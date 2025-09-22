<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Scanner QR Pasar Kolaboraya</h1>
            <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">
                Scan QR code untuk bergabung ke: <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $pasarKolaboraya->name }}</span>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <flux:button href="{{ route('admin.pasar-kolaboraya.manage') }}" size="sm" icon="arrow-left">
                Kembali
            </flux:button>
        </div>
    </div>

    <!-- Pasar Kolaboraya Info -->
    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                <flux:icon.cube class="w-5 h-5 text-white" />
            </div>
            <div>
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">{{ $pasarKolaboraya->name }}</h3>
                 <p class="text-sm text-slate-500 dark:text-slate-400">
                     {{ $memberCount }} anggota • Dibuat oleh {{ $pasarKolaboraya->creator->name }}
                 </p>
            </div>
        </div>
    </div>

    <!-- QR Scanner Section -->
    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2">Scan QR Code User</h2>
            <p class="text-slate-600 dark:text-slate-400">Arahkan kamera ke QR code user untuk bergabung ke Pasar Kolaboraya</p>
        </div>

        <!-- Camera Section -->
        <div class="mb-6">
            <div id="qr-reader" class="w-full max-w-md mx-auto"></div>
            
            @if (!$isScanning)
                <div class="text-center mt-4">
                    <flux:button wire:click="startScanning" variant="primary" size="sm" icon="camera">
                        Mulai Scan
                    </flux:button>
                </div>
            @else
                <div class="text-center mt-4">
                    <flux:button wire:click="stopScanning" size="sm" icon="stop">
                        Stop Scan
                    </flux:button>
                </div>
            @endif
        </div>

        <!-- Manual QR Code Input -->
        <div class="border-t border-slate-200 dark:border-slate-700 pt-6">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Atau Masukkan QR Code Manual</h3>
            
            <div class="space-y-4">
                <div>
                    <flux:input 
                        wire:model="scannedQrCode" 
                        placeholder="Masukkan QR code user..." 
                        class="w-full" 
                    />
                    @error('scannedQrCode') 
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>
                
                <div class="flex gap-2">
                    <flux:button wire:click="validateQrCode" variant="primary" size="sm" icon="check">
                        Validasi QR Code
                    </flux:button>
                    <flux:button wire:click="clearForm" size="sm" icon="x-mark">
                        Reset
                    </flux:button>
                </div>
            </div>
        </div>

        <!-- Validation Result -->
        @if ($validationResult)
            <div class="mt-6 p-4 rounded-xl border
                @if ($validationResult['valid']) 
                    bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800
                @else 
                    bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800
                @endif">
                
                @if ($validationResult['valid'])
                    <div class="flex items-start space-x-3">
                        <flux:icon.check-circle class="w-5 h-5 text-green-600 dark:text-green-400 mt-0.5" />
                        <div class="flex-1">
                            <h4 class="font-semibold text-green-800 dark:text-green-200">QR Code Valid</h4>
                            <p class="text-green-700 dark:text-green-300 text-sm mt-1">{{ $validationResult['message'] }}</p>
                            
                            @if (isset($validationResult['user']))
                                <div class="mt-3 p-3 bg-white/50 dark:bg-slate-800/50 rounded-lg">
                                    <h5 class="font-medium text-slate-800 dark:text-slate-200">Informasi User:</h5>
                                    <div class="mt-2 space-y-1 text-sm">
                                        <p><span class="font-medium">Nama:</span> {{ $validationResult['user']['name'] }}</p>
                                        <p><span class="font-medium">Email:</span> {{ $validationResult['user']['email'] }}</p>
                                        <p><span class="font-medium">Role:</span> {{ $validationResult['user']['role'] }}</p>
                                    </div>
                                </div>
                                
                                 <div class="mt-4">
                                     <div class="flex items-center space-x-2 text-green-600 dark:text-green-400 animate-pulse">
                                         <flux:icon.check-circle class="w-5 h-5" />
                                         <span class="font-medium">User berhasil bergabung!</span>
                                     </div>
                                     <p class="text-sm text-green-600 dark:text-green-400 mt-2">
                                         Siap untuk scan QR code berikutnya...
                                     </p>
                                 </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="flex items-start space-x-3">
                        <flux:icon.exclamation-triangle class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5" />
                        <div class="flex-1">
                            <h4 class="font-semibold text-red-800 dark:text-red-200">QR Code Tidak Valid</h4>
                            <p class="text-red-700 dark:text-red-300 text-sm mt-1">{{ $validationResult['message'] }}</p>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Scan History -->
    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Riwayat Scan</h3>
            <flux:button wire:click="toggleHistory" size="sm" icon="clock">
                {{ $showHistory ? 'Sembunyikan' : 'Tampilkan' }} Riwayat
            </flux:button>
        </div>

        @if ($showHistory)
            @if (count($scanHistory) > 0)
                <div class="space-y-2 max-h-64 overflow-y-auto">
                    @foreach ($scanHistory as $scan)
                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                @if ($scan['valid'])
                                    <flux:icon.check-circle class="w-4 h-4 text-green-600 dark:text-green-400" />
                                @else
                                    <flux:icon.x-circle class="w-4 h-4 text-red-600 dark:text-red-400" />
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $scan['user_name'] }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $scan['timestamp'] }}</p>
                                </div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full
                                @if ($scan['valid']) bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 @endif">
                                {{ $scan['valid'] ? 'Valid' : 'Invalid' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <flux:icon.clock class="w-12 h-12 text-slate-400 mx-auto mb-3" />
                    <p class="text-slate-500 dark:text-slate-400">Belum ada riwayat scan</p>
                </div>
            @endif
        @endif
    </div>
</div>

<!-- QR Scanner Script -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;
    let isScanning = false;

    document.addEventListener('livewire:init', () => {
        Livewire.on('start-camera', () => {
            startCamera();
        });

        Livewire.on('stop-camera', () => {
            stopCamera();
        });
        
        // Auto-start camera when page loads
        setTimeout(() => {
            startCamera();
        }, 1000);
    });

    async function startCamera() {
        try {
            // Check if camera is supported
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                throw new Error('Camera tidak didukung di browser ini');
            }

            // Check camera permissions
            const permissionStatus = await navigator.permissions.query({ name: 'camera' });
            if (permissionStatus.state === 'denied') {
                throw new Error('Izin kamera ditolak. Silakan aktifkan izin kamera di pengaturan browser.');
            }

            // Clear existing scanner
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }

            // Create new scanner
            html5QrcodeScanner = new Html5Qrcode("qr-reader");

            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            };

            // Start camera with proper error handling
            await html5QrcodeScanner.start(
                { facingMode: "environment" },
                config,
                (decodedText, decodedResult) => {
                    console.log('QR Code detected:', decodedText);
                    @this.call('onQrScanned', decodedText);
                    // Don't stop scanner, keep it running for next scan
                },
                (errorMessage) => {
                    // Ignore scan errors, keep scanning
                    console.log('QR scan error:', errorMessage);
                }
            );

            isScanning = true;

        } catch (err) {
            console.error('Camera error:', err);
            alert('Tidak dapat mengakses kamera: ' + err.message);
        }
    }

    function stopCamera() {
        isScanning = false;
        if (html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                html5QrcodeScanner.clear();
                html5QrcodeScanner = null;
            }).catch((err) => {
                console.log('Error stopping scanner:', err);
            });
        }
    }

    // Clean up on page unload
    window.addEventListener('beforeunload', () => {
        stopCamera();
    });

    // Handle page visibility change
    document.addEventListener('visibilitychange', () => {
        if (document.hidden && isScanning) {
            stopCamera();
        }
    });
</script>

