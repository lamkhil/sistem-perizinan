<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\JenisUsahaController; // ✅ Tambahkan ini
use App\Http\Controllers\TtdSettingController;
use Illuminate\Support\Facades\Route;

// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard (invokable controller)
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Statistik
Route::get('/statistik', [DashboardController::class, 'statistik'])
    ->middleware(['auth', 'verified'])
    ->name('statistik');

// Notifications API (for dpmptsp user)
Route::get('/api/notifications', [DashboardController::class, 'getNotifications'])
    ->middleware(['auth', 'verified'])
    ->name('api.notifications');

// Update notification status (for dpmptsp user)
Route::post('/api/notifications/{id}/update', [DashboardController::class, 'updateNotificationStatus'])
    ->middleware(['auth', 'verified'])
    ->name('api.notifications.update');

// Penerbitan Berkas
Route::get('/penerbitan-berkas', [DashboardController::class, 'penerbitanBerkas'])
    ->middleware(['auth', 'verified'])
    ->name('penerbitan-berkas');
Route::get('/penerbitan-berkas/export/excel', [DashboardController::class, 'exportPenerbitanBerkasExcel'])
    ->middleware(['auth', 'verified'])
    ->name('penerbitan-berkas.export.excel');
Route::get('/penerbitan-berkas/export/pdf/landscape', [DashboardController::class, 'exportPenerbitanBerkasPdfLandscape'])
    ->middleware(['auth', 'verified'])
    ->name('penerbitan-berkas.export.pdf.landscape');
Route::post('/penerbitan-berkas', [DashboardController::class, 'storePenerbitanBerkas'])
    ->middleware(['auth', 'verified'])
    ->name('penerbitan-berkas.store');
Route::get('/penerbitan-berkas/{id}/edit', [DashboardController::class, 'editPenerbitanBerkas'])
    ->middleware(['auth', 'verified'])
    ->name('penerbitan-berkas.edit');
Route::put('/penerbitan-berkas/{id}', [DashboardController::class, 'updatePenerbitanBerkas'])
    ->middleware(['auth', 'verified'])
    ->name('penerbitan-berkas.update');
Route::delete('/penerbitan-berkas/{id}', [DashboardController::class, 'destroyPenerbitanBerkas'])
    ->middleware(['auth', 'verified'])
    ->name('penerbitan-berkas.destroy');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permohonan (CRUD)
    Route::resource('permohonan', PermohonanController::class);
    
    // BAP routes
    Route::get('/permohonan/{permohonan}/bap', [PermohonanController::class, 'bap'])->name('permohonan.bap');
    Route::post('/permohonan/{permohonan}/bap/generate', [PermohonanController::class, 'generateBap'])->name('permohonan.bap.generate');
    
    // BAP TTD Settings (Admin only)
    Route::middleware('can:admin')->group(function () {
        Route::post('/bap/ttd/update', [PermohonanController::class, 'updateBapTtd'])->name('bap.ttd.update');
    });
    
    // Export routes
    Route::get('/permohonan/export/excel', [PermohonanController::class, 'exportExcel'])->name('permohonan.export.excel');
    Route::get('/permohonan/export/pdf-landscape', [PermohonanController::class, 'exportPdfLandscape'])->name('permohonan.export.pdf-landscape');
Route::get('/permohonan/export/pdf-penerbitan', [PermohonanController::class, 'exportPdfPenerbitan'])->name('permohonan.export.pdf-penerbitan');

    // ✅ Rute untuk Ekspor (Excel/PDF)
    Route::get('/export/{type}/{format}', [ExportController::class, 'export'])->name('export');

    // ✅ Rute TTD Settings (Admin & Penerbitan Berkas)
    Route::middleware('can:admin-or-penerbitan-berkas')->group(function () {
        Route::get('/ttd-settings', [TtdSettingController::class, 'index'])->name('ttd-settings.index');
        Route::put('/ttd-settings', [TtdSettingController::class, 'update'])->name('ttd-settings.update');
    });

    // User Management (Admin Only)
    Route::middleware('can:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);

        // ✅ Rute tambahan untuk melihat semua tabel
        Route::get('/semua-tabel', [UserController::class, 'semuaTabel'])->name('users.semua-tabel');

        // ✅ Rute resource Jenis Usaha
        Route::resource('jenis-usaha', JenisUsahaController::class);
    });
});

require __DIR__.'/auth.php';

// Fallback logout route (emergency)
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
})->name('logout.get');
