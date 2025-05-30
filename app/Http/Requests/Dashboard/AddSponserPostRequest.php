<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\StatusTypeSponserEnum;
use App\Enum\PaymentTypeEnum;
class AddSponserPostRequest extends FormRequest
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
      $statusTypes = implode(',',StatusTypeSponserEnum::toArray());
      $paymentStatusTypes = implode(',',PaymentTypeEnum::specialArray());

        return [
            'user_id' => 'required|exists:members,id',
            'image' => 'required|image|mimes:png,jpg,jpeg', 
            'days_number' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:'.$statusTypes,
            'payment_status' => 'required|in:'.$paymentStatusTypes,
        ];
    }
}
