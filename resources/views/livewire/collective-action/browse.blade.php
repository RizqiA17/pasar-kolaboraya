<div class="space-y-6" wire:poll.30s="refreshData">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-blue to-secondary-green text-white rounded-xl p-6">
        <div class="flex justify-between items-start max-sm:flex-col">
            <div>
                <h1 class="text-2xl font-bold mb-2">Aksi Kolektif</h1>
                <p class="text-blue-100">Bergabung dengan gerakan kolaboratif untuk perubahan sosial yang lebih besar</p>
            </div>
            <div class="flex-shrink-0 flex sm:flex-col max-sm:mt-4 max-sm:w-full gap-2 max-sm:flex-wrap">
                <flux:button 
                    wire:navigate
                    href="{{ route('collective-action.qr.scanner') }}"
                    variant="primary"
                    class="bg-white text-primary-blue hover:bg-gray-50 max-sm:w-full"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    Scan QR Code
                </flux:button>
                @if (Auth::user()->isEcosystemBuilder() && $hasCollectiveAction)
                    <flux:button href="{{ route('collective-action.create') }}" variant="primary" wire:navigate
                        class="bg-white text-primary-blue hover:bg-gray-50 max-sm:w-full">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Aksi Kolektif
                    </flux:button>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <div class="flex space-x-1 mb-6">
            <button 
                wire:click="$set('activeTab', 'actions')"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors
                @if($activeTab === 'actions') 
                    bg-primary-blue text-white 
                @else 
                    text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 
                @endif">
                Aksi Kolektif
            </button>
            <button 
                wire:click="$set('activeTab', 'invitations')"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors
                @if($activeTab === 'invitations') 
                    bg-primary-blue text-white 
                @else 
                    text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 
                @endif">
                Undangan
                @if($pendingInvitationsCount > 0)
                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-accent-red text-white">
                        {{ $pendingInvitationsCount }}
                    </span>
                @endif
            </button>
        </div>

        @if($activeTab === 'actions')
            <h2 class="text-lg font-semibold mb-4">Filter Pencarian</h2>
        @else
            <h2 class="text-lg font-semibold mb-4">Undangan Aksi Kolektif</h2>
        @endif

        @if($activeTab === 'actions')
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <!-- Search -->
                <flux:input wire:model.live.debounce.300ms="search" :placeholder="'Cari aksi kolektif...'" type="search" />

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

            @if ($search || $selectedScale || $selectedScope || $selectedStatus)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $collectiveActions->total() }} aksi kolektif ditemukan
                    </span>
                    <flux:button wire:click="clearFilters" variant="outline" size="sm">
                        Hapus Filter
                    </flux:button>
                </div>
            @endif
        @else
            <!-- Invitation Status Filter -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <flux:select wire:model.live="invitationStatus" placeholder="Filter Status Undangan">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu Respons</option>
                    <option value="accepted">Diterima</option>
                    <option value="declined">Ditolak</option>
                </flux:select>
                
                <flux:input wire:model.live.debounce.300ms="invitationSearch" :placeholder="'Cari undangan...'" type="search" />
                
                <div class="flex items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $invitations->total() }} undangan ditemukan
                    </span>
                </div>
            </div>
        @endif
    </div>

    <!-- Flash Messages -->
    @if (session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
            <p class="text-red-700 dark:text-red-300">{{ session('error') }}</p>
        </div>
    @endif

    @if (session('message'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
            <p class="text-green-700 dark:text-green-300">{{ session('message') }}</p>
        </div>
    @endif

    @if($activeTab === 'actions')
        <!-- Collective Actions Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($collectiveActions as $action)
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                <!-- Header -->
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-2 line-clamp-2">
                                {{ $action->title }}
                            </h3>
                            <div class="flex items-center gap-3 mb-3">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs 
                                    @if ($action->scale === 'kecil') bg-secondary-green text-white dark:bg-secondary-green/20 dark:text-secondary-green
                                    @elseif($action->scale === 'sedang') bg-secondary-yellow text-white dark:bg-secondary-yellow/20 dark:text-secondary-yellow
                                    @else bg-accent-red text-white dark:bg-accent-red/20 dark:text-accent-red @endif">
                                    {{ $action->scale_label }}
                                </span>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-primary-blue text-white dark:bg-primary-blue/20 dark:text-sky-600">
                                    {{ $action->scope_label }}
                                </span>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                    @if ($action->status === 'planning') bg-neutral-orange text-white dark:bg-neutral-orange/20 dark:text-neutral-orange
                                    @elseif($action->status === 'active') bg-secondary-green text-white dark:bg-secondary-green/20 dark:text-secondary-green
                                    @elseif($action->status === 'completed') bg-gray-600 text-white dark:bg-gray-600/20 dark:text-gray-400
                                    @else bg-accent-red text-white dark:bg-accent-red/20 dark:text-accent-red @endif">
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
                    @if ($action->required_resources)
                        <div class="mb-4">
                            <h4
                                class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                Sumber Daya Dibutuhkan
                            </h4>
                            <div class="flex flex-wrap gap-1">
                                @foreach (collect($action->required_resources)->take(4) as $resource)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-neutral-orange text-white dark:bg-neutral-orange/20 dark:text-neutral-orange">
                                        {{ ucfirst($resource) }}
                                    </span>
                                @endforeach
                                @if (count($action->required_resources) > 4)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-600 text-white dark:bg-gray-600/20 dark:text-gray-400">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $action->start_date?->format('d M Y') }}
                            </div>
                            <span>-</span>
                            <div class="flex items-center">
                                {{ $action->end_date?->format('d M Y') }}
                            </div>
                        </div>
                        @if ($action->location)
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $action->location }}
                            </div>
                        @endif
                    </div>

                    <!-- Contributors Count -->
                    <div class="mb-4">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            {{ $action->contributions()->distinct('user_id')->count() }} kontributor
                        </div>
                    </div>

                    <!-- Creator -->
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 mr-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-r from-primary-blue to-secondary-green rounded-full flex items-center justify-center text-white text-sm font-medium">
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
                        $user = Auth::user();
                        $userContribution = $user
                            ? $action->contributions()->where('user_id', $user->id)->first()
                            : null;
                        $canContribute = $user ? $action->canUserContribute($user) : false;
                        $canJoin = $user ? $action->canUserJoin($user) : false;
                        $isUserRegistered = $user ? $action->isUserRegistered($user) : false;
                        $userStatus = $user && $isUserRegistered ? $action->getUserStatus($user) : null;
                    @endphp

                    @if ($isUserRegistered)
                        @if ($userStatus === 'active')
                            <div class="flex space-x-2">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-secondary-green text-white dark:bg-secondary-green/20 dark:text-secondary-green">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Sudah Bergabung
                                </span>
                                <flux:button href="{{ route('collective-action.show', $action) }}" variant="outline" wire:navigate
                                    size="sm" class="flex-1">
                                    Lihat Detail
                                </flux:button>
                            </div>
                        @elseif($userStatus === 'pending_approval')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-secondary-yellow text-white dark:bg-secondary-yellow/20 dark:text-secondary-yellow">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Menunggu Persetujuan
                            </span>
                        @elseif($userStatus === 'rejected')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-accent-red text-white dark:bg-accent-red/20 dark:text-accent-red">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Ditolak
                            </span>
                        @elseif($userStatus === 'inactive')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-600 text-white dark:bg-gray-600/20 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                </svg>
                                Tidak Aktif
                            </span>
                        @endif
                    @elseif($canJoin)
                        <div class="flex space-x-2">
                            <flux:button href="{{ route('collective-action.join', $action) }}" variant="primary" wire:navigate
                                size="sm" class="flex-1 bg-primary-blue hover:bg-primary-blue/90 dark:bg-secondary-green dark:hover:bg-secondary-green/90">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Bergabung
                            </flux:button>
                            <flux:button href="{{ route('collective-action.show', $action) }}" variant="outline"
                                size="sm" class="flex-1">
                                Lihat Detail
                            </flux:button>
                        </div>
                    @elseif($userContribution)
                        @php $status = $userContribution->status; @endphp
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm
                            @if ($status === 'accepted') bg-secondary-green text-white dark:bg-secondary-green/20 dark:text-secondary-green
                            @elseif($status === 'offered') bg-secondary-yellow text-white dark:bg-secondary-yellow/20 dark:text-secondary-yellow
                            @elseif($status === 'completed') bg-primary-blue text-white dark:bg-primary-blue/20 dark:text-primary-blue
                            @else bg-accent-red text-white dark:bg-accent-red/20 dark:text-accent-red @endif">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if ($status === 'accepted')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                @elseif($status === 'offered')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @elseif($status === 'completed')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                @endif
                            </svg>
                            @if ($status === 'accepted')
                                Kontribusi Diterima
                            @elseif($status === 'offered')
                                Menunggu Persetujuan
                            @elseif($status === 'completed')
                                Kontribusi Selesai
                            @else
                                Kontribusi Ditolak
                            @endif
                        </span>
                    @else
                        <flux:button href="{{ route('collective-action.show', $action) }}" variant="outline"
                            size="sm" class="w-full">
                            Lihat Detail
                        </flux:button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    Belum Ada Aksi Kolektif
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    @if ($search || $selectedScale || $selectedScope || $selectedStatus)
                        Tidak ada aksi kolektif yang sesuai dengan filter Anda.
                    @else
                        Belum ada aksi kolektif yang tersedia saat ini.
                    @endif
                </p>
                @if ($search || $selectedScale || $selectedScope || $selectedStatus)
                    <flux:button wire:click="clearFilters" variant="outline">
                        Hapus Filter
                    </flux:button>
                @endif
            </div>
        @endforelse
        </div>

        <!-- Pagination -->
        @if ($collectiveActions->hasPages())
            <div class="mt-6">
                {{ $collectiveActions->links() }}
            </div>
        @endif
    @else
        <!-- Invitations List -->
        <div class="space-y-4">
            @forelse($invitations as $invitation)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-2">
                                    {{ $invitation->collectiveAction->title }}
                                </h3>
                                
                                <!-- Status Badge -->
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                        @if($invitation->status === 'pending') bg-secondary-yellow text-white dark:bg-secondary-yellow/20 dark:text-secondary-yellow
                                        @elseif($invitation->status === 'accepted') bg-secondary-green text-white dark:bg-secondary-green/20 dark:text-secondary-green
                                        @else bg-accent-red text-white dark:bg-accent-red/20 dark:text-accent-red @endif">
                                        {{ $invitation->status_label }}
                                    </span>
                                    
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-primary-blue text-white dark:bg-primary-blue/20 dark:text-sky-600">
                                        {{ $invitation->collectiveAction->scale_label }}
                                    </span>
                                    
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-neutral-orange text-white dark:bg-neutral-orange/20 dark:text-neutral-orange">
                                        {{ $invitation->collectiveAction->scope_label }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 line-clamp-3">
                            {{ $invitation->collectiveAction->description }}
                        </p>

                        <!-- Invitation Message -->
                        @if($invitation->invitation_message)
                            <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <h4 class="text-xs font-medium text-blue-800 dark:text-blue-200 uppercase tracking-wide mb-1">
                                    Pesan Undangan
                                </h4>
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    {{ $invitation->invitation_message }}
                                </p>
                            </div>
                        @endif

                        <!-- Response Message -->
                        @if($invitation->response_message)
                            <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h4 class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">
                                    Pesan Respons
                                </h4>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $invitation->response_message }}
                                </p>
                            </div>
                        @endif

                        <!-- Invited By -->
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 bg-gradient-to-r from-primary-blue to-secondary-green rounded-full flex items-center justify-center text-white text-sm font-medium">
                                    {{ $invitation->invitedBy->initials() }}
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $invitation->invitedBy->name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Mengundang Anda
                                </p>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Diundang: {{ $invitation->created_at->format('d M Y H:i') }}
                                </div>
                                @if($invitation->responded_at)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Direspons: {{ $invitation->responded_at->format('d M Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                        @if($invitation->status === 'pending')
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Menunggu respons Anda
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('collective-action.respond-invitation', $invitation) }}"
                                        class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        Respons
                                    </a>
                                    <flux:button 
                                        href="{{ route('collective-action.show', $invitation->collectiveAction) }}" 
                                        variant="outline" 
                                        size="sm">
                                        Lihat Detail
                                    </flux:button>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm
                                        @if($invitation->status === 'accepted') bg-secondary-green text-white dark:bg-secondary-green/20 dark:text-secondary-green
                                        @else bg-accent-red text-white dark:bg-accent-red/20 dark:text-accent-red @endif">
                                        @if($invitation->status === 'accepted')
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Undangan Diterima
                                        @else
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Undangan Ditolak
                                        @endif
                                    </span>
                                </div>
                                <div class="flex space-x-2">
                                    <flux:button 
                                        href="{{ route('collective-action.show', $invitation->collectiveAction) }}" 
                                        variant="outline" 
                                        size="sm">
                                        Lihat Aksi Kolektif
                                    </flux:button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        Belum Ada Undangan
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        @if ($invitationSearch || $invitationStatus)
                            Tidak ada undangan yang sesuai dengan filter Anda.
                        @else
                            Belum ada undangan aksi kolektif yang diterima.
                        @endif
                    </p>
                    @if ($invitationSearch || $invitationStatus)
                        <flux:button wire:click="clearInvitationFilters" variant="outline">
                            Hapus Filter
                        </flux:button>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Invitations Pagination -->
        @if ($invitations->hasPages())
            <div class="mt-6">
                {{ $invitations->links() }}
            </div>
        @endif
    @endif
</div>

@push('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    // Initialize Pusher for real-time invitation updates
    document.addEventListener('DOMContentLoaded', function() {
        try {
            if (typeof Pusher !== 'undefined' && '{{ config('broadcasting.default') }}' === 'pusher') {
                const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                    encrypted: true,
                    authEndpoint: '{{ route('broadcasting.auth') }}',
                    auth: {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }
                });

                // Subscribe to user's private channel
                const userId = {{ auth()->id() }};
                const channel = pusher.subscribe('private-user.' + userId);

                // Listen for invitation created events
                channel.bind('invitation.created', function(data) {
                    console.log('New invitation received:', data);
                    
                    // Show notification
                    showInvitationNotification(data.invitation);
                    
                    // Refresh Livewire component data
                    @this.call('refreshData');
                });

                // Listen for invitation updated events
                channel.bind('invitation.updated', function(data) {
                    console.log('Invitation updated:', data);
                    
                    // Refresh Livewire component data
                    @this.call('refreshData');
                });

                console.log('Pusher initialized for invitation updates');
            } else {
                console.log('Pusher not configured, using polling fallback');
            }
        } catch (error) {
            console.error('Pusher initialization failed:', error);
        }
    });

    // Show invitation notification
    function showInvitationNotification(invitation) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-orange-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-md transform transition-all duration-300 translate-x-full';
        notification.innerHTML = `
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold">Undangan Aksi Kolektif Baru</h4>
                    <p class="text-sm mt-1">${invitation.collective_action.title}</p>
                    <p class="text-xs mt-1 opacity-90">Dari: ${invitation.invited_by.name}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-white hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        `;

        // Add to page
        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }, 5000);
    }
</script>
@endpush
