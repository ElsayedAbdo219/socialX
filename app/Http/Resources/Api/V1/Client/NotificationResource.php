<?php

namespace App\Http\Resources\Api\V1\Client;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'data' => $this->data,
            'body' => $this->data['body'][get_current_lang()] ?? '',
            'title' => $this->data['title'][get_current_lang()] ?? '',
            'read_at' => $this->read_at,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
            'is_read' => (bool)$this->read_at,
        ];
    }
}
