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
            'message' => 'required|max:255|string',
        ];
    }

    public function attributes(): array
    {
        return [

        ];
    }
}
