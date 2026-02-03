<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transactions')->insert([
            [
                'grand_total' => 1500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grand_total' => 2750000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
