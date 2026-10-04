<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barangay;
use App\Models\FarmerSubaccount;
use App\Models\Listing;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Hubs
        $hub1 = Barangay::create([
            'city_municipality' => 'Quezon City',
            'barangay_name' => 'Commonwealth',
            'province' => 'Metro Manila'
        ]);

        $hub2 = Barangay::create([
            'city_municipality' => 'Quezon City',
            'barangay_name' => 'Batasan Hills',
            'province' => 'Metro Manila'
        ]);

        // 2. Create Proxy Farmer Accounts
        $farmer1 = FarmerSubaccount::create([
            'barangay_id' => $hub1->id,
            'farmer_name' => 'Mang Juan (via Proxy)',
            'contact_number' => '09123456789'
        ]);

        $farmer2 = FarmerSubaccount::create([
            'barangay_id' => $hub2->id,
            'farmer_name' => 'Aling Maria (via Proxy)',
            'contact_number' => '09987654321'
        ]);

        // 3. Create Wholesale Listings
        Listing::create([
            'farmer_subaccount_id' => $farmer1->id,
            'barangay_id' => $hub1->id,
            'crop_name' => 'Kamatis (Tomatoes)',
            'category' => 'Vegetable',
            'price_per_unit' => 45.00,
            'unit_type' => 'kg',
            'moq_units' => 50,
            'available_stock' => 200,
            'harvest_date' => now()->addDays(2),
            'pickup_hub' => 'Commonwealth Hall',
            'is_active' => true
        ]);

        Listing::create([
            'farmer_subaccount_id' => $farmer2->id,
            'barangay_id' => $hub2->id,
            'crop_name' => 'Dinorado Rice',
            'category' => 'Grain',
            'price_per_unit' => 1100.00,
            'unit_type' => 'Sack (25kg)',
            'moq_units' => 10,
            'available_stock' => 50,
            'harvest_date' => now()->subDays(1),
            'pickup_hub' => 'Batasan Co-op Center',
            'is_active' => true
        ]);
    }
}