<x-admin.layout title="Manajemen Acara">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Manajemen Acara</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">Kelola semua acara dalam sistem</p>
            </div>
        </div>

        <!-- Filters and Cari -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <form method="GET" class="space-y-4">
                <div class="flex flex-col lg:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <flux:input 
                            name="search" 
                            placeholder="Cari acara berdasarkan judul..." 
                            value="{{ request('search') }}"
                            class="w-full"
                        />
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="lg:w-48">
                        <flux:select name="status" placeholder="Filter berdasarkan status">
                            <option value="">Semua Status</option>
                            <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                            <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                        </flux:select>
                    </div>
                    
                    <!-- Date From -->
                    <div class="lg:w-48">
                        <flux:input 
                            name="date_from" 
                            type="date"
                            placeholder="Dari tanggal"
                            value="{{ request('date_from') }}"
                            class="w-full"
                        />
                    </div>
                    
                    <!-- Date To -->
                    <div class="lg:w-48">
                        <flux:input 
                            name="date_to" 
                            type="date"
                            placeholder="Sampai tanggal"
                            value="{{ request('date_to') }}"
                            class="w-full"
                        />
                    </div>
                    
                    <!-- Filter Button -->
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Cari</button>
                    
                    <!-- Clear Filters -->
                    @if(request('search') || request('status') || request('date_from') || request('date_to'))
                        <a href="{{ route('admin.events') }}" class="px-4 py-2 text-sm text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">Hapus</a>
                    @endif
                </div>
                
                <!-- Active Filters Display -->
                @if(request('search') || request('status') || request('date_from') || request('date_to'))
                    <div class="flex flex-wrap gap-2 pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-slate-600 dark:text-slate-400">Filter aktif:</span>
                        @if(request('search'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400 rounded-full">
                                Pencarian: "{{ request('search') }}"
                            </span>
                        @endif
                        @if(request('status'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400 rounded-full">
                                Status: {{ ucfirst(request('status')) }}
                            </span>
                        @endif
                        @if(request('date_from'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 rounded-full">
                                Dari: {{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}
                            </span>
                        @endif
                        @if(request('date_to'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 rounded-full">
                                Sampai: {{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}
                            </span>
                        @endif
                    </div>
                @endif
            </form>
        </div>

        <!-- Acaras Table -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
            <!-- Mobile Card View (hidden on larger screens) -->
            <div class="block lg:hidden">
                @forelse($events as $event)
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                        <div class="space-y-3">
                            <div>
                                <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $event->title }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ Str::limit($event->description, 80) }}</div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <x-ui.avatar :user="$event->creator" size="sm" />
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-medium text-slate-800 dark:text-slate-200">{{ $event->creator->name }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">{{ $event->creator->email }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    @php
                                        $statusColors = [
                                            'upcoming' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
                                            'ongoing' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                            'completed' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400'
                                        ];
                                        $status = $event->start_date ? 
                                            ($event->start_date->isFuture() ? 'upcoming' : 
                                             ($event->end_date && $event->end_date->isPast() ? 'completed' : 'ongoing')) : 'upcoming';
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $event->start_date ? $event->start_date->format('M d, Y') : 'TBD' }}
                                </div>
                            </div>
                            
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $event->location ?: 'TBD' }}
                            </div>
                            
                            <div class="flex items-center space-x-3 pt-2">
                                <a href="{{ route('admin.events.show', $event) }}" 
                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-xs font-medium">
                                    Lihat
                                </a>
                                <form method="POST" action="{{ route('admin.events.delete', $event) }}" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="text-slate-500 dark:text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-lg font-medium">Tidak ada acara ditemukan</p>
                            <p class="text-sm">Coba sesuaikan kriteria pencarian Anda</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Acara</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pembuat</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($events as $event)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $event->title }}</div>
                                        <div class="text-sm text-slate-500 dark:text-slate-400 truncate max-w-xs">{{ Str::limit($event->description, 60) }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <x-ui.avatar :user="$event->creator" size="sm" />
                                        <div>
                                            <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $event->creator->name }}</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">{{ $event->creator->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'upcoming' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
                                            'ongoing' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                            'completed' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400'
                                        ];
                                        $status = $event->start_date ? 
                                            ($event->start_date->isFuture() ? 'upcoming' : 
                                             ($event->end_date && $event->end_date->isPast() ? 'completed' : 'ongoing')) : 'upcoming';
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-800 dark:text-slate-200">
                                        {{ $event->start_date ? $event->start_date->format('M d, Y') : 'TBD' }}
                                    </div>
                                    @if($event->start_date && $event->end_date)
                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                            to {{ $event->end_date->format('M d, Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                    {{ $event->location ?: 'TBD' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.events.show', $event) }}" 
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium">
                                            Lihat
                                        </a>
                                        <form method="POST" action="{{ route('admin.events.delete', $event) }}" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-sm font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-slate-500 dark:text-slate-400">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Tidak ada acara ditemukan</p>
                                        <p class="text-sm">Coba sesuaikan kriteria pencarian Anda</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
            <div class="flex justify-center">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</x-admin.layout>
