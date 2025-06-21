<?php

namespace App\FCMChannel;

use App\Services\SendFCM;
use Illuminate\Notifications\Notification;

class FCMChannel
{
    public function send($notifiable, Notification $notification)
    {
        $notificationData = $notification->toArray($notifiable);
        dd($notificationData, 'FCMChannel');
        (new SendFCM())
            ->sendNotification(
                title: $notificationData['title'],
                body: $notificationData['body'],
                // id: $notificationData['id'],
                anotherData: $notificationData['id'],
                notifiable: $notifiable
            );
    }
}
