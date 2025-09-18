<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class QrScanner extends Component
{
    public $scannedQrCode = '';
    public $validationResult = null;
    public $isScanning = false;
    public $scanHistory = [];
    public $showHistory = false;
    public $selectedPasarKolaboraya = '';
    public $availablePasarKolaboraya = [];

    protected $rules = [
        'scannedQrCode' => 'required|string|min:10'
    ];

    protected $messages = [
        'scannedQrCode.required' => 'QR code harus diisi',
        'scannedQrCode.min' => 'QR code tidak valid'
    ];

    public function mount()
    {
        // Load recent scan history
        $this->loadScanHistory();
        
        // Load available Pasar Kolaboraya
        $this->loadAvailablePasarKolaboraya();
    }

    public function validateQrCode()
    {
        $this->validate();

        try {
            // Find user by QR code directly (no HTTP request)
            $user = \App\Models\User::where('qr_code', $this->scannedQrCode)->first();
            
            if (!$user) {
                $this->validationResult = [
                    'valid' => false,
                    'message' => 'QR code tidak valid atau tidak ditemukan'
                ];
                session()->flash('error', 'QR code tidak valid atau tidak ditemukan');
            } else {
                // Check if QR code is still valid (not expired)
                if (!$user->isQrCodeValid()) {
                    $this->validationResult = [
                        'valid' => false,
                        'message' => 'QR code sudah expired. Silakan generate ulang.'
                    ];
                    session()->flash('error', 'QR code sudah expired. Silakan generate ulang.');
                } else {
                    $this->validationResult = [
                        'valid' => true,
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'role' => $user->role,
                            'qr_code_generated_at' => $user->qr_code_generated_at,
                        ],
                        'message' => 'QR code valid. User dapat masuk ke Pasar Kolaboraya.'
                    ];
                    session()->flash('success', 'QR code valid! User: ' . $user->name);
                }
            }
        } catch (\Exception $e) {
            $this->validationResult = [
                'valid' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
            session()->flash('error', 'Terjadi kesalahan saat validasi QR code');
        }

        // Add to scan history
        $this->addToScanHistory();
    }

    public function grantAccess()
    {
        if (!$this->validationResult || !$this->validationResult['valid']) {
            session()->flash('error', 'QR code tidak valid');
            return;
        }

        if (!$this->selectedPasarKolaboraya) {
            session()->flash('error', 'Pilih Pasar Kolaboraya terlebih dahulu');
            return;
        }

        try {
            // Find user by QR code
            $user = \App\Models\User::where('qr_code', $this->scannedQrCode)->first();
            
            if (!$user) {
                session()->flash('error', 'User tidak ditemukan');
                return;
            }

            // Find Pasar Kolaboraya
            $pasarKolaboraya = \App\Models\PasarKolaboraya::find($this->selectedPasarKolaboraya);
            
            if (!$pasarKolaboraya) {
                session()->flash('error', 'Pasar Kolaboraya tidak ditemukan');
                return;
            }
            
            // Check if Pasar Kolaboraya is active
            if ($pasarKolaboraya->status !== 'active') {
                session()->flash('error', 'Pasar Kolaboraya tidak aktif');
                return;
            }
            
            // Check if user is already a member of this Pasar Kolaboraya
            $existingMembership = $pasarKolaboraya->users()->where('user_id', $user->id)->first();
            
            if ($existingMembership) {
                if ($existingMembership->pivot->status === 'accepted') {
                    session()->flash('error', 'User sudah menjadi anggota Pasar Kolaboraya ini');
                    return;
                } else {
                    // Update existing pending membership to accepted
                    $pasarKolaboraya->users()->updateExistingPivot($user->id, [
                        'status' => 'accepted',
                        'joined_at' => now(),
                        'responded_at' => now(),
                    ]);
                }
            } else {
                // Add user to Pasar Kolaboraya
                $pasarKolaboraya->users()->attach($user->id, [
                    'status' => 'accepted',
                    'role' => 'member',
                    'invited_by' => auth()->user()->id,
                    'join_reason' => 'QR Code Access Grant',
                    'joined_at' => now(),
                    'responded_at' => now(),
                ]);
            }
            
            // Set as active Pasar Kolaboraya for user
            $user->setActivePasarKolaboraya($pasarKolaboraya);
            
            // Log the access grant
            \Illuminate\Support\Facades\Log::info('QR Code Access Granted', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'qr_code' => $this->scannedQrCode,
                'pasar_kolaboraya_id' => $pasarKolaboraya->id,
                'pasar_kolaboraya_name' => $pasarKolaboraya->name,
                'granted_by' => auth()->user() ? auth()->user()->name : 'System',
                'granted_at' => now(),
            ]);
            
            session()->flash('success', 'Akses berhasil diberikan kepada ' . $user->name . ' untuk Pasar Kolaboraya: ' . $pasarKolaboraya->name);
            
            // Reset form
            $this->reset(['scannedQrCode', 'validationResult', 'selectedPasarKolaboraya']);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function clearForm()
    {
        $this->reset(['scannedQrCode', 'validationResult', 'selectedPasarKolaboraya']);
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
        $this->scanHistory = session()->get('qr_scan_history', []);
    }

    private function addToScanHistory()
    {
        $selectedPasar = collect($this->availablePasarKolaboraya)->firstWhere('id', $this->selectedPasarKolaboraya);
        
        $scanEntry = [
            'qr_code' => $this->scannedQrCode,
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'valid' => $this->validationResult['valid'] ?? false,
            'user_name' => $this->validationResult['user']['name'] ?? 'Unknown',
            'pasar_kolaboraya' => $selectedPasar ? $selectedPasar['name'] : 'Tidak dipilih',
            'message' => $this->validationResult['message'] ?? 'No message'
        ];

        $this->scanHistory = array_slice(
            array_merge([$scanEntry], $this->scanHistory),
            0,
            20 // Keep only last 20 scans
        );

        session()->put('qr_scan_history', $this->scanHistory);
    }

    private function loadAvailablePasarKolaboraya()
    {
        $this->availablePasarKolaboraya = \App\Models\PasarKolaboraya::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($pasar) {
                return [
                    'id' => $pasar->id,
                    'name' => $pasar->name,
                    'description' => $pasar->description,
                    'participant_count' => $pasar->acceptedUsers()->count(),
                    'created_at' => $pasar->created_at->format('d/m/Y H:i')
                ];
            })
            ->toArray();
    }

    public function toggleHistory()
    {
        $this->showHistory = !$this->showHistory;
    }

    public function clearHistory()
    {
        $this->scanHistory = [];
        session()->forget('qr_scan_history');
        session()->flash('message', 'Riwayat scan berhasil dihapus');
    }

    public function render()
    {
        return view('livewire.admin.qr-scanner');
    }
}