<?php

namespace App\Livewire\Ecosystem;

use App\Models\Ecosystem;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrScanner extends Component
{
    public $scannedQrCode = '';
    public $isScanning = false;
    public $errorMessage = '';
    public $successMessage = '';
    public $ecosystem = null;

    protected $listeners = [
        'qr-scanned' => 'handleQrScanned',
        'start-scanning' => 'startScanning',
        'stop-scanning' => 'stopScanning'
    ];

    public function mount()
    {
        // Set up auto-refresh for QR codes
        $this->dispatch('start-qr-refresh');
    }

    public function render()
    {
        return view('livewire.ecosystem.qr-scanner');
    }

    public function startScanning()
    {
        $this->isScanning = true;
        $this->errorMessage = '';
        $this->successMessage = '';
        $this->dispatch('start-camera');
    }

    public function stopScanning()
    {
        $this->isScanning = false;
        $this->dispatch('stop-camera');
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

        try {
            // Check if user can join ecosystems first
            if (Auth::check()) {
                /** @var User $user */
                $user = Auth::user();
                if (!$user->canJoinEcosystemsAndActions()) {
                    $this->errorMessage = 'Anda tidak dapat bergabung dengan ekosistem. Hanya pengguna tamu dan partisipan yang dapat bergabung.';
                    return;
                }
            }

            // Validate QR code format first
            if (empty($this->scannedQrCode)) {
                $this->errorMessage = 'QR code tidak boleh kosong.';
                return;
            }

            // Try to find ecosystem by QR code
            $ecosystemId = Ecosystem::where('qr_code', $this->scannedQrCode)->value('id');
            
            if (!$ecosystemId) {
                // Try alternative formats
                $ecosystemId = $this->extractEcosystemIdFromQr($this->scannedQrCode);
                
                if (!$ecosystemId) {
                    $this->errorMessage = 'QR code tidak valid. Pastikan QR code adalah untuk bergabung ekosistem.';
                    return;
                }
            }

            // Find ecosystem
            $ecosystem = Ecosystem::find($ecosystemId);
            
            if (!$ecosystem) {
                $this->errorMessage = 'Ekosistem tidak ditemukan.';
                return;
            }

            // Check if ecosystem is active
            if (!$ecosystem->is_active) {
                $this->errorMessage = 'Ekosistem tidak aktif.';
                return;
            }

            // Check if user is already a member
            if (Auth::check()) {
                $userStatus = $ecosystem->getUserStatus(Auth::user());
                
                if ($userStatus === 'accepted') {
                    $this->errorMessage = 'Anda sudah menjadi anggota ekosistem ini.';
                    return;
                }
                
                if ($userStatus === 'pending') {
                    $this->errorMessage = 'Permintaan bergabung Anda sedang menunggu persetujuan.';
                    return;
                }
            }

            // Store ecosystem for redirect
            $this->ecosystem = $ecosystem;
            $this->successMessage = 'QR code berhasil di-scan! Mengarahkan ke form bergabung...';
            
            // Log for debugging
            Log::info('QR Code redirect triggered', [
                'ecosystem_id' => $ecosystem->id,
                'user_id' => Auth::id(),
                'qr_code' => $this->scannedQrCode,
            ]);
            
            // Use Livewire redirect instead of JavaScript
            $this->js('
                setTimeout(() => {
                    console.log("Redirecting to ecosystem join page...");
                    window.location.href = "/ecosystem/' . $ecosystem->id . '/join";
                }, 2000);
            ');

        } catch (\Exception $e) {
            Log::error('QR Code Scan Error', [
                'qr_code' => $this->scannedQrCode,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            $this->errorMessage = 'Terjadi kesalahan saat memproses QR code. Silakan coba lagi.';
        }
    }

    /**
     * Extract ecosystem ID from QR code URL
     */
    private function extractEcosystemIdFromQr($qrCode)
    {
        // Expected format: /ecosystem/{id}/join
        if (preg_match('/\/ecosystem\/(\d+)\/join/', $qrCode, $matches)) {
            return $matches[1];
        }
        
        // Also handle full URLs
        if (preg_match('/ecosystem\/(\d+)\/join/', $qrCode, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

    public function clearMessages()
    {
        $this->errorMessage = '';
        $this->successMessage = '';
    }
}
