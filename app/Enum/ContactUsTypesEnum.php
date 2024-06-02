<?php

namespace App\Enum;

use App\Traits\EnumToArray;

enum ContactUsTypesEnum: string
{
    use EnumToArray;
    case REQUEST = 'request';
    case SUGGESTION = 'suggestion';
    case INQUIRY = 'inquiry';
    case COMPLAINT = 'complaint';
    case ANOTHER = 'another';
}
