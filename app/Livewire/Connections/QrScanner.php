<?php

namespace App\Livewire\Connections;

use App\Models\User;
use Livewire\Component;
use App\Models\Connection;
use Illuminate\Support\Facades\Auth;
use App\Services\ConnectionQrService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrScanner extends Component
{
    public string $scannedQrCode = '';
    public bool $isScanning = false;
    public string $connectionStatus = 'idle';

    public string $myQrCode = '';
    public string $myQrSvg = '';

    public ?int $targetUserId = null;
    public ?string $targetUserName = null;

    public ?string $currentQrCode = null;

    public string $errorMessage = '';
    public string $successMessage = '';

    protected $listeners = [
        'qr-scanned' => 'handleQrScanned',
        'check-connection-status' => 'checkConnectionStatus',
        'stop-connection-polling' => 'stopConnectionPolling',
    ];

    public function mount(): void
    {
        $this->generateMyQr();
        $this->dispatch('start-qr-refresh');
    }

    public function render()
    {
        return view('livewire.connections.qr-scanner');
    }

    /* =====================================================
     |  QR GENERATION
     |=====================================================*/

    public function generateMyQr(): void
    {
        $user = Auth::user();
        $pasarId = $user->active_pasar_kolaboraya_id;

        if (!$pasarId) {
            $this->errorMessage = 'Anda harus bergabung dengan Pasar Kolaboraya terlebih dahulu';
            return;
        }

        $message = 'Kode berhasil diperbarui. Tunjukkan ke user lain.';

        if ($this->myQrCode == '') {
            $message = '';
        }

        $qr = ConnectionQrService::create(
            $user->id,
            $pasarId,
            'initiator'
        );

        $this->myQrCode = $qr['qr_code'];
        $this->currentQrCode = $qr['qr_code'];
        $this->myQrSvg = QrCode::size(200)->format('svg')->generate($this->myQrCode);

        $this->resetUiState();
        $this->successMessage = $message;
    }

    /* =====================================================
     |  SCAN FLOW
     |=====================================================*/

    public function handleQrScanned(string $qrCode): void
    {
        $this->scannedQrCode = $qrCode;
        $this->processScannedQr();
    }

    public function processScannedQr(): void
    {
        $this->clearMessages();

        $user = Auth::user();
        $pasarId = $user->active_pasar_kolaboraya_id;

        $qr = ConnectionQrService::get($this->scannedQrCode);

        if (
            !$qr ||
            $qr['is_used'] ||
            $qr['pasar_id'] !== $pasarId ||
            $qr['expires_at'] < now()->timestamp
        ) {
            $this->errorMessage = 'Kode tidak valid atau expired';
            return;
        }

        if ($qr['user_id'] === $user->id) {
            $this->errorMessage = 'Tidak bisa scan kode sendiri';
            return;
        }

        $target = User::find($qr['user_id']);
        if (!$target) {
            $this->errorMessage = 'User tidak ditemukan';
            return;
        }

        $this->targetUserId = $target->id;
        $this->targetUserName = $target->name;

        if ($qr['type'] === 'initiator') {
            $this->handleInitiatorQr($qr);
        } else {
            $this->handleResponderQr($qr);
        }
    }

    private function handleInitiatorQr(array $qr): void
    {
        $user = Auth::user();

        ConnectionQrService::markUsed($qr['qr_code']);

        $responderQr = ConnectionQrService::create(
            $user->id,
            $qr['pasar_id'],
            'responder',
            $qr['user_id']
        );

        $this->myQrCode = $responderQr['qr_code'];
        $this->currentQrCode = $responderQr['qr_code'];
        $this->myQrSvg = QrCode::size(200)->format('svg')->generate($this->myQrCode);

        $this->connectionStatus = 'waiting_for_response';
        $this->successMessage = 'Berikan kode ini untuk menyelesaikan koneksi';
    }

    private function handleResponderQr(array $qr): void
    {
        $userId = Auth::id();
        // dd([$qr, 'user' => $userId, '$qr["target_user_id"] !== $userId' => $qr['target_user_id'] != $userId]);
        if ($qr['target_user_id'] != $userId) {
            $this->errorMessage = 'Kode tidak sesuai sesi';
            return;
        }

        ConnectionQrService::markUsed($qr['qr_code']);

        $this->createConnection(
            $qr['user_id'],
            $userId,
            $qr['pasar_id']
        );

        $this->connectionStatus = 'connected';
        $this->successMessage = 'Koneksi berhasil dengan ' . $this->targetUserName;
        $this->dispatch('connected');
    }

    /* =====================================================
     |  CONNECTION
     |=====================================================*/

    private function createConnection(int $requesterId, int $receiverId, int $pasarId): void
    {
        $connection = Connection::withTrashed()
            ->where(function ($q) use ($requesterId, $receiverId) {
                $q->where('requester_id', $requesterId)
                    ->where('receiver_id', $receiverId)
                    ->orWhere(function ($q) use ($requesterId, $receiverId) {
                        $q->where('requester_id', $receiverId)
                            ->where('receiver_id', $requesterId);
                    });
            })
            ->where('pasar_kolaboraya_id', $pasarId)
            ->first();

        if ($connection) {
            $connection->restore();
            $connection->update(['status' => 'accepted']);
        } else {
            $connection = Connection::create([
                'requester_id' => $requesterId,
                'receiver_id' => $receiverId,
                'pasar_kolaboraya_id' => $pasarId,
                'status' => 'accepted',
            ]);
        }
    }

    private function generateResponseQr(): void
    {
        $user = Auth::user();
        $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;

        if (!$pasarKolaborayaId) {
            $this->errorMessage = 'Anda harus bergabung dengan Pasar Kolaboraya terlebih dahulu';
            return;
        }

        // Jika sudah terhubung, hentikan proses
        if (
            $this->targetUserId &&
            $this->areUsersAlreadyConnected(
                $user->id,
                $this->targetUserId,
                $pasarKolaborayaId
            )
        ) {
            $this->connectionStatus = 'connected';
            $this->successMessage =
                'Anda sudah terhubung dengan <strong>' .
                $this->targetUserName .
                '</strong>!';
            return;
        }

        /*
         |------------------------------------------------------------
         | Ambil QR responder yang sedang aktif (jika ada)
         |------------------------------------------------------------
         */
        $connectionQr = ConnectionQrService::create(
            $user->id,
            $pasarKolaborayaId,
            'responder',
            $this->targetUserId ?: null
        );

        /*
         |------------------------------------------------------------
         | Update state Livewire (SCALAR ONLY)
         |------------------------------------------------------------
         */
        $this->myQrCode = $connectionQr['qr_code'];
        $this->currentQrCode = $connectionQr['qr_code'];

        $this->myQrSvg = QrCode::size(200)
            ->format('svg')
            ->generate($this->myQrCode);

        $this->connectionStatus = 'waiting_for_response';
        $this->errorMessage = '';
        $this->successMessage =
            'Kode Response berhasil diperbarui. Berikan kode ini kepada ' .
            $this->targetUserName .
            ' untuk melanjutkan koneksi.';
    }

    private function areUsersAlreadyConnected($userId1, $userId2, $pasarKolaborayaId)
    {
        return Connection::where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('status', 'accepted')
            ->where(function ($query) use ($userId1, $userId2) {
                $query->where(function ($q) use ($userId1, $userId2) {
                    $q->where('requester_id', $userId1)
                        ->where('receiver_id', $userId2);
                })->orWhere(function ($q) use ($userId1, $userId2) {
                    $q->where('requester_id', $userId2)
                        ->where('receiver_id', $userId1);
                });
            })
            ->exists();
    }

    public function resetConnection()
    {
        // Hentikan proses koneksi yang sedang berlangsung
        if ($this->connectionStatus === 'waiting_for_response') {
            $user = Auth::user();
            $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;

            // Mark semua QR code yang terkait sebagai expired
            if ($pasarKolaborayaId) {
                ConnectionQrService::get($this->scannedQrCode);
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

    /* =====================================================
     |  POLLING
     |=====================================================*/

    public function checkConnectionStatus(array $payload): void
    {
        if (!isset($payload['qr_code'])) {
            return;
        }

        $qr = ConnectionQrService::get($payload['qr_code']);

        if ($qr && $qr['is_used']) {
            $this->connectionStatus = 'connected';
            $this->successMessage = 'Koneksi berhasil dengan ' . $this->targetUserName;
            $this->dispatch('connected');
        }
    }

    public function stopConnectionPolling(): void
    {
        // handled in frontend
    }

    /* =====================================================
     |  UI HELPERS
     |=====================================================*/

    private function resetUiState(): void
    {
        $this->connectionStatus = 'idle';
        $this->targetUserId = null;
        $this->targetUserName = null;
        $this->currentQrCode = null;
        $this->clearMessages();
    }

    private function clearMessages(): void
    {
        $this->errorMessage = '';
        $this->successMessage = '';
    }
    public function refreshQr()
    {
        // Jika sedang dalam proses koneksi (waiting_for_response), 
        // generate ulang QR response untuk melanjutkan proses
        if ($this->connectionStatus === 'waiting_for_response' && $this->targetUserId) {
            $this->generateResponseQr();
        } else {
            // Jika idle atau connected, generate QR baru biasa
            $this->generateMyQr();
        }
        $this->dispatch('reset-interval-qr-refresh');
    }
}

