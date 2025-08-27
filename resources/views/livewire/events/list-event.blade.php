<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold">Aksi</h1>
        </div>
        <a href="{{ route('events.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
            Buat Aksi
        </a>
    </div>

    <div class="mb-6 space-y-4">
        {{-- Search and Filter --}}
        <div class="flex gap-4">
            <select wire:model.live="filter" class="border-gray-300 rounded-md shadow-sm">
                <option value="all">Semua Aksi</option>
                <option value="upcoming">Aksi Mendatang</option>
                <option value="past">Aksi Selesai</option>
            </select>
        </div>
    </div>

    {{-- Event List --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($events as $event)
            <div class="bg-white rounded-xl shadow-sm group hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100">
                <a href="{{ route('events.show', $event) }}" class="block">
                    <div class="relative">
                        @if ($event->banner)
                            <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->title }}"
                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-sky-50 to-indigo-50 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium shadow-sm
                                {{ $event->start_date->isPast()
                                    ? ($event->end_date->isFuture()
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-gray-100 text-gray-800')
                                    : 'bg-blue-100 text-blue-800' }}">
                                @if ($event->start_date->isPast())
                                    @if ($event->end_date->isFuture())
                                        <span class="flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                            Sedang Berlangsung
                                        </span>
                                    @else
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Selesai
                                        </span>
                                    @endif
                                @else
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Akan Datang
                                    </span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-900 mb-2 group-hover:text-sky-600 transition-colors">
                            {{ $event->title }}
                        </h3>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $event->description }}
                        </p>

                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $event->start_date->format('d M Y') }}</span>
                                </div>

                                @if($event->location)
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="truncate max-w-[150px]">{{ $event->location }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-1.5">
                                <div class="flex -space-x-2">
                                    @foreach($event->participants->take(3) as $participant)
                                        <div class="w-6 h-6 rounded-full bg-white border-2 border-white ring-1 ring-gray-100 flex items-center justify-center overflow-hidden">
                                            <span class="text-xs font-medium text-gray-600">{{ substr($participant->name, 0, 2) }}</span>
                                        </div>
                                    @endforeach
                                    @if($event->participants_count > 3)
                                        <div class="w-6 h-6 rounded-full bg-gray-50 border-2 border-white ring-1 ring-gray-100 flex items-center justify-center">
                                            <span class="text-xs font-medium text-gray-600">+{{ $event->participants_count - 3 }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-12 text-center">
                <div class="w-16 h-16 mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-gray-500 text-lg">Belum ada Aksi yang dibuat</p>
                <p class="text-gray-400 text-sm mt-1">Mulai buat aksi untuk berkolaborasi dengan teman Anda</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>
