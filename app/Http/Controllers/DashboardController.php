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

        // Filter tanggal
        if ($selectedDateFilter) {
            $now = Carbon::now();
            switch ($selectedDateFilter) {
                case 'today':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', $now->subDay()->toDateString());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [
                        $now->startOfWeek()->toDateTimeString(),
                        $now->endOfWeek()->toDateTimeString(),
                    ]);
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [
                        $now->subWeek()->startOfWeek()->toDateTimeString(),
                        $now->subWeek()->endOfWeek()->toDateTimeString(),
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', $now->month)
                          ->whereYear('created_at', $now->year);
                    break;
                case 'last_month':
                    $lastMonth = $now->subMonth();
                    $query->whereMonth('created_at', $lastMonth->month)
                          ->whereYear('created_at', $lastMonth->year);
                    break;
                case 'custom':
                    if ($customDate) {
                        $query->whereDate('created_at', $customDate);
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

        $permohonans = $query->orderBy('created_at', 'asc')->get();
        
        // Hitung statistik
        $stats = [
            'totalPermohonan' => $permohonans->count(),
            'dikembalikan' => $permohonans->where('status', 'Dikembalikan')->count(),
            'diterima' => $permohonans->where('status', 'Diterima')->count(),
            'ditolak' => $permohonans->where('status', 'Ditolak')->count(),
        ];

        // Ambil data TTD settings
        $ttdSettings = TtdSetting::getSettings();

        return view('dashboard.penerbitan_berkas', compact('permohonans', 'stats', 'ttdSettings', 'selectedDateFilter', 'customDate', 'search'));
    }

    public function exportPenerbitanBerkasExcel()
    {
        return Excel::download(new PenerbitanBerkasExport, 'data_penerbitan_berkas_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportPenerbitanBerkasPdfLandscape()
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

        $penerbitanBerkas = PenerbitanBerkas::with('user')->get();
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
        
        return response()->json($permohonan);
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

        $permohonan->update($validated);

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