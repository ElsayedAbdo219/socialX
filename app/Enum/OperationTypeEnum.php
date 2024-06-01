<?php

namespace App\Enum;

use App\Traits\EnumToArray;

enum OperationTypeEnum: string
{
    
    public const WHOLE = 'whole';
    public const SECTORAL = 'sectoral';

    public static function toArray()
    {
    return [
        self::WHOLE => 'whole',
        self::SECTORAL => 'sectoral',
    ];

}

}