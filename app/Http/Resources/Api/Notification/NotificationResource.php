<?php

namespace App\Http\Resources\Api\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'data' => [
                'title' => is_array($this->data['title']) ? $this->data['title'][get_current_lang()] : json_decode($this->data['title'], true)[get_current_lang()],
                'body' => $this->data['body'] ?: '',
                'type' => $this->data['anotherData']['type'] ?? '--',
                'id' => $this->data['id'] ?? null,
            ],
            'is_read' => $this->read_at ? 1 : 0,
            'receiver_type' => $this->notifiable?->type,
            'created_at' => formattedCreatedAt($this->created_at)
        ];
    }
}
