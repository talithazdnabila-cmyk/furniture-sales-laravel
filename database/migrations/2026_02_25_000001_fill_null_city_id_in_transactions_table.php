<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\ShippingCity;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ambil kota pertama sebagai default
        $defaultCity = ShippingCity::first();

        if ($defaultCity) {
            // Update semua transactions dengan city_id NULL
            DB::table('transactions')
                ->whereNull('city_id')
                ->update([
                    'city_id' => $defaultCity->id,
                    'shipping_cost' => $defaultCity->shipping_cost,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: set city_id kembali ke NULL
        DB::table('transactions')
            ->update([
                'city_id' => null,
            ]);
    }
};
