<?php

namespace App\Livewire\Connections;

use App\Models\ConnectionQr;
use App\Models\Connection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Events\ConnectionSuccess;
use App\Services\NotificationService;

class QrScanner extends Component
{
    public $scannedQrCode = '';
    public $isScanning = false;
    public $connectionStatus = 'idle'; // idle, waiting_for_response, connected
    public $myQrCode = '';
    public $myQrSvg = '';
    public $targetUser = null;
    public $errorMessage = '';
    public $successMessage = '';
    public $currentConnectionId = null; // ID koneksi yang sedang berlangsung

    protected $listeners = [
        'qr-scanned' => 'handleQrScanned',
        'check-connection-status' => 'checkConnectionStatus',
        'stop-connection-polling' => 'stopConnectionPolling',
        'check-connection' => 'connectionCheck',
    ];

    public function onQrScanned($qrCode)
    {
        $this->handleQrScanned($qrCode);
    }

    public function stopConnectionPolling()
    {
        // Method ini dipanggil ketika user menghentikan proses koneksi
        // Tidak perlu melakukan apa-apa karena polling sudah dihentikan di frontend
    }

    private function checkExistingConnections()
    {
        $user = Auth::user();
        $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;

        if (!$pasarKolaborayaId) {
            return;
        }

        // Check if there are any active connections
        $activeConnections = Connection::where('requester_id', $user->id)
            ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('status', 'accepted')
            ->orWhere(function ($query) use ($user, $pasarKolaborayaId) {
                $query->where('receiver_id', $user->id)
                    ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
                    ->where('status', 'accepted');
            })
            ->with(['requester', 'receiver'])
            ->get();
    }

    public function mount()
    {
        $this->generateMyQr();

        $this->successMessage = '';
        // Set up auto-refresh for QR codes
        $this->dispatch('start-qr-refresh');

        // Check if there are any existing connections that need to be displayed
        // $this->checkExistingConnections();
    }

    public function render()
    {
        return view('livewire.connections.qr-scanner');
    }

    public function generateMyQr()
    {
        $user = Auth::user();
        $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;

        if (!$pasarKolaborayaId) {
            $this->errorMessage = 'Anda harus bergabung dengan Pasar Kolaboraya terlebih dahulu';
            return;
        }

        // Create or refresh QR code
        $connectionQr = ConnectionQr::createOrRefreshQr($user->id, $pasarKolaborayaId, 'initiator');
        $this->myQrCode = $connectionQr->qr_code;

        // Generate SVG
        $this->myQrSvg = '' . QrCode::size(200)
            ->format('svg')
            ->generate($this->myQrCode) . '';

        $this->connectionStatus = 'idle';
        $this->currentConnectionId = null;
        $this->targetUser = null;
        $this->errorMessage = '';
        $this->successMessage = 'Kode berhasil dibuat. Tunjukkan QR ini kepada user lain untuk di-scan.';
    }

    public function handleQrScanned($qrCode)
    {
        $this->scannedQrCode = $qrCode;
        $this->processScannedQr();
    }

    public function processScannedQr()
    {
        $this->errorMessage = '';
        $this->successMessage = '';

        if (empty($this->scannedQrCode)) {
            return;
        }

        $user = Auth::user();
        $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;

        // Find the scanned QR
        $scannedQr = ConnectionQr::where('qr_code', $this->scannedQrCode)
            ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$scannedQr) {
            $this->errorMessage = 'Kode tidak valid atau sudah expired';
            return;
        }

        // Check if it's the same user
        if ($scannedQr->user_id === $user->id) {
            $this->errorMessage = 'Anda tidak dapat memasukan Kode sendiri';
            return;
        }

        // Check if users are already connected
        if ($this->areUsersAlreadyConnected($user->id, $scannedQr->user_id, $pasarKolaborayaId)) {
            $this->targetUser = $scannedQr->user;
            $this->connectionStatus = 'connected';
            $this->successMessage = 'Anda sudah terhubung dengan <strong>' . $scannedQr->user->name . '</strong>!';

            // Schedule auto-idle for already connected users
            $this->dispatch('schedule-auto-idle');
            return;
        }

        $this->targetUser = $scannedQr->user;

        $this->dispatch('start-connection-polling');

        if ($scannedQr->type === 'initiator') {
            // User B scanning User A's QR
            $this->handleInitiatorQrScanned($scannedQr);
        } else {
            // User A scanning User B's response QR
            $this->handleResponderQrScanned($scannedQr);
        }
    }

    private function handleInitiatorQrScanned($scannedQr)
    {
        $user = Auth::user();
        $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;

        // Double check if users are already connected
        if ($this->areUsersAlreadyConnected($user->id, $scannedQr->user_id, $pasarKolaborayaId)) {
            $this->connectionStatus = 'connected';
            $this->successMessage = 'Anda sudah terhubung dengan <strong>' . $scannedQr->user->name . '</strong>!';

            // Schedule auto-idle for already connected users
            $this->dispatch('schedule-auto-idle');
            return;
        }

        // Mark the initiator QR as used
        $scannedQr->markAsUsed();

        // Create responder QR for User B
        $responderQr = ConnectionQr::createOrRefreshQr(
            $user->id,
            $pasarKolaborayaId,
            'responder',
            $scannedQr->qr_code
        );

        // Update my QR display
        $this->myQrCode = $responderQr->qr_code;
        $this->myQrSvg = '' . QrCode::size(200)
            ->format('svg')
            ->generate($this->myQrCode) . '';

        $this->connectionStatus = 'waiting_for_response';
        $this->successMessage = 'QR berhasil di-scan! Sekarang tunjukkan QR Anda kepada <strong>' . $this->targetUser->name . '</strong> untuk menyelesaikan koneksi.';

        // Simpan state koneksi yang sedang berlangsung
        $this->currentConnectionId = $responderQr->id;

        // Start polling to check when the other party completes the connection
        // We'll use the QR code as identifier since connection doesn't exist yet
        $this->dispatch('start-connection-polling', [
            'qr_code' => $responderQr->qr_code,
            'target_user_id' => $scannedQr->user_id,
            'pasar_kolaboraya_id' => $pasarKolaborayaId
        ]);
    }

    private function handleResponderQrScanned($scannedQr)
    {
        $user = Auth::user();
        $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;

        // Double check if users are already connected
        if ($this->areUsersAlreadyConnected($user->id, $scannedQr->user_id, $pasarKolaborayaId)) {
            $this->connectionStatus = 'connected';
            $this->successMessage = 'Anda sudah terhubung dengan <strong>' . $scannedQr->user->name . '</strong>!';

            // Schedule auto-idle for already connected users
            $this->dispatch('schedule-auto-idle');
            return;
        }

        // Verify this is the correct responder QR
        if ($scannedQr->target_qr_code !== $this->myQrCode) {
            $this->errorMessage = 'Kode tidak sesuai dengan koneksi yang sedang berlangsung';
            return;
        }

        // Mark the responder QR as used
        $scannedQr->markAsUsed();

        // Create the connection
        $this->createConnection($scannedQr->user_id, $user->id, $pasarKolaborayaId);

        $this->connectionStatus = 'connected';
        $this->successMessage = 'Koneksi berhasil! Anda sekarang terhubung dengan <strong>' . $this->targetUser->name . '</strong>';
        $this->currentConnectionId = null; // Reset connection ID karena koneksi sudah selesai

        // Auto-reset after 3 seconds for both parties
        $this->dispatch('connection-completed');

        // Start polling to check if the other party has also completed the connection
        $connectionId = $this->getLatestConnectionId($user->id, $scannedQr->user_id, $pasarKolaborayaId);
        $this->dispatch('start-connection-polling', [
            'connection_id' => $connectionId
        ]);
    }

    private function createConnection($requesterId, $receiverId, $pasarKolaborayaId)
    {
        // Check if connection already exists (including soft-deleted ones)
        $existingConnection = Connection::withTrashed()
            ->where('requester_id', $requesterId)
            ->where('receiver_id', $receiverId)
            ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->orWhere(function ($query) use ($requesterId, $receiverId, $pasarKolaborayaId) {
                $query->where('requester_id', $receiverId)
                    ->where('receiver_id', $requesterId)
                    ->where('pasar_kolaboraya_id', $pasarKolaborayaId);
            })
            ->first();

        $connection = null;
        if ($existingConnection) {
            if ($existingConnection->trashed()) {
                // Restore the soft-deleted connection and update status
                $existingConnection->restore();
                $existingConnection->update(['status' => 'accepted']);
                $connection = $existingConnection;
            } else {
                $connection = $existingConnection;
            }
        } else {
            // Create new connection
            $connection = Connection::create([
                'requester_id' => $requesterId,
                'receiver_id' => $receiverId,
                'pasar_kolaboraya_id' => $pasarKolaborayaId,
                'status' => 'accepted',
            ]);
        }

        // Get user models for broadcasting
        $requester = \App\Models\User::find($requesterId);
        $receiver = \App\Models\User::find($receiverId);

        if ($connection && $requester && $receiver) {
            // Broadcast connection success event
            broadcast(new ConnectionSuccess($requester, $receiver, $pasarKolaborayaId, $connection->id));

            // Send notifications to both users
            $notificationService = app(NotificationService::class);

            $notificationService->createNotification(
                $requester,
                'Koneksi Berhasil!',
                'Anda berhasil terhubung dengan ' . $receiver->name,
                null,
                ['connection_id' => $connection->id, 'connected_user' => $receiver->name]
            );

            $notificationService->createNotification(
                $receiver,
                'Koneksi Berhasil!',
                'Anda berhasil terhubung dengan ' . $requester->name,
                null,
                ['connection_id' => $connection->id, 'connected_user' => $requester->name]
            );
        }
    }

    public function startScanning()
    {
        $this->isScanning = true;
        $this->dispatch('start-camera');
    }

    public function stopScanning()
    {
        $this->isScanning = false;
        $this->dispatch('stop-camera');
    }

    public function resetConnection()
    {
        // Hentikan proses koneksi yang sedang berlangsung
        if ($this->connectionStatus === 'waiting_for_response') {
            $user = Auth::user();
            $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;

            // Mark semua QR code yang terkait sebagai expired
            if ($pasarKolaborayaId) {
                ConnectionQr::where('user_id', $user->id)
                    ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
                    ->where('type', 'responder')
                    ->where('is_used', false)
                    ->update(['expires_at' => now()->subMinute()]);
            }
        }

        // Reset semua state
        $this->connectionStatus = 'idle';
        $this->targetUser = null;
        $this->scannedQrCode = '';
        $this->errorMessage = '';
        $this->successMessage = '';
        $this->currentConnectionId = null;

        // Generate QR code baru
        $this->generateMyQr();

        // Dispatch event untuk menghentikan polling
        $this->dispatch('stop-connection-polling');
    }

    public function refreshQr()
    {
        // Jika sedang dalam proses koneksi (waiting_for_response), 
        // generate ulang QR response untuk melanjutkan proses
        if ($this->connectionStatus === 'waiting_for_response' && $this->targetUser) {
            $this->generateResponseQr();
        } else {
            // Jika idle atau connected, generate QR baru biasa
            $this->generateMyQr();
        }
        $this->dispatch('reset-interval-qr-refresh');
    }

    private function generateResponseQr()
    {
        $user = Auth::user();
        $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;

        if (!$pasarKolaborayaId) {
            $this->errorMessage = 'Anda harus bergabung dengan Pasar Kolaboraya terlebih dahulu';
            return;
        }

        // Check if users are already connected
        if ($this->targetUser && $this->areUsersAlreadyConnected($user->id, $this->targetUser->id, $pasarKolaborayaId)) {
            $this->connectionStatus = 'connected';
            $this->successMessage = 'Anda sudah terhubung dengan <strong>' . $this->targetUser->name . '</strong>!';
            return;
        }

        // Cari QR code yang sedang digunakan untuk koneksi ini
        $currentQr = null;
        if ($this->currentConnectionId) {
            $currentQr = ConnectionQr::find($this->currentConnectionId);
        }

        if (!$currentQr || $currentQr->is_used || $currentQr->expires_at <= now()) {
            $currentQr = ConnectionQr::where('user_id', $user->id)
                ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
                ->where('type', 'responder')
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->first();
        }

        if ($currentQr) {
            // Refresh QR yang sudah ada
            $connectionQr = ConnectionQr::createOrRefreshQr(
                $user->id,
                $pasarKolaborayaId,
                'responder',
                $currentQr->target_qr_code
            );
        } else {
            // Buat QR baru jika tidak ada yang valid
            $connectionQr = ConnectionQr::createOrRefreshQr(
                $user->id,
                $pasarKolaborayaId,
                'responder'
            );
        }

        $this->myQrCode = $connectionQr->qr_code;

        // Generate SVG
        $this->myQrSvg = '' . QrCode::size(200)
            ->format('svg')
            ->generate($this->myQrCode) . '';

        // Update current connection ID
        $this->currentConnectionId = $connectionQr->id;

        $this->connectionStatus = 'waiting_for_response';
        $this->errorMessage = '';
        $this->successMessage = 'Kode Response berhasil diperbarui. Berikan kode ini kepada ' . $this->targetUser->name . ' untuk melanjutkan koneksi.';
    }

    private function areUsersAlreadyConnected($userId1, $userId2, $pasarKolaborayaId)
    {
        $connection = Connection::where('requester_id', $userId1)
            ->where('receiver_id', $userId2)
            ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('status', 'accepted')
            ->orWhere(function ($query) use ($userId1, $userId2, $pasarKolaborayaId) {
                $query->where('requester_id', $userId2)
                    ->where('receiver_id', $userId1)
                    ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
                    ->where('status', 'accepted');
            })
            ->first();

        return $connection ? true : false;
    }

    private function getLatestConnectionId($requesterId, $receiverId, $pasarKolaborayaId)
    {
        $connection = Connection::where('requester_id', $requesterId)
            ->where('receiver_id', $receiverId)
            ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->orWhere(function ($query) use ($requesterId, $receiverId, $pasarKolaborayaId) {
                $query->where('requester_id', $receiverId)
                    ->where('receiver_id', $requesterId)
                    ->where('pasar_kolaboraya_id', $pasarKolaborayaId);
            })
            ->latest()
            ->first();

        return $connection ? $connection->id : null;
    }

    public function checkConnectionStatus($data)
    {
        if (is_string($data)) {
            // Handle old format with just connection ID
            $connection = Connection::find($data);
            if ($connection && $connection->status === 'accepted') {
                $this->currentConnectionId = null;
                $this->resetConnection();
            }
            return;
        }

        if (isset($data['connection_id'])) {
            // Handle new format with connection ID
            $connection = Connection::find($data['connection_id']);
            if ($connection && $connection->status === 'accepted') {
                $this->currentConnectionId = null;
                $this->resetConnection();
            }
        } elseif (isset($data['qr_code'])) {
            // Handle polling based on QR code (for initiator)
            $qrCode = $data['qr_code'];
            $targetUserId = $data['target_user_id'];
            $pasarKolaborayaId = $data['pasar_kolaboraya_id'];

            // Check if users are already connected
            $user = Auth::user();
            if ($this->areUsersAlreadyConnected($user->id, $targetUserId, $pasarKolaborayaId)) {
                $this->connectionStatus = 'connected';
                $this->successMessage = 'Anda sudah terhubung dengan user ini!';
                $this->currentConnectionId = null;
                return;
            }

            // Check if the responder QR has been used (connection completed)
            $responderQr = \App\Models\ConnectionQr::where('qr_code', $qrCode)
                ->where('is_used', true)
                ->first();

            if ($responderQr) {
                // Connection completed, auto-reset
                $this->currentConnectionId = null;
                $this->resetConnection();
            }
        }
    }

    public function connectionCheck()
    {
        $conn = ConnectionQr::where('qr_code', $this->myQrCode)->orWhere('target_qr_code', $this->myQrCode)->where('is_used', true)->orderBy('created_at', 'desc')->first();
        if ($conn->qr_code !== null && $conn->target_qr_code !== null) {
            $this->connectionStatus = 'connected';
            $this->successMessage = 'Anda berhasil terhubung dengan <strong>' . $this->targetUser->name . '</strong>!';
            $this->dispatch('connected');
            $this->dispatch('schedule-auto-idle');
        }
    }
}
