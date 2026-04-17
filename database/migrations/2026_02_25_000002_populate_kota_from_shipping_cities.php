<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Populate kolom 'kota' dengan nama kota dari tabel shipping_cities
        DB::statement('
            UPDATE transactions t
            LEFT JOIN shipping_cities s ON t.city_id = s.id
            SET t.kota = s.city_name
            WHERE t.city_id IS NOT NULL AND s.city_name IS NOT NULL
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set kota kembali ke NULL saat rollback
        DB::table('transactions')->update(['kota' => null]);
    }
};
