<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenerbitanBerkas;
use App\Models\User;
use Carbon\Carbon;

class PenerbitanBerkasTableSeeder extends Seeder
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

        $this->command->info('Creating penerbitan berkas data for penerbitan_berkas table...');

        // Data penerbitan berkas untuk tabel penerbitan_berkas
        $data = [
            [
                'no_permohonan' => 'PB-202501001',
                'no_proyek' => 'PROJ-PB-001',
                'tanggal_permohonan' => '2025-01-10',
                'nib' => 'NIB-PB-001',
                'kbli' => 'KBLI-PB-001',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'jenis_badan_usaha' => 'PT',
                'pemilik' => 'PT. SIAP TERBIT DOKUMEN',
                'nama_usaha' => 'PT. SIAP TERBIT DOKUMEN',
                'alamat_perusahaan' => 'Jl. Raya Pergudangan No. 1, Surabaya',
                'modal_usaha' => 2000000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Menengah',
                'risiko' => 'Rendah',
                'status' => 'Diterima',
            ],
            [
                'no_permohonan' => 'PB-202501002',
                'no_proyek' => 'PROJ-PB-002',
                'tanggal_permohonan' => '2025-01-11',
                'nib' => 'NIB-PB-002',
                'kbli' => 'KBLI-PB-002',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'CV',
                'jenis_badan_usaha' => 'CV',
                'pemilik' => 'CV. DOKUMEN LENGKAP SIAP',
                'nama_usaha' => 'CV. DOKUMEN LENGKAP SIAP',
                'alamat_perusahaan' => 'Jl. Margomulyo Indah Blok A No. 5, Surabaya',
                'modal_usaha' => 1500000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Menengah',
                'risiko' => 'Rendah',
                'status' => 'Diterima',
            ],
            [
                'no_permohonan' => 'PB-202501003',
                'no_proyek' => 'PROJ-PB-003',
                'tanggal_permohonan' => '2025-01-12',
                'nib' => 'NIB-PB-003',
                'kbli' => 'KBLI-PB-003',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'UD',
                'jenis_badan_usaha' => 'UD',
                'pemilik' => 'UD. SIAP CETAK SURAT',
                'nama_usaha' => 'UD. SIAP CETAK SURAT',
                'alamat_perusahaan' => 'Jl. Tambak Langon Indah No. 10, Surabaya',
                'modal_usaha' => 800000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Kecil',
                'risiko' => 'Rendah',
                'status' => 'Diterima',
            ],
            [
                'no_permohonan' => 'PB-202501004',
                'no_proyek' => 'PROJ-PB-004',
                'tanggal_permohonan' => '2025-01-13',
                'nib' => 'NIB-PB-004',
                'kbli' => 'KBLI-PB-004',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'jenis_badan_usaha' => 'PT',
                'pemilik' => 'PT. FINAL APPROVAL SIAP',
                'nama_usaha' => 'PT. FINAL APPROVAL SIAP',
                'alamat_perusahaan' => 'Jl. Kenjeran 516 Kav. 15, Surabaya',
                'modal_usaha' => 3000000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Besar',
                'risiko' => 'Rendah',
                'status' => 'Diterima',
            ],
            [
                'no_permohonan' => 'PB-202501005',
                'no_proyek' => 'PROJ-PB-005',
                'tanggal_permohonan' => '2025-01-14',
                'nib' => 'NIB-PB-005',
                'kbli' => 'KBLI-PB-005',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'CV',
                'jenis_badan_usaha' => 'CV',
                'pemilik' => 'CV. READY TO PRINT',
                'nama_usaha' => 'CV. READY TO PRINT',
                'alamat_perusahaan' => 'Jl. Margomulyo Permai VIII/Blok R.10, Surabaya',
                'modal_usaha' => 1200000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Menengah',
                'risiko' => 'Rendah',
                'status' => 'Diterima',
            ],
            [
                'no_permohonan' => 'PB-202501006',
                'no_proyek' => 'PROJ-PB-006',
                'tanggal_permohonan' => '2025-01-15',
                'nib' => 'NIB-PB-006',
                'kbli' => 'KBLI-PB-006',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'UD',
                'jenis_badan_usaha' => 'UD',
                'pemilik' => 'UD. APPROVED DOCUMENT',
                'nama_usaha' => 'UD. APPROVED DOCUMENT',
                'alamat_perusahaan' => 'Jl. Romokalisari Industri Sentosa 1/25, Surabaya',
                'modal_usaha' => 600000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Kecil',
                'risiko' => 'Rendah',
                'status' => 'Diterima',
            ],
            [
                'no_permohonan' => 'PB-202501007',
                'no_proyek' => 'PROJ-PB-007',
                'tanggal_permohonan' => '2025-01-16',
                'nib' => 'NIB-PB-007',
                'kbli' => 'KBLI-PB-007',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'jenis_badan_usaha' => 'PT',
                'pemilik' => 'PT. COMPLETE PACKAGE',
                'nama_usaha' => 'PT. COMPLETE PACKAGE',
                'alamat_perusahaan' => 'Jl. Kedinding Tengah Jaya II No. 50, Surabaya',
                'modal_usaha' => 2500000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Besar',
                'risiko' => 'Rendah',
                'status' => 'Diterima',
            ],
            [
                'no_permohonan' => 'PB-202501008',
                'no_proyek' => 'PROJ-PB-008',
                'tanggal_permohonan' => '2025-01-17',
                'nib' => 'NIB-PB-008',
                'kbli' => 'KBLI-PB-008',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'CV',
                'jenis_badan_usaha' => 'CV',
                'pemilik' => 'CV. FINAL DOCUMENT',
                'nama_usaha' => 'CV. FINAL DOCUMENT',
                'alamat_perusahaan' => 'Jl. Margomulyo Jaya Blok C-20, Surabaya',
                'modal_usaha' => 1800000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Menengah',
                'risiko' => 'Rendah',
                'status' => 'Diterima',
            ],
            [
                'no_permohonan' => 'PB-202501009',
                'no_proyek' => 'PROJ-PB-009',
                'tanggal_permohonan' => '2025-01-18',
                'nib' => 'NIB-PB-009',
                'kbli' => 'KBLI-PB-009',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'UD',
                'jenis_badan_usaha' => 'UD',
                'pemilik' => 'UD. READY FOR ISSUANCE',
                'nama_usaha' => 'UD. READY FOR ISSUANCE',
                'alamat_perusahaan' => 'Jl. Gunung Anyar Tambak III No. 30, Surabaya',
                'modal_usaha' => 700000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Kecil',
                'risiko' => 'Rendah',
                'status' => 'Diterima',
            ],
            [
                'no_permohonan' => 'PB-202501010',
                'no_proyek' => 'PROJ-PB-010',
                'tanggal_permohonan' => '2025-01-19',
                'nib' => 'NIB-PB-010',
                'kbli' => 'KBLI-PB-010',
                'inputan_teks' => 'Pergudangan dan Penyimpanan',
                'jenis_pelaku_usaha' => 'PT',
                'jenis_badan_usaha' => 'PT',
                'pemilik' => 'PT. APPROVED FOR PRINT',
                'nama_usaha' => 'PT. APPROVED FOR PRINT',
                'alamat_perusahaan' => 'Jl. Kyai Tambak Deres No. 8, Surabaya',
                'modal_usaha' => 2200000000,
                'jenis_proyek' => 'Utama',
                'nama_perizinan' => 'Tanda Daftar Gudang',
                'skala_usaha' => 'Besar',
                'risiko' => 'Rendah',
                'status' => 'Diterima',
            ],
        ];

        // Buat data penerbitan berkas untuk tabel penerbitan_berkas
        foreach ($data as $index => $item) {
            $user = $users->random();
            
            PenerbitanBerkas::create([
                'user_id' => $user->id,
                'no_permohonan' => $item['no_permohonan'],
                'no_proyek' => $item['no_proyek'],
                'tanggal_permohonan' => $item['tanggal_permohonan'],
                'nib' => $item['nib'],
                'kbli' => $item['kbli'],
                'nama_usaha' => $item['nama_usaha'],
                'inputan_teks' => $item['inputan_teks'],
                'jenis_pelaku_usaha' => $item['jenis_pelaku_usaha'],
                'jenis_badan_usaha' => $item['jenis_badan_usaha'],
                'pemilik' => $item['pemilik'],
                'modal_usaha' => $item['modal_usaha'],
                'alamat_perusahaan' => $item['alamat_perusahaan'],
                'jenis_proyek' => $item['jenis_proyek'],
                'nama_perizinan' => $item['nama_perizinan'],
                'skala_usaha' => $item['skala_usaha'],
                'risiko' => $item['risiko'],
                'status' => $item['status'],
                'created_at' => Carbon::parse($item['tanggal_permohonan']),
                'updated_at' => Carbon::parse($item['tanggal_permohonan']),
            ]);
        }

        $this->command->info('Created 10 penerbitan berkas records in penerbitan_berkas table:');
        $this->command->info('- All status: Diterima (ready for document issuance)');
        $this->command->info('- Table: penerbitan_berkas (separate from permohonans table)');
        $this->command->info('- No. Permohonan: PB-202501001 to PB-202501010');
        $this->command->info('- Format: Clean format for export without issues');
        $this->command->info('- Purpose: Data for /penerbitan-berkas page');
    }
}
