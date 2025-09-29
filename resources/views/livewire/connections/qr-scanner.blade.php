<div class="w-full overflow-x-hidden">
    <div class="container mx-auto px-4 py-6 sm:py-8 w-full">
        <div class="max-w-4xl mx-auto w-full">
            {{-- Header --}}
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Koneksi QR</h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Scan QR code untuk terhubung dengan user
                    lain</p>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Refresh jika kamera tidak muncul</p>
            </div>

            {{-- Status Messages --}}
            @if ($errorMessage)
                <div
                    class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 sm:mb-6 text-sm sm:text-base">
                    {!! $errorMessage !!}
                </div>
            @endif

            @if ($successMessage)
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 sm:mb-6 text-sm sm:text-base">
                    {!! $successMessage !!}
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
                                <div
                                    class="bg-white p-1 sm:p-4 rounded-lg border-2 border-gray-200 max-w-52 sm:max-w-none">
                                    <div
                                        class="w-48 h-48 sm:w-48 sm:h-48 mx-auto overflow-hidden flex items-center justify-center">
                                        {!! $myQrSvg !!}
                                    </div>
                                </div>
                            </div>
                            <p
                                class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-3 sm:mb-4 break-all px-2 text-center">
                                {{ $myQrCode }}
                            </p>
                        @endif

                        @if ($connectionStatus === 'idle')
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-3 sm:mb-4">
                                Tunjukkan QR ini kepada user lain untuk di-scan
                            </p>
                        @elseif($connectionStatus === 'waiting_for_response')
                            <p class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 mb-3 sm:mb-4">
                                Tunjukkan QR ini kepada <strong>{{ $targetUser->name ?? 'user' }}</strong> untuk
                                menyelesaikan
                                koneksi
                            </p>
                            <div
                                class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-3 sm:mb-4">
                                <p class="text-xs sm:text-sm text-blue-700 dark:text-blue-300">
                                    <span
                                        class="inline-block w-2 h-2 bg-blue-500 rounded-full animate-pulse mr-2"></span>
                                    Menunggu konfirmasi dari {{ $targetUser->name ?? 'user' }}...
                                </p>
                            </div>
                            <div
                                class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3 mb-3 sm:mb-4">
                                <p class="text-xs sm:text-sm text-yellow-700 dark:text-yellow-300">
                                    <span class="inline-block w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                    <strong>Tips:</strong> Jika QR code tidak terbaca, tekan tombol "Buat QR Baru" untuk
                                    membuat QR baru.
                                </p>
                            </div>
                        @else
                            <p class="text-xs sm:text-sm text-green-600 dark:text-green-400 mb-3 sm:mb-4">
                                {!! $successMessage !!}
                            </p>
                            <div
                                class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-3 sm:mb-4">
                                <p class="text-xs sm:text-sm text-blue-700 dark:text-blue-300">
                                    <span
                                        class="inline-block w-2 h-2 bg-blue-500 rounded-full animate-pulse mr-2"></span>
                                    Koneksi berhasil! Anda dapat membuat koneksi baru dengan menekan tombol "Buat QR
                                    Baru".
                                </p>
                            </div>
                        @endif

                        <div class="space-y-2 w-full">
                            @if ($connectionStatus === 'idle')
                                <button wire:click="refreshQr"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 sm:py-2 rounded-lg transition-colors text-xs sm:text-sm font-medium">
                                    Buat QR Baru
                                </button>
                            @elseif($connectionStatus === 'waiting_for_response')
                                <button wire:click="refreshQr"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 sm:py-2 rounded-lg transition-colors text-xs sm:text-sm font-medium">
                                    Buat QR Baru
                                </button>
                                <button wire:click="resetConnection"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 sm:py-2 rounded-lg transition-colors text-xs sm:text-sm font-medium">
                                    Hentikan Koneksi
                                </button>
                            @elseif($connectionStatus === 'connected')
                                <button wire:click="refreshQr"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 sm:py-2 rounded-lg transition-colors text-xs sm:text-sm font-medium">
                                    Buat QR Baru
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

                        {{-- @if ($connectionStatus === 'connected')
                            <div class="text-center py-6 sm:py-8">
                                <div class="text-green-600 text-4xl sm:text-6xl mb-3 sm:mb-4">✓</div>
                                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400">
                                    Koneksi berhasil!
                                </p>
                            </div>
                            <div class="space-y-3 sm:space-y-4 w-full hidden">
                        @else --}}
                        <div class="space-y-3 sm:space-y-4 w-full">
                            {{-- Manual Input --}}
                            <div>
                                <label
                                    class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Atau masukkan QR code secara manual:
                                </label>
                                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full">
                                    <input type="text" wire:model="scannedQrCode"
                                        wire:keydown.enter="processScannedQr" placeholder="Paste QR code di sini..."
                                        class="flex-1 px-3 py-2.5 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-sm sm:text-base min-w-0">
                                    <button wire:click="processScannedQr"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 sm:py-2 rounded-lg transition-colors text-sm sm:text-base font-medium whitespace-nowrap">
                                        Scan
                                    </button>
                                </div>
                            </div>

                            {{-- Camera Scanner --}}
                            <div
                                class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 lg:p-8 w-full overflow-hidden">
                                {{-- <div wire:ignore id="openCam" class="text-center w-full">
                                        <div class="text-gray-400 text-3xl sm:text-4xl mb-3 sm:mb-4">📷</div>
                                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-3 sm:mb-4">
                                            Gunakan kamera untuk scan QR code
                                        </p>
                                        <button wire:click="startScanning"
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 sm:px-6 py-2.5 sm:py-2 rounded-lg transition-colors text-sm sm:text-base font-medium">
                                            Buka Kamera
                                        </button>
                                    </div> --}}
                                <div wire:ignore id="closeCam" class="text-center w-full">
                                    <div wire:ignore id="qr-reader" class="w-full max-w-sm mx-auto overflow-hidden">
                                    </div>
                                    {{-- <button wire:click="stopScanning"
                                            class="mt-3 sm:mt-4 bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 sm:py-2 rounded-lg transition-colors text-sm sm:text-base font-medium">
                                            Tutup Kamera
                                        </button> --}}
                                </div>
                            </div>
                        </div>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>

            {{-- Instructions --}}
            <div
                class="mt-6 sm:mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 sm:p-6 w-full overflow-hidden">
                <h3 class="text-sm sm:text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2 sm:mb-3">Cara
                    Menggunakan:</h3>
                <ol
                    class="list-decimal list-inside space-y-1.5 sm:space-y-2 text-xs sm:text-sm text-blue-800 dark:text-blue-200">
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
    <!-- QR Scanner Script -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        let html5QrcodeScanner = null;
        let isScanning = false;
        let pusher = null;
        let connectionChannel = null;
        let autoIdleTimeout = null;

        // Initialize Pusher for real-time connection notifications
        function initializePusher() {
            try {
                if (typeof Pusher !== 'undefined' && '{{ config('broadcasting.default') }}' === 'pusher') {
                    pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                        encrypted: true,
                        authEndpoint: '/broadcasting/auth',
                        auth: {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }
                    });

                    // Subscribe to user's private channel
                    const userId = {{ auth()->id() }};
                    connectionChannel = pusher.subscribe('private-user.' + userId);

                    // Listen for connection success events
                    connectionChannel.bind('connection.success', function(data) {
                        console.log('Connection success received:', data);

                        // Show success notification
                        showConnectionSuccessNotification(data);

                        // Auto-reset to idle after 5 seconds
                        scheduleAutoIdle();
                    });

                    console.log('Pusher initialized for connection notifications');
                } else {
                    console.log('Pusher not available, using polling fallback');
                }
            } catch (error) {
                console.error('Pusher initialization failed:', error);
            }
        }

        // Show connection success notification
        function showConnectionSuccessNotification(data) {
            // Update Livewire component state
            @this.set('connectionStatus', 'connected');
            @this.set('successMessage', data.message);
            @this.set('targetUser', {
                name: data.user2.name
            });

            // Show browser notification if permission granted
            if (Notification.permission === 'granted') {
                new Notification('Koneksi Berhasil!', {
                    body: data.message,
                    icon: '/favicon.ico'
                });
            }
        }

        // Schedule auto-idle after 5 seconds
        function scheduleAutoIdle() {
            // Clear any existing timeout
            if (autoIdleTimeout) {
                clearTimeout(autoIdleTimeout);
            }

            // Set new timeout for 5 seconds
            autoIdleTimeout = setTimeout(() => {
                console.log('Auto-resetting to idle state');
                @this.call('resetConnection');
            }, 5000);
        }

        // Request notification permission
        function requestNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission().then(function(permission) {
                    console.log('Notification permission:', permission);
                });
            }
        }

        function startConnectionPolling() {
            // kalau sudah ada polling jalan, hentikan dulu
            if (window.connectionPollingInterval) {
                clearInterval(window.connectionPollingInterval);
            }

            // jalankan polling tiap 3 detik
            window.connectionPollingInterval = setInterval(() => {
                console.log('Polling for connection status...');
                Livewire.dispatch('check-connection');
            }, 3000);

            console.log('✅ Polling started...');
        }

        // Tangkap event dari backend kalau sudah connected
        Livewire.on('connected', () => {
            console.log('🎉 Koneksi berhasil!');

            // stop polling setelah sukses
            if (window.connectionPollingInterval) {
                clearInterval(window.connectionPollingInterval);
                window.connectionPollingInterval = null;
            }

            // tampilkan notifikasi browser
            if (Notification.permission === 'granted') {
                new Notification('Koneksi Berhasil!', {
                    body: 'Anda sudah terhubung.',
                    icon: '/favicon.ico'
                });
            }
        });

        Livewire.on('start-connection-polling', () => {
            startConnectionPolling();
        });

        document.addEventListener('livewire:navigated', () => {
            // Initialize Pusher
            initializePusher();

            // Request notification permission
            requestNotificationPermission();
            // Livewire.on('start-camera', () => {
            //     startCamera();
            // });

            // Livewire.on('stop-camera', () => {
            //     stopCamera();
            // });

            // Auto-start camera when page loads
            setTimeout(() => {
                console.log('Auto-starting camera...');
                startCamera();
            }, 1000);
        });

        document.addEventListener("livewire:load", () => { // Initialize Pusher
            initializePusher();

            // Request notification permission
            requestNotificationPermission();
            // Livewire.on('start-camera', () => {
            //     startCamera();
            // });

            // Livewire.on('stop-camera', () => {
            //     stopCamera();
            // });

            // Auto-start camera when page loads
            setTimeout(() => {
                console.log('Auto-starting camera...');
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
                const permissionStatus = await navigator.permissions.query({
                    name: 'camera'
                });
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
                    qrbox: {
                        width: 250,
                        height: 250
                    },
                    aspectRatio: 1.0
                };

                // Start camera with proper error handling
                await html5QrcodeScanner.start({
                        facingMode: "environment"
                    },
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
                // alert('Tidak dapat mengakses kamera: ' + err.message);
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
            // Clear all intervals
            if (window.connectionPollingInterval) {
                clearInterval(window.connectionPollingInterval);
            }
            if (window.qrRefreshInterval) {
                clearInterval(window.qrRefreshInterval);
            }
            // Clear auto-idle timeout
            if (autoIdleTimeout) {
                clearTimeout(autoIdleTimeout);
            }
            // Disconnect Pusher
            if (pusher) {
                pusher.disconnect();
            }
        });

        // Handle page visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.hidden && isScanning) {
                stopCamera();
            }

            if (!document.hidden) {
                startCamera();
            }
        });

        Livewire.on("change-tab", (data) => {
            if (data.tab === 'qr-scan') {
                startCamera();
            } else {
                stopCamera();
            }
        });

        document.addEventListener('livewire:navigating', () => {
            stopCamera();
            // Clear all intervals
            if (window.connectionPollingInterval) {
                clearInterval(window.connectionPollingInterval);
            }
            if (window.qrRefreshInterval) {
                clearInterval(window.qrRefreshInterval);
            }
        });

        // Handle stop connection polling event
        Livewire.on('stop-connection-polling', () => {
            // Stop any ongoing polling or timers
            if (window.connectionPollingInterval) {
                clearInterval(window.connectionPollingInterval);
                window.connectionPollingInterval = null;
            }
        });

        // Handle start connection polling event
        Livewire.on('start-connection-polling', (data) => {
            // Stop any existing polling
            if (window.connectionPollingInterval) {
                clearInterval(window.connectionPollingInterval);
            }

            // Start new polling
            window.connectionPollingInterval = setInterval(() => {
                @this.call('checkConnectionStatus', data);
            }, 2000); // Check every 2 seconds
        });

        // Handle connection completed event
        Livewire.on('connection-completed', () => {
            // Stop polling when connection is completed
            if (window.connectionPollingInterval) {
                clearInterval(window.connectionPollingInterval);
                window.connectionPollingInterval = null;
            }
        });

        // Handle schedule auto-idle event
        Livewire.on('schedule-auto-idle', () => {
            console.log('Scheduling auto-idle...');
            scheduleAutoIdle();
        });

        // Handle start QR refresh event
        Livewire.on('start-qr-refresh', () => {
            // Auto-refresh QR codes every 50 seconds (before 1 minute expiry)
            if (window.qrRefreshInterval) {
                clearInterval(window.qrRefreshInterval);
            }

            window.qrRefreshInterval = setInterval(() => {
                console.log('refresh Qr')
                @this.call('refreshQr');
            }, 4.5 * 60 * 1000); // Refresh every 5 minutes
        });

        Livewire.on('reset-interval-qr-refresh', () => {
            // Reset QR refresh interval
            if (window.qrRefreshInterval) {
                clearInterval(window.qrRefreshInterval);
            }

            window.qrRefreshInterval = setInterval(() => {
                console.log('refresh Qr')
                @this.call('refreshQr');
            }, 4.5 * 60 * 1000); // Refresh every 5 minutes
        });

        // Clean up intervals when component is destroyed
        document.addEventListener('livewire:destroyed', () => {
            if (window.connectionPollingInterval) {
                clearInterval(window.connectionPollingInterval);
            }
            if (window.qrRefreshInterval) {
                clearInterval(window.qrRefreshInterval);
            }
            // Clear auto-idle timeout
            if (autoIdleTimeout) {
                clearTimeout(autoIdleTimeout);
            }
            // Disconnect Pusher
            if (pusher) {
                pusher.disconnect();
            }
        });

        // Clean up intervals when component is updated
        document.addEventListener('livewire:updated', () => {
            // Re-initialize QR refresh if needed
            if (!window.qrRefreshInterval) {
                @this.call('refreshQr');
            }
        });

        // Nonaktifkan alert/confirmation reload Livewire saat 419
        Livewire.hook('message.failed', (message, component, response) => {
            if (response.status === 419) {
                console.warn('CSRF expired detected, suppressing Livewire default alert');

                // Opsional: refresh token otomatis di background
                // refreshCsrfToken(); 

                return false; // <== penting, mencegah Livewire default alert/confirmation
            }
        });
    </script>
@endpush
