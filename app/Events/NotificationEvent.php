<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $notificationData;
    /**
     * Create a new event instance.
     */
    public function __construct($notificationData)
    {
        $this->notificationData = $notificationData;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('notification.'.$this->notificationData['topic']);
    }

    public function broadcastAs()
    {
        return 'new_notification';
    }

    public function broadcastWith()
    {
        return [
            'title' => $this->notificationData['title'],
            'body' => $this->notificationData['body'],
        ];
    }
}
