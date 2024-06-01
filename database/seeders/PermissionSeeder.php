<?php

namespace Database\Seeders;

use App\Actions\RolesPermissionGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    protected static mixed $abilities;
    protected static mixed $models;
    protected static mixed $permissions;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->truncate();
        self::defaultPermissions(new RolesPermissionGenerator());
    }


    public static function defaultPermissions($rolesPermissionGenerator): void
    {
        # Admin Models
        $adminModels = [
            'users', 'roles', 'permissions', 'notifications', 'chats'
        ];
        $clientModels = [

        ];

        # Default Methods
        $methods = ['index', 'create', 'edit', 'delete', 'show', 'activate'];

        # Additional Admin Permissions
        $additionalAdminPermissions = [];
        $rolesPermissionGenerator->handle(
            $clientModels,
            $methods,
            'client',
            additionalAdminPermissions: $additionalAdminPermissions
        );

        $rolesPermissionGenerator->handle(
            $adminModels,
            $methods,
            'admin',
            additionalAdminPermissions: $additionalAdminPermissions
        );


    }
}
