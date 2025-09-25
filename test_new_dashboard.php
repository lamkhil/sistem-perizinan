<?php

require_once 'vendor/autoload.php';

use App\Models\Permohonan;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST DASHBOARD DENGAN STATUS TERLAMBAT BARU ===\n\n";

// Simulasi filter dashboard untuk DPMPTSP
$permohonans = Permohonan::with('user')
    ->whereHas('user', function($query) {
        $query->where('role', '!=', 'penerbitan_berkas');
    })->get();

echo "=== DATA SETELAH FILTER ROLE (DPMPTSP) ===\n";
echo "Total: " . $permohonans->count() . "\n\n";

// Hitung statistik dengan 4 kategori status
$stats = [
    'totalPermohonan' => $permohonans->count(),
    'diterima' => $permohonans->where('status', 'Diterima')->count(),
    'dikembalikan' => $permohonans->where('status', 'Dikembalikan')->count(),
    'ditolak' => $permohonans->where('status', 'Ditolak')->count(),
    'terlambat' => $permohonans->where('status', 'Terlambat')->count(),
];

echo "=== DASHBOARD STATISTICS YANG AKAN DITAMPILKAN ===\n";
echo "Total Permohonan: " . $stats['totalPermohonan'] . "\n";
echo "Diterima: " . $stats['diterima'] . "\n";
echo "Dikembalikan: " . $stats['dikembalikan'] . "\n";
echo "Ditolak: " . $stats['ditolak'] . "\n";
echo "Terlambat: " . $stats['terlambat'] . "\n\n";

echo "=== DETAIL DATA BERDASARKAN STATUS ===\n";

echo "\n--- DATA TERLAMBAT ---\n";
$terlambatData = $permohonans->where('status', 'Terlambat');
foreach($terlambatData as $data) {
    $deadlineStr = $data->deadline ? $data->deadline->format('d/m/Y') : 'No deadline';
    echo "• {$data->no_permohonan} - {$data->nama_usaha} - Deadline: {$deadlineStr}\n";
}

echo "\n--- DATA DITERIMA ---\n";
$diterimaData = $permohonans->where('status', 'Diterima');
foreach($diterimaData as $data) {
    echo "• {$data->no_permohonan} - {$data->nama_usaha}\n";
}

echo "\n--- DATA DIKEMBALIKAN ---\n";
$dikembalikanData = $permohonans->where('status', 'Dikembalikan');
foreach($dikembalikanData as $data) {
    echo "• {$data->no_permohonan} - {$data->nama_usaha}\n";
}

echo "\n--- DATA DITOLAK ---\n";
$ditolakData = $permohonans->where('status', 'Ditolak');
foreach($ditolakData as $data) {
    echo "• {$data->no_permohonan} - {$data->nama_usaha}\n";
}

echo "\n=== BREAKDOWN STATUS UNTUK DASHBOARD ===\n";
echo "1. Diterima: " . $stats['diterima'] . " (data yang sudah diterima)\n";
echo "2. Dikembalikan: " . $stats['dikembalikan'] . " (data yang dikembalikan)\n";
echo "3. Ditolak: " . $stats['ditolak'] . " (data yang ditolak)\n";
echo "4. Terlambat: " . $stats['terlambat'] . " (data yang terlambat deadline)\n";
