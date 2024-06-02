<?php

namespace App\Actions\Chats;

use App\Enum\UserTypeEnum;
use App\Events\ChatEvent;
use App\Models\Chat;
use App\Notifications\ClientNotification;
use App\Notifications\DriverNotification;
use Illuminate\Foundation\Auth\User;

class SendMessageAction
{
    public function handle(
        Chat   $chat,
        User   $from,
        User   $to,
        string $messageText,
        array  $images,
        $toType
    ) {
        $message = $chat->messages()->create([
            'message_text' => $messageText,
            'from_id' => $from->id,
            'from_type' => $from::class,
            'to_id' => $to->id,
            'to_type' => $to::class,
        ]);

        # uploadImage($message, $images, 'message_images');

        $chat->update([
            'last_message_id' => $message->id,
        ]);

        event(new ChatEvent($chat, $message, $toType));

        $chatNotificationData = prepareNotification(
            title: 'messages.responses.new_message',
            body: [
                'data' => $message->message_text ?? '',
                'anotherData' => [
                    'type' => 'new_message',
                    'id' => $chat->id,
                    'notify_type' => $toType,
                    'from' => $from->name,
                    'to' => $to->name,
                    'from_avatar' => $from->avatar,
                    'to_avatar' => $to->avatar,
                    'from_mobile' => $from->mobile,
                    'to_mobile' => $to->mobile,
                    'to_id' => $to->id,
                    'from_id' => $from->id,
                    'order_id' => $chat->order_id,
                ]
            ]
        );

        $notification = $toType == UserTypeEnum::SUPPLIER ? DriverNotification::class : ClientNotification::class;
        $to->notify(new $notification($chatNotificationData, ['firebase', 'database']));

        return $message;
    }
}
