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
        // Drop tabel discounts
        Schema::dropIfExists('discounts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate tabel discounts saat rollback
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                  ->nullable()
                  ->constrained('products')
                  ->nullOnDelete();

            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->nullOnDelete();

            $table->string('type'); // percent / fixed
            $table->integer('value');
            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();
        });
    }
};
