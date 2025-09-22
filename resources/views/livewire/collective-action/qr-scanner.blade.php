<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">QR Scanner - Aksi Kolektif</h1>
            <p class="text-gray-600 dark:text-gray-300">Scan QR code untuk bergabung dengan aksi kolektif</p>
        </div>

        <!-- QR Scanner Interface -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <div class="text-center">
                <!-- Manual Input -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Atau masukkan QR code secara manual:
                    </label>
                    <div class="flex space-x-2">
                        <input type="text" wire:model="scannedQrCode" wire:keydown.enter="processScannedQr"
                            placeholder="Paste QR code di sini..."
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        <button wire:click="processScannedQr"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Scan
                        </button>
                    </div>
                </div>

                <!-- Camera Scanner -->
                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8">
                    @if (!$isScanning)
                        <div class="text-center">
                            <div class="text-gray-400 dark:text-gray-500 text-4xl mb-4">📷</div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Gunakan kamera untuk scan QR code
                            </p>
                            <button wire:click="startScanning"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
                                Buka Kamera
                            </button>
                        </div>
                    @else
                        <div class="text-center">
                            <div id="qr-reader" class="w-full"></div>
                            <button wire:click="stopScanning"
                                class="mt-4 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                                Tutup Kamera
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Messages -->
        @if($errorMessage)
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400 dark:text-red-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Error</h3>
                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                            <p>{{ $errorMessage }}</p>
                        </div>
                    </div>
                    <div class="ml-auto pl-3">
                        <button wire:click="clearMessages" class="text-red-400 dark:text-red-300 hover:text-red-600 dark:hover:text-red-400">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if($successMessage)
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400 dark:text-green-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800 dark:text-green-200">Berhasil</h3>
                        <div class="mt-2 text-sm text-green-700 dark:text-green-300">
                            <p>{{ $successMessage }}</p>
                        </div>
                    </div>
                    <div class="ml-auto pl-3">
                        <button wire:click="clearMessages" class="text-green-400 dark:text-green-300 hover:text-green-600 dark:hover:text-green-400">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Instructions -->
        <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-4">Cara Menggunakan QR Scanner</h3>
            <div class="space-y-3 text-sm text-blue-800 dark:text-blue-200">
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded-full flex items-center justify-center text-xs font-semibold mr-3 mt-0.5">1</span>
                    <p>Izinkan akses kamera saat diminta oleh browser</p>
                </div>
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded-full flex items-center justify-center text-xs font-semibold mr-3 mt-0.5">2</span>
                    <p>Posisikan QR code dalam area scanner yang ditampilkan</p>
                </div>
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded-full flex items-center justify-center text-xs font-semibold mr-3 mt-0.5">3</span>
                    <p>QR code akan otomatis ter-scan dan mengarahkan ke form bergabung</p>
                </div>
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded-full flex items-center justify-center text-xs font-semibold mr-3 mt-0.5">4</span>
                    <p>Atau masukkan URL QR code secara manual di kolom input</p>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-8">
            <a href="{{ route('collective-action.browse') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-700 dark:hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Aksi Kolektif
            </a>
        </div>
    </div>
</div>

@push('scripts')
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
                        stopCamera();
                        Livewire.dispatch('qr-scanned', { qrCode: decodedText });
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

        // Cleanup on page unload
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
@endpush
