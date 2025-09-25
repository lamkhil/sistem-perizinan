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
    ];

    protected $casts = [
        'tanggal_permohonan' => 'date',
        'modal_usaha' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}


