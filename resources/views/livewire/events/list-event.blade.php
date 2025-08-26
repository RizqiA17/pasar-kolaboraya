<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold">Events</h1>
        </div>
        <a href="{{ route('events.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
            Buat Event
        </a>
    </div>

    <div class="mb-6 space-y-4">
        {{-- Search and Filter --}}
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" wire:model.live="search" placeholder="Cari event..." 
                    class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <select wire:model.live="filter" class="border-gray-300 rounded-md shadow-sm">
                <option value="all">Semua Event</option>
                <option value="upcoming">Event Mendatang</option>
                <option value="past">Event Selesai</option>
            </select>
        </div>
    </div>

    {{-- Event List --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($events as $event)
            <div class="bg-white rounded-lg shadow-md overflow-hidden group hover:shadow-lg transition-shadow cursor-pointer">
                <a href="{{ route('events.show', $event) }}" class="block">
                    @if($event->banner)
                        <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->title }}" 
                            class="w-full h-48 object-cover group-hover:opacity-90 transition-opacity">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center group-hover:bg-gray-300 transition-colors">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2 group-hover:text-blue-500 transition-colors">
                            {{ $event->title }}
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            {{ $event->description }}
                        </p>
                        
                        <div class="flex justify-between text-sm text-gray-500">
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $event->start_date->format('d M Y') }}
                            </div>
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                {{ $event->participants_count }} Peserta
                            </div>
                        </div>
                        
                        <div class="mt-3 flex justify-end">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm
                                {{ $event->start_date->isPast() ? 
                                    ($event->end_date->isFuture() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') : 
                                    'bg-blue-100 text-blue-800' }}">
                                @if($event->start_date->isPast())
                                    @if($event->end_date->isFuture())
                                        Sedang Berlangsung
                                    @else
                                        Selesai
                                    @endif
                                @else
                                    Akan Datang
                                @endif
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Belum ada event yang dibuat.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>
