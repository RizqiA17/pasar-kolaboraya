<?php

/**
 * Demo Script untuk Navbar Disable Feature
 * 
 * Script ini menunjukkan bagaimana mengubah pengaturan sistem
 * untuk menonaktifkan fitur-fitur tertentu dan melihat efeknya
 * pada navbar.
 */

require_once 'vendor/autoload.php';

use App\Models\SystemSetting;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Demo Navbar Disable Feature ===\n\n";

// Function untuk menampilkan status pengaturan
function showSettings() {
    echo "Status Pengaturan Saat Ini:\n";
    echo "- Koneksi: " . (SystemSetting::isConnectionsEnabled() ? "AKTIF" : "NONAKTIF") . "\n";
    echo "- Kolaborasi: " . (SystemSetting::isCollaborationsEnabled() ? "AKTIF" : "NONAKTIF") . "\n";
    echo "- Aksi Pengguna: " . (SystemSetting::isUserActionsEnabled() ? "AKTIF" : "NONAKTIF") . "\n\n";
}

// Function untuk mengubah pengaturan
function changeSetting($key, $value, $description) {
    SystemSetting::setValue($key, $value ? '1' : '0', $description);
    echo "✓ Pengaturan '$key' diubah menjadi: " . ($value ? "AKTIF" : "NONAKTIF") . "\n";
}

echo "1. Status awal:\n";
showSettings();

echo "2. Menonaktifkan Koneksi...\n";
changeSetting('connections_enabled', false, 'Demo: Koneksi dinonaktifkan');
showSettings();

echo "3. Menonaktifkan Kolaborasi...\n";
changeSetting('collaborations_enabled', false, 'Demo: Kolaborasi dinonaktifkan');
showSettings();

echo "4. Menonaktifkan Aksi Pengguna...\n";
changeSetting('user_actions_enabled', false, 'Demo: Aksi pengguna dinonaktifkan');
showSettings();

echo "5. Mengaktifkan kembali semua fitur...\n";
changeSetting('connections_enabled', true, 'Demo: Koneksi diaktifkan kembali');
changeSetting('collaborations_enabled', true, 'Demo: Kolaborasi diaktifkan kembali');
changeSetting('user_actions_enabled', true, 'Demo: Aksi pengguna diaktifkan kembali');
showSettings();

echo "=== Demo Selesai ===\n";
echo "Sekarang buka aplikasi di browser untuk melihat efeknya pada navbar.\n";
echo "Menu yang dinonaktifkan akan tampil dengan:\n";
echo "- Opacity 60%\n";
echo "- Warna abu-abu\n";
echo "- Cursor not-allowed\n";
echo "- Tooltip informatif saat hover\n\n";

echo "Untuk super admin, semua menu akan tetap normal.\n";
echo "Untuk user biasa, menu yang dinonaktifkan akan terlihat disabled.\n";
