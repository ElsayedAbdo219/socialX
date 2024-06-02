<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\UpdateSettingsRequest;

class SettingController extends Controller
{
    public function index()
    {

        $page = isset($_GET['page']) ? $_GET['page'] : '';
        if (empty($page)) {
            $page = 'terms';
        }
        $settings = Setting::all();
        return view('dashboard.settings.list', compact('settings', 'page'));
    }

    public function update(Request $request, Setting $setting)
    {

        if ($setting->key == 'terms-and-conditions') {
            $settingRequest = $request->validate([
                'contentTerms' => ['required', 'string', 'max:500'],
            ]);

            $setting->update([
                "value" => [
                    "ar" => $settingRequest['contentTerms'],
                    "en" => $settingRequest['contentTerms'],
                ]
            ]);

            return redirect()->route('admin.settings.index', ['page' => 'terms'])
                ->with(['success' => __('dashboard.terms-and-conditions updated successfully')]);
        }


        if ($setting->key === 'about-app') {

            $settingRequest = $request->validate([
                'contentAbout' => ['required', 'string', 'max:500'],
            ]);

            $setting->update([
                "value" => [
                    "ar" =>  $settingRequest['contentAbout'],
                    "en" => $settingRequest['contentAbout'],
                ]
            ]);

            return redirect()->route('admin.settings.index', ['page' => 'about'])
                ->with(['success' => __('dashboard.about app updated successfully')]);
        }

        if ($setting->key == 'app-privacy') {
            $settingRequest = $request->validate([
                'content' => ['required', 'string'],
            ]);

            $setting->update([
                "value" => [
                    "ar" => $settingRequest['content'],
                    "en" => $settingRequest['content'],
                ]
            ]);

            return redirect()->route('admin.settings.index', ['page' => 'privacy'])
                ->with(['success' => __('dashboard.app-privacy updated successfully')]);
        }




        $validatedData = $request->validate([
            'number.*' => ['required', 'string', 'min:7', 'max:15'],
            'watsApp' => ['required', 'string', 'min:7', 'max:15'],
            'facebook' => ['required', 'string', 'url'],
            'snapchat' => ['required', 'string', 'url'],
            'instagram' => ['required', 'string', 'url'],
        ]);

        if ($setting->key == 'app-contacts') {
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
        }
    }
}
