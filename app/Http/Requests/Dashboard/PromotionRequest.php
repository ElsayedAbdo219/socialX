<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
    // dd($this);
    return [
      'name' => [
        'required',
        'regex:/^[a-zA-Z0-9\s]+$/',
        'string',
        'max:255',
        Rule::unique('promotions', 'name')->ignore($this->promotion),
      ],
      'discount' => 'required|numeric|min:0|max:100',
      'validity' => 'required|in:period,days',
      'days_count' => 'required_if:validity,days|nullable|integer|min:1|max:365',
      'start_date' => 'required_if:validity,period|nullable|date|after_or_equal:today',
      'end_date' => 'required_if:validity,period|nullable|date|after:start_date',
      'resolution_number' => 'required|array',
      'resolution_number.*' => 'required|numeric|in:720,1080,1440,2160',
      'is_active' => 'boolean',
      'seconds' => 'required|integer|min:0', 
    ];
    
  }
}
