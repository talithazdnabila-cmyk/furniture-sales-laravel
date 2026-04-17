<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Update nilai 'lunas' menjadi 'completed' untuk kompatibilitas
            DB::table('transactions')
                ->where('status', 'lunas')
                ->update(['status' => 'completed']);

            // Ubah enum status dari ['pending', 'lunas'] menjadi ['pending', 'shipped', 'completed']
            $table->enum('status', ['pending', 'shipped', 'completed'])
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
            // Update nilai 'completed' kembali menjadi 'lunas'
            DB::table('transactions')
                ->where('status', 'completed')
                ->update(['status' => 'lunas']);

            $table->enum('status', ['pending', 'lunas'])
                  ->default('pending')
                  ->change();
        });
    }
};
