<?php

namespace App\Http\Requests\Chat;

use App\Enum\Chat\ChatTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @bodyParam chat_id integer required.Example: 1
 * @bodyParam type string required in user_driver,provider_user,provider_driver.Example: user_driver
 */
class GetChatRequest extends FormRequest
{
    public function rules()
    {
        return [
            'chat_id' => ['nullable', 'exists:chats,id'],
            'order_id' => ['required', 'exists:trips,id'], // TODO Uncomment this when we have chat on order
            'type' => ['required', Rule::in(ChatTypeEnum::toValues())],
        ];
    }

    public function messagesAction(): array
    {
        return [];
    }
}
