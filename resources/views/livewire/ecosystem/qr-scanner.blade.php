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
                <!-- Camera Section -->
                <div class="mb-6">
                    <div class="text-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-slate-200 mb-2">Kamera Scanner</h2>
                        <p class="text-gray-600 dark:text-slate-400 text-sm">Arahkan kamera ke QR code ekosistem</p>
                    </div>
                    
                    <!-- Camera Container -->
                    <div class="relative mx-auto max-w-md">
                        <div id="camera-container" class="relative bg-gray-100 dark:bg-slate-700 rounded-lg overflow-hidden" style="height: 300px;">
                            <video id="video" class="w-full h-full object-cover" autoplay playsinline></video>
                            <canvas id="canvas" class="hidden"></canvas>
                            
                            <!-- Scanner Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-48 h-48 border-2 border-blue-500 rounded-lg relative">
                                    <div class="absolute top-0 left-0 w-6 h-6 border-t-4 border-l-4 border-blue-500 rounded-tl-lg"></div>
                                    <div class="absolute top-0 right-0 w-6 h-6 border-t-4 border-r-4 border-blue-500 rounded-tr-lg"></div>
                                    <div class="absolute bottom-0 left-0 w-6 h-6 border-b-4 border-l-4 border-blue-500 rounded-bl-lg"></div>
                                    <div class="absolute bottom-0 right-0 w-6 h-6 border-b-4 border-r-4 border-blue-500 rounded-br-lg"></div>
                                </div>
                            </div>
                            
                            <!-- Loading/Error States -->
                            <div id="camera-loading" class="absolute inset-0 flex items-center justify-center bg-gray-100 dark:bg-slate-700">
                                <div class="text-center">
                                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-2"></div>
                                    <p class="text-gray-600 dark:text-slate-300">Memuat kamera...</p>
                                </div>
                            </div>
                            
                            <div id="camera-error" class="absolute inset-0 flex items-center justify-center bg-red-50 dark:bg-red-900/20 hidden">
                                <div class="text-center">
                                    <div class="text-red-500 text-4xl mb-2">📷</div>
                                    <p class="text-red-600 dark:text-red-400 font-medium">Kamera tidak dapat diakses</p>
                                    <p class="text-red-500 dark:text-red-400 text-sm">Pastikan izin kamera telah diberikan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Control Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center mb-6">
                    @if($isScanning)
                        <button wire:click="stopScanning" 
                                class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors">
                            Stop Scanning
                        </button>
                    @else
                        <button wire:click="startScanning" 
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                            Mulai Scanning
                        </button>
                    @endif
                    
                    <button onclick="window.location.href='{{ route('ecosystem.browse') }}'" 
                            class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition-colors">
                        Kembali ke Daftar Ekosistem
                    </button>
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
    <script>
        let stream = null;
        let scanning = false;
        let video = null;
        let canvas = null;
        let ctx = null;

        document.addEventListener('DOMContentLoaded', function() {
            video = document.getElementById('video');
            canvas = document.getElementById('canvas');
            ctx = canvas.getContext('2d');
        });

        // Listen for Livewire events
        Livewire.on('start-camera', () => {
            startCamera();
        });

        Livewire.on('stop-camera', () => {
            stopCamera();
        });


        async function startCamera() {
            try {
                const constraints = {
                    video: {
                        facingMode: 'environment', // Use back camera
                        width: { ideal: 640 },
                        height: { ideal: 480 }
                    }
                };

                stream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = stream;
                
                video.onloadedmetadata = () => {
                    video.play();
                    scanning = true;
                    scanForQR();
                    hideLoading();
                };

            } catch (err) {
                console.error('Error accessing camera:', err);
                showError();
            }
        }

        function stopCamera() {
            scanning = false;
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            video.srcObject = null;
        }

        function scanForQR() {
            if (!scanning) return;

            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);

                if (code) {
                    console.log('QR Code detected:', code.data);
                    scanning = false;
                    stopCamera();
                    
                    // Send to Livewire
                    @this.handleQrScanned(code.data);
                }
            }

            if (scanning) {
                requestAnimationFrame(scanForQR);
            }
        }

        function hideLoading() {
            document.getElementById('camera-loading').style.display = 'none';
        }

        function showError() {
            document.getElementById('camera-loading').style.display = 'none';
            document.getElementById('camera-error').classList.remove('hidden');
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            stopCamera();
        });
    </script>

    <!-- Include jsQR library -->
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
</div>
