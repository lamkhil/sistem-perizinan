<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TtdSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'mengetahui_title',
        'mengetahui_jabatan',
        'mengetahui_unit',
        'mengetahui_nama',
        'mengetahui_pangkat',
        'mengetahui_nip',
        'mengetahui_photo',
        'menyetujui_lokasi',
        'menyetujui_tanggal',
        'menyetujui_jabatan',
        'menyetujui_nama',
        'menyetujui_pangkat',
        'menyetujui_nip',
        'menyetujui_photo',
    ];

    /**
     * Get the first TTD setting or create default one
     */
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = self::create([
                'mengetahui_title' => 'Mengetahui',
                'mengetahui_jabatan' => 'Koordinator Ketua Tim Kerja',
                'mengetahui_unit' => 'Pelayanan Terpadu Satu Pintu',
                'mengetahui_nama' => 'Yohanes Franklin, S.H., M.H.',
                'mengetahui_pangkat' => 'Penata Tk.1',
                'mengetahui_nip' => '198502182010011008',
                'menyetujui_lokasi' => 'Surabaya',
                'menyetujui_tanggal' => date('Y-m-d'),
                'menyetujui_jabatan' => 'Ketua Tim Kerja Pelayanan Perizinan Berusaha',
                'menyetujui_nama' => 'Ulvia Zulvia, ST',
                'menyetujui_pangkat' => 'Penata Tk. 1',
                'menyetujui_nip' => '197710132006042012',
            ]);
        }
        
        return $settings;
    }
}