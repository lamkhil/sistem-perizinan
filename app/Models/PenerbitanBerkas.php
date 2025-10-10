<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $no_permohonan
 * @property string|null $no_proyek
 * @property \Carbon\CarbonInterface|null $tanggal_permohonan
 * @property string|null $nib
 * @property string|null $kbli
 * @property string|null $nama_usaha
 * @property string|null $inputan_teks
 * @property string|null $jenis_pelaku_usaha
 * @property string|null $jenis_badan_usaha
 * @property string|null $pemilik
 * @property float|int|string|null $modal_usaha
 * @property string|null $alamat_perusahaan
 * @property string|null $jenis_proyek
 * @property string|null $nama_perizinan
 * @property string|null $skala_usaha
 * @property string|null $risiko
 * @property string|null $status
 * @property \Carbon\CarbonInterface|null $created_at
 * @property \Carbon\CarbonInterface|null $updated_at
 * @property-read \App\Models\User $user
 */
class PenerbitanBerkas extends Model
{
    use HasFactory;

    protected $table = 'penerbitan_berkas';

    protected $fillable = [
        'user_id',
        'no_permohonan',
        'no_proyek',
        'tanggal_permohonan',
        'nib',
        'kbli',
        'nama_usaha',
        'inputan_teks',
        'jenis_pelaku_usaha',
        'jenis_badan_usaha',
        'pemilik',
        'modal_usaha',
        'alamat_perusahaan',
        'jenis_proyek',
        'nama_perizinan',
        'skala_usaha',
        'risiko',
        'status',
        'pemroses_dan_tgl_surat',
    ];

    protected $casts = [
        'tanggal_permohonan' => 'date',
        'modal_usaha' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getRisikoBadgeClass()
    {
        switch ($this->risiko) {
            case 'Rendah':
                return 'bg-green-100 text-green-800';
            case 'Menengah Rendah':
                return 'bg-blue-100 text-blue-800';
            case 'Menengah Tinggi':
                return 'bg-yellow-100 text-yellow-800';
            case 'Tinggi':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case 'Diterima':
                return 'bg-green-100 text-green-800';
            case 'Dikembalikan':
                return 'bg-yellow-100 text-yellow-800';
            case 'Ditolak':
                return 'bg-red-100 text-red-800';
            case 'Menunggu':
                return 'bg-blue-100 text-blue-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    // Method untuk mendapatkan jenis perusahaan yang ditampilkan di tabel
    public function getJenisPerusahaanDisplayAttribute()
    {
        if ($this->jenis_pelaku_usaha === 'Orang Perseorangan') {
            return 'Orang Perseorangan';
        } elseif ($this->jenis_pelaku_usaha === 'Badan Usaha' && $this->jenis_badan_usaha) {
            return $this->jenis_badan_usaha;
        }
        
        return $this->jenis_pelaku_usaha ?? '-';
    }
}


