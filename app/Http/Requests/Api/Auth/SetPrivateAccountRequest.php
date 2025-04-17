<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam code string required The OTP sent via sms to user.Example: 1234
 */
class SetPrivateAccountRequest extends FormRequest
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
            'private_account' => ['required', 'in:0,1','max:1'],
        ];
    }

    /* public function attributes(): array
    {
        return [
            'code' => __('OTP Code'),
        ];
    } */
}
