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

        $dataPermohonan = [
            [
                'no_permohonan' => '1-202505021616241896624',
                'no_proyek' => '202505-0215-2855-7978-250',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '9120320000000',
                'kbli' => '52101',
                'jenis_pelaku_usaha' => 'Perseorangan',
                'nama_usaha' => 'UD. BINTANG MULIA',
                'verifikator' => 'UD. BINTANG MULIA',
                'alamat_perusahaan' => 'Jalan Kenjeran 516 Kav 27-29',
                'modal_usaha' => 50000000,
                'jenis_proyek' => 'Utama',
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang',
                'verifikasi_dpmptsp' => 'Mikro',
                'status' => 'Rendah',
                'sektor' => 'Pergudangan dan Penyimpanan',
                'inputan_teks' => 'Pergudangan Barang Logam',
                'created_at' => Carbon::parse('2025-05-02 16:16:24'),
            ],
            [
                'no_permohonan' => '1-202505021640141739840',
                'no_proyek' => '202505-0215-3632-2579-012',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '2301250000000',
                'kbli' => '46631',
                'jenis_pelaku_usaha' => 'Perseorangan',
                'nama_usaha' => 'HERMANTO',
                'verifikator' => 'GUDANG',
                'alamat_perusahaan' => 'Komp. Pergudangan Mutiara Margomulyo Indah No. 14 (Lama: Jl. Margomulyo Indah Blok E Kav. 3)',
                'modal_usaha' => 27000000,
                'jenis_proyek' => 'Utama',
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang',
                'verifikasi_dpmptsp' => 'Kecil',
                'status' => 'Rendah',
                'sektor' => 'Perdagangan Besar Barang Logam Untuk Bahan Konstruksi',
                'inputan_teks' => 'Perdagangan Besar Logam',
                'created_at' => Carbon::parse('2025-05-02 16:40:14'),
            ],
            [
                'no_permohonan' => '1-202505021330209982564',
                'no_proyek' => '202504-2911-4201-7854-786',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '1404230000000',
                'kbli' => '52109',
                'jenis_pelaku_usaha' => 'Perseorangan',
                'nama_usaha' => 'DJONI RUDY',
                'verifikator' => 'C-15',
                'alamat_perusahaan' => 'JL. ROMOKALISARI INDUSTRI SENTOSA 1/33 (LAMA JL. ROMOKALISARI INDAH SANTOSO I KAV. D-8)',
                'modal_usaha' => 100000000,
                'jenis_proyek' => 'Utama',
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang',
                'verifikasi_dpmptsp' => 'Mikro',
                'status' => 'Rendah',
                'sektor' => 'Pergudangan dan Penyimpanan Lainnya',
                'inputan_teks' => 'Pergudangan Umum',
                'created_at' => Carbon::parse('2025-05-02 13:30:20'),
            ],
            [
                'no_permohonan' => '1-202505051613106809540',
                'no_proyek' => '202504-2911-0621-9693-141',
                'tanggal_permohonan' => '2025-05-05',
                'nib' => '2910220000000',
                'kbli' => '46900',
                'jenis_pelaku_usaha' => 'Perseorangan',
                'nama_usaha' => 'LIM HENDRA',
                'verifikator' => 'Gudang penyimpanan',
                'alamat_perusahaan' => 'Jalan Gunung Anyar Tambak III No. 41 (Lama: Jl. gunung Anyar Tambak No. 41)',
                'modal_usaha' => 25000000,
                'jenis_proyek' => 'Utama',
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang',
                'verifikasi_dpmptsp' => 'Mikro',
                'status' => 'Rendah',
                'sektor' => 'Pergudangan dan Penyimpanan',
                'inputan_teks' => 'Penyimpanan Barang',
                'created_at' => Carbon::parse('2025-05-05 16:13:10'),
            ],
            [
                'no_permohonan' => '1-202504111417139145034',
                'no_proyek' => '202504-1016-3851-9219-625',
                'tanggal_permohonan' => '2025-04-11',
                'nib' => '410220000000',
                'kbli' => '52101',
                'jenis_pelaku_usaha' => 'Perseorangan',
                'nama_usaha' => 'UD. ANUGERAH GRAHA SUKSES',
                'verifikator' => 'PERGUDANGAN SENTOSA',
                'alamat_perusahaan' => 'Komp. Pergudangan Margomulyo Jaya Blok B-19 Surabaya',
                'modal_usaha' => 200000000,
                'jenis_proyek' => 'Utama',
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang',
                'verifikasi_dpmptsp' => 'Kecil',
                'status' => 'Rendah',
                'sektor' => 'Pergudangan dan Penyimpanan',
                'inputan_teks' => 'Pergudangan Komersial',
                'created_at' => Carbon::parse('2025-04-11 14:17:13'),
            ],
            [
                'no_permohonan' => '1-202504111417139145035',
                'no_proyek' => '202504-1016-3851-9219-626',
                'tanggal_permohonan' => '2025-04-11',
                'nib' => '505250000000',
                'kbli' => '46631',
                'jenis_pelaku_usaha' => 'Perseorangan',
                'nama_usaha' => 'YENNY',
                'verifikator' => 'pergudangan',
                'alamat_perusahaan' => 'SIMO TAMBAAN II/69-A10',
                'modal_usaha' => 10000000,
                'jenis_proyek' => 'Utama',
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang',
                'verifikasi_dpmptsp' => 'Mikro',
                'status' => 'Rendah',
                'sektor' => 'Perdagangan Besar Barang Logam Untuk Bahan Konstruksi',
                'inputan_teks' => 'Perdagangan Logam Kecil',
                'created_at' => Carbon::parse('2025-04-11 15:30:00'),
            ],
            [
                'no_permohonan' => '1-202504111417139145036',
                'no_proyek' => '202504-1016-3851-9219-627',
                'tanggal_permohonan' => '2025-04-11',
                'nib' => '1201220000000',
                'kbli' => '52109',
                'jenis_pelaku_usaha' => 'Perseorangan',
                'nama_usaha' => 'MEIDIAN SURYA BERSAUDARA',
                'verifikator' => 'Yenny Jaya',
                'alamat_perusahaan' => 'Jl. Raya Darmo Permai Selatan No. 88',
                'modal_usaha' => 300000000,
                'jenis_proyek' => 'Utama',
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang',
                'verifikasi_dpmptsp' => 'Kecil',
                'status' => 'Rendah',
                'sektor' => 'Pergudangan dan Penyimpanan Lainnya',
                'inputan_teks' => 'Pergudangan Keluarga',
                'created_at' => Carbon::parse('2025-04-11 16:45:00'),
            ],
            [
                'no_permohonan' => '1-202504111417139145037',
                'no_proyek' => '202504-1016-3851-9219-628',
                'tanggal_permohonan' => '2025-04-11',
                'nib' => '9120600000000',
                'kbli' => '46900',
                'jenis_pelaku_usaha' => 'Perseorangan',
                'nama_usaha' => 'WIBISONO GUNAWAN',
                'verifikator' => 'GUDANG Penyimpanan',
                'alamat_perusahaan' => 'Jl. Rungkut Industri Raya No. 15',
                'modal_usaha' => 1300000000,
                'jenis_proyek' => 'Utama',
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang',
                'verifikasi_dpmptsp' => 'Kecil',
                'status' => 'Rendah',
                'sektor' => 'Pergudangan dan Penyimpanan',
                'inputan_teks' => 'Pergudangan Industri',
                'created_at' => Carbon::parse('2025-04-11 17:20:00'),
            ],
            [
                'no_permohonan' => '1-202504111417139145038',
                'no_proyek' => '202504-1016-3851-9219-629',
                'tanggal_permohonan' => '2025-04-11',
                'nib' => '6287880000000',
                'kbli' => '52101',
                'jenis_pelaku_usaha' => 'Perseorangan',
                'nama_usaha' => 'PT. SUKSES MANDIRI',
                'verifikator' => 'PERGUDANGAN DUMAR INDUSTRI',
                'alamat_perusahaan' => 'Jl. Raya Gresik Km. 12 No. 45',
                'modal_usaha' => 1000000000,
                'jenis_proyek' => 'Utama',
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang',
                'verifikasi_dpmptsp' => 'Kecil',
                'status' => 'Rendah',
                'sektor' => 'Pergudangan dan Penyimpanan',
                'inputan_teks' => 'Pergudangan Besar',
                'created_at' => Carbon::parse('2025-04-11 18:00:00'),
            ],
            [
                'no_permohonan' => '1-202504111417139145039',
                'no_proyek' => '202504-1016-3851-9219-630',
                'tanggal_permohonan' => '2025-04-11',
                'nib' => '410230000000',
                'kbli' => '46631',
                'jenis_pelaku_usaha' => 'Perseorangan',
                'nama_usaha' => 'CV. MAJU JAYA',
                'verifikator' => 'Gudang Logistik',
                'alamat_perusahaan' => 'Jl. Raya Surabaya-Mojokerto Km. 8',
                'modal_usaha' => 500000000,
                'jenis_proyek' => 'Utama',
                'verifikasi_pd_teknis' => 'Tanda Daftar Gudang',
                'verifikasi_dpmptsp' => 'Kecil',
                'status' => 'Rendah',
                'sektor' => 'Perdagangan Besar Barang Logam Untuk Bahan Konstruksi',
                'inputan_teks' => 'Perdagangan Logam Besar',
                'created_at' => Carbon::parse('2025-04-11 19:15:00'),
            ]
        ];

        foreach ($dataPermohonan as $data) {
            Permohonan::create(array_merge($data, [
                'user_id' => $user->id,
                'updated_at' => $data['created_at'],
            ]));
        }

        $this->command->info('Data permohonan berhasil di-seed!');
    }
}