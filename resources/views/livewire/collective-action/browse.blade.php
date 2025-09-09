<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold mb-2">Aksi Kolektif</h1>
                <p class="text-purple-100">Bergabung dengan gerakan kolaboratif untuk perubahan sosial yang lebih besar</p>
            </div>
            @if(Auth::user()->isEcosystemBuilder())
                <flux:button href="{{ route('collective-action.create') }}" variant="primary" class="bg-white text-purple-600 hover:bg-purple-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Aksi Kolektif
                </flux:button>
            @endif
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Filter Pencarian</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <!-- Search -->
            <flux:input
                wire:model.live.debounce.300ms="search"
                :placeholder="'Cari aksi kolektif...'"
                type="search"
            />

            <!-- Scale Filter -->
            <flux:select wire:model.live="selectedScale" placeholder="Pilih Skala">
                <option value="">Semua Skala</option>
                <option value="kecil">Aksi Kecil</option>
                <option value="sedang">Aksi Sedang</option>
                <option value="besar">Aksi Besar</option>
            </flux:select>

            <!-- Scope Filter -->
            <flux:select wire:model.live="selectedScope" placeholder="Pilih Jangkauan">
                <option value="">Semua Jangkauan</option>
                <option value="local">Lokal</option>
                <option value="national">Nasional</option>
                <option value="international">Internasional</option>
            </flux:select>

            <!-- Status Filter -->
            <flux:select wire:model.live="selectedStatus" placeholder="Pilih Status">
                <option value="">Semua Status</option>
                <option value="planning">Perencanaan</option>
                <option value="active">Aktif</option>
                <option value="completed">Selesai</option>
            </flux:select>
        </div>

        @if($search || $selectedScale || $selectedScope || $selectedStatus)
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $collectiveActions->total() }} aksi kolektif ditemukan
                </span>
                <flux:button wire:click="clearFilters" variant="outline" size="sm">
                    Hapus Filter
                </flux:button>
            </div>
        @endif
    </div>

    <!-- Flash Messages -->
    @if (session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
            <p class="text-red-700 dark:text-red-300">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Collective Actions Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($collectiveActions as $action)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                <!-- Header -->
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-2 line-clamp-2">
                                {{ $action->title }}
                            </h3>
                            <div class="flex items-center gap-3 mb-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs 
                                    @if($action->scale === 'kecil') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                    @elseif($action->scale === 'sedang') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                    @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 @endif">
                                    {{ $action->scale_label }}
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    {{ $action->scope_label }}
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                    @if($action->status === 'planning') bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200
                                    @elseif($action->status === 'active') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                    @elseif($action->status === 'completed') bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                    @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 @endif">
                                    {{ $action->status_label }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 line-clamp-3">
                        {{ $action->description }}
                    </p>

                    <!-- Goals -->
                    <div class="mb-4">
                        <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                            Tujuan
                        </h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-2">
                            {{ $action->goals }}
                        </p>
                    </div>

                    <!-- Required Resources -->
                    @if($action->required_resources)
                        <div class="mb-4">
                            <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                Sumber Daya Dibutuhkan
                            </h4>
                            <div class="flex flex-wrap gap-1">
                                @foreach(collect($action->required_resources)->take(4) as $resource)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                        {{ ucfirst($resource) }}
                                    </span>
                                @endforeach
                                @if(count($action->required_resources) > 4)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                        +{{ count($action->required_resources) - 4 }} lainnya
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Participating Ecosystems -->
                    <div class="mb-4">
                        <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                            Ekosistem Berpartisipasi
                        </h4>
                        <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            {{ $action->acceptedInvitations()->count() }} ekosistem terlibat
                            <span class="text-xs text-gray-500 ml-1">(termasuk penyelenggara)</span>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $action->start_date->format('d M Y') }}
                            </div>
                            <span>-</span>
                            <div class="flex items-center">
                                {{ $action->end_date->format('d M Y') }}
                            </div>
                        </div>
                        @if($action->location)
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $action->location }}
                            </div>
                        @endif
                    </div>

                    <!-- Contributors Count -->
                    <div class="mb-4">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            {{ $action->contributions()->distinct('user_id')->count() }} kontributor
                        </div>
                    </div>

                    <!-- Creator -->
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                {{ $action->creator->initials() }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $action->creator->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Penyelenggara
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    @php
                        $userContribution = Auth::user() ? $action->contributions()->where('user_id', Auth::user()->id)->first() : null;
                        $canContribute = Auth::user() ? $action->canUserContribute(Auth::user()) : false;
                    @endphp

                    @if($userContribution)
                        @php $status = $userContribution->status; @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm
                            @if($status === 'accepted') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                            @elseif($status === 'offered') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                            @elseif($status === 'completed') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                            @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 @endif">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($status === 'accepted')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                @elseif($status === 'offered')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @elseif($status === 'completed')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                @endif
                            </svg>
                            @if($status === 'accepted') Kontribusi Diterima
                            @elseif($status === 'offered') Menunggu Persetujuan
                            @elseif($status === 'completed') Kontribusi Selesai
                            @else Kontribusi Ditolak @endif
                        </span>
                    @elseif($canContribute)
                        <flux:button 
                            wire:click="contributeToAction({{ $action->id }})" 
                            variant="primary" 
                            size="sm" 
                            class="w-full"
                        >
                            Lihat Detail
                        </flux:button>
                    @else
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            @if($action->status === 'completed')
                                Aksi Telah Selesai
                            @elseif($action->status === 'cancelled')
                                Aksi Dibatalkan
                            @else
                                Tidak Dapat Berkontribusi
                            @endif
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    Belum Ada Aksi Kolektif
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    @if($search || $selectedScale || $selectedScope || $selectedStatus)
                        Tidak ada aksi kolektif yang sesuai dengan filter Anda.
                    @else
                        Belum ada aksi kolektif yang tersedia saat ini.
                    @endif
                </p>
                @if($search || $selectedScale || $selectedScope || $selectedStatus)
                    <flux:button wire:click="clearFilters" variant="outline">
                        Hapus Filter
                    </flux:button>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($collectiveActions->hasPages())
        <div class="mt-6">
            {{ $collectiveActions->links() }}
        </div>
    @endif
</div>