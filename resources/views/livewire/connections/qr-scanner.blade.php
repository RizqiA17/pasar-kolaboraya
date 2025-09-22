<div class="w-full overflow-x-hidden">
    <div class="container mx-auto px-4 py-6 sm:py-8 w-full">
        <div class="max-w-4xl mx-auto w-full">
            {{-- Header --}}
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Koneksi QR</h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Scan QR code untuk terhubung dengan user lain</p>
            </div>

            {{-- Status Messages --}}
            @if ($errorMessage)
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 sm:mb-6 text-sm sm:text-base">
                    {{ $errorMessage }}
                </div>
            @endif

            @if ($successMessage)
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 sm:mb-6 text-sm sm:text-base">
                    {{ $successMessage }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 w-full">
                {{-- My QR Code Section --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 w-full overflow-hidden">
                    <div class="text-center w-full">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">
                            @if ($connectionStatus === 'idle')
                                QR Code Anda
                            @elseif($connectionStatus === 'waiting_for_response')
                                QR Response Anda
                            @else
                                Koneksi Berhasil!
                            @endif
                        </h2>

                        @if ($myQrSvg)
                            <div class="flex justify-center mb-3 sm:mb-4">
                                <div class="bg-white p-2 sm:p-4 rounded-lg border-2 border-gray-200 max-w-[200px] sm:max-w-none">
                                    <div class="w-32 h-32 sm:w-48 sm:h-48 mx-auto overflow-hidden flex items-center justify-center">
                                        {!! $myQrSvg !!}
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-3 sm:mb-4 break-all px-2 text-center">
                                {{ $myQrCode }}
                            </p>
                        @endif

                        @if ($connectionStatus === 'idle')
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-3 sm:mb-4">
                                Tunjukkan QR ini kepada user lain untuk di-scan
                            </p>
                        @elseif($connectionStatus === 'waiting_for_response')
                            <p class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 mb-3 sm:mb-4">
                                Tunjukkan QR ini kepada <strong>{{ $targetUser->name ?? 'user' }}</strong> untuk menyelesaikan
                                koneksi
                            </p>
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-3 sm:mb-4">
                                <p class="text-xs sm:text-sm text-blue-700 dark:text-blue-300">
                                    <span class="inline-block w-2 h-2 bg-blue-500 rounded-full animate-pulse mr-2"></span>
                                    Menunggu konfirmasi dari {{ $targetUser->name ?? 'user' }}...
                                </p>
                            </div>
                        @else
                            <p class="text-xs sm:text-sm text-green-600 dark:text-green-400 mb-3 sm:mb-4">
                                Anda berhasil terhubung dengan <strong>{{ $targetUser->name ?? 'user' }}</strong>!
                            </p>
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-3 sm:mb-4">
                                <p class="text-xs sm:text-sm text-blue-700 dark:text-blue-300">
                                    <span class="inline-block w-2 h-2 bg-blue-500 rounded-full animate-pulse mr-2"></span>
                                    Sistem akan otomatis reset dalam beberapa detik...
                                </p>
                            </div>
                        @endif

                        <div class="space-y-2 w-full">
                            <button wire:click="refreshQr"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 sm:py-2 rounded-lg transition-colors text-xs sm:text-sm font-medium">
                                Buat QR Baru
                            </button>

                            @if ($connectionStatus === 'waiting_for_response')
                                <button wire:click="resetConnection"
                                    class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2.5 sm:py-2 rounded-lg transition-colors text-xs sm:text-sm font-medium">
                                    Reset Koneksi
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Scanner Section --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 w-full overflow-hidden">
                    <div class="text-center w-full">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">
                            Scan QR Code
                        </h2>

                        @if ($connectionStatus === 'connected')
                            <div class="text-center py-6 sm:py-8">
                                <div class="text-green-600 text-4xl sm:text-6xl mb-3 sm:mb-4">✓</div>
                                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400">
                                    Koneksi berhasil!
                                </p>
                            </div>
                        @else
                            <div class="space-y-3 sm:space-y-4 w-full">
                                {{-- Manual Input --}}
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Atau masukkan QR code secara manual:
                                    </label>
                                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full">
                                        <input type="text" wire:model="scannedQrCode" wire:keydown.enter="processScannedQr"
                                            placeholder="Paste QR code di sini..."
                                            class="flex-1 px-3 py-2.5 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-sm sm:text-base min-w-0">
                                        <button wire:click="processScannedQr"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 sm:py-2 rounded-lg transition-colors text-sm sm:text-base font-medium whitespace-nowrap">
                                            Scan
                                        </button>
                                    </div>
                                </div>

                                {{-- Camera Scanner --}}
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 lg:p-8 w-full overflow-hidden">
                                    @if (!$isScanning)
                                        <div class="text-center w-full">
                                            <div class="text-gray-400 text-3xl sm:text-4xl mb-3 sm:mb-4">📷</div>
                                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-3 sm:mb-4">
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
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Instructions --}}
            <div class="mt-6 sm:mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 sm:p-6 w-full overflow-hidden">
                <h3 class="text-sm sm:text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2 sm:mb-3">Cara Menggunakan:</h3>
                <ol class="list-decimal list-inside space-y-1.5 sm:space-y-2 text-xs sm:text-sm text-blue-800 dark:text-blue-200">
                    <li>User A menampilkan QR code mereka</li>
                    <li>User B scan QR code User A</li>
                    <li>User B akan mendapat QR code baru untuk ditunjukkan kepada User A</li>
                    <li>User A scan QR code User B</li>
                    <li>Koneksi berhasil dibuat!</li>
                </ol>
                <p class="text-xs sm:text-sm text-blue-700 dark:text-blue-300 mt-2 sm:mt-3">
                    <strong>Catatan:</strong> QR code berlaku selama 1 menit dan akan otomatis diperbarui.
                </p>
            </div>
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

            Livewire.on('connection-completed', () => {
                setTimeout(() => {
                    Livewire.dispatch('resetConnection');
                }, 3000);
            });

            // Polling mechanism for auto-reset when both parties complete connection
            let connectionPollingInterval = null;

            Livewire.on('start-connection-polling', (data) => {
                if (connectionPollingInterval) {
                    clearInterval(connectionPollingInterval);
                }

                connectionPollingInterval = setInterval(() => {
                    Livewire.dispatch('check-connection-status', data);
                }, 2000); // Check every 2 seconds

                // Stop polling after 30 seconds to avoid infinite polling
                setTimeout(() => {
                    if (connectionPollingInterval) {
                        clearInterval(connectionPollingInterval);
                        connectionPollingInterval = null;
                    }
                }, 30000);
            });

            // Auto-refresh QR codes every 50 seconds (before 1-minute expiry)
            let qrRefreshInterval = null;

            Livewire.on('start-qr-refresh', () => {
                if (qrRefreshInterval) {
                    clearInterval(qrRefreshInterval);
                }

                qrRefreshInterval = setInterval(() => {
                    // Only refresh if we're in idle state
                    const component = document.querySelector('[wire\\:id]');
                    if (component) {
                        const wireId = component.getAttribute('wire:id');
                        const livewireComponent = Livewire.find(wireId);
                        if (livewireComponent && livewireComponent.connectionStatus === 'idle') {
                            livewireComponent.refreshQr();
                        }
                    }
                }, 50000); // 50 seconds
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
