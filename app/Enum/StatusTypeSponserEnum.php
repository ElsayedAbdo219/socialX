<?php

namespace App\Enum;

class StatusTypeSponserEnum
{
    const PENDING = 'pending';
    const APPROVED = 'approved';


    public static function toArray(): array
    {
      return [
        self::PENDING => self::PENDING,
        self::APPROVED => self::APPROVED,
      ];
    }
}
