<?php

require_once 'vendor/autoload.php';

use App\Models\Permohonan;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST DASHBOARD FINAL (4 STATUS) ===\n\n";

// Simulasi filter dashboard untuk DPMPTSP
$permohonans = Permohonan::with('user')
    ->whereHas('user', function($query) {
        $query->where('role', '!=', 'penerbitan_berkas');
    })->get();

echo "=== DATA SETELAH FILTER ROLE (DPMPTSP) ===\n";
echo "Total: " . $permohonans->count() . "\n\n";

// Hitung statistik dengan 4 kategori status (tanpa Menunggu)
$stats = [
    'totalPermohonan' => $permohonans->count(),
    'diterima' => $permohonans->where('status', 'Diterima')->count(),
    'dikembalikan' => $permohonans->where('status', 'Dikembalikan')->count(),
    'ditolak' => $permohonans->where('status', 'Ditolak')->count(),
    'terlambat' => $permohonans->where('status', 'Terlambat')->count(),
];

// Ambil data terlambat untuk tampilan khusus
$terlambatData = $permohonans->where('status', 'Terlambat');

echo "=== DASHBOARD STATISTICS YANG AKAN DITAMPILKAN ===\n";
echo "Total Permohonan: " . $stats['totalPermohonan'] . "\n";
echo "Diterima: " . $stats['diterima'] . "\n";
echo "Dikembalikan: " . $stats['dikembalikan'] . "\n";
echo "Ditolak: " . $stats['ditolak'] . "\n";
echo "Terlambat: " . $stats['terlambat'] . "\n\n";

echo "=== DETAIL DATA TERLAMBAT (UNTUK SECTION KHUSUS) ===\n";
foreach($terlambatData as $data) {
    $deadlineStr = $data->deadline ? $data->deadline->format('d/m/Y') : 'No deadline';
    $daysLate = $data->deadline ? now()->diffInDays($data->deadline, false) : 0;
    echo "• {$data->no_permohonan} - {$data->nama_usaha} - Deadline: {$deadlineStr} - Terlambat: " . abs($daysLate) . " hari\n";
}

echo "\n=== BREAKDOWN STATUS UNTUK DASHBOARD (4 STATUS) ===\n";
echo "1. Diterima: " . $stats['diterima'] . " (data yang sudah diterima)\n";
echo "2. Dikembalikan: " . $stats['dikembalikan'] . " (data yang dikembalikan)\n";
echo "3. Ditolak: " . $stats['ditolak'] . " (data yang ditolak)\n";
echo "4. Terlambat: " . $stats['terlambat'] . " (data yang terlambat deadline)\n";

echo "\n=== STATUS YANG TIDAK DITAMPILKAN ===\n";
echo "Menunggu: " . $permohonans->where('status', 'Menunggu')->count() . " (tidak ditampilkan di dashboard)\n";
