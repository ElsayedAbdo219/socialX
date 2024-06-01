<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @bodyParam password string required The User bew password.Example: 123456789
 * @bodyParam password_confirmation string required The user new password confirmation.Example: 123456789
 */
class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => ['required', 'confirmed', 'string', Password::default()],
        ];
    }

    public function attributes(): array
    {
        return [
            'password' => __('Password'),
            'password_confirmation' => __('Password Confirmation'),
        ];
    }
}
