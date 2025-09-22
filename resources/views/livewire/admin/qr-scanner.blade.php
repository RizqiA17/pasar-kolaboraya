<div>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">QR Code Scanner</h1>
                <p class="text-gray-600 dark:text-gray-300">Scan QR code user untuk memberikan akses ke Pasar Kolaboraya</p>
            </div>

            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if (session()->has('message'))
                <div class="bg-blue-100 dark:bg-blue-900/20 border border-blue-400 dark:border-blue-800 text-blue-700 dark:text-blue-300 px-4 py-3 rounded mb-6">
                    {{ session('message') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Scanner Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Scanner QR Code</h2>
                    
                    <!-- Manual Input -->
                    <div class="mb-6">
                        <label for="scannedQrCode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Masukkan QR Code Manual
                        </label>
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                id="scannedQrCode"
                                wire:model="scannedQrCode" 
                                class="flex-1 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Paste atau ketik QR code di sini..."
                            />
                            <button 
                                wire:click="validateQrCode"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                Validasi
                            </button>
                        </div>
                        @error('scannedQrCode') 
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Camera Scanner -->
                    <div class="mb-6">
                        <div class="flex gap-2 mb-4">
                            @if (!$isScanning)
                                <button 
                                    wire:click="startScanning"
                                    class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                >
                                    📷 Buka Kamera
                                </button>
                            @else
                                <button 
                                    wire:click="stopScanning"
                                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                >
                                    ⏹️ Tutup Kamera
                                </button>
                            @endif
                        </div>

                        <!-- Camera Container -->
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8">
                            @if (!$isScanning)
                                <div class="text-center">
                                    <div class="text-gray-400 text-4xl mb-4">📷</div>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        Gunakan kamera untuk scan QR code
                                    </p>
                                </div>
                            @else
                                <div class="text-center">
                                    <div id="qr-reader" class="w-full"></div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button 
                            wire:click="clearForm"
                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        >
                            Reset
                        </button>
                        <button 
                            wire:click="toggleHistory"
                            class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        >
                            {{ $showHistory ? 'Sembunyikan' : 'Tampilkan' }} Riwayat
                        </button>
                    </div>
                </div>

                <!-- Validation Result -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Hasil Validasi</h2>
                    
                    @if ($validationResult)
                        <div class="space-y-4">
                            <!-- Status -->
                            <div class="flex items-center gap-2">
                                @if ($validationResult['valid'])
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-green-600 font-medium">QR Code Valid</span>
                                @else
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <span class="text-red-600 font-medium">QR Code Tidak Valid</span>
                                @endif
                            </div>

                            <!-- Message -->
                            <div class="p-3 rounded-md {{ $validationResult['valid'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                                <p class="text-sm {{ $validationResult['valid'] ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $validationResult['message'] }}
                                </p>
                            </div>

                            <!-- User Info (if valid) -->
                            @if ($validationResult['valid'] && isset($validationResult['user']))
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                                    <h3 class="font-medium text-gray-900 dark:text-white mb-2">Informasi User</h3>
                                    <div class="space-y-2 text-sm">
                                        <div><span class="font-medium text-gray-700 dark:text-gray-300">Nama:</span> <span class="text-gray-900 dark:text-white">{{ $validationResult['user']['name'] }}</span></div>
                                        <div><span class="font-medium text-gray-700 dark:text-gray-300">Email:</span> <span class="text-gray-900 dark:text-white">{{ $validationResult['user']['email'] }}</span></div>
                                        <div><span class="font-medium text-gray-700 dark:text-gray-300">Role:</span> <span class="text-gray-900 dark:text-white">{{ ucfirst($validationResult['user']['role']) }}</span></div>
                                        <div><span class="font-medium text-gray-700 dark:text-gray-300">QR Generated:</span> <span class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($validationResult['user']['qr_code_generated_at'])->format('d/m/Y H:i') }}</span></div>
                                    </div>
                                </div>

                            <!-- Pasar Kolaboraya Selection -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pilih Pasar Kolaboraya
                                </label>
                                <select 
                                    wire:model="selectedPasarKolaboraya"
                                    class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                    <option value="">-- Pilih Pasar Kolaboraya --</option>
                                    @foreach($availablePasarKolaboraya as $pasar)
                                        <option value="{{ $pasar['id'] }}">
                                            {{ $pasar['name'] }} ({{ $pasar['participant_count'] }} peserta)
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedPasarKolaboraya') 
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> 
                                @enderror
                                
                                <!-- Selected Pasar Kolaboraya Info -->
                                @if($selectedPasarKolaboraya)
                                    @php
                                        $selectedPasar = collect($availablePasarKolaboraya)->firstWhere('id', $selectedPasarKolaboraya);
                                    @endphp
                                    @if($selectedPasar)
                                        <div class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md">
                                            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">{{ $selectedPasar['name'] }}</h4>
                                            <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">{{ $selectedPasar['description'] }}</p>
                                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                                                {{ $selectedPasar['participant_count'] }} peserta • Dibuat: {{ $selectedPasar['created_at'] }}
                                            </p>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <!-- Grant Access Button -->
                            <button 
                                wire:click="grantAccess"
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                @if(!$selectedPasarKolaboraya) disabled @endif
                            >
                                ✅ Berikan Akses ke Pasar Kolaboraya
                            </button>
                            @endif
                        </div>
                    @else
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Belum ada QR code yang di-scan</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Scan History -->
            @if ($showHistory && count($scanHistory) > 0)
                <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat Scan</h2>
                        <button 
                            wire:click="clearHistory"
                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm"
                        >
                            Hapus Riwayat
                        </button>
</div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">QR Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pasar Kolaboraya</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pesan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($scanHistory as $scan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $scan['timestamp'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-mono">{{ Str::limit($scan['qr_code'], 20) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $scan['user_name'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $scan['pasar_kolaboraya'] ?? 'Tidak dipilih' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($scan['valid'])
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                    Valid
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                                    Tidak Valid
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $scan['message'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- QR Scanner Script -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    
    <script>
        let html5QrcodeScanner = null;
        let isScanning = false;
        
        document.addEventListener('livewire:init', () => {
            Livewire.on('start-camera', () => {
                startCamera();
            });
            
            Livewire.on('stop-camera', () => {
                stopCamera();
            });
        });

        async function startCamera() {
            try {
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
                html5QrcodeScanner = new Html5Qrcode("qr-reader");

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
                        stopCamera();
                        Livewire.dispatch('qr-scanned', { qrCode: decodedText });
                    },
                    (errorMessage) => {
                        // Ignore scan errors, keep scanning
                        console.log('QR scan error:', errorMessage);
                    }
                );

                isScanning = true;

            } catch (err) {
                console.error('Camera error:', err);
                alert('Tidak dapat mengakses kamera: ' + err.message);
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
        }
        
        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            stopCamera();
        });

        // Handle page visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.hidden && isScanning) {
                stopCamera();
            }
        });
    </script>
</div>