<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permohonan;
use App\Models\User;
use Carbon\Carbon;

class PermohonanBaruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user untuk testing
        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        $this->command->info('Creating permohonan baru data with various statuses...');

        // Data permohonan baru dengan berbagai status
        $data = [
            // Data dengan status Diterima
            [
                'no_permohonan' => 'PM-202501001',
                'no_proyek' => 'PROJ-PM-001',
                'tanggal_permohonan' => '2025-01-15',
                'nib' => 'NIB-PM-001',
                'kbli' => 'KBLI-PM-001',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'nama_perusahaan' => 'PT. USAHA BARU SUKSES',
                'nama_usaha' => 'PT. USAHA BARU SUKSES',
                'alamat_perusahaan' => 'Jl. Raya Industri No. 1, Surabaya',
                'modal_usaha' => 1500000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Menengah',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Dinkopdag',
                'status' => 'Diterima',
                'verifikator' => 'Ahmad Wijaya, S.T.',
                'verifikasi_pd_teknis' => 'Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
            ],
            [
                'no_permohonan' => 'PM-202501002',
                'no_proyek' => 'PROJ-PM-002',
                'tanggal_permohonan' => '2025-01-16',
                'nib' => 'NIB-PM-002',
                'kbli' => 'KBLI-PM-002',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'CV',
                'nama_perusahaan' => 'CV. BISNIS MANDIRI',
                'nama_usaha' => 'CV. BISNIS MANDIRI',
                'alamat_perusahaan' => 'Jl. Margomulyo Indah Blok B No. 10, Surabaya',
                'modal_usaha' => 800000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Kecil',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Disbudpar',
                'status' => 'Diterima',
                'verifikator' => 'Budi Santoso, S.E.',
                'verifikasi_pd_teknis' => 'Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
            ],
            // Data dengan status Dikembalikan
            [
                'no_permohonan' => 'PM-202501003',
                'no_proyek' => 'PROJ-PM-003',
                'tanggal_permohonan' => '2025-01-17',
                'nib' => 'NIB-PM-003',
                'kbli' => 'KBLI-PM-003',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'UD',
                'nama_perusahaan' => 'UD. PERLU PERBAIKAN',
                'nama_usaha' => 'UD. PERLU PERBAIKAN',
                'alamat_perusahaan' => 'Jl. Tambak Langon Indah No. 5, Surabaya',
                'modal_usaha' => 500000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Kecil',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Dinkes',
                'status' => 'Dikembalikan',
                'verifikator' => 'Citra Dewi, S.H.',
                'verifikasi_pd_teknis' => 'Berkas Diperbaiki',
                'verifikasi_dpmptsp' => 'Perlu Perbaikan',
            ],
            [
                'no_permohonan' => 'PM-202501004',
                'no_proyek' => 'PROJ-PM-004',
                'tanggal_permohonan' => '2025-01-18',
                'nib' => 'NIB-PM-004',
                'kbli' => 'KBLI-PM-004',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'nama_perusahaan' => 'PT. REVISI DOKUMEN',
                'nama_usaha' => 'PT. REVISI DOKUMEN',
                'alamat_perusahaan' => 'Jl. Kenjeran 516 Kav. 20, Surabaya',
                'modal_usaha' => 1200000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Menengah',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Dishub',
                'status' => 'Dikembalikan',
                'verifikator' => 'Dedi Kurniawan, S.T.',
                'verifikasi_pd_teknis' => 'Berkas Diperbaiki',
                'verifikasi_dpmptsp' => 'Perlu Perbaikan',
            ],
            // Data dengan status Ditolak
            [
                'no_permohonan' => 'PM-202501005',
                'no_proyek' => 'PROJ-PM-005',
                'tanggal_permohonan' => '2025-01-19',
                'nib' => 'NIB-PM-005',
                'kbli' => 'KBLI-PM-005',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'CV',
                'nama_perusahaan' => 'CV. TIDAK MEMENUHI SYARAT',
                'nama_usaha' => 'CV. TIDAK MEMENUHI SYARAT',
                'alamat_perusahaan' => 'Jl. Margomulyo Permai VIII/Blok R.5, Surabaya',
                'modal_usaha' => 300000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Kecil',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Dprkpp',
                'status' => 'Ditolak',
                'verifikator' => 'Eka Putri, S.E.',
                'verifikasi_pd_teknis' => 'Ditolak',
                'verifikasi_dpmptsp' => 'Ditolak',
            ],
            [
                'no_permohonan' => 'PM-202501006',
                'no_proyek' => 'PROJ-PM-006',
                'tanggal_permohonan' => '2025-01-20',
                'nib' => 'NIB-PM-006',
                'kbli' => 'KBLI-PM-006',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'UD',
                'nama_perusahaan' => 'UD. LOKASI TIDAK SESUAI',
                'nama_usaha' => 'UD. LOKASI TIDAK SESUAI',
                'alamat_perusahaan' => 'Jl. Romokalisari Industri Sentosa 1/15, Surabaya',
                'modal_usaha' => 400000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Kecil',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Dkpp',
                'status' => 'Ditolak',
                'verifikator' => 'Fajar Nugroho, S.T.',
                'verifikasi_pd_teknis' => 'Ditolak',
                'verifikasi_dpmptsp' => 'Ditolak',
            ],
            // Data dengan status Diterima (lebih banyak)
            [
                'no_permohonan' => 'PM-202501007',
                'no_proyek' => 'PROJ-PM-007',
                'tanggal_permohonan' => '2025-01-21',
                'nib' => 'NIB-PM-007',
                'kbli' => 'KBLI-PM-007',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'nama_perusahaan' => 'PT. GUDANG MAJU',
                'nama_usaha' => 'PT. GUDANG MAJU',
                'alamat_perusahaan' => 'Jl. Kedinding Tengah Jaya II No. 25, Surabaya',
                'modal_usaha' => 2000000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Besar',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Dlh',
                'status' => 'Diterima',
                'verifikator' => 'Gita Sari, S.H.',
                'verifikasi_pd_teknis' => 'Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
            ],
            [
                'no_permohonan' => 'PM-202501008',
                'no_proyek' => 'PROJ-PM-008',
                'tanggal_permohonan' => '2025-01-22',
                'nib' => 'NIB-PM-008',
                'kbli' => 'KBLI-PM-008',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'CV',
                'nama_perusahaan' => 'CV. LOGISTIK SUKSES',
                'nama_usaha' => 'CV. LOGISTIK SUKSES',
                'alamat_perusahaan' => 'Jl. Margomulyo Jaya Blok C-25, Surabaya',
                'modal_usaha' => 900000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Menengah',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Disperinaker',
                'status' => 'Diterima',
                'verifikator' => 'Hendra Pratama, S.E.',
                'verifikasi_pd_teknis' => 'Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
            ],
            [
                'no_permohonan' => 'PM-202501009',
                'no_proyek' => 'PROJ-PM-009',
                'tanggal_permohonan' => '2025-01-23',
                'nib' => 'NIB-PM-009',
                'kbli' => 'KBLI-PM-009',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'UD',
                'nama_perusahaan' => 'UD. WAREHOUSE JAYA',
                'nama_usaha' => 'UD. WAREHOUSE JAYA',
                'alamat_perusahaan' => 'Jl. Gunung Anyar Tambak III No. 35, Surabaya',
                'modal_usaha' => 600000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Kecil',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Dinkopdag',
                'status' => 'Diterima',
                'verifikator' => 'Indah Lestari, S.T.',
                'verifikasi_pd_teknis' => 'Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
            ],
            [
                'no_permohonan' => 'PM-202501010',
                'no_proyek' => 'PROJ-PM-010',
                'tanggal_permohonan' => '2025-01-24',
                'nib' => 'NIB-PM-010',
                'kbli' => 'KBLI-PM-010',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'nama_perusahaan' => 'PT. DISTRIBUSI UTAMA',
                'nama_usaha' => 'PT. DISTRIBUSI UTAMA',
                'alamat_perusahaan' => 'Jl. Kyai Tambak Deres No. 12, Surabaya',
                'modal_usaha' => 1800000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Besar',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Disbudpar',
                'status' => 'Diterima',
                'verifikator' => 'Joko Susilo, S.H.',
                'verifikasi_pd_teknis' => 'Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
            ],
        ];

        // Buat data permohonan baru
        foreach ($data as $index => $item) {
            $user = $users->random();
            
            Permohonan::create([
                'no_permohonan' => $item['no_permohonan'],
                'no_proyek' => $item['no_proyek'],
                'tanggal_permohonan' => $item['tanggal_permohonan'],
                'nib' => $item['nib'],
                'alamat_perusahaan' => $item['alamat_perusahaan'],
                'sektor' => $item['sektor'],
                'nama_usaha' => $item['nama_usaha'],
                'nama_perusahaan' => $item['nama_perusahaan'],
                'jenis_pelaku_usaha' => $item['jenis_pelaku_usaha'],
                'kbli' => $item['kbli'],
                'inputan_teks' => $item['inputan_teks'],
                'modal_usaha' => $item['modal_usaha'],
                'jenis_proyek' => $item['jenis_proyek'],
                'nama_perizinan' => $item['nama_perizinan'],
                'skala_usaha' => $item['skala_usaha'],
                'risiko' => $item['risiko'],
                'jangka_waktu' => $item['jangka_waktu'],
                'no_telephone' => '0812345678' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'deadline' => Carbon::parse($item['tanggal_permohonan'])->addDays(30),
                'verifikator' => $item['verifikator'],
                'verifikasi_dpmptsp' => $item['verifikasi_dpmptsp'],
                'verifikasi_pd_teknis' => $item['verifikasi_pd_teknis'],
                'status' => $item['status'],
                'user_id' => $user->id,
                'created_at' => Carbon::parse($item['tanggal_permohonan']),
                'updated_at' => Carbon::parse($item['tanggal_permohonan']),
            ]);
        }

        $this->command->info('Created 10 permohonan baru records:');
        $this->command->info('- Status Diterima: 6 records');
        $this->command->info('- Status Dikembalikan: 2 records');
        $this->command->info('- Status Ditolak: 2 records');
        $this->command->info('- Sektor: Various (Dinkopdag, Disbudpar, Dinkes, etc.)');
        $this->command->info('- KBLI: Pergudangan dan Penyimpanan');
        $this->command->info('- Nama Perizinan: Tanda Daftar Gudang');
        $this->command->info('- Jangka Waktu: 2 Hari');
        $this->command->info('- Format: Clean format for export without issues');
    }
}
