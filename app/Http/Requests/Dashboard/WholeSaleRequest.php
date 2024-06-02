<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class WholeSaleRequest extends FormRequest
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
            'trader_id'=>['required','exists:traders,id'],
            'phone'=>['required','string'],
            'goods_type_id'=>['required','exists:good_types,id'],
            'ton_quantity'=>['required','numeric'],
            'ton_quantity_price'=>['required','numeric'],
            'delivery_way' => ['required', 'string'],
            'ton_nolon_price' => ['nullable','required_if:delivery_way,wassal', 'numeric'],
            'deposit_money'=>['nullable','numeric'],
            'payment_type'=>['required','string'],
            'first_amount'=>['nullable','required_if:payment_type,installment','numeric'],
            'duration'=>['nullable','required_if:payment_type,installment'],
        ];
    }
}
