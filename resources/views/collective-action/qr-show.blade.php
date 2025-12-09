@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<x-layouts.app :title="'QR Code Aksi Kolektif'">
    <div class="container mx-auto px-4 py-6 sm:py-8 w-full overflow-x-hidden">
        <div class="max-w-4xl mx-auto w-full">
            <!-- Header -->
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">QR Code Aksi Kolektif</h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">{{ $collectiveAction->title }}</p>
            </div>

            <!-- QR Code Display -->
            <div class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-xl shadow-lg p-4 sm:p-6 w-full overflow-hidden">
                <div class="text-center w-full">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Scan QR Code untuk Bergabung</h2>
                    <div class="flex justify-center mb-3 sm:mb-4">
                        <div class="bg-white p-1 sm:p-4 rounded-lg border-2 border-gray-200 max-w-52 sm:max-w-none">
                            <div id="qr-code-container" class="w-48 h-48 sm:w-48 sm:h-48 mx-auto overflow-hidden flex items-center justify-center">
                                {!! QrCode::size(300)->format('svg')->generate($qrUrl) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR URL -->
                <div class="mb-4 sm:mb-6">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">URL QR Code:</label>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 w-full">
                        <input type="text" value="{{ $qrUrl }}" readonly
                            class="flex-1 px-3 py-2.5 sm:py-2 border border-gray-300 dark:border-slate-600 rounded-l-md sm:rounded-r-none bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-slate-100 text-xs sm:text-sm min-w-0">
                        <button 
                            onclick="copyToClipboard('{{ $qrUrl }}', event)"
                            data-copy-button
                            class="px-4 py-2.5 sm:py-2 bg-primary-blue hover:bg-primary-blue/90 text-white rounded-r-md sm:rounded-l-none text-xs sm:text-sm transition-colors whitespace-nowrap">
                            Copy
                        </button>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-blue-50 dark:bg-green-900/20 border border-blue-200 dark:border-green-800/30 rounded-xl p-4 sm:p-6 mb-4 sm:mb-6 w-full overflow-hidden">
                    <h3 class="text-sm sm:text-lg font-semibold text-blue-900 dark:text-secondary-green mb-2 sm:mb-3">Cara Menggunakan:</h3>
                    <ol class="list-decimal list-inside space-y-1.5 sm:space-y-2 text-xs sm:text-sm text-blue-800 dark:text-teal-100">
                        <li>Tunjukkan QR code ini kepada user yang ingin bergabung</li>
                        <li>User dapat scan QR code menggunakan kamera smartphone</li>
                        <li>User akan diarahkan ke form bergabung aksi kolektif</li>
                        <li>Setelah mengisi form, permintaan bergabung akan menunggu persetujuan Anda</li>
                    </ol>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-center w-full">
                    <a href="{{ route('collective-action.show', $collectiveAction) }}"
                        class="px-4 sm:px-6 py-2.5 sm:py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition-colors text-xs sm:text-sm font-medium">
                        Kembali ke Aksi Kolektif
                    </a>
                    <button onclick="downloadQR()"
                        class="px-4 sm:px-6 py-2.5 sm:py-2 bg-secondary-green hover:bg-secondary-green/90 text-white rounded-md transition-colors text-xs sm:text-sm font-medium">
                        Download QR Code
                    </button>
                    <a href="{{ route('collective-action.qr.scanner') }}"
                        class="px-4 sm:px-6 py-2.5 sm:py-2 bg-primary-blue hover:bg-primary-blue/90 text-white rounded-md transition-colors text-xs sm:text-sm font-medium">
                        Scan QR Code Lain
                    </a>
                </div>
            </div>

            <!-- Collective Action Info -->
            <div class="mt-6 sm:mt-8 bg-gray-50 dark:bg-slate-800 rounded-lg p-4 sm:p-6 border border-gray-200 dark:border-slate-700 w-full overflow-hidden">
                <h3 class="text-sm sm:text-base font-semibold text-gray-800 dark:text-slate-200 mb-2 sm:mb-3">Informasi Aksi Kolektif</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-xs sm:text-sm">
                    <div>
                        <span class="font-medium text-gray-600 dark:text-slate-400">Judul:</span>
                        <span class="text-gray-800 dark:text-slate-200">{{ $collectiveAction->title }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600 dark:text-slate-400">Skala:</span>
                        <span class="text-gray-800 dark:text-slate-200 capitalize">{{ $collectiveAction->scale }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600 dark:text-slate-400">Lingkup:</span>
                        <span class="text-gray-800 dark:text-slate-200 capitalize">{{ $collectiveAction->scope }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600 dark:text-slate-400">Status:</span>
                        <span class="text-gray-800 dark:text-slate-200">
                            <span class="px-2 py-1 rounded-full text-xs {{ 
                                $collectiveAction->status === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200' : 
                                ($collectiveAction->status === 'completed' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200' : 
                                'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200') 
                            }}">
                                {{ ucfirst($collectiveAction->status) }}
                            </span>
                        </span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600 dark:text-slate-400">Tanggal Mulai:</span>
                        <span class="text-gray-800 dark:text-slate-200">{{ $collectiveAction->start_date->format('d M Y') }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600 dark:text-slate-400">Tanggal Selesai:</span>
                        <span class="text-gray-800 dark:text-slate-200">{{ $collectiveAction->end_date->format('d M Y') }}</span>
                    </div>
                    <div class="md:col-span-2">
                        <span class="font-medium text-gray-600 dark:text-slate-400">Deskripsi:</span>
                        <p class="text-gray-800 dark:text-slate-200 mt-1">{{ Str::limit($collectiveAction->description, 150) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text, event) {
            // Get the button element directly
            const button = document.querySelector('[data-copy-button]');
            if (!button) {
                console.error('Copy button not found');
                return;
            }

            const originalText = button.textContent;
            
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                button.textContent = 'Copied!';
                button.classList.add('bg-secondary-green');
                button.classList.remove('bg-primary-blue');

                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('bg-secondary-green');
                    button.classList.add('bg-primary-blue');
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                alert('Gagal menyalin URL');
                // Reset button state in case of error
                button.textContent = originalText;
            });
        }

        function downloadQR() {
            // Find the QR code SVG specifically by ID
            const qrContainer = document.getElementById('qr-code-container');
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
                link.download = 'collective-action-qr-{{ $collectiveAction->id }}.png';
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
</x-layouts.app>
