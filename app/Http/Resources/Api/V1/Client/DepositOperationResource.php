<?php

namespace App\Http\Resources\Api\V1\Client;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\Client\TraderResource;

class DepositOperationResource extends JsonResource
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
            "operation_type" => $this->type,
            "operation_type_translated" => $this->type_translated,
            "name" => $this->trader->name ?? '',
            "trader" => $this->whenLoaded('trader') ? new TraderResource($this->trader) : '',
            "total" => $this->amount. ' ' . __('messages.pound'),
            "another_account" => $this->depositAnother?->name ?? '',
            "deposit_operation_type" => $this->deposit_operation_type ?? '',
            "created_at" => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
        ];
    }
}
