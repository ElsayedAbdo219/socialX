<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam CMUUID string required The user FCM Token.Example: sdjdgjkbsdkjgbkjb4kjrb4kbjkb45jj43jkbk
 */
class UpdateCMUUIDRequest extends FormRequest
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
            'CMUUID' => ['required', 'string', 'max:190'],
        ];
    }

    public function attributes(): array
    {
        return [
            'CMUUID' => __('CMUUID'),
        ];
    }
}
