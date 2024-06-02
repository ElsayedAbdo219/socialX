<?php

namespace App\Http\Resources\Api\Chat;

use App\Http\Resources\Api\Auth\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => (int) $this->id,
            'type' => (string) $this->type,
            'order_id' => (string) $this->order_id,
            'order_status' => (string) $this->trip?->status,
            'last_message' => MessageResource::make($this->last_message),
            'messages' => $this->whenLoaded('messages', MessageResource::collection($this->messages)),
            #'driver' => UserResource::make($this->driver),
            'user' => UserResource::make($this->user),
            #'store' => UserResource::make($this->store),
            #'order' => OrderResource::make($this->order),
        ];
    }
}
