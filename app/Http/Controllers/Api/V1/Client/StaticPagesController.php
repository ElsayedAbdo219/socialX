<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Payment;
use App\Models\GoodType;
use App\Enum\UserTypeEnum;
use App\Enum\ContactUsTypesEnum;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Notifications\AdminNotification;
use App\Repositories\Contracts\UserContract;
use Illuminate\Support\Facades\Notification;
use App\Repositories\Contracts\ContactUsContract;
use App\Http\Requests\Api\V1\Client\ContactUsRequest;
use App\Http\Resources\Api\V1\Dashboard\PaymentResource;
use App\Http\Resources\Api\V1\Dashboard\ContactUsResource;

class StaticPagesController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected UserContract $userRepository)
    {
    }

    public function aboutApp(): JsonResponse
    {
        $data['data'] = collect(setting('about-app'))->toArray()[app()->getLocale()] ?? '';
        $data['status'] = 200;
        return $this->respondWithArray($data);
    }

    public function termsAndConditions(): JsonResponse
    {
        $data['data'] = collect(setting('terms-and-conditions'))->toArray()[app()->getLocale()] ?? '';
        $data['status'] = 200;
        return $this->respondWithArray($data);
    }

    public function privacyPolicy(): JsonResponse
    {
        $data['data'] = collect(setting('app-privacy'))->toArray()[app()->getLocale()] ?? '';
        $data['status'] = 200;
        return $this->respondWithArray($data);

    }

    public function contactUs(): JsonResponse
    {
        $data['data'] = collect(setting('app-contacts'))->toArray() ?? '';
        $data['contact-us-types'] = ContactUsTypesEnum::values();
        $data['status'] = 200;
        return $this->respondWithArray($data);
    }

    public function paymentsMethods(): JsonResponse
    {
        $data['data'] = PaymentResource::collection(Payment::where('is_active', true)->get());
        $data['status'] = 200;
        return $this->respondWithArray($data);
    }

    public function contactUsSubmit(ContactUsRequest $request)
    {
        $request->merge(['user_id' => auth('api')->id() ?? 0]);
        $contactUs = app(ContactUsContract::class)->create($request->all());

        # Send Notifications For Admins
        $notificationData = prepareNotification(
            title: 'messages.responses.contact_us',
            body: [
                'data' => ['ar' => __('messages.client :name send message :message', ['name' => $contactUs->name, 'message' => $contactUs->message], 'ar'),
                    'en' => __('messages.client :name send message :message', ['name' => $contactUs->name, 'message' => $contactUs->message], 'en')]]
        );

        $adminsAndEmployees = $this->userRepository->search(
            filters: ['type' => [UserTypeEnum::ADMIN, UserTypeEnum::EMPLOYEE], 'status' => true],
            page: 0,
            limit: 0
        );
        Notification::send($adminsAndEmployees, new AdminNotification($notificationData, ['database']));
        return $this->respondWithModelData(new ContactUsResource($contactUs));

    }


    public function index()
    {
        return GoodType::select('id', 'name')->get() ??null;
    }



}
