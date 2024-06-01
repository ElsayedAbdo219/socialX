<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enum\UserTypeEnum;

class TraderResource extends JsonResource
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
                "name" => $this->name,
                "phone" => $this->phone,
                "type" => $this->type,
                "company_balance" =>$this->company_balance ?? 0,
                "credit_balance" => $this->credit_balance ?? 0,
                "debit_balance" => $this->debit_balance ?? 0,
                 "boolenStatus"=> $this->name===UserTypeEnum::MAKHZANY ? 1 : 0
        ];
    }
}