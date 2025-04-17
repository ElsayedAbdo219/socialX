<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam code string required The OTP sent via sms to user.Example: 1234
 */
class UpdatePasswordRequest extends FormRequest
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
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }

    /* public function attributes(): array
    {
        return [
            'code' => __('OTP Code'),
        ];
    } */
}
