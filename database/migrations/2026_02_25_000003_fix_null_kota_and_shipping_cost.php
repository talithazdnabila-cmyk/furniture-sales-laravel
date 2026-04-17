<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update transaksi terbaru (NULL kota) dengan data dari city_id
        \DB::statement('
            UPDATE transactions t
            LEFT JOIN shipping_cities s ON t.city_id = s.id
            SET 
                t.kota = s.city_name,
                t.shipping_cost = s.shipping_cost
            WHERE t.kota IS NULL 
            AND t.city_id IS NOT NULL 
            AND s.city_name IS NOT NULL
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
