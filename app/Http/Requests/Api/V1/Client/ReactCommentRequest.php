<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\ReactTypeEnum;
class ReactCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $reacts = implode(',',array_keys(ReactTypeEnum::toArray()));
        return [
            'comment_id' => ['required','exists:comments,id'],
            'react_type' => ['required','string','in:'.$reacts],
        ];
    }
}
