<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permohonan;
use App\Models\User;
use Carbon\Carbon;

class PenerbitanBerkasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user dengan role penerbitan_berkas
        $user = User::where('role', 'penerbitan_berkas')->first();
        
        if (!$user) {
            $this->command->info('User dengan role penerbitan_berkas tidak ditemukan. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        $sektors = [
            'Perdagangan',
            'Kesehatan',
            'Perhubungan',
            'Pertanian',
            'Perindustrian',
            'DKKPR',
            'Ketenagakerjaan'
        ];

        $kbliCodes = ['52101', '46631', '52109', '46900', '47111', '47211', '47301', '47411'];
        $statuses = ['Diterima', 'Dikembalikan', 'Ditolak', 'Menunggu'];
        $jenisProyek = ['Utama', 'Pendukung', 'Pendukung UMKU', 'Kantor Cabang'];
        $jenisPelakuUsaha = ['Orang Perseorangan', 'Badan Usaha'];
        $jenisBadanUsaha = [
            'Perseroan Terbatas (PT)',
            'Perseroan Komanditer (CV)',
            'Firma (Fa)',
            'Persekutuan Perdata',
            'Perseroan Terbatas (PT)',
            'Perseroan Komanditer (CV)',
            'Firma (Fa)',
            'Persekutuan Perdata',
            'Koperasi',
            'Yayasan',
            'Perusahaan Perseorangan',
            'Persekutuan Komanditer (CV)',
            'Persekutuan Firma (Fa)',
            'Persekutuan Perdata'
        ];

        $dataPermohonan = [];

        for ($i = 1; $i <= 5; $i++) {
            $tanggal = Carbon::now()->subDays(rand(1, 30));
            $jenisPelaku = $jenisPelakuUsaha[array_rand($jenisPelakuUsaha)];
            
            $dataPermohonan[] = [
                'no_permohonan' => 'PB-' . str_pad($i, 4, '0', STR_PAD_LEFT) . '-' . date('Y'),
                'no_proyek' => 'PROJ-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'tanggal_permohonan' => $tanggal,
                'nama_usaha' => 'Usaha Penerbitan Berkas ' . $i,
                'alamat_perusahaan' => 'Jl. Penerbitan Berkas No. ' . $i . ', Surabaya',
                'sektor' => $sektors[array_rand($sektors)],
                'modal_usaha' => rand(1000000, 100000000),
                'jenis_proyek' => $jenisProyek[array_rand($jenisProyek)],
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisPelaku === 'Badan Usaha' ? $jenisBadanUsaha[array_rand($jenisBadanUsaha)] : null,
                'nib' => 'NIB' . str_pad($i, 10, '0', STR_PAD_LEFT),
                'kbli' => $kbliCodes[array_rand($kbliCodes)],
                'inputan_teks' => 'Kegiatan Penerbitan Berkas ' . $i,
                'pemilik' => 'Pemilik Usaha ' . $i,
                'nama_perizinan' => 'Perizinan Penerbitan Berkas ' . $i,
                'skala_usaha' => ['Mikro', 'Usaha Kecil', 'Usaha Menengah', 'Usaha Besar'][array_rand(['Mikro', 'Usaha Kecil', 'Usaha Menengah', 'Usaha Besar'])],
                'risiko' => ['Rendah', 'Menengah Rendah', 'Menengah Tinggi', 'Tinggi'][array_rand(['Rendah', 'Menengah Rendah', 'Menengah Tinggi', 'Tinggi'])],
                'verifikator' => 'Verifikator PB ' . $i,
                'verifikasi_pd_teknis' => $statuses[array_rand($statuses)],
                'verifikasi_dpmptsp' => $statuses[array_rand($statuses)],
                'status' => $statuses[array_rand($statuses)],
                'user_id' => $user->id,
                'created_at' => $tanggal,
                'updated_at' => $tanggal,
            ];
        }

        Permohonan::insert($dataPermohonan);
        
        $this->command->info('Berhasil membuat 5 data permohonan untuk role penerbitan_berkas');
    }
}
