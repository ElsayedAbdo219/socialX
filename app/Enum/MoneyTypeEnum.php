<?php

namespace App\Enum;

use App\Traits\EnumToArray;

enum MoneyTypeEnum: string
{
    use EnumToArray;
    case DEPOSIT = 'deposit';
    case SETTLEMENT = 'settlement';
    case REPAYMENT_CREDIT = 'repayment_credit';
    case REPAYMENT_DEBIT = 'repayment_debit';
}
