<?php

namespace App\Http\Resources\Api\V1\Client;

use Carbon\Carbon;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectoralSellingResource extends JsonResource
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
            "operation_type" =>'sectoral_selling',
            "operation_type_translated" => __('messages.sectoral_selling'),
            "type" =>'sectoral_selling',
            "name" => $this->trader?->name,
            "total" => $this->total. ' ' . __('messages.pound'),
            "ton_quantity" => $this->unit === 'ton' ?   $this->quantity. ' ' . __('messages.ton') :  $this->quantity. ' ' . __('messages.shekara') ,
            "payment"=>$this->payment_type,
            "delivery"=>$this->delivery_way,
            "created_at" => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
        ];
    }


    
}
