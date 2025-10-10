<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

echo "=== DEBUG TTD DATA ===\n";

$settings = App\Models\TtdSetting::getSettings();

echo "Mengetahui Photo: " . ($settings->mengetahui_photo ?? 'N/A') . "\n";
echo "Menyetujui Photo: " . ($settings->menyetujui_photo ?? 'N/A') . "\n";

echo "\n=== ALL TTD SETTINGS ===\n";
$allSettings = $settings->toArray();
foreach ($allSettings as $key => $value) {
    echo "$key: " . ($value ?? 'N/A') . "\n";
}

echo "\n=== CHECKING FILE EXISTENCE ===\n";

// Check if files exist in storage
if ($settings->mengetahui_photo) {
    $mengetahuiPath = storage_path('app/public/ttd_photos/' . $settings->mengetahui_photo);
    echo "Mengetahui file path: $mengetahuiPath\n";
    echo "Mengetahui file exists: " . (file_exists($mengetahuiPath) ? 'YES' : 'NO') . "\n";
}

if ($settings->menyetujui_photo) {
    $menyetujuiPath = storage_path('app/public/ttd_photos/' . $settings->menyetujui_photo);
    echo "Menyetujui file path: $menyetujuiPath\n";
    echo "Menyetujui file exists: " . (file_exists($menyetujuiPath) ? 'YES' : 'NO') . "\n";
}

echo "\n=== CHECKING PUBLIC STORAGE LINK ===\n";
$publicStoragePath = public_path('storage');
echo "Public storage path: $publicStoragePath\n";
echo "Public storage exists: " . (is_dir($publicStoragePath) ? 'YES' : 'NO') . "\n";

if (is_dir($publicStoragePath)) {
    echo "Public storage is link: " . (is_link($publicStoragePath) ? 'YES' : 'NO') . "\n";
}
