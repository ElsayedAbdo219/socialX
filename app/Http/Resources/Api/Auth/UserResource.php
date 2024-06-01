<?php

namespace App\Http\Resources\Api\Auth;

use App\Enum\UserTypeEnum;
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
            $this->mergeWhen($this->OTP != null, [
                "verification_code" => $this->OTP ?? 0000,
            ]),
            $this->mergeWhen($this->access_token != null, [
                "access_token" => $this->access_token ?? '',
            ]),
            "user" => [
                "id" => $this->id ?? 0,
                "name" => $this->name ?? '',
                "avatar" => $this->avatar,
                "email" => $this->email ?? '',
                "mobile" => $this->mobile ?? '',
                "is_verified" => is_null($this->email_verified_at) ? false : true,
                $this->mergeWhen(in_array($this->type, [UserTypeEnum::ADMIN,UserTypeEnum::EMPLOYEE]), [
                    'roles' => $this->groupedRoles(),
                    'roles_ids' => $this->getRoleIds(),
                    'role_id' => $this->getRoleIds()[0] ?? null,
                    'permissions' => $this->formatPermsForCASL(),
                ]),
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
                'slug' => $permission->slug,
                'slug_action' => str_replace('-', ' ', $permission->slug),
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

    private function groupedRoles()
    {
        return $this->roles?->map(function ($controls, $key) {
            return [
                'name' => json_decode($controls?->name, true)[app()->getLocale()] ?? '',
                'id' => $controls->id,
            ];
        })->values();
    }
}
