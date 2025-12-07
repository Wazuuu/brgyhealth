<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'reyesaivan60@gmail.com',
            'password' => bcrypt('password'), // Or Hash::make
            'role' => 'admin', // Ensure this column exists
        ]);

        // FIX: Add this line to actually run the ResidentSeeder
        $this->call(ResidentSeeder::class);
    }
}