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
        Schema::table('suppliers', function (Blueprint $table) {
        $table->string('name')->after('id');
        $table->string('phone')->nullable()->after('name');
        $table->string('email')->nullable()->after('phone');
        $table->boolean('is_active')->default(true)->after('email');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
        $table->dropColumn(['name', 'phone', 'email', 'is_active']);
    });
    }
};
