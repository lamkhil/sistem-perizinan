<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'name' => 'admin',
            'email' => 'admin@dpmptsp.surabaya.go.id',
            'password' => Hash::make('Admin@2025'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'dpmptsp',
            'email' => 'dpmptsp@dpmptsp.surabaya.go.id',
            'password' => Hash::make('Dpmptsp@2025'),
            'role' => 'dpmptsp',
            'email_verified_at' => now(),
        ]);

        $sektorList = [
            'Dinkopdag',
            'Disbudpar',
            'Dinkes',
            'Dishub',
            'Dprkpp',
            'Dkpp',
            'Dlh',
            'Disperinaker',
        ];

        foreach ($sektorList as $sektor) {
            User::create([
                'name' => $sektor,
                'email' => strtolower($sektor) . '@dpmptsp.surabaya.go.id',
                'password' => Hash::make('PdTeknis@2025'),
                'role' => 'pd_teknis',
                'sektor' => $sektor,
                'email_verified_at' => now(),
            ]);
        }

        User::create([
            'name' => 'penerbitan',
            'email' => 'penerbitan@dpmptsp.surabaya.go.id',
            'password' => Hash::make('Penerbitan@2025'),
            'role' => 'penerbitan_berkas',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ User berhasil dibuat!');
        $this->command->info('📧 Format email: [nama]@dpmptsp.surabaya.go.id');
        $this->command->info('🔑 Password default: [Role]@2025');
        $this->command->info('');
        $this->command->info('📋 Daftar User:');
        $this->command->info('  - Admin: admin@dpmptsp.surabaya.go.id / Admin@2025');
        $this->command->info('  - DPMPTSP: dpmptsp@dpmptsp.surabaya.go.id / Dpmptsp@2025');
        $this->command->info('  - PD Teknis: [sektor]@dpmptsp.surabaya.go.id / PdTeknis@2025');
        $this->command->info('  - Penerbitan Berkas: penerbitan@dpmptsp.surabaya.go.id / Penerbitan@2025');
    }
}
