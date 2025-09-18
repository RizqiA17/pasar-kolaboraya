<x-layouts.app :title="__('Dashboard')">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">QR Code Saya</h1>
            <p class="text-gray-600">Tunjukkan QR code ini kepada admin untuk masuk ke Pasar Kolaboraya</p>
        </div>

        <!-- QR Code Display -->
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <!-- QR Code Display -->
            <div class="mb-6">
                <div class="inline-block p-4 bg-white border-2 border-gray-200 rounded-lg">
                    <!-- Server-side generated QR code -->
                    <div class="w-64 h-64 flex items-center justify-center">
                        {!! $qrCodeSvg !!}
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $qrCodeData['user_name'] }}</h2>
                <p class="text-gray-600">{{ $qrCodeData['user_email'] }}</p>
            </div>

            <!-- QR Code Info -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">QR Code:</span>
                        <p class="text-gray-600 font-mono text-xs break-all">{{ $qrCodeData['qr_code'] }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Dibuat:</span>
                        <p class="text-gray-600">{{ \Carbon\Carbon::parse($qrCodeData['generated_at'])->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Berlaku hingga:</span>
                        <p class="text-gray-600">{{ \Carbon\Carbon::parse($qrCodeData['expires_at'])->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button 
                    onclick="downloadQR()"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    📥 Download QR Code
                </button>
                <button 
                    onclick="printQR()"
                    class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
                >
                    🖨️ Print QR Code
                </button>
                <button 
                    onclick="regenerateQR()"
                    class="bg-orange-600 text-white px-6 py-2 rounded-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500"
                >
                    🔄 Generate Ulang
                </button>
            </div>
        </div>

        <!-- Instructions -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">Cara Menggunakan QR Code</h3>
            <ol class="list-decimal list-inside space-y-2 text-blue-800">
                <li>Tunjukkan QR code ini kepada admin Pasar Kolaboraya</li>
                <li>Admin akan scan QR code menggunakan aplikasi scanner</li>
                <li>Setelah QR code divalidasi, Anda akan mendapat akses ke Pasar Kolaboraya</li>
                <li>QR code berlaku selama 30 hari dari tanggal pembuatan</li>
                <li>Jika QR code expired, klik "Generate Ulang" untuk membuat yang baru</li>
            </ol>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Peringatan Keamanan</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Jangan bagikan QR code ini kepada orang lain. QR code ini adalah kunci akses pribadi Anda ke Pasar Kolaboraya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

// Download QR Code
function downloadQR() {
    const qrCodeData = @json($qrCodeData);
    const qrSvg = @json($qrCodeSvg);
    
    // Create SVG content for download
    const svgContent = `<?xml version="1.0" encoding="UTF-8"?>
${qrSvg}`;
    
    // Create blob and download
    const blob = new Blob([svgContent], { type: 'image/svg+xml' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'qr-code-pasar-kolaboraya.svg';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Print QR Code
function printQR() {
    const qrCodeData = @json($qrCodeData);
    const qrSvg = @json($qrCodeSvg);
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
    `);
    
    printWindow.document.close();
    printWindow.print();
}

// Regenerate QR Code
function regenerateQR() {
    if (confirm('Apakah Anda yakin ingin membuat QR code baru? QR code lama akan tidak berlaku lagi.')) {
        // Show loading state
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '🔄 Generating...';
        button.disabled = true;
        
        // Make AJAX request to regenerate QR code
        fetch('{{ route("qr.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.qr_code) {
                // Update QR code display
                updateQRCodeDisplay(data);
                alert('QR code berhasil di-generate ulang!');
            } else {
                alert(data.message || 'Terjadi kesalahan saat membuat QR code baru');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat membuat QR code baru: ' + error.message);
        })
        .finally(() => {
            // Restore button state
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
}

// Update QR code display with new data
function updateQRCodeDisplay(data) {
    // Update QR code SVG
    const qrContainer = document.querySelector('#qr-code-container div');
    if (qrContainer) {
        qrContainer.innerHTML = data.qr_code_svg;
    }
    
    // Update QR code text
    const qrCodeText = document.querySelector('.font-mono');
    if (qrCodeText) {
        qrCodeText.textContent = data.qr_code;
    }
    
    // Update generated date
    const generatedDate = document.querySelector('.text-gray-600');
    if (generatedDate && data.generated_at) {
        const date = new Date(data.generated_at);
        generatedDate.textContent = date.toLocaleDateString('id-ID') + ' ' + date.toLocaleTimeString('id-ID');
    }
    
    // Update expires date
    const expiresDate = document.querySelectorAll('.text-gray-600')[1];
    if (expiresDate && data.expires_at) {
        const date = new Date(data.expires_at);
        expiresDate.textContent = date.toLocaleDateString('id-ID') + ' ' + date.toLocaleTimeString('id-ID');
    }
}

</script>
</x-layouts.app>
