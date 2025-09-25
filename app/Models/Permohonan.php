<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $no_permohonan
 * @property string|null $nama_usaha
 * @property string|null $nama_perusahaan
 * @property string|null $pemilik
 * @property string|null $jenis_perusahaan
 * @property string|null $jenis_pelaku_usaha
 * @property string|null $jenis_badan_usaha
 * @property string|null $nik
 * @property \Carbon\CarbonInterface|null $tanggal_permohonan
 * @property string|null $nib
 * @property string|null $alamat_perusahaan
 * @property string|null $sektor
 * @property string|null $kbli
 * @property string|null $inputan_teks
 * @property float|int|string|null $modal_usaha
 * @property string|null $jenis_proyek
 * @property string|null $no_proyek
 * @property string|null $nama_perizinan
 * @property string|null $skala_usaha
 * @property string|null $risiko
 * @property int|null $jangka_waktu
 * @property string|null $no_telephone
 * @property \Carbon\CarbonInterface|null $deadline
 * @property string|null $verifikator
 * @property string|null $verifikasi_dpmptsp
 * @property string|null $verifikasi_pd_teknis
 * @property string|null $status
 * @property \Carbon\CarbonInterface|null $pengembalian
 * @property string|null $keterangan_pengembalian
 * @property \Carbon\CarbonInterface|null $menghubungi
 * @property string|null $keterangan_menghubungi
 * @property string|null $status_menghubungi
 * @property \Carbon\CarbonInterface|null $perbaikan
 * @property string|null $keterangan_perbaikan
 * @property \Carbon\CarbonInterface|null $terbit
 * @property string|null $keterangan_terbit
 * @property string|null $pemroses_dan_tgl_surat
 * @property string|null $keterangan
 * @property \Carbon\CarbonInterface|null $created_at
 * @property \Carbon\CarbonInterface|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LogPermohonan[] $logs
 */
class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'no_permohonan',
        'nama_usaha',
        'nama_perusahaan',
        'pemilik',
        'jenis_perusahaan', 
        'jenis_pelaku_usaha',
        'jenis_badan_usaha',
        'nik',
        'tanggal_permohonan',
        'nib',
        'alamat_perusahaan',
        'sektor',
        'kbli',
        'inputan_teks',
        'modal_usaha',
        'jenis_proyek',
        'no_proyek',
        'nama_perizinan',
        'skala_usaha',
        'risiko',
        'jangka_waktu',
        'no_telephone',
        'deadline',
        'verifikator',
        'verifikasi_dpmptsp',
        'verifikasi_pd_teknis',
        'status',
        'pengembalian',
        'keterangan_pengembalian',
        'menghubungi',
        'keterangan_menghubungi',
        'status_menghubungi',
        'perbaikan',
        'keterangan_perbaikan',
        'terbit',
        'keterangan_terbit',
        'pemroses_dan_tgl_surat',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_permohonan' => 'date',
        'pengembalian' => 'date',
        'menghubungi' => 'date',
        'perbaikan' => 'date',
        'terbit' => 'date',
        'deadline' => 'date',
        // Tambahkan juga untuk created_at dan updated_at jika ingin eksplisit meskipun sudah default
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Jika kamu memiliki `$dates` sebelumnya, sebaiknya pindahkan semua ke `$casts`
    // atau hapus `$dates` untuk menghindari kebingungan.
    // protected $dates = [
    //     'tanggal_permohonan',
    //     'pengembalian',
    //     'menghubungi',
    //     'perbaikan',
    //     'terbit'
    // ];
    // Saya telah menonaktifkan `$dates` di sini, pastikan kamu juga menghapusnya di file kamu.
    
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke LogPermohonan
    public function logs()
    {
        return $this->hasMany(LogPermohonan::class);
    }

    // Method untuk mengecek apakah permohonan melewati deadline
    public function isOverdue()
    {
        if (!$this->getAttribute('deadline')) {
            return false;
        }
        
        return now()->toDateString() > $this->getAttribute('deadline')->toDateString();
    }

    // Method untuk mendapatkan status deadline
    public function getDeadlineStatus()
    {
        if (!$this->getAttribute('deadline')) {
            return 'no_deadline';
        }

        $today = now()->toDateString();
        $deadline = $this->getAttribute('deadline')->toDateString();

        if ($today > $deadline) {
            return 'overdue';
        } elseif ($today == $deadline) {
            return 'due_today';
        } else {
            $daysLeft = now()->diffInDays($this->getAttribute('deadline'), false);
            if ($daysLeft <= 3) {
                return 'due_soon';
            }
            return 'on_time';
        }
    }

    // Method untuk membuat log notifikasi deadline
    public function createDeadlineNotification()
    {
        if ($this->isOverdue()) {
            $this->logs()->create([
                'user_id' => Auth::id() ?? 1,
                'status_sebelum' => $this->status ?? 'Menunggu',
                'status_sesudah' => $this->status ?? 'Menunggu',
                'keterangan' => "⚠️ PERINGATAN: Permohonan telah melewati deadline ({$this->getAttribute('deadline')->format('d/m/Y')})",
                'action' => 'deadline_overdue',
                'old_data' => null,
                'new_data' => json_encode(['deadline' => $this->getAttribute('deadline')->toDateString()])
            ]);
        }
    }
}