<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $medicines = [
            ['name' => 'Paracetamol (Biogesic)', 'category' => 'Analgesic', 'stock' => 500, 'description' => 'For relief of minor aches and pains.'],
            ['name' => 'Amoxicillin', 'category' => 'Antibiotic', 'stock' => 100, 'description' => 'Used to treat bacterial infections.'],
            ['name' => 'Lagundi Syrup', 'category' => 'Herbal', 'stock' => 50, 'description' => 'For cough and asthma relief.'],
            ['name' => 'Multivitamins (Enervon)', 'category' => 'Supplements', 'stock' => 200, 'description' => 'Nutritional supplement.'],
            ['name' => 'Mefenamic Acid', 'category' => 'Pain Reliever', 'stock' => 15, 'description' => 'For mild to moderate pain.'], // Low stock example
            ['name' => 'Cetirizine', 'category' => 'Antihistamine', 'stock' => 0, 'description' => 'For allergy relief.'], // Out of stock example
        ];

        foreach ($medicines as $med) {
            Medicine::create([
                'name' => $med['name'],
                'category' => $med['category'],
                'stock' => $med['stock'],
                'description' => $med['description'],
                'expiration_date' => now()->addYear(), // Expire in 1 year
            ]);
        }
    }
}