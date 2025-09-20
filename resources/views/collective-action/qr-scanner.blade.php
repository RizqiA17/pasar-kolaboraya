<x-layouts.app :title="'Scanner QR Code Aksi Kolektif'">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2">Scanner QR Code</h1>
                <p class="text-gray-600 dark:text-slate-300">Scan QR code untuk bergabung dengan aksi kolektif</p>
            </div>

            <!-- Scanner Interface -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8 text-center border border-gray-200 dark:border-slate-700">
                <!-- Camera Preview -->
                <div class="mb-6">
                    <div id="camera-container" class="relative mx-auto w-80 h-80 bg-gray-100 dark:bg-slate-700 rounded-lg overflow-hidden border-2 border-gray-300 dark:border-slate-600">
                        <video id="video" autoplay playsinline class="w-full h-full object-cover"></video>
                        <canvas id="canvas" class="hidden"></canvas>
                        <div id="scanner-overlay" class="absolute inset-0 flex items-center justify-center">
                            <div class="w-48 h-48 border-2 border-blue-500 rounded-lg relative">
                                <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-blue-500"></div>
                                <div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-blue-500"></div>
                                <div class="absolute bottom-0 left-0 w-6 h-6 border-b-2 border-l-2 border-blue-500"></div>
                                <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-blue-500"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scanner Status -->
                <div id="scanner-status" class="mb-6">
                    <div id="status-message" class="text-sm text-gray-600 dark:text-slate-400">
                        Klik tombol "Mulai Scan" untuk memulai scanning
                    </div>
                </div>

                <!-- Manual Input -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Atau masukkan URL QR code secara manual:
                    </label>
                    <form method="POST" action="{{ route('collective-action.qr.process-scan') }}" class="flex">
                        @csrf
                        <input type="url" name="qr_data" placeholder="https://..." required
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-l-md bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-md text-sm transition-colors">
                            Proses
                        </button>
                    </form>
                </div>

                <!-- Controls -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <button id="start-scan" onclick="startScan()"
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors">
                        Mulai Scan
                    </button>
                    <button id="stop-scan" onclick="stopScan()" disabled
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        Stop Scan
                    </button>
                    <a href="{{ route('collective-action.browse') }}"
                        class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition-colors">
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Error</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Berhasil</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Instructions -->
            <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800">
                <h3 class="font-semibold text-blue-900 dark:text-blue-200 mb-3">Cara Menggunakan Scanner:</h3>
                <ol class="list-decimal list-inside text-blue-800 dark:text-blue-300 space-y-2 text-sm">
                    <li>Klik tombol "Mulai Scan" untuk mengaktifkan kamera</li>
                    <li>Arahkan kamera ke QR code aksi kolektif</li>
                    <li>Pastikan QR code berada dalam area kotak biru</li>
                    <li>Scanner akan otomatis mendeteksi dan memproses QR code</li>
                    <li>Anda akan diarahkan ke halaman bergabung aksi kolektif</li>
                </ol>
            </div>
        </div>
    </div>

    <script>
        let stream = null;
        let scanning = false;

        async function startScan() {
            try {
                // Request camera access
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment' // Use back camera on mobile
                    } 
                });
                
                const video = document.getElementById('video');
                video.srcObject = stream;
                
                // Update UI
                document.getElementById('start-scan').disabled = true;
                document.getElementById('stop-scan').disabled = false;
                document.getElementById('status-message').textContent = 'Arahkan kamera ke QR code...';
                document.getElementById('status-message').className = 'text-sm text-blue-600 dark:text-blue-400';
                
                scanning = true;
                
                // Start scanning for QR codes
                scanForQR();
                
            } catch (error) {
                console.error('Error accessing camera:', error);
                document.getElementById('status-message').textContent = 'Gagal mengakses kamera. Pastikan izin kamera diizinkan.';
                document.getElementById('status-message').className = 'text-sm text-red-600 dark:text-red-400';
            }
        }

        function stopScan() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            
            scanning = false;
            
            // Update UI
            document.getElementById('start-scan').disabled = false;
            document.getElementById('stop-scan').disabled = true;
            document.getElementById('status-message').textContent = 'Scanning dihentikan. Klik "Mulai Scan" untuk memulai lagi.';
            document.getElementById('status-message').className = 'text-sm text-gray-600 dark:text-slate-400';
        }

        function scanForQR() {
            if (!scanning) return;
            
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');
            
            // Set canvas size to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw current video frame to canvas
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Get image data
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            
            // Simple QR code detection (this is a basic implementation)
            // In a real application, you would use a QR code library like jsQR
            const qrData = detectQRCode(imageData);
            
            if (qrData) {
                // QR code detected
                document.getElementById('status-message').textContent = 'QR code terdeteksi! Memproses...';
                document.getElementById('status-message').className = 'text-sm text-green-600 dark:text-green-400';
                
                // Stop scanning
                stopScan();
                
                // Process the QR code
                processQRCode(qrData);
            } else {
                // Continue scanning
                setTimeout(scanForQR, 100);
            }
        }

        function detectQRCode(imageData) {
            // This is a simplified QR detection
            // In a real implementation, you would use a proper QR code library
            // For now, we'll simulate detection by checking for specific patterns
            
            // This is just a placeholder - you would need to implement actual QR detection
            // or use a library like jsQR: https://github.com/cozmo/jsQR
            
            return null; // Placeholder - no QR detected
        }

        function processQRCode(qrData) {
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("collective-action.qr.process-scan") }}';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add QR data
            const qrInput = document.createElement('input');
            qrInput.type = 'hidden';
            qrInput.name = 'qr_data';
            qrInput.value = qrData;
            form.appendChild(qrInput);
            
            // Submit form
            document.body.appendChild(form);
            form.submit();
        }

        // Clean up when page is unloaded
        window.addEventListener('beforeunload', function() {
            stopScan();
        });
    </script>
</x-layouts.app>
