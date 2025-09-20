<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'QR Scanner - Aksi Kolektif'])]
class QrScanner extends Component
{
    public $scannedQrCode = '';
    public $errorMessage = '';
    public $successMessage = '';
    public $collectiveAction = null;

    public function processScannedQr()
    {
        $this->errorMessage = '';
        $this->successMessage = '';

        try {
            // Parse QR code URL to get collective action ID
            $collectiveActionId = $this->extractCollectiveActionIdFromQr($this->scannedQrCode);
            
            if (!$collectiveActionId) {
                $this->errorMessage = 'QR code tidak valid. Pastikan QR code adalah untuk bergabung aksi kolektif.';
                return;
            }

            // Find collective action
            $collectiveAction = CollectiveAction::find($collectiveActionId);
            
            if (!$collectiveAction) {
                $this->errorMessage = 'Aksi kolektif tidak ditemukan.';
                return;
            }

            // Check if collective action is active
            if ($collectiveAction->status !== 'active') {
                $this->errorMessage = 'Aksi kolektif tidak aktif.';
                return;
            }

            // Check if user is already a member
            if (Auth::check()) {
                $existingMember = $collectiveAction->users()
                    ->where('user_id', Auth::id())
                    ->first();
                
                if ($existingMember) {
                    if ($existingMember->pivot->status === 'active') {
                        $this->errorMessage = 'Anda sudah menjadi anggota aksi kolektif ini.';
                        return;
                    }
                    
                    if ($existingMember->pivot->status === 'pending') {
                        $this->errorMessage = 'Permintaan bergabung Anda sedang menunggu persetujuan.';
                        return;
                    }
                }
            }

            // Store collective action for redirect
            $this->collectiveAction = $collectiveAction;
            $this->successMessage = 'QR code berhasil di-scan! Mengarahkan ke form bergabung...';
            
            // Log for debugging
            Log::info('QR Code redirect triggered', [
                'collective_action_id' => $collectiveAction->id,
                'user_id' => Auth::id(),
            ]);
            
            // Use JavaScript to redirect after showing success message
            $this->js('
                setTimeout(() => {
                    console.log("Redirecting to collective action join page...");
                    window.location.href = "/collective-actions/' . $collectiveAction->id . '/join";
                }, 2000);
            ');

        } catch (\Exception $e) {
            Log::error('QR Code Scan Error', [
                'qr_code' => $this->scannedQrCode,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            
            $this->errorMessage = 'Terjadi kesalahan saat memproses QR code.';
        }
    }

    /**
     * Extract collective action ID from QR code URL
     */
    private function extractCollectiveActionIdFromQr($qrCode)
    {
        // Expected format: /collective-actions/{id}/join
        if (preg_match('/\/collective-actions\/(\d+)\/join/', $qrCode, $matches)) {
            return $matches[1];
        }
        
        // Also handle full URLs
        if (preg_match('/collective-actions\/(\d+)\/join/', $qrCode, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

    public function clearMessages()
    {
        $this->errorMessage = '';
        $this->successMessage = '';
    }

    public function render()
    {
        return view('livewire.collective-action.qr-scanner');
    }
}
