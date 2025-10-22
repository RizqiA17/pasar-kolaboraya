<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Code Registrasi - {{ $pasarKolaboraya->name }}</title>
    <link rel="icon" href="{{ asset('images/logo-pasar-kolaboraya.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
               <div class="text-center">
                   <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                       {{ $pasarKolaboraya->name }}
                   </h2>
                   <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                       QR Code untuk registrasi event
                   </p>
               </div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="text-center">
                    <!-- QR Code -->
                    <div class="flex justify-center mb-6">
                        <div class="bg-white p-4 rounded-lg shadow-lg">
                            {!! $qrCode !!}
                        </div>
                    </div>

                    <!-- Event Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            {{ $pasarKolaboraya->name }}
                        </h3>
                        @if($pasarKolaboraya->description)
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $pasarKolaboraya->description }}
                            </p>
                        @endif
                    </div>

                    <!-- Registration URL -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Link Registrasi:
                        </label>
                        <div class="flex">
                            <input 
                                type="text" 
                                value="{{ $registrationUrl }}" 
                                readonly 
                                class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md bg-gray-50 dark:bg-gray-700 text-sm text-gray-900 dark:text-white"
                            >
                            <button 
                                onclick="copyToClipboard(event, '{{ $registrationUrl }}')"
                                class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-r-md transition-colors"
                            >
                                Copy
                            </button>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="text-left">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">
                            Cara Penggunaan:
                        </h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                            <li>• Scan QR code dengan kamera smartphone</li>
                            <li>• Atau salin link di atas dan buka di browser</li>
                            <li>• Isi form registrasi yang muncul</li>
                            <li>• Verifikasi email untuk mengaktifkan akun</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 space-y-3">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button onclick="downloadQR()" 
                               class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                📥 Download PNG
                            </button>
                            {{-- <a href="{{ route('pasar-kolaboraya.qr.printable', $pasarKolaboraya->name) }}" 
                               class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                                🖨️ Print Poster
                            </a> --}}
                        </div>
                        
                               <div class="text-center">
                                   <a href="{{ route('admin.pasar-kolaboraya.manage') }}" 
                                      class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                       ← Kembali ke Dashboard
                                   </a>
                               </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto download if URL contains download=1
        if (window.location.search.includes('download=1')) {
            window.onload = function() {
                setTimeout(() => {
                    downloadQR();
                }, 1000);
            };
        }

        function copyToClipboard(event, text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const button = event.target;
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                button.classList.add('bg-green-600');
                button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                
                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('bg-green-600');
                    button.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                alert('Gagal menyalin link');
            });
        }

        function downloadQR() {
            // Find the QR code SVG
            const qrContainer = document.querySelector('.bg-white.p-4.rounded-lg.shadow-lg');
            const svg = qrContainer ? qrContainer.querySelector('svg') : null;
            
            if (!svg) {
                alert('QR code tidak ditemukan');
                return;
            }

            // Create a canvas element to convert SVG to image
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            // Set canvas size
            canvas.width = 300;
            canvas.height = 300;

            // Create image from SVG
            const img = new Image();
            const svgData = new XMLSerializer().serializeToString(svg);
            const svgBlob = new Blob([svgData], {
                type: 'image/svg+xml;charset=utf-8'
            });
            const url = URL.createObjectURL(svgBlob);

            img.onload = function() {
                ctx.drawImage(img, 0, 0);
                URL.revokeObjectURL(url);

                // Download the image
                const link = document.createElement('a');
                link.download = 'pasar-kolaboraya-qr-{{ $pasarKolaboraya->name }}-{{ date("Y-m-d") }}.png';
                link.href = canvas.toDataURL();
                link.click();
            };

            img.onerror = function() {
                URL.revokeObjectURL(url);
                alert('Gagal mengunduh QR code');
            };

            img.src = url;
        }
    </script>
</body>
</html>
