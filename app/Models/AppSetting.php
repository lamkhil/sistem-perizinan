<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'nama_mengetahui',
        'nip_mengetahui',
        'ttd_bap_mengetahui',
    ];

    /**
     * Get atau create setting untuk koordinator
     * Default nama: Yohanes Franklin, S.H., M.H.
     * Default NIP: 198502182010011008
     */
    public static function getKoordinator()
    {
        $koordinator = static::firstOrCreate(
            ['id' => 1],
            [
                'nama_mengetahui' => 'Yohanes Franklin, S.H., M.H.',
                'nip_mengetahui' => '198502182010011008',
            ]
        );
        
        // Jika nama masih null atau kosong, set default
        if (empty($koordinator->nama_mengetahui)) {
            $koordinator->update(['nama_mengetahui' => 'Yohanes Franklin, S.H., M.H.']);
            $koordinator->refresh();
        }
        
        // Jika NIP masih null atau kosong, set default
        if (empty($koordinator->nip_mengetahui)) {
            $koordinator->update(['nip_mengetahui' => '198502182010011008']);
            $koordinator->refresh();
        }
        
        return $koordinator;
    }
}
