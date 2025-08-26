<div class="max-w-2xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="mb-6">
        <h1 class="text-3xl font-bold">Buat Event Baru</h1>
    </div>

        <form wire:submit.prevent="save" class="space-y-6" id="eventForm" 
            x-data="{
                map: null,
                marker: null,
                latitude: @entangle('latitude').defer,
                longitude: @entangle('longitude').defer,

                initializeMap() {
                    if (this.map) {
                        this.map.remove();
                    }

                    const defaultLat = this.latitude || -7.4292;
                    const defaultLng = this.longitude || 109.2290;

                    // Initialize map
                    this.map = L.map(this.$refs.map).setView([defaultLat, defaultLng], 13);

                    // Add tile layer
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(this.map);

                    // Add marker
                    this.marker = L.marker([defaultLat, defaultLng], {
                        draggable: true
                    }).addTo(this.map);

                    // Handle marker drag
                    this.marker.on('dragend', () => {
                        const pos = this.marker.getLatLng();
                        this.latitude = pos.lat;
                        this.longitude = pos.lng;
                    });

                    // Update map size
                    setTimeout(() => this.map.invalidateSize(), 250);
                },
        
        init() {
            this.initializeMap();
            this.$watch('latitude', () => this.updateMarker());
            this.$watch('longitude', () => this.updateMarker());

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
        }
    }">
        <div>
            <label for="banner" class="block text-sm font-medium text-gray-700">Event Banner</label>
            <div class="mt-1">
                <input type="file" name="banner" id="banner" wire:model="banner" accept="image/*"
                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                <div wire:loading wire:target="banner">
                    <span class="text-sm text-gray-500">Uploading...</span>
                </div>
                @if($banner)
                    <div class="mt-2">
                        <img src="{{ $banner->temporaryUrl() }}" alt="Banner Preview" class="h-32 w-full object-cover rounded-lg">
                    </div>
                @endif
            </div>
            @error('banner') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title Event</label>
            <div class="mt-1">
                <input type="text" name="title" id="title" wire:model="title"
                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
            <div x-ref="map" class="h-96 mb-4"></div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                    <input type="text" id="latitude" name="latitude" x-model="latitude" readonly
                           class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('latitude') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                    <input type="text" id="longitude" name="longitude" x-model="longitude" readonly
                           class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('longitude') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <div class="mt-1">
                <textarea id="description" name="description" rows="3" wire:model="description"
                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <div class="mt-1">
                        <input type="datetime-local" name="start_date" id="start_date" wire:model="start_date"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                    @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <div class="mt-1">
                        <input type="datetime-local" name="end_date" id="end_date" wire:model="end_date"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                    @error('end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>        <div>
            <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Create Event
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('eventMap', () => ({
                map: null,
                marker: null,
                latitude: @entangle('latitude').defer,
                longitude: @entangle('longitude').defer,
                location: @entangle('location').defer,
                
                init() {
                    this.$nextTick(() => {
                        // Default coordinates (Banyumas)
                        const defaultLat = this.latitude || -7.4292;
                        const defaultLng = this.longitude || 109.2290;

                        // Initialize map
                        this.map = L.map(this.$refs.map).setView([defaultLat, defaultLng], 13);

                        // Add tile layer
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(this.map);

                        // Add marker
                        this.marker = L.marker([defaultLat, defaultLng], {
                            draggable: true
                        }).addTo(this.map);

                        // Handle marker drag
                        this.marker.on('dragend', () => {
                            const pos = this.marker.getLatLng();
                            this.updateLocation(pos.lat, pos.lng);
                        });

                        // Update map size
                        setTimeout(() => this.map.invalidateSize(), 250);
                    });
                },

                updateLocation(lat, lng) {
                    this.latitude = lat;
                    this.longitude = lng;

                    // Reverse geocoding
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.display_name) {
                                this.locationInput = data.display_name;
                            }
                        });
                },

                searchLocation(query) {
                    if (!query) return;

                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                const lat = parseFloat(data[0].lat);
                                const lon = parseFloat(data[0].lon);

                                this.marker.setLatLng([lat, lon]);
                                this.map.setView([lat, lon], 13);
                                this.updateLocation(lat, lon);
                            }
                        });
                }
            }));
        });

        function initializeMap() {
            if (eventMap) {
                eventMap.remove();
            }

            // Get saved coordinates or use defaults
            const lat = @this.get('latitude') || -7.4292;
            const lng = @this.get('longitude') || 109.2290;
            
            // Initialize map
            eventMap = L.map('map').setView([lat, lng], 13);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(eventMap);

            // Add draggable marker
            eventMarker = L.marker([lat, lng], {
                draggable: true
            }).addTo(eventMap);

            // Update coordinates when marker is dragged
            eventMarker.on('dragend', function(e) {
                const position = eventMarker.getLatLng();
                
                // Update Livewire properties
                @this.$set('latitude', position.lat);
                @this.$set('longitude', position.lng);
                
                // Reverse geocoding to get address
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.lat}&lon=${position.lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            @this.$set('location', data.display_name);
                        }
                    });
            });

            // Force map to recalculate its container size
            setTimeout(() => {
                eventMap.invalidateSize();
            }, 250);
        }

        // Initialize map when component is ready
        document.addEventListener('livewire:initialized', () => {
            initializeMap();
        });

        // Re-initialize map when Livewire updates
        document.addEventListener('livewire:navigated', () => {
            initializeMap();
        });

        // Handle location input changes
        @this.on('location-changed', (location) => {
            if (location && eventMap && eventMarker) {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(location)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            
                            eventMarker.setLatLng([lat, lon]);
                            eventMap.setView([lat, lon], 13);
                            
                            @this.$set('latitude', lat);
                            @this.$set('longitude', lon);
                        }
                    });
            }
        });
    </script>
</div>v>
    {{-- Do your work, then step back. --}}
</div>
