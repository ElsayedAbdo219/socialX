<?php

namespace App\Http\Resources\Api\V1\Client;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DrawerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'total' => $this->amount,
            'trader name' => $this->trader->name,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
        ];
    }


}