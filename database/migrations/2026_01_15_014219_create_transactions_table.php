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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
    $table->string('kode_transaksi');
    $table->dateTime('tanggal');

    $table->string('nama_pembeli');
    $table->string('nama_penerima');
    $table->string('no_telepon');
    $table->text('alamat');
    $table->text('catatan')->nullable();

    $table->integer('total_harga');
    $table->integer('grand_total')->default(0);  // ← PINDAHKAN KE SINI

    $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
