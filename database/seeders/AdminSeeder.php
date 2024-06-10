<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->truncate();

        User::create([
            'name' => 'Admin123',
            'email' => 'admin@admin.com',
            'password' => Hash::make('s7&^sd-(*)'),
            'email_verified_at' => now()
        ]);
    }
}
