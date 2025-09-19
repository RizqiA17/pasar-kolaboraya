<div class="max-w-4xl mx-auto p-6">
    {{-- Header --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Koneksi QR</h1>
        <p class="text-gray-600 dark:text-gray-400">Scan QR code untuk terhubung dengan user lain</p>
    </div>

    {{-- Status Messages --}}
    @if ($errorMessage)
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            {{ $errorMessage }}
        </div>
    @endif

    @if ($successMessage)
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ $successMessage }}
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-8">
        {{-- My QR Code Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="text-center">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    @if ($connectionStatus === 'idle')
                        QR Code Anda
                    @elseif($connectionStatus === 'waiting_for_response')
                        QR Response Anda
                    @else
                        Koneksi Berhasil!
                    @endif
                </h2>

                @if ($myQrSvg)
                    <div class="flex justify-center mb-4">
                        <div class="bg-white p-4 rounded-lg border-2 border-gray-200">
                            {!! $myQrSvg !!}
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        {{ $myQrCode }}
                    </p>
                @endif

                @if ($connectionStatus === 'idle')
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Tunjukkan QR ini kepada user lain untuk di-scan
                    </p>
                @elseif($connectionStatus === 'waiting_for_response')
                    <p class="text-sm text-blue-600 dark:text-blue-400 mb-4">
                        Tunjukkan QR ini kepada <strong>{{ $targetUser->name ?? 'user' }}</strong> untuk menyelesaikan
                        koneksi
                    </p>
                @else
                    <p class="text-sm text-green-600 dark:text-green-400 mb-4">
                        Anda berhasil terhubung dengan <strong>{{ $targetUser->name ?? 'user' }}</strong>!
                    </p>
                @endif

                <div class="space-y-2">
                    <button wire:click="refreshQr"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Buat QR Baru
                    </button>

                    @if ($connectionStatus !== 'idle')
                        <button wire:click="resetConnection"
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Reset Koneksi
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Scanner Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="text-center">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    Scan QR Code
                </h2>

                @if ($connectionStatus === 'connected')
                    <div class="text-center py-8">
                        <div class="text-green-600 text-6xl mb-4">✓</div>
                        <p class="text-lg text-gray-600 dark:text-gray-400">
                            Koneksi berhasil!
                        </p>
                    </div>
                @else
                    <div class="space-y-4">
                        {{-- Manual Input --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Atau masukkan QR code secara manual:
                            </label>
                            <div class="flex space-x-2">
                                <input type="text" wire:model="scannedQrCode" wire:keydown.enter="processScannedQr"
                                    placeholder="Paste QR code di sini..."
                                    class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <button wire:click="processScannedQr"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    Scan
                                </button>
                            </div>
                        </div>

                        {{-- Camera Scanner --}}
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8">
                            @if (!$isScanning)
                                <div class="text-center">
                                    <div class="text-gray-400 text-4xl mb-4">📷</div>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
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
                @endif
            </div>
        </div>
    </div>

    {{-- Instructions --}}
    <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">Cara Menggunakan:</h3>
        <ol class="list-decimal list-inside space-y-2 text-blue-800 dark:text-blue-200">
            <li>User A menampilkan QR code mereka</li>
            <li>User B scan QR code User A</li>
            <li>User B akan mendapat QR code baru untuk ditunjukkan kepada User A</li>
            <li>User A scan QR code User B</li>
            <li>Koneksi berhasil dibuat!</li>
        </ol>
        <p class="text-sm text-blue-700 dark:text-blue-300 mt-3">
            <strong>Catatan:</strong> QR code berlaku selama 1 menit dan akan otomatis diperbarui.
        </p>
    </div>
</div>

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrcodeScanner = null;

        document.addEventListener('livewire:init', () => {
            Livewire.on('start-camera', () => {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.clear();
                }

                html5QrcodeScanner = new Html5Qrcode("qr-reader");

                const config = {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                };

                html5QrcodeScanner.start({
                        facingMode: "environment"
                    },
                    config,
                    (decodedText, decodedResult) => {
                        console.log(`Code scanned = ${decodedText}`, decodedResult);
                        Livewire.dispatch('qr-scanned', {
                            qrCode: decodedText
                        });
                        html5QrcodeScanner.stop();
                    },
                    (errorMessage) => {
                        // Parse error, ideally ignore.
                        console.log(`QR Code scan error = ${errorMessage}`);
                    }
                ).catch((err) => {
                    console.log(`Unable to start the scanner, error = ${err}`);
                });
            });

            Livewire.on('stop-camera', () => {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.stop().then(() => {
                        html5QrcodeScanner.clear();
                    }).catch((err) => {
                        console.log(`Error stopping scanner = ${err}`);
                    });
                }
            });

            Livewire.on('connection-completed', () => {
                setTimeout(() => {
                    Livewire.dispatch('resetConnection');
                }, 3000);
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
    </script>
@endpush
