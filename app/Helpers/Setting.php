<?php

namespace App\Helpers;

use App\Models\Setting as SettingModel;
use Illuminate\Support\Facades\Cache;

class Setting
{
    public const CACHE_KEY = 'settings';
    protected $settings;

    public function __construct()
    {
//        if (Cache::has(self::CACHE_KEY)) {
//            $this->settings = Cache::get(self::CACHE_KEY);
//        } else {
            $this->settings = SettingModel::all();
//            Cache::add(self::CACHE_KEY, $this->settings);
//        }
    }

    public function __get($key)
    {
        $setting = $this->settings->filter(function ($setting) use ($key) {
            return $setting->key === $key;
        })->first()->value ?? null;

        return (object) $setting;
    }
}
