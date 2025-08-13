<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\UpdateSettingsRequest;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
  public function index()
  {

    $page = isset($_GET['page']) ? $_GET['page'] : '';
    if (empty($page)) {
      $page = 'terms';
    }
    $settings = Setting::all();
    // dd($settings) ;
    return view('dashboard.settings.list', compact('settings', 'page'));
  }

  public function update(Request $request, Setting $setting)
  {
    // dd($request);

    if ($setting->key == 'terms-and-conditions') {
      $settingRequest = $request->validate([
        'contentTerms' => ['required', 'string', 'max:500'],
      ]);

      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => strip_tags($settingRequest['contentTerms']),
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => strip_tags($settingRequest['contentTerms']),
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'terms'])
        ->with(['success' => __('dashboard.terms-and-conditions updated successfully')]);
    } elseif ($setting->key === 'about-app') {

      $settingRequest = $request->validate([
        'contentAbout' => ['required', 'string', 'max:500'],
      ]);
      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => strip_tags($settingRequest['contentAbout']),
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => strip_tags($settingRequest['contentAbout']),
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'about'])
        ->with(['success' => __('dashboard.about app updated successfully')]);
    } elseif ($setting->key == 'app-privacy') {
      $settingRequest = $request->validate([
        'content' => ['required', 'string'],
      ]);

      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => strip_tags($settingRequest['content']),
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => strip_tags($settingRequest['content']),
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'privacy'])
        ->with(['success' => __('dashboard.app-privacy updated successfully')]);
    } elseif ($setting->key == 'app-contacts') {
      $validatedData = $request->validate([
        'number.*' => ['required', 'string', 'min:7', 'max:15'],
        'watsApp' => ['required', 'string', 'min:7', 'max:15'],
        'facebook' => ['required', 'string', 'url'],
        'snapchat' => ['required', 'string', 'url'],
        'instagram' => ['required', 'string', 'url'],
      ]);

      $phones = [];
      foreach ($validatedData['number'] as $number) {
        $phones[] = $number;
      }

      $setting->update([
        "value" => [
          'phones' => $phones,
          'watsApp' => $validatedData['watsApp'],
          'facebook' => $validatedData['facebook'],
          'snapchat' => $validatedData['snapchat'],
          'instagram' => $validatedData['instagram'],
        ]
      ]);

      return redirect()->route('admin.settings.index', ['page' => 'contact'])
        ->with(['success' => __('dashboard.contact updated successfully')]);
    } elseif ($setting->key === 'our-vision') {
        // dd($request) ;     
      // return "dfgdfg";

      $settingRequest = $request->validate([
        'content' => ['required', 'string', 'max:500'],
      ]);
      if($request->language  ==  'ar')
      {
        $setting->update([
        "value" => [
          "ar" => strip_tags($settingRequest['content']),
          "en" => $setting->value['en'] ?? '', 
        ]
      ]);
      }else{
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '', 
            "en" => strip_tags($settingRequest['content']),
          ]
        ]);
      }

    

      return redirect()->route('admin.settings.index', ['page' => 'our-vision'])
        ->with(['success' => __('dashboard.our-vision updated successfully')]);
    } elseif ($setting->key === 'why-choose-anceega-for-seekers') {
      // dd($request);
      $settingRequest = $request->validate([
        'items1' => ['required', 'array'],
        'items1.*.contentSeekers' => ['required', 'string'],
      ]);
      // استخراج القيم النصية فقط
      $contentSeekers = collect($settingRequest['items1'])->pluck('contentSeekers')->toArray();
      // تحديث القيمة كـ JSON
       if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => $contentSeekers, // نفس القيم لكلا اللغتين
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => $contentSeekers,
          ]
        ]);
      }
      return redirect()->route('admin.settings.index', ['page' => 'why-choose-anceega-for-seekers'])
        ->with(['success' => __('dashboard.why-choose-anceega-for-seekers updated successfully')]);
    } 
    elseif ($setting->key === 'why-choose-anceega-for-business-and-freelancers') {
      // dd($request);
      $settingRequest = $request->validate([
        'items2' => ['required', 'array'],
        'items2.*.contentFreelanceAndBusiness' => ['required', 'string'],
      ]);
      // استخراج القيم النصية فقط
      $contentFreelanceAndBusiness = collect($settingRequest['items2'])->pluck('contentFreelanceAndBusiness')->toArray();
      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => $contentFreelanceAndBusiness, // نفس القيم لكلا اللغتين
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => $contentFreelanceAndBusiness,
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'why-choose-anceega-for-business-and-freelancers'])
        ->with(['success' => __('dashboard.why-choose-anceega-for-business-and-freelancers updated successfully')]);
    } elseif ($setting->key === 'key-features') {
      // dd($request);
      $settingRequest = $request->validate([
        'items3' => ['required', 'array'],
        'items3.*.contentKeyFeatures' => ['required', 'string'],
      ]);
      // استخراج القيم النصية فقط
      $contentKeyFeatures = collect($settingRequest['items3'])->pluck('contentKeyFeatures')->toArray();
      // تحديث القيمة كـ JSON
      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => $contentKeyFeatures, // نفس القيم لكلا اللغتين
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => $contentKeyFeatures,
          ]
        ]);
      }
      return redirect()->route('admin.settings.index', ['page' => 'key-features'])
        ->with(['success' => __('dashboard.contentKeyFeatures updated successfully')]);
    } elseif ($setting->key === 'user-responsibilities') {
      // dd($request);
      $settingRequest = $request->validate([
        'items4' => ['required', 'array'],
        'items4.*.contentUserResponsibilities' => ['required', 'string'],
      ]);
      // استخراج القيم النصية فقط
      $contentUserResponsibilities = collect($settingRequest['items4'])->pluck('contentUserResponsibilities')->toArray();
     if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => $contentUserResponsibilities, // نفس القيم لكلا اللغتين
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => $contentUserResponsibilities,
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'user-responsibilities'])
        ->with(['success' => __('dashboard.user-responsibilities updated successfully')]);
    } elseif ($setting->key === 'company-responsibilities') {
      // dd($request);
      $settingRequest = $request->validate([
        'items5' => ['required', 'array'],
        'items5.*.contentCompanyResponsibilities' => ['required', 'string'],
      ]);
      // استخراج القيم النصية فقط
      $contentCompanyResponsibilities = collect($settingRequest['items5'])->pluck('contentCompanyResponsibilities')->toArray();
      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => $contentCompanyResponsibilities, // نفس القيم لكلا اللغتين
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => $contentCompanyResponsibilities,
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'company-responsibilities'])
        ->with(['success' => __('dashboard.contentCompanyResponsibilities updated successfully')]);
    } elseif ($setting->key === 'platform-usage') {
      //   dd($request) ;     
      // return "dfgdfg";

      $settingRequest = $request->validate([
        'contentPlatformUsage' => ['required', 'string', 'max:500'],
      ]);

      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => strip_tags($settingRequest['contentPlatformUsage']),
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => strip_tags($settingRequest['contentPlatformUsage']),
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'platform-usage'])
        ->with(['success' => __('dashboard.platform-usage updated successfully')]);
    } elseif ($setting->key === 'account-suspension-policy') {
      //   dd($request) ;     
      // return "dfgdfg";

      $settingRequest = $request->validate([
        'contentAccountSuspensionPolicy' => ['required', 'string', 'max:500'],
      ]);

      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => strip_tags($settingRequest['contentAccountSuspensionPolicy']),
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => strip_tags($settingRequest['contentAccountSuspensionPolicy']),
          ]
        ]);
      } 

      return redirect()->route('admin.settings.index', ['page' => 'account-suspension-policy'])
        ->with(['success' => __('dashboard.account-suspension-policy updated successfully')]);
    } elseif ($setting->key === 'Help-Shape-Anceega') {
      //   dd($request) ;     
      // return "dfgdfg";

      $settingRequest = $request->validate([
        'contentHelpShapeAnceega' => ['required', 'string', 'max:500'],
      ]);

      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => strip_tags($settingRequest['contentHelpShapeAnceega']),
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => strip_tags($settingRequest['contentHelpShapeAnceega']),
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'Help-Shape-Anceega'])
        ->with(['success' => __('dashboard.Help-Shape-Anceega updated successfully')]);
    } elseif ($setting->key === 'custom-suggestions') {
      //  dd($request);
      $settingRequest = $request->validate([
        'items6' => ['required', 'array'],
        'items6.*.contentCustomSuggestions' => ['required', 'string'],
      ]);
      // استخراج القيم النصية فقط
      $contentCustomSuggestions = collect($settingRequest['items6'])->pluck('contentCustomSuggestions')->toArray();
      // تحديث القيمة كـ JSON
      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => $contentCustomSuggestions, // نفس القيم لكلا اللغتين
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => $contentCustomSuggestions,
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'custom-suggestions'])
        ->with(['success' => __('dashboard.custom-suggestions updated successfully')]);
    } elseif ($setting->key === 'your-rights') {
      // dd($request);
      $settingRequest = $request->validate([
        'items7' => ['required', 'array'],
        'items7.*.contentYourRights' => ['required', 'string'],
      ]);
      // استخراج القيم النصية فقط
      $contentYourRights = collect($settingRequest['items7'])->pluck('contentYourRights')->toArray();
      // تحديث القيمة كـ JSON
      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => $contentYourRights, // نفس القيم لكلا اللغتين
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => $contentYourRights,
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'your-rights'])
        ->with(['success' => __('dashboard.your-rights updated successfully')]);
    } elseif ($setting->key === 'information-collect') {
      // dd($request);
      $settingRequest = $request->validate([
        'items8' => ['required', 'array'],
        'items8.*.contentInformationCollect' => ['required', 'string'],
      ]);
      // استخراج القيم النصية فقط
      $contentInformationCollect = collect($settingRequest['items8'])->pluck('contentInformationCollect')->toArray();
      // تحديث القيمة كـ JSON
      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => $contentInformationCollect, // نفس القيم لكلا اللغتين
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => $contentInformationCollect,
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'information-collect'])
        ->with(['success' => __('dashboard.information-collect updated successfully')]);
    } elseif ($setting->key === 'how-use-data') {
      //   dd($request) ;     
      // return "dfgdfg";

      $settingRequest = $request->validate([
        'contentHowUseData' => ['required', 'string', 'max:500'],
      ]);

      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => strip_tags($settingRequest['contentHowUseData']),
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => strip_tags($settingRequest['contentHowUseData']),
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'how-use-data'])
        ->with(['success' => __('dashboard.how-use-data updated successfully')]);
    } elseif ($setting->key === 'help-support') {
      //   dd($request) ;     
      // return "dfgdfg";

      $settingRequest = $request->validate([
        'contentHelpAndSupport' => ['required', 'string', 'max:500'],
      ]);

      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => strip_tags($settingRequest['contentHelpAndSupport']),
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => strip_tags($settingRequest['contentHelpAndSupport']),
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'help-support'])
        ->with(['success' => __('dashboard.help-support updated successfully')]);
    } elseif ($setting->key === 'advertise-Anceega') {
      //   dd($request) ;     
      // return "dfgdfg";

      $settingRequest = $request->validate([
        'contentAdvertiseAnceega' => ['required', 'string', 'max:500'],
      ]);

      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => strip_tags($settingRequest['contentAdvertiseAnceega']),
            "en" => $setting->value['en'] ?? '',
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => strip_tags($settingRequest['contentAdvertiseAnceega']),
          ]
        ]);
      }

      return redirect()->route('admin.settings.index', ['page' => 'advertise-Anceega'])
        ->with(['success' => __('dashboard.advertise-Anceega updated successfully')]);
    } elseif ($setting->key === 'why-advertise-withAnceega') {
      // dd($request);
      $settingRequest = $request->validate([
        'items9' => ['required', 'array'],
        'items9.*.contentWhyAdvertiseWithUs' => ['required', 'string'],
        'imageWhyAdvertise' => ['nullable', 'array'],
        'imageWhyAdvertise.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif']
      ]);
      // dd($request);

      // استخراج القيم النصية فقط
      $contentWhyAdvertiseWithUs = collect($settingRequest['items9'])->pluck('contentWhyAdvertiseWithUs')->toArray();

      // حفظ الصورة في public storage
      $images = [];
      foreach ($settingRequest['imageWhyAdvertise'] ?? [] as  $imageWhyAdvertise) {
        $images[] = basename(Storage::disk('public')->put('whyAdvertise-Anceega', $imageWhyAdvertise));
      }
      // dd($images);
      // تحديث القيمة كـ JSON
      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => $contentWhyAdvertiseWithUs, // نفس القيم لكلا اللغتين
            "en" => $setting->value['en'] ?? '',
            'imagePath' => !empty($images) ? $images : ($setting->value['imagePath'] ?? [])
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => $contentWhyAdvertiseWithUs,
            'imagePath' => !empty($images) ? $images : ($setting->value['imagePath'] ?? [])
          ]
        ]);
      }


      return redirect()->route('admin.settings.index', ['page' => 'why-advertise-withAnceega'])
        ->with(['success' => __('dashboard.why-advertise-withAnceega updated successfully')]);
    } elseif ($setting->key === 'how-advertise-work-for-companies') {

      // dd($request) ; 

      $settingRequest = $request->validate([
        'contentAdvertiseForCompanies' => ['required', 'string'],
        'videoAdvertiseForCompanies' => ['nullable', 'array'], // 20MB
        'videoAdvertiseForCompanies.*' => ['nullable', 'file', 'mimes:mp4,mov,avi,wmv,mkv,flv', 'max:20480'] // 20MB
      ]);
      // dd($settingRequest) ;
      // حفظ الصورة في public storage
      $videos = [];
      foreach ($settingRequest['videoAdvertiseForCompanies'] ?? [] as  $videoWhyAdvertise) {
        $videos[] = basename(Storage::disk('public')->put('AdvertiseForCompaniesAnceega', $videoWhyAdvertise));
      }
      // dd($request) ; 

    if($request->language  ==  'ar') {
      $setting->update([
        "value" => [
          "ar" =>  strip_tags($settingRequest['contentAdvertiseForCompanies']),
          "en" => $setting->value['en'] ?? '',
          'videoPath' => !empty($videos) ? $videos : ($setting->value['videoPath'] ?? [])
        ]
      ]);
    } else {
      $setting->update([
        "value" => [
          "ar" => $setting->value['ar'] ?? '',
          "en" => strip_tags($settingRequest['contentAdvertiseForCompanies']),
          'videoPath' => !empty($videos) ? $videos : ($setting->value['videoPath'] ?? [])
        ]
      ]);
    }

      return redirect()->route('admin.settings.index', ['page' => 'how-advertise-work-for-companies'])
        ->with(['success' => __('dashboard.how-advertise-work-for-companies  updated successfully')]);
    } elseif ($setting->key === 'how-advertise-work-for-users') {
      //  dd($request) ;     
      // return "dfgdfg";

      $settingRequest = $request->validate([
        'contentAdvertiseForUsers' => ['required', 'string'],
        'videoAdvertiseForUsers' => ['nullable', 'array'], // 20MB
        'videoAdvertiseForUsers.*' => ['nullable', 'file', 'mimes:mp4,mov,avi,wmv,mkv,flv', 'max:20480'] // 20MB
      ]);
      //  dd($request) ;   
      $videos = [];
      foreach ($settingRequest['videoAdvertiseForUsers'] ?? [] as  $videoWhyAdvertise) {
        $videos[] = basename(Storage::disk('public')->put('AdvertiseForUsers-Anceega', $videoWhyAdvertise));
      }

      if($request->language  ==  'ar') {
        $setting->update([
          "value" => [
            "ar" => strip_tags($settingRequest['contentAdvertiseForUsers']),
            "en" => $setting->value['en'] ?? '',
            'videoPath' => !empty($videos) ? $videos : ($setting->value['videoPath'] ?? [])
          ]
        ]);
      } else {
        $setting->update([
          "value" => [
            "ar" => $setting->value['ar'] ?? '',
            "en" => strip_tags($settingRequest['contentAdvertiseForUsers']),
            'videoPath' => !empty($videos) ? $videos : ($setting->value['videoPath'] ?? [])
          ]
        ]);
      }
      return redirect()->route('admin.settings.index', ['page' => 'how-advertise-work-for-users'])
        ->with(['success' => __('dashboard.how-advertise-work-for-users updated successfully')]);
    }
  }
}
