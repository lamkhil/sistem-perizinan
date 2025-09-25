<?php

require_once 'vendor/autoload.php';

use App\Models\Permohonan;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ANALISIS DATA TERLAMBAT DAN BELUM SELESAI ===\n\n";

// Data yang terlambat (deadline sudah lewat)
$overdueData = Permohonan::where('deadline', '<', now())->get();
echo "=== DATA TERLAMBAT (DEADLINE SUDAH LEWAT) ===\n";
echo "Total: " . $overdueData->count() . "\n";
echo "Diterima: " . $overdueData->where('status', 'Diterima')->count() . "\n";
echo "Dikembalikan: " . $overdueData->where('status', 'Dikembalikan')->count() . "\n";
echo "Ditolak: " . $overdueData->where('status', 'Ditolak')->count() . "\n";
echo "Menunggu: " . $overdueData->where('status', 'Menunggu')->count() . "\n\n";

// Data yang belum selesai (status bukan Diterima atau Ditolak)
$unfinishedData = Permohonan::whereNotIn('status', ['Diterima', 'Ditolak'])->get();
echo "=== DATA BELUM SELESAI (STATUS BUKAN DITERIMA/DITOLAK) ===\n";
echo "Total: " . $unfinishedData->count() . "\n";
echo "Dikembalikan: " . $unfinishedData->where('status', 'Dikembalikan')->count() . "\n";
echo "Menunggu: " . $unfinishedData->where('status', 'Menunggu')->count() . "\n\n";

// Data yang terlambat DAN belum selesai
$overdueUnfinished = Permohonan::where('deadline', '<', now())
    ->whereNotIn('status', ['Diterima', 'Ditolak'])
    ->get();
echo "=== DATA TERLAMBAT DAN BELUM SELESAI ===\n";
echo "Total: " . $overdueUnfinished->count() . "\n";
echo "Dikembalikan: " . $overdueUnfinished->where('status', 'Dikembalikan')->count() . "\n";
echo "Menunggu: " . $overdueUnfinished->where('status', 'Menunggu')->count() . "\n\n";

// Data yang sudah selesai (Diterima atau Ditolak)
$finishedData = Permohonan::whereIn('status', ['Diterima', 'Ditolak'])->get();
echo "=== DATA SUDAH SELESAI ===\n";
echo "Total: " . $finishedData->count() . "\n";
echo "Diterima: " . $finishedData->where('status', 'Diterima')->count() . "\n";
echo "Ditolak: " . $finishedData->where('status', 'Ditolak')->count() . "\n\n";

echo "=== DETAIL DATA TERLAMBAT ===\n";
foreach($overdueData as $data) {
    $deadlineStr = $data->deadline ? $data->deadline->format('d/m/Y') : 'No deadline';
    echo "• {$data->no_permohonan} - {$data->nama_usaha} - Status: {$data->status} - Deadline: {$deadlineStr}\n";
}

echo "\n=== REKOMENDASI DASHBOARD ===\n";
echo "Dashboard seharusnya menampilkan:\n";
echo "1. Total: " . $overdueUnfinished->count() . " (data terlambat dan belum selesai)\n";
echo "2. Dikembalikan: " . $overdueUnfinished->where('status', 'Dikembalikan')->count() . "\n";
echo "3. Menunggu: " . $overdueUnfinished->where('status', 'Menunggu')->count() . "\n";
echo "4. Ditolak: " . $overdueUnfinished->where('status', 'Ditolak')->count() . "\n";
