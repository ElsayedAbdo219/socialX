<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
