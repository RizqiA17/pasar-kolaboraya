<div>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">QR Code Scanner</h1>
                <p class="text-gray-600">Scan QR code user untuk memberikan akses ke Pasar Kolaboraya</p>
            </div>

            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if (session()->has('message'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
                    {{ session('message') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Scanner Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Scanner QR Code</h2>
                    
                    <!-- Manual Input -->
                    <div class="mb-6">
                        <label for="scannedQrCode" class="block text-sm font-medium text-gray-700 mb-2">
                            Masukkan QR Code Manual
                        </label>
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                id="scannedQrCode"
                                wire:model="scannedQrCode" 
                                class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
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
                        <div id="camera-container" class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300">
                            @if ($isScanning)
                                <div class="text-center">
                                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-2"></div>
                                    <p class="text-gray-600">Mengaktifkan kamera...</p>
                                </div>
                            @else
                                <div class="text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p>Klik "Buka Kamera" untuk memulai scan</p>
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
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Hasil Validasi</h2>
                    
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
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <h3 class="font-medium text-gray-900 mb-2">Informasi User</h3>
                                    <div class="space-y-2 text-sm">
                                        <div><span class="font-medium">Nama:</span> {{ $validationResult['user']['name'] }}</div>
                                        <div><span class="font-medium">Email:</span> {{ $validationResult['user']['email'] }}</div>
                                        <div><span class="font-medium">Role:</span> {{ ucfirst($validationResult['user']['role']) }}</div>
                                        <div><span class="font-medium">QR Generated:</span> {{ \Carbon\Carbon::parse($validationResult['user']['qr_code_generated_at'])->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>

                            <!-- Pasar Kolaboraya Selection -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih Pasar Kolaboraya
                                </label>
                                <select 
                                    wire:model="selectedPasarKolaboraya"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                    <option value="">-- Pilih Pasar Kolaboraya --</option>
                                    @foreach($availablePasarKolaboraya as $pasar)
                                        <option value="{{ $pasar['id'] }}">
                                            {{ $pasar['name'] }} ({{ $pasar['participant_count'] }} peserta)
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedPasarKolaboraya') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                                @enderror
                                
                                <!-- Selected Pasar Kolaboraya Info -->
                                @if($selectedPasarKolaboraya)
                                    @php
                                        $selectedPasar = collect($availablePasarKolaboraya)->firstWhere('id', $selectedPasarKolaboraya);
                                    @endphp
                                    @if($selectedPasar)
                                        <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-md">
                                            <h4 class="text-sm font-medium text-blue-900">{{ $selectedPasar['name'] }}</h4>
                                            <p class="text-xs text-blue-700 mt-1">{{ $selectedPasar['description'] }}</p>
                                            <p class="text-xs text-blue-600 mt-1">
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
                        <div class="text-center text-gray-500 py-8">
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
                <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Riwayat Scan</h2>
                        <button 
                            wire:click="clearHistory"
                            class="text-red-600 hover:text-red-800 text-sm"
                        >
                            Hapus Riwayat
                        </button>
</div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasar Kolaboraya</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pesan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($scanHistory as $scan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $scan['timestamp'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-mono">{{ Str::limit($scan['qr_code'], 20) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $scan['user_name'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $scan['pasar_kolaboraya'] ?? 'Tidak dipilih' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($scan['valid'])
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Valid
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Tidak Valid
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $scan['message'] }}</td>
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
    <script src="https://cdn.jsdelivr.net/npm/qr-scanner@1.4.2/qr-scanner.umd.min.js"></script>
    
    <script>
        let qrScanner = null;
        
        Livewire.on('start-camera', () => {
            const videoContainer = document.getElementById('camera-container');
            
            if (qrScanner) {
                qrScanner.destroy();
            }
            
            qrScanner = new QrScanner(
                videoContainer,
                result => {
                    Livewire.emit('onQrScanned', result.data);
                },
                {
                    highlightScanRegion: true,
                    highlightCodeOutline: true,
                }
            );
            
            qrScanner.start().catch(err => {
                console.error('Error starting camera:', err);
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.');
            });
        });
        
        Livewire.on('stop-camera', () => {
            if (qrScanner) {
                qrScanner.destroy();
                qrScanner = null;
            }
        });
        
        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (qrScanner) {
                qrScanner.destroy();
            }
        });
    </script>
</div>