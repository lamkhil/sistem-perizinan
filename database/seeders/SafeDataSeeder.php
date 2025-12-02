<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permohonan;
use App\Models\PenerbitanBerkas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Safe Data Seeder
 * 
 * Seeder ini memastikan semua data yang dibuat memiliki user_id yang valid
 * dan semua user memiliki email_verified_at untuk mencegah masalah akses.
 */
class SafeDataSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan semua user yang ada memiliki email_verified_at
        $this->ensureUsersVerified();
        
        // Pastikan semua permohonan memiliki user_id yang valid
        $this->fixPermohonanUsers();
        
        // Pastikan semua penerbitan_berkas memiliki user_id yang valid
        $this->fixPenerbitanBerkasUsers();
        
        $this->command->info('✅ Semua data telah diverifikasi dan diperbaiki jika diperlukan!');
    }
    
    /**
     * Pastikan semua user memiliki email_verified_at
     */
    private function ensureUsersVerified(): void
    {
        $usersWithoutVerification = User::whereNull('email_verified_at')->get();
        
        if ($usersWithoutVerification->count() > 0) {
            foreach ($usersWithoutVerification as $user) {
                $user->email_verified_at = now();
                $user->save();
            }
            $this->command->info("✅ {$usersWithoutVerification->count()} user telah diverifikasi");
        }
    }
    
    /**
     * Perbaiki user_id di permohonan yang tidak valid
     */
    private function fixPermohonanUsers(): void
    {
        $dpmptspUser = User::where('role', 'dpmptsp')->first();
        
        if (!$dpmptspUser) {
            $this->command->warn('⚠️  User DPMPTSP tidak ditemukan. Permohonan tidak dapat diperbaiki.');
            return;
        }
        
        $permohonansWithoutUser = Permohonan::whereDoesntHave('user')->get();
        
        if ($permohonansWithoutUser->count() > 0) {
            foreach ($permohonansWithoutUser as $permohonan) {
                $permohonan->user_id = $dpmptspUser->id;
                $permohonan->save();
            }
            $this->command->info("✅ {$permohonansWithoutUser->count()} permohonan telah diperbaiki");
        }
    }
    
    /**
     * Perbaiki user_id di penerbitan_berkas yang tidak valid
     */
    private function fixPenerbitanBerkasUsers(): void
    {
        $penerbitanUser = User::where('role', 'penerbitan_berkas')->first();
        
        if (!$penerbitanUser) {
            $this->command->warn('⚠️  User Penerbitan Berkas tidak ditemukan. Penerbitan Berkas tidak dapat diperbaiki.');
            return;
        }
        
        $penerbitanWithoutUser = PenerbitanBerkas::whereDoesntHave('user')->get();
        
        if ($penerbitanWithoutUser->count() > 0) {
            foreach ($penerbitanWithoutUser as $penerbitan) {
                $penerbitan->user_id = $penerbitanUser->id;
                $penerbitan->save();
            }
            $this->command->info("✅ {$penerbitanWithoutUser->count()} penerbitan_berkas telah diperbaiki");
        }
    }
}

