<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Aksi Bersama</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Temukan dan ikuti aksi kolaborasi yang menarik</p>
        </div>
        <a href="{{ route('events.create') }}"
            class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Buat Aksi
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Search Bar -->
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.live="search" 
                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl leading-5 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    placeholder="Cari aksi berdasarkan judul atau deskripsi...">
            </div>
            
            <!-- Filter Dropdown -->
            <div class="sm:w-48">
                <select wire:model.live="filter" class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <option value="all">Semua Aksi</option>
                    <option value="upcoming">Aksi Mendatang</option>
                    <option value="past">Aksi Selesai</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Event List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($events as $event)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100 dark:border-gray-700 group">
                <a href="{{ route('events.show', $event) }}" class="block">
                    <div class="relative">
                        @if ($event->banner)
                            <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->title }}"
                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-sky-50 to-indigo-50 dark:from-sky-900/20 dark:to-indigo-900/20 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <!-- SVG Accent Elements -->
                        <x-svg-accent position="top-left" size="w-12 h-12" opacity="opacity-10" />
                        <x-svg-accent position="bottom-right" size="w-8 h-8" opacity="opacity-10" />
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium shadow-sm
                                {{ $event->start_date->isPast()
                                    ? ($event->end_date->isFuture()
                                        ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                        : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300')
                                    : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' }}">
                                @if ($event->start_date->isPast())
                                    @if ($event->end_date->isFuture())
                                                                                <span class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                            Sedang Berlangsung
                                        </span>
                                    @else
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Selesai
                                        </span>
                                    @endif
                                @else
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Akan Datang
                                        </span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                            {{ $event->title }}
                        </h3>

                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 line-clamp-3 leading-relaxed">
                            {{ $event->description }}
                        </p>

                        <!-- Event Details -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="font-medium">{{ $event->start_date->format('d M Y') }}</span>
                            </div>

                            @if($event->location)
                                <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                    <div class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <span class="truncate max-w-[150px] font-medium">{{ $event->location }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Footer -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>{{ $event->participants_count ?? 0 }} peserta</span>
                            </div>

                            <div class="text-blue-600 dark:text-blue-400 font-medium text-sm group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">
                                Lihat Detail →
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                <div class="w-20 h-20 mb-6 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum ada Aksi yang dibuat</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Mulai buat aksi untuk berkolaborasi dengan teman Anda</p>
                <a href="{{ route('events.create') }}" 
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Buat Aksi Pertama
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($events->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-2">
                {{ $events->links() }}
            </div>
        </div>
    @endif
</div>
