<?php

namespace App\Http\Requests\Dashboard;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusAdvertise extends FormRequest
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
        // dd($this->status);
        $statusTypes = \App\Enum\AdsStatusEnum::toArray();
        // dd($statusTypes);
        $statusTypes = implode(',', array_keys($statusTypes));
        // dd($this->status, $statusTypes);
        return [
            'status' => 'required|in:' . $statusTypes,
            'reason_cancelled' => 'required_if:status,cancelled|nullable|string',
        ];
    }
}
