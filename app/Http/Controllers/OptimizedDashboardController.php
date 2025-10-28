<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\PenerbitanBerkas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OptimizedDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cache key berdasarkan user role dan sektor
        $cacheKey = "dashboard_data_{$user->role}_{$user->sektor}";
        
        // Cache untuk 5 menit
        $data = Cache::remember($cacheKey, 300, function() use ($user) {
            return $this->getDashboardData($user);
        });

        return view('dashboard', $data);
    }

    private function getDashboardData($user)
    {
        // Optimized query dengan eager loading dan proper indexing
        $permohonansQuery = Permohonan::with('user');
        
        // Apply role-based filtering with optimized queries
        if ($user->role === 'admin') {
            $permohonans = $permohonansQuery->orderBy('created_at', 'desc')->get();
        } elseif ($user->role === 'dpmptsp') {
            $permohonans = $permohonansQuery
                ->whereHas('user', function($query) {
                    $query->where('role', '!=', 'penerbitan_berkas');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->role === 'pd_teknis') {
            if ($user->sektor) {
                $permohonans = $permohonansQuery
                    ->where('sektor', $user->sektor)
                    ->whereHas('user', function($query) {
                        $query->where('role', '!=', 'penerbitan_berkas');
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $permohonans = $permohonansQuery
                    ->whereHas('user', function($query) {
                        $query->where('role', '!=', 'penerbitan_berkas');
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } elseif ($user->role === 'penerbitan_berkas') {
            return $this->penerbitanBerkasData();
        } else {
            $permohonans = $permohonansQuery->orderBy('created_at', 'desc')->get();
        }

        // Optimized statistics calculation using database queries
        $stats = $this->calculateOptimizedStats($permohonans);

        return [
            'permohonans' => $permohonans,
            'stats' => $stats
        ];
    }

    private function calculateOptimizedStats($permohonans)
    {
        // Use database aggregation instead of PHP filtering
        $statusCounts = $permohonans->groupBy('status')->map->count();
        
        // Calculate overdue using database query for better performance
        $today = now()->toDateString();
        $overdueCount = $permohonans->filter(function($permohonan) use ($today) {
            return $permohonan->deadline && 
                   $permohonan->deadline < $today && 
                   !in_array($permohonan->status, ['Diterima', 'Ditolak']) &&
                   ($permohonan->verifikasi_pd_teknis !== 'Berkas Disetujui');
        })->count();

        return [
            'totalPermohonan' => $statusCounts->whereIn('status', ['Diterima', 'Dikembalikan', 'Ditolak'])->sum(),
            'diterima' => $statusCounts->get('Diterima', 0),
            'dikembalikan' => $statusCounts->get('Dikembalikan', 0),
            'ditolak' => $statusCounts->get('Ditolak', 0),
            'terlambat' => $overdueCount,
        ];
    }

    private function penerbitanBerkasData()
    {
        $penerbitanBerkas = PenerbitanBerkas::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'penerbitanBerkas' => $penerbitanBerkas,
            'stats' => [
                'totalPermohonan' => 0,
                'diterima' => 0,
                'dikembalikan' => 0,
                'ditolak' => 0,
                'terlambat' => 0,
            ]
        ];
    }
}
