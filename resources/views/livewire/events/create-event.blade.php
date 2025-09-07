@php
    $userActionsEnabled = \App\Models\SystemSetting::isUserActionsEnabled();
    $isSuperAdmin = auth()->user()->isSuperAdmin();
    $isFormDisabled = !$userActionsEnabled && !$isSuperAdmin;
@endphp

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-8 px-4 sm:px-6 lg:px-8 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-24 h-24" opacity="opacity-10" />
    <x-svg-accent position="center-right" size="w-20 h-20" opacity="opacity-10" />
    <x-svg-accent position="bottom-left" size="w-16 h-16" opacity="opacity-10" />
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Header Section -->
    <div class="max-w-4xl mx-auto mb-8">
        <div class="text-center">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 dark:from-indigo-400 dark:to-purple-500 rounded-full mb-4">
                <svg class="w-8 h-8 text-white dark:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">
                Buat Aksi Baru
            </h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-slate-400">Bagikan ide dan inspirasi Anda dengan komunitas</p>
        </div>
    </div>

    <!-- Feature Disabled Message -->
    @if($isFormDisabled)
        <div class="max-w-4xl mx-auto mb-8">
            <div class="p-6 bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border border-red-200 dark:border-red-800 rounded-xl shadow-lg dark:shadow-slate-900/50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-red-800 dark:text-red-300 mb-2">
                            Fitur Aksi Pengguna Dinonaktifkan
                        </h3>
                        <p class="text-red-700 dark:text-red-400 mb-4">
                            Fitur aksi pengguna (event) sedang dinonaktifkan oleh administrator. Silakan hubungi administrator untuk informasi lebih lanjut.
                        </p>
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 dark:bg-red-500 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Form -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl dark:shadow-slate-900/50 border border-gray-100 dark:border-slate-700 overflow-hidden relative {{ $isFormDisabled ? 'opacity-60 pointer-events-none' : '' }}">
            <!-- SVG Accent for Form Container -->
            <x-svg-accent position="top-right" size="w-12 h-12" opacity="opacity-5" />
            
            @if($isFormDisabled)
                <!-- Disabled Overlay -->
                <div class="absolute inset-0 bg-gray-100/80 dark:bg-slate-900/80 rounded-2xl flex items-center justify-center z-10">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-2">Form Dinonaktifkan</h3>
                        <p class="text-gray-500 dark:text-slate-400 text-sm">Fitur aksi pengguna sedang dinonaktifkan</p>
                    </div>
                </div>
            @endif
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 dark:from-indigo-400 dark:to-purple-500 px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 dark:bg-slate-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white dark:text-slate-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-white dark:text-slate-100">Formulir Aksi</h2>
                        <p class="text-indigo-100 dark:text-slate-300 text-sm">Lengkapi informasi aksi Anda</p>
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="save" class="p-6 space-y-8" id="eventForm" 
                x-ref="form"
                x-data="{
                    map: null,
                    marker: null,
                    syncTimeout: null,
                    latitude: @entangle('latitude').defer,
                    longitude: @entangle('longitude').defer,
                    location: @entangle('location').defer,
                    
                    preventEnterSubmit(e) {
                        if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                            e.preventDefault();
                            return false;
                        }
                    },

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
                            // Sync coordinates immediately
                            this.syncToLivewire();
                            // Then get address
                            this.updateLocationFromCoordinates(pos.lat, pos.lng);
                        });

                        // Add click event to map for location selection
                        this.map.on('click', (e) => {
                            const pos = e.latlng;
                            this.marker.setLatLng(pos);
                            this.latitude = pos.lat;
                            this.longitude = pos.lng;
                            // Sync coordinates immediately
                            this.syncToLivewire();
                            // Then get address
                            this.updateLocationFromCoordinates(pos.lat, pos.lng);
                        });

                        // Ensure map is properly sized
                        setTimeout(() => {
                            if (this.map) {
                                this.map.invalidateSize();
                            }
                        }, 250);
                        
                        // Additional size check after a longer delay
                        setTimeout(() => {
                            if (this.map) {
                                this.map.invalidateSize();
                            }
                        }, 500);
                    },

                    updateLocationFromCoordinates(lat, lng) {
                        // Show loading state
                        this.location = 'Mengambil alamat...';
                        
                        // Reverse geocoding to get address from coordinates
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
                                } else if (data && data.address) {
                                    // Try to construct address from address components
                                    const address = data.address;
                                    let addressParts = [];
                                    
                                    if (address.road) addressParts.push(address.road);
                                    if (address.house_number) addressParts.push(address.house_number);
                                    if (address.suburb) addressParts.push(address.suburb);
                                    if (address.city) addressParts.push(address.city);
                                    if (address.state) addressParts.push(address.state);
                                    if (address.country) addressParts.push(address.country);
                                    
                                    if (addressParts.length > 0) {
                                        this.location = addressParts.join(', ');
                                    } else {
                                        this.location = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                                    }
                                } else {
                                    this.location = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                                }
                                // Sync location to Livewire after getting address
                                this.syncToLivewire();
                            })
                            .catch(error => {
                                console.log('Error getting location:', error);
                                // Try alternative geocoding service as fallback
                                this.tryAlternativeGeocoding(lat, lng);
                            });
                    },

                    tryAlternativeGeocoding(lat, lng) {
                        // Try using Google Geocoding API as fallback (if available)
                        // For now, use a simple coordinate format
                        this.location = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                        
                        // You can add alternative geocoding services here
                        // For example, using a different Nominatim endpoint or other services
                        
                        // Sync location to Livewire
                        this.syncToLivewire();
                    },

                    syncToLivewire() {
                        // Sync Alpine.js data to Livewire component with debounce
                        clearTimeout(this.syncTimeout);
                        this.syncTimeout = setTimeout(() => {
                            if (this.latitude && this.longitude) {
                                @this.set('latitude', this.latitude);
                                @this.set('longitude', this.longitude);
                            }
                            if (this.location && !this.location.includes('Mengambil alamat...') && !this.location.includes('Mencari lokasi...')) {
                                @this.set('location', this.location);
                            }
                        }, 300);
                    },
            
                    init() {
                        this.initializeMap();
                        
                        // Prevent form submission on Enter key
                        this.$refs.form.addEventListener('keydown', this.preventEnterSubmit);
                        
                        // Watch for changes in coordinates and update map accordingly
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
                        
                        // Watch for location changes to sync with Livewire
                        this.$watch('location', (newVal, oldVal) => {
                            if (newVal !== oldVal && newVal && oldVal) {
                                // Only sync if it's not a loading state
                                if (!newVal.includes('Mengambil alamat...') && !newVal.includes('Mencari lokasi...')) {
                                    this.syncToLivewire();
                                }
                            }
                        });

                        // Listen for Livewire events to refresh map
                        Livewire.on('refresh-map', () => {
                            this.$nextTick(() => {
                                setTimeout(() => {
                                    this.initializeMap();
                                }, 100);
                            });
                        });
                        
                        // Prevent map from disappearing during form interactions
                        document.addEventListener('livewire:load', () => {
                            // Ensure map stays visible during Livewire updates
                            Livewire.hook('message.processed', (message, component) => {
                                if (this.map && !this.map._loaded) {
                                    setTimeout(() => {
                                        this.map.invalidateSize();
                                    }, 50);
                                }
                            });
                            
                            // Additional protection against map disappearing
                            Livewire.hook('message.sent', (message, component) => {
                                // Store map state before Livewire update
                                if (this.map) {
                                    this.map._lastView = this.map.getCenter();
                                    this.map._lastZoom = this.map.getZoom();
                                }
                            });
                            
                            Livewire.hook('message.processed', (message, component) => {
                                // Restore map state after Livewire update
                                if (this.map && this.map._lastView) {
                                    setTimeout(() => {
                                        if (this.map && !this.map._loaded) {
                                            this.map.setView(this.map._lastView, this.map._lastZoom);
                                            this.map.invalidateSize();
                                        }
                                    }, 100);
                                }
                            });
                        });
                        
                        // Additional protection: prevent map from being destroyed
                        window.addEventListener('beforeunload', () => {
                            if (this.map) {
                                this.map._loaded = false;
                            }
                        });
                        
                        // Re-initialize map if it gets destroyed
                        this.$watch('map', (newVal, oldVal) => {
                            if (oldVal && !newVal) {
                                // Map was destroyed, re-initialize
                                setTimeout(() => {
                                    this.initializeMap();
                                }, 200);
                            }
                        });
                    },

                    updateMarker() {
                        if (this.map && this.marker && this.latitude && this.longitude) {
                            const lat = parseFloat(this.latitude);
                            const lng = parseFloat(this.longitude);
                            
                            if (!isNaN(lat) && !isNaN(lng)) {
                                this.marker.setLatLng([lat, lng]);
                                this.map.setView([lat, lng]);
                                
                                // Ensure map is properly sized after view change
                                setTimeout(() => {
                                    if (this.map) {
                                        this.map.invalidateSize();
                                    }
                                }, 100);
                            }
                        }
                    },

                    searchLocation(query) {
                        if (!query || query.length < 3) return;
                        
                        // Show loading state
                        this.location = 'Mencari lokasi...';
                        
                        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&accept-language=id&addressdetails=1`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data && data.length > 0) {
                                    const result = data[0];
                                    const lat = parseFloat(result.lat);
                                    const lon = parseFloat(result.lon);
                                    
                                    if (!isNaN(lat) && !isNaN(lon)) {
                                        this.marker.setLatLng([lat, lon]);
                                        this.map.setView([lat, lon], 16);
                                        this.latitude = lat;
                                        this.longitude = lon;
                                        
                                        // Use display_name if available, otherwise construct from address
                                        if (result.display_name) {
                                            this.location = result.display_name;
                                        } else if (result.address) {
                                            const address = result.address;
                                            let addressParts = [];
                                            
                                            if (address.road) addressParts.push(address.road);
                                            if (address.house_number) addressParts.push(address.house_number);
                                            if (address.suburb) addressParts.push(address.suburb);
                                            if (address.city) addressParts.push(address.city);
                                            if (address.state) addressParts.push(address.state);
                                            if (address.country) addressParts.push(address.country);
                                            
                                            if (addressParts.length > 0) {
                                                this.location = addressParts.join(', ');
                                            } else {
                                                this.location = `Koordinat: ${lat.toFixed(6)}, ${lon.toFixed(6)}`;
                                            }
                                        } else {
                                            this.location = `Koordinat: ${lat.toFixed(6)}, ${lon.toFixed(6)}`;
                                        }
                                        
                                        // Sync to Livewire after search
                                        this.syncToLivewire();
                                    } else {
                                        this.location = 'Koordinat tidak valid';
                                    }
                                } else {
                                    this.location = 'Lokasi tidak ditemukan';
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
                            class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-500 dark:from-pink-400 dark:to-rose-400 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white dark:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Aksi Banner</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">Upload gambar menarik untuk aksi Anda</p>
                        </div>
                    </div>

                    <div class="relative">
                        <div
                            class="border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-xl p-6 hover:border-indigo-400 dark:hover:border-indigo-500 transition-colors duration-200">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-slate-500" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="mt-4">
                                    <label for="banner" class="cursor-pointer">
                                        <span
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 dark:from-indigo-400 dark:to-purple-500 text-white text-sm font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 dark:hover:from-indigo-500 dark:hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-all duration-200">
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
                                <p class="mt-2 text-xs text-gray-500 dark:text-slate-400">PNG, JPG, GIF hingga 10MB</p>
                            </div>
                        </div>

                        <div wire:loading wire:target="banner"
                            class="absolute inset-0 bg-white/80 dark:bg-slate-800/80 rounded-xl flex items-center justify-center">
                            <div class="flex items-center space-x-2">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600 dark:border-indigo-400"></div>
                                <span class="text-indigo-600 dark:text-indigo-400 font-medium">Uploading...</span>
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
                        <span class="text-red-500 dark:text-red-400 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor"
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
                            class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 dark:from-yellow-400 dark:to-orange-400 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white dark:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Judul Aksi</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">Buat judul yang menarik dan mudah diingat</p>
                        </div>
                    </div>

                    <div class="relative">
                        <input type="text" name="title" id="title" wire:model="title"
                            placeholder="Contoh: Workshop Design Thinking untuk Startup"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-200 text-lg placeholder-gray-400 dark:placeholder-slate-500">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    @error('title')
                        <span class="text-red-500 dark:text-red-400 text-sm flex items-center"><svg class="w-4 h-4 mr-1"
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
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 dark:from-green-400 dark:to-emerald-400 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white dark:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Lokasi Aksi</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">Masukkan alamat atau pilih lokasi dengan peta interaktif</p>
                        </div>
                    </div>
                    
                    <!-- Location Input Field -->
                    <div class="space-y-3">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Alamat Lokasi</label>
                            <div class="relative">
                                <input type="text" id="location" name="location" wire:model="location" 
                                       placeholder="Contoh: Jl. Sudirman No. 123, Jakarta Pusat"
                                       x-model="location"
                                       @input.debounce.500ms="searchLocation($event.target.value)"
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-200 placeholder-gray-400 dark:placeholder-slate-500">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">Ketik nama tempat untuk mencari lokasi, atau gunakan peta di bawah</p>
                            @error('location') <span class="text-red-500 dark:text-red-400 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-slate-700 rounded-xl p-4">
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 dark:text-slate-300 mb-2">Atau pilih lokasi dengan peta (drag marker untuk mengubah koordinat):</p>
                            </div>
                            <div x-ref="map" class="h-80 rounded-lg overflow-hidden shadow-lg dark:shadow-slate-900/50 mb-4" wire:ignore></div>
                            <div class="grid grid-cols-2 hidden gap-4">
                                <div>
                                    <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Latitude</label>
                                    <input type="text" id="latitude" name="latitude" wire:model="latitude" readonly
                                           class="w-full px-3 py-2 bg-white dark:bg-slate-600 border border-gray-300 dark:border-slate-500 rounded-lg text-sm text-gray-600 dark:text-slate-300">
                                    @error('latitude') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" wire:model="longitude" readonly
                                           class="w-full px-3 py-2 bg-white dark:bg-slate-600 border border-gray-300 dark:border-slate-500 rounded-lg text-sm text-gray-600 dark:text-slate-300">
                                    @error('longitude') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 dark:from-blue-400 dark:to-cyan-400 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white dark:text-slate-900" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Deskripsi Aksi</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">Jelaskan detail dan tujuan aksi Anda</p>
                        </div>
                    </div>

                    <div class="relative">
                        <textarea id="description" name="description" rows="4" wire:model="description"
                            placeholder="Deskripsikan event Anda dengan detail, termasuk tujuan, target peserta, dan apa yang akan mereka dapatkan..."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-200 resize-none placeholder-gray-400 dark:placeholder-slate-500"></textarea>
                        <div class="absolute bottom-3 right-3 text-xs text-gray-400 dark:text-slate-500">
                            <span x-text="(description || '').length"></span>/500
                        </div>
                    </div>
                    @error('description')
                        <span class="text-red-500 dark:text-red-400 text-sm flex items-center"><svg class="w-4 h-4 mr-1"
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
                            class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 dark:from-purple-400 dark:to-pink-400 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white dark:text-slate-900" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Waktu Aksi</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">Tentukan kapan aksi akan berlangsung</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Mulai</label>
                            <div class="relative">
                                <input type="datetime-local" name="start_date" id="start_date"
                                    wire:model="start_date"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-200">
                            </div>
                            @error('start_date')
                                <span class="text-red-500 dark:text-red-400 text-sm flex items-center"><svg class="w-4 h-4 mr-1"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Selesai</label>
                            <div class="relative">
                                <input type="datetime-local" name="end_date" id="end_date" wire:model="end_date"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-200">
                            </div>
                            @error('end_date')
                                <span class="text-red-500 dark:text-red-400 text-sm flex items-center"><svg class="w-4 h-4 mr-1"
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
                        @if($isFormDisabled) disabled @endif
                        class="w-full group relative overflow-hidden font-semibold py-4 px-6 rounded-xl shadow-lg dark:shadow-slate-900/50 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 {{ $isFormDisabled ? 'bg-gray-400 dark:bg-slate-600 text-gray-200 dark:text-slate-400 cursor-not-allowed' : 'bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-500 dark:to-purple-500 text-white hover:from-indigo-700 hover:to-purple-700 dark:hover:from-indigo-600 dark:hover:to-purple-600 focus:ring-indigo-500 dark:focus:ring-indigo-400 transform hover:scale-[1.02]' }}">
                        @if(!$isFormDisabled)
                            <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        @endif
                        <div class="relative flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="text-lg">{{ $isFormDisabled ? 'Fitur Dinonaktifkan' : 'Buat Aksi Sekarang' }}</span>
                        </div>
                    </button>

                    <div wire:loading wire:target="save" class="mt-4 text-center">
                        <div class="inline-flex items-center space-x-2 text-indigo-600 dark:text-indigo-400">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-indigo-600 dark:border-indigo-400"></div>
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
            class="fixed bottom-4 right-4 bg-green-500 dark:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg dark:shadow-slate-900/50 transform transition-all duration-300 animate-bounce">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif
</div>
