@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const defaultLat = -6.200000;
            const defaultLng = 106.816666;
            
            // Initialize map
            const map = L.map('map').setView([defaultLat, defaultLng], 13);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add marker
            let marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            // Update coordinates when marker is dragged
            marker.on('dragend', function(e) {
                const position = marker.getLatLng();
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
                
                // Trigger Livewire update
                @this.set('latitude', position.lat);
                @this.set('longitude', position.lng);
                
                // Reverse geocoding to get address
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.lat}&lon=${position.lng}`)
                    .then(response => response.json())
                    .then(data => {
                        @this.set('location', data.display_name);
                    });
            });

            // Update marker when location is entered
            Livewire.on('updateMap', (data) => {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(data.location)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            
                            marker.setLatLng([lat, lon]);
                            map.setView([lat, lon], 13);
                            
                            @this.set('latitude', lat);
                            @this.set('longitude', lon);
                        }
                    });
            });

            // Listen for location input changes
            let timeoutId;
            @this.on('location-changed', (location) => {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    Livewire.dispatch('updateMap', { location });
                }, 500);
            });
        });
    </script>
@endpush
