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
            // Ubah enum status untuk menambahkan 'rejected'
            $table->enum('status', ['pending', 'shipped', 'completed', 'rejected'])
                  ->default('pending')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Kembalikan ke enum tanpa 'rejected'
            $table->enum('status', ['pending', 'shipped', 'completed'])
                  ->default('pending')
                  ->change();
        });
    }
};
