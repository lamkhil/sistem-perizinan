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
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Admin bisa akses semua settings
        // Penerbitan Berkas bisa akses TTD Settings
        $canAccessTtdSettings = in_array($user->role, ['admin', 'penerbitan_berkas']);
        $canAccessAppSettings = $user->role === 'admin';
        
        $ttdSettings = null;
        $appSettings = null;
        
        if ($canAccessTtdSettings) {
            $ttdSettings = TtdSetting::getSettings();
        }
        
        if ($canAccessAppSettings) {
            $appSettings = AppSetting::getKoordinator();
        }
        
        return view('settings.index', compact('ttdSettings', 'appSettings', 'canAccessTtdSettings', 'canAccessAppSettings'));
    }
}

