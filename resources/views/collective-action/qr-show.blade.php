@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<x-layouts.app :title="'QR Code Aksi Kolektif'">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2">QR Code Aksi Kolektif</h1>
                <p class="text-gray-600 dark:text-slate-300">{{ $collectiveAction->title }}</p>
            </div>

            <!-- QR Code Display -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8 text-center border border-gray-200 dark:border-slate-700">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-slate-200 mb-4">Scan QR Code untuk Bergabung</h2>
                    <div id="qr-code-container" class="inline-block p-4 bg-white border-2 border-gray-200 rounded-lg">
                        {!! QrCode::size(300)->format('svg')->generate($qrUrl) !!}
                    </div>
                </div>

                <!-- QR URL -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">URL QR Code:</label>
                    <div class="flex">
                        <input type="text" value="{{ $qrUrl }}" readonly
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-l-md bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-slate-100 text-sm">
                        <button onclick="copyToClipboard('{{ $qrUrl }}')"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-md text-sm transition-colors">
                            Copy
                        </button>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="text-left bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6 border border-blue-200 dark:border-blue-800">
                    <h3 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">Cara Menggunakan:</h3>
                    <ol class="list-decimal list-inside text-blue-800 dark:text-blue-300 space-y-1 text-sm">
                        <li>Tunjukkan QR code ini kepada user yang ingin bergabung</li>
                        <li>User dapat scan QR code menggunakan kamera smartphone</li>
                        <li>User akan diarahkan ke form bergabung aksi kolektif</li>
                        <li>Setelah mengisi form, permintaan bergabung akan menunggu persetujuan Anda</li>
                    </ol>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('collective-action.show', $collectiveAction) }}"
                        class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition-colors">
                        Kembali ke Aksi Kolektif
                    </a>
                    <button onclick="downloadQR()"
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors">
                        Download QR Code
                    </button>
                    <a href="{{ route('collective-action.qr.scanner') }}"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                        Scan QR Code Lain
                    </a>
                </div>
            </div>

            <!-- Collective Action Info -->
            <div class="mt-8 bg-gray-50 dark:bg-slate-800 rounded-lg p-6 border border-gray-200 dark:border-slate-700">
                <h3 class="font-semibold text-gray-800 dark:text-slate-200 mb-3">Informasi Aksi Kolektif</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
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
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const button = event.target;
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                button.classList.add('bg-green-600');
                button.classList.remove('bg-blue-600');

                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('bg-green-600');
                    button.classList.add('bg-blue-600');
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                alert('Gagal menyalin URL');
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
