<?php

namespace App\Http\Requests\Api\V1\Client;

use App\Rules\CheckTonQuantityPrice;
use Illuminate\Foundation\Http\FormRequest;
use App\Enum\{UserTypeEnum,DeliveryWayEnum};

class PurshaseCompanyRequest extends FormRequest
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
        return [
            'trader_id'=>['required','exists:traders,id,type,'.UserTypeEnum::COMPANY],
            'phone'=>['exists:traders,phone'],
            'goods_type_id'=>['required','exists:good_types,id'],
            'ton_quantity'=>['required','numeric'],
            'ton_quantity_cutting'=>['required','numeric','gt:ton_quantity_price'],
            'ton_quantity_price'=>['required','numeric'],
            'delivery_way' => ['required', 'string', 'in:'.$types],
            'ton_colon_price' => ['nullable','required_if:delivery_way,'.DeliveryWayEnum::ONSITE, 'numeric'],
            'deposit_money'=>['nullable','numeric'],
        ];
    }
}
