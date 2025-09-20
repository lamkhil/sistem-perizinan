<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permohonan;
use App\Models\User;
use Carbon\Carbon;

class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user pertama sebagai pemilik permohonan
        $user = User::first();
        
        if (!$user) {
            // Jika tidak ada user, buat user dummy
            $user = User::create([
                'name' => 'User Dummy',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
        }

        $sektors = [
            'Pergudangan dan Penyimpanan',
            'Perdagangan Besar Barang Logam Untuk Bahan Konstruksi',
            'Pergudangan dan Penyimpanan Lainnya',
            'Perdagangan Eceran',
            'Industri Makanan',
            'Jasa Konstruksi',
            'Transportasi',
            'Pariwisata'
        ];

        $kbliCodes = ['52101', '46631', '52109', '46900', '47111', '47211', '47301', '47411'];
        $statuses = ['Diterima', 'Dikembalikan', 'Ditolak', 'Menunggu'];
        $verifikasiStatus = ['Mikro', 'Kecil', 'Menengah', 'Besar'];
        $jenisProyek = ['Utama', 'Pendukung', 'Tambahan'];

        $dataPermohonan = [];

        for ($i = 1; $i <= 30; $i++) {
            $tanggal = Carbon::now()->subDays(rand(1, 30));
            $noPermohonan = '1-' . $tanggal->format('YmdHis') . str_pad($i, 6, '0', STR_PAD_LEFT);
            $noProyek = $tanggal->format('Ym') . '-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT) . '-' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
            
            $dataPermohonan[] = [
                'no_permohonan' => $noPermohonan,
                'no_proyek' => $noProyek,
                'tanggal_permohonan' => $tanggal->format('Y-m-d'),
                'nib' => rand(100000000000, 9999999999999),
                'kbli' => $kbliCodes[array_rand($kbliCodes)],
                'jenis_pelaku_usaha' => 'Perseorangan',
                'nama_usaha' => 'UD. ' . ['BINTANG MULIA', 'SUKSES JAYA', 'MAJU MANDIRI', 'SENTOSA', 'ANUGERAH', 'BERKAH', 'SEJAHTERA', 'MAKMUR', 'GEMILANG', 'CEMERLANG'][array_rand(['BINTANG MULIA', 'SUKSES JAYA', 'MAJU MANDIRI', 'SENTOSA', 'ANUGERAH', 'BERKAH', 'SEJAHTERA', 'MAKMUR', 'GEMILANG', 'CEMERLANG'])],
                'verifikator' => 'GUDANG ' . $i,
                'alamat_perusahaan' => 'Jl. ' . ['Raya', 'Maju', 'Sukses', 'Jaya', 'Mandiri'][array_rand(['Raya', 'Maju', 'Sukses', 'Jaya', 'Mandiri'])] . ' No. ' . rand(1, 999),
                'modal_usaha' => rand(10000000, 2000000000),
                'jenis_proyek' => $jenisProyek[array_rand($jenisProyek)],
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang',
                'verifikasi_dpmptsp' => $verifikasiStatus[array_rand($verifikasiStatus)],
                'status' => $statuses[array_rand($statuses)],
                'sektor' => $sektors[array_rand($sektors)],
                'inputan_teks' => 'Kegiatan ' . $i,
                'created_at' => $tanggal,
            ];
        }

        foreach ($dataPermohonan as $data) {
            Permohonan::create(array_merge($data, [
                'user_id' => $user->id,
                'updated_at' => $data['created_at'],
            ]));
        }

        $this->command->info('Data permohonan berhasil di-seed!');
    }
}