<?php

namespace App\Livewire\Admin;

use App\Models\PasarKolaboraya;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use App\Events\UserQrScannedSuccessfully;

#[Layout('components.admin.layout', ['title' => 'Scanner QR Pasar Kolaboraya'])]
class PasarKolaborayaQrScanner extends Component
{
    public $pasarKolaboraya;
    public $scannedQrCode = '';
    public $validationResult = null;
    public $isScanning = false;
    public $scanHistory = [];
    public $showHistory = false;
    public $memberCount = 0;

    protected $rules = [
        'scannedQrCode' => 'required|string|min:10'
    ];

    protected $messages = [
        'scannedQrCode.required' => 'QR code harus diisi',
        'scannedQrCode.min' => 'QR code tidak valid'
    ];

    public function mount(PasarKolaboraya $pasarKolaboraya)
    {
        // Check if user is admin
        if (!in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Unauthorized access');
        }

        // Load Pasar Kolaboraya
        $this->pasarKolaboraya = $pasarKolaboraya;
        
        // Check if Pasar Kolaboraya is active
        if ($this->pasarKolaboraya->status !== 'active') {
            session()->flash('error', 'Pasar Kolaboraya tidak aktif');
            return redirect()->route('admin.pasar-kolaboraya');
        }
        
        // Load recent scan history
        $this->loadScanHistory();
        
        // Load member count
        $this->updateMemberCount();
    }

    public function validateQrCode()
    {
        $this->validate();

        try {
            // Find user by QR code directly
            $user = User::where('qr_code', $this->scannedQrCode)->first();
            
            if (!$user) {
                $this->validationResult = [
                    'valid' => false,
                    'message' => 'QR code tidak valid atau tidak ditemukan'
                ];
                session()->flash('error', 'QR code tidak valid atau tidak ditemukan');
                $this->addToScanHistory(null, false);
                return;
            }

            // Check if QR code is still valid (not expired)
            if (!$user->isQrCodeValid()) {
                $this->validationResult = [
                    'valid' => false,
                    'message' => 'QR code sudah expired. Silakan generate ulang.'
                ];
                session()->flash('error', 'QR code sudah expired. Silakan generate ulang.');
                $this->addToScanHistory($user, false);
                return;
            }

            // Check if user is already a member of this Pasar Kolaboraya
            $existingMembership = $this->pasarKolaboraya->users()->where('user_id', $user->id)->first();
            
            if ($existingMembership) {
                if ($existingMembership->pivot->status === 'accepted') {
                    $this->validationResult = [
                        'valid' => false,
                        'message' => 'User sudah menjadi anggota Pasar Kolaboraya ini'
                    ];
                    session()->flash('error', 'User sudah menjadi anggota Pasar Kolaboraya ini');
                    $this->addToScanHistory($user, false);
                    return;
                } else {
                    // Update existing pending membership to accepted
                    $this->pasarKolaboraya->users()->updateExistingPivot($user->id, [
                        'status' => 'accepted',
                        'joined_at' => now(),
                        'responded_at' => now(),
                    ]);
                }
            } else {
                // Add user to Pasar Kolaboraya
                $this->pasarKolaboraya->users()->attach($user->id, [
                    'status' => 'accepted',
                    'role' => 'member',
                    'invited_by' => Auth::user()->id,
                    'join_reason' => 'QR Code Access Grant',
                    'joined_at' => now(),
                    'responded_at' => now(),
                ]);
            }
            
            // Set as active Pasar Kolaboraya for user
            $user->setActivePasarKolaboraya($this->pasarKolaboraya);
            
            // Log the access grant
            \Illuminate\Support\Facades\Log::info('QR Code Access Granted', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'qr_code' => $this->scannedQrCode,
                'pasar_kolaboraya_id' => $this->pasarKolaboraya->id,
                'pasar_kolaboraya_name' => $this->pasarKolaboraya->name,
                'granted_by' => Auth::user() ? Auth::user()->name : 'System',
                'granted_at' => now(),
            ]);
            
            $this->validationResult = [
                'valid' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'qr_code_generated_at' => $user->qr_code_generated_at,
                ],
                'message' => 'User ' . $user->name . ' berhasil bergabung ke Pasar Kolaboraya!'
            ];
            session()->flash('success', 'User ' . $user->name . ' berhasil bergabung ke Pasar Kolaboraya!');
            
            // Add to scan history
            $this->addToScanHistory($user, true);
            
            // Update member count
            $this->updateMemberCount();
            
            // Broadcast event to notify user's browser to redirect to dashboard
            broadcast(new UserQrScannedSuccessfully(
                $user->id,
                $this->pasarKolaboraya->name,
                route('dashboard')
            ));
            
            // Reset form for next scan
            $this->reset(['scannedQrCode']);
            
        } catch (\Exception $e) {
            $this->validationResult = [
                'valid' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
            session()->flash('error', 'Terjadi kesalahan saat validasi QR code');
            $this->addToScanHistory(null, false);
        }
    }

    public function grantAccess()
    {
        if (!$this->validationResult || !$this->validationResult['valid']) {
            session()->flash('error', 'QR code tidak valid');
            return;
        }

        try {
            // Find user by QR code
            $user = User::where('qr_code', $this->scannedQrCode)->first();
            
            if (!$user) {
                session()->flash('error', 'User tidak ditemukan');
                return;
            }
            
            // Check if user is already a member of this Pasar Kolaboraya
            $existingMembership = $this->pasarKolaboraya->users()->where('user_id', $user->id)->first();
            
            if ($existingMembership) {
                if ($existingMembership->pivot->status === 'accepted') {
                    session()->flash('error', 'User sudah menjadi anggota Pasar Kolaboraya ini');
                    return;
                } else {
                    // Update existing pending membership to accepted
                    $this->pasarKolaboraya->users()->updateExistingPivot($user->id, [
                        'status' => 'accepted',
                        'joined_at' => now(),
                        'responded_at' => now(),
                    ]);
                }
            } else {
                // Add user to Pasar Kolaboraya
                $this->pasarKolaboraya->users()->attach($user->id, [
                    'status' => 'accepted',
                    'role' => 'member',
                    'invited_by' => Auth::user()->id,
                    'join_reason' => 'QR Code Access Grant',
                    'joined_at' => now(),
                    'responded_at' => now(),
                ]);
            }
            
            // Set as active Pasar Kolaboraya for user
            $user->setActivePasarKolaboraya($this->pasarKolaboraya);
            
            // Log the access grant
            \Illuminate\Support\Facades\Log::info('QR Code Access Granted', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'qr_code' => $this->scannedQrCode,
                'pasar_kolaboraya_id' => $this->pasarKolaboraya->id,
                'pasar_kolaboraya_name' => $this->pasarKolaboraya->name,
                'granted_by' => Auth::user() ? Auth::user()->name : 'System',
                'granted_at' => now(),
            ]);
            
            session()->flash('success', 'Akses berhasil diberikan kepada ' . $user->name . ' untuk Pasar Kolaboraya: ' . $this->pasarKolaboraya->name);
            
            // Reset form
            $this->reset(['scannedQrCode', 'validationResult']);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function clearForm()
    {
        $this->reset(['scannedQrCode', 'validationResult']);
        session()->flash('message', 'Form berhasil direset');
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

    public function onQrScanned($qrCode)
    {
        $this->scannedQrCode = $qrCode;
        $this->isScanning = false;
        $this->validateQrCode();
    }

    private function loadScanHistory()
    {
        // Load from session or database
        $this->scanHistory = session()->get('qr_scan_history_' . $this->pasarKolaboraya->id, []);
    }

    private function addToScanHistory($user = null, $valid = false)
    {
        $scanEntry = [
            'qr_code' => $this->scannedQrCode,
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'valid' => $valid,
            'user_name' => $user ? $user->name : 'Unknown',
            'pasar_kolaboraya' => $this->pasarKolaboraya->name,
            'message' => $this->validationResult['message'] ?? 'No message'
        ];

        $this->scanHistory = array_slice(
            array_merge([$scanEntry], $this->scanHistory),
            0,
            20 // Keep only last 20 scans
        );

        session()->put('qr_scan_history_' . $this->pasarKolaboraya->id, $this->scanHistory);
    }

    public function toggleHistory()
    {
        $this->showHistory = !$this->showHistory;
    }

    private function updateMemberCount()
    {
        $this->memberCount = $this->pasarKolaboraya->acceptedUsers()->count();
    }

    public function render()
    {
        return view('livewire.admin.pasar-kolaboraya-qr-scanner');
    }
}
