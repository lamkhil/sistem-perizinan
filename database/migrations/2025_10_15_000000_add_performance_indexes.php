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
        Schema::table('permohonans', function (Blueprint $table) {
            // Add indexes for frequently queried columns
            $table->index('status');
            $table->index('sektor');
            $table->index('created_at');
            $table->index('deadline');
            $table->index(['status', 'created_at']);
            $table->index(['sektor', 'status']);
            $table->index(['user_id', 'status']);
        });

        Schema::table('users', function (Blueprint $table) {
            // Add indexes for user queries
            $table->index('role');
            $table->index('sektor');
            $table->index(['role', 'sektor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['sektor']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['deadline']);
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['sektor', 'status']);
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['sektor']);
            $table->dropIndex(['role', 'sektor']);
        });
    }
};
