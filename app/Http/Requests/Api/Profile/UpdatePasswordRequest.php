<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "password" => ["required","confirmed",Password::default()],
            'old_password' => ['required']
        ];
    }

    public function attributes(): array
    {
        return [

        ];
    }
}
