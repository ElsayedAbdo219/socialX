<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Payment;
use App\Models\Setting;
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
use App\Http\Resources\Api\V1\Client\GoodTypeResource;
use App\Http\Resources\Api\V1\Dashboard\PaymentResource;
use App\Http\Resources\Api\V1\Dashboard\ContactUsResource;
use App\Http\Resources\Api\V1\Client\DrawerTonGoodTypeResource;

class StaticPagesController extends Controller
{
    use ApiResponseTrait;

   /*  public function __construct(protected UserContract $userRepository)
    {
    } */

    public function aboutApp()
    {
        // return Setting::where('key','about-app')->get() ; 
        $data['data'] = collect(Setting::where('key','about-app')->get())->toArray();
        $data['status'] = 200;
        // return $data ;
        return $this->respondWithArray($data);
    }

    public function termsAndConditions() 
    {
        // return Setting::where('key','terms-and-conditions')->get() ; 
        // return Setting::where('key','terms-and-conditions')->get() ; 
        $data['data'] = collect(Setting::where('key','terms-and-conditions')->get())->toArray();
        $data['status'] = 200;
        return $this->respondWithArray($data);
    }

    public function privacyPolicy(): JsonResponse
    {
        $data['data'] = collect(Setting::where('key','app-privacy')->get())->toArray();
        $data['status'] = 200;
        return $this->respondWithArray($data);
    }

    public function contactUs(): JsonResponse
    {
        $data['data'] = collect(Setting::where('key','app-contacts')->get())->toArray() ?? '';
        // $data['contact-us-types'] = ContactUsTypesEnum::values();
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
       
        Notification::send($adminsAndEmployees, new AdminNotification($notificationData, ['database']));
        return $this->respondWithModelData(new ContactUsResource($contactUs));
    }


   
}
