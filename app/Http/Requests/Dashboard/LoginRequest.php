<?php

namespace App\Http\Requests\Dashboard;

use App\Enum\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required','email',Rule::exists('users','email')
            ->where('type',UserTypeEnum::ADMIN)],
            'password' => ['required', 'min:6' ,'max:100']
        ];
    }

    public function messages()
    {
        return [
            'email.required'=>__('validation_errors.required'),
            'email.email'=>__('validation_errors.email'),
            'email.exists'=>__('validation_errors.exists'),
            'email.min'=>__('validation_errors.min'),
            'email.max'=>__('validation_errors.max'),
        ];
    }
}
