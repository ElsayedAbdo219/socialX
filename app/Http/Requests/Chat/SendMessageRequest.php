<?php

namespace App\Http\Requests\Chat;

use App\Enum\Chat\ChatUsersTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rule;

/**
 * @bodyParam to_type string required in user,provider,driver.Example: user
 * @bodyParam to_id integer required.Example: 2
 * @bodyParam message string required.Example: dsbfjksdbk
 * @bodyParam images file [].
 */
class SendMessageRequest extends FormRequest
{
    use ValidatesRequests;

    public function rules()
    {
        return [
            'to_type' => ['required', Rule::in(ChatUsersTypeEnum::toValues())],
            'to_id' => ['required'],
            'message' => ['required'],
            'images' => ['nullable', 'array'],
        ];
    }

    public function messagesAction(): array
    {
        return [];
    }
}
