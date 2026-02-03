<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier; // ✅ INI YANG KURANG

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::insert([
            [
                'name' => 'CV Mebel Jaya',
                'phone' => '08123456789',
                'email' => 'mebeljaya@email.com',
                'address' => 'Jepara',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT Kayu Abadi',
                'phone' => '08234567890',
                'email' => 'kayuabadi@email.com',
                'address' => 'Solo',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
