<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\LogPermohonan;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Exports\PermohonanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil parameter dari request
        $searchQuery = $request->query('search');
        $selectedSektor = $request->query('sektor');
        $selectedDateFilter = $request->query('date_filter');
        $customDateFrom = $request->query('custom_date_from');
        $customDateTo = $request->query('custom_date_to');
        $selectedStatus = $request->query('status');

        // Query dasar
        $permohonans = Permohonan::query();

        // Filter berdasarkan peran
        if ($user->role === 'dpmptsp') {
            // DPMPTSP melihat semua permohonan kecuali yang dibuat oleh penerbitan_berkas
            $permohonans->whereHas('user', function($query) {
                $query->where('role', '!=', 'penerbitan_berkas');
            });
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis melihat permohonan sesuai sektornya saja
            if ($user->sektor) {
                $permohonans->where('sektor', $user->sektor)
                    ->whereHas('user', function($query) {
                        $query->where('role', '!=', 'penerbitan_berkas');
                    });
            } else {
                // Jika PD Teknis belum ada sektor, tampilkan semua (fallback)
                $permohonans->whereHas('user', function($query) {
                    $query->where('role', '!=', 'penerbitan_berkas');
                });
            }
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas hanya melihat data yang dibuat oleh role penerbitan_berkas
            $permohonans->whereHas('user', function($query) {
                $query->where('role', 'penerbitan_berkas');
            });
        }
        // Admin melihat semua permohonan secara default

        // Terapkan filter sektor
        if ($selectedSektor) {
            $permohonans->where('sektor', $selectedSektor);
        }

        // Terapkan filter tanggal
        if ($selectedDateFilter) {
            $now = Carbon::now();
            $customDateFrom = $request->query('custom_date_from');
            $customDateTo = $request->query('custom_date_to');
            
            switch ($selectedDateFilter) {
                case 'today':
                    $permohonans->whereDate('created_at', $now->toDateString());
                    break;
                case 'yesterday':
                    $permohonans->whereDate('created_at', $now->subDay()->toDateString());
                    break;
                case 'this_week':
                    $permohonans->whereBetween('created_at', [
                        $now->startOfWeek()->toDateTimeString(),
                        $now->endOfWeek()->toDateTimeString()
                    ]);
                    break;
                case 'last_week':
                    $permohonans->whereBetween('created_at', [
                        $now->subWeek()->startOfWeek()->toDateTimeString(),
                        $now->subWeek()->endOfWeek()->toDateTimeString()
                    ]);
                    break;
                case 'this_month':
                    $permohonans->whereMonth('created_at', $now->month)
                               ->whereYear('created_at', $now->year);
                    break;
                case 'last_month':
                    $lastMonth = $now->subMonth();
                    $permohonans->whereMonth('created_at', $lastMonth->month)
                               ->whereYear('created_at', $lastMonth->year);
                    break;
                case 'custom':
                    if ($customDateFrom && $customDateTo) {
                        // Filter range tanggal
                        $permohonans->whereBetween('created_at', [
                            Carbon::parse($customDateFrom)->startOfDay()->toDateTimeString(),
                            Carbon::parse($customDateTo)->endOfDay()->toDateTimeString()
                        ]);
                    } elseif ($customDateFrom) {
                        // Hanya dari tanggal (sampai hari ini)
                        $permohonans->whereDate('created_at', '>=', $customDateFrom);
                    } elseif ($customDateTo) {
                        // Hanya sampai tanggal (dari awal)
                        $permohonans->whereDate('created_at', '<=', $customDateTo);
                    }
                    break;
            }
        }

        // Terapkan filter status
        if ($selectedStatus) {
            if ($selectedStatus === 'Terlambat') {
                // Samakan logika dengan Permohonan::isOverdue()
                // - Memiliki deadline, dan deadline < hari ini
                // - BUKAN status final (Diterima, Ditolak)
                // - verifikasi_pd_teknis BUKAN 'Berkas Disetujui'
                $today = now()->toDateString();
                $permohonans
                    ->whereNotNull('deadline')
                    ->whereDate('deadline', '<', $today)
                    ->whereNotIn('status', ['Diterima', 'Ditolak'])
                    ->where(function ($q) {
                        $q->whereNull('verifikasi_pd_teknis')
                          ->orWhere('verifikasi_pd_teknis', '!=', 'Berkas Disetujui');
                    });
            } else {
                $permohonans->where('status', $selectedStatus);
            }
        }

        // Terapkan logika pencarian
        if ($searchQuery) {
            $permohonans->where(function ($query) use ($searchQuery) {
                $query->where('no_permohonan', 'like', '%' . $searchQuery . '%')
                      ->orWhere('nama_usaha', 'like', '%' . $searchQuery . '%');
            });
        }

        // Urutkan data: data lama di atas, data baru di bawah (untuk semua role)
        $permohonans = $permohonans->orderBy('created_at', 'asc')->get();
        
        // Ambil daftar sektor unik dari database dan gabungkan dengan sektor yang tersedia
        $sektorsFromDb = Permohonan::select('sektor')->whereNotNull('sektor')->distinct()->pluck('sektor');
        $availableSektors = ['Dinkopdag', 'Disbudpar', 'Dinkes', 'Dishub', 'Dprkpp', 'Dkpp', 'Dlh', 'Disperinaker'];
        $sektors = $availableSektors;

        return view('permohonan.index', compact('permohonans', 'sektors', 'selectedSektor', 'searchQuery', 'selectedDateFilter', 'customDateFrom', 'customDateTo', 'selectedStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $verifikators = ['RAMLAN', 'SURYA', 'ALI', 'WILDAN A', 'TYO', 'WILDAN M', 'YOLA', 'NAURA'];
        $sektors = ['Dinkopdag', 'Disbudpar', 'Dinkes', 'Dishub', 'Dprkpp', 'Dkpp', 'Dlh', 'Disperinaker'];
        $jenisPelakuUsahas = ['Orang Perseorangan', 'Badan Usaha'];
        
        // CSS classes untuk hide field berdasarkan role
        $cssClasses = $this->getRoleBasedCssClasses($user);
        $jenisUsahas = [
            'Perseroan Terbatas (PT)',
            'Perseroan Terbatas (PT) Perorangan',
            'Persekutuan Komanditer (CV/Commanditaire Vennootschap)',
            'Persekutuan Firma (FA / Venootschap Onder Firma)',
            'Persekutuan Perdata',
            'Perusahaan Umum (Perum)',
            'Perusahaan Umum Daerah (Perumda)',
            'Badan Hukum Lainnya',
            'Koperasi',
            'Persekutuan dan Perkumpulan',
            'Yayasan',
            'Badan Layanan Umum',
            'BUM Desa',
            'BUM Desa Bersama',
        ];
        $jenisProyeks = ['Utama', 'Pendukung', 'Pendukung UMKU', 'Kantor Cabang Administratif'];
        $verificationStatusOptions = ['Berkas Disetujui', 'Berkas Diperbaiki', 'Pemohon Dihubungi', 'Berkas Diunggah Ulang', 'Pemohon Belum Dihubungi'];

        return view('permohonan.create', compact('verifikators', 'sektors', 'jenisPelakuUsahas', 'jenisUsahas', 'jenisProyeks', 'verificationStatusOptions', 'cssClasses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $isDpmptsp = $user->role === 'dpmptsp';

        $rules = [
            'tanggal_permohonan' => 'nullable|date',
            'jenis_pelaku_usaha' => 'nullable|string|in:Orang Perseorangan,Badan Usaha',
            'nik' => 'nullable|string|max:16',
            'nama_usaha' => 'nullable|string', // Pastikan ini ada untuk input teks
            'nama_perusahaan' => 'nullable|string',
            'jenis_badan_usaha' => 'nullable|string', // Tambahkan ini untuk dropdown Jenis Badan Usaha
            'nib' => 'nullable|string|max:20',
            'alamat_perusahaan' => 'nullable|string',
            'sektor' => 'nullable|string',
            'kbli' => 'nullable|string',
            'inputan_teks' => 'nullable|string',
            'modal_usaha' => 'nullable|numeric',
            'jenis_proyek' => 'nullable|string|in:Utama,Pendukung,Pendukung UMKU,Kantor Cabang',
            'no_proyek' => 'nullable|string',
            'pemilik' => 'nullable|string',
            'nama_perizinan' => 'nullable|string',
            'skala_usaha' => 'nullable|string',
            'risiko' => 'nullable|string',
            'jangka_waktu' => 'nullable|integer|min:1',
            'no_telephone' => 'nullable|string|max:100',
            'deadline' => 'nullable|date|after_or_equal:today', // CREATE: deadline harus >= hari ini
            'verifikator' => 'nullable|string',
            'status' => 'required|in:Menunggu,Dikembalikan,Diterima,Ditolak',
            'verifikasi_pd_teknis' => 'nullable|string',
            'verifikasi_dpmptsp' => 'nullable|string',
            'pengembalian' => 'nullable|date',
            'keterangan_pengembalian' => 'nullable|string',
            'menghubungi' => 'nullable|date',
            'keterangan_menghubungi' => 'nullable|string',
            'status_menghubungi' => 'nullable|string',
            'perbaikan' => 'nullable|date',
            'keterangan_perbaikan' => 'nullable|string',
            'terbit' => 'nullable|date',
            'keterangan_terbit' => 'nullable|string',
            'pemroses_dan_tgl_surat' => 'nullable|string',
        ];

        // Validasi kondisional berdasarkan role
        if ($user->role === 'pd_teknis') {
            // PD Teknis wajib isi: no_permohonan, tanggal_permohonan, jenis_pelaku_usaha, nib, status
            $rules['no_permohonan'] = 'required|string|unique:permohonans,no_permohonan';
            $rules['tanggal_permohonan'] = 'required|date';
            $rules['jenis_pelaku_usaha'] = 'required|in:Orang Perseorangan,Badan Usaha';
            $rules['jenis_badan_usaha'] = 'nullable|string';
            $rules['nib'] = 'required|string|max:20';
            $rules['verifikator'] = 'nullable|string';
            $rules['status'] = 'required|in:Menunggu,Dikembalikan,Diterima,Ditolak,Terlambat';
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP wajib isi: nama_usaha, alamat_perusahaan, modal_usaha, jenis_proyek, verifikator, status
            $rules['nama_usaha'] = 'required|string';
            $rules['alamat_perusahaan'] = 'required|string';
            $rules['modal_usaha'] = 'required|numeric';
            $rules['jenis_proyek'] = 'required|string';
            $rules['verifikator'] = 'required|string';
            $rules['status'] = 'required|in:Menunggu,Dikembalikan,Diterima,Ditolak,Terlambat';
        } else {
            // Admin wajib isi semua field utama
            $rules['no_permohonan'] = 'required|string|unique:permohonans,no_permohonan';
            $rules['tanggal_permohonan'] = 'required|date';
            $rules['jenis_pelaku_usaha'] = 'required|in:Orang Perseorangan,Badan Usaha';
            $rules['jenis_badan_usaha'] = 'nullable|string';
            $rules['verifikator'] = 'required|string';
            $rules['status'] = 'required|in:Menunggu,Dikembalikan,Diterima,Ditolak,Terlambat';
        }
        
        // Status perlu tetap tervalidasi; verifikator tidak wajib untuk PD Teknis
        $rules['status'] = 'required|in:Dikembalikan,Diterima,Ditolak,Terlambat';

        $validated = $request->validate(
            $rules,
            [
                'no_permohonan.required' => 'Nomor permohonan wajib diisi.',
                'no_permohonan.unique' => 'Nomor permohonan sudah digunakan. Silakan ganti dengan nomor lain.',
            ]
        );
        
        // Tambahkan user_id ke data yang akan disimpan
        $validated['user_id'] = $user->id;
        
        // Role-based field protection untuk CREATE
        if ($user->role === 'pd_teknis') {
            // PD Teknis tidak boleh mengisi nama_usaha
            $validated['nama_usaha'] = null;
            // PD Teknis tidak mengatur verifikator
            $validated['verifikator'] = null;
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP tidak boleh mengisi nama_perusahaan
            $validated['nama_perusahaan'] = null;
        }
        
        // PENTING: Jika jenis_pelaku_usaha adalah 'Orang Perseorangan', pastikan jenis_badan_usaha di-null-kan
        if (isset($validated['jenis_pelaku_usaha']) && $validated['jenis_pelaku_usaha'] === 'Orang Perseorangan') {
            $validated['jenis_badan_usaha'] = null;
        }

        // PENTING: Jika jenis_pelaku_usaha adalah 'Badan Usaha', pastikan nik di-null-kan
        if (isset($validated['jenis_pelaku_usaha']) && $validated['jenis_pelaku_usaha'] === 'Badan Usaha') {
            $validated['nik'] = null;
        }
        
        // LOGIKA KHUSUS UNTUK DPMPTSP
        
        // Jika DPMPTSP dan no_permohonan kosong, buat nomor draft
        if ($isDpmptsp && empty($validated['no_permohonan'])) {
            $validated['no_permohonan'] = 'Draft-' . $user->name . '-' . Carbon::now()->format('YmdHis');
        }
        // Jika DPMPTSP dan jenis_pelaku_usaha kosong, set default ke 'Badan Usaha'
        if ($isDpmptsp && empty($validated['jenis_pelaku_usaha'])) {
            $validated['jenis_pelaku_usaha'] = 'Badan Usaha';
        }

        $permohonan = Permohonan::create($validated);

        // Buat log
        $tanggalBuat = now()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y');
        LogPermohonan::create([
            'permohonan_id' => $permohonan->id,
            'user_id' => Auth::id(),
            'status_sebelum' => 'Draft',
            'status_sesudah' => $permohonan->status,
            'keterangan' => 'Permohonan baru dibuat pada <strong>' . $tanggalBuat . '</strong>',
        ]);

        // Cek dan buat notifikasi deadline jika ada
        if ($permohonan->getAttribute('deadline')) {
            $permohonan->createDeadlineNotification();
        }

        return redirect()->route('dashboard')->with('success', 'Permohonan berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Permohonan $permohonan)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Authorization check berdasarkan role
        // Admin bisa lihat semua
        if ($user->role === 'admin') {
            // Admin bisa lihat semua permohonan
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP tidak bisa lihat permohonan yang dibuat oleh penerbitan_berkas
            if ($permohonan->user && $permohonan->user->role === 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk melihat permohonan ini.');
            }
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis hanya bisa lihat permohonan sesuai sektornya (kecuali yang dibuat oleh penerbitan_berkas)
            if ($permohonan->user && $permohonan->user->role === 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk melihat permohonan ini.');
            }
            if ($user->sektor && $permohonan->sektor !== $user->sektor) {
                abort(403, 'Anda tidak memiliki izin untuk melihat permohonan dari sektor lain.');
            }
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas hanya bisa lihat permohonan yang dibuat oleh role penerbitan_berkas
            if (!$permohonan->user || $permohonan->user->role !== 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk melihat permohonan ini.');
            }
        }
        
        $logs = LogPermohonan::where('permohonan_id', $permohonan->id)->orderBy('created_at', 'desc')->get();
        return view('permohonan.show', compact('permohonan', 'logs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permohonan $permohonan)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Authorization check berdasarkan role
        // Admin bisa edit semua
        if ($user->role === 'admin') {
            // Admin bisa edit semua permohonan
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP tidak bisa edit permohonan yang dibuat oleh penerbitan_berkas
            if ($permohonan->user && $permohonan->user->role === 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk mengedit permohonan ini.');
            }
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis hanya bisa edit permohonan sesuai sektornya (kecuali yang dibuat oleh penerbitan_berkas)
            if ($permohonan->user && $permohonan->user->role === 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk mengedit permohonan ini.');
            }
            if ($user->sektor && $permohonan->sektor !== $user->sektor) {
                abort(403, 'Anda tidak memiliki izin untuk mengedit permohonan dari sektor lain.');
            }
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas hanya bisa edit permohonan yang dibuat oleh role penerbitan_berkas
            if (!$permohonan->user || $permohonan->user->role !== 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk mengedit permohonan ini.');
            }
        }
        
        $verifikators = ['RAMLAN', 'SURYA', 'ALI', 'WILDAN A', 'TYO', 'WILDAN M', 'YOLA', 'NAURA'];
        $sektors = ['Dinkopdag', 'Disbudpar', 'Dinkes', 'Dishub', 'Dprkpp', 'Dkpp', 'Dlh', 'Disperinaker'];
        $jenisPelakuUsahas = ['Orang Perseorangan', 'Badan Usaha'];
        
        // CSS classes untuk hide field berdasarkan role
        $cssClasses = $this->getRoleBasedCssClasses($user);
        $jenisUsahas = [
            'Perseroan Terbatas (PT)',
            'Perseroan Terbatas (PT) Perorangan',
            'Persekutuan Komanditer (CV/Commanditaire Vennootschap)',
            'Persekutuan Firma (FA / Venootschap Onder Firma)',
            'Persekutuan Perdata',
            'Perusahaan Umum (Perum)',
            'Perusahaan Umum Daerah (Perumda)',
            'Badan Hukum Lainnya',
            'Koperasi',
            'Persekutuan dan Perkumpulan',
            'Yayasan',
            'Badan Layanan Umum',
            'BUM Desa',
            'BUM Desa Bersama',
        ];
        $jenisProyeks = ['Utama', 'Pendukung', 'Pendukung UMKU', 'Kantor Cabang Administratif'];
        $verificationStatusOptions = ['Berkas Disetujui', 'Berkas Diperbaiki', 'Pemohon Dihubungi', 'Berkas Diunggah Ulang', 'Pemohon Belum Dihubungi'];

        return view('permohonan.edit', compact('permohonan', 'jenisPelakuUsahas', 'jenisUsahas', 'sektors', 'verifikators', 'jenisProyeks', 'verificationStatusOptions', 'cssClasses'));
    }

    /**
     * Get role-based CSS class for body element
     */
    private function getRoleBasedCssClasses($user)
    {
        if ($user->role === 'pd_teknis') {
            return 'role-pd-teknis';
        } elseif ($user->role === 'dpmptsp') {
            return 'role-dpmptsp';
        } elseif ($user->role === 'admin') {
            return 'role-admin';
        } else {
            return 'role-non-admin';
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permohonan $permohonan)
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Authorization check berdasarkan role
        // Admin bisa update semua
        if ($user->role === 'admin') {
            // Admin bisa update semua permohonan
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP tidak bisa update permohonan yang dibuat oleh penerbitan_berkas
            if ($permohonan->user && $permohonan->user->role === 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk memperbarui permohonan ini.');
            }
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis hanya bisa update permohonan sesuai sektornya (kecuali yang dibuat oleh penerbitan_berkas)
            if ($permohonan->user && $permohonan->user->role === 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk memperbarui permohonan ini.');
            }
            if ($user->sektor && $permohonan->sektor !== $user->sektor) {
                abort(403, 'Anda tidak memiliki izin untuk memperbarui permohonan dari sektor lain.');
            }
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas hanya bisa update permohonan yang dibuat oleh role penerbitan_berkas
            if (!$permohonan->user || $permohonan->user->role !== 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk memperbarui permohonan ini.');
            }
        }

        $validated = $request->validate([
            'no_permohonan' => [
                'nullable',
                'string',
                Rule::unique('permohonans', 'no_permohonan')->ignore($permohonan->id),
            ],
            'tanggal_permohonan' => 'nullable|date',
            'jenis_pelaku_usaha' => 'nullable|string|in:Orang Perseorangan,Badan Usaha',
            'nik' => 'nullable|string|max:16',
            'nama_usaha' => 'nullable|string', // Pastikan ini ada untuk input teks
            'nama_perusahaan' => 'nullable|string',
            'jenis_badan_usaha' => 'nullable|string', // Tambahkan ini untuk dropdown Jenis Badan Usaha
            'nib' => 'nullable|string|max:20',
            'alamat_perusahaan' => 'nullable|string',
            'sektor' => 'nullable|string',
            'kbli' => 'nullable|string',
            'inputan_teks' => 'nullable|string',
            'modal_usaha' => 'nullable|numeric',
            'jenis_proyek' => 'nullable|string|in:Utama,Pendukung,Pendukung UMKU,Kantor Cabang',
            'no_proyek' => 'nullable|string',
            'pemilik' => 'nullable|string',
            'nama_perizinan' => 'nullable|string',
            'skala_usaha' => 'nullable|string',
            'risiko' => 'nullable|string',
            'jangka_waktu' => 'nullable|integer|min:1',
            'no_telephone' => 'nullable|string|max:100',
            'deadline' => 'nullable|date', // UPDATE: deadline boleh apa saja (termasuk yang sudah terlewat)
            // verifikator tidak wajib pada update (khususnya untuk PD Teknis)
            'verifikator' => 'sometimes|nullable|string',
            'status' => 'required|in:Diterima,Dikembalikan,Ditolak,Menunggu',
            'verifikasi_pd_teknis' => 'nullable|string',
            'verifikasi_dpmptsp' => 'nullable|string',
            'pengembalian' => 'nullable|date',
            'keterangan_pengembalian' => 'nullable|string',
            'menghubungi' => 'nullable|date',
            'keterangan_menghubungi' => 'nullable|string',
            'status_menghubungi' => 'nullable|string',
            'perbaikan' => 'nullable|date',
            'keterangan_perbaikan' => 'nullable|string',
            'terbit' => 'nullable|date',
            'keterangan_terbit' => 'nullable|string',
            'pemroses_dan_tgl_surat' => 'nullable|string',
        ], [
            'no_permohonan.unique' => 'Nomor permohonan sudah digunakan. Silakan ganti dengan nomor lain.',
        ]);
        
        // Role-based validation untuk update
        $user = Auth::user();
        if ($user->role === 'pd_teknis') {
            // PD Teknis tidak boleh mengubah nama_usaha
            $validated['nama_usaha'] = $permohonan->nama_usaha; // Keep original value
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP tidak boleh mengubah nama_perusahaan
            $validated['nama_perusahaan'] = $permohonan->nama_perusahaan; // Keep original value
        }
        
        // PENTING: Jika jenis_pelaku_usaha adalah 'Orang Perseorangan', pastikan jenis_badan_usaha di-null-kan
        if ($request->input('jenis_pelaku_usaha') === 'Orang Perseorangan') {
            $validated['jenis_badan_usaha'] = null;
        }

        // PENTING: Jika jenis_pelaku_usaha adalah 'Badan Usaha', pastikan nik di-null-kan
        if ($request->input('jenis_pelaku_usaha') === 'Badan Usaha') {
            $validated['nik'] = null;
        }

        $dataSebelum = $permohonan->getOriginal();
        
        $permohonan->update($validated);

        // Log perubahan
        $perubahan = $permohonan->getChanges();
        
        if (!empty(Arr::except($perubahan, ['updated_at']))) {
            $deskripsiLog = [];
            foreach ($perubahan as $field => $nilaiBaru) {
                if ($field === 'updated_at') continue;
                
                $nilaiLama = $dataSebelum[$field] ?? 'Kosong';
                if (in_array($field, ['tanggal_permohonan', 'pengembalian', 'menghubungi', 'perbaikan', 'terbit']) && $nilaiLama && $nilaiLama !== 'Kosong') {
                    try {
                        $nilaiLama = Carbon::parse($nilaiLama)->locale('id')->translatedFormat('d-m-Y');
                    } catch (\Exception $e) {
                        // Keep original value if parsing fails
                    }
                }
                
                if (in_array($field, ['tanggal_permohonan', 'pengembalian', 'menghubungi', 'perbaikan', 'terbit']) && $nilaiBaru && $nilaiBaru !== 'Kosong') {
                    try {
                        $nilaiBaru = Carbon::parse($nilaiBaru)->locale('id')->translatedFormat('d-m-Y');
                    } catch (\Exception $e) {
                        // Keep original value if parsing fails
                    }
                }
                
                $namaField = ucwords(str_replace('_', ' ', $field));
                
                if ($nilaiLama != $nilaiBaru) {
                   $deskripsiLog[] = "{$namaField} diubah dari '{$nilaiLama}' menjadi '{$nilaiBaru}'";
                }
            }

            if(!empty($deskripsiLog)) {
                LogPermohonan::create([
                    'permohonan_id' => $permohonan->id,
                    'user_id' => Auth::id(),
                    'status_sebelum' => $dataSebelum['status'],
                    'status_sesudah' => $permohonan->status,
                    'keterangan' => implode("\n• ", $deskripsiLog),
                ]);
            }
        }

        // Cek dan buat notifikasi deadline jika ada
        if ($permohonan->getAttribute('deadline')) {
            $permohonan->createDeadlineNotification();
        }

        return redirect()->route('permohonan.show', $permohonan)
            ->with('success', 'Data permohonan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permohonan $permohonan)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Authorization check berdasarkan role
        // Admin, PD Teknis, dan DPMPTSP bisa hapus semua (kecuali yang dibuat oleh penerbitan_berkas)
        if ($user->role === 'admin') {
            // Admin bisa hapus semua permohonan
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP tidak bisa hapus permohonan yang dibuat oleh penerbitan_berkas
            if ($permohonan->user && $permohonan->user->role === 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk menghapus permohonan ini.');
            }
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis hanya bisa hapus permohonan sesuai sektornya (kecuali yang dibuat oleh penerbitan_berkas)
            if ($permohonan->user && $permohonan->user->role === 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk menghapus permohonan ini.');
            }
            if ($user->sektor && $permohonan->sektor !== $user->sektor) {
                abort(403, 'Anda tidak memiliki izin untuk menghapus permohonan dari sektor lain.');
            }
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas hanya bisa hapus permohonan yang dibuat oleh role penerbitan_berkas
            if (!$permohonan->user || $permohonan->user->role !== 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk menghapus permohonan ini.');
            }
        }
        
        // Simpan data sebelum dihapus
        $permohonanId = $permohonan->id;
        $statusSebelum = $permohonan->status;
        
        // Buat log sebelum menghapus
        LogPermohonan::create([
            'permohonan_id' => $permohonanId,
            'user_id' => Auth::id(),
            'status_sebelum' => $statusSebelum,
            'status_sesudah' => 'Dihapus',
            'keterangan' => 'Permohonan dihapus',
        ]);

        // Hapus permohonan setelah log dibuat
        $permohonan->delete();

        return redirect()->route('dashboard')->with('success', 'Permohonan berhasil dihapus!');
    }

    /**
     * Export data permohonan to Excel
     */
    public function exportExcel()
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        return Excel::download(new PermohonanExport($user), 'data_permohonan_' . date('Y-m-d_H-i-s') . '.xlsx');
    }


    /**
     * Export data permohonan to PDF (Landscape optimized version)
     */
    public function exportPdfLandscape()
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $permohonans = $this->getFilteredPermohonans($user);
        
        $pdf = Pdf::loadView('permohonan.export-pdf-landscape', compact('permohonans'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('data_permohonan_landscape_' . date('Y-m-d_H-i-s') . '.pdf');
    }


    /**
     * Export data permohonan to PDF (Penerbitan Berkas version with TTD photos)
     */
    public function exportPdfPenerbitan()
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $permohonans = $this->getFilteredPermohonans($user);
        $ttdSettings = \App\Models\TtdSetting::getSettings();
        
        $pdf = Pdf::loadView('pdf.penerbitan-berkas', compact('permohonans', 'ttdSettings'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('data_permohonan_penerbitan_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered permohonans based on user role
     */
    private function getFilteredPermohonans($user)
    {
        $permohonans = Permohonan::with('user');

        // Filter berdasarkan peran
        if ($user->role === 'dpmptsp') {
            // DPMPTSP melihat semua permohonan kecuali yang dibuat oleh penerbitan_berkas
            $permohonans->whereHas('user', function($query) {
                $query->where('role', '!=', 'penerbitan_berkas');
            });
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis melihat permohonan sesuai sektornya saja
            if ($user->sektor) {
                $permohonans->where('sektor', $user->sektor)
                    ->whereHas('user', function($query) {
                        $query->where('role', '!=', 'penerbitan_berkas');
                    });
            } else {
                // Jika PD Teknis belum ada sektor, tampilkan semua (fallback)
                $permohonans->whereHas('user', function($query) {
                    $query->where('role', '!=', 'penerbitan_berkas');
                });
            }
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas hanya melihat data yang dibuat oleh role penerbitan_berkas
            $permohonans->whereHas('user', function($query) {
                $query->where('role', 'penerbitan_berkas');
            });
        }
        // Admin melihat semua permohonan secara default

        // Urutkan data: data lama di atas, data baru di bawah (untuk semua role)
        return $permohonans->orderBy('created_at', 'asc')->get();
    }

    /**
     * Show BAP form untuk permohonan
     * 
     * Akses: Semua user yang sudah login dapat mengakses BAP
     * - Admin: Bisa akses semua permohonan
     * - DPMPTSP: Bisa akses semua permohonan
     * - PD Teknis: Bisa akses semua permohonan
     * - Penerbitan Berkas: Bisa akses semua permohonan
     */
    public function bap(Permohonan $permohonan)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Authorization check berdasarkan role untuk BAP
        // Semua role bisa akses BAP, tapi tetap perlu cek apakah mereka bisa lihat permohonan tersebut
        if ($user->role === 'admin') {
            // Admin bisa akses semua permohonan
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP tidak bisa akses permohonan yang dibuat oleh penerbitan_berkas
            if ($permohonan->user && $permohonan->user->role === 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk mengakses BAP permohonan ini.');
            }
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis bisa akses semua permohonan (sesuai kebutuhan BAP)
            // Tidak perlu filter sektor karena BAP bisa dibuat untuk semua permohonan
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas bisa akses semua permohonan untuk BAP
        }

        // Load relationships
        $permohonan->load('user');
        
        // Ambil data koordinator dari database
        $koordinator = AppSetting::getKoordinator();
        
        // Cek apakah user adalah admin untuk menampilkan edit TTD
        $isAdmin = $user->role === 'admin';
        
        return view('permohonan.bap-form', compact('permohonan', 'koordinator', 'isAdmin'));
    }

    /**
     * Generate BAP PDF dari form
     * 
     * Akses: Semua user yang sudah login dapat generate BAP PDF
     * - Admin: Bisa generate BAP untuk semua permohonan
     * - DPMPTSP: Bisa generate BAP untuk semua permohonan
     * - PD Teknis: Bisa generate BAP untuk semua permohonan
     * - Penerbitan Berkas: Bisa generate BAP untuk semua permohonan
     */
    public function generateBap(Request $request, Permohonan $permohonan)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Authorization check berdasarkan role untuk generate BAP
        // Semua role bisa generate BAP, tapi tetap perlu cek apakah mereka bisa lihat permohonan tersebut
        if ($user->role === 'admin') {
            // Admin bisa generate BAP untuk semua permohonan
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP tidak bisa generate BAP untuk permohonan yang dibuat oleh penerbitan_berkas
            if ($permohonan->user && $permohonan->user->role === 'penerbitan_berkas') {
                abort(403, 'Anda tidak memiliki izin untuk generate BAP permohonan ini.');
            }
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis bisa generate BAP untuk semua permohonan (sesuai kebutuhan BAP)
            // Tidak perlu filter sektor karena BAP bisa dibuat untuk semua permohonan
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas bisa generate BAP untuk semua permohonan
        }

        try {
            // Validasi form
            $validated = $request->validate([
                'nomor_bap' => 'required|string',
                'tanggal_pemeriksaan' => 'required|date',
                'nomor_surat_tugas' => 'nullable|string',
                'tanggal_surat_tugas' => 'nullable|date',
                'hasil_peninjauan_lapangan' => 'nullable|string',
                'keputusan' => 'required|in:Disetujui,Perbaikan,Penolakan',
                'catatan' => 'nullable|string',
                'persyaratan' => 'required|array|min:1',
                'persyaratan.*.nama' => 'required|string',
                'persyaratan.*.status' => 'required|in:Sesuai,Tidak Sesuai',
                'persyaratan.*.subItems' => 'nullable|array',
                'persyaratan.*.subItems.*.nama' => 'nullable|string',
                'persyaratan.*.subItems.*.status' => 'nullable|in:Sesuai,Tidak Sesuai',
                'ttd_memeriksa' => 'nullable|string',
                'ttd_menyetujui' => 'nullable|string',
                'ttd_mengetahui' => 'nullable|string',
                'nama_memeriksa' => 'nullable|string',
                'nip_memeriksa' => 'nullable|string',
                'nama_menyetujui' => 'nullable|string',
                'nip_menyetujui' => 'nullable|string',
                'nama_mengetahui' => 'nullable|string',
                'nip_mengetahui' => 'nullable|string',
            ], [
                'persyaratan.required' => 'Mohon tambahkan minimal 1 persyaratan sebelum generate PDF.',
                'persyaratan.min' => 'Mohon tambahkan minimal 1 persyaratan sebelum generate PDF.',
                'persyaratan.*.nama.required' => 'Nama persyaratan harus diisi.',
                'persyaratan.*.status.required' => 'Status persyaratan harus dipilih (Sesuai atau Tidak Sesuai).',
            ]);

            // Bersihkan subItems yang kosong
            foreach ($validated['persyaratan'] as &$item) {
                if (isset($item['subItems']) && is_array($item['subItems'])) {
                    $item['subItems'] = array_filter($item['subItems'], function($subItem) {
                        return !empty($subItem['nama']);
                    });
                    // Re-index array
                    $item['subItems'] = array_values($item['subItems']);
                }
            }

            // Load relationships
            $permohonan->load('user');
            
            // Ambil TTD Mengetahui dari database jika tidak ada di form
            $koordinator = AppSetting::getKoordinator();
            if (empty($validated['ttd_mengetahui']) && $koordinator->ttd_bap_mengetahui) {
                $ttdMengetahui = $koordinator->ttd_bap_mengetahui;
                // Jika bukan base64, berarti path file
                if (!str_starts_with($ttdMengetahui, 'data:image')) {
                    $filePath = storage_path('app/public/ttd_photos/' . $ttdMengetahui);
                    if (file_exists($filePath)) {
                        $ttdMengetahui = 'data:image/png;base64,' . base64_encode(file_get_contents($filePath));
                    }
                }
                $validated['ttd_mengetahui'] = $ttdMengetahui;
            }
            
            // Jika nama dan NIP Mengetahui kosong, ambil dari database
            if (empty($validated['nama_mengetahui']) && $koordinator->nama_mengetahui) {
                $validated['nama_mengetahui'] = $koordinator->nama_mengetahui;
            }
            if (empty($validated['nip_mengetahui']) && $koordinator->nip_mengetahui) {
                $validated['nip_mengetahui'] = $koordinator->nip_mengetahui;
            }
            
            // Pastikan semua data aman sebelum generate PDF
            $pdfData = [
                'permohonan' => $permohonan,
                'data' => array_merge([
                    'nomor_bap' => '',
                    'tanggal_pemeriksaan' => now()->format('Y-m-d'),
                    'nomor_surat_tugas' => '',
                    'tanggal_surat_tugas' => null,
                    'hasil_peninjauan_lapangan' => '',
                    'keputusan' => 'Disetujui',
                    'catatan' => '',
                    'persyaratan' => [],
                    'ttd_memeriksa' => null,
                    'ttd_menyetujui' => null,
                    'ttd_mengetahui' => null,
                    'nama_memeriksa' => null,
                    'nip_memeriksa' => null,
                    'nama_menyetujui' => null,
                    'nip_menyetujui' => null,
                    'nama_mengetahui' => null,
                    'nip_mengetahui' => null
                ], $validated)
            ];
            
            // Log untuk debugging (hapus di production jika tidak diperlukan)
            \Log::info('BAP PDF Data:', [
                'persyaratan_count' => count($pdfData['data']['persyaratan'] ?? []),
                'has_persyaratan' => !empty($pdfData['data']['persyaratan']),
            ]);
            
            // Generate PDF BAP
            $pdf = Pdf::loadView('permohonan.bap-pdf', $pdfData);
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'dpi' => 150,
                'defaultFont' => 'Times New Roman'
            ]);
            
            // Bersihkan filename dari karakter yang tidak diizinkan
            $noPermohonan = $permohonan->no_permohonan ?? 'N/A';
            // Ganti karakter yang tidak diizinkan: / \ : * ? " < > |
            $noPermohonanClean = preg_replace('/[\/\\\\:\*\?"<>\|]/', '_', $noPermohonan);
            $filename = 'BAP_' . $noPermohonanClean . '_' . date('Y-m-d') . '.pdf';
            
            \Log::info('Generating BAP PDF with filename: ' . $filename);
            
            // Generate dan download PDF
            return $pdf->download($filename);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Barryvdh\DomPDF\Exception\PdfException $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            \Log::error('Request data: ' . json_encode($request->all(), JSON_PRETTY_PRINT));
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghasilkan PDF. Pastikan semua data sudah lengkap dan coba lagi. Error: ' . $e->getMessage())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Error generating BAP PDF: ' . $e->getMessage());
            \Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            \Log::error('Request data: ' . json_encode($request->all(), JSON_PRETTY_PRINT));
            
            // Tampilkan error yang lebih informatif untuk debugging
            $errorMessage = 'Terjadi kesalahan saat menghasilkan PDF. ';
            if (str_contains($e->getMessage(), 'file_get_contents')) {
                $errorMessage .= 'Logo tidak ditemukan. ';
            } elseif (str_contains($e->getMessage(), 'parse')) {
                $errorMessage .= 'Format tanggal tidak valid. ';
            } elseif (str_contains($e->getMessage(), 'persyaratan')) {
                $errorMessage .= 'Data persyaratan tidak valid. Pastikan semua persyaratan sudah diisi dengan lengkap. ';
            } else {
                $errorMessage .= 'Silakan coba lagi atau hubungi administrator. ';
            }
            $errorMessage .= 'Detail: ' . $e->getMessage();
            
            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }

    /**
     * Update TTD BAP untuk Mengetahui (hanya admin)
     */
    public function updateBapTtd(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Cek authorization - hanya admin yang bisa update
        if ($user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
        
        $request->validate([
            'nama_mengetahui' => 'required|string|max:255',
            'nip_mengetahui' => 'required|string|max:255',
            'ttd_bap_mengetahui' => 'nullable|string', // base64 signature
            'ttd_bap_mengetahui_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $koordinator = AppSetting::getKoordinator();
        
        $data = [
            'nama_mengetahui' => $request->nama_mengetahui,
            'nip_mengetahui' => $request->nip_mengetahui,
        ];
        
        // Handle upload TTD (file upload)
        if ($request->hasFile('ttd_bap_mengetahui_file')) {
            $file = $request->file('ttd_bap_mengetahui_file');
            $filename = 'bap_mengetahui_ttd_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('ttd_photos', $filename, 'public');
            
            if ($path) {
                // Simpan sebagai path file
                $data['ttd_bap_mengetahui'] = $filename;
            }
        }
        // Handle base64 signature
        elseif ($request->has('ttd_bap_mengetahui') && !empty($request->ttd_bap_mengetahui)) {
            // Simpan sebagai base64
            $data['ttd_bap_mengetahui'] = $request->ttd_bap_mengetahui;
        }
        
        $koordinator->update($data);
        
        return redirect()->back()->with('success', 'TTD BAP Mengetahui berhasil diperbarui.');
    }
}