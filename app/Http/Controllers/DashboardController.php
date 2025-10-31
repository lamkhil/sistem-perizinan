<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\PenerbitanBerkas;
use App\Models\TtdSetting;
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
            $permohonans = Permohonan::with('user')->orderBy('created_at', 'asc')->get();
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP melihat semua permohonan kecuali yang dibuat oleh penerbitan_berkas
            $permohonans = Permohonan::with('user')
                ->whereHas('user', function($query) {
                    $query->where('role', '!=', 'penerbitan_berkas');
                })->orderBy('created_at', 'asc')->get();
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis melihat permohonan sesuai sektornya saja
            if ($user->sektor) {
                $permohonans = Permohonan::with('user')
                    ->where('sektor', $user->sektor)
                    ->whereHas('user', function($query) {
                        $query->where('role', '!=', 'penerbitan_berkas');
                    })->orderBy('created_at', 'asc')->get();
            } else {
                // Jika PD Teknis belum ada sektor, tampilkan semua (fallback)
                $permohonans = Permohonan::with('user')
                    ->whereHas('user', function($query) {
                        $query->where('role', '!=', 'penerbitan_berkas');
                    })->orderBy('created_at', 'asc')->get();
            }
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas melihat modul khususnya sendiri (data terpisah)
            return $this->penerbitanBerkas($request);
        } else {
            // Default untuk role lain
            $permohonans = Permohonan::with('user')->orderBy('created_at', 'asc')->get();
        }
        
        // Hitung statistik:
        // Total = hanya status final (Diterima, Dikembalikan, Ditolak) — Menunggu tidak dihitung
        $totalPermohonan = $permohonans->whereIn('status', ['Diterima', 'Dikembalikan', 'Ditolak'])->count();

        // Terlambat = semua data yang melewati deadline (semua status bisa terlambat)
        $terlambatCount = $permohonans->filter(function($permohonan) {
            return $permohonan->isOverdue();
        })->count();
        
        $stats = [
            'totalPermohonan' => $totalPermohonan, // Hanya status final
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
        $customDate = $request->query('custom_date');
        
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
                    if ($customDate) {
                        $permohonans->whereDate('created_at', $customDate);
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

        return view('statistik', compact('stats', 'selectedDateFilter', 'customDate'));
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
        $selectedDateFilter = $request->query('date_filter');
        $customDate = $request->query('custom_date');
        $search = $request->query('search');

        $query = PenerbitanBerkas::with('user');

        // Filter berdasarkan role
        if ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas hanya melihat data yang dibuatnya
            $query->where('user_id', $user->id);
        }
        // Admin melihat semua data penerbitan berkas

        // Filter tanggal berdasarkan tanggal_permohonan (bukan created_at)
        if ($selectedDateFilter) {
            $now = Carbon::now();
            switch ($selectedDateFilter) {
                case 'today':
                    $query->whereDate('tanggal_permohonan', $now->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('tanggal_permohonan', $now->subDay()->toDateString());
                    break;
                case 'this_week':
                    $query->whereBetween('tanggal_permohonan', [
                        $now->startOfWeek()->toDateTimeString(),
                        $now->endOfWeek()->toDateTimeString(),
                    ]);
                    break;
                case 'last_week':
                    $query->whereBetween('tanggal_permohonan', [
                        $now->subWeek()->startOfWeek()->toDateTimeString(),
                        $now->subWeek()->endOfWeek()->toDateTimeString(),
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('tanggal_permohonan', $now->month)
                          ->whereYear('tanggal_permohonan', $now->year);
                    break;
                case 'last_month':
                    $lastMonth = $now->subMonth();
                    $query->whereMonth('tanggal_permohonan', $lastMonth->month)
                          ->whereYear('tanggal_permohonan', $lastMonth->year);
                    break;
                case 'custom':
                    if ($customDate) {
                        $query->whereDate('tanggal_permohonan', $customDate);
                    }
                    break;
            }
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

        return view('dashboard.penerbitan_berkas', compact('permohonans', 'stats', 'ttdSettings', 'selectedDateFilter', 'customDate', 'search', 'perPage'));
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

        $selectedDateFilter = $request->query('date_filter');
        $customDate = $request->query('custom_date');

        $query = PenerbitanBerkas::with('user');
        if ($user->role === 'penerbitan_berkas') {
            $query->where('user_id', $user->id);
        }

        if ($selectedDateFilter) {
            $now = Carbon::now();
            switch ($selectedDateFilter) {
                case 'today':
                    $query->whereDate('tanggal_permohonan', $now->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('tanggal_permohonan', $now->subDay()->toDateString());
                    break;
                case 'this_week':
                    $query->whereBetween('tanggal_permohonan', [
                        $now->startOfWeek()->toDateTimeString(),
                        $now->endOfWeek()->toDateTimeString(),
                    ]);
                    break;
                case 'last_week':
                    $query->whereBetween('tanggal_permohonan', [
                        $now->subWeek()->startOfWeek()->toDateTimeString(),
                        $now->subWeek()->endOfWeek()->toDateTimeString(),
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('tanggal_permohonan', $now->month)
                          ->whereYear('tanggal_permohonan', $now->year);
                    break;
                case 'last_month':
                    $lastMonth = $now->subMonth();
                    $query->whereMonth('tanggal_permohonan', $lastMonth->month)
                          ->whereYear('tanggal_permohonan', $lastMonth->year);
                    break;
                case 'custom':
                    if ($customDate) {
                        $query->whereDate('tanggal_permohonan', $customDate);
                    }
                    break;
            }
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

        $selectedDateFilter = $request->query('date_filter');
        $customDate = $request->query('custom_date');

        $query = PenerbitanBerkas::with('user');
        if ($user->role === 'penerbitan_berkas') {
            $query->where('user_id', $user->id);
        }

        if ($selectedDateFilter) {
            $now = Carbon::now();
            switch ($selectedDateFilter) {
                case 'today':
                    $query->whereDate('tanggal_permohonan', $now->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('tanggal_permohonan', $now->subDay()->toDateString());
                    break;
                case 'this_week':
                    $query->whereBetween('tanggal_permohonan', [
                        $now->startOfWeek()->toDateTimeString(),
                        $now->endOfWeek()->toDateTimeString(),
                    ]);
                    break;
                case 'last_week':
                    $query->whereBetween('tanggal_permohonan', [
                        $now->subWeek()->startOfWeek()->toDateTimeString(),
                        $now->subWeek()->endOfWeek()->toDateTimeString(),
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('tanggal_permohonan', $now->month)
                          ->whereYear('tanggal_permohonan', $now->year);
                    break;
                case 'last_month':
                    $lastMonth = $now->subMonth();
                    $query->whereMonth('tanggal_permohonan', $lastMonth->month)
                          ->whereYear('tanggal_permohonan', $lastMonth->year);
                    break;
                case 'custom':
                    if ($customDate) {
                        $query->whereDate('tanggal_permohonan', $customDate);
                    }
                    break;
            }
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
        
        // Format tanggal_bap untuk input type="date" (Y-m-d format)
        // Handle null untuk data lama yang belum punya field ini
        $data = $permohonan->toArray();
        
        // Pastikan ID selalu ada di response untuk validasi di frontend
        $data['id'] = $permohonan->id;
        
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

        // Update dengan fill untuk memastikan semua field ter-update
        $permohonan->fill($validated);
        $permohonan->save();

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
        
        $permohonan = PenerbitanBerkas::findOrFail($id);
        $permohonan->delete();

        return redirect()->route('penerbitan-berkas')->with('success', 'Data permohonan berhasil dihapus!');
    }
}