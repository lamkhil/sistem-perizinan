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
     */
    public static function getKoordinator()
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'nama_mengetahui' => null,
                'nip_mengetahui' => null,
            ]
        );
    }
}
