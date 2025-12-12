<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\PenerbitanBerkas;
use App\Models\TtdSetting;
use App\Models\LogPermohonan;
use App\Exports\PenerbitanBerkasExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data permohonan berdasarkan role
        if ($user->role === 'admin') {
            // Admin melihat semua data
            $permohonans = Permohonan::with('user')->orderBy('created_at', 'desc')->get();
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP melihat semua permohonan kecuali yang dibuat oleh penerbitan_berkas
            $permohonans = Permohonan::with('user')
                ->whereHas('user', function($query) {
                    $query->where('role', '!=', 'penerbitan_berkas');
                })->orderBy('created_at', 'desc')->get();
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis melihat permohonan sesuai sektornya saja
            if ($user->sektor) {
                $permohonans = Permohonan::with('user')
                    ->where('sektor', $user->sektor)
                    ->whereHas('user', function($query) {
                        $query->where('role', '!=', 'penerbitan_berkas');
                    })->orderBy('created_at', 'desc')->get();
            } else {
                // Jika PD Teknis belum ada sektor, tampilkan semua (fallback)
                $permohonans = Permohonan::with('user')
                    ->whereHas('user', function($query) {
                        $query->where('role', '!=', 'penerbitan_berkas');
                    })->orderBy('created_at', 'desc')->get();
            }
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas melihat modul khususnya sendiri (data terpisah)
            return $this->penerbitanBerkas($request);
        }
        
        // Hitung statistik:
        // Total = semua permohonan (termasuk Menunggu, Diterima, Dikembalikan, Ditolak)
        $totalPermohonan = $permohonans->count();

        // Terlambat = semua data yang melewati deadline (semua status bisa terlambat)
        $terlambatCount = $permohonans->filter(function($permohonan) {
            return $permohonan->isOverdue();
        })->count();
        
        $stats = [
            'totalPermohonan' => $totalPermohonan, // Semua permohonan
            'diterima' => $permohonans->where('status', 'Diterima')->count(),
            'dikembalikan' => $permohonans->where('status', 'Dikembalikan')->count(),
            'ditolak' => $permohonans->where('status', 'Ditolak')->count(),
            'terlambat' => $terlambatCount,
        ];
        
        // Ambil data terlambat untuk tampilan khusus (semua status yang terlambat)
        $terlambatData = $permohonans->filter(function($permohonan) {
            return $permohonan->isOverdue();
        });

        // Return view berdasarkan role
        switch ($user->role) {
            case 'admin':
                return view('dashboard.admin', compact('permohonans', 'stats', 'terlambatData'));
            case 'dpmptsp':
                return view('dashboard.dpmptsp', compact('permohonans', 'stats', 'terlambatData'));
            case 'pd_teknis':
                return view('dashboard.pd_teknis', compact('permohonans', 'stats', 'terlambatData'));
            case 'penerbitan_berkas':
                return view('dashboard.penerbitan_berkas', compact('permohonans', 'stats', 'terlambatData'));
            default:
                $request->session()->regenerateToken();
                return redirect('/login')->with('error', 'Peran tidak valid, hubungi admin.');
        }
    }


    public function statistik(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Ambil parameter dari request
        $selectedDateFilter = $request->query('date_filter');
        $customDateFrom = $request->query('custom_date_from');
        $customDateTo = $request->query('custom_date_to');
        $selectedSektor = $request->query('sektor');
        
        // Query dasar
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
        
        // Filter sektor (hanya untuk dpmptsp dan admin)
        if (in_array($user->role, ['dpmptsp', 'admin']) && $selectedSektor) {
            $permohonans->where('sektor', $selectedSektor);
        }
        
        // Terapkan filter tanggal
        if ($selectedDateFilter) {
            $now = Carbon::now();
            
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
        
        // Ambil data permohonan
        $permohonans = $permohonans->orderBy('created_at', 'asc')->get();
        
        // Hitung statistik untuk chart (Terlambat otomatis berdasarkan deadline)
        $terlambatCount = $permohonans->filter(function($permohonan) {
            return $permohonan->isOverdue();
        })->count();
        
        $stats = [
            'totalPermohonan' => $permohonans->count(),
            'dikembalikan' => $permohonans->where('status', 'Dikembalikan')->count(),
            'diterima' => $permohonans->where('status', 'Diterima')->count(),
            'ditolak' => $permohonans->where('status', 'Ditolak')->count(),
            'terlambat' => $terlambatCount, // Otomatis berdasarkan deadline system
        ];

        // Daftar sektor untuk filter (hanya untuk dpmptsp dan admin)
        $sektors = [];
        if (in_array($user->role, ['dpmptsp', 'admin'])) {
            $sektors = [
                'Dinkopdag' => 'Dinkopdag - Dinas Koperasi dan Perdagangan',
                'Disbudpar' => 'Disbudpar - Dinas Kebudayaan dan Pariwisata',
                'Dinkes' => 'Dinkes - Dinas Kesehatan',
                'Dishub' => 'Dishub - Dinas Perhubungan',
                'Dprkpp' => 'Dprkpp - Dinas Pemberdayaan Perempuan dan Perlindungan Anak',
                'Dkpp' => 'Dkpp - Dinas Ketahanan Pangan dan Perikanan',
                'Dlh' => 'Dlh - Dinas Lingkungan Hidup',
                'Disperinaker' => 'Disperinaker - Dinas Perindustrian dan Tenaga Kerja'
            ];
        }

        return view('statistik', compact('stats', 'selectedDateFilter', 'customDateFrom', 'customDateTo', 'selectedSektor', 'sektors', 'user'));
    }

    public function penerbitanBerkas(Request $request)
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Batasi akses hanya admin dan penerbitan_berkas
        if (!in_array($user->role, ['admin', 'penerbitan_berkas'])) {
            return redirect()->route('dashboard')->with('error', 'Tidak memiliki akses ke Penerbitan Berkas.');
        }

        // Filters
        $customDateFrom = $request->query('custom_date_from');
        $customDateTo = $request->query('custom_date_to');
        $search = $request->query('search');

        $query = PenerbitanBerkas::with('user');

        // Role admin dan penerbitan_berkas sama-sama melihat semua data (setara)
        // Tidak ada filter berdasarkan user_id

        // Filter custom tanggal langsung tanpa perlu dropdown
        if ($customDateFrom && $customDateTo) {
            // Filter range tanggal
            $query->whereBetween('tanggal_permohonan', [
                Carbon::parse($customDateFrom)->startOfDay()->toDateTimeString(),
                Carbon::parse($customDateTo)->endOfDay()->toDateTimeString()
            ]);
        } elseif ($customDateFrom) {
            // Hanya dari tanggal (sampai hari ini)
            $query->whereDate('tanggal_permohonan', '>=', $customDateFrom);
        } elseif ($customDateTo) {
            // Hanya sampai tanggal (dari awal)
            $query->whereDate('tanggal_permohonan', '<=', $customDateTo);
        }

        // Pencarian bebas
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('no_permohonan', 'like', "%{$search}%")
                  ->orWhere('no_proyek', 'like', "%{$search}%")
                  ->orWhere('nib', 'like', "%{$search}%")
                  ->orWhere('kbli', 'like', "%{$search}%")
                  ->orWhere('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('inputan_teks', 'like', "%{$search}%")
                  ->orWhere('pemilik', 'like', "%{$search}%")
                  ->orWhere('nama_perizinan', 'like', "%{$search}%")
                  ->orWhere('alamat_perusahaan', 'like', "%{$search}%");
            });
        }

        // Kumpulan lengkap untuk statistik (tanpa paginasi)
        // Order by tanggal_permohonan ASC, kemudian created_at ASC (data baru di bawah)
        $allForStats = (clone $query)->orderBy('tanggal_permohonan', 'asc')
                                     ->orderBy('created_at', 'asc')
                                     ->orderBy('id', 'asc')
                                     ->get();

        // Paginasi: per_page dapat dipilih (10/20/50/100)
        $perPage = (int) ($request->query('per_page', 20));
        if (!in_array($perPage, [10, 20, 50, 100], true)) {
            $perPage = 20;
        }
        // Order by tanggal_permohonan ASC, kemudian created_at ASC (data baru di bawah)
        $permohonans = $query->orderBy('tanggal_permohonan', 'asc')
                            ->orderBy('created_at', 'asc')
                            ->orderBy('id', 'asc')
                            ->paginate($perPage)->withQueryString();
        
        // Hitung statistik dari seluruh hasil terfilter
        $stats = [
            'totalPermohonan' => $allForStats->count(),
            'dikembalikan' => $allForStats->where('status', 'Dikembalikan')->count(),
            'diterima' => $allForStats->where('status', 'Diterima')->count(),
            'ditolak' => $allForStats->where('status', 'Ditolak')->count(),
        ];

        // Ambil data TTD settings
        $ttdSettings = TtdSetting::getSettings();

        return view('dashboard.penerbitan_berkas', compact('permohonans', 'stats', 'ttdSettings', 'customDateFrom', 'customDateTo', 'search', 'perPage'));
    }

    public function exportPenerbitanBerkasExcel(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if (!in_array($user->role, ['admin', 'penerbitan_berkas'])) {
            return redirect()->route('dashboard')->with('error', 'Tidak memiliki akses ke Penerbitan Berkas.');
        }

        $customDateFrom = $request->query('custom_date_from');
        $customDateTo = $request->query('custom_date_to');

        $query = PenerbitanBerkas::with('user');
        // Role admin dan penerbitan_berkas sama-sama melihat semua data (setara)
        // Tidak ada filter berdasarkan user_id

        // Filter custom tanggal langsung tanpa perlu dropdown
        if ($customDateFrom && $customDateTo) {
            // Filter range tanggal
            $query->whereBetween('tanggal_permohonan', [
                Carbon::parse($customDateFrom)->startOfDay()->toDateTimeString(),
                Carbon::parse($customDateTo)->endOfDay()->toDateTimeString()
            ]);
        } elseif ($customDateFrom) {
            // Hanya dari tanggal (sampai hari ini)
            $query->whereDate('tanggal_permohonan', '>=', $customDateFrom);
        } elseif ($customDateTo) {
            // Hanya sampai tanggal (dari awal)
            $query->whereDate('tanggal_permohonan', '<=', $customDateTo);
        }

        // Order by tanggal_permohonan ASC, kemudian created_at ASC (data baru di bawah)
        $data = $query->orderBy('tanggal_permohonan', 'asc')
                     ->orderBy('created_at', 'asc')
                     ->orderBy('id', 'asc')
                     ->get();
        return Excel::download(new PenerbitanBerkasExport($data), 'data_penerbitan_berkas_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportPenerbitanBerkasPdfLandscape(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if (!in_array($user->role, ['admin', 'penerbitan_berkas'])) {
            return redirect()->route('dashboard')->with('error', 'Tidak memiliki akses ke Penerbitan Berkas.');
        }

        $customDateFrom = $request->query('custom_date_from');
        $customDateTo = $request->query('custom_date_to');

        $query = PenerbitanBerkas::with('user');
        // Role admin dan penerbitan_berkas sama-sama melihat semua data (setara)
        // Tidak ada filter berdasarkan user_id

        // Filter custom tanggal langsung tanpa perlu dropdown
        if ($customDateFrom && $customDateTo) {
            // Filter range tanggal
            $query->whereBetween('tanggal_permohonan', [
                Carbon::parse($customDateFrom)->startOfDay()->toDateTimeString(),
                Carbon::parse($customDateTo)->endOfDay()->toDateTimeString()
            ]);
        } elseif ($customDateFrom) {
            // Hanya dari tanggal (sampai hari ini)
            $query->whereDate('tanggal_permohonan', '>=', $customDateFrom);
        } elseif ($customDateTo) {
            // Hanya sampai tanggal (dari awal)
            $query->whereDate('tanggal_permohonan', '<=', $customDateTo);
        }

        // Order by tanggal_permohonan ASC, kemudian created_at ASC (data baru di bawah)
        $penerbitanBerkas = $query->orderBy('tanggal_permohonan', 'asc')
                                 ->orderBy('created_at', 'asc')
                                 ->orderBy('id', 'asc')
                                 ->get();
        $ttdSettings = TtdSetting::getSettings();
        
        $pdf = PDF::loadView('pdf.penerbitan-berkas', compact('penerbitanBerkas', 'ttdSettings'));
        $pdf->setPaper('A4', 'landscape');
        $pdf->setOptions([
            'margin-top' => 10,
            'margin-right' => 5,
            'margin-bottom' => 10,
            'margin-left' => 5,
            'dpi' => 150
        ]);
        
        return $pdf->download('data_penerbitan_berkas_landscape_' . date('Y-m-d_H-i-s') . '.pdf');
    }


    public function storePenerbitanBerkas(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        if (!in_array($user->role, ['admin', 'penerbitan_berkas'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
        
        $rules = [
            'no_permohonan' => 'nullable|string|unique:penerbitan_berkas,no_permohonan',
            'no_proyek' => 'nullable|string',
            'tanggal_permohonan' => 'nullable|date',
            'nib' => 'nullable|string|max:20',
            'kbli' => 'nullable|string',
            'nama_usaha' => 'nullable|string',
            'inputan_teks' => 'nullable|string',
            'jenis_pelaku_usaha' => 'required|string|in:Orang Perseorangan,Badan Usaha',
            'jenis_badan_usaha' => 'nullable|string',
            'pemilik' => 'nullable|string',
            'modal_usaha' => 'nullable|numeric',
            'alamat_perusahaan' => 'nullable|string',
            'jenis_proyek' => 'nullable|string|in:Utama,Pendukung,Pendukung UMKU,Kantor Cabang',
            'nama_perizinan' => 'nullable|string',
            'skala_usaha' => 'required|string|in:Mikro,Usaha Kecil,Usaha Menengah,Usaha Besar',
            'risiko' => 'required|string|in:Rendah,Menengah Rendah,Menengah Tinggi,Tinggi',
            'verifikator' => 'nullable|string',
            'status' => 'nullable|string|in:Dikembalikan,Diterima,Ditolak,Menunggu',
            'nomor_bap' => 'required|string',
            'tanggal_bap' => 'required|date',
        ];

        // Jika jenis pelaku usaha adalah Badan Usaha, jenis_badan_usaha wajib diisi
        if ($request->jenis_pelaku_usaha === 'Badan Usaha') {
            $rules['jenis_badan_usaha'] = 'required|string';
        }

        $validated = $request->validate($rules);
        
        // Sanitize input teks untuk mencegah XSS
        $textFields = ['no_permohonan', 'no_proyek', 'nib', 'kbli', 'nama_usaha', 'inputan_teks', 
                      'jenis_badan_usaha', 'pemilik', 'alamat_perusahaan', 'jenis_proyek', 
                      'nama_perizinan', 'skala_usaha', 'risiko', 'verifikator', 'status', 'nomor_bap'];
        foreach ($textFields as $field) {
            if (isset($validated[$field]) && is_string($validated[$field])) {
                $validated[$field] = strip_tags($validated[$field]);
            }
        }
        
        // Tambahkan user_id ke data yang akan disimpan
        $validated['user_id'] = $user->id;
        
        // Jika jenis_pelaku_usaha adalah 'Orang Perseorangan', set jenis_badan_usaha ke null
        if ($validated['jenis_pelaku_usaha'] === 'Orang Perseorangan') {
            $validated['jenis_badan_usaha'] = null;
        }

        // Set default status jika tidak ada
        if (empty($validated['status'])) {
            $validated['status'] = 'Menunggu';
        }

        PenerbitanBerkas::create($validated);

        return redirect()->route('penerbitan-berkas')->with('success', 'Data penerbitan berkas berhasil ditambahkan!');
    }

    public function editPenerbitanBerkas($id)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Cek authorization - hanya admin dan penerbitan_berkas yang bisa edit
        if (!in_array($user->role, ['admin', 'penerbitan_berkas'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $permohonan = PenerbitanBerkas::findOrFail($id);
        
        // Format tanggal untuk input type="date" (Y-m-d format)
        // Handle null untuk data lama yang belum punya field ini
        $data = $permohonan->toArray();
        
        // Pastikan ID selalu ada di response untuk validasi di frontend
        $data['id'] = $permohonan->id;
        
        // Format tanggal_permohonan untuk input type="date"
        if ($permohonan->tanggal_permohonan) {
            $data['tanggal_permohonan'] = $permohonan->tanggal_permohonan->format('Y-m-d');
        } else {
            $data['tanggal_permohonan'] = null;
        }
        
        // Format tanggal_bap untuk input type="date"
        if ($permohonan->tanggal_bap) {
            $data['tanggal_bap'] = $permohonan->tanggal_bap->format('Y-m-d');
        } else {
            $data['tanggal_bap'] = null; // Pastikan null untuk data lama
        }
        
        // Pastikan nomor_bap null jika tidak ada
        if (!isset($data['nomor_bap'])) {
            $data['nomor_bap'] = null;
        }
        
        // Pastikan skala_usaha dan risiko ada di response
        $data['skala_usaha'] = $permohonan->skala_usaha ?? null;
        $data['risiko'] = $permohonan->risiko ?? null;
        
        return response()->json($data);
    }

    public function updatePenerbitanBerkas(Request $request, $id)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Cek authorization - hanya admin dan penerbitan_berkas yang bisa update
        if (!in_array($user->role, ['admin', 'penerbitan_berkas'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
        
        $permohonan = PenerbitanBerkas::findOrFail($id);
        
        $rules = [
            'no_permohonan' => 'nullable|string|unique:penerbitan_berkas,no_permohonan,' . $id,
            'no_proyek' => 'nullable|string',
            'tanggal_permohonan' => 'nullable|date',
            'nib' => 'nullable|string|max:20',
            'kbli' => 'nullable|string',
            'nama_usaha' => 'nullable|string',
            'inputan_teks' => 'nullable|string',
            'jenis_pelaku_usaha' => 'required|string|in:Orang Perseorangan,Badan Usaha',
            'jenis_badan_usaha' => 'nullable|string',
            'pemilik' => 'nullable|string',
            'modal_usaha' => 'nullable|numeric',
            'alamat_perusahaan' => 'nullable|string',
            'jenis_proyek' => 'nullable|string|in:Utama,Pendukung,Pendukung UMKU,Kantor Cabang',
            'nama_perizinan' => 'nullable|string',
            'skala_usaha' => 'required|string|in:Mikro,Usaha Kecil,Usaha Menengah,Usaha Besar',
            'risiko' => 'required|string|in:Rendah,Menengah Rendah,Menengah Tinggi,Tinggi',
            'verifikator' => 'nullable|string',
            'status' => 'nullable|string|in:Dikembalikan,Diterima,Ditolak,Menunggu',
            'nomor_bap' => 'nullable|string', // Nullable untuk data lama yang belum punya field ini
            'tanggal_bap' => 'nullable|date', // Nullable untuk data lama yang belum punya field ini
        ];

        // Jika jenis pelaku usaha adalah Badan Usaha, jenis_badan_usaha wajib diisi
        if ($request->jenis_pelaku_usaha === 'Badan Usaha') {
            $rules['jenis_badan_usaha'] = 'required|string';
        }

        $validated = $request->validate($rules);
        
        // Sanitize input teks untuk mencegah XSS
        $textFields = ['no_permohonan', 'no_proyek', 'nib', 'kbli', 'nama_usaha', 'inputan_teks', 
                      'jenis_badan_usaha', 'pemilik', 'alamat_perusahaan', 'jenis_proyek', 
                      'nama_perizinan', 'skala_usaha', 'risiko', 'verifikator', 'status', 'nomor_bap'];
        foreach ($textFields as $field) {
            if (isset($validated[$field]) && is_string($validated[$field])) {
                $validated[$field] = strip_tags($validated[$field]);
            }
        }
        
        // Jika jenis_pelaku_usaha adalah 'Orang Perseorangan', set jenis_badan_usaha ke null
        if ($validated['jenis_pelaku_usaha'] === 'Orang Perseorangan') {
            $validated['jenis_badan_usaha'] = null;
        }

        // Pastikan field nomor_bap dan tanggal_bap bisa diupdate bahkan jika kosong/null
        // Jika field kosong, set ke null (bukan empty string)
        if (empty($request->nomor_bap)) {
            $validated['nomor_bap'] = null;
        }
        if (empty($request->tanggal_bap)) {
            $validated['tanggal_bap'] = null;
        }

        // Debug: Log data yang akan di-update
        Log::info('Update Penerbitan Berkas', [
            'id' => $id,
            'tanggal_permohonan' => $validated['tanggal_permohonan'] ?? 'NOT SET',
            'skala_usaha' => $validated['skala_usaha'] ?? 'NOT SET',
            'risiko' => $validated['risiko'] ?? 'NOT SET',
            'nomor_bap' => $validated['nomor_bap'] ?? 'NOT SET',
            'tanggal_bap' => $validated['tanggal_bap'] ?? 'NOT SET',
            'validated' => $validated
        ]);

        // Update dengan cara yang lebih eksplisit untuk memastikan semua field ter-update
        // Gunakan fill() dan save() untuk lebih eksplisit
        $permohonan->fill($validated);
        $saved = $permohonan->save();

        // Debug: Log setelah save
        $permohonan->refresh();
        Log::info('After Update Penerbitan Berkas', [
            'id' => $id,
            'saved' => $saved,
            'tanggal_permohonan' => $permohonan->tanggal_permohonan,
            'skala_usaha' => $permohonan->skala_usaha,
            'risiko' => $permohonan->risiko,
            'nomor_bap' => $permohonan->nomor_bap,
            'tanggal_bap' => $permohonan->tanggal_bap,
            'is_dirty' => $permohonan->isDirty(),
            'get_dirty' => $permohonan->getDirty()
        ]);

        // Cek apakah benar-benar ter-update
        if (!$saved) {
            Log::error('Update failed for Penerbitan Berkas ID: ' . $id);
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui data!'
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal memperbarui data!');
        }

        // Jika request AJAX, return JSON response
        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Data permohonan berhasil diperbarui!',
                'data' => $permohonan->fresh()
            ]);
        }
        
        // Jika bukan AJAX, return redirect normal
        return redirect()->route('penerbitan-berkas')->with('success', 'Data permohonan berhasil diperbarui!');
    }

    public function destroyPenerbitanBerkas($id)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Cek authorization - hanya admin dan penerbitan_berkas yang bisa delete
        if (!in_array($user->role, ['admin', 'penerbitan_berkas'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
        
        try {
            $permohonan = PenerbitanBerkas::findOrFail($id);
            $permohonan->delete();

            return redirect()->route('penerbitan-berkas')
                ->with('success', 'Data permohonan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('penerbitan-berkas')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Get notifications for dikembalikan berkas (for dpmptsp and admin user)
     */
    public function getNotifications(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !in_array($user->role, ['dpmptsp', 'admin'])) {
            return response()->json(['notifications' => [], 'count' => 0], 200, [
                'Content-Type' => 'application/json; charset=utf-8',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
        }

        // Optimasi query: hanya ambil field yang diperlukan
        $permohonans = Permohonan::with(['user:id,name'])
            ->select('id', 'no_permohonan', 'nama_usaha', 'status', 'pengembalian', 
                     'keterangan_pengembalian', 'menghubungi', 'keterangan_menghubungi', 
                     'updated_at', 'user_id')
            ->where('status', 'Dikembalikan')
            ->whereHas('user', function($query) {
                $query->where('role', '!=', 'penerbitan_berkas');
            })
            ->orderBy('pengembalian', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        $notifications = $permohonans->map(function($permohonan) {
            return [
                'id' => $permohonan->id,
                'no_permohonan' => $permohonan->no_permohonan ?? 'N/A',
                'nama_usaha' => $permohonan->nama_usaha ?? 'N/A',
                'status' => $permohonan->status ?? 'Dikembalikan',
                'tanggal_pengembalian' => $permohonan->pengembalian 
                    ? Carbon::parse($permohonan->pengembalian)->locale('id')->translatedFormat('d F Y')
                    : null,
                'keterangan' => $permohonan->keterangan_pengembalian ?? 'Berkas dikembalikan untuk perbaikan',
                'menghubungi' => $permohonan->menghubungi ? $permohonan->menghubungi->format('Y-m-d') : null,
                'keterangan_menghubungi' => $permohonan->keterangan_menghubungi ?? null,
                'url' => route('permohonan.show', ['permohonan' => $permohonan->id]),
                'created_at' => $permohonan->updated_at->diffForHumans(),
            ];
        });

        $response = response()->json([
            'notifications' => $notifications,
            'count' => $notifications->count()
        ], 200, [
            'Content-Type' => 'application/json; charset=utf-8',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
        
        return $response;
    }

    /**
     * Update status and menghubungi from notification
     */
    public function updateNotificationStatus(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user || !in_array($user->role, ['dpmptsp', 'admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $permohonan = Permohonan::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Dikembalikan,Diterima,Ditolak',
            'menghubungi' => 'nullable|date',
            'keterangan_menghubungi' => 'nullable|string',
        ]);

        // Sanitize input teks untuk mencegah XSS
        if (isset($validated['keterangan_menghubungi']) && is_string($validated['keterangan_menghubungi'])) {
            $validated['keterangan_menghubungi'] = strip_tags($validated['keterangan_menghubungi']);
        }

        $oldStatus = $permohonan->status;
        $oldMenghubungi = $permohonan->menghubungi;
        $oldKeteranganMenghubungi = $permohonan->keterangan_menghubungi;

        // Update permohonan
        $permohonan->status = $validated['status'];
        if (isset($validated['menghubungi'])) {
            $permohonan->menghubungi = $validated['menghubungi'];
        }
        if (isset($validated['keterangan_menghubungi'])) {
            $permohonan->keterangan_menghubungi = $validated['keterangan_menghubungi'];
        }
        $permohonan->save();

        // Create log for status change
        if ($oldStatus !== $validated['status']) {
            LogPermohonan::create([
                'permohonan_id' => $permohonan->id,
                'user_id' => $user->id,
                'action' => 'status_update',
                'status_sebelum' => $oldStatus,
                'status_sesudah' => $validated['status'],
                'keterangan' => 'Status diubah dari notifikasi: ' . $oldStatus . ' → ' . $validated['status'],
                'old_data' => json_encode(['status' => $oldStatus]),
                'new_data' => json_encode(['status' => $validated['status']]),
            ]);
        }

        // Create log for menghubungi
        if (isset($validated['menghubungi']) && $validated['menghubungi'] && (!$oldMenghubungi || $oldMenghubungi->format('Y-m-d') !== $validated['menghubungi'])) {
            LogPermohonan::create([
                'permohonan_id' => $permohonan->id,
                'user_id' => $user->id,
                'action' => 'contact',
                'status_sebelum' => $permohonan->status,
                'status_sesudah' => $permohonan->status,
                'keterangan' => 'Pemohon dihubungi pada ' . Carbon::parse($validated['menghubungi'])->locale('id')->translatedFormat('d M Y') . ': ' . ($validated['keterangan_menghubungi'] ?? ''),
                'old_data' => json_encode(['menghubungi' => $oldMenghubungi ? $oldMenghubungi->format('Y-m-d') : null]),
                'new_data' => json_encode(['menghubungi' => $validated['menghubungi'], 'keterangan_menghubungi' => $validated['keterangan_menghubungi'] ?? '']),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status dan data menghubungi berhasil diperbarui',
            'permohonan' => [
                'id' => $permohonan->id,
                'status' => $permohonan->status,
                'menghubungi' => $permohonan->menghubungi ? $permohonan->menghubungi->format('Y-m-d') : null,
                'keterangan_menghubungi' => $permohonan->keterangan_menghubungi,
            ]
        ]);
    }
}