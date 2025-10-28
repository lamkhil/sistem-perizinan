<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait PaginatedController
{
    /**
     * Get paginated data with optimized queries
     */
    protected function getPaginatedData($query, $perPage = 15)
    {
        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Get optimized permohonan query based on user role
     */
    protected function getOptimizedPermohonanQuery($user)
    {
        $query = Permohonan::with('user');
        
        if ($user->role === 'admin') {
            // Admin melihat semua data
            return $query;
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP melihat semua permohonan kecuali yang dibuat oleh penerbitan_berkas
            return $query->whereHas('user', function($q) {
                $q->where('role', '!=', 'penerbitan_berkas');
            });
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis melihat permohonan sesuai sektornya saja
            if ($user->sektor) {
                return $query->where('sektor', $user->sektor)
                    ->whereHas('user', function($q) {
                        $q->where('role', '!=', 'penerbitan_berkas');
                    });
            } else {
                return $query->whereHas('user', function($q) {
                    $q->where('role', '!=', 'penerbitan_berkas');
                });
            }
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas hanya melihat data yang dibuat oleh role penerbitan_berkas
            return $query->whereHas('user', function($q) {
                $q->where('role', 'penerbitan_berkas');
            });
        }
        
        return $query;
    }

    /**
     * Apply search filters to query
     */
    protected function applySearchFilters($query, $searchQuery)
    {
        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('no_permohonan', 'like', '%' . $searchQuery . '%')
                  ->orWhere('nama_usaha', 'like', '%' . $searchQuery . '%')
                  ->orWhere('nib', 'like', '%' . $searchQuery . '%')
                  ->orWhere('kbli', 'like', '%' . $searchQuery . '%')
                  ->orWhere('pemilik', 'like', '%' . $searchQuery . '%')
                  ->orWhere('nama_perizinan', 'like', '%' . $searchQuery . '%');
            });
        }
        
        return $query;
    }

    /**
     * Apply status filters to query
     */
    protected function applyStatusFilters($query, $selectedStatus)
    {
        if ($selectedStatus) {
            if ($selectedStatus === 'Terlambat') {
                $today = now()->toDateString();
                $query->whereNotNull('deadline')
                      ->whereDate('deadline', '<', $today)
                      ->whereNotIn('status', ['Diterima', 'Ditolak'])
                      ->where(function ($q) {
                          $q->whereNull('verifikasi_pd_teknis')
                            ->orWhere('verifikasi_pd_teknis', '!=', 'Berkas Disetujui');
                      });
            } else {
                $query->where('status', $selectedStatus);
            }
        }
        
        return $query;
    }

    /**
     * Apply date filters to query
     */
    protected function applyDateFilters($query, $selectedDateFilter, $customDate)
    {
        if ($selectedDateFilter) {
            $now = now();
            
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
                        $now->endOfWeek()->toDateTimeString()
                    ]);
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [
                        $now->subWeek()->startOfWeek()->toDateTimeString(),
                        $now->subWeek()->endOfWeek()->toDateTimeString()
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
        
        return $query;
    }
}
