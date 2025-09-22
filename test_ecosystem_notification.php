<?php
/**
 * Test Script untuk Notifikasi Ekosistem
 * 
 * Script ini dapat dijalankan untuk menguji sistem notifikasi
 * ketika user diterima atau ditolak bergabung dengan ekosistem.
 * 
 * Cara menjalankan:
 * php test_ecosystem_notification.php
 */

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Ecosystem;
use App\Services\NotificationService;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 Testing Ecosystem Notification System\n";
echo "==========================================\n\n";

try {
    // 1. Cek apakah ada user dan ekosistem
    $user = User::first();
    $ecosystem = Ecosystem::first();
    
    if (!$user) {
        echo "❌ Error: Tidak ada user di database\n";
        exit(1);
    }
    
    if (!$ecosystem) {
        echo "❌ Error: Tidak ada ekosistem di database\n";
        exit(1);
    }
    
    echo "✅ User ditemukan: {$user->name} ({$user->email})\n";
    echo "✅ Ekosistem ditemukan: {$ecosystem->ecosystem_title}\n\n";
    
    // 2. Test NotificationService
    $notificationService = app(NotificationService::class);
    
    // 3. Test notifikasi penerimaan
    echo "🔔 Testing notifikasi penerimaan...\n";
    $acceptanceNotification = $notificationService->createEcosystemAcceptanceNotification(
        $user,
        $ecosystem,
        $user // menggunakan user yang sama sebagai approver untuk testing
    );
    
    echo "✅ Notifikasi penerimaan berhasil dibuat:\n";
    echo "   - ID: {$acceptanceNotification->id}\n";
    echo "   - Title: {$acceptanceNotification->title}\n";
    echo "   - Message: {$acceptanceNotification->message}\n";
    echo "   - Type: {$acceptanceNotification->data['type']}\n\n";
    
    // 4. Test notifikasi penolakan
    echo "🔔 Testing notifikasi penolakan...\n";
    $rejectionNotification = $notificationService->createEcosystemRejectionNotification(
        $user,
        $ecosystem,
        $user // menggunakan user yang sama sebagai approver untuk testing
    );
    
    echo "✅ Notifikasi penolakan berhasil dibuat:\n";
    echo "   - ID: {$rejectionNotification->id}\n";
    echo "   - Title: {$rejectionNotification->title}\n";
    echo "   - Message: {$rejectionNotification->message}\n";
    echo "   - Type: {$rejectionNotification->data['type']}\n\n";
    
    // 5. Cek total notifikasi user
    $totalNotifications = $user->notifications()->count();
    $unreadNotifications = $user->notifications()->where('is_read', false)->count();
    
    echo "📊 Statistik notifikasi untuk {$user->name}:\n";
    echo "   - Total notifikasi: {$totalNotifications}\n";
    echo "   - Belum dibaca: {$unreadNotifications}\n\n";
    
    // 6. Test mark as read
    echo "🔔 Testing mark as read...\n";
    $acceptanceNotification->markAsRead();
    echo "✅ Notifikasi penerimaan berhasil di-mark as read\n\n";
    
    // 7. Test recent notifications
    echo "🔔 Testing recent notifications...\n";
    $recentNotifications = $user->notifications()
        ->orderBy('created_at', 'desc')
        ->limit(3)
        ->get();
    
    echo "✅ Recent notifications (3 terbaru):\n";
    foreach ($recentNotifications as $index => $notification) {
        $status = $notification->is_read ? '✅ Read' : '🔴 Unread';
        echo "   " . ($index + 1) . ". [{$status}] {$notification->title}\n";
        echo "      Message: {$notification->message}\n";
        echo "      Created: {$notification->created_at->diffForHumans()}\n\n";
    }
    
    echo "🎉 Semua test berhasil! Sistem notifikasi ekosistem berfungsi dengan baik.\n";
    echo "\n📝 Catatan:\n";
    echo "- Notifikasi akan muncul di header website\n";
    echo "- Real-time notification memerlukan Pusher configuration\n";
    echo "- User dapat melihat semua notifikasi di /notifications\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
