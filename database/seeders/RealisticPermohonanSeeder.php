<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permohonan;
use App\Models\User;
use Carbon\Carbon;

class RealisticPermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua data permohonan yang ada
        Permohonan::query()->delete();
        
        // Ambil user untuk testing
        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        $sektors = ['Dinkopdag', 'Disbudpar', 'Dinkes', 'Dishub', 'Dprkpp', 'Dkpp', 'Dlh', 'Disperinaker'];
        $skalaUsaha = ['Mikro', 'Kecil', 'Menengah', 'Besar'];
        $risiko = ['Rendah', 'Sedang', 'Tinggi'];
        $status = ['Menunggu', 'Diterima', 'Ditolak', 'Dikembalikan'];
        $verifikasiStatus = ['Berkas Disetujui', 'Berkas Diperbaiki', 'Pemohon Dihubungi', 'Berkas Diunggah Ulang', 'Pemohon Belum Dihubungi'];
        $jenisProyek = ['Utama', 'Pendukung', 'Pendukung UMKU', 'Kantor Cabang'];
        $jenisPelakuUsaha = ['Orang Perseorangan', 'Badan Usaha'];

        $this->command->info('Creating realistic permohonan data...');

        // 1. DATA TERLAMBAT (5 data) - Deadline di masa lalu
        $this->command->info('Creating overdue data...');
        for ($i = 1; $i <= 5; $i++) {
            $deadline = Carbon::now()->subDays(rand(1, 30)); // 1-30 hari yang lalu
            $tanggalPermohonan = $deadline->copy()->subDays(rand(1, 10)); // Permohonan dibuat sebelum deadline
            
            Permohonan::create([
                'user_id' => $users->random()->id,
                'no_permohonan' => 'OVERDUE-' . str_pad($i, 3, '0', STR_PAD_LEFT) . '-' . $tanggalPermohonan->format('Ymd'),
                'nama_usaha' => 'Usaha Terlambat ' . $i,
                'nama_perusahaan' => 'PT. Terlambat ' . $i,
                'jenis_pelaku_usaha' => $jenisPelakuUsaha[array_rand($jenisPelakuUsaha)],
                'nib' => '123456789' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'alamat_perusahaan' => 'Jl. Terlambat No. ' . $i . ', Malang',
                'sektor' => $sektors[array_rand($sektors)],
                'kbli' => '12345',
                'inputan_teks' => 'Kegiatan Usaha Terlambat ' . $i,
                'modal_usaha' => rand(10000000, 2000000000),
                'jenis_proyek' => $jenisProyek[array_rand($jenisProyek)],
                'no_proyek' => 'PROJ-OVERDUE-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_perizinan' => 'Izin Usaha Terlambat ' . $i,
                'skala_usaha' => $skalaUsaha[array_rand($skalaUsaha)],
                'risiko' => $risiko[array_rand($risiko)],
                'jangka_waktu' => rand(5, 30),
                'no_telephone' => '08' . rand(100000000, 999999999),
                'deadline' => $deadline->format('Y-m-d'),
                'tanggal_permohonan' => $tanggalPermohonan->format('Y-m-d'),
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang ' . ['Besar', 'Menengah', 'Kecil'][array_rand(['Besar', 'Menengah', 'Kecil'])],
                'verifikasi_dpmptsp' => $verifikasiStatus[array_rand($verifikasiStatus)],
                'status' => $status[array_rand($status)],
                'verifikator' => 'Verifikator Terlambat ' . $i,
                'keterangan_pengembalian' => $i <= 2 ? 'Dokumen tidak lengkap' : null,
                'pengembalian' => $i <= 2 ? $deadline->copy()->addDays(rand(1, 5))->format('Y-m-d') : null,
            ]);
        }

        // 2. DATA CLEAR/SELESAI (8 data) - Status Diterima dengan deadline sudah lewat
        $this->command->info('Creating completed data...');
        for ($i = 1; $i <= 8; $i++) {
            $deadline = Carbon::now()->subDays(rand(1, 60)); // 1-60 hari yang lalu
            $tanggalPermohonan = $deadline->copy()->subDays(rand(5, 20)); // Permohonan dibuat sebelum deadline
            $tanggalTerbit = $deadline->copy()->addDays(rand(1, 10)); // Terbit setelah deadline (overdue tapi selesai)
            
            Permohonan::create([
                'user_id' => $users->random()->id,
                'no_permohonan' => 'CLEAR-' . str_pad($i, 3, '0', STR_PAD_LEFT) . '-' . $tanggalPermohonan->format('Ymd'),
                'nama_usaha' => 'Usaha Selesai ' . $i,
                'nama_perusahaan' => 'PT. Selesai ' . $i,
                'jenis_pelaku_usaha' => $jenisPelakuUsaha[array_rand($jenisPelakuUsaha)],
                'nib' => '987654321' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'alamat_perusahaan' => 'Jl. Selesai No. ' . $i . ', Malang',
                'sektor' => $sektors[array_rand($sektors)],
                'kbli' => '54321',
                'inputan_teks' => 'Kegiatan Usaha Selesai ' . $i,
                'modal_usaha' => rand(50000000, 1500000000),
                'jenis_proyek' => $jenisProyek[array_rand($jenisProyek)],
                'no_proyek' => 'PROJ-CLEAR-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_perizinan' => 'Izin Usaha Selesai ' . $i,
                'skala_usaha' => $skalaUsaha[array_rand($skalaUsaha)],
                'risiko' => $risiko[array_rand($risiko)],
                'jangka_waktu' => rand(7, 25),
                'no_telephone' => '08' . rand(200000000, 899999999),
                'deadline' => $deadline->format('Y-m-d'),
                'tanggal_permohonan' => $tanggalPermohonan->format('Y-m-d'),
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang ' . ['Besar', 'Menengah', 'Kecil'][array_rand(['Besar', 'Menengah', 'Kecil'])],
                'verifikasi_dpmptsp' => 'Berkas Disetujui',
                'status' => 'Diterima',
                'verifikator' => 'Verifikator Selesai ' . $i,
                'terbit' => $tanggalTerbit->format('Y-m-d'),
                'keterangan_terbit' => 'Izin telah diterbitkan sesuai ketentuan',
            ]);
        }

        // 3. DATA BERJALAN/ONGOING (12 data) - Deadline di masa depan
        $this->command->info('Creating ongoing data...');
        for ($i = 1; $i <= 12; $i++) {
            $deadline = Carbon::now()->addDays(rand(1, 30)); // 1-30 hari ke depan
            $tanggalPermohonan = Carbon::now()->subDays(rand(1, 15)); // Permohonan dibuat 1-15 hari yang lalu
            
            Permohonan::create([
                'user_id' => $users->random()->id,
                'no_permohonan' => 'ONGOING-' . str_pad($i, 3, '0', STR_PAD_LEFT) . '-' . $tanggalPermohonan->format('Ymd'),
                'nama_usaha' => 'Usaha Berjalan ' . $i,
                'nama_perusahaan' => 'PT. Berjalan ' . $i,
                'jenis_pelaku_usaha' => $jenisPelakuUsaha[array_rand($jenisPelakuUsaha)],
                'nib' => '555666777' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'alamat_perusahaan' => 'Jl. Berjalan No. ' . $i . ', Malang',
                'sektor' => $sektors[array_rand($sektors)],
                'kbli' => '67890',
                'inputan_teks' => 'Kegiatan Usaha Berjalan ' . $i,
                'modal_usaha' => rand(25000000, 1000000000),
                'jenis_proyek' => $jenisProyek[array_rand($jenisProyek)],
                'no_proyek' => 'PROJ-ONGOING-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_perizinan' => 'Izin Usaha Berjalan ' . $i,
                'skala_usaha' => $skalaUsaha[array_rand($skalaUsaha)],
                'risiko' => $risiko[array_rand($risiko)],
                'jangka_waktu' => rand(10, 30),
                'no_telephone' => '08' . rand(300000000, 799999999),
                'deadline' => $deadline->format('Y-m-d'),
                'tanggal_permohonan' => $tanggalPermohonan->format('Y-m-d'),
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang ' . ['Besar', 'Menengah', 'Kecil'][array_rand(['Besar', 'Menengah', 'Kecil'])],
                'verifikasi_dpmptsp' => $verifikasiStatus[array_rand($verifikasiStatus)],
                'status' => ['Menunggu', 'Dikembalikan'][array_rand(['Menunggu', 'Dikembalikan'])],
                'verifikator' => 'Verifikator Berjalan ' . $i,
                'keterangan_pengembalian' => $i <= 3 ? 'Perlu perbaikan dokumen' : null,
                'pengembalian' => $i <= 3 ? Carbon::now()->subDays(rand(1, 5))->format('Y-m-d') : null,
            ]);
        }

        // 4. DATA KHUSUS - Deadline hari ini dan besok
        $this->command->info('Creating special deadline data...');
        
        // Deadline hari ini
        Permohonan::create([
            'user_id' => $users->random()->id,
            'no_permohonan' => 'TODAY-' . Carbon::now()->format('Ymd') . '-001',
            'nama_usaha' => 'Usaha Deadline Hari Ini',
            'nama_perusahaan' => 'PT. Deadline Hari Ini',
            'jenis_pelaku_usaha' => 'Badan Usaha',
            'nib' => '111222333444',
            'alamat_perusahaan' => 'Jl. Deadline Hari Ini No. 1, Malang',
            'sektor' => 'Dinkopdag',
            'kbli' => '11111',
            'inputan_teks' => 'Kegiatan Deadline Hari Ini',
            'modal_usaha' => 500000000,
            'jenis_proyek' => 'Utama',
            'no_proyek' => 'PROJ-TODAY-001',
            'nama_perizinan' => 'Izin Usaha Deadline Hari Ini',
            'skala_usaha' => 'Menengah',
            'risiko' => 'Sedang',
            'jangka_waktu' => 15,
            'no_telephone' => '081234567890',
            'deadline' => Carbon::now()->format('Y-m-d'),
            'tanggal_permohonan' => Carbon::now()->subDays(10)->format('Y-m-d'),
            'verifikasi_pd_teknis' => 'Tanda Daftar Gudang Menengah',
            'verifikasi_dpmptsp' => 'Berkas Disetujui',
            'status' => 'Menunggu',
            'verifikator' => 'Verifikator Hari Ini',
        ]);

        // Deadline besok
        Permohonan::create([
            'user_id' => $users->random()->id,
            'no_permohonan' => 'TOMORROW-' . Carbon::now()->addDay()->format('Ymd') . '-001',
            'nama_usaha' => 'Usaha Deadline Besok',
            'nama_perusahaan' => 'PT. Deadline Besok',
            'jenis_pelaku_usaha' => 'Badan Usaha',
            'nib' => '222333444555',
            'alamat_perusahaan' => 'Jl. Deadline Besok No. 1, Malang',
            'sektor' => 'Disbudpar',
            'kbli' => '22222',
            'inputan_teks' => 'Kegiatan Deadline Besok',
            'modal_usaha' => 750000000,
            'jenis_proyek' => 'Utama',
            'no_proyek' => 'PROJ-TOMORROW-001',
            'nama_perizinan' => 'Izin Usaha Deadline Besok',
            'skala_usaha' => 'Besar',
            'risiko' => 'Tinggi',
            'jangka_waktu' => 20,
            'no_telephone' => '081234567891',
            'deadline' => Carbon::now()->addDay()->format('Y-m-d'),
            'tanggal_permohonan' => Carbon::now()->subDays(8)->format('Y-m-d'),
            'verifikasi_pd_teknis' => 'Tanda Daftar Gudang Besar',
            'verifikasi_dpmptsp' => 'Berkas Disetujui',
            'status' => 'Menunggu',
            'verifikator' => 'Verifikator Besok',
        ]);

        $this->command->info('Realistic permohonan data created successfully!');
        $this->command->info('Total permohonan created: ' . Permohonan::count());
        $this->command->info('Overdue: ' . Permohonan::where('deadline', '<', now())->count());
        $this->command->info('Completed: ' . Permohonan::where('status', 'Diterima')->count());
        $this->command->info('Ongoing: ' . Permohonan::where('deadline', '>', now())->where('status', '!=', 'Diterima')->count());
        $this->command->info('Due today: ' . Permohonan::whereDate('deadline', now())->count());
        $this->command->info('Due tomorrow: ' . Permohonan::whereDate('deadline', now()->addDay())->count());
    }
}
