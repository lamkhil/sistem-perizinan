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

        $this->command->info('Creating penerbitan berkas data with correct format...');

        // Daftar sektor yang tersedia
        $sektors = ['Dinkopdag', 'Disbudpar', 'Dinkes', 'Dishub', 'Dprkpp', 'Dkpp', 'Dlh', 'Disperinaker'];

        // Data untuk penerbitan berkas (status Diterima dengan data lengkap)
        $data = [
            [
                'no_permohonan' => 'PB-202501001',
                'nama_usaha' => 'PT. BERKAS SIAP TERBIT',
                'sektor' => 'Dinkopdag',
                'status' => 'Diterima',
                'tanggal_permohonan' => '2025-01-01',
                'deadline' => '2025-01-31',
                'verifikator' => 'Ahmad Wijaya, S.T.',
                'verifikasi_pd_teknis' => 'Berkas Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/IX/PARKIR-341/436.7.15/' . date('Y') . "\n" .
                                          'tanggal BAP: ' . date('d'),
            ],
            [
                'no_permohonan' => 'PB-202501002',
                'nama_usaha' => 'CV. DOKUMEN LENGKAP',
                'sektor' => 'Disbudpar',
                'status' => 'Diterima',
                'tanggal_permohonan' => '2025-01-02',
                'deadline' => '2025-02-01',
                'verifikator' => 'Budi Santoso, S.E.',
                'verifikasi_pd_teknis' => 'Berkas Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/IX/PARKIR-342/436.7.15/' . date('Y') . "\n" .
                                          'tanggal BAP: ' . date('d'),
            ],
            [
                'no_permohonan' => 'PB-202501003',
                'nama_usaha' => 'UD. SIAP CETAK',
                'sektor' => 'Dinkes',
                'status' => 'Diterima',
                'tanggal_permohonan' => '2025-01-03',
                'deadline' => '2025-02-02',
                'verifikator' => 'Citra Dewi, S.H.',
                'verifikasi_pd_teknis' => 'Berkas Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/IX/PARKIR-343/436.7.15/' . date('Y') . "\n" .
                                          'tanggal BAP: ' . date('d'),
            ],
            [
                'no_permohonan' => 'PB-202501004',
                'nama_usaha' => 'PT. FINAL APPROVAL',
                'sektor' => 'Dishub',
                'status' => 'Diterima',
                'tanggal_permohonan' => '2025-01-04',
                'deadline' => '2025-02-03',
                'verifikator' => 'Dedi Kurniawan, S.T.',
                'verifikasi_pd_teknis' => 'Berkas Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/IX/PARKIR-344/436.7.15/' . date('Y') . "\n" .
                                          'tanggal BAP: ' . date('d'),
            ],
            [
                'no_permohonan' => 'PB-202501005',
                'nama_usaha' => 'CV. READY TO PRINT',
                'sektor' => 'Dprkpp',
                'status' => 'Diterima',
                'tanggal_permohonan' => '2025-01-05',
                'deadline' => '2025-02-04',
                'verifikator' => 'Eka Putri, S.E.',
                'verifikasi_pd_teknis' => 'Berkas Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/IX/PARKIR-345/436.7.15/' . date('Y') . "\n" .
                                          'tanggal BAP: ' . date('d'),
            ],
            [
                'no_permohonan' => 'PB-202501006',
                'nama_usaha' => 'UD. APPROVED DOCUMENT',
                'sektor' => 'Dkpp',
                'status' => 'Diterima',
                'tanggal_permohonan' => '2025-01-06',
                'deadline' => '2025-02-05',
                'verifikator' => 'Fajar Nugroho, S.T.',
                'verifikasi_pd_teknis' => 'Berkas Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/IX/PARKIR-346/436.7.15/' . date('Y') . "\n" .
                                          'tanggal BAP: ' . date('d'),
            ],
            [
                'no_permohonan' => 'PB-202501007',
                'nama_usaha' => 'PT. COMPLETE PACKAGE',
                'sektor' => 'Dlh',
                'status' => 'Diterima',
                'tanggal_permohonan' => '2025-01-07',
                'deadline' => '2025-02-06',
                'verifikator' => 'Gita Sari, S.H.',
                'verifikasi_pd_teknis' => 'Berkas Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/IX/PARKIR-347/436.7.15/' . date('Y') . "\n" .
                                          'tanggal BAP: ' . date('d'),
            ],
            [
                'no_permohonan' => 'PB-202501008',
                'nama_usaha' => 'CV. FINAL DOCUMENT',
                'sektor' => 'Disperinaker',
                'status' => 'Diterima',
                'tanggal_permohonan' => '2025-01-08',
                'deadline' => '2025-02-07',
                'verifikator' => 'Hendra Pratama, S.E.',
                'verifikasi_pd_teknis' => 'Berkas Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/IX/PARKIR-348/436.7.15/' . date('Y') . "\n" .
                                          'tanggal BAP: ' . date('d'),
            ],
            [
                'no_permohonan' => 'PB-202501009',
                'nama_usaha' => 'UD. READY FOR ISSUANCE',
                'sektor' => 'Dinkopdag',
                'status' => 'Diterima',
                'tanggal_permohonan' => '2025-01-09',
                'deadline' => '2025-02-08',
                'verifikator' => 'Indah Lestari, S.T.',
                'verifikasi_pd_teknis' => 'Berkas Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/IX/PARKIR-349/436.7.15/' . date('Y') . "\n" .
                                          'tanggal BAP: ' . date('d'),
            ],
            [
                'no_permohonan' => 'PB-202501010',
                'nama_usaha' => 'PT. APPROVED FOR PRINT',
                'sektor' => 'Disbudpar',
                'status' => 'Diterima',
                'tanggal_permohonan' => '2025-01-10',
                'deadline' => '2025-02-09',
                'verifikator' => 'Joko Susilo, S.H.',
                'verifikasi_pd_teknis' => 'Berkas Disetujui',
                'verifikasi_dpmptsp' => 'Disetujui',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                          'No: BAP/OSS/IX/PARKIR-350/436.7.15/' . date('Y') . "\n" .
                                          'tanggal BAP: ' . date('d'),
            ],
        ];

        // Buat data permohonan untuk penerbitan berkas
        foreach ($data as $index => $item) {
            $user = $users->random();
            
            Permohonan::create([
                'no_permohonan' => $item['no_permohonan'],
                'no_proyek' => 'PROJ-PB-' . ($index + 1), // Format sederhana untuk penerbitan berkas
                'tanggal_permohonan' => $item['tanggal_permohonan'],
                'nib' => 'NIB-PB-' . ($index + 1), // Format sederhana
                'alamat_perusahaan' => 'Jl. Penerbitan Berkas No. ' . ($index + 1),
                'sektor' => $item['sektor'],
                'kbli' => 'KBLI-PB-' . ($index + 1), // Format sederhana
                'inputan_teks' => 'Kegiatan Penerbitan ' . ($index + 1),
                'modal_usaha' => 2000000 + ($index * 1000000), // Format numerik yang benar
                'jenis_proyek' => 'Proyek Penerbitan ' . ($index + 1),
                'nama_perizinan' => 'Perizinan Penerbitan ' . ($index + 1),
                'skala_usaha' => 'Skala Penerbitan ' . ($index + 1),
                'risiko' => 'Risiko Penerbitan ' . ($index + 1),
                'jangka_waktu' => 30,
                'no_telephone' => '0812345679' . str_pad($index + 1, 2, '0', STR_PAD_LEFT), // Format yang benar
                'deadline' => $item['deadline'],
                'verifikator' => $item['verifikator'],
                'verifikasi_dpmptsp' => $item['verifikasi_dpmptsp'],
                'verifikasi_pd_teknis' => $item['verifikasi_pd_teknis'],
                'status' => $item['status'],
                'pemroses_dan_tgl_surat' => $item['pemroses_dan_tgl_surat'],
                'user_id' => $user->id,
                'created_at' => Carbon::parse($item['tanggal_permohonan']),
                'updated_at' => Carbon::parse($item['tanggal_permohonan']),
            ]);
        }

        $this->command->info('Created 10 penerbitan berkas records with correct format:');
        $this->command->info('- All status: Diterima (ready for issuance)');
        $this->command->info('- Format: Clean format without leading zeros');
        $this->command->info('- No. Permohonan: PB-202501001 to PB-202501010');
        $this->command->info('- Ready for Excel/PDF export without formatting issues');
    }
}