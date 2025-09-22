<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Test - Pasar Kolaboraya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Camera Test</h1>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">QR Code Scanner Test</h2>
                
                <!-- Camera Container -->
                <div id="camera-container" class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300 mb-4">
                    <div class="text-center text-gray-500">
                        <div class="text-4xl mb-2">📷</div>
                        <p>Klik tombol di bawah untuk mengaktifkan kamera</p>
                    </div>
                </div>
                
                <!-- Control Buttons -->
                <div class="flex gap-3 justify-center mb-4">
                    <button id="start-camera" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Mulai Kamera
                    </button>
                    <button id="stop-camera" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" disabled>
                        Stop Kamera
                    </button>
                </div>
                
                <!-- Status Display -->
                <div id="status" class="text-center text-sm text-gray-600">
                    Siap untuk mengaktifkan kamera
                </div>
                
                <!-- QR Code Result -->
                <div id="qr-result" class="mt-4 p-3 bg-green-50 border border-green-200 rounded-md hidden">
                    <h3 class="font-semibold text-green-800 mb-2">QR Code Terdeteksi:</h3>
                    <p id="qr-text" class="text-green-700 font-mono text-sm"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let html5QrcodeScanner = null;
        let isScanning = false;

        const startButton = document.getElementById('start-camera');
        const stopButton = document.getElementById('stop-camera');
        const statusDiv = document.getElementById('status');
        const qrResultDiv = document.getElementById('qr-result');
        const qrTextDiv = document.getElementById('qr-text');

        startButton.addEventListener('click', startCamera);
        stopButton.addEventListener('click', stopCamera);

        async function startCamera() {
            try {
                statusDiv.textContent = 'Meminta izin kamera...';
                startButton.disabled = true;

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
                html5QrcodeScanner = new Html5Qrcode("camera-container");

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
                        showQRResult(decodedText);
                        stopCamera();
                    },
                    (errorMessage) => {
                        // Ignore scan errors, keep scanning
                        console.log('QR scan error:', errorMessage);
                    }
                );

                statusDiv.textContent = 'Kamera aktif - Arahkan ke QR code';
                stopButton.disabled = false;
                isScanning = true;

            } catch (err) {
                console.error('Camera error:', err);
                statusDiv.textContent = 'Error: ' + err.message;
                statusDiv.className = 'text-center text-sm text-red-600';
                startButton.disabled = false;
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
            
            startButton.disabled = false;
            stopButton.disabled = true;
            statusDiv.textContent = 'Kamera dihentikan';
            statusDiv.className = 'text-center text-sm text-gray-600';
        }

        function showQRResult(decodedText) {
            qrTextDiv.textContent = decodedText;
            qrResultDiv.classList.remove('hidden');
            statusDiv.textContent = 'QR Code berhasil di-scan!';
            statusDiv.className = 'text-center text-sm text-green-600';
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            stopCamera();
        });
    </script>
</body>
</html>
