<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'logo' => $this->logo  ?? '',
            'name' => $this->name ??  '',
            'email' => $this->email ??  '',
            'slogo' => $this->slogo ??  '',
            'website' => $this->website ??  '',
            'address' => $this->address ??  '',
            'bio' => $this->bio ??  '',
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
         
        ];
    }
}
