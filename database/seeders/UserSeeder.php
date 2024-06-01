<?php

namespace Database\Seeders;

use App\Enum\UserTypeEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->truncate();
        //        DB::table('users')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();

        $permissions = Permission::all();
        $clientPermissions = Permission::where('for_users', 1)->get();

        # Admin
        $adminRole = Role::create([
            'name' => [
                'ar' => __('permissions.responses.roles-models.' . Role::DEFAULT_ROLE_SUPER_ADMIN, [], 'ar'),
                'en' => __('permissions.responses.roles-models.' . Role::DEFAULT_ROLE_SUPER_ADMIN, [], 'en')
            ],
            'guard_name' => 'api',
            'slug' => Role::DEFAULT_ROLE_SUPER_ADMIN
            ]);
        $adminRole->givePermissionTo($permissions);
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'mobile' => 12345678910,
                'password' => 123123123,
                'is_active' => true,
                'type' => UserTypeEnum::ADMIN
            ]
        );
        $adminUser->assignRole($adminRole);
        $this->command->info('Admin :');
        $this->command->warn($adminUser->email);
        $this->command->warn(123123);
        $this->command->line('------------------------------------------------------------------------------');


        # Client
        //        $clientRole = Role::create([
        //            'name' => [
        //                'ar' => __('permissions.responses.roles-models.' . Role::DEFAULT_ROLE_CLIENT, [], 'ar'),
        //                'en' => __('permissions.responses.roles-models.' . Role::DEFAULT_ROLE_CLIENT, [], 'en')
        //            ],
        //            'guard_name' => 'api',
        //            'slug' => Role::DEFAULT_ROLE_CLIENT
        //            ]);
        //        $clientRole->givePermissionTo($clientPermissions);
        $clientUser = User::firstOrCreate(
            ['email' => 'client@client.com'],
            [
                'name' => 'client',
                'mobile' => 123456789,
                'password' => 123123123,
                'is_active' => true,
                'type' => UserTypeEnum::CLIENT
            ]
        );
        $clientUser = User::firstOrCreate(
            ['email' => 'client@client.com'],
            [
                'name' => 'client',
                'mobile' => 123456789,
                'password' => 123123123,
                'is_active' => true,
                'type' => UserTypeEnum::CLIENT
            ]
        );
        //        $clientUser->assignRole($clientRole);
        $this->command->info('Client :');
        $this->command->warn($clientUser->mobile);
        $this->command->warn(123123);
        $this->command->line('------------------------------------------------------------------------------');

    }

}
