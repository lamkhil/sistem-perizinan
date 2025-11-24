<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\TtdSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display settings page
     * Hanya admin yang bisa akses
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Hanya admin yang bisa akses
        if ($user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        
        // Load semua settings untuk admin
        $ttdSettings = TtdSetting::getSettings();
        $appSettings = AppSetting::getKoordinator();
        
        return view('settings.index', compact('ttdSettings', 'appSettings'));
    }
}

