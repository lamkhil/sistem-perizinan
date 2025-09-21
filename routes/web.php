<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\JenisUsahaController; // ✅ Tambahkan ini
use App\Http\Controllers\TtdSettingController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Dashboard (invokable controller)
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Statistik
Route::get('/statistik', [DashboardController::class, 'statistik'])
    ->middleware(['auth', 'verified'])
    ->name('statistik');

// Penerbitan Berkas
Route::get('/penerbitan-berkas', [DashboardController::class, 'penerbitanBerkas'])
    ->middleware(['auth', 'verified'])
    ->name('penerbitan-berkas');
Route::get('/penerbitan-berkas/export/excel', [DashboardController::class, 'exportPenerbitanBerkasExcel'])
    ->middleware(['auth', 'verified'])
    ->name('penerbitan-berkas.export.excel');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permohonan (CRUD)
    Route::resource('permohonan', PermohonanController::class);
    
    // Export routes
    Route::get('/permohonan/export/excel', [PermohonanController::class, 'exportExcel'])->name('permohonan.export.excel');
    Route::get('/permohonan/export/pdf', [PermohonanController::class, 'exportPdf'])->name('permohonan.export.pdf');
    Route::get('/permohonan/export/pdf-compact', [PermohonanController::class, 'exportPdfCompact'])->name('permohonan.export.pdf-compact');
Route::get('/permohonan/export/pdf-penerbitan', [PermohonanController::class, 'exportPdfPenerbitan'])->name('permohonan.export.pdf-penerbitan');

    // ✅ Rute untuk Ekspor (Excel/PDF)
    Route::get('/export/{type}/{format}', [ExportController::class, 'export'])->name('export');

    // User Management (Admin Only)
    Route::middleware('can:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);

        // ✅ Rute tambahan untuk melihat semua tabel
        Route::get('/semua-tabel', [UserController::class, 'semuaTabel'])->name('users.semua-tabel');

        // ✅ Rute resource Jenis Usaha
        Route::resource('jenis-usaha', JenisUsahaController::class);

        // ✅ Rute TTD Settings
        Route::get('/ttd-settings', [TtdSettingController::class, 'index'])->name('ttd-settings.index');
        Route::put('/ttd-settings', [TtdSettingController::class, 'update'])->name('ttd-settings.update');
    });
});

require __DIR__.'/auth.php';
