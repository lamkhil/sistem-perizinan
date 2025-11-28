<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Mengubah foreign key constraints dari CASCADE ke SET NULL
     * untuk melindungi data saat user dihapus
     */
    public function up(): void
    {
        // 1. Ubah permohonans table - user_id menjadi nullable dan set null on delete
        Schema::table('permohonans', function (Blueprint $table) {
            // Drop foreign key constraint yang lama
            $table->dropForeign(['user_id']);
        });

        // Ubah kolom user_id menjadi nullable
        DB::statement('ALTER TABLE permohonans MODIFY user_id BIGINT UNSIGNED NULL');

        // Tambahkan foreign key constraint baru dengan SET NULL
        Schema::table('permohonans', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });

        // 2. Ubah log_permohonans table - user_id menjadi nullable dan set null on delete
        Schema::table('log_permohonans', function (Blueprint $table) {
            // Drop foreign key constraint yang lama
            $table->dropForeign(['user_id']);
        });

        // Ubah kolom user_id menjadi nullable
        DB::statement('ALTER TABLE log_permohonans MODIFY user_id BIGINT UNSIGNED NULL');

        // Tambahkan foreign key constraint baru dengan SET NULL
        Schema::table('log_permohonans', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });

        // 3. Ubah penerbitan_berkas table - user_id menjadi nullable dan set null on delete
        Schema::table('penerbitan_berkas', function (Blueprint $table) {
            // Drop foreign key constraint yang lama
            $table->dropForeign(['user_id']);
        });

        // Ubah kolom user_id menjadi nullable
        DB::statement('ALTER TABLE penerbitan_berkas MODIFY user_id BIGINT UNSIGNED NULL');

        // Tambahkan foreign key constraint baru dengan SET NULL
        Schema::table('penerbitan_berkas', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert permohonans
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        DB::statement('ALTER TABLE permohonans MODIFY user_id BIGINT UNSIGNED NOT NULL');
        Schema::table('permohonans', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

        // Revert log_permohonans
        Schema::table('log_permohonans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        DB::statement('ALTER TABLE log_permohonans MODIFY user_id BIGINT UNSIGNED NOT NULL');
        Schema::table('log_permohonans', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

        // Revert penerbitan_berkas
        Schema::table('penerbitan_berkas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        DB::statement('ALTER TABLE penerbitan_berkas MODIFY user_id BIGINT UNSIGNED NOT NULL');
        Schema::table('penerbitan_berkas', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }
};
