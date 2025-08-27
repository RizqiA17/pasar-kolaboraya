<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    {{-- Event Banner with Overlay --}}
    <div class="relative mb-8 rounded-2xl overflow-hidden shadow-lg">
        @if($event->banner)
            <div class="relative h-80">
                <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->title }}" 
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            </div>
        @else
            <div class="h-80 bg-gradient-to-br from-sky-50 to-indigo-50 flex items-center justify-center">
                <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif

        {{-- Event Status Badge --}}
        <div class="absolute top-4 right-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium shadow-sm
                {{ $event->start_date->isPast()
                    ? ($event->end_date->isFuture()
                        ? 'bg-green-100 text-green-800'
                        : 'bg-gray-100 text-gray-800')
                    : 'bg-blue-100 text-blue-800' }}">
                @if ($event->start_date->isPast())
                    @if ($event->end_date->isFuture())
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            Sedang Berlangsung
                        </span>
                    @else
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Selesai
                        </span>
                    @endif
                @else
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        Akan Datang
                    </span>
                @endif
            </span>
        </div>
    </div>

    {{-- Event Header --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
            <div class="flex-1">
                <h1 class="text-3xl font-bold mb-3 text-gray-900">{{ $event->title }}</h1>
                <p class="text-gray-600 text-lg">{{ $event->description }}</p>
                
                <div class="mt-4 flex flex-wrap gap-4">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $event->start_date->format('d M Y H:i') }} - {{ $event->end_date->format('d M Y H:i') }}</span>
                    </div>

                    @if($event->location)
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $event->location }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex-shrink-0 w-full md:w-auto">
                @if(!$isParticipant)
                    <button wire:click="joinEvent" 
                        class="w-full md:w-auto bg-sky-500 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-sky-600 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Ikuti Event
                    </button>
                @else
                    <button wire:click="leaveEvent" 
                        class="w-full md:w-auto bg-red-500 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-red-600 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/>
                        </svg>
                        Batalkan Keikutsertaan
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Map --}}
    @if($event->latitude && $event->longitude)
        <div class="mb-8 rounded-xl overflow-hidden shadow-md">
            <div id="map" class="h-64"></div>
        </div>
        @push('scripts')
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                document.addEventListener('livewire:initialized', () => {
                    const map = L.map('map').setView([{{ $event->latitude }}, {{ $event->longitude }}], 15);
                    
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    L.marker([{{ $event->latitude }}, {{ $event->longitude }}])
                        .addTo(map)
                        .bindPopup("{{ $event->title }}");
                });
            </script>
        @endpush
        @push('styles')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        @endpush
    @endif

    {{-- Event Details --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Participants Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Peserta ({{ $event->participants->count() }})</h3>
                @if($event->participants->count() > 0)
                    <span class="text-sm text-gray-500">{{ $event->participants->count() }} orang bergabung</span>
                @endif
            </div>

            @if($event->participants->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($event->participants as $participant)
                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-50 to-indigo-50 border border-gray-100 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-600">{{ substr($participant->name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $participant->name }}</h4>
                                    <p class="text-sm text-gray-500">Bergabung {{ $participant->pivot->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500">Belum ada peserta yang bergabung</p>
                </div>
            @endif
        </div>

        {{-- Additional Info Section --}}
        <div class="space-y-6">
            {{-- Event Timeline --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline Event</h3>
                <div class="relative pl-8 space-y-6">
                    <div class="relative">
                        <div class="absolute -left-8 mt-1.5">
                            <div class="w-4 h-4 rounded-full bg-sky-500"></div>
                            <div class="absolute top-4 bottom-0 left-2 -ml-px w-0.5 bg-gray-200"></div>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Mulai Event</h4>
                            <p class="text-sm text-gray-500">{{ $event->start_date->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <div class="absolute -left-8 mt-1.5">
                            <div class="w-4 h-4 rounded-full {{ $event->end_date->isFuture() ? 'bg-gray-200' : 'bg-green-500' }}"></div>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Selesai Event</h4>
                            <p class="text-sm text-gray-500">{{ $event->end_date->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>