<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam mobile string required The new Mobile Number of the user.Example: 0564776688
 */
class ChangeMobileRequest extends FormRequest
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
            'mobile' => ['required', "unique:users,mobile," . request()->user('api')?->id . ',id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'mobile' => __('Mobile'),
        ];
    }
}
