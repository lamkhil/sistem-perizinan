<?php

namespace Database\Seeders;

use App\Models\Permohonan;
use App\Models\User;
use App\Models\LogPermohonan;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class PermohonanSeeder extends Seeder
{
    private $adminUser;
    private $dpmptspUser;
    private $pdTeknisUser;

    /**
     * Helper function untuk membuat log permohonan
     */
    private function createLog($permohonanId, $userId, $action, $statusSebelum, $statusSesudah, $keterangan, $oldData = null, $newData = null, $createdAt = null)
    {
        LogPermohonan::create([
            'permohonan_id' => $permohonanId,
            'user_id' => $userId,
            'action' => $action,
            'status_sebelum' => $statusSebelum,
            'status_sesudah' => $statusSesudah,
            'keterangan' => $keterangan,
            'old_data' => $oldData ? json_encode($oldData) : null,
            'new_data' => $newData ? json_encode($newData) : null,
            'created_at' => $createdAt ?? now(),
        ]);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // HAPUS DATA LAMA
        $this->command->info('🗑️  Menghapus data permohonan dan log yang lama...');
        // Hapus log dulu karena ada foreign key ke permohonan
        LogPermohonan::query()->delete();
        Permohonan::query()->delete();
        $this->command->info('✅ Data lama berhasil dihapus!');
        
        // Ambil semua user yang bukan penerbitan_berkas
        $users = User::where('role', '!=', 'penerbitan_berkas')->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('Tidak ada user yang tersedia. Silakan jalankan UserSeeder terlebih dahulu.');
            return;
        }

        // Ambil admin, dpmptsp, dan pd_teknis user untuk log
        $this->adminUser = $users->where('role', 'admin')->first() ?? $users->first();
        $this->dpmptspUser = $users->where('role', 'dpmptsp')->first() ?? $this->adminUser;
        $this->pdTeknisUser = $users->where('role', 'pd_teknis')->first() ?? $this->adminUser;

        // Data untuk berbagai kombinasi
        $sektors = ['Dinkopdag', 'Disbudpar', 'Dinkes', 'Dishub', 'Dprkpp', 'Dkpp', 'Dlh', 'Disperinaker'];
        $jenisPelakuUsahas = ['Orang Perseorangan', 'Badan Usaha'];
        $jenisBadanUsahas = [
            'Perseroan Terbatas (PT)',
            'Perseroan Terbatas (PT) Perorangan',
            'Persekutuan Komanditer (CV/Commanditaire Vennootschap)',
            'Persekutuan Firma (FA / Venootschap Onder Firma)',
            'Persekutuan Perdata',
            'Koperasi',
            'Yayasan',
        ];
        $jenisProyeks = ['Utama', 'Pendukung', 'Pendukung UMKU', 'Kantor Cabang'];
        $skalaUsahas = ['Mikro', 'Kecil', 'Menengah', 'Besar'];
        $risikos = ['Rendah', 'Sedang', 'Tinggi'];
        $statuses = ['Menunggu', 'Dikembalikan', 'Diterima', 'Ditolak'];
        $verifikators = ['RAMLAN', 'SURYA', 'ALI', 'WILDAN A', 'TYO', 'WILDAN M', 'YOLA', 'NAURA'];
        $verifikasiStatuses = ['Berkas Disetujui', 'Berkas Diperbaiki', 'Pemohon Dihubungi', 'Berkas Diunggah Ulang', 'Pemohon Belum Dihubungi'];
        
        // Nama perusahaan Indonesia yang realistis
        $namaPerusahaan = [
            'PT. Maju Bersama Sejahtera', 'CV. Karya Mandiri', 'UD. Sumber Rezeki',
            'PT. Nusantara Jaya', 'CV. Abadi Makmur', 'PT. Sentosa Prima',
            'CV. Sejahtera Abadi', 'PT. Makmur Jaya', 'UD. Berkah Selalu',
            'PT. Cemerlang Nusantara', 'CV. Mandiri Sejahtera', 'PT. Prima Karya',
            'CV. Jaya Abadi', 'PT. Sukses Makmur', 'UD. Lancar Jaya',
            'PT. Bersama Maju', 'CV. Makmur Sentosa', 'PT. Nusantara Prima',
            'CV. Sejahtera Jaya', 'PT. Karya Mandiri', 'UD. Berkah Makmur',
            'PT. Sentosa Abadi', 'CV. Prima Sejahtera', 'PT. Maju Jaya',
            'CV. Nusantara Makmur', 'PT. Abadi Karya', 'UD. Lancar Makmur',
            'PT. Sejahtera Prima', 'CV. Mandiri Jaya', 'PT. Karya Nusantara',
        ];

        $this->command->info('Membuat data permohonan dengan memaksimalkan semua fitur...');

        $counter = 1;
        $now = Carbon::now();

        // 1. Data dengan status DITERIMA (3 data)
        for ($i = 0; $i < 3; $i++) {
            $tanggalPermohonan = $now->copy()->subDays(rand(30, 90));
            $deadline = $tanggalPermohonan->copy()->addDays(rand(5, 14));
            $terbit = $deadline->copy()->subDays(rand(1, 3));
            
            $jenisPelaku = $faker->randomElement($jenisPelakuUsahas);
            $user = $users->random();
            
            $permohonan = Permohonan::create([
                'user_id' => $user->id,
                'no_permohonan' => 'PMH-' . str_pad($counter++, 6, '0', STR_PAD_LEFT) . '/' . date('Y'),
                'nama_usaha' => $faker->randomElement($namaPerusahaan),
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisPelaku === 'Badan Usaha' ? $faker->randomElement($jenisBadanUsahas) : null,
                'nik' => $jenisPelaku === 'Orang Perseorangan' ? $faker->numerify('################') : null,
                'tanggal_permohonan' => $tanggalPermohonan,
                'nib' => $faker->numerify('#################'),
                'alamat_perusahaan' => $faker->address(),
                'sektor' => $faker->randomElement($sektors),
                'kbli' => $faker->numerify('#####'),
                'inputan_teks' => $faker->words(3, true),
                'modal_usaha' => $faker->numberBetween(50000000, 5000000000),
                'jenis_proyek' => $faker->randomElement($jenisProyeks),
                'no_proyek' => 'PROJ-' . $faker->numerify('####'),
                'nama_perizinan' => 'Izin Usaha ' . $faker->words(2, true),
                'skala_usaha' => $faker->randomElement($skalaUsahas),
                'risiko' => $faker->randomElement($risikos),
                'jangka_waktu' => $faker->numberBetween(1, 5),
                'no_telephone' => $faker->phoneNumber(),
                'deadline' => $deadline,
                'verifikator' => $faker->randomElement($verifikators),
                'verifikasi_dpmptsp' => 'Berkas Disetujui',
                'verifikasi_pd_teknis' => 'Berkas Disetujui',
                'status' => 'Diterima',
                'terbit' => $terbit,
                'keterangan_terbit' => 'Izin telah diterbitkan sesuai dengan ketentuan yang berlaku.',
                'pemroses_dan_tgl_surat' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                                            'No: ' . $faker->numerify('###') . '/OSS/I/' . date('Y') . "\n" .
                                            'Tanggal: ' . $terbit->locale('id')->translatedFormat('d F Y'),
                'created_at' => $tanggalPermohonan,
                'updated_at' => $terbit,
            ]);

            // Buat log riwayat perubahan status
            $menungguDate = $tanggalPermohonan->copy()->addDays(rand(1, 2));
            $diterimaDate = $terbit->copy()->subDays(rand(1, 2));
            
            // Log 1: Permohonan dibuat
            $this->createLog(
                $permohonan->id,
                $user->id,
                'create',
                'Draft',
                'Menunggu',
                'Permohonan baru dibuat pada <strong>' . $tanggalPermohonan->locale('id')->translatedFormat('d M Y') . '</strong>',
                null,
                ['status' => 'Menunggu'],
                $tanggalPermohonan
            );

            // Log 2: Verifikasi DPMPTSP
            if ($menungguDate->gt($tanggalPermohonan)) {
                $this->createLog(
                    $permohonan->id,
                    $this->dpmptspUser->id,
                    'verification',
                    'Menunggu',
                    'Menunggu',
                    'Verifikasi DPMPTSP: Berkas Disetujui',
                    ['verifikasi_dpmptsp' => null],
                    ['verifikasi_dpmptsp' => 'Berkas Disetujui'],
                    $menungguDate
                );
            }

            // Log 3: Status berubah ke Diterima
            $this->createLog(
                $permohonan->id,
                $this->adminUser->id,
                'status_update',
                'Menunggu',
                'Diterima',
                'Permohonan telah diterima dan izin diterbitkan pada <strong>' . $terbit->locale('id')->translatedFormat('d M Y') . '</strong>',
                ['status' => 'Menunggu'],
                ['status' => 'Diterima', 'terbit' => $terbit->toDateString()],
                $diterimaDate
            );
        }

        // 2. Data dengan status DIKEMBALIKAN (5 data) - untuk testing notifikasi
        for ($i = 0; $i < 5; $i++) {
            $tanggalPermohonan = $now->copy()->subDays(rand(5, 30));
            $deadline = $tanggalPermohonan->copy()->addDays(rand(7, 14));
            $pengembalian = $tanggalPermohonan->copy()->addDays(rand(2, 5));
            
            $jenisPelaku = $faker->randomElement($jenisPelakuUsahas);
            $user = $users->random();
            $keteranganPengembalian = $faker->randomElement([
                'Dokumen NIB tidak lengkap, mohon dilengkapi.',
                'Surat keterangan domisili belum disertakan.',
                'Foto lokasi usaha belum disertakan.',
                'Dokumen identitas pemilik tidak jelas, mohon diunggah ulang.',
                'Surat pernyataan belum ditandatangani.',
                'Dokumen akta pendirian perusahaan tidak lengkap.',
                'Bukti pembayaran retribusi belum disertakan.',
            ]);
            
            $permohonan = Permohonan::create([
                'user_id' => $user->id,
                'no_permohonan' => 'PMH-' . str_pad($counter++, 6, '0', STR_PAD_LEFT) . '/' . date('Y'),
                'nama_usaha' => $faker->randomElement($namaPerusahaan),
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisPelaku === 'Badan Usaha' ? $faker->randomElement($jenisBadanUsahas) : null,
                'nik' => $jenisPelaku === 'Orang Perseorangan' ? $faker->numerify('################') : null,
                'tanggal_permohonan' => $tanggalPermohonan,
                'nib' => $faker->numerify('#################'),
                'alamat_perusahaan' => $faker->address(),
                'sektor' => $faker->randomElement($sektors),
                'kbli' => $faker->numerify('#####'),
                'inputan_teks' => $faker->words(3, true),
                'modal_usaha' => $faker->numberBetween(50000000, 5000000000),
                'jenis_proyek' => $faker->randomElement($jenisProyeks),
                'no_proyek' => 'PROJ-' . $faker->numerify('####'),
                'nama_perizinan' => 'Izin Usaha ' . $faker->words(2, true),
                'skala_usaha' => $faker->randomElement($skalaUsahas),
                'risiko' => $faker->randomElement($risikos),
                'jangka_waktu' => $faker->numberBetween(1, 5),
                'no_telephone' => $faker->phoneNumber(),
                'deadline' => $deadline,
                'verifikator' => $faker->randomElement($verifikators),
                'verifikasi_dpmptsp' => $faker->randomElement($verifikasiStatuses),
                'verifikasi_pd_teknis' => 'Berkas Diperbaiki',
                'status' => 'Dikembalikan',
                'pengembalian' => $pengembalian,
                'keterangan_pengembalian' => $keteranganPengembalian,
                'menghubungi' => $pengembalian->copy()->addDays(rand(1, 3)),
                'keterangan_menghubungi' => $faker->randomElement([
                    "Telah dihubungi\n\nPemohon telah dihubungi melalui telepon dan email untuk memberitahu dokumen yang perlu dilengkapi.",
                    "Tidak bisa dihubungi\n\nNomor telepon tidak aktif dan email tidak merespon.",
                    "Belum dihubungi\n\nAkan dihubungi dalam waktu dekat.",
                    "Telah dihubungi\n\nPemohon sudah memahami dokumen yang perlu diperbaiki dan akan mengunggah ulang.",
                ]),
                'created_at' => $tanggalPermohonan,
                'updated_at' => $pengembalian,
            ]);

            // Buat log riwayat perubahan status
            $menungguDate = $tanggalPermohonan->copy()->addDays(rand(1, 2));
            $dikembalikanDate = $pengembalian;
            $menghubungiDate = $pengembalian->copy()->addDays(rand(1, 2));
            
            // Log 1: Permohonan dibuat
            $this->createLog(
                $permohonan->id,
                $user->id,
                'create',
                'Draft',
                'Menunggu',
                'Permohonan baru dibuat pada <strong>' . $tanggalPermohonan->locale('id')->translatedFormat('d M Y') . '</strong>',
                null,
                ['status' => 'Menunggu'],
                $tanggalPermohonan
            );

            // Log 2: Verifikasi DPMPTSP
            if ($menungguDate->gt($tanggalPermohonan)) {
                $this->createLog(
                    $permohonan->id,
                    $this->dpmptspUser->id,
                    'verification',
                    'Menunggu',
                    'Menunggu',
                    'Verifikasi DPMPTSP: ' . $permohonan->verifikasi_dpmptsp,
                    ['verifikasi_dpmptsp' => null],
                    ['verifikasi_dpmptsp' => $permohonan->verifikasi_dpmptsp],
                    $menungguDate
                );
            }

            // Log 3: Status berubah ke Dikembalikan (oleh PD Teknis)
            $this->createLog(
                $permohonan->id,
                $this->pdTeknisUser->id,
                'status_update',
                'Menunggu',
                'Dikembalikan',
                'Berkas dikembalikan oleh PD Teknis: ' . $keteranganPengembalian,
                ['status' => 'Menunggu'],
                ['status' => 'Dikembalikan', 'pengembalian' => $pengembalian->toDateString(), 'keterangan_pengembalian' => $keteranganPengembalian],
                $dikembalikanDate
            );

            // Log 4: Pemohon dihubungi
            $this->createLog(
                $permohonan->id,
                $this->dpmptspUser->id,
                'contact',
                'Dikembalikan',
                'Dikembalikan',
                'Pemohon dihubungi pada <strong>' . $permohonan->menghubungi->locale('id')->translatedFormat('d M Y') . '</strong>: ' . $permohonan->keterangan_menghubungi,
                ['status_menghubungi' => null],
                ['menghubungi' => $permohonan->menghubungi->toDateString(), 'keterangan_menghubungi' => $permohonan->keterangan_menghubungi],
                $menghubungiDate
            );
        }

        // 3. Data dengan status DITOLAK (2 data)
        for ($i = 0; $i < 2; $i++) {
            $tanggalPermohonan = $now->copy()->subDays(rand(10, 60));
            $deadline = $tanggalPermohonan->copy()->addDays(rand(7, 14));
            
            $jenisPelaku = $faker->randomElement($jenisPelakuUsahas);
            $user = $users->random();
            $keteranganDitolak = $faker->randomElement([
                'Permohonan ditolak karena tidak memenuhi persyaratan lokasi usaha.',
                'Permohonan ditolak karena dokumen tidak valid.',
                'Permohonan ditolak karena tidak sesuai dengan RTRW.',
            ]);
            $ditolakDate = $deadline->copy()->subDays(rand(1, 3));
            
            $permohonan = Permohonan::create([
                'user_id' => $user->id,
                'no_permohonan' => 'PMH-' . str_pad($counter++, 6, '0', STR_PAD_LEFT) . '/' . date('Y'),
                'nama_usaha' => $faker->randomElement($namaPerusahaan),
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisPelaku === 'Badan Usaha' ? $faker->randomElement($jenisBadanUsahas) : null,
                'nik' => $jenisPelaku === 'Orang Perseorangan' ? $faker->numerify('################') : null,
                'tanggal_permohonan' => $tanggalPermohonan,
                'nib' => $faker->numerify('#################'),
                'alamat_perusahaan' => $faker->address(),
                'sektor' => $faker->randomElement($sektors),
                'kbli' => $faker->numerify('#####'),
                'inputan_teks' => $faker->words(3, true),
                'modal_usaha' => $faker->numberBetween(50000000, 5000000000),
                'jenis_proyek' => $faker->randomElement($jenisProyeks),
                'no_proyek' => 'PROJ-' . $faker->numerify('####'),
                'nama_perizinan' => 'Izin Usaha ' . $faker->words(2, true),
                'skala_usaha' => $faker->randomElement($skalaUsahas),
                'risiko' => $faker->randomElement($risikos),
                'jangka_waktu' => $faker->numberBetween(1, 5),
                'no_telephone' => $faker->phoneNumber(),
                'deadline' => $deadline,
                'verifikator' => $faker->randomElement($verifikators),
                'verifikasi_dpmptsp' => 'Berkas Diperbaiki',
                'verifikasi_pd_teknis' => 'Berkas Diperbaiki',
                'status' => 'Ditolak',
                'keterangan' => $keteranganDitolak,
                'created_at' => $tanggalPermohonan,
                'updated_at' => $ditolakDate,
            ]);

            // Buat log riwayat perubahan status
            $menungguDate = $tanggalPermohonan->copy()->addDays(rand(1, 2));
            
            // Log 1: Permohonan dibuat
            $this->createLog(
                $permohonan->id,
                $user->id,
                'create',
                'Draft',
                'Menunggu',
                'Permohonan baru dibuat pada <strong>' . $tanggalPermohonan->locale('id')->translatedFormat('d M Y') . '</strong>',
                null,
                ['status' => 'Menunggu'],
                $tanggalPermohonan
            );

            // Log 2: Verifikasi DPMPTSP
            if ($menungguDate->gt($tanggalPermohonan)) {
                $this->createLog(
                    $permohonan->id,
                    $this->dpmptspUser->id,
                    'verification',
                    'Menunggu',
                    'Menunggu',
                    'Verifikasi DPMPTSP: ' . $permohonan->verifikasi_dpmptsp,
                    ['verifikasi_dpmptsp' => null],
                    ['verifikasi_dpmptsp' => $permohonan->verifikasi_dpmptsp],
                    $menungguDate
                );
            }

            // Log 3: Status berubah ke Ditolak
            $this->createLog(
                $permohonan->id,
                $this->adminUser->id,
                'status_update',
                'Menunggu',
                'Ditolak',
                'Permohonan ditolak: ' . $keteranganDitolak,
                ['status' => 'Menunggu'],
                ['status' => 'Ditolak', 'keterangan' => $keteranganDitolak],
                $ditolakDate
            );
        }

        // 4. Data dengan status MENUNGGU - Normal (3 data)
        for ($i = 0; $i < 3; $i++) {
            $tanggalPermohonan = $now->copy()->subDays(rand(1, 10));
            $deadline = $tanggalPermohonan->copy()->addDays(rand(7, 14));
            
            $jenisPelaku = $faker->randomElement($jenisPelakuUsahas);
            $user = $users->random();
            
            $permohonan = Permohonan::create([
                'user_id' => $user->id,
                'no_permohonan' => 'PMH-' . str_pad($counter++, 6, '0', STR_PAD_LEFT) . '/' . date('Y'),
                'nama_usaha' => $faker->randomElement($namaPerusahaan),
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisPelaku === 'Badan Usaha' ? $faker->randomElement($jenisBadanUsahas) : null,
                'nik' => $jenisPelaku === 'Orang Perseorangan' ? $faker->numerify('################') : null,
                'tanggal_permohonan' => $tanggalPermohonan,
                'nib' => $faker->numerify('#################'),
                'alamat_perusahaan' => $faker->address(),
                'sektor' => $faker->randomElement($sektors),
                'kbli' => $faker->numerify('#####'),
                'inputan_teks' => $faker->words(3, true),
                'modal_usaha' => $faker->numberBetween(50000000, 5000000000),
                'jenis_proyek' => $faker->randomElement($jenisProyeks),
                'no_proyek' => 'PROJ-' . $faker->numerify('####'),
                'nama_perizinan' => 'Izin Usaha ' . $faker->words(2, true),
                'skala_usaha' => $faker->randomElement($skalaUsahas),
                'risiko' => $faker->randomElement($risikos),
                'jangka_waktu' => $faker->numberBetween(1, 5),
                'no_telephone' => $faker->phoneNumber(),
                'deadline' => $deadline,
                'verifikator' => $faker->randomElement($verifikators),
                'verifikasi_dpmptsp' => $faker->randomElement($verifikasiStatuses),
                'verifikasi_pd_teknis' => $faker->randomElement($verifikasiStatuses),
                'status' => 'Menunggu',
                'created_at' => $tanggalPermohonan,
                'updated_at' => $tanggalPermohonan,
            ]);

            // Buat log riwayat perubahan status
            $menungguDate = $tanggalPermohonan->copy()->addDays(rand(1, 2));
            
            // Log 1: Permohonan dibuat
            $this->createLog(
                $permohonan->id,
                $user->id,
                'create',
                'Draft',
                'Menunggu',
                'Permohonan baru dibuat pada <strong>' . $tanggalPermohonan->locale('id')->translatedFormat('d M Y') . '</strong>',
                null,
                ['status' => 'Menunggu'],
                $tanggalPermohonan
            );

            // Log 2: Verifikasi DPMPTSP
            if ($menungguDate->gt($tanggalPermohonan)) {
                $this->createLog(
                    $permohonan->id,
                    $this->dpmptspUser->id,
                    'verification',
                    'Menunggu',
                    'Menunggu',
                    'Verifikasi DPMPTSP: ' . $permohonan->verifikasi_dpmptsp,
                    ['verifikasi_dpmptsp' => null],
                    ['verifikasi_dpmptsp' => $permohonan->verifikasi_dpmptsp],
                    $menungguDate
                );
            }
        }

        // 5. Data dengan status MENUNGGU - Terlambat (3 data) - deadline sudah lewat
        for ($i = 0; $i < 3; $i++) {
            $tanggalPermohonan = $now->copy()->subDays(rand(20, 60));
            $deadline = $tanggalPermohonan->copy()->addDays(rand(5, 10)); // Deadline sudah lewat
            
            $jenisPelaku = $faker->randomElement($jenisPelakuUsahas);
            $user = $users->random();
            
            $permohonan = Permohonan::create([
                'user_id' => $user->id,
                'no_permohonan' => 'PMH-' . str_pad($counter++, 6, '0', STR_PAD_LEFT) . '/' . date('Y'),
                'nama_usaha' => $faker->randomElement($namaPerusahaan),
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisPelaku === 'Badan Usaha' ? $faker->randomElement($jenisBadanUsahas) : null,
                'nik' => $jenisPelaku === 'Orang Perseorangan' ? $faker->numerify('################') : null,
                'tanggal_permohonan' => $tanggalPermohonan,
                'nib' => $faker->numerify('#################'),
                'alamat_perusahaan' => $faker->address(),
                'sektor' => $faker->randomElement($sektors),
                'kbli' => $faker->numerify('#####'),
                'inputan_teks' => $faker->words(3, true),
                'modal_usaha' => $faker->numberBetween(50000000, 5000000000),
                'jenis_proyek' => $faker->randomElement($jenisProyeks),
                'no_proyek' => 'PROJ-' . $faker->numerify('####'),
                'nama_perizinan' => 'Izin Usaha ' . $faker->words(2, true),
                'skala_usaha' => $faker->randomElement($skalaUsahas),
                'risiko' => $faker->randomElement($risikos),
                'jangka_waktu' => $faker->numberBetween(1, 5),
                'no_telephone' => $faker->phoneNumber(),
                'deadline' => $deadline,
                'verifikator' => $faker->randomElement($verifikators),
                'verifikasi_dpmptsp' => 'Pemohon Belum Dihubungi',
                'verifikasi_pd_teknis' => 'Pemohon Belum Dihubungi',
                'status' => 'Menunggu',
                'created_at' => $tanggalPermohonan,
                'updated_at' => $tanggalPermohonan,
            ]);

            // Buat log riwayat perubahan status
            $menungguDate = $tanggalPermohonan->copy()->addDays(rand(1, 2));
            $terlambatDate = $deadline->copy()->addDays(rand(1, 3)); // Setelah deadline
            
            // Log 1: Permohonan dibuat
            $this->createLog(
                $permohonan->id,
                $user->id,
                'create',
                'Draft',
                'Menunggu',
                'Permohonan baru dibuat pada <strong>' . $tanggalPermohonan->locale('id')->translatedFormat('d M Y') . '</strong>',
                null,
                ['status' => 'Menunggu'],
                $tanggalPermohonan
            );

            // Log 2: Verifikasi DPMPTSP
            if ($menungguDate->gt($tanggalPermohonan)) {
                $this->createLog(
                    $permohonan->id,
                    $this->dpmptspUser->id,
                    'verification',
                    'Menunggu',
                    'Menunggu',
                    'Verifikasi DPMPTSP: ' . $permohonan->verifikasi_dpmptsp,
                    ['verifikasi_dpmptsp' => null],
                    ['verifikasi_dpmptsp' => $permohonan->verifikasi_dpmptsp],
                    $menungguDate
                );
            }

            // Log 3: Deadline terlambat
            $this->createLog(
                $permohonan->id,
                1, // System user
                'deadline_overdue',
                'Menunggu',
                'Menunggu',
                '⚠️ PERINGATAN: Permohonan telah melewati deadline (' . $deadline->locale('id')->translatedFormat('d/m/Y') . ')',
                ['deadline' => $deadline->toDateString()],
                ['deadline' => $deadline->toDateString(), 'status' => 'Menunggu'],
                $terlambatDate
            );
        }

        // 6. Data dengan status MENUNGGU - Due Soon (2 data) - deadline dalam 3 hari
        for ($i = 0; $i < 2; $i++) {
            $tanggalPermohonan = $now->copy()->subDays(rand(5, 10));
            $deadline = $now->copy()->addDays(rand(1, 3)); // Deadline dalam 1-3 hari
            
            $jenisPelaku = $faker->randomElement($jenisPelakuUsahas);
            $user = $users->random();
            $menghubungiDate = $now->copy()->subDays(rand(1, 2));
            
            $permohonan = Permohonan::create([
                'user_id' => $user->id,
                'no_permohonan' => 'PMH-' . str_pad($counter++, 6, '0', STR_PAD_LEFT) . '/' . date('Y'),
                'nama_usaha' => $faker->randomElement($namaPerusahaan),
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisPelaku === 'Badan Usaha' ? $faker->randomElement($jenisBadanUsahas) : null,
                'nik' => $jenisPelaku === 'Orang Perseorangan' ? $faker->numerify('################') : null,
                'tanggal_permohonan' => $tanggalPermohonan,
                'nib' => $faker->numerify('#################'),
                'alamat_perusahaan' => $faker->address(),
                'sektor' => $faker->randomElement($sektors),
                'kbli' => $faker->numerify('#####'),
                'inputan_teks' => $faker->words(3, true),
                'modal_usaha' => $faker->numberBetween(50000000, 5000000000),
                'jenis_proyek' => $faker->randomElement($jenisProyeks),
                'no_proyek' => 'PROJ-' . $faker->numerify('####'),
                'nama_perizinan' => 'Izin Usaha ' . $faker->words(2, true),
                'skala_usaha' => $faker->randomElement($skalaUsahas),
                'risiko' => $faker->randomElement($risikos),
                'jangka_waktu' => $faker->numberBetween(1, 5),
                'no_telephone' => $faker->phoneNumber(),
                'deadline' => $deadline,
                'verifikator' => $faker->randomElement($verifikators),
                'verifikasi_dpmptsp' => 'Pemohon Dihubungi',
                'verifikasi_pd_teknis' => 'Berkas Diperbaiki',
                'status' => 'Menunggu',
                'menghubungi' => $menghubungiDate,
                'keterangan_menghubungi' => "Telah dihubungi\n\nPemohon telah dihubungi untuk mempercepat proses karena deadline sudah dekat.",
                'created_at' => $tanggalPermohonan,
                'updated_at' => $tanggalPermohonan,
            ]);

            // Buat log riwayat perubahan status
            $menungguDate = $tanggalPermohonan->copy()->addDays(rand(1, 2));
            
            // Log 1: Permohonan dibuat
            $this->createLog(
                $permohonan->id,
                $user->id,
                'create',
                'Draft',
                'Menunggu',
                'Permohonan baru dibuat pada <strong>' . $tanggalPermohonan->locale('id')->translatedFormat('d M Y') . '</strong>',
                null,
                ['status' => 'Menunggu'],
                $tanggalPermohonan
            );

            // Log 2: Verifikasi DPMPTSP
            if ($menungguDate->gt($tanggalPermohonan)) {
                $this->createLog(
                    $permohonan->id,
                    $this->dpmptspUser->id,
                    'verification',
                    'Menunggu',
                    'Menunggu',
                    'Verifikasi DPMPTSP: ' . $permohonan->verifikasi_dpmptsp,
                    ['verifikasi_dpmptsp' => null],
                    ['verifikasi_dpmptsp' => $permohonan->verifikasi_dpmptsp],
                    $menungguDate
                );
            }

            // Log 3: Pemohon dihubungi (deadline due soon)
            $this->createLog(
                $permohonan->id,
                $this->dpmptspUser->id,
                'contact',
                'Menunggu',
                'Menunggu',
                'Pemohon dihubungi pada <strong>' . $menghubungiDate->locale('id')->translatedFormat('d M Y') . '</strong> untuk mempercepat proses. Deadline: ' . $deadline->locale('id')->translatedFormat('d M Y'),
                ['status_menghubungi' => null],
                ['menghubungi' => $menghubungiDate->toDateString(), 'keterangan_menghubungi' => $permohonan->keterangan_menghubungi],
                $menghubungiDate
            );
        }

        // 7. Data dengan tracking lengkap - Dikembalikan kemudian Perbaikan (1 data)
        for ($i = 0; $i < 1; $i++) {
            $tanggalPermohonan = $now->copy()->subDays(rand(15, 30));
            $deadline = $tanggalPermohonan->copy()->addDays(rand(10, 14));
            $pengembalian = $tanggalPermohonan->copy()->addDays(rand(3, 5));
            $perbaikan = $pengembalian->copy()->addDays(rand(2, 5));
            
            $jenisPelaku = $faker->randomElement($jenisPelakuUsahas);
            $user = $users->random();
            $keteranganPengembalian = 'Dokumen perlu dilengkapi.';
            $menghubungiDate = $pengembalian->copy()->addDays(1);
            
            $permohonan = Permohonan::create([
                'user_id' => $user->id,
                'no_permohonan' => 'PMH-' . str_pad($counter++, 6, '0', STR_PAD_LEFT) . '/' . date('Y'),
                'nama_usaha' => $faker->randomElement($namaPerusahaan),
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisPelaku === 'Badan Usaha' ? $faker->randomElement($jenisBadanUsahas) : null,
                'nik' => $jenisPelaku === 'Orang Perseorangan' ? $faker->numerify('################') : null,
                'tanggal_permohonan' => $tanggalPermohonan,
                'nib' => $faker->numerify('#################'),
                'alamat_perusahaan' => $faker->address(),
                'sektor' => $faker->randomElement($sektors),
                'kbli' => $faker->numerify('#####'),
                'inputan_teks' => $faker->words(3, true),
                'modal_usaha' => $faker->numberBetween(50000000, 5000000000),
                'jenis_proyek' => $faker->randomElement($jenisProyeks),
                'no_proyek' => 'PROJ-' . $faker->numerify('####'),
                'nama_perizinan' => 'Izin Usaha ' . $faker->words(2, true),
                'skala_usaha' => $faker->randomElement($skalaUsahas),
                'risiko' => $faker->randomElement($risikos),
                'jangka_waktu' => $faker->numberBetween(1, 5),
                'no_telephone' => $faker->phoneNumber(),
                'deadline' => $deadline,
                'verifikator' => $faker->randomElement($verifikators),
                'verifikasi_dpmptsp' => 'Berkas Diunggah Ulang',
                'verifikasi_pd_teknis' => 'Berkas Diunggah Ulang',
                'status' => 'Menunggu',
                'pengembalian' => $pengembalian,
                'keterangan_pengembalian' => $keteranganPengembalian,
                'menghubungi' => $menghubungiDate,
                'keterangan_menghubungi' => "Telah dihubungi\n\nPemohon telah dihubungi untuk memberitahu dokumen yang perlu dilengkapi.",
                'perbaikan' => $perbaikan,
                'keterangan_perbaikan' => 'Pemohon telah mengunggah dokumen perbaikan.',
                'created_at' => $tanggalPermohonan,
                'updated_at' => $perbaikan,
            ]);

            // Buat log riwayat perubahan status lengkap
            $menungguDate = $tanggalPermohonan->copy()->addDays(rand(1, 2));
            
            // Log 1: Permohonan dibuat
            $this->createLog(
                $permohonan->id,
                $user->id,
                'create',
                'Draft',
                'Menunggu',
                'Permohonan baru dibuat pada <strong>' . $tanggalPermohonan->locale('id')->translatedFormat('d M Y') . '</strong>',
                null,
                ['status' => 'Menunggu'],
                $tanggalPermohonan
            );

            // Log 2: Verifikasi DPMPTSP
            if ($menungguDate->gt($tanggalPermohonan)) {
                $this->createLog(
                    $permohonan->id,
                    $this->dpmptspUser->id,
                    'verification',
                    'Menunggu',
                    'Menunggu',
                    'Verifikasi DPMPTSP: Berkas sedang diverifikasi',
                    ['verifikasi_dpmptsp' => null],
                    ['verifikasi_dpmptsp' => 'Berkas Diperbaiki'],
                    $menungguDate
                );
            }

            // Log 3: Status berubah ke Dikembalikan (oleh PD Teknis)
            $this->createLog(
                $permohonan->id,
                $this->pdTeknisUser->id,
                'status_update',
                'Menunggu',
                'Dikembalikan',
                'Berkas dikembalikan oleh PD Teknis: ' . $keteranganPengembalian,
                ['status' => 'Menunggu'],
                ['status' => 'Dikembalikan', 'pengembalian' => $pengembalian->toDateString(), 'keterangan_pengembalian' => $keteranganPengembalian],
                $pengembalian
            );

            // Log 4: Pemohon dihubungi
            $this->createLog(
                $permohonan->id,
                $this->dpmptspUser->id,
                'contact',
                'Dikembalikan',
                'Dikembalikan',
                'Pemohon dihubungi pada <strong>' . $menghubungiDate->locale('id')->translatedFormat('d M Y') . '</strong>: ' . $permohonan->keterangan_menghubungi,
                ['status_menghubungi' => null],
                ['menghubungi' => $menghubungiDate->toDateString(), 'keterangan_menghubungi' => $permohonan->keterangan_menghubungi],
                $menghubungiDate
            );

            // Log 5: Dokumen perbaikan diunggah
            $this->createLog(
                $permohonan->id,
                $user->id,
                'revision',
                'Dikembalikan',
                'Menunggu',
                'Pemohon telah mengunggah dokumen perbaikan pada <strong>' . $perbaikan->locale('id')->translatedFormat('d M Y') . '</strong>',
                ['status' => 'Dikembalikan'],
                ['status' => 'Menunggu', 'perbaikan' => $perbaikan->toDateString(), 'verifikasi_dpmptsp' => 'Berkas Diunggah Ulang'],
                $perbaikan
            );
        }

        // 8. Data dengan semua sektor (1 data - satu sektor)
        foreach (array_slice($sektors, 0, 1) as $sektor) {
            $tanggalPermohonan = $now->copy()->subDays(rand(5, 20));
            $deadline = $tanggalPermohonan->copy()->addDays(rand(7, 14));
            
            $jenisPelaku = $faker->randomElement($jenisPelakuUsahas);
            $user = $users->where('sektor', $sektor)->first() ?? $users->random();
            $status = $faker->randomElement(['Menunggu', 'Diterima', 'Dikembalikan']);
            
            $permohonan = Permohonan::create([
                'user_id' => $user->id,
                'no_permohonan' => 'PMH-' . str_pad($counter++, 6, '0', STR_PAD_LEFT) . '/' . date('Y'),
                'nama_usaha' => $faker->randomElement($namaPerusahaan),
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisPelaku === 'Badan Usaha' ? $faker->randomElement($jenisBadanUsahas) : null,
                'nik' => $jenisPelaku === 'Orang Perseorangan' ? $faker->numerify('################') : null,
                'tanggal_permohonan' => $tanggalPermohonan,
                'nib' => $faker->numerify('#################'),
                'alamat_perusahaan' => $faker->address(),
                'sektor' => $sektor,
                'kbli' => $faker->numerify('#####'),
                'inputan_teks' => $faker->words(3, true),
                'modal_usaha' => $faker->numberBetween(50000000, 5000000000),
                'jenis_proyek' => $faker->randomElement($jenisProyeks),
                'no_proyek' => 'PROJ-' . $faker->numerify('####'),
                'nama_perizinan' => 'Izin Usaha ' . $faker->words(2, true),
                'skala_usaha' => $faker->randomElement($skalaUsahas),
                'risiko' => $faker->randomElement($risikos),
                'jangka_waktu' => $faker->numberBetween(1, 5),
                'no_telephone' => $faker->phoneNumber(),
                'deadline' => $deadline,
                'verifikator' => $faker->randomElement($verifikators),
                'verifikasi_dpmptsp' => $faker->randomElement($verifikasiStatuses),
                'verifikasi_pd_teknis' => $faker->randomElement($verifikasiStatuses),
                'status' => $status,
                'created_at' => $tanggalPermohonan,
                'updated_at' => $tanggalPermohonan,
            ]);

            // Buat log riwayat perubahan status
            $menungguDate = $tanggalPermohonan->copy()->addDays(rand(1, 2));
            
            // Log 1: Permohonan dibuat
            $this->createLog(
                $permohonan->id,
                $user->id,
                'create',
                'Draft',
                'Menunggu',
                'Permohonan baru dibuat pada <strong>' . $tanggalPermohonan->locale('id')->translatedFormat('d M Y') . '</strong>',
                null,
                ['status' => 'Menunggu'],
                $tanggalPermohonan
            );

            // Log 2: Verifikasi DPMPTSP
            if ($menungguDate->gt($tanggalPermohonan)) {
                $this->createLog(
                    $permohonan->id,
                    $this->dpmptspUser->id,
                    'verification',
                    'Menunggu',
                    'Menunggu',
                    'Verifikasi DPMPTSP: ' . $permohonan->verifikasi_dpmptsp,
                    ['verifikasi_dpmptsp' => null],
                    ['verifikasi_dpmptsp' => $permohonan->verifikasi_dpmptsp],
                    $menungguDate
                );
            }

            // Log 3: Status update (jika bukan Menunggu)
            if ($status !== 'Menunggu') {
                $statusDate = $menungguDate->copy()->addDays(rand(1, 3));
                $keterangan = $status === 'Diterima' 
                    ? 'Permohonan telah diterima' 
                    : 'Berkas dikembalikan untuk perbaikan';
                
                // Jika Dikembalikan, log dilakukan oleh PD Teknis
                $userId = $status === 'Dikembalikan' ? $this->pdTeknisUser->id : $this->adminUser->id;
                $keteranganLog = $status === 'Diterima' 
                    ? 'Permohonan telah diterima' 
                    : 'Berkas dikembalikan oleh PD Teknis: ' . $keterangan;
                
                $this->createLog(
                    $permohonan->id,
                    $userId,
                    'status_update',
                    'Menunggu',
                    $status,
                    $keteranganLog,
                    ['status' => 'Menunggu'],
                    ['status' => $status],
                    $statusDate
                );
            }
        }

        $this->command->info('✅ Berhasil membuat 20 data permohonan dengan memaksimalkan semua fitur!');
        $this->command->info('📊 Distribusi data:');
        $this->command->info('   - Diterima: 3 data');
        $this->command->info('   - Dikembalikan: 5 data (untuk testing notifikasi dengan template menghubungi)');
        $this->command->info('   - Ditolak: 2 data');
        $this->command->info('   - Menunggu (Normal): 3 data');
        $this->command->info('   - Menunggu (Terlambat): 3 data');
        $this->command->info('   - Menunggu (Due Soon): 2 data');
        $this->command->info('   - Tracking Lengkap (Dikembalikan → Perbaikan): 1 data');
        $this->command->info('   - Per Sektor: 1 data');
        $this->command->info('   Total: 20 data');
    }
}

