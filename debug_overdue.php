<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\Permohonan;

echo "=== ANALISIS DATA TERLAMBAT ===" . PHP_EOL;

// Ambil semua permohonan
$permohonans = Permohonan::all();

echo "Total permohonan: " . $permohonans->count() . PHP_EOL;

// Hitung berdasarkan isOverdue()
$overdueByMethod = $permohonans->filter(function($p) {
    return $p->isOverdue();
})->count();

echo "Terlambat berdasarkan isOverdue(): " . $overdueByMethod . PHP_EOL;

// Hitung berdasarkan status Terlambat
$overdueByStatus = $permohonans->where('status', 'Terlambat')->count();

echo "Terlambat berdasarkan status: " . $overdueByStatus . PHP_EOL;

// Cek beberapa data untuk debugging
echo PHP_EOL . "=== SAMPLE DATA ===" . PHP_EOL;
$sample = $permohonans->take(5);
foreach($sample as $p) {
    echo "No: " . $p->no_permohonan . PHP_EOL;
    echo "  Status: " . $p->status . PHP_EOL;
    echo "  Deadline: " . ($p->deadline ? $p->deadline->format('Y-m-d') : 'NULL') . PHP_EOL;
    echo "  Tanggal Permohonan: " . $p->tanggal_permohonan->format('Y-m-d') . PHP_EOL;
    echo "  isOverdue(): " . ($p->isOverdue() ? 'YES' : 'NO') . PHP_EOL;
    echo "  ---" . PHP_EOL;
}

// Cek data yang isOverdue() = true
echo PHP_EOL . "=== DATA YANG TERLAMBAT (isOverdue() = true) ===" . PHP_EOL;
$overdueData = $permohonans->filter(function($p) {
    return $p->isOverdue();
});

foreach($overdueData->take(10) as $p) {
    echo "No: " . $p->no_permohonan . " - " . $p->nama_usaha . PHP_EOL;
    echo "  Status: " . $p->status . PHP_EOL;
    echo "  Deadline: " . ($p->deadline ? $p->deadline->format('Y-m-d') : 'NULL') . PHP_EOL;
    echo "  ---" . PHP_EOL;
}
