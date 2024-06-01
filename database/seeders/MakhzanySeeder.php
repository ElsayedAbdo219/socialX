<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Trader;
use App\Enum\UserTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MakhzanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            Trader::create([
            'name' => UserTypeEnum::MAKHZANY,
            'phone' => auth('api')->user()->mobile,
            'user_id' =>auth('api')->user()->id,
            'type' => UserTypeEnum::CLIENT,
        ]);

    }
}
