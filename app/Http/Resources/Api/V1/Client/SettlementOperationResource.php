<?php

namespace App\Http\Resources\Api\V1\Client;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettlementOperationResource extends JsonResource
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
            "total" => $this->amount,
            "type" => $this->type,
            "created_at" => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
        ];
    }
}
