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
     
           User::create(
            [
                'email' => 'admin@admin.com',
                'name' => 'admin',
                'password' => 123123123,
           ]
        );

    }

}
