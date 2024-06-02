<?php

namespace App\Http\Resources\Api\V1\Client;

use Carbon\Carbon;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchasingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "operation_type" => $this->type == UserTypeEnum::COMPANY ? 'purshase_from_company' : 'purshase_from_supplier',
            "operation_type_translated" => $this->type == UserTypeEnum::COMPANY ? __('messages.purshase_from_company') : __('messages.purshase_from_supplier'),
            "name" => $this->trader?->name,
            "total" => $this->total . ' ' . __('messages.pound'),
            "ton_quantity" => $this->ton_quantity . ' ' . __('messages.ton'),
            "payment"=>$this->payment_way,
            "delivery"=>$this->delivery_way,
            "created_at" => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
        ];
    }
}
