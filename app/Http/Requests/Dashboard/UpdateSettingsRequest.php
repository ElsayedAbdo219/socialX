<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
            'number.*' => ['required', 'string', 'min:7', 'max:15'],
            'watsApp'=>['required','string','min:7,max:15'],
            'facebook'=>['required','string','url'],
            'snapchat' => ['required','string', 'url'],
            'instagram'=>['required','string', 'url'],
            'content' => ['required|string','max:500'],
            // 'watsApp'=>['required','string'],
            // 'watsApp'=>['required','string'],
            // 'watsApp'=>['required','string'],
            // 'watsApp'=>['required','string'],
            // 'watsApp'=>['required','string'],
            // 'watsApp'=>['required','string'],
            // 'watsApp'=>['required','string'],
            // 'watsApp'=>['required','string'],
        ];
    }
}
