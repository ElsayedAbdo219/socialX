<?php

namespace App\Enum\Chat;

use App\Traits\EnumHelpers;

enum ChatTypeEnum: string
{
    use EnumHelpers;
    case USER_DRIVER = 'user_driver';
    case PROVIDER_USER = 'provider_user';
    case PROVIDER_DRIVER = 'provider_driver';

    protected static function labels()
    {
        return [
            'user_driver' => __('user_driver'),
            'provider_user' => __('provider_user'),
            'provider_driver' => __('provider_driver'),
        ];
    }
}
