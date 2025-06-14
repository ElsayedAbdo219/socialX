<?php

namespace App\Http\Requests\Api\V1\Client;
use Illuminate\Foundation\Http\FormRequest;

class uploadChunkAdsRequest extends FormRequest
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
            'chunk' => ['required', 'file', 'mimes:mp4,mov', 'max:50000'], // حوالي 50MB للجزء الواحد
            'file_name' => ['required','string'],
            'chunk_number' => ['required','numeric'],
        ];
    }
}
