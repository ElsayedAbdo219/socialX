<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam token string required The user current access token.Example: 1|dfkjbkjsdb32jb4jkb2kj5b32k5jb3j2b5j3k2b5
 */
class RefreshTokenRequest extends FormRequest
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
            "token" => ["string"],
        ];
    }

    public function attributes(): array
    {
        return [
            'token' => __('Authorization Token'),
        ];
    }
}
