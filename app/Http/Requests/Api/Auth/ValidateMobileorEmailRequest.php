<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam email string required user email. Example: test@test.com
 * @bodyParam mobile string required The new Mobile Number of the user.Example: 0564776688
 */
class ValidateMobileorEmailRequest extends FormRequest
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
            "email" => ["nullable", 'email:rfc,filter', "unique:users,email"],
            "mobile" => ["nullable", "unique:users,mobile"],
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => __('E-Mail'),
            'mobile' => __('Mobile'),
        ];
    }
}
