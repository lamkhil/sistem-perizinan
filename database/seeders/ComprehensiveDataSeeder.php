<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permohonan;
use App\Models\PenerbitanBerkas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComprehensiveDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('penerbitan_berkas')->delete();
        DB::table('permohonans')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->error('❌ Tidak ada user di database. Jalankan UserSeeder terlebih dahulu!');
            return;
        }

        $dpmptspUser = $users->where('role', 'dpmptsp')->first();
        $pdTeknisUsers = $users->where('role', 'pd_teknis');
        $penerbitanUser = $users->where('role', 'penerbitan_berkas')->first();

        if (!$dpmptspUser) {
            $this->command->error('❌ User DPMPTSP tidak ditemukan! Pastikan UserSeeder sudah dijalankan.');
            return;
        }
        if (!$penerbitanUser) {
            $this->command->error('❌ User Penerbitan Berkas tidak ditemukan! Pastikan UserSeeder sudah dijalankan.');
            return;
        }
        
        // Pastikan user yang digunakan memiliki email_verified_at
        if (!$dpmptspUser->email_verified_at) {
            $dpmptspUser->email_verified_at = now();
            $dpmptspUser->save();
        }
        if (!$penerbitanUser->email_verified_at) {
            $penerbitanUser->email_verified_at = now();
            $penerbitanUser->save();
        }

        $sektorList = ['Dinkopdag', 'Disbudpar', 'Dinkes', 'Dishub', 'Dprkpp', 'Dkpp', 'Dlh', 'Disperinaker'];
        $jenisPelakuUsaha = ['Orang Perseorangan', 'Badan Usaha'];
        $jenisBadanUsaha = ['PT', 'CV', 'UD', 'Firma', 'Koperasi', 'Persero'];
        $jenisProyek = ['Utama', 'Pendukung', 'Pendukung UMKU', 'Kantor Cabang'];
        $skalaUsaha = ['Mikro', 'Usaha Kecil', 'Usaha Menengah', 'Usaha Besar'];
        $risiko = ['Rendah', 'Menengah Rendah', 'Menengah Tinggi', 'Tinggi'];
        $statusPermohonan = ['Menunggu', 'Dikembalikan', 'Diterima', 'Ditolak', 'Terlambat'];
        $statusPenerbitan = ['Menunggu', 'Dikembalikan', 'Diterima', 'Ditolak'];

        $permohonans = [];

        for ($i = 1; $i <= 10; $i++) {
            $sektor = $sektorList[array_rand($sektorList)];
            $pdTeknisUser = $pdTeknisUsers->where('sektor', $sektor)->first() ?? $pdTeknisUsers->random();
            
            $jenisPelaku = $jenisPelakuUsaha[array_rand($jenisPelakuUsaha)];
            $jenisBadan = ($jenisPelaku === 'Badan Usaha') ? $jenisBadanUsaha[array_rand($jenisBadanUsaha)] : null;

            $tanggalPermohonan = Carbon::now()->subDays(rand(1, 60));
            $jangkaWaktu = rand(7, 30);
            $deadline = $tanggalPermohonan->copy()->addDays($jangkaWaktu);
            
            $status = $statusPermohonan[array_rand($statusPermohonan)];
            
            $noPermohonan = 'PMH-' . str_pad($i, 6, '0', STR_PAD_LEFT) . '/' . date('Y');
            $noProyek = 'PRJ-' . str_pad($i, 4, '0', STR_PAD_LEFT) . '-' . date('Y');

            $permohonan = Permohonan::create([
                'user_id' => $dpmptspUser->id,
                'no_permohonan' => $noPermohonan,
                'nama_usaha' => "Usaha " . $this->getNamaUsaha($i),
                'nama_perusahaan' => ($jenisPelaku === 'Badan Usaha') ? $jenisBadan . ' ' . $this->getNamaUsaha($i) : null,
                'pemilik' => $this->getNamaPemilik($i),
                'jenis_perusahaan' => $jenisPelaku,
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisBadan,
                'nik' => $this->generateNIK(),
                'tanggal_permohonan' => $tanggalPermohonan,
                'nib' => $this->generateNIB(),
                'alamat_perusahaan' => $this->getAlamat($i),
                'sektor' => $sektor,
                'kbli' => $this->generateKBLI(),
                'inputan_teks' => $this->getInputanTeks($i),
                'modal_usaha' => rand(50000000, 5000000000),
                'jenis_proyek' => $jenisProyek[array_rand($jenisProyek)],
                'no_proyek' => $noProyek,
                'nama_perizinan' => $this->getNamaPerizinan($i),
                'skala_usaha' => $skalaUsaha[array_rand($skalaUsaha)],
                'risiko' => $risiko[array_rand($risiko)],
                'jangka_waktu' => $jangkaWaktu,
                'no_telephone' => $this->generatePhone(),
                'deadline' => $deadline,
                'verifikator' => $pdTeknisUser->name,
                'verifikasi_dpmptsp' => ($status !== 'Menunggu') ? ($status === 'Diterima' ? 'Disetujui' : 'Ditolak') : null,
                'verifikasi_pd_teknis' => ($status !== 'Menunggu' && $status !== 'Dikembalikan') ? 'Telah Diverifikasi' : null,
                'status' => $status,
                'pengembalian' => ($status === 'Dikembalikan') ? $tanggalPermohonan->copy()->addDays(rand(1, 5)) : null,
                'keterangan_pengembalian' => ($status === 'Dikembalikan') ? $this->getKeteranganPengembalian($i) : null,
                'menghubungi' => ($status === 'Menunggu' || $status === 'Dikembalikan') ? $tanggalPermohonan->copy()->addDays(rand(6, 10)) : null,
                'keterangan_menghubungi' => ($status === 'Menunggu' || $status === 'Dikembalikan') ? 'Sudah dihubungi untuk konfirmasi' : null,
                'status_menghubungi' => ($status === 'Menunggu' || $status === 'Dikembalikan') ? 'Sudah Dihubungi' : null,
                'perbaikan' => ($status === 'Dikembalikan') ? $tanggalPermohonan->copy()->addDays(rand(11, 15)) : null,
                'keterangan_perbaikan' => ($status === 'Dikembalikan') ? 'Berkas telah diperbaiki sesuai catatan' : null,
                'terbit' => ($status === 'Diterima') ? $tanggalPermohonan->copy()->addDays(rand(20, $jangkaWaktu)) : null,
                'keterangan_terbit' => ($status === 'Diterima') ? 'Izin telah diterbitkan' : null,
                'pemroses_dan_tgl_surat' => ($status === 'Diterima') ? $pdTeknisUser->name . ' / ' . Carbon::now()->format('d-m-Y') : null,
                'keterangan' => $this->getKeterangan($i, $status),
            ]);

            $permohonans[] = $permohonan;
        }

        for ($i = 1; $i <= 10; $i++) {
            $permohonan = $permohonans[($i - 1) % count($permohonans)];
            
            $jenisPelaku = $jenisPelakuUsaha[array_rand($jenisPelakuUsaha)];
            $jenisBadan = ($jenisPelaku === 'Badan Usaha') ? $jenisBadanUsaha[array_rand($jenisBadanUsaha)] : null;

            $status = $statusPenerbitan[array_rand($statusPenerbitan)];
            $tanggalBAP = Carbon::now()->subDays(rand(1, 30));
            $nomorBAP = 'BAP-' . str_pad($i, 5, '0', STR_PAD_LEFT) . '/' . date('Y');

            PenerbitanBerkas::create([
                'user_id' => $penerbitanUser->id,
                'permohonan_id' => $permohonan->id,
                'no_permohonan' => 'PB-' . str_pad($i, 6, '0', STR_PAD_LEFT) . '/' . date('Y'),
                'no_proyek' => $permohonan->no_proyek,
                'tanggal_permohonan' => $permohonan->tanggal_permohonan,
                'nib' => $permohonan->nib,
                'kbli' => $permohonan->kbli,
                'nama_usaha' => $permohonan->nama_usaha,
                'inputan_teks' => $permohonan->inputan_teks,
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisBadan,
                'pemilik' => $permohonan->pemilik,
                'modal_usaha' => $permohonan->modal_usaha,
                'alamat' => $this->getAlamat($i),
                'alamat_perusahaan' => $permohonan->alamat_perusahaan,
                'kegiatan' => $this->getKegiatan($i),
                'jenis_proyek' => $permohonan->jenis_proyek,
                'nama_perizinan' => $permohonan->nama_perizinan,
                'skala_usaha' => $permohonan->skala_usaha,
                'risiko' => $permohonan->risiko,
                'status' => $status,
                'pemroses_dan_tgl_surat' => ($status === 'Diterima') ? $penerbitanUser->name . ' / ' . Carbon::now()->format('d-m-Y') : null,
                'nomor_bap' => $nomorBAP,
                'tanggal_bap' => $tanggalBAP,
            ]);
        }

        $this->command->info('✅ 10 data Permohonan berhasil dibuat dengan variasi lengkap!');
        $this->command->info('✅ 10 data Penerbitan Berkas berhasil dibuat dengan variasi lengkap!');
    }

    private function getNamaUsaha($index): string
    {
        $nama = [
            'Surya Makmur', 'Bintang Jaya', 'Cahaya Abadi', 'Maju Bersama', 'Sejahtera Mandiri',
            'Karya Indah', 'Harmoni Sejahtera', 'Berkah Jaya', 'Sukses Makmur', 'Prima Sejahtera'
        ];
        return $nama[($index - 1) % count($nama)];
    }

    private function getNamaPemilik($index): string
    {
        $nama = [
            'Budi Santoso', 'Siti Nurhaliza', 'Ahmad Hidayat', 'Dewi Sartika', 'Rudi Hartono',
            'Maya Sari', 'Indra Gunawan', 'Ratna Dewi', 'Agus Setiawan', 'Lina Wijaya'
        ];
        return $nama[($index - 1) % count($nama)];
    }

    private function getAlamat($index): string
    {
        $alamat = [
            'Jl. Raya Darmo No. 123, Surabaya',
            'Jl. Diponegoro No. 45, Surabaya',
            'Jl. Pemuda No. 78, Surabaya',
            'Jl. Gubeng Raya No. 12, Surabaya',
            'Jl. Ahmad Yani No. 234, Surabaya',
            'Jl. Tunjungan No. 56, Surabaya',
            'Jl. Basuki Rahmat No. 89, Surabaya',
            'Jl. Mayjen Sungkono No. 34, Surabaya',
            'Jl. Raya Kupang No. 67, Surabaya',
            'Jl. HR Muhammad No. 90, Surabaya'
        ];
        return $alamat[($index - 1) % count($alamat)];
    }

    private function getNamaPerizinan($index): string
    {
        $perizinan = [
            'Izin Usaha Mikro Kecil (IUMK)',
            'Izin Mendirikan Bangunan (IMB)',
            'Izin Gangguan (HO)',
            'Izin Usaha Perdagangan (SIUP)',
            'Izin Tempat Usaha (ITU)',
            'Izin Usaha Jasa Konstruksi',
            'Izin Usaha Pariwisata',
            'Izin Usaha Kesehatan',
            'Izin Usaha Transportasi',
            'Izin Usaha Perindustrian'
        ];
        return $perizinan[($index - 1) % count($perizinan)];
    }

    private function getInputanTeks($index): string
    {
        $teks = [
            'Usaha perdagangan umum dengan fokus pada produk kebutuhan sehari-hari',
            'Jasa konstruksi untuk pembangunan rumah dan gedung',
            'Usaha pariwisata dengan paket wisata dalam dan luar kota',
            'Klinik kesehatan dengan layanan umum dan spesialis',
            'Usaha transportasi dengan armada kendaraan pribadi',
            'Industri pengolahan makanan dan minuman',
            'Usaha retail dengan sistem franchise',
            'Jasa konsultasi bisnis dan manajemen',
            'Usaha kuliner dengan konsep modern',
            'Industri tekstil dan garmen'
        ];
        return $teks[($index - 1) % count($teks)];
    }

    private function getKeteranganPengembalian($index): string
    {
        $keterangan = [
            'Dokumen NIB belum lengkap, harap dilengkapi',
            'Surat keterangan domisili belum ada',
            'Foto lokasi usaha belum disertakan',
            'NPWP belum dilampirkan',
            'Surat izin lingkungan belum ada',
            'Dokumen tanah/bangunan belum lengkap',
            'Surat pernyataan belum ditandatangani',
            'Dokumen identitas pemilik belum jelas',
            'Lampiran dokumen pendukung kurang lengkap',
            'Surat rekomendasi dari kelurahan belum ada'
        ];
        return $keterangan[($index - 1) % count($keterangan)];
    }

    private function getKeterangan($index, $status): string
    {
        if ($status === 'Diterima') {
            return 'Permohonan telah disetujui dan izin telah diterbitkan';
        } elseif ($status === 'Ditolak') {
            return 'Permohonan ditolak karena tidak memenuhi persyaratan';
        } elseif ($status === 'Dikembalikan') {
            return 'Permohonan dikembalikan untuk perbaikan dokumen';
        } elseif ($status === 'Terlambat') {
            return 'Permohonan melewati batas waktu yang ditentukan';
        }
        return 'Permohonan sedang dalam proses verifikasi';
    }

    private function getKegiatan($index): string
    {
        $kegiatan = [
            'Perdagangan Barang dan Jasa',
            'Konstruksi Bangunan',
            'Pariwisata dan Perhotelan',
            'Pelayanan Kesehatan',
            'Transportasi dan Logistik',
            'Industri Pengolahan',
            'Retail dan Distribusi',
            'Konsultasi dan Jasa Profesional',
            'Kuliner dan Restoran',
            'Industri Kreatif'
        ];
        return $kegiatan[($index - 1) % count($kegiatan)];
    }

    private function generateNIK(): string
    {
        return '35' . str_pad(rand(1, 99999999999999), 14, '0', STR_PAD_LEFT);
    }

    private function generateNIB(): string
    {
        return rand(100000000000, 999999999999);
    }

    private function generateKBLI(): string
    {
        return rand(10000, 99999) . '.' . rand(10, 99);
    }

    private function generatePhone(): string
    {
        return '08' . rand(100000000, 999999999);
    }
}

