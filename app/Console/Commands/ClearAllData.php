<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LogPermohonan;
use App\Models\Permohonan;
use App\Models\PenerbitanBerkas;
use App\Models\JenisUsaha;
use App\Models\TtdSetting;
use App\Models\AppSetting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ClearAllData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:clear {--all : Hapus semua data termasuk users} {--force : Skip konfirmasi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus semua data dari database (kecuali users, kecuali jika menggunakan --all)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('Apakah Anda yakin ingin menghapus semua data? Tindakan ini tidak dapat dibatalkan!', true)) {
                $this->info('Operasi dibatalkan.');
                return 0;
            }
        }

        $this->info('Menghapus data...');
        
        try {
            DB::beginTransaction();

            // Hapus log_permohonans dulu karena foreign key ke permohonans
            $this->info('Menghapus log permohonan...');
            LogPermohonan::query()->delete();
            $this->info('✓ Log permohonan dihapus');

            // Hapus permohonans
            $this->info('Menghapus permohonan...');
            Permohonan::query()->delete();
            $this->info('✓ Permohonan dihapus');

            // Hapus penerbitan_berkas
            $this->info('Menghapus penerbitan berkas...');
            PenerbitanBerkas::query()->delete();
            $this->info('✓ Penerbitan berkas dihapus');

            // Hapus jenis_usahas
            $this->info('Menghapus jenis usaha...');
            JenisUsaha::query()->delete();
            $this->info('✓ Jenis usaha dihapus');

            // Hapus ttd_settings
            $this->info('Menghapus pengaturan TTD...');
            TtdSetting::query()->delete();
            $this->info('✓ Pengaturan TTD dihapus');

            // Hapus app_settings
            if (class_exists(AppSetting::class)) {
                $this->info('Menghapus pengaturan aplikasi...');
                AppSetting::query()->delete();
                $this->info('✓ Pengaturan aplikasi dihapus');
            }

            // Hapus users jika menggunakan --all
            if ($this->option('all')) {
                $this->info('Menghapus users...');
                User::query()->delete();
                $this->info('✓ Users dihapus');
            }

            DB::commit();
            
            $this->newLine();
            $this->info('✓ Semua data berhasil dihapus!');
            
            if (!$this->option('all')) {
                $this->info('ℹ Users tetap ada untuk login.');
            }
            
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
            return 1;
        }
    }
}
