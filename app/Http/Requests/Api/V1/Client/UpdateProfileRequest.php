<?php

namespace App\Http\Requests\Api\V1\Client;

use App\Enum\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "avatar" => ["nullable","image",'mimes:jpeg,png,jpg,gif,svg'],
            "name" => ["required", 'min:3', 'max:255', 'string'],
            "email" => ["nullable", "unique:users,email," . auth('api')?->id()],
        ];
    }

    public function attributes(): array
    {
        return [

        ];
    }
}
