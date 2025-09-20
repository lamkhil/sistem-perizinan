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
        Schema::table('ttd_settings', function (Blueprint $table) {
            $table->string('mengetahui_photo')->nullable()->after('mengetahui_nip');
            $table->string('menyetujui_photo')->nullable()->after('menyetujui_nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ttd_settings', function (Blueprint $table) {
            $table->dropColumn(['mengetahui_photo', 'menyetujui_photo']);
        });
    }
};
