<?php

namespace App\Actions\Chats;

use App\Enum\Chat\ChatTypeEnum;
use App\Models\Chat;
use App\Models\Order;
use App\Models\Trip;
use App\Models\User as ModelsUser;
use App\Models\User as ProvidersUser;
use App\Models\User as DriversUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class GetChatAction
{
    # $model is the Order Model
    public function handle(Trip $model, User $loggedInUser, string $type)
    {
        if ($type === 'user_driver') {
            return Chat::firstOrCreate([
                'user_id' => $model->user_id,
                'driver_id' => $model->driver_id,
                'order_id' => $model->id,
                'type' => $type,
            ]);
        }

        if ($type === 'provider_user') {
            return Chat::firstOrCreate([
                'user_id' => $model->user_id,
                'provider_id' => $model->provider_id,
                'order_id' => $model->id,
                'type' => $type,
            ]);
        }

        if ($type === 'provider_driver') {
            return Chat::firstOrCreate([
                'provider_id' => $model->provider_id,
                'driver_id' => $model->driver_id,
                'order_id' => $model->id,
                'type' => $type,
            ]);
        }
    }

    private function getChatType(User $loggedInUser, User $toUser)
    {
        if (
            ($loggedInUser instanceof DriversUser && $toUser instanceof ModelsUser)
            || ($toUser instanceof DriversUser && $loggedInUser instanceof ModelsUser)
        ) {
            return ChatTypeEnum::USER_DRIVER->value;
        }

        if (
            ($loggedInUser instanceof ProvidersUser && $toUser instanceof ModelsUser)
            || ($toUser instanceof ProvidersUser && $loggedInUser instanceof ModelsUser)
        ) {
            return ChatTypeEnum::PROVIDER_USER->value;
        }

        if (
            ($loggedInUser instanceof DriversUser && $toUser instanceof ProvidersUser)
            || ($toUser instanceof DriversUser && $loggedInUser instanceof ProvidersUser)
        ) {
            return ChatTypeEnum::PROVIDER_DRIVER->value;
        }

        throw new \Exception('undefiended chat type');
    }
}
