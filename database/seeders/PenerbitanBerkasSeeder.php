<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PenerbitanBerkas;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class PenerbitanBerkasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Ambil user dengan role admin atau penerbitan_berkas
        $users = User::whereIn('role', ['admin', 'penerbitan_berkas'])->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('Tidak ada user dengan role admin atau penerbitan_berkas. Membuat user dummy...');
            $user = User::create([
                'name' => 'Admin Penerbitan',
                'email' => 'admin@penerbitan.test',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
            $users = collect([$user]);
        }

        // Data opsi
        $jenisPelakuUsaha = ['Orang Perseorangan', 'Badan Usaha'];
        $jenisBadanUsaha = [
            'Perseroan Terbatas (PT)',
            'Perseroan Terbatas (PT) Perorangan',
            'Persekutuan Komanditer (CV/Commanditaire Vennootschap)',
            'Persekutuan Firma (FA / Venootschap Onder Firma)',
            'Persekutuan Perdata',
            'Perusahaan Umum (Perum)',
            'Perusahaan Umum Daerah (Perumda)',
            'Badan Hukum Lainnya',
            'Koperasi',
            'Yayasan',
        ];
        $jenisProyek = ['Utama', 'Pendukung', 'Pendukung UMKU', 'Kantor Cabang'];
        $skalaUsaha = ['Mikro', 'Usaha Kecil', 'Usaha Menengah', 'Usaha Besar'];
        $risiko = ['Rendah', 'Menengah Rendah', 'Menengah Tinggi', 'Tinggi'];
        $status = ['Menunggu', 'Diterima', 'Ditolak', 'Dikembalikan'];
        $kbliOptions = ['47111', '47112', '47113', '47114', '47115', '56101', '56102', '70209', '73100', '82301'];

        // Generate 30 data penerbitan berkas
        $this->command->info('Creating 30 Penerbitan Berkas records...');

        for ($i = 1; $i <= 30; $i++) {
            $jenisPelaku = $faker->randomElement($jenisPelakuUsaha);
            $tanggalPermohonan = $faker->dateTimeBetween('-6 months', 'now');
            $tanggalBap = $faker->dateTimeBetween($tanggalPermohonan, 'now');
            
            // Generate nomor BAP dengan format: BAP/OSS/IX/I-[tahun][bulan][hari][random]/436.7.15/[tahun]
            $nomorBap = 'BAP/OSS/IX/I-' . $faker->numerify('#########') . '/436.7.15/' . $tanggalBap->format('Y');

            $data = [
                'user_id' => $users->random()->id,
                'no_permohonan' => 'PB-' . str_pad($i, 6, '0', STR_PAD_LEFT) . '-' . date('Y'),
                'no_proyek' => 'PROY-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'tanggal_permohonan' => $tanggalPermohonan,
                'nib' => $faker->numerify('##############'),
                'kbli' => $faker->randomElement($kbliOptions),
                'nama_usaha' => $faker->company(),
                'inputan_teks' => $faker->sentence(8),
                'jenis_pelaku_usaha' => $jenisPelaku,
                'jenis_badan_usaha' => $jenisPelaku === 'Badan Usaha' ? $faker->randomElement($jenisBadanUsaha) : null,
                'pemilik' => $faker->name(),
                'modal_usaha' => $faker->numberBetween(10000000, 1000000000),
                'alamat_perusahaan' => $faker->address(),
                'jenis_proyek' => $faker->randomElement($jenisProyek),
                'nama_perizinan' => 'Izin ' . $faker->randomElement(['Usaha', 'Perdagangan', 'Industri', 'Pertambangan', 'Perkebunan']),
                'skala_usaha' => $faker->randomElement($skalaUsaha),
                'risiko' => $faker->randomElement($risiko),
                'status' => $faker->randomElement($status),
                'nomor_bap' => $nomorBap,
                'tanggal_bap' => $tanggalBap,
            ];

            PenerbitanBerkas::create($data);
            
            if ($i % 10 == 0) {
                $this->command->info("Created {$i} records...");
            }
        }

        $this->command->info('✅ Successfully created 30 Penerbitan Berkas records!');
    }
}
