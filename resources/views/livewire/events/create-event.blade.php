<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Header Section -->
    <div class="max-w-4xl mx-auto mb-8">
        <div class="text-center">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Buat Aksi Baru
            </h1>
            <p class="mt-2 text-lg text-gray-600">Bagikan ide dan inspirasi Anda dengan komunitas</p>
        </div>
    </div>

    <!-- Main Form -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-white">Formulir Aksi</h2>
                        <p class="text-indigo-100 text-sm">Lengkapi informasi aksi Anda</p>
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="save" class="p-6 space-y-8" id="eventForm" 
                x-data="{
                    map: null,
                    marker: null,
                    latitude: @entangle('latitude').defer,
                    longitude: @entangle('longitude').defer,
                    location: @entangle('location').defer,

                    initializeMap() {
                        if (this.map) {
                            this.map.remove();
                        }

                        const defaultLat = this.latitude || -7.4292;
                        const defaultLng = this.longitude || 109.2290;

                        this.map = L.map(this.$refs.map).setView([defaultLat, defaultLng], 13);

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
                            this.updateLocationFromCoordinates(pos.lat, pos.lng);
                        });

                        // Add click event to map for location selection
                        this.map.on('click', (e) => {
                            const pos = e.latlng;
                            this.marker.setLatLng(pos);
                            this.latitude = pos.lat;
                            this.longitude = pos.lng;
                            this.updateLocationFromCoordinates(pos.lat, pos.lng);
                        });

                        setTimeout(() => this.map.invalidateSize(), 250);
                    },

                    updateLocationFromCoordinates(lat, lng) {
                        // Show loading state
                        this.location = 'Mengambil alamat...';
                        
                        // Reverse geocoding to get address from coordinates
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&accept-language=id`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.display_name) {
                                    this.location = data.display_name;
                                } else {
                                    this.location = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                                }
                            })
                            .catch(error => {
                                console.log('Error getting location:', error);
                                this.location = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                            });
                    },
            
                    init() {
                        this.initializeMap();
                        this.$watch('latitude', () => {
                            this.updateMarker();
                            this.updateInputFields();
                        });
                        this.$watch('longitude', () => {
                            this.updateMarker();
                            this.updateInputFields();
                        });

                        Livewire.on('refresh-map', () => {
                            this.$nextTick(() => {
                                this.initializeMap();
                            });
                        });
                    },

                    updateMarker() {
                        if (this.map && this.marker) {
                            const lat = this.latitude || -7.4292;
                            const lng = this.longitude || 109.2290;
                            this.marker.setLatLng([lat, lng]);
                            this.map.setView([lat, lng]);
                        }
                    },

                    updateInputFields() {
                        // Update latitude and longitude input fields
                        if (this.map && this.marker) {
                            const lat = this.marker.getLatLng().lat;
                            const lng = this.marker.getLatLng().lng;
                            // Update Livewire properties directly
                            @this.set('latitude', lat);
                            @this.set('longitude', lng);
                        }
                    },

                    searchLocation(query) {
                        if (!query || query.length < 3) return;
                        
                        // Show loading state
                        this.location = 'Mencari lokasi...';
                        
                        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&accept-language=id`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    const lat = parseFloat(data[0].lat);
                                    const lon = parseFloat(data[0].lon);
                                    
                                    this.marker.setLatLng([lat, lon]);
                                    this.map.setView([lat, lon], 16);
                                    this.latitude = lat;
                                    this.longitude = lon;
                                    this.location = data[0].display_name;
                                }
                            })
                            .catch(error => {
                                console.log('Error searching location:', error);
                                this.location = 'Gagal mencari lokasi';
                            });
                    }
                }">

                <!-- Banner Section -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Aksi Banner</h3>
                            <p class="text-sm text-gray-500">Upload gambar menarik untuk aksi Anda</p>
                        </div>
                    </div>

                    <div class="relative">
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-indigo-400 transition-colors duration-200">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="mt-4">
                                    <label for="banner" class="cursor-pointer">
                                        <span
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                            </svg>
                                            Pilih Gambar
                                        </span>
                                    </label>
                                    <input type="file" name="banner" id="banner" wire:model="banner"
                                        accept="image/*" class="hidden">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">PNG, JPG, GIF hingga 10MB</p>
                            </div>
                        </div>

                        <div wire:loading wire:target="banner"
                            class="absolute inset-0 bg-white/80 rounded-xl flex items-center justify-center">
                            <div class="flex items-center space-x-2">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
                                <span class="text-indigo-600 font-medium">Uploading...</span>
                            </div>
                        </div>

                        @if ($banner)
                            <div class="mt-4 relative group">
                                <img src="{{ $banner->temporaryUrl() }}" alt="Banner Preview"
                                    class="w-full h-48 object-cover rounded-xl shadow-lg">
                                <div
                                    class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-xl flex items-center justify-center">
                                    <span class="text-white font-medium">Preview Banner</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    @error('banner')
                        <span class="text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Title Section -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Judul Aksi</h3>
                            <p class="text-sm text-gray-500">Buat judul yang menarik dan mudah diingat</p>
                        </div>
                    </div>

                    <div class="relative">
                        <input type="text" name="title" id="title" wire:model="title"
                            placeholder="Contoh: Workshop Design Thinking untuk Startup"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg placeholder-gray-400">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    @error('title')
                        <span class="text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Location Section -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Lokasi Aksi</h3>
                            <p class="text-sm text-gray-500">Masukkan alamat atau pilih lokasi dengan peta interaktif</p>
                        </div>
                    </div>
                    
                    <!-- Location Input Field -->
                    <div class="space-y-3">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lokasi</label>
                            <div class="relative">
                                <input type="text" id="location" name="location" wire:model="location" 
                                       placeholder="Contoh: Jl. Sudirman No. 123, Jakarta Pusat"
                                       x-model="location"
                                       @input.debounce.500ms="searchLocation($event.target.value)"
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Ketik nama tempat untuk mencari lokasi, atau gunakan peta di bawah</p>
                            @error('location') <span class="text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 mb-2">Atau pilih lokasi dengan peta (drag marker untuk mengubah koordinat):</p>
                            </div>
                            <div x-ref="map" class="h-80 rounded-lg overflow-hidden shadow-lg mb-4"></div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                                    <input type="text" id="latitude" name="latitude" wire:model="latitude" readonly
                                           class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600">
                                    @error('latitude') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" wire:model="longitude" readonly
                                           class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600">
                                    @error('longitude') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Deskripsi Aksi</h3>
                            <p class="text-sm text-gray-500">Jelaskan detail dan tujuan aksi Anda</p>
                        </div>
                    </div>

                    <div class="relative">
                        <textarea id="description" name="description" rows="4" wire:model="description"
                            placeholder="Deskripsikan event Anda dengan detail, termasuk tujuan, target peserta, dan apa yang akan mereka dapatkan..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 resize-none placeholder-gray-400"></textarea>
                        <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                            <span x-text="(description || '').length"></span>/500
                        </div>
                    </div>
                    @error('description')
                        <span class="text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Date & Time Section -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Waktu Aksi</h3>
                            <p class="text-sm text-gray-500">Tentukan kapan aksi akan berlangsung</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Mulai</label>
                            <div class="relative">
                                <input type="datetime-local" name="start_date" id="start_date"
                                    wire:model="start_date"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('start_date')
                                <span class="text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Selesai</label>
                            <div class="relative">
                                <input type="datetime-local" name="end_date" id="end_date" wire:model="end_date"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('end_date')
                                <span class="text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit"
                        class="w-full group relative overflow-hidden bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-[1.02] transition-all duration-200">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000">
                        </div>
                        <div class="relative flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="text-lg">Buat Aksi Sekarang</span>
                        </div>
                    </button>

                    <div wire:loading wire:target="save" class="mt-4 text-center">
                        <div class="inline-flex items-center space-x-2 text-indigo-600">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-indigo-600"></div>
                            <span class="font-medium">Menyimpan aksi...</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div
            class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 animate-bounce">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif
</div>
