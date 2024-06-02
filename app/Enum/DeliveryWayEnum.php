<?php

namespace App\Enum;


enum DeliveryWayEnum: string
{
    public const WASSAL = 'wassal';
    public const ONSITE = 'on_site';

    public static function toArray()
    {
        return [
            self::WASSAL => 'wassal',
            self::ONSITE => 'on_site',
        ];
    }
}
