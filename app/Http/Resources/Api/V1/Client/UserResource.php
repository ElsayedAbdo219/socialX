<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user" => [
                "id" => $this->id ?? 0,
                "name" => $this->name ?? '',
                "email" => $this->email ?? '',
                "mobile" => $this->mobile ?? '',
                "avatar" => $this->avatar,
                "is_verified" => is_null($this->email_verified_at) ? false : true,
                'roles' => implode(' ,', $this->getRoleNames()->toArray()),
                'info' => $this->info,
                'roles_ids' => $this->getRoleIds(),
                'role_id' => $this->getRoleIds()[0] ?? null,
                'permissions' => $this->formatPermsForCASL()
            ],
        ];
    }


    protected function formatPermsForCASL(): array
    {
        $output = [];
        foreach ($this->getAllPermissions() as $permission) {
            $subject = $permission->model;
            $output[] = [
                'action' => $permission->name,
                'subject' => $subject,
            ];
        }
        return $output;
    }

    public function getRoleIds()
    {
        return $this->whenLoaded('roles', function () {
            return $this->roles->sortByDesc('id')->pluck('id')->toArray();
        });
    }
}
