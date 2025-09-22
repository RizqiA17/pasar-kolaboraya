<div>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2">Scan QR Code Ekosistem</h1>
                <p class="text-gray-600 dark:text-slate-300">Scan QR code untuk bergabung dengan ekosistem</p>
            </div>

            <!-- Scanner Section -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8 border border-gray-200 dark:border-slate-700">
                <!-- Manual Input -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Atau masukkan QR code secara manual:
                    </label>
                    <div class="flex space-x-2">
                        <input type="text" wire:model="scannedQrCode" wire:keydown.enter="processScannedQr"
                            placeholder="Paste QR code di sini..."
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white">
                        <button wire:click="processScannedQr"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Scan
                        </button>
                    </div>
                </div>

                <!-- Camera Scanner -->
                <div class="border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg p-8">
                    @if (!$isScanning)
                        <div class="text-center">
                            <div class="text-gray-400 text-4xl mb-4">📷</div>
                            <p class="text-gray-600 dark:text-slate-400 mb-4">
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

                <!-- Messages -->
                @if($errorMessage)
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-800 dark:text-red-200">{{ $errorMessage }}</p>
                            </div>
                            <div class="ml-auto pl-3">
                                <button wire:click="clearMessages" class="text-red-400 hover:text-red-600 dark:text-red-300 dark:hover:text-red-400">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if($successMessage)
                    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-800 dark:text-green-200">{{ $successMessage }}</p>
                            </div>
                            <div class="ml-auto pl-3">
                                <button wire:click="clearMessages" class="text-green-400 hover:text-green-600 dark:text-green-300 dark:hover:text-green-400">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Manual QR Input -->
                <div class="border-t border-gray-200 dark:border-slate-600 pt-6">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-slate-200 mb-3">Atau Masukkan URL QR Code Manual</h3>
                    <div class="flex gap-3">
                        <input type="text" 
                               wire:model="scannedQrCode"
                               placeholder="Paste URL QR code di sini..."
                               class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                        <button wire:click="processScannedQr" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                            Proses
                        </button>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800">
                <h3 class="font-semibold text-blue-900 dark:text-blue-200 mb-3">Cara Menggunakan Scanner:</h3>
                <ol class="list-decimal list-inside text-blue-800 dark:text-blue-300 space-y-2 text-sm">
                    <li>Klik tombol "Mulai Scanning" untuk mengaktifkan kamera</li>
                    <li>Arahkan kamera ke QR code ekosistem</li>
                    <li>QR code akan otomatis terdeteksi dan diproses</li>
                    <li>Anda akan diarahkan ke form bergabung ekosistem</li>
                    <li>Atau gunakan input manual jika QR code tidak dapat di-scan</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- QR Code Scanner JavaScript -->
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
</div>
