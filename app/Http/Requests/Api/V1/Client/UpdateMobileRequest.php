<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMobileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "mobile" => ["required", "unique:users,mobile," . auth('api')?->id()],
        ];
    }

    public function attributes(): array
    {
        return [

        ];
    }
}
