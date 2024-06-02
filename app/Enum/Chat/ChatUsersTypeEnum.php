<?php

namespace App\Enum\Chat;

use App\Enum\UserTypeEnum;
use App\Models\User;
use App\Traits\EnumHelpers;
use App\Models\User as ModelsUser;
use App\Models\User as ProvidersUser;
use App\Models\User as DriversUser;

enum ChatUsersTypeEnum: string
{
    use EnumHelpers;

    case User = 'user';
    case Provider = 'provider';
    case Driver = 'driver';

    public static function model($type)
    {
        return [
            'user' => ModelsUser::class,
            'provider' => ProvidersUser::class,
            'driver' => DriversUser::class,
        ][$type];
    }

    public static function modelById($id)
    {
        $model = User::find($id);
        if ($model) {
            return match ($model->type) {
                UserTypeEnum::SUPPLIER => 'supplier',
                default => 'user',
            };
        }
        return 'undefined';
    }

    public static function model_value(string $model)
    {
        return [
            ModelsUser::class => 'user',
            ProvidersUser::class => 'provider',
            DriversUser::class => 'driver',
        ][$model];
    }

    protected static function labels()
    {
        return [
            'user' => __('user'),
            'provider' => __('provider'),
            'driver' => __('driver'),
        ];
    }
}
