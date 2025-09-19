<?php

namespace App\Livewire\Connections;

use App\Models\ConnectionQr;
use App\Models\Connection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    protected $listeners = [
        'qr-scanned' => 'handleQrScanned',
        'check-connection-status' => 'checkConnectionStatus'
    ];

    public function mount()
    {
        $this->generateMyQr();
        
        // Set up auto-refresh for QR codes
        $this->dispatch('start-qr-refresh');
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
        $this->myQrSvg = ''.QrCode::size(200)
        ->format('svg')
        ->generate($this->myQrCode).'';
        
        $this->connectionStatus = 'idle';
        $this->errorMessage = '';
        $this->successMessage = 'QR Code berhasil dibuat. Tunjukkan QR ini kepada user lain untuk di-scan.';
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
            $this->errorMessage = 'QR Code tidak valid atau sudah expired';
            return;
        }

        // Check if it's the same user
        if ($scannedQr->user_id === $user->id) {
            $this->errorMessage = 'Anda tidak dapat scan QR code sendiri';
            return;
        }

        $this->targetUser = $scannedQr->user;

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
        $this->myQrSvg = ''.QrCode::size(200)
            ->format('svg')
            ->generate($this->myQrCode).'';

        $this->connectionStatus = 'waiting_for_response';
        $this->successMessage = 'QR berhasil di-scan! Sekarang tunjukkan QR Anda kepada ' . $this->targetUser->name . ' untuk menyelesaikan koneksi.';
        
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

        // Verify this is the correct responder QR
        if ($scannedQr->target_qr_code !== $this->myQrCode) {
            $this->errorMessage = 'QR Code tidak sesuai dengan koneksi yang sedang berlangsung';
            return;
        }

        // Mark the responder QR as used
        $scannedQr->markAsUsed();

        // Create the connection
        $this->createConnection($scannedQr->user_id, $user->id, $pasarKolaborayaId);

        $this->connectionStatus = 'connected';
        $this->successMessage = 'Koneksi berhasil! Anda sekarang terhubung dengan ' . $this->targetUser->name;
        
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
            ->first();

        if ($existingConnection) {
            if ($existingConnection->trashed()) {
                // Restore the soft-deleted connection and update status
                $existingConnection->restore();
                $existingConnection->update(['status' => 'accepted']);
            }
            // If connection exists and is not trashed, do nothing
        } else {
            // Create new connection
            Connection::create([
                'requester_id' => $requesterId,
                'receiver_id' => $receiverId,
                'pasar_kolaboraya_id' => $pasarKolaborayaId,
                'status' => 'accepted',
            ]);
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
        $this->connectionStatus = 'idle';
        $this->targetUser = null;
        $this->scannedQrCode = '';
        $this->errorMessage = '';
        $this->successMessage = '';
        $this->generateMyQr();
    }

    public function refreshQr()
    {
        $this->generateMyQr();
    }

    private function getLatestConnectionId($requesterId, $receiverId, $pasarKolaborayaId)
    {
        $connection = Connection::where('requester_id', $requesterId)
            ->where('receiver_id', $receiverId)
            ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->orWhere(function($query) use ($requesterId, $receiverId, $pasarKolaborayaId) {
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
                $this->resetConnection();
            }
            return;
        }

        if (isset($data['connection_id'])) {
            // Handle new format with connection ID
            $connection = Connection::find($data['connection_id']);
            if ($connection && $connection->status === 'accepted') {
                $this->resetConnection();
            }
        } elseif (isset($data['qr_code'])) {
            // Handle polling based on QR code (for initiator)
            $qrCode = $data['qr_code'];
            $targetUserId = $data['target_user_id'];
            $pasarKolaborayaId = $data['pasar_kolaboraya_id'];
            
            // Check if the responder QR has been used (connection completed)
            $responderQr = \App\Models\ConnectionQr::where('qr_code', $qrCode)
                ->where('is_used', true)
                ->first();
                
            if ($responderQr) {
                // Connection completed, auto-reset
                $this->resetConnection();
            }
        }
    }
}
