<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResidentSeeder extends Seeder
{
    public function run()
    {
        // Create 50 random residents
        for ($i = 0; $i < 50; $i++) {
            $gender = rand(0, 1) ? 'male' : 'female';
            $age = rand(1, 80);
            
            // Logic: Only females > 18 can be pregnant
            $is_pregnant = ($gender === 'female' && $age > 18) ? (rand(0, 10) > 8) : false;
            
            DB::table('residents')->insert([
                'name' => 'Resident ' . Str::random(5),
                'age' => $age,
                'gender' => $gender,
                'is_pregnant' => $is_pregnant,
                'is_sick' => (rand(0, 10) > 8), // 20% chance of being sick
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}