<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->truncate();

        $values = [
            [
                'app-contacts' => [
                    'phones' => ['0521215212', '05212012012', '0524512623'],
                    'watsApp' => '0512325626',
                    'facebook' => 'https://www.facebook.com/',
                    'instagram' => 'https://www.instagram.com/',
                    'snapchat' => 'https://www.snapchat.com/',
                ],
                'about-app' => [
                    'ar' => 'عن التطبيق',
                    'en' => 'about application',
                ],
                'terms-and-conditions' => [
                    'ar' => 'الشروط والأحكام',
                    'en' => 'terms and conditions',
                ],
                'app-privacy' => [
                    'ar' => 'سياسة الخصوصية',
                    'en' => 'application privacy',
                ],
                'our-vision' => [
                    'ar' => ' رؤيتنا',
                    'en' => 'our-vision',
                ],
                'why-choose-anceega-for-seekers' => [
                    'ar' => ['ميزة 1', 'ميزة 2'],
                    'en' => ['meezq1', 'meeza2'],
                ],
                 'why-choose-anceega-for-business-and-freelancers' => [
                    'ar' => ['ميزة 1', 'ميزة 2'],
                    'en' => ['meezq1', 'meeza2'],
                ],
                 'key-features' => [
                    'ar' => ['مفتاح 1', 'مفتاح 2'],
                    'en' => ['key 12 ', 'kry 2'],
                ],
                'user-responsibilities' => [
                    'ar' => ['مفتابلابلاح 1', 'بلاب 2'],
                    'en' => ['kdfgfdgdey 12 ', 'kryxdfgdrtg 2'],
                ],
                 'company-responsibilities' => [
                    'ar' => ['مفتابلابلاح 1', 'بلاب 2'],
                    'en' => ['kdfgfdgdey 12 ', 'kryxdfgdrtg 2'],
                ],
                'platform-usage' => [
                    'ar' => 'استخدام المنصة',
                    'en' => 'platform-usage',
                ],

                'account-suspension-policy' => [
                    'ar' => 'استخدام الاكونت',
                    'en' => 'account-suspension-policy',
                ],

                'Help-Shape-Anceega' => [
                    'ar' => 'المساعدة في تشكيل عن ثقة',
                    'en' => 'Help-Shape-Anceega',
                ],

                'custom-suggestions' => [
                    'ar' => ['مفتابلابلاح 1', 'بلاب 2'],
                    'en' => ['kdfgfdgdey 12 ', 'kryxdfgdrtg 2'],
                ],

                 'your-rights' => [
                    'ar' => ['مفتابلابلاح 1', 'بلاب 2'],
                    'en' => ['kdfgfdgdey 12 ', 'kryxdfgdrtg 2'],
                ],

                 'information-collect' => [
                    'ar' => ['مفتابلابلاح 1', 'بلاب 2'],
                    'en' => ['kdfgfdgdey 12 ', 'kryxdfgdrtg 2'],
                ],

                 'how-use-data' => [
                    'ar' => 'المساعدة في تشكيل عن ثقة',
                    'en' => 'Help-Shape-Anceega',
                ],

                'help-support' => [
                    'ar' => 'المساعدة في تشكيل عن ثقة',
                    'en' => 'Help-Shape-Anceega',
                ],
                'advertise-Anceega' => [
                    'ar' => 'المساعدة في تشكيل عن ثقة',
                    'en' => 'Help-Shape-Anceega',
                ],

                'why-advertise-withAnceega' => [
                    'ar' => ['ميزة 1', 'ميزة 2'],
                    'en' => ['Feature 1', 'Feature 2'],
                    'imagePath' => Storage::url('posts/6686f8d22b68f_3d ثيسؤ - Copy.jpg')
                ],
                
                'how-advertise-work-for-companies' => [
                    'ar' => 'المساعدة في تشكيل عن ثقة',
                    'en' => 'Help shape Anceega with confidence',
                    'videoPath' => Storage::url('posts/669bd50447475_٢٠٢٣-٠٨-١٢ at ١٤-٢٠-٥٣.mp4')
                ],
                
                'how-advertise-work-for-users' => [
                    'ar' => 'المساعدة في تشكيل عن ثقة',
                    'en' => 'Help shape Anceega with confidence',
                    'videoPath' => Storage::url('posts/669bd50447475_٢٠٢٣-٠٨-١٢ at ١٤-٢٠-٥٣.mp4')
                ],
                























                
                'general' => [

                ]
            ],
        ];

        foreach ($values as $item) {
            foreach ($item as $key => $value) {
                Setting::create([
                    'key' => $key,
                    'name' => $key,
                    'value' => $value
                ]);
            }
        }
    }
}
