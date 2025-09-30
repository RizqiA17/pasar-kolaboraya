@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush

<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-blue to-secondary-green text-white rounded-xl p-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('collective-action.browse') }}" class="mr-4 text-white/80 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Buat Aksi Kolektif</h1>
        </div>
        <p class="text-blue-100">
            Ajak ecosystem builders lain untuk berkolaborasi dalam gerakan perubahan sosial yang lebih besar
        </p>
    </div>

    <!-- Info Box -->
    <div class="bg-primary-light-blue/10 dark:bg-primary-blue/20 border border-primary-light-blue/20 dark:border-primary-blue/30 rounded-xl p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-primary-blue mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="font-semibold text-primary-blue dark:text-primary-light-blue">Flow Aksi Kolektif</h3>
                <p class="text-sm text-primary-blue/80 dark:text-primary-light-blue/80 mt-1">
                    1. Anda membuat aksi kolektif dan mengundang ecosystem builders lain<br>
                    2. Mereka menerima/menolak undangan untuk berkolaborasi<br>
                    3. Setelah minimal 3 ekosistem bergabung, aksi dapat dimulai<br>
                    4. User biasa dapat berkontribusi pada aksi yang aktif
                </p>
            </div>
        </div>
    </div>

    <form wire:submit="createAction" class="space-y-6">
        <!-- Basic Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Informasi Dasar
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div class="md:col-span-2">
                    <flux:input
                        wire:model="title"
                        :label="'Judul Aksi Kolektif'"
                        type="text"
                        required
                        :placeholder="'Contoh: Gerakan Bersih-Bersih Lingkungan Nasional'"
                    />
                </div>

                <!-- Scale -->
                <flux:select wire:model="scale" :label="'Skala Aksi'" required>
                    <option value="kecil">Aksi Kecil</option>
                    <option value="sedang">Aksi Sedang</option>
                    <option value="besar">Aksi Besar</option>
                </flux:select>

                <!-- Scope -->
                <flux:select wire:model="scope" :label="'Jangkauan'" required>
                    <option value="local">Lokal</option>
                    <option value="national">Nasional</option>
                    <option value="international">Internasional</option>
                </flux:select>

                <!-- Description -->
                <div class="md:col-span-2">
                    <flux:textarea
                        wire:model="description"
                        :label="'Deskripsi'"
                        required
                        :placeholder="'Jelaskan detail aksi kolektif yang akan dilakukan...'"
                        rows="4"
                    />
                </div>

                <!-- Goals -->
                <div class="md:col-span-2">
                    <flux:textarea
                        wire:model="goals"
                        :label="'Tujuan Aksi'"
                        required
                        :placeholder="'Apa yang ingin dicapai dari aksi kolektif ini?'"
                        rows="3"
                    />
                </div>
            </div>
        </div>

        <!-- Timeline & Location -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm"
            x-data="{
                map: null,
                marker: null,
                syncTimeout: null,
                latitude: @entangle('latitude').defer,
                longitude: @entangle('longitude').defer,
                location: @entangle('location').defer,
                searchResults: [],
                showSuggestions: false,
                isSearching: false,
                
                initializeMap() {
                    if (this.map) {
                        this.map.remove();
                    }

                    const defaultLat = this.latitude || -7.4292;
                    const defaultLng = this.longitude || 109.2290;

                    this.map = L.map(this.$refs.map).setView([defaultLat, defaultLng], 13);
                    this.map._loaded = true;

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(this.map);

                    this.marker = L.marker([defaultLat, defaultLng], {
                        draggable: true
                    }).addTo(this.map);

                    this.marker.on('dragend', () => {
                        const pos = this.marker.getLatLng();
                        this.latitude = pos.lat;
                        this.longitude = pos.lng;
                        this.syncToLivewire();
                        this.updateLocationFromCoordinates(pos.lat, pos.lng);
                    });

                    this.map.on('click', (e) => {
                        const pos = e.latlng;
                        this.marker.setLatLng(pos);
                        this.latitude = pos.lat;
                        this.longitude = pos.lng;
                        this.syncToLivewire();
                        this.updateLocationFromCoordinates(pos.lat, pos.lng);
                    });

                    setTimeout(() => {
                        if (this.map) {
                            this.map.invalidateSize();
                        }
                    }, 250);
                    
                    setTimeout(() => {
                        if (this.map) {
                            this.map.invalidateSize();
                        }
                    }, 500);
                },

                updateLocationFromCoordinates(lat, lng) {
                    this.location = 'Mengambil alamat...';
                    this.syncToLivewire();
                    
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&accept-language=id`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data && data.display_name) {
                                this.location = data.display_name;
                            } else {
                                this.location = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                            }
                            this.syncToLivewire();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Try alternative geocoding service as fallback
                            fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=id`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data && data.locality) {
                                        this.location = `${data.locality}, ${data.principalSubdivision}, ${data.countryName}`;
                                    } else {
                                        this.location = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                                    }
                                    this.syncToLivewire();
                                })
                                .catch(() => {
                                    this.location = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                                    this.syncToLivewire();
                                });
                        });
                },

                searchLocation(query) {
                    if (!query || query.length < 3) {
                        this.searchResults = [];
                        this.showSuggestions = false;
                        return;
                    }
                    
                    this.isSearching = true;
                    this.showSuggestions = true;
                    
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5&accept-language=id&addressdetails=1`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            this.isSearching = false;
                            if (data && data.length > 0) {
                                this.searchResults = data.map(item => ({
                                    name: item.display_name,
                                    lat: parseFloat(item.lat),
                                    lon: parseFloat(item.lon)
                                }));
                            } else {
                                this.searchResults = [{
                                    name: 'Lokasi tidak ditemukan',
                                    lat: null,
                                    lon: null
                                }];
                            }
                        })
                        .catch(error => {
                            console.log('Error searching location:', error);
                            this.isSearching = false;
                            this.searchResults = [{
                                name: 'Gagal mencari lokasi',
                                lat: null,
                                lon: null
                            }];
                        });
                },

                selectLocation(result) {
                    if (result.lat && result.lon) {
                        this.location = result.name;
                        this.latitude = result.lat;
                        this.longitude = result.lon;
                        
                        // Update map
                        this.marker.setLatLng([result.lat, result.lon]);
                        this.map.setView([result.lat, result.lon], 16);
                        
                        // Sync to Livewire
                        this.syncToLivewire();
                    }
                    
                    // Hide suggestions
                    this.showSuggestions = false;
                    this.searchResults = [];
                },

                updateMarker() {
                    if (this.map && this.marker && this.latitude && this.longitude) {
                        const newLatLng = L.latLng(this.latitude, this.longitude);
                        this.marker.setLatLng(newLatLng);
                        this.map.setView(newLatLng, this.map.getZoom());
                    }
                },

                syncToLivewire() {
                    clearTimeout(this.syncTimeout);
                    this.syncTimeout = setTimeout(() => {
                        if (this.latitude && this.longitude) {
                            @this.call('setCoordinates', {
                                latitude: this.latitude,
                                longitude: this.longitude
                            });
                        }
                        if (this.location) {
                            @this.call('setLocation', {
                                location: this.location
                            });
                        }
                    }, 300);
                },

                init() {
                    this.initializeMap();
                    
                    this.$watch('latitude', (newVal, oldVal) => {
                        if (newVal !== oldVal && this.map && this.marker && newVal && oldVal) {
                            this.updateMarker();
                        }
                    });
                    
                    this.$watch('longitude', (newVal, oldVal) => {
                        if (newVal !== oldVal && this.map && this.marker && newVal && oldVal) {
                            this.updateMarker();
                        }
                    });
                    
                    this.$watch('location', (newVal, oldVal) => {
                        if (newVal !== oldVal && newVal && oldVal) {
                            if (!newVal.includes('Mengambil alamat...') && !newVal.includes('Mencari lokasi...')) {
                                this.syncToLivewire();
                            }
                        }
                    });
                }
            }"
        >
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Waktu dan Tempat
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input
                    wire:model="start_date"
                    :label="'Tanggal Mulai'"
                    type="date"
                    required
                />

                <flux:input
                    wire:model="end_date"
                    :label="'Tanggal Selesai'"
                    type="date"
                    required
                />

                <div class="md:col-span-2">
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Lokasi (Opsional)
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="location" 
                            name="location" 
                            wire:model="location" 
                            x-model="location"
                            @input.debounce.500ms="searchLocation($event.target.value)"
                            @focus="if(searchResults.length > 0) showSuggestions = true"
                            @blur="setTimeout(() => showSuggestions = false, 200)"
                            placeholder="Contoh: Jakarta, Bandung, atau Online - ketik untuk mencari"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <div x-show="isSearching" class="animate-spin">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <svg x-show="!isSearching" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <!-- Search Results Dropdown -->
                        <div x-show="showSuggestions && searchResults.length > 0" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            <template x-for="(result, index) in searchResults" :key="index">
                                <div @click="selectLocation(result)" 
                                     class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-b-0"
                                     :class="{'text-gray-400 cursor-not-allowed': !result.lat}">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="text-sm text-gray-900 dark:text-white truncate" x-text="result.name"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Ketik nama tempat untuk mencari lokasi, atau gunakan map di bawah untuk memilih lokasi yang tepat (opsional)
                    </p>
                    @error('location') 
                        <span class="text-red-500 text-sm flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </span> 
                    @enderror
                </div>

                <!-- Map Section -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pilih Lokasi di Map (Opsional)
                    </label>
                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden" wire:ignore>
                        <div x-ref="map" style="height: 300px; width: 100%;"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Klik atau drag marker pada map untuk menentukan lokasi yang lebih spesifik
                    </p>
                </div>
            </div>
        </div>

        <!-- Required Resources -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Sumber Daya yang Dibutuhkan
            </h2>
            
            <!-- Predefined Resources -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Sumber Daya yang Diperlukan <span class="text-red-500">*</span>
                </label>
                <div class="mb-6">
                    <div x-data="{
                        open: false,
                        search: '',
                        selectedItems: @entangle('required_resources').live,
                        mainInput: '',
                        isProcessing: false,
                        updateMainInput() {
                            this.mainInput = this.selectedItems.map(id =>
                                document.getElementById('resource_label_' + id)?.textContent || ''
                            ).filter(Boolean).join(', ');
                        },
                        async toggleItem(id) {
                            if (this.isProcessing) return;
                            this.isProcessing = true;
                            try {
                                await $wire.toggleResource(id);
                                this.updateMainInput();
                            } finally {
                                this.isProcessing = false;
                            }
                        }
                    }" x-init="updateMainInput()" @click.away="open = false"
                        class="multi-select-container relative">
                        <!-- Main Selector Input -->
                        <div class="relative">
                            <input type="text" x-model="mainInput" placeholder="Pilih sumber daya yang diperlukan..."
                                class="w-full pl-10 pr-12 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 cursor-pointer transition-all duration-200"
                                readonly @click="open = !open">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Dropdown Panel -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="absolute left-0 right-0 z-10 mt-2">
                            <!-- Search Input -->
                            <div class="relative">
                                <input type="text" wire:model.live="resourceSearch" placeholder="Cari sumber daya..."
                                    class="w-full pl-10 pr-4 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 shadow-sm"
                                    @click.stop>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Dropdown List -->
                            <div
                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @foreach ($this->getFilteredResources() as $key => $label)
                                    <div class="multi-option {{ in_array($key, is_array($required_resources) ? $required_resources : []) ? 'bg-blue-50 dark:bg-blue-900/20' : '' }} px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-all duration-200"
                                        @click.stop="toggleItem('{{ $key }}')">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center justify-center w-5 h-5">
                                                    <input type="checkbox" id="resource_{{ $key }}"
                                                        :checked="selectedItems.includes('{{ $key }}')"
                                                        @click.stop="toggleItem('{{ $key }}')"
                                                        class="h-4 w-4 text-blue-600 focus:ring-2 focus:ring-blue-500/20 border-gray-300 dark:border-gray-600 rounded transition-colors duration-200">
                                                </div>
                                                <div>
                                                    <span id="resource_label_{{ $key }}"
                                                        class="font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                        Pilih untuk menambahkan ke daftar sumber daya</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center"
                                                x-show="selectedItems.includes('{{ $key }}')">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                    Terpilih
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($this->getFilteredResources()->isEmpty())
                                    <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                                        Tidak ada hasil yang ditemukan
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Selected Resources Display -->
                    @if (count($required_resources) > 0)
                        <div class="mt-4 border-t border-gray-100 dark:border-gray-700 pt-4">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Sumber Daya yang Dipilih:
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($required_resources as $key)
                                    @if (isset($resourceTypes[$key]))
                                        <div
                                            class="group inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-700 transition-all duration-200 hover:bg-blue-100 dark:hover:bg-blue-900/30">
                                            <svg class="w-4 h-4 mr-1.5 text-blue-500 dark:text-blue-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                            <span>{{ $resourceTypes[$key] }}</span>
                                            <button type="button" wire:click="removeResource('{{ $key }}')"
                                                class="ml-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @error('required_resources')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>

                <!-- Custom Resources -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Atau tambahkan sumber daya custom:</h3>
                        <flux:button 
                            type="button" 
                            wire:click="addCustomResource"
                            variant="outline" 
                            size="sm"
                            class="text-primary-blue hover:bg-primary-blue/10"
                        >
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Custom
                        </flux:button>
                    </div>
                    
                    @if(count($custom_resources) > 0)
                        <div class="space-y-3">
                            @foreach($custom_resources as $index => $customResource)
                                <div class="flex items-center gap-3">
                                    <flux:input
                                        wire:model="custom_resources.{{ $index }}"
                                        :placeholder="'Masukkan sumber daya custom...'"
                                        class="flex-1"
                                    />
                                    <flux:button 
                                        type="button" 
                                        wire:click="removeCustomResource({{ $index }})"
                                        variant="outline" 
                                        size="sm"
                                        class="text-accent-red hover:bg-accent-red/10"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </flux:button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                            Klik "Tambah Custom" untuk menambahkan sumber daya yang tidak ada dalam daftar
                        </p>
                    @endif
                </div>
            </div>

            <!-- Invite Ecosystems -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Undang Ekosistem untuk Berkolaborasi
                </h2>

                @if($availableEcosystems->count() > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pilih Ekosistem <span class="text-red-500">*</span>
                        </label>
                        <div class="mb-6">
                            <div x-data="{
                                open: false,
                                search: '',
                                selectedItems: @entangle('invited_ecosystems').live,
                                mainInput: '',
                                isProcessing: false,
                                updateMainInput() {
                                    this.mainInput = this.selectedItems.map(id =>
                                        document.getElementById('ecosystem_label_' + id)?.textContent || ''
                                    ).filter(Boolean).join(', ');
                                },
                                async toggleItem(id) {
                                    if (this.isProcessing) return;
                                    this.isProcessing = true;
                                    try {
                                        await $wire.toggleEcosystem(id);
                                        this.updateMainInput();
                                    } finally {
                                        this.isProcessing = false;
                                    }
                                }
                            }" x-init="updateMainInput()" @click.away="open = false"
                                class="multi-select-container relative">
                                <!-- Main Selector Input -->
                                <div class="relative">
                                    <input type="text" x-model="mainInput" placeholder="Pilih ekosistem untuk diundang..."
                                        class="w-full pl-10 pr-12 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 cursor-pointer transition-all duration-200"
                                        readonly @click="open = !open">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Dropdown Panel -->
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    class="absolute left-0 right-0 z-10 mt-2">
                                    <!-- Search Input -->
                                    <div class="relative">
                                        <input type="text" wire:model.live="ecosystemSearch" placeholder="Cari ekosistem..."
                                            class="w-full pl-10 pr-4 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 shadow-sm"
                                            @click.stop>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Dropdown List -->
                                    <div
                                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                        @foreach ($this->getFilteredEcosystems() as $ecosystem)
                                            <div class="multi-option {{ in_array($ecosystem->id, is_array($invited_ecosystems) ? $invited_ecosystems : []) ? 'bg-green-50 dark:bg-green-900/20' : '' }} px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-all duration-200"
                                                @click.stop="toggleItem({{ $ecosystem->id }})">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="flex items-center justify-center w-5 h-5">
                                                            <input type="checkbox" id="ecosystem_{{ $ecosystem->id }}"
                                                                :checked="selectedItems.includes({{ $ecosystem->id }})"
                                                                @click.stop="toggleItem({{ $ecosystem->id }})"
                                                                class="h-4 w-4 text-green-600 focus:ring-2 focus:ring-green-500/20 border-gray-300 dark:border-gray-600 rounded transition-colors duration-200">
                                                        </div>
                                                        <div>
                                                            <span id="ecosystem_label_{{ $ecosystem->id }}"
                                                                class="font-medium text-gray-700 dark:text-gray-300">{{ $ecosystem->ecosystem_title }}</span>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                {{ $ecosystem->organization_name }} • {{ $ecosystem->work_region }}
                                                            </p>
                                                            @if($ecosystem->description)
                                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">
                                                                    {{ $ecosystem->description }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center"
                                                        x-show="selectedItems.includes({{ $ecosystem->id }})">
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                            Terpilih
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($this->getFilteredEcosystems()->isEmpty())
                                            <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                                                Tidak ada hasil yang ditemukan
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Ecosystems Display -->
                            @if (count($invited_ecosystems) > 0)
                                <div class="mt-4 border-t border-gray-100 dark:border-gray-700 pt-4">
                                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Ekosistem yang Dipilih:
                                    </h3>
                                    <div class="space-y-4">
                                        @foreach ($invited_ecosystems as $ecosystemId)
                                            @php
                                                $ecosystem = $availableEcosystems->firstWhere('id', $ecosystemId);
                                            @endphp
                                            @if ($ecosystem)
                                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                                    <div class="flex items-start justify-between">
                                                        <div class="flex-1">
                                                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                                                {{ $ecosystem->ecosystem_title }}
                                                            </h4>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                {{ $ecosystem->organization_name }} • {{ $ecosystem->work_region }}
                                                            </p>
                                                        </div>
                                                        <button type="button" wire:click="removeEcosystem({{ $ecosystemId }})"
                                                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="mt-3">
                                                        <flux:textarea
                                                            wire:model="invitation_messages.{{ $ecosystemId }}"
                                                            :label="'Pesan Undangan (Opsional)'"
                                                            :placeholder="'Tulis pesan personal untuk mengundang ekosistem ini...'"
                                                            rows="2"
                                                        />
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @error('invited_ecosystems')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </div>
                    </div>

                    @if($availableEcosystems->count() < 2)
                        <div class="mt-4 p-4 bg-neutral-orange/10 dark:bg-neutral-orange/20 border border-neutral-orange/20 dark:border-neutral-orange/30 rounded-lg">
                            <p class="text-neutral-orange dark:text-neutral-orange text-sm">
                                Tersedia {{ $availableEcosystems->count() }} ekosistem untuk diundang. Anda memerlukan minimal 2 ekosistem lain untuk berkolaborasi.
                            </p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-6">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            Belum Ada Ekosistem Tersedia
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Saat ini belum ada ekosistem lain yang dapat diundang untuk berkolaborasi.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Collaboration Terms -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Syarat Kolaborasi
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input
                        wire:model="min_ecosystems"
                        :label="'Minimal Ekosistem yang Diperlukan'"
                        type="number"
                        min="3"
                        required
                    />
                    
                    <div></div>
                    
                    <div class="md:col-span-2">
                        <flux:textarea
                            wire:model="collaboration_terms"
                            :label="'Syarat dan Ketentuan Kolaborasi'"
                            required
                            :placeholder="'Tuliskan syarat dan ketentuan untuk berkolaborasi dalam aksi ini...'"
                            rows="4"
                        />
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3">
                @if($availableEcosystems->count() >= 2)
                    <flux:button 
                        type="submit" 
                        variant="primary" 
                        class="flex-1 bg-primary-blue hover:bg-primary-blue/90"
                        {{-- :loading="$wire.loading" --}}
                    >
                        Buat Aksi dan Kirim Undangan
                    </flux:button>
                @else
                    <flux:button 
                        type="button" 
                        variant="outline" 
                        class="flex-1 text-gray-400 dark:text-gray-500"
                        disabled
                    >
                        Perlu Minimal 2 Ekosistem Lain
                    </flux:button>
                @endif
                
                <flux:button 
                    type="button" 
                    variant="outline"
                    onclick="window.history.back()"
                >
                    Batal
                </flux:button>
            </div>
    </form>
</div>