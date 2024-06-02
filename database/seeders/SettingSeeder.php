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
