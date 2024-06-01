<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\DeliveryWayEnum;
use App\Enum\PaymentTypeEnum;
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
         $types=implode(',',DeliveryWayEnum::toArray());
        $payments=implode(',',PaymentTypeEnum::toArray());

        return [
            'trader_id'=>['required','exists:traders,id'],
            'phone'=>['required','string'],
            'goods_type_id'=>['required','exists:good_types,id'],
            'ton_quantity'=>['required','numeric'],
            'ton_quantity_price'=>['required','numeric'],
            'delivery_way' => ['required', 'string', 'in:'.$types],
            'ton_nolon_price' => ['nullable','required_if:delivery_way,'.DeliveryWayEnum::WASSAL, 'numeric'],
            'payment_type'=>['nullable','string','in:'.$payments],
            'deposit_money'=>['nullable','numeric','required_if:payment_type,'.PaymentTypeEnum::CHECKINGACCOUNT],
            'first_amount'=>['nullable','numeric','required_if:payment_type,'.PaymentTypeEnum::INSTALLMENT],
            'duration'=>['nullable','numeric','required_if:payment_type,'.PaymentTypeEnum::INSTALLMENT],
        ];
    }
}
