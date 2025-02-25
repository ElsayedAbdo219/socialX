<?php

namespace App\Enum;

enum UserTypeEnum: string
{
    public const EMPLOYEE = 'employee';
    public const COMPANY = 'company'; 

    public static function toArray() 
    {
        return [
            self::EMPLOYEE => "employee" ,
            self::COMPANY => "company", 
        ];
      
    }
}
