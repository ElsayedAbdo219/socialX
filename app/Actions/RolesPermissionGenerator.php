<?php

namespace App\Actions;

use Illuminate\Support\Str;
use App\Models\Permission;

class RolesPermissionGenerator
{
    public function handle(array $models, array $methods, string $guard_name, $additionalAdminPermissions = []): array
    {
        $permissions = [];

        if ($additionalAdminPermissions) {
            $parent = null;
            foreach ($additionalAdminPermissions as $additionalAdminPermission) {
                if (is_array($additionalAdminPermission)) {
                    foreach ($additionalAdminPermission as $key => $data) {
                        foreach ($data as $small) {
                            $permissionMore = Permission::firstOrCreate([
                                'slug' => Str::slug($small),
                                'guard_name' => 'api',
                            ], [
                                'name' => [
                                    'ar' => trans('permissions.responses.' . $small, [], 'ar'),
                                    'en' => trans('permissions.responses.' . $small, [], 'en')
                                ],
                                'slug' => Str::slug($small),
                                'guard_name' => 'api',
                                'model' => $key,
                                'parent_id' => $parent,
                                'for_users' => $guard_name != 'admin' ? 1 : 0
                            ]);
                        }
                    }
                } else {
                    $permissionMore = Permission::firstOrCreate([
                        'slug' => Str::slug($additionalAdminPermission),
                        'guard_name' => 'api',
                    ], [
                        'name' => [
                            'ar' => trans('permissions.responses.' . $additionalAdminPermission, [], 'ar'),
                            'en' => trans('permissions.responses.' . $additionalAdminPermission, [], 'en')
                        ],
                        'slug' => Str::slug($additionalAdminPermission),
                        'guard_name' => 'api',
                        'model' => 'driver_edit_requests',
                        'parent_id' => $parent,
                        'for_users' => $guard_name != 'admin' ? 1 : 0
                    ]);
                }


                if ($parent == null) {
                    $parent = $permissionMore->id;
                }
                $permissions[] = $permissionMore;
            }
        }


        foreach ($models as $model) {

            $permission = Permission::firstOrCreate(
                [
                    'slug' => Str::slug($model),
                    'guard_name' => 'api',
                ],
                [
                    'name' =>
                        [
                            'ar' => trans('permissions.responses.' . $model, [], 'ar'),
                            'en' => trans('permissions.responses.' . $model, [], 'en')
                        ]
                    ,
                    'slug' => Str::slug($model),
                    'model' => $model,
                    'guard_name' => 'api',
                    'parent_id' => null,
                    'for_users' => $guard_name != 'admin' ? 1 : 0
                ]
            );

            foreach ($methods as $method) {
                $permissions[] = Permission::firstOrCreate([
                    'slug' => Str::slug("$model $method"),
                    'parent_id' => $permission->id,
                    'guard_name' => 'api',
                ], [
                    'name' => [
                        'ar' => trans('permissions.responses.' . $method, [], 'ar') . ' ' . trans('permissions.responses.' . $model, [], 'ar'),
                        'en' => trans('permissions.responses.' . $method, [], 'en') . ' ' . trans('permissions.responses.' . $model, [], 'en')
                    ],
                    'slug' => Str::slug("$model $method"),
                    'model' => $model,
                    'guard_name' => 'api',
                    'parent_id' => $permission->id,
                    'for_users' => $guard_name != 'admin' ? 1 : 0
                ]);
            }
        }

        return $permissions;
    }
}
