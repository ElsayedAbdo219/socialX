<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\PostTypeEnum;
class ProjectRequest extends FormRequest
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
            'title' => ['required','string'],
            'description' => ['nullable','string'],
            'url' => ['required','string','url'],
            'start_month' => ['required','numeric','min:1','max:12'],
            'start_year' => ['required','numeric','min:1950','max:'.date("Y")],
            'status' => ['required','string','in:finished,continous'],
            'end_month' => ['required_if:status,continous','numeric','min:1','max:12'],
            'end_year' => ['required_if:status,continous','numeric','min:1950','max:'.date("Y")],
           
        ];
    }
}
