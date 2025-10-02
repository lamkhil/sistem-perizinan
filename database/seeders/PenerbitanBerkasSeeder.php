<?php

namespace Database\Seeders;

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
        // Ambil user untuk testing
        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        $this->command->info('Creating penerbitan berkas data (approved applications ready for document issuance)...');

        // Data penerbitan berkas - permohonan yang sudah disetujui dan siap diterbitkan dokumennya
        $data = [
            [
                'no_permohonan' => 'PB-202501001',
                'no_proyek' => 'PROJ-PB-001',
                'tanggal_permohonan' => '2025-01-10',
                'nib' => 'NIB-PB-001',
                'kbli' => 'KBLI-PB-001',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'nama_perusahaan' => 'PT. SIAP TERBIT DOKUMEN',
                'nama_usaha' => 'PT. SIAP TERBIT DOKUMEN',
                'alamat_perusahaan' => 'Jl. Raya Pergudangan No. 1, Surabaya',
                'modal_usaha' => 2000000000,
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
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/I/PARKIR-001/436.7.15/2025' . "\n" .
                                          'Tanggal BAP: 10 Januari 2025',
            ],
            [
                'no_permohonan' => 'PB-202501002',
                'no_proyek' => 'PROJ-PB-002',
                'tanggal_permohonan' => '2025-01-11',
                'nib' => 'NIB-PB-002',
                'kbli' => 'KBLI-PB-002',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'CV',
                'nama_perusahaan' => 'CV. DOKUMEN LENGKAP SIAP',
                'nama_usaha' => 'CV. DOKUMEN LENGKAP SIAP',
                'alamat_perusahaan' => 'Jl. Margomulyo Indah Blok A No. 5, Surabaya',
                'modal_usaha' => 1500000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Menengah',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Disbudpar',
                'status' => 'Diterima',
                'verifikator' => 'Budi Santoso, S.E.',
                'verifikasi_pd_teknis' => 'Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/I/PARKIR-002/436.7.15/2025' . "\n" .
                                          'Tanggal BAP: 11 Januari 2025',
            ],
            [
                'no_permohonan' => 'PB-202501003',
                'no_proyek' => 'PROJ-PB-003',
                'tanggal_permohonan' => '2025-01-12',
                'nib' => 'NIB-PB-003',
                'kbli' => 'KBLI-PB-003',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'UD',
                'nama_perusahaan' => 'UD. SIAP CETAK SURAT',
                'nama_usaha' => 'UD. SIAP CETAK SURAT',
                'alamat_perusahaan' => 'Jl. Tambak Langon Indah No. 10, Surabaya',
                'modal_usaha' => 800000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Kecil',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Dinkes',
                'status' => 'Diterima',
                'verifikator' => 'Citra Dewi, S.H.',
                'verifikasi_pd_teknis' => 'Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/I/PARKIR-003/436.7.15/2025' . "\n" .
                                          'Tanggal BAP: 12 Januari 2025',
            ],
            [
                'no_permohonan' => 'PB-202501004',
                'no_proyek' => 'PROJ-PB-004',
                'tanggal_permohonan' => '2025-01-13',
                'nib' => 'NIB-PB-004',
                'kbli' => 'KBLI-PB-004',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'nama_perusahaan' => 'PT. FINAL APPROVAL SIAP',
                'nama_usaha' => 'PT. FINAL APPROVAL SIAP',
                'alamat_perusahaan' => 'Jl. Kenjeran 516 Kav. 15, Surabaya',
                'modal_usaha' => 3000000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Besar',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Dishub',
                'status' => 'Diterima',
                'verifikator' => 'Dedi Kurniawan, S.T.',
                'verifikasi_pd_teknis' => 'Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/I/PARKIR-004/436.7.15/2025' . "\n" .
                                          'Tanggal BAP: 13 Januari 2025',
            ],
            [
                'no_permohonan' => 'PB-202501005',
                'no_proyek' => 'PROJ-PB-005',
                'tanggal_permohonan' => '2025-01-14',
                'nib' => 'NIB-PB-005',
                'kbli' => 'KBLI-PB-005',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'CV',
                'nama_perusahaan' => 'CV. READY TO PRINT',
                'nama_usaha' => 'CV. READY TO PRINT',
                'alamat_perusahaan' => 'Jl. Margomulyo Permai VIII/Blok R.10, Surabaya',
                'modal_usaha' => 1200000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Menengah',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Dprkpp',
                'status' => 'Diterima',
                'verifikator' => 'Eka Putri, S.E.',
                'verifikasi_pd_teknis' => 'Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/I/PARKIR-005/436.7.15/2025' . "\n" .
                                          'Tanggal BAP: 14 Januari 2025',
            ],
            [
                'no_permohonan' => 'PB-202501006',
                'no_proyek' => 'PROJ-PB-006',
                'tanggal_permohonan' => '2025-01-15',
                'nib' => 'NIB-PB-006',
                'kbli' => 'KBLI-PB-006',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'UD',
                'nama_perusahaan' => 'UD. APPROVED DOCUMENT',
                'nama_usaha' => 'UD. APPROVED DOCUMENT',
                'alamat_perusahaan' => 'Jl. Romokalisari Industri Sentosa 1/25, Surabaya',
                'modal_usaha' => 600000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Kecil',
                'risiko' => 'Rendah',
                'jangka_waktu' => 2,
                'sektor' => 'Dkpp',
                'status' => 'Diterima',
                'verifikator' => 'Fajar Nugroho, S.T.',
                'verifikasi_pd_teknis' => 'Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/I/PARKIR-006/436.7.15/2025' . "\n" .
                                          'Tanggal BAP: 15 Januari 2025',
            ],
            [
                'no_permohonan' => 'PB-202501007',
                'no_proyek' => 'PROJ-PB-007',
                'tanggal_permohonan' => '2025-01-16',
                'nib' => 'NIB-PB-007',
                'kbli' => 'KBLI-PB-007',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'nama_perusahaan' => 'PT. COMPLETE PACKAGE',
                'nama_usaha' => 'PT. COMPLETE PACKAGE',
                'alamat_perusahaan' => 'Jl. Kedinding Tengah Jaya II No. 50, Surabaya',
                'modal_usaha' => 2500000000,
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
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/I/PARKIR-007/436.7.15/2025' . "\n" .
                                          'Tanggal BAP: 16 Januari 2025',
            ],
            [
                'no_permohonan' => 'PB-202501008',
                'no_proyek' => 'PROJ-PB-008',
                'tanggal_permohonan' => '2025-01-17',
                'nib' => 'NIB-PB-008',
                'kbli' => 'KBLI-PB-008',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'CV',
                'nama_perusahaan' => 'CV. FINAL DOCUMENT',
                'nama_usaha' => 'CV. FINAL DOCUMENT',
                'alamat_perusahaan' => 'Jl. Margomulyo Jaya Blok C-20, Surabaya',
                'modal_usaha' => 1800000000,
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
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/I/PARKIR-008/436.7.15/2025' . "\n" .
                                          'Tanggal BAP: 17 Januari 2025',
            ],
            [
                'no_permohonan' => 'PB-202501009',
                'no_proyek' => 'PROJ-PB-009',
                'tanggal_permohonan' => '2025-01-18',
                'nib' => 'NIB-PB-009',
                'kbli' => 'KBLI-PB-009',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'UD',
                'nama_perusahaan' => 'UD. READY FOR ISSUANCE',
                'nama_usaha' => 'UD. READY FOR ISSUANCE',
                'alamat_perusahaan' => 'Jl. Gunung Anyar Tambak III No. 30, Surabaya',
                'modal_usaha' => 700000000,
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
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/I/PARKIR-009/436.7.15/2025' . "\n" .
                                          'Tanggal BAP: 18 Januari 2025',
            ],
            [
                'no_permohonan' => 'PB-202501010',
                'no_proyek' => 'PROJ-PB-010',
                'tanggal_permohonan' => '2025-01-19',
                'nib' => 'NIB-PB-010',
                'kbli' => 'KBLI-PB-010',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'nama_perusahaan' => 'PT. APPROVED FOR PRINT',
                'nama_usaha' => 'PT. APPROVED FOR PRINT',
                'alamat_perusahaan' => 'Jl. Kyai Tambak Deres No. 8, Surabaya',
                'modal_usaha' => 2200000000,
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
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/I/PARKIR-010/436.7.15/2025' . "\n" .
                                          'Tanggal BAP: 19 Januari 2025',
            ],
        ];

        // Buat data penerbitan berkas
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
                'no_telephone' => '0812345679' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'deadline' => Carbon::parse($item['tanggal_permohonan'])->addDays(30),
                'verifikator' => $item['verifikator'],
                'verifikasi_dpmptsp' => $item['verifikasi_dpmptsp'],
                'verifikasi_pd_teknis' => $item['verifikasi_pd_teknis'],
                'pemroses_dan_tgl_surat' => $item['pemroses_dan_tgl_surat'],
                'status' => $item['status'],
                'user_id' => $user->id,
                'created_at' => Carbon::parse($item['tanggal_permohonan']),
                'updated_at' => Carbon::parse($item['tanggal_permohonan']),
            ]);
        }

        $this->command->info('Created 10 penerbitan berkas records:');
        $this->command->info('- All status: Diterima (approved and ready for document issuance)');
        $this->command->info('- Sektor: Various (Dinkopdag, Disbudpar, Dinkes, etc.)');
        $this->command->info('- KBLI: Pergudangan dan Penyimpanan');
        $this->command->info('- Nama Perizinan: Tanda Daftar Gudang');
        $this->command->info('- Jangka Waktu: 2 Hari');
        $this->command->info('- Format: Clean format for export without issues');
        $this->command->info('- Pemroses: Complete document processing information with BAP numbers');
        $this->command->info('- Purpose: These are applications that have been approved and are ready for document issuance');
    }
}