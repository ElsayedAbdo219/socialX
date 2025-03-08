<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Payment;
use App\Models\Setting;
use App\Models\GoodType;
use App\Models\Complain;
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
        $aboutApp= collect(Setting::where('key','about-app')->get())->toArray();
        $ourVision= collect(Setting::where('key','our-vision')->get())->toArray();
        $anceegaForSeekers = collect(Setting::where('key','why-choose-anceega-for-seekers')->get())->toArray();
        $anceegaForBusinessAndFreelancers = collect(Setting::where('key','why-choose-anceega-for-business-and-freelancers')->get())->toArray();
        $keyFeatures = collect(Setting::where('key','key-features')->get())->toArray();

        $data['status'] = 200;
        // return $data ;
        return $this->respondWithArray([
            'aboutApp' => $aboutApp,
            'ourVision' => $ourVision,
            'anceegaForSeekers' => $anceegaForSeekers,
            'anceegaForBusinessAndFreelancers' => $anceegaForBusinessAndFreelancers,
            'keyFeatures' => $keyFeatures,
        ]);
    }

    public function termsAndConditions() 
    {
        $termsAndConditions = collect(Setting::where('key','terms-and-conditions')->get())->toArray();
        $userResponsibilities = collect(Setting::where('key','user-responsibilities')->get())->toArray();
        $companyResponsibilities = collect(Setting::where('key','company-responsibilities')->get())->toArray();
        $platformUsage= collect(Setting::where('key','platform-usage')->get())->toArray();
        $accountSuspensionPolicy= collect(Setting::where('key','account-suspension-policy')->get())->toArray();

        $data['status'] = 200;
        return $this->respondWithArray([
            'termsAndConditions' => $termsAndConditions,
            'userResponsibilities' => $userResponsibilities,
            'companyResponsibilities' => $companyResponsibilities,
            'platformUsage' => $platformUsage,
            'accountSuspensionPolicy' => $accountSuspensionPolicy,
        ]);
    }

    public function privacyPolicy(): JsonResponse
    {
        $appPrivacy = collect(Setting::where('key','app-privacy')->get())->toArray();
        $informationCollect = collect(Setting::where('key','information-collect')->get())->toArray();
        $yourRights= collect(Setting::where('key','your-rights')->get())->toArray();
        $howUseData = collect(Setting::where('key','how-use-data')->get())->toArray();
        $data['status'] = 200;
        return $this->respondWithArray([
            'appPrivacy' => $appPrivacy,
            'informationCollect' => $informationCollect,
            'yourRights' => $yourRights,
            'howUseData' => $howUseData,
        ]);
    }

     public function helpShape(): JsonResponse
    {
        $helpShape = collect(Setting::where('key','Help-Shape-Anceega')->get())->toArray();
        $customSuggestions = collect(Setting::where('key','custom-suggestions')->get())->toArray();
        $data['status'] = 200;
        return $this->respondWithArray([
            'helpShape' => $helpShape,
            'customSuggestions' => $customSuggestions,
        ]);
    }
   /*  "whyAdvertiseWithAnceega": [
        {
            "id": 20,
            "key": "why-advertise-withAnceega",
            "name": "why-advertise-withAnceega",
            "value": {
                "ar": [
                    "ميزة 1",
                    "ميزة 2"
                ],
                "en": [
                    "Feature 1",
                    "Feature 2"
                ],
                "imagePath": "6686f8d22b68f_3d ثيسؤ - Copy.jpg"
            },
            "created_at": "2025-03-08T17:31:00.000000Z",
            "updated_at": "2025-03-08T17:31:00.000000Z"
        }
    ], */
    public function ads(): JsonResponse
    {
        $advertiseAnceega = collect(Setting::where('key','advertise-Anceega')->get())->toArray();
        $whyAdvertiseWithAnceega = collect(Setting::where('key','why-advertise-withAnceega')->get())->toArray();
        $whyAdvertiseWithAnceega['imagePathValue'] = asset('storage/whyAdvertise-Anceega/'.$whyAdvertiseWithAnceega[0]['value']['imagePath']);   
        
        $howAdvertiseWorkforCompanies = collect(Setting::where('key','how-advertise-work-for-companies')->get())->toArray();
        $howAdvertiseWorkforCompanies['videoPathValue'] = asset('storage/AdvertiseForCompaniesAnceega/'.$howAdvertiseWorkforCompanies[0]['value']['videoPath']);   
        
        $howAdvertiseWorkforUsers = collect(Setting::where('key','how-advertise-work-for-users')->get())->toArray();
        $howAdvertiseWorkforUsers['videoPathValue'] = asset('storage/AdvertiseForUsersAnceega/'.$howAdvertiseWorkforUsers[0]['value']['videoPath']);   


        $data['status'] = 200;
        return $this->respondWithArray([
            'advertiseAnceega' => $advertiseAnceega,
            'whyAdvertiseWithAnceega' => $whyAdvertiseWithAnceega,
            'howAdvertiseWorkforCompanies' => $howAdvertiseWorkforCompanies,
            'howAdvertiseWorkforUsers' => $howAdvertiseWorkforUsers,
        ]);
    }

    public function help(): JsonResponse
    {
        $helpSupport = collect(Setting::where('key','help-support')->get())->toArray();
        $issues = collect(Complain::limit(5)->get())->toArray();
        $data['status'] = 200;
        return $this->respondWithArray([
            'helpSupport' => $helpSupport,
            'issues' => $issues,
        ]);
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
