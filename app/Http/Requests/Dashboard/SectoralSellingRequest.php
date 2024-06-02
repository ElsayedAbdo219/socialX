<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SectoralSellingRequest extends FormRequest
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
            'payment_type'=>['required','string'],
            'trader_id'=>['nullable','required_if:payment_type,checking_account','exists:traders,id'],
            'phone'=>['nullable','required_if:payment_type,checking_account','string'],
            'payment_amout'=>['nullable','required_if:payment_type,checking_account','numeric'],
            'goods_type_id'=>['required','exists:good_types,id'],
            'unit'=>['required','string'],
            'quantity'=>['required','numeric'],
            'unit_price'=>['required','numeric'],
        ];
    }
}
