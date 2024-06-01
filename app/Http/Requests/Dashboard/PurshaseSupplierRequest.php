<?php

namespace App\Http\Requests\Dashboard;

use App\Enum\UserTypeEnum;
use App\Enum\DeliveryWayEnum;
use App\Enum\PaymentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class PurshaseSupplierRequest extends FormRequest
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
            'trader_id'=>['required','exists:traders,id,type,'.UserTypeEnum::SUPPLIER],
            'phone'=>['required','exists:traders,phone,type,'.UserTypeEnum::SUPPLIER],
            'goods_type_id'=>['required','exists:good_types,id'],
            'ton_quantity'=>['required','numeric'],
            'ton_quantity_price'=>['required','numeric'],
            'ton_quantity_cutting'=>['required','numeric','gt:ton_quantity_price'],
            'delivery_way' => ['required', 'string', 'in:'.$types],
            'ton_colon_price' => ['nullable','required_if:delivery_way,'.DeliveryWayEnum::WASSAL, 'numeric'],
            'payment_way'=>['nullable','string','in:'.$payments],
            'first_amount'=>['nullable','numeric','required_if:delivery_way,'.PaymentTypeEnum::INSTALLMENT],
            'duration'=>['nullable','numeric','required_if:delivery_way,'.PaymentTypeEnum::INSTALLMENT],
           
        ];
    }
}
