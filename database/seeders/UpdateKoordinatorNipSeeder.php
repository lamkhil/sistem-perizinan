<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppSetting;

class UpdateKoordinatorNipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update atau create NIP untuk koordinator
        $koordinator = AppSetting::firstOrCreate(
            ['id' => 1],
            [
                'nama_mengetahui' => 'Yohanes Franklin, S.H., M.H.',
                'nip_mengetahui' => '198502182010011008',
            ]
        );

        // Update NIP jika masih null atau kosong
        if (empty($koordinator->nip_mengetahui)) {
            $koordinator->update(['nip_mengetahui' => '198502182010011008']);
            $this->command->info('NIP Koordinator berhasil diupdate: 198502182010011008');
        } else {
            $this->command->info('NIP Koordinator sudah ada: ' . $koordinator->nip_mengetahui);
        }
    }
}
