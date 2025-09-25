<?php

require_once 'vendor/autoload.php';

use App\Models\Permohonan;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST DASHBOARD FIX ===\n\n";

// Simulasi filter dashboard untuk DPMPTSP
$permohonans = Permohonan::with('user')
    ->whereHas('user', function($query) {
        $query->where('role', '!=', 'penerbitan_berkas');
    })->get();

echo "=== DATA SETELAH FILTER ROLE (DPMPTSP) ===\n";
echo "Total: " . $permohonans->count() . "\n\n";

// Filter data yang terlambat dan belum selesai
$overdueUnfinished = $permohonans->filter(function($permohonan) {
    return $permohonan->deadline && 
           $permohonan->deadline < now() && 
           !in_array($permohonan->status, ['Diterima', 'Ditolak']);
});

echo "=== DATA TERLAMBAT DAN BELUM SELESAI ===\n";
echo "Total: " . $overdueUnfinished->count() . "\n";
echo "Dikembalikan: " . $overdueUnfinished->where('status', 'Dikembalikan')->count() . "\n";
echo "Diterima: " . $overdueUnfinished->where('status', 'Diterima')->count() . "\n";
echo "Ditolak: " . $overdueUnfinished->where('status', 'Ditolak')->count() . "\n";
echo "Menunggu: " . $overdueUnfinished->where('status', 'Menunggu')->count() . "\n\n";

echo "=== DETAIL DATA TERLAMBAT DAN BELUM SELESAI ===\n";
foreach($overdueUnfinished as $data) {
    $deadlineStr = $data->deadline ? $data->deadline->format('d/m/Y') : 'No deadline';
    echo "• {$data->no_permohonan} - {$data->nama_usaha} - Status: {$data->status} - Deadline: {$deadlineStr}\n";
}

echo "\n=== DASHBOARD STATISTICS YANG AKAN DITAMPILKAN ===\n";
$stats = [
    'totalPermohonan' => $overdueUnfinished->count(),
    'dikembalikan' => $overdueUnfinished->where('status', 'Dikembalikan')->count(),
    'diterima' => $overdueUnfinished->where('status', 'Diterima')->count(),
    'ditolak' => $overdueUnfinished->where('status', 'Ditolak')->count(),
];

echo "Total Permohonan: " . $stats['totalPermohonan'] . "\n";
echo "Diterima: " . $stats['diterima'] . "\n";
echo "Dikembalikan: " . $stats['dikembalikan'] . "\n";
echo "Ditolak: " . $stats['ditolak'] . "\n";
