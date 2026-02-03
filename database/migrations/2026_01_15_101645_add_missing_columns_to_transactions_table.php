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

            if (!Schema::hasColumn('transactions', 'kode_transaksi')) {
                $table->string('kode_transaksi')->after('id');
            }

            if (!Schema::hasColumn('transactions', 'tanggal')) {
                $table->dateTime('tanggal')->nullable()->after('kode_transaksi');
            }

            if (!Schema::hasColumn('transactions', 'nama_pembeli')) {
                $table->string('nama_pembeli')->after('tanggal');
            }

            if (!Schema::hasColumn('transactions', 'total_harga')) {
                $table->decimal('total_harga', 15, 2)->default(0)->after('nama_pembeli');
            }

            if (!Schema::hasColumn('transactions', 'status')) {
                $table->enum('status', ['pending', 'lunas'])
                      ->default('pending')
                      ->after('total_harga');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            $columns = [
                'kode_transaksi',
                'tanggal',
                'nama_pembeli',
                'total_harga',
                'status',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('transactions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
