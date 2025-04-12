<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\ReactTypeEnum;
class ReactRequest extends FormRequest
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
            'post_id' => ['required','exists:posts,id'],
            'react_type' => ['required','string','in:'.$reacts],
        ];
    }
}
