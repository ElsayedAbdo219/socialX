<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\{UserTypeEnum,PaymentTypeEnum,DeliveryWayEnum};
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
         $payments=implode(',',PaymentTypeEnum::toArray());
         $types=implode(',',DeliveryWayEnum::toArray());

        return [
            'payment_type'=>['required','string','in:'.$payments],
            'trader_id'=>['nullable','exists:traders,id,type,'.UserTypeEnum::CLIENT,'required_if:payment_type,'.PaymentTypeEnum::CHECKINGACCOUNT,'string'],
            'phone'=>['nullable','required_if:payment_type,'.PaymentTypeEnum::CHECKINGACCOUNT,'string'],
            'payment_amout'=>['nullable','required_if:payment_type,'.PaymentTypeEnum::CHECKINGACCOUNT,'numeric'],
            'goods_type_id'=>['required','exists:good_types,id'],
            'unit'=>['required','string'],
            'quantity'=>['required','numeric'],
            'unit_price'=>['required','numeric'],
            'delivery_way' => ['required', 'string', 'in:'.$types],
            'ton_nolon_price' => ['nullable','required_if:delivery_way,'.DeliveryWayEnum::WASSAL, 'numeric'],
        ];
    }
}
