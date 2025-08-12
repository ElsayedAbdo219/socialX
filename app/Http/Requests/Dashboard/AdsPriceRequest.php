<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdsPriceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'price' => ['required', 'numeric'],
            'type' => ['required', 'string', Rule::in(['video', 'image'])],
            'currency' => ['required', 'string', 'max:3'],
            'resolution' => ['nullable', 'required_if:type,video', 'numeric',Rule::in([ '720', '1080', '1440', '2160'])],
            'appearence_count_for_time' => ['required','numeric','min:1']
        ];
    }
}
