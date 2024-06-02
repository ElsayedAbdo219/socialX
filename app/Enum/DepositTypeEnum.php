<?php

namespace App\Enum;

use App\Traits\EnumToArray;

enum DepositTypeEnum: string
{
    use EnumToArray;
    case MY_ACCOUNT = 'my_account';
    case ANOTHER_ACCOUNT = 'another_account';
}
