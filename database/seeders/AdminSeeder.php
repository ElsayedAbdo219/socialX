<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("users")->truncate();

        User::create([
            'name' => 'Admin123',
            'email' => 'admin@admin.com',
            'password' => Hash::make('s7&^sd-(*)'),
            'email_verified_at' => now()
        ]);
    }
}
