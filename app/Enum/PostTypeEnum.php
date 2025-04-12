<?php

namespace App\Enum;

enum PostTypeEnum: string
{
    public const ADVERTISE = 'advertise';
    public const NORMAL = 'normal'; 

    public static function toArray() 
    {
        return [
            self::ADVERTISE => "advertise" ,
            self::NORMAL => "normal", 
        ];
      
    }
}
