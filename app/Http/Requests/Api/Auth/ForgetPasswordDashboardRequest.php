<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam email string required The E-Mail Address of the user.Example: fahmi@moltaqa.net
 */
class ForgetPasswordDashboardRequest extends FormRequest
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
            'email' => ['required', "exists:users,email,deleted_at,NULL"],
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => __('E-Mail'),
        ];
    }
}
