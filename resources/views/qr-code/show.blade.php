<x-layouts.app :title="__('Dashboard')">
    <div class="container mx-auto px-4 py-6 sm:py-8 w-full overflow-x-hidden">
        <div class="max-w-2xl mx-auto w-full">
            <!-- Header -->
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">QR Code Saya</h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">Tunjukkan QR code ini kepada admin untuk
                    masuk ke Pasar Kolaboraya</p>
            </div>

            <!-- QR Code Display -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 sm:p-6 lg:p-8 text-center w-full overflow-hidden">
                <!-- QR Code Display -->
                <div class="mb-4 sm:mb-6">
                    <div class="flex justify-center mb-3 sm:mb-4">
                        <div
                            class="bg-white p-1 sm:p-4 rounded-lg border-2 border-gray-200 dark:border-gray-600 max-w-52 sm:max-w-none">
                            <div
                                class="w-48 h-48 sm:w-48 sm:h-48 mx-auto overflow-hidden flex items-center justify-center">
                                {!! $qrCodeSvg !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Info -->
                <div class="mb-4 sm:mb-6">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        {{ $qrCodeData['user_name'] }}</h2>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">{{ $qrCodeData['user_email'] }}</p>
                </div>

                <!-- QR Code Info -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6 w-full overflow-hidden">
                    <div class="grid grid-cols-1 gap-3 sm:gap-4 text-xs sm:text-sm">
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">QR Code:</span>
                            <p id="qr-code-text"
                                class="text-gray-600 dark:text-gray-400 font-mono text-xs break-all px-2">
                                {{ $qrCodeData['qr_code'] }}</p>
                        </div>
                        {{-- <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Dibuat:</span>
                        <p id="qr-generated-date" class="text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($qrCodeData['generated_at'])->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Berlaku hingga:</span>
                        <p id="qr-expires-date" class="text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($qrCodeData['expires_at'])->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                            Aktif
                        </span>
                    </div> --}}
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-center w-full">
                    <button onclick="downloadQR()"
                        class="bg-blue-600 text-white px-4 sm:px-6 py-2.5 sm:py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs sm:text-sm font-medium">
                        📥 Download QR Code
                    </button>
                    {{-- <button onclick="printQR()"
                        class="bg-gray-600 text-white px-4 sm:px-6 py-2.5 sm:py-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 text-xs sm:text-sm font-medium">
                        🖨️ Print QR Code
                    </button> --}}
                    {{-- <button 
                    onclick="regenerateQR()"
                    class="bg-orange-600 text-white px-4 sm:px-6 py-2.5 sm:py-2 rounded-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 text-xs sm:text-sm font-medium"
                >
                    🔄 Generate Ulang
                </button> --}}
                </div>
            </div>

            <!-- Instructions -->
            <div
                class="mt-6 sm:mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 sm:p-6 w-full overflow-hidden">
                <h3 class="text-sm sm:text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2 sm:mb-3">Cara
                    Menggunakan QR Code</h3>
                <ol
                    class="list-decimal list-inside space-y-1.5 sm:space-y-2 text-xs sm:text-sm text-blue-800 dark:text-blue-200">
                    <li>Tunjukkan QR code ini kepada admin Pasar Kolaboraya</li>
                    <li>Admin akan scan QR code menggunakan aplikasi scanner</li>
                    <li>Setelah QR code divalidasi, Anda akan mendapat akses ke Pasar Kolaboraya</li>
                    {{-- <li>QR code berlaku selama 30 hari dari tanggal pembuatan</li> --}}
                    {{-- <li>Jika QR code expired, klik "Generate Ulang" untuk membuat yang baru</li> --}}
                </ol>
            </div>

            <!-- Security Notice -->
            <div
                class="mt-4 sm:mt-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3 sm:p-4 w-full overflow-hidden">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-yellow-400 dark:text-yellow-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-xs sm:text-sm font-medium text-yellow-800 dark:text-yellow-200">Peringatan
                            Keamanan</h3>
                        <div class="mt-1 sm:mt-2 text-xs sm:text-sm text-yellow-700 dark:text-yellow-300">
                            <p>Jangan bagikan QR code ini kepada orang lain. QR code ini adalah kunci akses pribadi Anda
                                ke Pasar Kolaboraya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // ==========================
        // Pusher Initialization (with fallback to polling)
        // ==========================
        let pusher = null;
        let channel = null;
        let pollingInterval = null;

        const userId = {{ auth()->id() }};

        try {
            const pusherKey = '{{ config('broadcasting.connections.pusher.key') }}';
            const pusherCluster = '{{ config('broadcasting.connections.pusher.options.cluster') }}';

            if (pusherKey && pusherCluster) {
                pusher = new Pusher(pusherKey, {
                    cluster: pusherCluster,
                    encrypted: true,
                    authEndpoint: '{{ route('broadcasting.auth') }}',
                    auth: {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    }
                });

                // Subscribe private channel
                channel = pusher.subscribe('private-user.' + userId);
                console.log('Pusher initialized successfully');
            } else {
                console.log('Pusher not configured, using polling fallback');
                startPolling();
            }
        } catch (error) {
            console.error('Pusher initialization failed:', error);
            startPolling();
        }

        // ==========================
        // Handle QR Scan Success
        // ==========================
        function handleQrScanSuccess(data) {
            console.log('QR Code successfully scanned by admin:', data);

            // Success notification
            const successDiv = document.createElement('div');
            successDiv.className =
                'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 max-w-md';
            successDiv.innerHTML = `
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" 
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 
                       7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 
                       001.414 0l4-4z" clip-rule="evenodd">
                </path>
            </svg>
            <div>
                <p class="font-semibold">Berhasil bergabung!</p>
                <p class="text-sm">Anda telah bergabung ke ${data.pasar_kolaboraya_name}</p>
            </div>
        </div>
    `;
            document.body.appendChild(successDiv);

            // Set active pasar
            setActivePasar(data.pasar_kolaboraya_id);

            // Auto-remove notification
            setTimeout(() => {
                if (successDiv.parentNode) successDiv.parentNode.removeChild(successDiv);
            }, 8000);
        }

        // ==========================
        // Pusher Event Listeners
        // ==========================
        if (channel) {
            channel.bind('qr-scanned-successfully', handleQrScanSuccess);

            pusher.connection.bind('connected', () => {
                console.log('Pusher connected successfully');
            });

            pusher.connection.bind('disconnected', () => {
                console.log('Pusher disconnected, fallback to polling');
                startPolling();
            });

            pusher.connection.bind('error', (err) => {
                console.error('Pusher connection error:', err);
                startPolling();
            });
        }

        // ==========================
        // Polling Fallback
        // ==========================
        function startPolling() {
            if (pollingInterval) return; // prevent duplicate

            console.log('Starting polling for QR scan status...');

            pollingInterval = setInterval(async () => {
                try {
                    const response = await fetch('{{ route("qr.status") }}', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    });

                    if (!response.ok) {
                        console.error('Failed to check QR status:', response.status);
                        return;
                    }

                    const data = await response.json();
                    if (data.success) {
                        console.log('User added via polling:', data);
                        stopPolling();
                        handleQrScanSuccess({
                            pasar_kolaboraya_name: data.pasar_kolaboraya_name || 'Pasar Kolaboraya',
                            pasar_kolaboraya_id: data.pasar_kolaboraya_id,
                        });
                    }
                } catch (error) {
                    console.error('Error checking QR status:', error);
                }
            }, 3000);
        }

        function stopPolling() {
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
                console.log('Stopped polling');
            }
        }

        // ==========================
        // Set Active Pasar
        // ==========================
        async function setActivePasar(pasarId) {
            try {
                const response = await fetch('{{ route('set.pasar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        pasar: pasarId
                    })
                });

                if (!response.ok) {
                    console.error('Failed to set active pasar:', response.status);
                    return;
                }

                const data = await response.json();
                if (data.success) console.log('Masuk ke pasar');
                if (data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 3000); // redirect setelah 3 detik
                }

            } catch (error) {
                console.error('Error setting active pasar:', error);
            }
        }

        // ==========================
        // Cleanup
        // ==========================
        if (!pusher || !channel) startPolling();

        window.addEventListener('beforeunload', () => {
            stopPolling();
            if (pusher) pusher.disconnect();
        });

        // ==========================
        // Download QR Code
        // ==========================
        function downloadQR() {
            const qrSvg = `{!! $qrCodeSvg !!}`;
            const svgBlob = new Blob([qrSvg], {
                type: 'image/svg+xml;charset=utf-8'
            });
            const url = URL.createObjectURL(svgBlob);
            const img = new Image();

            img.onload = function() {
                const width = img.width || 300;
                const height = img.height || 300;

                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob(function(blob) {
                    const a = document.createElement('a');
                    a.href = URL.createObjectURL(blob);
                    a.download = 'qr-code-pasar-kolaboraya.jpg';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }, 'image/jpeg', 1.0);

                URL.revokeObjectURL(url);
            };

            img.crossOrigin = 'anonymous';
            img.src = url;
        }

        // ==========================
        // Print QR Code
        // ==========================
        function printQR() {
            const qrCodeData = @json($qrCodeData);
            const qrSvg = @json($qrCodeSvg);

            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>QR Code - Pasar Kolaboraya</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
                .qr-container { margin: 20px 0; }
                .user-info { margin: 20px 0; }
                .qr-info { background: #f5f5f5; padding: 15px; border-radius: 8px; margin: 20px 0; }
            </style>
        </head>
        <body>
            <h1>QR Code Pasar Kolaboraya</h1>
            <div class="qr-container">${qrSvg}</div>
            <div class="user-info">
                <h2>${qrCodeData.user_name}</h2>
                <p>${qrCodeData.user_email}</p>
            </div>
            <div class="qr-info">
                <p><strong>QR Code:</strong> ${qrCodeData.qr_code}</p>
            </div>
        </body>
        </html>
    `);
            printWindow.document.close();
            printWindow.print();
        }

        // ==========================
        // Regenerate QR Code
        // ==========================
        function regenerateQR(event) {
            if (!confirm('Apakah Anda yakin ingin membuat QR code baru? QR code lama akan tidak berlaku lagi.')) return;

            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '🔄 Generating...';
            button.disabled = true;

            const qrContainer = document.querySelector('#qr-code-container');
            if (qrContainer) {
                qrContainer.innerHTML = `
            <div class="flex items-center justify-center h-full">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600"></div>
            </div>`;
            }

            fetch('{{ route('qr.generate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.qr_code) {
                        updateQRCodeDisplay(data);

                        const successDiv = document.createElement('div');
                        successDiv.className =
                            'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                        successDiv.textContent = 'QR code berhasil di-generate ulang!';
                        document.body.appendChild(successDiv);

                        setTimeout(() => successDiv.remove(), 3000);
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan saat membuat QR code baru');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    const errorDiv = document.createElement('div');
                    errorDiv.className =
                        'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    errorDiv.textContent = 'Error: ' + error.message;
                    document.body.appendChild(errorDiv);

                    setTimeout(() => errorDiv.remove(), 5000);
                    if (qrContainer) qrContainer.innerHTML = @json($qrCodeSvg);
                })
                .finally(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
        }

        // ==========================
        // Update QR Display
        // ==========================
        function updateQRCodeDisplay(data) {
            const qrContainer = document.querySelector('#qr-code-container');
            if (qrContainer) qrContainer.innerHTML = data.qr_code_svg;

            const qrCodeText = document.querySelector('#qr-code-text');
            if (qrCodeText) qrCodeText.textContent = data.qr_code;

            const generatedDate = document.querySelector('#qr-generated-date');
            if (generatedDate && data.generated_at) {
                generatedDate.textContent = new Date(data.generated_at).toLocaleString('id-ID');
            }

            const expiresDate = document.querySelector('#qr-expires-date');
            if (expiresDate && data.expires_at) {
                expiresDate.textContent = new Date(data.expires_at).toLocaleString('id-ID');
            }
        }

        window.downloadQR = downloadQR;
    </script>
</x-layouts.app>
