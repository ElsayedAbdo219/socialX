<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class FrequentlyQuestionedAnswerRequest extends FormRequest
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
            'order' => ['required','numeric','min:1'],
            // 'question_en' => ['nullable','string','max:255'],
            // 'answer_en' => ['nullable','string','max:1023'],
            'question' => ['required','string','max:255'],
            'answer' => ['required','string','max:1023'],
        ];
    }
}