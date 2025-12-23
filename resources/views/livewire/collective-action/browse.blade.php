<div class="space-y-6" wire:poll.30s="refreshData">
    <!-- Header -->
    <div class="p-6 text-white bg-gradient-to-r from-primary-blue to-secondary-green rounded-xl">
        <div class="flex items-start justify-between max-sm:flex-col">
            <div>
                <h1 class="mb-2 text-2xl font-bold">Aksi Kolektif</h1>
                <p class="text-blue-100">Bergabung dengan gerakan kolaboratif untuk perubahan sosial yang lebih besar</p>
            </div>
            <div class="flex flex-shrink-0 gap-2 sm:flex-col max-sm:mt-4 max-sm:w-full max-sm:flex-wrap">
                @if (Auth::user()->canJoinEcosystemsAndActions())
                    <flux:button wire:navigate href="{{ route('collective-action.qr.scanner') }}" variant="primary"
                        class="bg-white text-primary-blue hover:bg-gray-50 max-sm:w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                            </path>
                        </svg>
                        Scan QR Code
                    </flux:button>
                @endif
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
    <div class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-xl p-6 shadow-sm">
        @if (Auth::user()->isEcosystemBuilder())
            <div class="flex mb-6 space-x-1">
                <button wire:click="$set('activeTab', 'actions')"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-colors
                @if ($activeTab === 'actions') bg-primary-blue text-white 
                @else 
                    text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 @endif">
                    Aksi Kolektif
                </button>
                <button wire:click="$set('activeTab', 'invitations')"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-colors
                @if ($activeTab === 'invitations') bg-primary-blue text-white 
                @else 
                    text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 @endif">
                    Undangan
                    @if ($pendingInvitationsCount > 0)
                        <span
                            class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-accent-red text-white">
                            {{ $pendingInvitationsCount }}
                        </span>
                    @endif
                </button>
            </div>
        @endif
        @if ($activeTab === 'actions')
            <h2 class="mb-4 text-lg font-semibold">Filter Pencarian</h2>
        @else
            <h2 class="mb-4 text-lg font-semibold">Undangan Aksi Kolektif</h2>
        @endif

        @if ($activeTab === 'actions')
            <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-2 lg:grid-cols-4">
                <!-- Search -->
                <flux:input wire:model.live.debounce.300ms="search" :placeholder="'Cari aksi kolektif...'"
                    type="search" />

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
                <div class="flex items-center justify-between">
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
            <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">
                <flux:select wire:model.live="invitationStatus" placeholder="Filter Status Undangan">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="accepted">Diterima</option>
                    <option value="declined">Ditolak</option>
                </flux:select>

                <flux:input wire:model.live.debounce.300ms="invitationSearch" :placeholder="'Cari undangan...'"
                    type="search" />

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
        <div class="p-4 border border-red-200 bg-red-50 dark:bg-red-900/20 dark:border-red-800 rounded-xl">
            <p class="text-red-700 dark:text-red-300">{{ session('error') }}</p>
        </div>
    @endif

    @if (session('message'))
        <div class="p-4 border border-green-200 bg-green-50 dark:bg-green-900/20 dark:border-green-800 rounded-xl">
            <p class="text-green-700 dark:text-green-300">{{ session('message') }}</p>
        </div>
    @endif

    @if ($activeTab === 'actions')
        <!-- Collective Actions Grid -->
        <div class="grid grid-cols-[repeat(auto-fill,_minmax(384px,_1fr))] gap-6">
            @forelse($collectiveActions as $action)
                <div
                    class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-xl  overflow-hidden hover:shadow-md flex flex-col hover:scale-105 transition-[scale,shadow] duration-300">

                    <!-- Header -->
                    <a href="{{ route('collective-action.show', $action) }}" class="flex flex-col flex-grow p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-200 line-clamp-1">
                                    {{ $action->title }}
                                </h3>
                                <div class="flex items-center gap-3 my-3">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                            @if ($action->scale === 'kecil') text-emerald-800 dark:text-emerald-200 bg-emerald-100 dark:bg-secondary-green/50
                                            @elseif($action->scale === 'sedang') text-yellow-800 bg-yellow-100 dark:text-yellow-200 dark:bg-secondary-yellow/50
                                            @else text-red-800 dark:text-red-200 bg-red-100 dark:bg-accent-red/50 @endif">
                                        {{ $action->scale_label }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs rounded-full text-sky-800 bg-sky-100 dark:text-sky-200 dark:bg-primary-blue/50">
                                        {{ $action->scope_label }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                @if ($action->status === 'planning') text-orange-800 bg-orange-100 dark:text-orange-200 dark:bg-accent-orange/50
                                @elseif($action->status === 'active') text-emerald-800 dark:text-emerald-200 bg-emerald-100 dark:bg-secondary-green/50
                                @elseif($action->status === 'completed') text-gray-800 bg-gray-100 dark:text-slate-200 dark:bg-gray-500/50
                                @else text-red-800 bg-red-100 dark:text-red-200 dark:bg-secondary-red/50 @endif">
                                        {{ $action->status_label }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <p
                            class="flex-grow mb-4 text-sm text-gray-700 dark:text-gray-300 line-clamp-3 min-h-15 max-h-15">
                            {{ $action->description }}
                        </p>

                        <!-- Goals -->
                        <div class="flex-grow mb-4">
                            <h4
                                class="mb-2 text-xs font-medium tracking-wide text-gray-500 uppercase dark:text-gray-400">
                                Tujuan
                            </h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-2 min-h-10 max-h-10">
                                {{ $action->goals }}
                            </p>
                        </div>

                        <!-- Required Resources -->
                        @if ($action->required_resources_limited)
                            <div class="mb-4">
                                <h4
                                    class="mb-2 text-xs font-medium tracking-wide text-gray-500 uppercase dark:text-gray-400">
                                    Sumber Daya Dibutuhkan
                                </h4>
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($action->required_resources_limited as $resource)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs text-white rounded-full bg-neutral-orange dark:bg-neutral-orange/20 dark:text-neutral-orange">
                                            {{ ucfirst($resource) }}
                                        </span>
                                    @endforeach
                                    @if ($action->required_resources_count > 4)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs text-white bg-gray-600 rounded-full dark:bg-gray-600/20 dark:text-gray-400">
                                            +{{ $action->required_resources_count - 4 }} lainnya
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Participating Ecosystems -->
                        <div class="mb-4">
                            <h4
                                class="mb-2 text-xs font-medium tracking-wide text-gray-500 uppercase dark:text-gray-400">
                                Ekosistem Berpartisipasi
                            </h4>
                            <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                {{ $action->accepted_count }} ekosistem terlibat
                                <span class="ml-1 text-xs text-gray-500">(termasuk penyelenggara)</span>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
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
                                <div class="flex items-center mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <p class="line-clamp-1">{{ $action->location }}</p>
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
                                {{ $action->contributors_count }} kontributor
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3 mb-4">
                            <!-- Creator -->
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 mr-3">
                                    <div
                                        class="flex items-center justify-center w-8 h-8 text-sm font-medium text-white rounded-full bg-gradient-to-r from-primary-blue to-secondary-green">
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

                            <!-- Like Button and User Status -->
                            <button id="like-button-{{ $action->id }}"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                                {{ $action->is_liked
                                    ? 'text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400'
                                    : 'text-gray-600 hover:text-gray-700 dark:text-gray-500 dark:hover:text-gray-400' }}"
                                onclick="toggleLike('collective-action', {{ $action->id }}, '{{ $action->id }}', event)">
                                <svg id="like-icon-{{ $action->id }}"
                                    class="w-8 h-8 {{ $action->is_liked ? 'fill-red-600' : 'fill-gray-600' }}"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span id="like-count-{{ $action->id }}"
                                    class="font-medium">{{ $action->like_count }}</span>
                            </button>

                        </div>
                    </a>

                    <!-- Footer Buttons -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex space-x-2">
                            @if ($action->can_user_contribute)
                                <flux:button href="{{ route('collective-action.contribute', $action) }}"
                                    variant="primary" wire:navigate size="sm" class="flex-1">Berkontribusi
                                </flux:button>
                                <span
                                    class="flex items-center justify-center w-8 h-8 px-2 py-1 text-xs rounded-full text-emerald-800 dark:text-emerald-200 bg-emerald-100 dark:bg-secondary-green/50">
                                    <flux:icon.check class="size-4" />
                                </span>
                            @elseif ($action->can_user_join)
                                <flux:button href="{{ route('collective-action.join', $action) }}" variant="primary"
                                    wire:navigate size="sm" class="flex-1">Bergabung</flux:button>
                            @elseif ($action->user_contribution)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm
                                    @if ($action->user_contribution_status === 'accepted') text-emerald-800 dark:text-emerald-200 bg-emerald-100 dark:bg-secondary-green/50
                                    @elseif ($action->user_contribution_status === 'offered') text-yellow-800 bg-yellow-100 dark:text-yellow-200 dark:bg-secondary-yellow/50
                                    @elseif ($action->user_contribution_status === 'completed') text-sky-800 bg-sky-100 dark:text-sky-200 dark:bg-primary-blue/50
                                    @else text-red-800 bg-red-100 dark:text-red-200 dark:bg-secondary-red/50 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $action->user_contribution_status)) }}
                                </span>
                            @elseif ($action->is_user_registered && $action->user_status === 'pending_approval')
                                <span
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-yellow-800 bg-yellow-100 rounded-full dark:text-yellow-200 dark:bg-secondary-yellow/50 w-fit">
                                    Menunggu Persetujuan
                                </span>
                            @else
                                <div class="flex items-center h-8!">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Anda sudah aktif dalm
                                        ekosistem ini</span>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center col-span-full">
                    <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">Belum Ada Aksi Kolektif</h3>
                    <p class="mb-4 text-gray-600 dark:text-gray-400">
                        @if ($search || $selectedScale || $selectedScope || $selectedStatus)
                            Tidak ada aksi kolektif yang sesuai dengan filter Anda.
                        @else
                            Belum ada aksi kolektif yang tersedia saat ini.
                        @endif
                    </p>
                    @if ($search || $selectedScale || $selectedScope || $selectedStatus)
                        <flux:button wire:click="clearFilters" variant="outline">Hapus Filter</flux:button>
                    @endif
                </div>
            @endforelse
        </div>

        @if ($collectiveActions->hasPages())
            <div class="mt-6">
                {{ $collectiveActions->links() }}
            </div>
        @endif
    @else
        <!-- Invitations List -->
        <div class="grid grid-cols-[repeat(auto-fill,_minmax(512px,_1fr))] gap-6">
            @forelse($invitations as $invitation)
                <div
                    class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-xl  overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white line-clamp-1">
                                    {{ $invitation->collectiveAction->title }}
                                </h3>

                                <!-- Status Badge -->
                                <div class="flex items-center gap-3 mb-3">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                        @if ($invitation->status === 'pending') bg-secondary-yellow text-white dark:bg-secondary-yellow/20 dark:text-secondary-yellow
                                        @elseif($invitation->status === 'accepted') text-emerald-800 dark:text-emerald-200 bg-emerald-100 dark:bg-secondary-green/50
                                        @else text-red-800 bg-red-100 dark:text-red-200 dark:bg-secondary-red/50 @endif">
                                        {{ $invitation->status_label }}
                                    </span>

                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs text-sky-800 bg-sky-100 dark:text-sky-200 dark:bg-primary-blue/50">
                                        {{ $invitation->collectiveAction->scale_label }}
                                    </span>

                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs text-white rounded-full bg-neutral-orange dark:bg-neutral-orange/20 dark:text-neutral-orange">
                                        {{ $invitation->collectiveAction->scope_label }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <p class="mb-4 text-sm text-gray-700 dark:text-gray-300 line-clamp-3 h-15">
                            {{ $invitation->collectiveAction->description }}
                        </p>
                        
                        <!-- Invitation Message -->
                        @if ($invitation->invitation_message)
                            <div class="p-3 mb-4 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                                <h4
                                    class="mb-1 text-xs font-medium tracking-wide text-blue-800 uppercase dark:text-blue-200">
                                    Pesan Undangan
                                <p class="text-sm text-blue-700 dark:text-blue-300 line-clamp-2 h-10">
                                    {{ $invitation->invitation_message }}
                                </p>
                            </div>
                        @endif
                            
                        <!-- Invited By -->
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 mr-3">
                                <div
                                    class="flex items-center justify-center w-8 h-8 text-sm font-medium text-white rounded-full bg-gradient-to-r from-primary-blue to-secondary-green">
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
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Diundang: {{ $invitation->created_at->format('d M Y H:i') }}
                                </div>
                                @if ($invitation->responded_at)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
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
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                        @if ($invitation->status === 'pending')
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Menunggu respons
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('collective-action.respond-invitation', $invitation) }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-orange-600 rounded-lg hover:bg-orange-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        Respons
                                    </a>
                                    <flux:button
                                        href="{{ route('collective-action.show', $invitation->collectiveAction) }}"
                                        variant="outline" size="sm">
                                        Lihat Detail
                                    </flux:button>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm
                                        @if ($invitation->status === 'accepted') text-emerald-800 dark:text-emerald-200 bg-emerald-100 dark:bg-secondary-green/50
                                        @else text-red-800 bg-red-100 dark:text-red-200 dark:bg-secondary-red/50 @endif">
                                        @if ($invitation->status === 'accepted')
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Diterima
                                        @else
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Ditolak
                                        @endif
                                    </span>
                                </div>
                                <div class="flex space-x-2">
                                    <flux:button
                                        href="{{ route('collective-action.show', $invitation->collectiveAction) }}"
                                        variant="outline" size="sm">
                                        Lihat Aksi Kolektif
                                    </flux:button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">
                        Belum Ada Undangan
                    </h3>
                    <p class="mb-4 text-gray-600 dark:text-gray-400">
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
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
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
            notification.className =
                'fixed top-4 right-4 bg-orange-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-md transform transition-all duration-300 translate-x-full';
            notification.innerHTML = `
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold">Undangan Aksi Kolektif Baru</h4>
                    <p class="mt-1 text-sm">${invitation.collective_action.title}</p>
                    <p class="mt-1 text-xs opacity-90">Dari: ${invitation.invited_by.name}</p>
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

        // Like functionality
        function toggleLike(type, id, elementId) {
            event.stopPropagation();
            event.preventDefault();

            const button = document.getElementById(`like-button-${elementId}`);
            const icon = document.getElementById(`like-icon-${elementId}`);
            const count = document.getElementById(`like-count-${elementId}`);

            // Disable button during request
            button.disabled = true;

            fetch(`/${type}s/${id}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update button state
                        if (data.isLiked) {
                            button.classList.remove('text-gray-600', 'hover:text-gray-700', 'dark:text-gray-500',
                                'dark:hover:text-gray-400');
                            button.classList.add('text-red-600', 'hover:text-red-700', 'dark:text-red-500',
                                'dark:hover:text-red-400');
                            // Update icon fill
                            if (icon) {
                                icon.classList.remove('fill-gray-600');
                                icon.classList.add('fill-red-600');
                            }
                        } else {
                            button.classList.remove('text-red-600', 'hover:text-red-700', 'dark:text-red-500',
                                'dark:hover:text-red-400');
                            button.classList.add('text-gray-600', 'hover:text-gray-700', 'dark:text-gray-500',
                                'dark:hover:text-gray-400');
                            // Update icon fill
                            if (icon) {
                                icon.classList.remove('fill-red-600');
                                icon.classList.add('fill-gray-600');
                            }
                        }

                        // Update count
                        count.textContent = data.likeCount;

                        // Show notification
                        showNotification(data.message, 'success');
                    } else {
                        showNotification(data.message || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat memproses like', 'error');
                })
                .finally(() => {
                    button.disabled = false;
                });
        }

        function loadLikeStatus(type, id, elementId) {
            fetch(`/${type}s/${id}/like-status`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const button = document.getElementById(`like-button-${elementId}`);
                        const count = document.getElementById(`like-count-${elementId}`);

                        if (data.isLiked) {
                            button.classList.remove('text-gray-600', 'hover:text-gray-700', 'dark:text-gray-500',
                                'dark:hover:text-gray-400');
                            button.classList.add('text-red-600', 'hover:text-red-700', 'dark:text-red-500',
                                'dark:hover:text-red-400');
                        } else {
                            button.classList.remove('text-red-600', 'hover:text-red-700', 'dark:text-red-500',
                                'dark:hover:text-red-400');
                            button.classList.add('text-gray-600', 'hover:text-gray-700', 'dark:text-gray-500',
                                'dark:hover:text-gray-400');
                        }

                        count.textContent = data.likeCount;
                    }
                })
                .catch(error => {
                    console.error('Error loading like status:', error);
                });
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 3000);
        }

        // Load like status for all collective actions on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Find all like buttons and load their status
            const likeButtons = document.querySelectorAll('[id^="like-button-"]');
            likeButtons.forEach(button => {
                const elementId = button.id.replace('like-button-', '');
                loadLikeStatus('collective-action', elementId, elementId);
            });
        });
    </script>
@endpush
