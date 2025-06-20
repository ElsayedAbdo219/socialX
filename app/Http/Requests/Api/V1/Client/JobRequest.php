<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'job_name' => 'required|string|max:255',
            'employee_type' => 'required|string|max:255',
            'job_period' => 'required|string|max:255',
            'overview' => 'required|string', // text 
            'job_category' => 'required|string|max:255',
            'job_description' => 'required|array', // array
            'job_description.*' => 'required|string|max:255', // array of strings
            'work_level' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'salary_period' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'location' => 'required|string',
        ];
    }
}
