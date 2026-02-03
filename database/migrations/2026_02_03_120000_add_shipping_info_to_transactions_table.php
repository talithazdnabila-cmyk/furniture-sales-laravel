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
            if (!Schema::hasColumn('transactions', 'nama_penerima')) {
                $table->string('nama_penerima')->nullable()->after('nama_pembeli');
            }
            if (!Schema::hasColumn('transactions', 'no_telepon')) {
                $table->string('no_telepon')->nullable()->after('nama_penerima');
            }
            if (!Schema::hasColumn('transactions', 'alamat')) {
                $table->longText('alamat')->nullable()->after('no_telepon');
            }
            if (!Schema::hasColumn('transactions', 'catatan')) {
                $table->longText('catatan')->nullable()->after('alamat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'nama_penerima')) {
                $table->dropColumn('nama_penerima');
            }
            if (Schema::hasColumn('transactions', 'no_telepon')) {
                $table->dropColumn('no_telepon');
            }
            if (Schema::hasColumn('transactions', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('transactions', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });
    }
};
