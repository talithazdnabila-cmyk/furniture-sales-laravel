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
            if (!Schema::hasColumn('transactions', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('grand_total');
            }
            if (!Schema::hasColumn('transactions', 'payment_proof_status')) {
                $table->enum('payment_proof_status', ['pending', 'approved', 'rejected'])->default('pending')->after('payment_proof');
            }
            if (!Schema::hasColumn('transactions', 'payment_proof_note')) {
                $table->text('payment_proof_note')->nullable()->after('payment_proof_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'payment_proof')) {
                $table->dropColumn('payment_proof');
            }
            if (Schema::hasColumn('transactions', 'payment_proof_status')) {
                $table->dropColumn('payment_proof_status');
            }
            if (Schema::hasColumn('transactions', 'payment_proof_note')) {
                $table->dropColumn('payment_proof_note');
            }
        });
    }
};
