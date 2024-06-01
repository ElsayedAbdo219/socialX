<?php

namespace App\Actions\Chats;

use App\Models\Chat;
use App\Models\User as ModelsUser;
use App\Models\User as ProvidersUser;
use App\Models\User as DriversUser;
use Illuminate\Foundation\Auth\User;

class GetChatsAction
{
    public function handle(User $loggedInUser)
    {
        return Chat::whereNotNull('last_message_id')
            ->where('driver_id', $this->getId($loggedInUser))
            ->get();
    }

    private function getKey(User $loggedInUser): string
    {
        return match ($loggedInUser::class) {
            DriversUser::class => 'driver_id',
            ModelsUser::class => 'user_id',
            ProvidersUser::class => 'provider_id',
        };
    }

    private function getId(User $user)
    {
        return match ($user::class) {
            # ProvidersUser::class => $user->provider_id, # Test If Provider In Same User Table
            default => $user->id,
        };
    }
}
