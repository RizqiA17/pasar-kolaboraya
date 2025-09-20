<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">QR Scanner - Aksi Kolektif</h1>
            <p class="text-gray-600">Scan QR code untuk bergabung dengan aksi kolektif</p>
        </div>

        <!-- QR Scanner Interface -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="text-center">
                <!-- Camera Scanner Area -->
                <div id="scanner-container" class="relative mb-6">
                    <div id="qr-reader" class="w-full max-w-md mx-auto"></div>
                    <div class="mt-4 text-sm text-gray-500">
                        <p>Posisikan QR code dalam area scanner</p>
                    </div>
                </div>

                <!-- Manual Input -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4">Atau masukkan URL QR code secara manual:</h3>
                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            wire:model="scannedQrCode"
                            placeholder="Masukkan URL QR code..."
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        <button 
                            wire:click="processScannedQr"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Proses
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages -->
        @if($errorMessage)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Error</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>{{ $errorMessage }}</p>
                        </div>
                    </div>
                    <div class="ml-auto pl-3">
                        <button wire:click="clearMessages" class="text-red-400 hover:text-red-600">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if($successMessage)
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Berhasil</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>{{ $successMessage }}</p>
                        </div>
                    </div>
                    <div class="ml-auto pl-3">
                        <button wire:click="clearMessages" class="text-green-400 hover:text-green-600">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Instructions -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">Cara Menggunakan QR Scanner</h3>
            <div class="space-y-3 text-sm text-blue-800">
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-blue-200 text-blue-800 rounded-full flex items-center justify-center text-xs font-semibold mr-3 mt-0.5">1</span>
                    <p>Izinkan akses kamera saat diminta oleh browser</p>
                </div>
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-blue-200 text-blue-800 rounded-full flex items-center justify-center text-xs font-semibold mr-3 mt-0.5">2</span>
                    <p>Posisikan QR code dalam area scanner yang ditampilkan</p>
                </div>
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-blue-200 text-blue-800 rounded-full flex items-center justify-center text-xs font-semibold mr-3 mt-0.5">3</span>
                    <p>QR code akan otomatis ter-scan dan mengarahkan ke form bergabung</p>
                </div>
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-blue-200 text-blue-800 rounded-full flex items-center justify-center text-xs font-semibold mr-3 mt-0.5">4</span>
                    <p>Atau masukkan URL QR code secara manual di kolom input</p>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-8">
            <a href="{{ route('collective-action.browse') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Aksi Kolektif
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader",
        { 
            fps: 10, 
            qrbox: { width: 250, height: 250 } 
        },
        false
    );

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`QR Code detected: ${decodedText}`);
        
        // Set the scanned QR code in Livewire
        @this.set('scannedQrCode', decodedText);
        
        // Process the QR code
        @this.call('processScannedQr');
        
        // Stop the scanner
        html5QrcodeScanner.clear();
    }

    function onScanFailure(error) {
        // Handle scan failure, usually ignored
        console.log(`QR Code scan failed: ${error}`);
    }
});
</script>
@endpush
