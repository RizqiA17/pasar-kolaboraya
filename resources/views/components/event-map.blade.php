@props(['event'])

@if($event->latitude && $event->longitude)
    <div class="mb-8">
        <div class="relative">
            {{-- Decorative Elements --}}
            <div class="absolute -top-4 -left-4 w-8 h-8 bg-gradient-to-br from-sky-400 to-indigo-500 rounded-full opacity-20"></div>
            <div class="absolute -bottom-4 -right-4 w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full opacity-20"></div>
            <div class="absolute top-1/2 -left-2 w-4 h-4 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full opacity-30"></div>
            
            {{-- Map Container with Organic Shape --}}
            <div class="relative">
                {{-- Main Map Container --}}
                <div class="relative overflow-hidden" style="clip-path: polygon(0% 0%, 95% 0%, 100% 5%, 100% 100%, 5% 100%, 0% 95%);">
                    <div id="event-map-{{ $event->id }}" class="h-80 w-full bg-gradient-to-br from-sky-50 to-indigo-50"></div>
                    
                    {{-- Map Overlay with Gradient --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-sky-500/10 to-indigo-500/10 pointer-events-none"></div>
                    
                    {{-- Location Info Overlay --}}
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm rounded-lg p-3 shadow-lg border border-white/20">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-sky-500 to-indigo-600 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Lokasi Event</p>
                                <p class="text-xs text-gray-600">{{ $event->location ?? 'Koordinat: ' . $event->latitude . ', ' . $event->longitude }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Decorative Border Elements --}}
                <div class="absolute inset-0 pointer-events-none" style="clip-path: polygon(0% 0%, 95% 0%, 100% 5%, 100% 100%, 5% 100%, 0% 95%);">
                    <div class="absolute top-0 left-0 w-16 h-1 bg-gradient-to-r from-sky-400 to-indigo-500"></div>
                    <div class="absolute top-0 right-0 w-1 h-16 bg-gradient-to-b from-indigo-500 to-purple-500"></div>
                    <div class="absolute bottom-0 left-0 w-1 h-16 bg-gradient-to-t from-sky-400 to-indigo-500"></div>
                    <div class="absolute bottom-0 right-0 w-16 h-1 bg-gradient-to-l from-purple-500 to-indigo-500"></div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
        <script>
            // Load Leaflet dynamically if not already loaded
            function loadLeaflet() {
                return new Promise((resolve, reject) => {
                    if (window.L) {
                        resolve(window.L);
                        return;
                    }
                    
                    // Load CSS
                    if (!document.querySelector('link[href*="leaflet.css"]')) {
                        const link = document.createElement('link');
                        link.rel = 'stylesheet';
                        link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                        document.head.appendChild(link);
                    }
                    
                    // Load JavaScript
                    const script = document.createElement('script');
                    script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                    script.onload = () => resolve(window.L);
                    script.onerror = reject;
                    document.head.appendChild(script);
                });
            }
            
            // Initialize map
            async function initializeMap() {
                try {
                    const L = await loadLeaflet();
                    
                    const mapId = 'event-map-{{ $event->id }}';
                    const mapContainer = document.getElementById(mapId);
                    
                    if (!mapContainer) {
                        console.error('Map container not found:', mapId);
                        return;
                    }

                    // Initialize map with event coordinates
                    const eventMap = L.map(mapId).setView([{{ $event->latitude }}, {{ $event->longitude }}], 15);
                    
                    // Add OpenStreetMap tiles
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(eventMap);

                    // Custom marker icon
                    const customIcon = L.divIcon({
                        className: 'custom-marker',
                        html: `
                            <div class="relative">
                                <div class="w-8 h-8 bg-gradient-to-br from-sky-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg border-2 border-white">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-sky-500"></div>
                            </div>
                        `,
                        iconSize: [32, 32],
                        iconAnchor: [16, 32],
                        popupAnchor: [0, -32]
                    });

                    // Add custom marker
                    const marker = L.marker([{{ $event->latitude }}, {{ $event->longitude }}], { icon: customIcon })
                        .addTo(eventMap)
                        .bindPopup(`
                            <div class="text-center p-2">
                                <div class="w-12 h-12 mx-auto mb-3 bg-gradient-to-br from-sky-100 to-indigo-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2"/>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">{{ $event->title }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $event->location ?? 'Koordinat: ' . $event->latitude . ', ' . $event->longitude }}</p>
                                <div class="space-y-1 text-xs text-gray-500">
                                    <p>📅 Mulai: {{ $event->start_date->format('d M Y H:i') }}</p>
                                    <p>⏰ Selesai: {{ $event->end_date->format('d M Y H:i') }}</p>
                                    <p>👥 Peserta: {{ $event->participants->count() }} orang</p>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <button onclick="window.location.href='{{ route('events.show', $event) }}'" 
                                            class="w-full bg-sky-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-sky-600 transition-colors">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        `);

                    // Add a subtle circle around the marker
                    L.circle([{{ $event->latitude }}, {{ $event->longitude }}], {
                        color: '#3b82f6',
                        fillColor: '#3b82f6',
                        fillOpacity: 0.1,
                        radius: 200
                    }).addTo(eventMap);

                    // Fit map to show the marker and circle
                    eventMap.fitBounds(marker.getBounds().pad(0.1));

                    // Force map refresh
                    setTimeout(() => {
                        eventMap.invalidateSize();
                    }, 100);
                    
                } catch (error) {
                    console.error('Error initializing map:', error);
                }
            }
            
            // Initialize when Livewire is ready
            document.addEventListener('livewire:initialized', () => {
                setTimeout(initializeMap, 100);
            });
            
            // Also try to initialize if Livewire is already ready
            if (document.readyState === 'complete') {
                setTimeout(initializeMap, 100);
            }
        </script>
    @endpush
    
    @push('styles')
        <style>
            .custom-marker {
                background: transparent;
                border: none;
            }
            
            .leaflet-popup-content-wrapper {
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }
            
            .leaflet-popup-tip {
                background: white;
            }
            
            .leaflet-control-attribution {
                background: rgba(255, 255, 255, 0.8);
                border-radius: 8px;
                padding: 4px 8px;
                font-size: 11px;
            }
            
            /* Ensure map container is visible */
            #event-map-{{ $event->id }} {
                min-height: 320px;
                width: 100%;
                z-index: 1;
            }
            
            /* Fix for Leaflet map tiles */
            .leaflet-tile {
                filter: none;
            }
            
            /* Ensure proper map rendering */
            .leaflet-container {
                background: #f8fafc;
            }
        </style>
    @endpush
@endif
