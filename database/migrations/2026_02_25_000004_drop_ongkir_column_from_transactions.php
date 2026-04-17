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
        Schema::table('transactions', function (Blueprint $table) {
            // Drop kolom ongkir yang sudah tidak digunakan
            // Sekarang menggunakan shipping_cost
            if (Schema::hasColumn('transactions', 'ongkir')) {
                $table->dropColumn('ongkir');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Restore kolom ongkir saat rollback
            $table->integer('ongkir')->default(0)->after('shipping_cost');
        });
    }
};
