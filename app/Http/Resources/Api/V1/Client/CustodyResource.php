<?php

namespace App\Http\Resources\Api\V1\Client;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustodyResource extends JsonResource
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
            "operation_type" => 'custody',
            "operation_type_translated" =>__('messages.custody'),
            "total" => $this->amount.' '.__('messages.pound'),
            "to" =>$this->to,
            "reason" => $this->reason,
            "status" => $this->status === 'Active' ? __('messages.equaltive') : __('messages.nonequaltive'),
            "statusBoolean" => $this->status === 'Active' ? true : false ,
            "created_at" => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
        ];
    }
}
