<?php

namespace App\Enum;

use App\Traits\EnumToArray;

enum PaymentTypeEnum: string
{
    
    public const CASH = 'cash';
    public const INSTALLMENT = 'installment';
    public const CHECKINGACCOUNT = 'checking_account'; //حساب جاري
    public static function toArray()
    {
    return [
        self::CASH => 'cash',
        self::INSTALLMENT => 'installment',
        self::CHECKINGACCOUNT => 'checking_account',
    ];

}

}