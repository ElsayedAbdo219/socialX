<?php
namespace App\Enum;

class PaymentStatusEnum 
{
    public const PAID = 'paid';
    public const UNPAID = 'unpaid';

    public static function toArray(): array
    {
        return [
            self::PAID => self::PAID,
            self::UNPAID => self::UNPAID,
        ];
    }
}