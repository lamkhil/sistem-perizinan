<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus semua data seeder kecuali users
        DB::table('penerbitan_berkas')->truncate();
        DB::table('permohonans')->truncate();
        DB::table('log_permohonans')->truncate();
        DB::table('jenis_usahas')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ Semua data seeder berhasil dihapus!');
        $this->command->info('   - penerbitan_berkas');
        $this->command->info('   - permohonans');
        $this->command->info('   - log_permohonans');
        $this->command->info('   - jenis_usahas');
        $this->command->info('✅ Data User tetap dipertahankan.');
    }
}

