<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CompanyResource;
use Carbon\Carbon;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'content' => $this->content ?? '',
            'file_name' => $this->file_name ?? '',
            'is_follow' => $this->is_follow == 0 ? 'غير متابع' : 'متابع',
            'file_name' => $this->file_name ?? '',
            'review' =>  ReviewResource::make($this->whenLoaded('review')),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
