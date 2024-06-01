<?php

namespace App\Traits;

trait EnumToArray
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function translatedNames(): array
    {
        return collect(array_column(self::cases(), 'name'))->map(function ($name) {
            return __('messages.responses.'.$name);
        })->toArray();
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function translatedArray(): array
    {
        return array_combine(self::values(), self::translatedNames());
    }

    public static function implodedArray(): string
    {
        return implode(',', self::values());
    }

}
