<?php

namespace App\Http\Resources\Api\Chat;

use App\Enum\Chat\ChatUsersTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => (int) $this->id,
            'from_id' => (int) $this->from_id,
            'from_type' => ChatUsersTypeEnum::modelById((int) $this->from_id),
            'from_type_text' => __('messages.'.ChatUsersTypeEnum::modelById((int) $this->from_id)),
            'to_id' => (int) $this->to_id,
            'to_type' => ChatUsersTypeEnum::modelById((int) $this->to_id),
            'message_text' => (string) $this->message_text,
            'readed_at' => (string) $this->readed_at,
            'date' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
