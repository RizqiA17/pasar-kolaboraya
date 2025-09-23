<div class="w-full overflow-x-hidden">
    <div class="container mx-auto px-4 py-6 sm:py-8 w-full">
        <div class="max-w-4xl mx-auto w-full">
            <!-- Header -->
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2">Scan QR Code Ekosistem</h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-slate-300">Scan QR code untuk bergabung dengan ekosistem</p>
            </div>

            <!-- Scanner Section -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-4 sm:p-6 lg:p-8 border border-gray-200 dark:border-slate-700 w-full overflow-hidden">
                <!-- Manual Input -->
                <div class="mb-4 sm:mb-6">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Atau masukkan QR code secara manual:
                    </label>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full">
                        <input type="text" wire:model="scannedQrCode" wire:keydown.enter="processScannedQr"
                            placeholder="Paste QR code di sini..."
                            class="flex-1 px-3 py-2.5 sm:py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white text-sm sm:text-base min-w-0">
                        <button wire:click="processScannedQr"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 sm:py-2 rounded-lg transition-colors text-sm sm:text-base font-medium whitespace-nowrap">
                            Scan
                        </button>
                    </div>
                </div>

                <!-- Camera Scanner -->
                <div class="border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg p-4 sm:p-6 lg:p-8 w-full overflow-hidden">
                    @if (!$isScanning)
                        <div class="text-center w-full">
                            <div class="text-gray-400 text-3xl sm:text-4xl mb-3 sm:mb-4">📷</div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-slate-400 mb-3 sm:mb-4">
                                Gunakan kamera untuk scan QR code
                            </p>
                            <button wire:click="startScanning"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 sm:px-6 py-2.5 sm:py-2 rounded-lg transition-colors text-sm sm:text-base font-medium">
                                Buka Kamera
                            </button>
                        </div>
                    @else
                        <div class="text-center w-full">
                            <div id="qr-reader" class="w-full max-w-sm mx-auto overflow-hidden"></div>
                            <button wire:click="stopScanning"
                                class="mt-3 sm:mt-4 bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 sm:py-2 rounded-lg transition-colors text-sm sm:text-base font-medium">
                                Tutup Kamera
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Messages -->
                @if($errorMessage)
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm sm:text-base">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-red-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-xs sm:text-sm text-red-800 dark:text-red-200">{{ $errorMessage }}</p>
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
                    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-sm sm:text-base">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-green-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-xs sm:text-sm text-green-800 dark:text-green-200">{{ $successMessage }}</p>
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
            </div>

            <!-- Instructions -->
            <div class="mt-6 sm:mt-8 bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 sm:p-6 border border-blue-200 dark:border-blue-800 w-full overflow-hidden">
                <h3 class="text-sm sm:text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2 sm:mb-3">Cara Menggunakan Scanner:</h3>
                <div class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm text-blue-800 dark:text-blue-200">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded-full flex items-center justify-center text-xs font-semibold mr-2 sm:mr-3 mt-0.5">1</span>
                        <p>Klik tombol "Buka Kamera" untuk mengaktifkan kamera</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded-full flex items-center justify-center text-xs font-semibold mr-2 sm:mr-3 mt-0.5">2</span>
                        <p>Arahkan kamera ke QR code ekosistem</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded-full flex items-center justify-center text-xs font-semibold mr-2 sm:mr-3 mt-0.5">3</span>
                        <p>QR code akan otomatis terdeteksi dan diproses</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded-full flex items-center justify-center text-xs font-semibold mr-2 sm:mr-3 mt-0.5">4</span>
                        <p>Anda akan diarahkan ke form bergabung ekosistem</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded-full flex items-center justify-center text-xs font-semibold mr-2 sm:mr-3 mt-0.5">5</span>
                        <p>Atau gunakan input manual jika QR code tidak dapat di-scan</p>
                    </div>
                </div>
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

        // Handle wire:navigate - reinitialize camera functionality after navigation
        document.addEventListener('livewire:navigated', () => {
            console.log('Livewire navigated - reinitializing ecosystem camera functionality');
            
            // Clean up any existing camera instances
            if (html5QrcodeScanner) {
                stopCamera();
            }
            
            // Reset scanning state
            isScanning = false;
            
            // Re-register Livewire event listeners after navigation
            if (typeof Livewire !== 'undefined') {
                Livewire.on('start-camera', () => {
                    startCamera();
                });

                Livewire.on('stop-camera', () => {
                    stopCamera();
                });
            }
        });

        // Additional fallback for wire:navigate - ensure camera works even if livewire:navigated doesn't fire
        document.addEventListener('DOMContentLoaded', () => {
            // Check if we're on the ecosystem QR scanner page and reinitialize if needed
            if (document.querySelector('#qr-reader')) {
                console.log('Ecosystem QR scanner page detected - ensuring camera functionality is ready');
                
                // Add a small delay to ensure Livewire is fully loaded
                setTimeout(() => {
                    if (typeof Livewire !== 'undefined') {
                        // Re-register event listeners as fallback
                        Livewire.on('start-camera', () => {
                            startCamera();
                        });

                        Livewire.on('stop-camera', () => {
                            stopCamera();
                        });
                    }
                }, 500);
            }
        });

        async function startCamera() {
            try {
                // Check if camera is supported
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    throw new Error('Camera tidak didukung di browser ini');
                }

                // Check camera permissions - but don't block if permission query fails
                try {
                    const permissionStatus = await navigator.permissions.query({ name: 'camera' });
                    if (permissionStatus.state === 'denied') {
                        throw new Error('Izin kamera ditolak. Silakan aktifkan izin kamera di pengaturan browser.');
                    }
                } catch (permissionError) {
                    console.log('Permission query failed, proceeding anyway:', permissionError);
                    // Continue anyway as some browsers don't support permission query
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
                // Show more specific error message
                if (err.name === 'NotAllowedError') {
                    alert('Izin kamera ditolak. Silakan klik "Allow" ketika browser meminta izin kamera, atau aktifkan izin kamera di pengaturan browser.');
                } else if (err.name === 'NotFoundError') {
                    alert('Kamera tidak ditemukan. Pastikan perangkat memiliki kamera yang berfungsi.');
                } else if (err.name === 'NotReadableError') {
                    alert('Kamera sedang digunakan oleh aplikasi lain. Tutup aplikasi lain yang menggunakan kamera dan coba lagi.');
                } else {
                    alert('Tidak dapat mengakses kamera: ' + err.message + '. Silakan refresh halaman dan coba lagi.');
                }
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
