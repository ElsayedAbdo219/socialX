<?php

namespace App\Traits;

trait EnumHelpers
{
    public static function toValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toNames(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function translated(): array
    {
        $translatedEnums = [];
        foreach (self::cases() as $case) {
            $translatedEnums[] = [
                'name' => $case->value,
                'value' => __($case->value),
            ];
        }

        return $translatedEnums;
    }
}
