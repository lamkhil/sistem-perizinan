<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\TtdSetting;
use App\Exports\PenerbitanBerkasExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        
        // Ambil data permohonan
        $permohonans = Permohonan::with('user')->get();
        
        // Hitung statistik
        $stats = [
            'totalPermohonan' => $permohonans->count(),
            'dikembalikan' => $permohonans->where('status', 'Dikembalikan')->count(),
            'diterima' => $permohonans->where('status', 'Diterima')->count(),
            'ditolak' => $permohonans->where('status', 'Ditolak')->count(),
        ];

        // Return view berdasarkan role
        switch ($user->role) {
            case 'admin':
                return view('dashboard.admin', compact('permohonans', 'stats'));
            case 'dpmptsp':
                return view('dashboard.dpmptsp', compact('permohonans', 'stats'));
            case 'pd_teknis':
                return view('dashboard.pd_teknis', compact('permohonans', 'stats'));
            case 'penerbitan_berkas':
                return view('dashboard.penerbitan_berkas', compact('permohonans', 'stats'));
            default:
                $request->session()->regenerateToken();
                return redirect('/login')->with('error', 'Peran tidak valid, hubungi admin.');
        }
    }

    public function statistik(Request $request)
    {
        $user = Auth::user();
        
        // Ambil parameter dari request
        $selectedDateFilter = $request->query('date_filter');
        $customDate = $request->query('custom_date');
        
        // Query dasar
        $permohonans = Permohonan::with('user');
        
        // Terapkan filter tanggal
        if ($selectedDateFilter) {
            $now = \Carbon\Carbon::now();
            
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
        $permohonans = $permohonans->get();
        
        // Hitung statistik untuk chart
        $stats = [
            'totalPermohonan' => $permohonans->count(),
            'dikembalikan' => $permohonans->where('status', 'Dikembalikan')->count(),
            'diterima' => $permohonans->where('status', 'Diterima')->count(),
            'ditolak' => $permohonans->where('status', 'Ditolak')->count(),
        ];

        return view('statistik', compact('stats', 'selectedDateFilter', 'customDate'));
    }

    public function penerbitanBerkas()
    {
        $user = Auth::user();
        
        // Ambil data permohonan
        $permohonans = Permohonan::with('user')->get();
        
        // Hitung statistik
        $stats = [
            'totalPermohonan' => $permohonans->count(),
            'dikembalikan' => $permohonans->where('status', 'Dikembalikan')->count(),
            'diterima' => $permohonans->where('status', 'Diterima')->count(),
            'ditolak' => $permohonans->where('status', 'Ditolak')->count(),
        ];

        // Ambil data TTD settings
        $ttdSettings = TtdSetting::getSettings();
        
        // Proses title menyetujui untuk mengganti placeholder tanggal
        $menyetujuiTitle = str_replace('{{ date("d F Y") }}', date('d F Y'), $ttdSettings->menyetujui_title);

        return view('dashboard.penerbitan_berkas', compact('permohonans', 'stats', 'ttdSettings', 'menyetujuiTitle'));
    }

    public function exportPenerbitanBerkasExcel()
    {
        return Excel::download(new PenerbitanBerkasExport, 'data_penerbitan_berkas_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}