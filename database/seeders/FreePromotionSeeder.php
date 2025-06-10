<?php

namespace Database\Seeders;

use App\Models\Promotion;
use App\Enum\PromotionTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FreePromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotion::create([
            'name' => PromotionTypeEnum::FREE,
            'discount' => 100,
            'is_active' => true,
        ]);
    }
}
