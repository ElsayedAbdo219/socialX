<?php

namespace App\Enum;


enum RegisterationRequestEnum: string
{
    public const ACTIVE = 1;
    public const DISACTIVE = 0;

    public static function toArray()
    {
        return [
            self::ACTIVE => __("dashboard.active"),
            self::DISACTIVE => __("dashboard.disactive"),
        ];
    }
}
