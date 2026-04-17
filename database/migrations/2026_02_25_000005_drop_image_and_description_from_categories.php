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
        Schema::table('categories', function (Blueprint $table) {
            // Drop kolom image dan description
            if (Schema::hasColumn('categories', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('categories', 'description')) {
                $table->dropColumn('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Restore kolom saat rollback
            $table->text('description')->nullable()->after('name');
            $table->string('image')->nullable()->after('description');
        });
    }
};
