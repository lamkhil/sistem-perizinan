<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('penerbitan_berkas')->truncate();
        DB::table('permohonans')->truncate();
        DB::table('log_permohonans')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ Semua data Permohonan, Penerbitan Berkas, dan Log berhasil dihapus!');
        $this->command->info('✅ Data User tetap dipertahankan.');
    }
}

