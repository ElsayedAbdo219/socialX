<?php

namespace App\Services;

use App\Enum\UserTypeEnum;
use App\Models\DeviceToken;
use Carbon\Carbon;

class SendFCM
{
    public bool $shouldSendForAdmin = false;
    public bool $shouldSendForUsers = false;

    public function __construct()
    {
    }

    public function setLocale($locale = null): string
    {
        return $locale ?? app()->getLocale();
    }

    public function sendForAdmin(bool $shouldSendForAdmin = false)
    {
        $this->shouldSendForAdmin = $shouldSendForAdmin;
        return $this;
    }

    public function sendForUsers(bool $shouldSendForUsers = false)
    {
        $this->shouldSendForUsers = $shouldSendForUsers;
        return $this;
    }

    # Registration Id
    public function registrationIds($fcmTokens = []): array
    {
        if ($fcmTokens) {
            $tokens[] = $fcmTokens;
        }

        if ($this->shouldSendForAdmin) {
            $tokens[] = DeviceToken::query()->whereHas('tokenable', function ($q) {
                $q->whereHas('roles', function ($q) {
                    $q->whereIn("name", ["admin"]);
                })
                    ->orWhereIn("type", [UserTypeEnum::EMPLOYEE, UserTypeEnum::ADMIN]);
            })->pluck('device_token')->toArray();
        }

        if ($this->shouldSendForUsers) {
            $tokens[] = DeviceToken::query()->whereHas('tokenable', function ($q) {
                $q->whereDoesntHave('roles')
                    ->orWhere("type", UserTypeEnum::EMPLOYEE);
            })->pluck('device_token')->toArray();
        }

        return $tokens ?? [];
    }

    # Notification Action
    # Ex >> ['home_screen' => true]
    public function withAction(array $action): array
    {
        return $action;
    }

    public function sendNotification($title, $body, $anotherData = [], $notifiable = null): void
    {
        
        $payload = [
            'title' => $title ?? '',
            'body' => $body ?? '',
            'anotherData' => $anotherData ?? [],
            'created_at' => (string)Carbon::now(),
        ];

        if ($notifiable) {
            $fcmTokens = $notifiable->deviceTokens?->pluck('device_token')->toArray();
        }

        $data = [
            'registration_ids' => collect($this->registrationIds($fcmTokens ?? []))->flatten()->unique()->toArray(),
            'data' => $payload,
            'notification' => $payload,
        ];

        $this->CURLCalling($data);
    }


    public function CURLCalling($data): int
    {

        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . config('app.fcm_server_key'),
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        curl_close($ch);
        if ($response === false) {
            $result = 0;
        } else {
            $result = 1;
        }
        return $result;
    }

}
