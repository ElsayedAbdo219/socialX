<?php

namespace App\Http\Requests\Api\V1\Client;

use App\Enum\ContactUsTypesEnum;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|max:255|string|min:3',
            'email' => 'required|email',
            'mobile' => 'required',
            'message' => 'required|max:255|string|min:3',
            'message_type' => 'required|in:' . ContactUsTypesEnum::implodedArray(),
        ];
    }

    public function attributes(): array
    {
        return [

        ];
    }
}
