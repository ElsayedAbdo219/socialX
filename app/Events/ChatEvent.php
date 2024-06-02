<?php

namespace App\Events;

use App\Http\Resources\Api\Chat\ChatResource;
use App\Http\Resources\Api\Chat\MessageResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public mixed $message;

    public $chat;

    public string $toType;

    /**
     * Create a new event instance.
     */
    public function __construct($chat, $message, $toType)
    {
        $this->chat = $chat;
        $this->message = $message;
        $this->toType = $toType;
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->chat?->id);
    }

    public function broadcastAs()
    {
        return 'new_chat';
    }

    public function broadcastWith()
    {
        return [
            'message' => MessageResource::make($this->message),
            'chat' => ChatResource::make($this->chat),
        ];
    }
}
