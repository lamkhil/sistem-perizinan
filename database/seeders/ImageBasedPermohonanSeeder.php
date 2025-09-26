<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permohonan;
use App\Models\User;
use Carbon\Carbon;

class ImageBasedPermohonanSeeder extends Seeder
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

        // Data berdasarkan gambar yang dikirim
        $verifikatorOptions = [
            'Ahmad Wijaya, S.T.',
            'Budi Santoso, S.E.',
            'Citra Dewi, S.H.',
            'Dedi Kurniawan, S.T.',
            'Eka Putri, S.E.',
            'Fajar Nugroho, S.T.',
            'Gita Sari, S.H.',
            'Hendra Pratama, S.E.',
            'Indah Lestari, S.T.',
            'Joko Susilo, S.H.'
        ];

        $this->command->info('Creating image-based permohonan data...');

        // Data sesuai dengan gambar (17 baris data)
        $data = [
            [
                'no_permohonan' => 'I-202504291626428624593',
                'no_proyek' => '202504-2908-5233-9874-388',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000000',
                'nama_perusahaan' => 'PT SAPTASUMBER LANCAR',
                'nama_usaha' => 'PT. SAPTASUMBER LANCAR',
                'alamat_perusahaan' => 'Jl. Tambak Langon Indah 1/27 Surabaya',
                'modal_usaha' => 20600000000,
                'no_telephone' => '6281330000000',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202209191652027222398',
                'no_proyek' => '202209-0914-1531-4755-545',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '0809220113861',
                'nama_perusahaan' => 'SAMSUDIN, SAMSUL',
                'nama_usaha' => 'Persewaan Gudang',
                'alamat_perusahaan' => 'Jl. Margomulyo Indah Blok E Kav. 4 Surabaya',
                'modal_usaha' => 10000000,
                'no_telephone' => '6281330000000',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624594',
                'no_proyek' => '202504-2908-5233-9874-389',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000001',
                'nama_perusahaan' => 'UD. KING KOK',
                'nama_usaha' => '83',
                'alamat_perusahaan' => 'JL KEDINDING TENGAH JAYA II NO. 83',
                'modal_usaha' => 50000000,
                'no_telephone' => '6281330000001',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624595',
                'no_proyek' => '202504-2908-5233-9874-390',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000002',
                'nama_perusahaan' => 'HERMANTO',
                'nama_usaha' => '81',
                'alamat_perusahaan' => 'Jalan Kenjeran 516 Kav 27-29',
                'modal_usaha' => 25000000,
                'no_telephone' => 'hermanto.pajak00@gmail.com',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624596',
                'no_proyek' => '202504-2908-5233-9874-391',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000003',
                'nama_perusahaan' => 'LIM HENDRA',
                'nama_usaha' => 'GUDANG',
                'alamat_perusahaan' => 'Komp. Pergudangan Mutiara Margomulyo Indah No. 14',
                'modal_usaha' => 100000000,
                'no_telephone' => '3199443555',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624597',
                'no_proyek' => '202504-2908-5233-9874-392',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000004',
                'nama_perusahaan' => 'UD. ANUGERAH GRAHA SUKSES',
                'nama_usaha' => 'UD. BINTANG MULIA',
                'alamat_perusahaan' => 'Jl. Kyai Tambak Deres No. 3-5',
                'modal_usaha' => 75000000,
                'no_telephone' => '8113426168',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624598',
                'no_proyek' => '202504-2908-5233-9874-393',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000005',
                'nama_perusahaan' => 'DJONI RUDY',
                'nama_usaha' => 'pergudangan',
                'alamat_perusahaan' => 'Jl. Raya Kenjeran No. 123 Surabaya',
                'modal_usaha' => 30000000,
                'no_telephone' => '6281330000005',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624599',
                'no_proyek' => '202504-2908-5233-9874-394',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000006',
                'nama_perusahaan' => 'LENBACH SASTRA',
                'nama_usaha' => 'C-15',
                'alamat_perusahaan' => 'Jl. Margomulyo Indah Blok C No. 15',
                'modal_usaha' => 40000000,
                'no_telephone' => '6281330000006',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624600',
                'no_proyek' => '202504-2908-5233-9874-395',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000007',
                'nama_perusahaan' => 'ZULCHA MINTACHUS SANIA',
                'nama_usaha' => 'C-16',
                'alamat_perusahaan' => 'Jl. Margomulyo Indah Blok C No. 16',
                'modal_usaha' => 35000000,
                'no_telephone' => '6281330000007',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624601',
                'no_proyek' => '202504-2908-5233-9874-396',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000008',
                'nama_perusahaan' => 'PT GUDANG SUKSES',
                'nama_usaha' => 'Gudang penyimpanan',
                'alamat_perusahaan' => 'Jl. Raya Gubeng No. 45 Surabaya',
                'modal_usaha' => 150000000,
                'no_telephone' => '6281330000008',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624602',
                'no_proyek' => '202504-2908-5233-9874-397',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000009',
                'nama_perusahaan' => 'UD PERGUDANGAN SENTOSA',
                'nama_usaha' => 'PERGUDANGAN SENTOSA',
                'alamat_perusahaan' => 'Jl. Kenjeran No. 200 Surabaya',
                'modal_usaha' => 80000000,
                'no_telephone' => '6281330000009',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624603',
                'no_proyek' => '202504-2908-5233-9874-398',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000010',
                'nama_perusahaan' => 'CV GUDANG MANDIRI',
                'nama_usaha' => 'Gudang dan Penyimpanan',
                'alamat_perusahaan' => 'Jl. Rungkut Industri No. 88 Surabaya',
                'modal_usaha' => 120000000,
                'no_telephone' => '6281330000010',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624604',
                'no_proyek' => '202504-2908-5233-9874-399',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000011',
                'nama_perusahaan' => 'PT WAREHOUSE JAYA',
                'nama_usaha' => 'Warehouse Jaya',
                'alamat_perusahaan' => 'Jl. Margomulyo Indah Blok D No. 20',
                'modal_usaha' => 200000000,
                'no_telephone' => '6281330000011',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624605',
                'no_proyek' => '202504-2908-5233-9874-400',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000012',
                'nama_perusahaan' => 'UD GUDANG SEJAHTERA',
                'nama_usaha' => 'Gudang Sejahtera',
                'alamat_perusahaan' => 'Jl. Kenjeran No. 300 Surabaya',
                'modal_usaha' => 60000000,
                'no_telephone' => '6281330000012',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624606',
                'no_proyek' => '202504-2908-5233-9874-401',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000013',
                'nama_perusahaan' => 'PT LOGISTIK SUKSES',
                'nama_usaha' => 'Logistik Sukses',
                'alamat_perusahaan' => 'Jl. Rungkut Industri No. 100 Surabaya',
                'modal_usaha' => 180000000,
                'no_telephone' => '6281330000013',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624607',
                'no_proyek' => '202504-2908-5233-9874-402',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000014',
                'nama_perusahaan' => 'CV GUDANG UTAMA',
                'nama_usaha' => 'Gudang Utama',
                'alamat_perusahaan' => 'Jl. Margomulyo Indah Blok E No. 25',
                'modal_usaha' => 90000000,
                'no_telephone' => '6281330000014',
                'pengembalian' => '2025-05-05',
            ],
            [
                'no_permohonan' => 'I-202504291626428624608',
                'no_proyek' => '202504-2908-5233-9874-403',
                'tanggal_permohonan' => '2025-05-02',
                'nib' => '8120210000015',
                'nama_perusahaan' => 'UD WAREHOUSE MANDIRI',
                'nama_usaha' => 'Warehouse Mandiri',
                'alamat_perusahaan' => 'Jl. Kenjeran No. 400 Surabaya',
                'modal_usaha' => 70000000,
                'no_telephone' => '6281330000015',
                'pengembalian' => '2025-05-02', // Satu data dengan tanggal berbeda
            ],
        ];

        // Status distribution sesuai permintaan
        $statuses = ['Diterima', 'Dikembalikan', 'Ditolak', 'Terlambat'];
        $statusCounts = [5, 7, 3, 2]; // Total 17 data

        $statusIndex = 0;
        $currentStatusCount = 0;

        foreach ($data as $index => $item) {
            // Tentukan status berdasarkan distribusi
            if ($currentStatusCount >= $statusCounts[$statusIndex]) {
                $statusIndex++;
                $currentStatusCount = 0;
            }
            $status = $statuses[$statusIndex];
            $currentStatusCount++;

            // Tentukan jenis perusahaan berdasarkan nama
            $jenisPelakuUsaha = (strpos($item['nama_perusahaan'], 'PT') === 0 || strpos($item['nama_perusahaan'], 'CV') === 0 || strpos($item['nama_perusahaan'], 'UD') === 0) 
                ? 'Badan Usaha' 
                : 'Orang Perseorangan';

            // Tentukan skala usaha berdasarkan modal
            $skalaUsaha = $item['modal_usaha'] >= 100000000 ? 'Kecil' : 'Mikro';

            Permohonan::create([
                'user_id' => $users->random()->id,
                'no_permohonan' => $item['no_permohonan'],
                'nama_usaha' => $item['nama_usaha'],
                'nama_perusahaan' => $item['nama_perusahaan'],
                'jenis_pelaku_usaha' => $jenisPelakuUsaha,
                'nib' => $item['nib'],
                'alamat_perusahaan' => $item['alamat_perusahaan'],
                'sektor' => 'PERDAGANGAN', // Semua data di gambar adalah PERDAGANGAN
                'kbli' => '52101', // Semua data di gambar adalah 52101
                'inputan_teks' => 'Pergudangan dan Penyimpanan', // Semua data di gambar sama
                'modal_usaha' => $item['modal_usaha'],
                'jenis_proyek' => 'Utama', // Semua data di gambar adalah Utama
                'no_proyek' => $item['no_proyek'],
                'nama_perizinan' => 'Tanda Daftar Gudang', // Semua data di gambar sama
                'skala_usaha' => $skalaUsaha,
                'risiko' => 'Rendah', // Semua data di gambar adalah Rendah
                'jangka_waktu' => 2, // Semua data di gambar adalah 2 Hari
                'no_telephone' => $item['no_telephone'],
                'deadline' => Carbon::parse($item['tanggal_permohonan'])->addDays(2)->format('Y-m-d'), // 2 hari kerja setelah permohonan
                'tanggal_permohonan' => $item['tanggal_permohonan'],
                'verifikasi_pd_teknis' => 'File Approved', // Semua data di gambar sama
                'verifikasi_dpmptsp' => 'File Approved', // Semua data di gambar sama
                'status' => $status,
                'verifikator' => $verifikatorOptions[array_rand($verifikatorOptions)], // Random verifikator
                'pengembalian' => $item['pengembalian'],
                'keterangan_pengembalian' => $status === 'Dikembalikan' ? 'Dokumen perlu perbaikan' : null,
            ]);
        }

        $this->command->info('Image-based permohonan data created successfully!');
        $this->command->info('Total permohonan created: ' . Permohonan::count());
        $this->command->info('Diterima: ' . Permohonan::where('status', 'Diterima')->count());
        $this->command->info('Dikembalikan: ' . Permohonan::where('status', 'Dikembalikan')->count());
        $this->command->info('Ditolak: ' . Permohonan::where('status', 'Ditolak')->count());
        $this->command->info('Terlambat: ' . Permohonan::where('status', 'Terlambat')->count());
    }
}
