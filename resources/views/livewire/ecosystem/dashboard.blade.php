<div class="space-y-6" wire:poll.30s="refreshData">
    {{-- {{dd(['contributions' => $contributions,'pendingContributions' => $pendingContributions, 'acceptedContributions' =>  $acceptedContributions])}} --}}
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div
            class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div
            class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex-1">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-2">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-slate-100 break-words">
                        {{ $ecosystem->ecosystem_title }}</h1>
                    <div class="flex flex-wrap gap-2">
                        @if ($isOwner)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-primary-light-blue dark:bg-primary-blue text-primary-blue dark:text-primary-light-blue">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pemilik
                            </span>
                        @elseif($isEcosystemBuilder)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Ecosystem Builder
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Pengunjung
                            </span>
                        @endif
                        @if ($isReadOnly)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Mode Lihat Saja
                            </span>
                        @endif
                    </div>
                </div>
                <p class="text-gray-600 dark:text-slate-300 mt-1 text-sm sm:text-base">
                    {{ $ecosystem->organization_name }}</p>
                <div
                    class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mt-2 text-sm text-gray-500 dark:text-slate-400">
                    <span>📍 {{ $ecosystem->work_region }}</span>
                    <span>👥 {{ $ecosystem->acceptedUsers()->count() }} anggota</span>
                    @if ($ecosystem->max_users)
                        <span>📊 {{ $ecosystem->acceptedUsers()->count() }}/{{ $ecosystem->max_users }} kapasitas</span>
                    @endif
                </div>
            </div>
            <div class="flex flex-col sm:text-right">
                <div class="text-2xl sm:text-3xl font-bold text-green-600 dark:text-green-400">
                    {{ $ecosystemQuality['ekosistem_score'] }}%</div>
                <div class="text-sm text-gray-500 dark:text-slate-400">Skor Ekosistem</div>
                @if ($isOwner)
                    <div class="mt-3 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('ecosystem.qr.show', $ecosystem) }}" wire:navigate
                            class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-md text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                </path>
                            </svg>
                            QR Code
                        </a>
                        <a href="{{ route('ecosystem.edit', $ecosystem) }}" wire:navigate
                            class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-md text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit
                        </a>
                        {{-- <a href="{{ route('ecosystem.settings', $ecosystem) }}" wire:navigate
                            class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-md text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Pengaturan
                        </a> --}}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="border-b border-gray-200 dark:border-slate-700">
            <div class="overflow-x-auto">
                <nav class="flex space-x-2 sm:space-x-8 px-4 sm:px-6 min-w-max" aria-label="Tabs">
                    <button wire:click="setActiveTab('overview')"
                        class="px-3 sm:px-4 py-2 font-medium text-sm sm:text-base
                            {{ $activeTab === 'overview'
                                ? 'border-b-2 border-sky-500 text-sky-600 dark:border-secondary-green dark:text-secondary-green'
                                : 'text-neutral-600 hover:text-sky-600 dark:text-neutral-300 dark:hover:text-secondary-green' }}">
                        Ringkasan
                    </button>
                    @if ($isOwner || $isEcosystemBuilder)
                        <button wire:click="setActiveTab('members')"
                            class="px-3 sm:px-4 py-2 font-medium text-sm sm:text-base
                                {{ $activeTab === 'members'
                                    ? 'border-b-2 border-sky-500 text-sky-600 dark:border-secondary-green dark:text-secondary-green'
                                    : 'text-neutral-600 hover:text-sky-600 dark:text-neutral-300 dark:hover:text-secondary-green' }}">
                            <span class="flex items-center">
                                Anggota
                                @if ($pendingRequests->count() > 0)
                                    <span
                                        class="ml-1 sm:ml-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 py-0.5 px-1.5 sm:py-1 sm:px-2 rounded-full text-xs">{{ $pendingRequests->count() }}</span>
                                @endif
                            </span>
                        </button>
                        @if ($isOwner)
                            <button wire:click="setActiveTab('invitations')"
                                class="px-3 sm:px-4 py-2 font-medium text-sm sm:text-base
                                    {{ $activeTab === 'invitations'
                                        ? 'border-b-2 border-sky-500 text-sky-600 dark:border-secondary-green dark:text-secondary-green'
                                        : 'text-neutral-600 hover:text-sky-600 dark:text-neutral-300 dark:hover:text-secondary-green' }}">
                                <span class="flex items-center">
                                    Undangan Aksi
                                    @if ($pendingInvitations->count() > 0)
                                        <span
                                            class="ml-1 sm:ml-2 bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 py-0.5 px-1.5 sm:py-1 sm:px-2 rounded-full text-xs">{{ $pendingInvitations->count() }}</span>
                                    @endif
                                </span>
                            </button>
                        @endif
                    @endif
                    <button wire:click="setActiveTab('quality')"
                        class="px-3 sm:px-4 py-2 font-medium text-sm sm:text-base
                            {{ $activeTab === 'quality'
                                ? 'border-b-2 border-sky-500 text-sky-600 dark:border-secondary-green dark:text-secondary-green'
                                : 'text-neutral-600 hover:text-sky-600 dark:text-neutral-300 dark:hover:text-secondary-green' }}">
                        Kualitas & Keahlian
                    </button>
                    <button wire:click="setActiveTab('actions')"
                        class="px-3 sm:px-4 py-2 font-medium text-sm sm:text-base
                            {{ $activeTab === 'actions'
                                ? 'border-b-2 border-sky-500 text-sky-600 dark:border-secondary-green dark:text-secondary-green'
                                : 'text-neutral-600 hover:text-sky-600 dark:text-neutral-300 dark:hover:text-secondary-green' }}">
                        Aksi Kolektif
                    </button>
                    <button wire:click="setActiveTab('contributions')"
                        class="px-3 sm:px-4 py-2 font-medium text-sm sm:text-base
                            {{ $activeTab === 'contributions'
                                ? 'border-b-2 border-sky-500 text-sky-600 dark:border-secondary-green dark:text-secondary-green'
                                : 'text-neutral-600 hover:text-sky-600 dark:text-neutral-300 dark:hover:text-secondary-green' }}">
                        <span class="flex items-center">
                            Kontribusi
                            @if ($pendingContributions->count() > 0)
                                <span
                                    class="ml-1 sm:ml-2 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 py-0.5 px-1.5 sm:py-1 sm:px-2 rounded-full text-xs">{{ $pendingContributions->count() }}</span>
                            @endif
                        </span>
                    </button>
                </nav>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            <!-- Overview Tab -->
            @if ($activeTab === 'overview')
                <div class="space-y-6">
                    <!-- Quality Overview -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        <!-- Overall Ekosistem Score -->
                        <div
                            class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-4 sm:p-6 border border-green-200 dark:border-green-800">
                            <div class="text-center">
                                <div class="text-2xl sm:text-3xl font-bold text-green-700 dark:text-green-400">
                                    {{ $ecosystemQuality['ekosistem_score'] }}%</div>
                                <div class="text-xs sm:text-sm text-green-600 dark:text-green-300 mt-1">Kualitas
                                    Ekosistem</div>
                                <div class="text-xs text-green-500 dark:text-green-400 mt-1">Berdasarkan Keragaman
                                    Peran</div>
                            </div>
                        </div>

                        <!-- Role Diversity Score -->
                        <div
                            class="bg-gradient-to-r from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-lg p-4 sm:p-6 border border-cyan-200 dark:border-cyan-800">
                            <div class="text-center">
                                <div class="text-2xl sm:text-3xl font-bold text-cyan-700 dark:text-cyan-400">
                                    {{ $ecosystemQuality['role_diversity_score'] }}%</div>
                                <div class="text-xs sm:text-sm text-cyan-600 dark:text-cyan-300 mt-1">Keragaman Peran
                                </div>
                                <div class="text-xs text-cyan-500 dark:text-cyan-400 mt-1">Peran Ada / Total Peran
                                </div>
                            </div>
                        </div>

                        <!-- Role Statistics -->
                        <div
                            class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-4 sm:p-6 border border-blue-200 dark:border-blue-800 sm:col-span-2 lg:col-span-1">
                            <div class="text-center">
                                <div class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-primary-blue">
                                    {{ $ecosystemQuality['details']['existing_roles_count'] }}/{{ $ecosystemQuality['details']['total_roles_in_database'] }}
                                </div>
                                <div class="text-xs sm:text-sm text-primary-blue dark:text-primary-blue mt-1">Peran
                                    Tersedia
                                </div>
                                <div class="text-xs text-primary-blue dark:text-primary-blue mt-1">Dari Total Database
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div
                        class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-4 sm:p-6 border border-gray-200 dark:border-slate-600">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-slate-100 mb-3">Deskripsi
                            Ekosistem
                        </h3>
                        <p class="text-sm sm:text-base text-gray-700 dark:text-slate-300">
                            {{ $ecosystem->description ?: 'Belum ada deskripsi.' }}</p>
                    </div>

                    <!-- User Status Info (for non-owners) -->
                    @if (!$isOwner)
                        @php
                            $userStatus = $ecosystem->getUserStatus(Auth::user());
                            $canJoin = $ecosystem->canUserJoin(Auth::user());
                        @endphp

                        <div
                            class="bg-primary-light-blue dark:bg-primary-blue/20 border border-primary-blue/20 dark:border-primary-blue/30 rounded-lg p-4 sm:p-6">
                            <h3
                                class="text-base sm:text-lg font-semibold text-primary-blue dark:text-primary-blue mb-3">
                                Status
                                Anda</h3>

                            @if ($userStatus === 'accepted')
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                                    <div class="flex items-center text-green-700 dark:text-green-300">
                                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="font-medium text-sm sm:text-base">Anda adalah anggota aktif dari
                                            ekosistem ini</span>
                                    </div>
                                    @if ($ecosystem->canUserContribute(Auth::user()))
                                        <a href="{{ route('ecosystem.contribute', $ecosystem) }}" wire:navigate
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors w-full sm:w-auto text-center">
                                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Berkontribusi
                                        </a>
                                    @endif
                                </div>
                            @elseif($userStatus === 'pending')
                                <div class="flex items-center text-amber-700 dark:text-amber-300">
                                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium text-sm sm:text-base">Permintaan bergabung Anda sedang
                                        menunggu
                                        persetujuan</span>
                                </div>
                            @elseif($canJoin)
                                @if (Auth::user()->isGuestOrInvitation())
                                    <!-- Like button for guest/invitation users -->
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                                        <div class="flex items-center text-primary-blue dark:text-primary-blue">
                                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            <span class="font-medium text-sm sm:text-base">Anda dapat melihat dan menyukai
                                                ekosistem ini</span>
                                        </div>
                                        <button id="like-button" 
                                            class="{{ $isLiked ? 'bg-red-600 hover:bg-red-700' : 'bg-red-500 hover:bg-red-600' }} text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2 w-full sm:w-auto justify-center"
                                            onclick="toggleLike('ecosystem', {{ $ecosystem->id }})">
                                            <svg id="like-icon" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span id="like-text">{{ $isLiked ? 'Disukai' : 'Suka' }}</span>
                                            <span id="like-count" class="bg-red-600 px-2 py-1 rounded-full text-xs">{{ $likeCount }}</span>
                                        </button>
                                    </div>
                                @else
                                    <!-- Regular join button for partisipan users -->
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                                        <div class="flex items-center text-primary-blue dark:text-primary-blue">
                                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            <span class="font-medium text-sm sm:text-base">Anda dapat bergabung dengan
                                                ekosistem ini</span>
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ route('ecosystem.join', $ecosystem) }}" wire:navigate
                                                class="bg-primary-blue hover:bg-primary-blue/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors w-full sm:w-auto text-center">
                                                Bergabung Sekarang
                                            </a>
                                            <button id="like-button" 
                                                class="{{ $isLiked ? 'bg-red-600 hover:bg-red-700' : 'bg-red-500 hover:bg-red-600' }} text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2"
                                                onclick="toggleLike('ecosystem', {{ $ecosystem->id }})">
                                                <svg id="like-icon" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span id="like-text">{{ $isLiked ? 'Disukai' : 'Suka' }}</span>
                                                <span id="like-count" class="bg-red-600 px-2 py-1 rounded-full text-xs">{{ $likeCount }}</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="flex items-center text-gray-700 dark:text-gray-300">
                                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium text-sm sm:text-base">Anda tidak dapat bergabung dengan
                                        ekosistem ini</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Recent Activities -->
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Aktivitas Terbaru</h3>
                        </div>
                        <div class="p-6">
                            @if ($isOwner)
                                @if ($ecosystem->canUserContribute(Auth::user()))
                                    <div
                                        class="flex items-center max-md:flex-col-reverse max-md:items-start justify-between text-primary-blue dark:text-primary-blue mb-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-3 h-3 bg-primary-blue dark:bg-primary-blue rounded-full mr-3">
                                            </div>
                                            <span>Anda adalah pemilik ekosistem dan dapat berkontribusi</span>
                                        </div>
                                        <a href="{{ route('ecosystem.contribute', $ecosystem) }}"
                                            class="bg-primary-blue hover:bg-primary-blue/90 text-white px-3 max-md:mb-4 py-1 rounded text-sm font-medium transition-colors">
                                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Berkontribusi
                                        </a>
                                    </div>
                                @endif

                                @if ($pendingRequests->count() > 0)
                                    <div class="flex items-center text-amber-600 dark:text-amber-400 mb-4">
                                        <div class="w-3 h-3 bg-amber-500 dark:bg-amber-400 rounded-full mr-3"></div>
                                        <span>{{ $pendingRequests->count() }} permintaan bergabung menunggu
                                            persetujuan</span>
                                    </div>
                                @endif

                                @if ($ecosystem->acceptedUsers()->count() === 0)
                                    <div class="flex items-center text-gray-500 dark:text-slate-400">
                                        <div class="w-3 h-3 bg-gray-400 dark:bg-slate-500 rounded-full mr-3"></div>
                                        <span>Belum ada anggota yang bergabung</span>
                                    </div>
                                @else
                                    <div class="flex items-center text-green-600 dark:text-green-400">
                                        <div class="w-3 h-3 bg-green-500 dark:bg-green-400 rounded-full mr-3"></div>
                                        <span>{{ $ecosystem->acceptedUsers()->count() }} anggota telah bergabung</span>
                                    </div>
                                @endif
                            @else
                                @php
                                    $userStatus = $ecosystem->getUserStatus(Auth::user());
                                @endphp

                                @if ($userStatus === 'accepted')
                                    <div class="flex items-center text-green-600 dark:text-green-400 mb-4">
                                        <div class="w-3 h-3 bg-green-500 dark:bg-green-400 rounded-full mr-3"></div>
                                        <span>Anda adalah anggota aktif dari ekosistem ini</span>
                                    </div>
                                @elseif($userStatus === 'pending')
                                    <div class="flex items-center text-amber-600 dark:text-amber-400 mb-4">
                                        <div class="w-3 h-3 bg-amber-500 dark:bg-amber-400 rounded-full mr-3"></div>
                                        <span>Permintaan bergabung Anda sedang menunggu persetujuan</span>
                                    </div>
                                @else
                                    <div class="flex items-center text-primary-blue dark:text-primary-blue mb-4">
                                        <div class="w-3 h-3 bg-primary-blue dark:bg-primary-blue rounded-full mr-3">
                                        </div>
                                        <span>Anda dapat bergabung dengan ekosistem ini</span>
                                    </div>
                                @endif

                                <div class="flex items-center text-gray-500 dark:text-slate-400">
                                    <div class="w-3 h-3 bg-gray-400 dark:bg-slate-500 rounded-full mr-3"></div>
                                    <span>{{ $ecosystem->acceptedUsers()->count() }} anggota aktif</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contribution Analytics Charts -->
            @if ($activeTab === 'overview')
                @php
                    $analyticsData = $analyticsData ?? $ecosystem->getEcosystemAnalytics();
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm mt-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Analisis Kontribusi Ekosistem
                    </h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Contribution Types Chart -->
                        <div>
                            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-4">Jenis Kontribusi</h3>
                            <div class="relative" style="height: 300px;">
                                <canvas id="ecosystemContributionTypesChart" wire:ignore></canvas>
                            </div>
                        </div>

                        <!-- Contribution Status Chart -->
                        <div>
                            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-4">Status Kontribusi</h3>
                            <div class="relative" style="height: 300px;">
                                <canvas id="ecosystemContributionStatusChart" wire:ignore></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                        <!-- Member Status Chart -->
                        <div>
                            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-4">Status Anggota</h3>
                            <div class="relative" style="height: 300px;">
                                <canvas id="ecosystemMemberStatusChart" wire:ignore></canvas>
                            </div>
                        </div>

                        <!-- Role Diversity Chart -->
                        <div>
                            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-4">Keragaman Peran</h3>
                            <div class="relative" style="height: 300px;">
                                <canvas id="ecosystemRoleDiversityChart" wire:ignore></canvas>
                            </div>
                        </div>
                    </div> --}}
                </div>
            @endif

            <!-- Members Tab -->
            @if ($activeTab === 'members')
                <div class="space-y-6">
                    @if ($isReadOnly)
                        <div
                            class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400 mr-2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <p class="text-orange-800 dark:text-orange-200 text-sm">
                                    <strong>Mode Lihat Saja:</strong> Anda hanya dapat melihat informasi anggota. Untuk
                                    mengelola anggota, Anda perlu menjadi ecosystem builder atau pemilik ekosistem.
                                </p>
                            </div>
                        </div>
                    @endif
                    <!-- Pending Requests -->
                    @if ($pendingRequests->count() > 0)
                        <div
                            class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                            <div class="p-6 border-b border-amber-200 dark:border-amber-800">
                                <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-200">Permintaan
                                    Bergabung ({{ $pendingRequests->count() }})</h3>
                            </div>
                            <div class="divide-y divide-amber-200 dark:divide-amber-800">
                                @foreach ($pendingRequests as $request)
                                    <div class="p-6 flex items-start justify-between">
                                        <div class="flex items-start space-x-4">
                                            <div
                                                class="w-12 h-12 bg-gray-300 dark:bg-slate-600 rounded-full flex items-center justify-center">
                                                @if ($request->profile && $request->profile->profile_photo)
                                                    <img src="{{ asset('storage/' . $request->profile->profile_photo) }}"
                                                        alt="{{ $request->name }}"
                                                        class="w-12 h-12 rounded-full object-cover">
                                                @else
                                                    <span
                                                        class="text-lg text-gray-600 dark:text-slate-300">{{ substr($request->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-slate-100">
                                                    {{ $request->name }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-slate-300">
                                                    {{ $request->email }}</p>
                                                @if ($request->profile && $request->profile->organization)
                                                    <p class="text-sm text-gray-500 dark:text-slate-400">
                                                        {{ $request->profile->organization }}</p>
                                                @endif
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-700 dark:text-slate-300"><strong>Alasan
                                                            bergabung:</strong></p>
                                                    <p class="text-sm text-gray-600 dark:text-slate-400">
                                                        {{ $request->pivot->join_reason }}</p>
                                                </div>
                                                @if ($request->profile && $request->profile->skills->count() > 0)
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-700 dark:text-slate-300 mb-1">
                                                            <strong>Keahlian:</strong>
                                                        </p>
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach ($request->profile->skills->take(5) as $skill)
                                                                <span
                                                                    class="inline-block bg-neutral-orange/20 dark:bg-neutral-orange/30 text-neutral-orange dark:text-neutral-orange text-xs px-2 py-1 rounded">{{ $skill->name }}</span>
                                                            @endforeach
                                                            @if ($request->profile->skills->count() > 5)
                                                                <span
                                                                    class="inline-block bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 text-xs px-2 py-1 rounded">+{{ $request->profile->skills->count() - 5 }}
                                                                    lainnya</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($isOwner)
                                            <div class="flex space-x-2">
                                                <button wire:click="acceptMember({{ $request->id }})"
                                                    class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                    Terima
                                                </button>
                                                <button wire:click="rejectMember({{ $request->id }})"
                                                    class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                    Tolak
                                                </button>
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-500 dark:text-slate-400">
                                                Menunggu persetujuan pemilik
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Accepted Members -->
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Anggota Aktif
                                ({{ $acceptedMembers->total() }})</h3>
                        </div>
                        @if ($acceptedMembers->count() > 0)
                            <div class="divide-y divide-gray-200 dark:divide-slate-700">
                                @foreach ($acceptedMembers as $member)
                                    <div class="p-6 flex-wrap gap-4 flex items-start justify-between">
                                        <div class="flex flex-wrap gap-4 items-start space-x-4">
                                            <div
                                                class="w-12 h-12 bg-gray-300 dark:bg-slate-600 rounded-full flex items-center justify-center">
                                                @if ($member->profile && $member->profile->profile_photo)
                                                    <img src="{{ asset('storage/' . $member->profile->profile_photo) }}"
                                                        alt="{{ $member->name }}"
                                                        class="w-12 h-12 rounded-full object-cover">
                                                @else
                                                    <span
                                                        class="text-lg text-gray-600 dark:text-slate-300">{{ substr($member->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-slate-100">
                                                    {{ $member->name }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-slate-300">
                                                    {{ $member->email }}</p>
                                                @if ($member->profile && $member->profile->organization)
                                                    <p class="text-sm text-gray-500 dark:text-slate-400">
                                                        {{ $member->profile->organization }}</p>
                                                @endif
                                                @if ($member->pivot->joined_at)
                                                    <p class="text-sm text-gray-500 dark:text-slate-400">Bergabung:
                                                        {{ Carbon\Carbon::parse($member->pivot->joined_at)->format('d M Y') }}
                                                    </p>
                                                @endif
                                                @if ($member->profile && $member->profile->skills->count() > 0)
                                                    <div class="mt-2">
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach ($member->profile->skills->take(5) as $skill)
                                                                <span
                                                                    class="inline-block bg-neutral-orange/20 dark:bg-neutral-orange/30 text-neutral-orange dark:text-neutral-orange text-xs px-2 py-1 rounded">{{ $skill->name }}</span>
                                                            @endforeach
                                                            @if ($member->profile->skills->count() > 5)
                                                                <span
                                                                    class="inline-block bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 text-xs px-2 py-1 rounded">+{{ $member->profile->skills->count() - 5 }}
                                                                    lainnya</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- @if ($isOwner)
                                            <div class="flex space-x-2">
                                                <button wire:click="removeMember({{ $member->id }})"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengeluarkan {{ $member->name }} dari ekosistem ini?')"
                                                    class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                    Keluarkan
                                                </button>
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-500 dark:text-slate-400">
                                                Anggota aktif
                                            </div>
                                        @endif --}}
                                    </div>
                                @endforeach
                            </div>
                            <div class="p-6 border-t border-gray-200 dark:border-slate-700">
                                {{ $acceptedMembers->links() }}
                            </div>
                        @else
                            <div class="p-6 text-center text-gray-500 dark:text-slate-400">
                                Belum ada anggota yang bergabung.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quality Tab -->
            @if ($activeTab === 'quality')
                <div class="space-y-6" wire:key="quality-tab-{{ $activeTab }}">
                    <!-- Overall Score -->
                    <div
                        class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-8 border border-green-200 dark:border-green-800 text-center">
                        <div class="text-6xl font-bold text-green-700 dark:text-green-400 mb-2">
                            {{ $ecosystemQuality['ekosistem_score'] }}%
                        </div>
                        <div class="text-xl text-green-600 dark:text-green-300 font-semibold">Kualitas Ekosistem</div>
                        <div class="text-sm text-green-500 dark:text-green-400 mt-2">
                            Berdasarkan Keragaman Peran: Peran yang Ada / Total Peran di Database
                        </div>
                    </div>

                    <!-- Detailed Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Role Diversity Score -->
                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-slate-100">Keragaman
                                        Peran</div>
                                    <div class="text-sm text-gray-500 dark:text-slate-400">Peran Ada / Total Peran
                                    </div>
                                </div>
                                <div class="text-3xl font-bold text-cyan-600 dark:text-cyan-400">
                                    {{ $ecosystemQuality['role_diversity_score'] }}%
                                </div>
                            </div>
                            <div class="space-y-2 text-sm text-gray-600 dark:text-slate-400">
                                <div class="flex justify-between">
                                    <span>Peran yang ada:</span>
                                    <span
                                        class="font-medium text-cyan-600">{{ $ecosystemQuality['details']['existing_roles_count'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Total peran database:</span>
                                    <span
                                        class="font-medium">{{ $ecosystemQuality['details']['total_roles_in_database'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Persentase:</span>
                                    <span
                                        class="font-medium text-green-600">{{ $ecosystemQuality['ekosistem_score'] }}%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Role Statistics -->
                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-slate-100">Statistik
                                        Peran</div>
                                    <div class="text-sm text-gray-500 dark:text-slate-400">Detail Peran</div>
                                </div>
                                <div class="text-3xl font-bold text-primary-blue dark:text-primary-blue">
                                    {{ $ecosystemQuality['details']['existing_roles_count'] }}/{{ $ecosystemQuality['details']['total_roles_in_database'] }}
                                </div>
                            </div>
                            <div class="space-y-2 text-sm text-gray-600 dark:text-slate-400">
                                <div class="flex justify-between">
                                    <span>Peran tersedia:</span>
                                    <span
                                        class="font-medium text-primary-blue">{{ $ecosystemQuality['details']['existing_roles_count'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Total peran:</span>
                                    <span
                                        class="font-medium">{{ $ecosystemQuality['details']['total_roles_in_database'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Peran tersisa:</span>
                                    <span
                                        class="font-medium text-orange-600">{{ $ecosystemQuality['details']['total_roles_in_database'] - $ecosystemQuality['details']['existing_roles_count'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Existing Roles List -->
                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6">
                            <div class="mb-4">
                                <div class="text-lg font-semibold text-gray-900 dark:text-slate-100">Peran yang Ada
                                </div>
                                <div class="text-sm text-gray-500 dark:text-slate-400">Daftar Peran di Ekosistem</div>
                            </div>
                            @if (!empty($ecosystemQuality['details']['existing_role_names']))
                                <div class="space-y-2">
                                    @foreach ($ecosystemQuality['details']['existing_role_names'] as $roleName)
                                        <div class="flex items-center gap-2 text-sm">
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            <span class="text-gray-700 dark:text-slate-300">{{ $roleName }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-sm text-gray-500 dark:text-slate-400 italic">
                                    Belum ada peran yang ditetapkan
                                </div>
                            @endif
                        </div>

                    </div>

                    <!-- Progress Bars Section -->
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Progress Keragaman
                                Peran</h3>
                            <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">Visualisasi pencapaian keragaman
                                peran ekosistem</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Main Role Diversity Progress -->
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-gray-900 dark:text-slate-100">Keragaman Peran</span>
                                    <span class="text-xl font-bold text-cyan-600 dark:text-cyan-400">
                                        {{ $ecosystemQuality['role_diversity_score'] }}%
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-3">
                                    <div class="bg-cyan-500 h-3 rounded-full transition-all duration-1000 ease-out"
                                        style="width: {{ $ecosystemQuality['role_diversity_score'] }}%"></div>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-slate-400">
                                    {{ $ecosystemQuality['details']['existing_roles_count'] }} dari
                                    {{ $ecosystemQuality['details']['total_roles_in_database'] }} peran tersedia
                                </div>
                            </div>

                            <!-- Role Coverage Progress -->
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-gray-900 dark:text-slate-100">Cakupan Peran</span>
                                    <span class="text-lg font-bold text-primary-blue dark:text-primary-blue">
                                        {{ $ecosystemQuality['details']['existing_roles_count'] }}/{{ $ecosystemQuality['details']['total_roles_in_database'] }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                    <div class="bg-primary-blue h-2 rounded-full transition-all duration-1000 ease-out"
                                        style="width: {{ $ecosystemQuality['role_diversity_score'] }}%"></div>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-slate-400">
                                    {{ $ecosystemQuality['details']['total_roles_in_database'] - $ecosystemQuality['details']['existing_roles_count'] }}
                                    peran tersisa untuk dicapai
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Role Diversity Summary -->
                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Ringkasan Keragaman
                                    Peran</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-slate-400">Peran yang Ada:</span>
                                    <span
                                        class="font-semibold text-cyan-600 dark:text-cyan-400">{{ $ecosystemQuality['details']['existing_roles_count'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-slate-400">Total Peran Database:</span>
                                    <span
                                        class="font-semibold text-gray-900 dark:text-slate-100">{{ $ecosystemQuality['details']['total_roles_in_database'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-slate-400">Peran Tersisa:</span>
                                    <span
                                        class="font-semibold text-orange-600 dark:text-orange-400">{{ $ecosystemQuality['details']['total_roles_in_database'] - $ecosystemQuality['details']['existing_roles_count'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-slate-400">Kualitas Ekosistem:</span>
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium {{ $ecosystemQuality['ekosistem_score'] >= 80 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : ($ecosystemQuality['ekosistem_score'] >= 60 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300') }}">
                                        {{ $ecosystemQuality['ekosistem_score'] }}% -
                                        {{ $ecosystemQuality['ekosistem_score'] >= 80 ? 'Sangat Baik' : ($ecosystemQuality['ekosistem_score'] >= 60 ? 'Baik' : 'Perlu Ditingkatkan') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Role Diversity Insights -->
                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Insight Keragaman
                                    Peran</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                @php
                                    $rolePercentage =
                                        $ecosystemQuality['details']['total_roles_in_database'] > 0
                                            ? round(
                                                ($ecosystemQuality['details']['existing_roles_count'] /
                                                    $ecosystemQuality['details']['total_roles_in_database']) *
                                                    100,
                                                1,
                                            )
                                            : 0;

                                    $remainingRoles =
                                        $ecosystemQuality['details']['total_roles_in_database'] -
                                        $ecosystemQuality['details']['existing_roles_count'];

                                    $status = '';
                                    $statusColor = '';
                                    if ($rolePercentage >= 80) {
                                        $status = 'Sangat Baik';
                                        $statusColor = 'text-green-600 dark:text-green-400';
                                    } elseif ($rolePercentage >= 60) {
                                        $status = 'Baik';
                                        $statusColor = 'text-yellow-600 dark:text-yellow-400';
                                    } elseif ($rolePercentage >= 40) {
                                        $status = 'Cukup';
                                        $statusColor = 'text-orange-600 dark:text-orange-400';
                                    } else {
                                        $status = 'Perlu Ditingkatkan';
                                        $statusColor = 'text-red-600 dark:text-red-400';
                                    }
                                @endphp

                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-slate-400">Persentase Pencapaian:</span>
                                    <span class="font-semibold {{ $statusColor }}">{{ $rolePercentage }}%</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-slate-400">Status Keragaman:</span>
                                    <span class="font-semibold {{ $statusColor }}">{{ $status }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-slate-400">Peran Tersisa:</span>
                                    <span
                                        class="font-semibold text-orange-600 dark:text-orange-400">{{ $remainingRoles }}
                                        peran</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-slate-400">Potensi Peningkatan:</span>
                                    <span
                                        class="font-semibold text-primary-blue dark:text-primary-blue">{{ 100 - $rolePercentage }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

            <!-- Actions Tab -->
            @if ($activeTab === 'actions')
                <div class="space-y-6">
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Aksi Kolektif</h3>
                        </div>
                        <div class="p-6">
                            @if ($ecosystem->collectiveActions->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($ecosystem->collectiveActions as $action)
                                        <div
                                            class="border border-gray-200 dark:border-slate-700 rounded-lg p-4 bg-gray-50 dark:bg-slate-700/50">
                                            <a href="{{ route('collective-action.show', $action) }}"
                                                class="font-semibold hover:text-primary-blue dark:hover:text-secondary-green text-gray-900 dark:text-slate-100">
                                                {{ $action->title }}</a>
                                            <p class="text-sm text-gray-600 dark:text-slate-300 mt-1">
                                                {{ $action->description }}</p>
                                            <div
                                                class="flex flex-wrap gap-2 items-center space-x-4 mt-2 text-sm text-gray-500 dark:text-slate-400">
                                                <span>📅
                                                    {{ $action->start_date ? $action->start_date->format('d M Y') : 'Tanggal belum ditentukan' }}</span>
                                                <span>📍 {{ $action->location ?? 'Lokasi belum ditentukan' }}</span>
                                                <span
                                                    class="px-2 py-1 rounded text-xs {{ $action->status === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-gray-100 dark:bg-slate-600 text-gray-800 dark:text-slate-300' }}">
                                                    {{ ucfirst($action->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-gray-500 dark:text-slate-400">
                                    <div class="text-4xl mb-2">📋</div>
                                    <p>Belum ada aksi kolektif yang dibuat.</p>
                                    @if ($isOwner || $isEcosystemBuilder)
                                        <a href="{{ route('collective-action.create') }}"
                                            class="inline-block mt-4 bg-primary-blue hover:bg-primary-blue/90 dark:bg-primary-blue dark:hover:bg-primary-blue/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            Buat Aksi Kolektif
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Invitations Tab -->
            @if ($activeTab === 'invitations' && $isOwner)
                <div class="space-y-6">
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Undangan Aksi Kolektif
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-slate-300 mt-1">
                                Kelola undangan untuk berkolaborasi dalam aksi kolektif
                            </p>
                        </div>
                        <div class="p-6">
                            @if ($pendingInvitations->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($pendingInvitations as $invitation)
                                        <div
                                            class="border border-orange-200 dark:border-orange-900 rounded-lg p-4 bg-orange-50 dark:bg-orange-900/10">
                                            <div class="flex max-sm:flex-col gap-4 items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-900 dark:text-slate-100">
                                                        {{ $invitation->collectiveAction->title }}
                                                    </h4>
                                                    <div class="flex flex-wrap items-center gap-3 mt-2">
                                                        <span
                                                            class="inline-flex flex-wrap items-center px-2 py-1 rounded-full text-xs 
                                                            @if ($invitation->collectiveAction->scale === 'kecil') bg-green-100 dark:bg-green-800/60 text-green-800 dark:text-green-200
                                                            @elseif($invitation->collectiveAction->scale === 'sedang') bg-yellow-100 dark:bg-yellow-800/60 text-yellow-800 dark:text-yellow-200
                                                            @else bg-red-100 dark:bg-red-800/60 text-red-800 dark:text-red-200 @endif">
                                                            {{ $invitation->collectiveAction->scale_label }}
                                                        </span>
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-primary-light-blue dark:bg-primary-blue/30 text-primary-blue dark:text-primary-light-blue">
                                                            {{ $invitation->collectiveAction->scope_label }}
                                                        </span>
                                                        <span class="text-xs text-gray-500 dark:text-slate-400">
                                                            📅
                                                            {{ $invitation->collectiveAction->start_date->format('d M Y') }}
                                                        </span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 dark:text-slate-300 mt-2">
                                                        {{ Str::limit($invitation->collectiveAction->description, 150) }}
                                                    </p>
                                                    @if ($invitation->invitation_message)
                                                        <div class="mt-3 bg-gray-100 dark:bg-slate-800/60 rounded-lg">
                                                            <p class="text-sm text-gray-700 dark:text-slate-300">
                                                                <strong>Pesan:</strong>
                                                                {{ $invitation->invitation_message }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                    <div
                                                        class="flex flex-wrap gap-2 items-center mt-3 text-sm text-gray-500 dark:text-slate-400">
                                                        <div class="flex-shrink-02">
                                                            <div
                                                                class="w-6 h-6 bg-gradient-to-r from-orange-600 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-medium">
                                                                {{ $invitation->invitedBy->initials() }}
                                                            </div>
                                                        </div>
                                                        <span>Diundang oleh {{ $invitation->invitedBy->name }}</span>
                                                        <span class="">•</span>
                                                        <span>{{ $invitation->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <a href="{{ route('collective-action.respond-invitation', $invitation) }}"
                                                        class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                        <svg class="w-4 h-4 mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                        </svg>
                                                        Respons
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-gray-500 dark:text-slate-400">
                                    <div class="text-4xl mb-2">📬</div>
                                    <p>Belum ada undangan aksi kolektif.</p>
                                    <p class="text-sm mt-1">Undangan akan muncul di sini ketika ecosystem builders lain
                                        mengundang Anda berkolaborasi.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contributions Tab -->
            @if ($activeTab === 'contributions')
                <div class="space-y-6">
                    <!-- Contribution Actions -->
                    @if ($isOwner || $isEcosystemBuilder)
                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-4 sm:p-6">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                                <div class="flex-1">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-slate-100">
                                        Kelola Kontribusi</h3>
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-slate-400 mt-1">Terima, tolak,
                                        atau selesaikan kontribusi dari anggota</p>
                                </div>
                                <div class="text-xs sm:text-sm text-gray-500 dark:text-slate-400">
                                    {{ $contributions->total() }} total kontribusi
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Pending Contributions -->
                    @if ($pendingContributions->count() > 0)
                        <div
                            class="border border-orange-200 dark:border-orange-900 rounded-lg bg-orange-50 dark:bg-orange-900/10">
                            <div class="p-6 border-b border-orange-200 dark:border-orange-900">
                                <h3 class="text-lg font-semibold text-orange-800 dark:text-orange-200">Kontribusi
                                    Menunggu Persetujuan ({{ $pendingContributions->count() }})</h3>
                            </div>
                            <div class="divide-y divide-orange-200 dark:divide-orange-900">
                                @foreach ($pendingContributions as $contribution)
                                    <div class="p-6">
                                        <div class="flex flex-wrap gap-4 items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex flex-wrap items-center gap-3 mb-3">
                                                    <div
                                                        class="w-10 h-10 bg-gray-300 dark:bg-slate-600 rounded-full flex items-center justify-center">
                                                        @if ($contribution->user->profile && $contribution->user->profile->profile_photo)
                                                            <img src="{{ asset('storage/' . $contribution->user->profile->profile_photo) }}"
                                                                alt="{{ $contribution->user->name }}"
                                                                class="w-10 h-10 rounded-full object-cover">
                                                        @else
                                                            <span
                                                                class="text-sm text-gray-600 dark:text-slate-300">{{ substr($contribution->user->name, 0, 1) }}</span>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold text-gray-900 dark:text-slate-100">
                                                            {{ $contribution->user->name }}</h4>
                                                        <p class="text-sm text-gray-600 dark:text-slate-300">
                                                            {{ $contribution->user->email }}</p>
                                                    </div>
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs {{ $contribution->status_color_class }}">
                                                        {{ $contribution->contribution_type_label }}
                                                    </span>
                                                </div>

                                                <div class="mb-3">
                                                    <p class="text-sm text-gray-700 dark:text-slate-300">
                                                        <strong>Deskripsi:</strong>
                                                    </p>
                                                    <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">
                                                        {{ $contribution->contribution_description }}</p>
                                                </div>

                                                @if ($contribution->contribution_amount)
                                                    <div class="mb-3">
                                                        <p class="text-sm text-gray-700 dark:text-slate-300">
                                                            <strong>Jumlah:</strong> Rp
                                                            {{ number_format($contribution->contribution_amount, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                @endif

                                                @if ($contribution->contribution_details)
                                                    <div class="mb-3">
                                                        <p class="text-sm text-gray-700 dark:text-slate-300">
                                                            <strong>Detail Tambahan:</strong>
                                                        </p>
                                                        <div class="mt-1 space-y-1">
                                                            @foreach ($contribution->contribution_details as $detail)
                                                                <div class="text-sm text-gray-600 dark:text-slate-400">
                                                                    • {{ $detail['type'] ?? 'N/A' }}:
                                                                    {{ $detail['description'] ?? 'N/A' }}
                                                                    @if (isset($detail['quantity']) && $detail['quantity'])
                                                                        ({{ $detail['quantity'] }})
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="text-xs text-gray-500 dark:text-slate-400">
                                                    Diajukan
                                                    {{ $contribution->offered_at ? $contribution->offered_at->diffForHumans() : 'N/A' }}
                                                </div>
                                            </div>

                                            @if ($isOwner)
                                                <div class="flex space-x-2">
                                                    <button wire:click="acceptContribution({{ $contribution->id }})"
                                                        class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                        Terima
                                                    </button>
                                                    <button wire:click="declineContribution({{ $contribution->id }})"
                                                        class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                        Tolak
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- All Contributions -->
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-slate-100">Semua
                                Kontribusi</h3>
                        </div>
                        @if ($contributions->count() > 0)
                            <div class="divide-y divide-gray-200 dark:divide-slate-700">
                                @foreach ($contributions as $contribution)
                                    <div class="p-4 sm:p-6">
                                        <div class="space-y-3">
                                            <div class="flex items-start space-x-3">
                                                <div
                                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-300 dark:bg-slate-600 rounded-full flex items-center justify-center flex-shrink-0">
                                                    @if ($contribution->user->profile && $contribution->user->profile->profile_photo)
                                                        <img src="{{ asset('storage/' . $contribution->user->profile->profile_photo) }}"
                                                            alt="{{ $contribution->user->name }}"
                                                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover">
                                                    @else
                                                        <span
                                                            class="text-xs sm:text-sm text-gray-600 dark:text-slate-300">{{ substr($contribution->user->name, 0, 1) }}</span>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4
                                                        class="font-semibold text-gray-900 dark:text-slate-100 text-sm sm:text-base truncate">
                                                        {{ $contribution->user->name }}</h4>
                                                    <p
                                                        class="text-xs sm:text-sm text-gray-600 dark:text-slate-300 truncate">
                                                        {{ $contribution->user->email }}</p>
                                                </div>
                                            </div>

                                            <div class="flex flex-wrap gap-2">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs {{ $contribution->status_color_class }}">
                                                    {{ $contribution->status_label }}
                                                </span>
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-primary-light-blue dark:bg-primary-blue text-primary-blue dark:text-primary-light-blue">
                                                    {{ $contribution->contribution_type_label }}
                                                </span>
                                            </div>

                                            <div>
                                                <p
                                                    class="text-xs sm:text-sm text-gray-700 dark:text-slate-300 font-medium">
                                                    Deskripsi:</p>
                                                <p class="text-xs sm:text-sm text-gray-600 dark:text-slate-400 mt-1">
                                                    {{ Str::limit($contribution->contribution_description, 100) }}</p>
                                            </div>

                                            @if ($contribution->contribution_amount)
                                                <div>
                                                    <p class="text-xs sm:text-sm text-gray-700 dark:text-slate-300">
                                                        <strong>Jumlah:</strong> Rp
                                                        {{ number_format($contribution->contribution_amount, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            @endif

                                            <div class="text-xs text-gray-500 dark:text-slate-400">
                                                @if ($contribution->offered_at)
                                                    Diajukan {{ $contribution->offered_at->diffForHumans() }}
                                                @endif
                                                @if ($contribution->accepted_at)
                                                    • Diterima {{ $contribution->accepted_at->diffForHumans() }}
                                                @endif
                                                @if ($contribution->completed_at)
                                                    • Selesai {{ $contribution->completed_at->diffForHumans() }}
                                                @endif
                                            </div>

                                            @if ($isOwner && $contribution->status === 'accepted')
                                                <div class="pt-2">
                                                    <button
                                                        wire:click="completeContribution({{ $contribution->id }})"
                                                        class="w-full sm:w-auto bg-primary-blue hover:bg-primary-blue/90 dark:bg-primary-blue dark:hover:bg-primary-blue/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                        Tandai Selesai
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="p-4 sm:p-6 border-t border-gray-200 dark:border-slate-700">
                                {{ $contributions->links() }}
                            </div>
                        @else
                            <div class="p-6 text-center text-gray-500 dark:text-slate-400">
                                <div class="text-3xl sm:text-4xl mb-2">🤝</div>
                                <p class="text-sm sm:text-base">Belum ada kontribusi yang diajukan.</p>
                                @if ($ecosystem->canUserContribute(Auth::user()))
                                    <a href="{{ route('ecosystem.contribute', $ecosystem) }}"
                                        class="inline-block mt-4 bg-primary-blue hover:bg-primary-blue/90 dark:bg-primary-blue dark:hover:bg-primary-blue/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        Ajukan Kontribusi
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        let connectionQualityRadarChart = null;

        function initializeConnectionQualityChart() {
            console.log('Initializing connection quality chart...');
            const canvas = document.getElementById('connectionQualityRadarChart');

            if (!canvas) {
                console.log('Canvas not found');
                return;
            }

            // Check if chart already exists and destroy it
            if (connectionQualityRadarChart) {
                console.log('Destroying existing chart...');
                connectionQualityRadarChart.destroy();
                connectionQualityRadarChart = null;
            }

            const ctx = canvas.getContext('2d');
            const connectionData = @json($connectionQualityData);
            console.log('Connection data:', connectionData);

            // Validate data
            if (!connectionData || typeof connectionData !== 'object') {
                console.error('Invalid connection data:', connectionData);
                return;
            }

            // Check if all required data properties exist
            const requiredProps = ['jumlah_koneksi', 'kualitas_koneksi', 'keluasan_jejaring', 'keragaman_keahlian',
                'tingkat_interaksi', 'kekuatan_jejaring'
            ];
            const hasAllProps = requiredProps.every(prop => connectionData.hasOwnProperty(prop));

            if (!hasAllProps) {
                console.error('Missing required data properties:', requiredProps.filter(prop => !connectionData
                    .hasOwnProperty(prop)));
                return;
            }

            // Get theme-aware colors
            function getThemeColors() {
                const isDark = localStorage.getItem('theme') === 'dark' ||
                    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);

                return {
                    isDark: isDark,
                    gridColor: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                    angleLinesColor: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                    textColor: isDark ? '#ffffff' : '#000000',
                    connection: {
                        bg: 'rgba(59, 130, 246, 0.1)',
                        border: 'rgba(59, 130, 246, 0.8)',
                        point: 'rgba(59, 130, 246, 1)'
                    }
                };
            }

            function customRound(value) {
                if (value > 10) {
                    return Math.ceil(value / 10) * 10;
                } else {
                    return Math.ceil(value);
                }
            }

            const themeColors = getThemeColors();

            try {
                connectionQualityRadarChart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: [
                            'Jumlah Koneksi',
                            'Kualitas Koneksi',
                            'Keluasan Jejaring',
                            'Keragaman Keahlian',
                            'Tingkat Interaksi',
                            'Kekuatan Jejaring'
                        ],
                        datasets: [{
                            label: 'Kualitas Koneksi Ekosistem',
                            data: [
                                connectionData.jumlah_koneksi,
                                connectionData.kualitas_koneksi,
                                connectionData.keluasan_jejaring,
                                connectionData.keragaman_keahlian,
                                connectionData.tingkat_interaksi,
                                connectionData.kekuatan_jejaring
                            ],
                            backgroundColor: themeColors.connection.bg,
                            borderColor: themeColors.connection.border,
                            borderWidth: 2,
                            pointBackgroundColor: themeColors.connection.point,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                beginAtZero: true,
                                max: 5,
                                min: 0,
                                ticks: {
                                    stepSize: 1,
                                    backdropColor: 'transparent'
                                },
                                grid: {
                                    color: themeColors.gridColor,
                                    circular: true
                                },
                                angleLines: {
                                    color: themeColors.angleLinesColor
                                }
                            }
                        },
                        elements: {
                            line: {
                                tension: 0.0
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    color: themeColors.textColor,
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating chart:', error);
                connectionQualityRadarChart = null;
            }
        }

        // Function to update chart colors when theme changes
        function updateConnectionChartColors() {
            if (connectionQualityRadarChart) {
                setTimeout(initializeConnectionQualityChart, 200);
            }
        }

        // Listen for theme changes
        function setupThemeListener() {
            // Listen for storage changes (when theme is changed in another tab)
            window.addEventListener('storage', function(e) {
                if (e.key === 'theme') {
                    updateConnectionChartColors();
                }
            });

            // Listen for custom theme change events
            document.addEventListener('themeChanged', function() {
                updateConnectionChartColors();
            });

            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
                if (!localStorage.getItem('theme')) {
                    updateConnectionChartColors();
                }
            });
        }

        // Initialize chart when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // console.log('DOM loaded, checking for quality tab...');
            // Check if quality tab is already active
            const qualityTab = document.querySelector('button[wire\\:click="setActiveTab(\'quality\')"]');
            if (qualityTab && qualityTab.classList.contains('border-primary-blue')) {
                // console.log('Quality tab is active, initializing chart...');
                setTimeout(initializeConnectionQualityChart, 200);
            }
            setupThemeListener();
        });

        // Re-initialize chart when Livewire updates
        document.addEventListener('livewire:navigated', function() {
            setTimeout(function() {
                if (document.getElementById('connectionQualityRadarChart')) {
                    initializeConnectionQualityChart();
                }
            }, 200);
            setupThemeListener();
            setTimeout(initializeEcosystemContributionCharts, 200);
        });

        // Simple approach - just check periodically if chart needs to be initialized
        function checkForChartInitialization() {
            const canvas = document.getElementById('connectionQualityRadarChart');
            const qualityTab = document.querySelector('button[wire\\:click="setActiveTab(\'quality\')"]');

            if (canvas && qualityTab && qualityTab.classList.contains('border-primary-blue') && !
                connectionQualityRadarChart) {
                // console.log('Initializing chart...');
                initializeConnectionQualityChart();
            }
        }

        // Method 1: Using livewire:init event
        document.addEventListener('livewire:init', () => {
            // console.log('Livewire initialized, registering tabChanged listener');
            Livewire.on('tabChanged', (event) => {
                // console.log('Tab changed to:', event.tab);
                if (event.tab === 'overview') {
                    setTimeout(initializeEcosystemContributionCharts, 200);
                }
            });
        });

        // Method 2: Fallback - Direct event listener registration
        if (typeof Livewire !== 'undefined') {
            // console.log('Livewire available, registering fallback tabChanged listener');
            Livewire.on('tabChanged', (event) => {
                // console.log('Tab changed to (fallback):', event.tab);
                if (event.tab === 'overview') {
                    setTimeout(initializeEcosystemContributionCharts, 200);
                }
            });
        } else {
            // console.log('Livewire not available yet, will retry...');
            // Retry after a short delay
            setTimeout(() => {
                if (typeof Livewire !== 'undefined') {
                    // console.log('Livewire now available, registering tabChanged listener');
                    Livewire.on('tabChanged', (event) => {
                        // console.log('Tab changed to (delayed):', event.tab);
                        if (event.tab == 'overview') {
                            console.log('Overview tab is active, initializing chart...');
                            // setTimeout(initializeEcosystemContributionCharts, 5000);
                            setTimeout(initializeEcosystemContributionCharts, 200);
                        }
                    });
                }
            }, 1000);
        }

        // Check every 500ms
        setInterval(checkForChartInitialization, 500);

        // Listen for Livewire updates
        document.addEventListener('livewire:updated', function() {
            // console.log('Livewire updated, checking for chart...');
            setTimeout(function() {
                const canvas = document.getElementById('connectionQualityRadarChart');
                const qualityTab = document.querySelector(
                    'button[wire\\:click="setActiveTab(\'quality\')"]');

                if (canvas && qualityTab && qualityTab.classList.contains('border-primary-blue')) {
                    // console.log('Quality tab is active, initializing chart...');
                    initializeConnectionQualityChart();
                }
            }, 200);
        });

        // Also listen for tab changes
        document.addEventListener('click', function(e) {
            if (e.target && e.target.getAttribute('wire:click') === "setActiveTab('quality')") {
                setTimeout(function() {
                    if (document.getElementById('connectionQualityRadarChart') && !
                        connectionQualityRadarChart) {
                        // console.log('Quality tab clicked, initializing chart...');
                        initializeConnectionQualityChart();
                    }
                }, 300);
            }
        });

        // Also try to initialize when the page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(initializeConnectionQualityChart, 200);
            setupThemeListener();
        });

        // Ecosystem Charts
        let ecosystemRadarChart = null;
        let ecosystemBarChart = null;

        function initializeEcosystemCharts() {
            // console.log('Initializing ecosystem charts...');

            // Destroy existing charts
            if (ecosystemRadarChart) {
                // console.log('Destroying existing radar chart...');
                ecosystemRadarChart.destroy();
                ecosystemRadarChart = null;
            }
            if (ecosystemBarChart) {
                // console.log('Destroying existing bar chart...');
                ecosystemBarChart.destroy();
                ecosystemBarChart = null;
            }

            // Get current theme
            const isDark = document.documentElement.classList.contains('dark') ||
                localStorage.getItem('theme') === 'dark' ||
                (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);

            // console.log('Current theme is dark:', isDark);

            const textColor = isDark ? '#e2e8f0' : '#374151';
            const gridColor = isDark ? '#475569' : '#e5e7eb';

            // Initialize Radar Chart
            const radarCtx = document.getElementById('ecosystemRadarChart');
            if (radarCtx) {
                // console.log('Creating radar chart...');

                ecosystemRadarChart = new Chart(radarCtx, {
                    type: 'radar',
                    data: {
                        labels: [
                            'Keragaman Peran (%)',
                            'Peran Tersedia',
                            'Total Peran Database'
                        ],
                        datasets: [{
                            label: 'Skor Ekosistem',
                            data: [
                                {{ $ecosystemQuality['role_diversity_score'] }},
                                {{ $ecosystemQuality['details']['existing_roles_count'] }},
                                {{ $ecosystemQuality['details']['total_roles_in_database'] }}
                            ],
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(59, 130, 246, 1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: textColor
                                }
                            }
                        },
                        scales: {
                            r: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    color: textColor,
                                    stepSize: 20
                                },
                                grid: {
                                    color: gridColor
                                },
                                pointLabels: {
                                    color: textColor,
                                    font: {
                                        size: 12
                                    },
                                }
                            }
                        }
                    }
                });
            }

            // Initialize Bar Chart
            const barCtx = document.getElementById('ecosystemBarChart');
            if (barCtx) {
                // console.log('Creating bar chart...');

                ecosystemBarChart = new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: [
                            'Keragaman Peran (%)',
                            'Peran Tersedia',
                            'Total Peran Database'
                        ],
                        datasets: [{
                            label: 'Skor (%)',
                            data: [
                                {{ $ecosystemQuality['role_diversity_score'] }},
                                {{ $ecosystemQuality['details']['existing_roles_count'] }},
                                {{ $ecosystemQuality['details']['total_roles_in_database'] }}
                            ],
                            backgroundColor: [
                                'rgba(6, 182, 212, 0.8)', // cyan
                                'rgba(59, 130, 246, 0.8)', // blue
                                'rgba(107, 114, 128, 0.8)' // gray
                            ],
                            borderColor: [
                                'rgba(6, 182, 212, 1)',
                                'rgba(59, 130, 246, 1)',
                                'rgba(107, 114, 128, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    color: textColor,
                                    stepSize: 20
                                },
                                grid: {
                                    color: gridColor
                                }
                            },
                            x: {
                                ticks: {
                                    color: textColor
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        }

        // Initialize ecosystem charts when quality tab is active
        function checkEcosystemCharts() {
            const qualityTab = document.querySelector('button[wire\\:click="setActiveTab(\'quality\')"]');
            if (qualityTab && qualityTab.classList.contains('border-primary-blue')) {
                // console.log('Quality tab is active, initializing ecosystem charts...');
                setTimeout(initializeEcosystemCharts, 200);
            }
        }

        // Listen for tab changes
        document.addEventListener('livewire:navigated', function() {
            checkEcosystemCharts();
        });

        // Listen for Livewire updates
        document.addEventListener('livewire:updated', function() {
            // console.log('Livewire updated, checking for ecosystem charts...');
            setTimeout(checkEcosystemCharts, 200);
        });

        // Listen for tab clicks
        document.addEventListener('click', function(e) {
            if (e.target && e.target.getAttribute('wire:click') === "setActiveTab('quality')") {
                // console.log('Quality tab clicked, initializing charts...');
                setTimeout(initializeEcosystemCharts, 300);
            }
        });

        // Listen for Livewire tab changes
        document.addEventListener('livewire:updated', function() {
            // console.log('Livewire updated, checking for quality tab...');
            setTimeout(function() {
                const qualityTab = document.querySelector(
                    'button[wire\\:click="setActiveTab(\'quality\')"]');
                if (qualityTab && qualityTab.classList.contains('border-primary-blue')) {
                    // console.log('Quality tab is active after update, initializing charts...');
                    initializeEcosystemCharts();
                }
            }, 200);
        });

        // Check on page load
        document.addEventListener('DOMContentLoaded', function() {
            checkEcosystemCharts();
        });

        // Also try to initialize when the page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(checkEcosystemCharts, 200);
        });

        // Function to update existing charts with new theme
        function updateChartsTheme() {
            // console.log('Updating charts theme...');

            // Get current theme
            const isDark = document.documentElement.classList.contains('dark') ||
                localStorage.getItem('theme') === 'dark' ||
                (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);

            const textColor = isDark ? '#e2e8f0' : '#374151';
            const gridColor = isDark ? '#475569' : '#e5e7eb';

            // Update connection quality radar chart if it exists
            if (connectionQualityRadarChart) {
                // console.log('Updating connection quality chart theme...');
                connectionQualityRadarChart.options.plugins.legend.labels.color = textColor;
                connectionQualityRadarChart.options.scales.r.ticks.color = textColor;
                connectionQualityRadarChart.options.scales.r.grid.color = gridColor;
                connectionQualityRadarChart.options.scales.r.pointLabels.color = textColor;
                connectionQualityRadarChart.update();
            }

            // Update radar chart if it exists
            if (ecosystemRadarChart) {
                // console.log('Updating radar chart theme...');
                ecosystemRadarChart.options.plugins.legend.labels.color = textColor;
                ecosystemRadarChart.options.scales.r.ticks.color = textColor;
                ecosystemRadarChart.options.scales.r.grid.color = gridColor;
                ecosystemRadarChart.options.scales.r.pointLabels.color = textColor;
                ecosystemRadarChart.update();
            }

            // Update bar chart if it exists
            if (ecosystemBarChart) {
                // console.log('Updating bar chart theme...');
                ecosystemBarChart.options.scales.y.ticks.color = textColor;
                ecosystemBarChart.options.scales.y.grid.color = gridColor;
                ecosystemBarChart.options.scales.x.ticks.color = textColor;
                ecosystemBarChart.update();
            }

            // Update contribution types chart
            if (ecosystemContributionTypesChart) {
                // console.log('Updating contribution types chart theme...');
                ecosystemContributionTypesChart.options.plugins.legend.labels.color = textColor;
                ecosystemContributionTypesChart.update();
            }

            // Update contribution status chart
            if (ecosystemContributionStatusChart) {
                // console.log('Updating contribution status chart theme...');
                ecosystemContributionStatusChart.options.plugins.legend.labels.color = textColor;
                ecosystemContributionStatusChart.options.scales.x.ticks.color = textColor;
                ecosystemContributionStatusChart.options.scales.y.ticks.color = textColor;
                ecosystemContributionStatusChart.options.scales.x.grid.color = gridColor;
                ecosystemContributionStatusChart.options.scales.y.grid.color = gridColor;
                ecosystemContributionStatusChart.update();
            }

            // Update member status chart
            if (ecosystemMemberStatusChart) {
                // console.log('Updating member status chart theme...');
                ecosystemMemberStatusChart.options.plugins.legend.labels.color = textColor;
                ecosystemMemberStatusChart.update();
            }

            // Update role diversity chart
            if (ecosystemRoleDiversityChart) {
                // console.log('Updating role diversity chart theme...');
                ecosystemRoleDiversityChart.options.plugins.legend.labels.color = textColor;
                ecosystemRoleDiversityChart.options.scales.x.ticks.color = textColor;
                ecosystemRoleDiversityChart.options.scales.y.ticks.color = textColor;
                ecosystemRoleDiversityChart.options.scales.x.grid.color = gridColor;
                ecosystemRoleDiversityChart.options.scales.y.grid.color = gridColor;
                ecosystemRoleDiversityChart.update();
            }
        }

        // Theme change listener
        function setupThemeListener() {
            // Listen for theme changes via localStorage
            window.addEventListener('storage', function(e) {
                if (e.key === 'theme') {
                    // console.log('Theme changed to:', e.newValue);
                    // Update charts when theme changes
                    setTimeout(updateChartsTheme, 100);
                }
            });

            // Listen for theme changes via class changes on document element
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        // console.log('Document class changed, updating charts...');
                        setTimeout(updateChartsTheme, 100);
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });

            // Also listen for clicks on theme toggle buttons
            document.addEventListener('click', function(e) {
                if (e.target && (
                        e.target.closest('[data-theme-toggle]') ||
                        e.target.closest('button[wire\\:click*="toggleTheme"]') ||
                        e.target.closest('.theme-toggle') ||
                        e.target.closest('button[wire\\:click*="setTheme"]')
                    )) {
                    // console.log('Theme toggle clicked, updating charts...');
                    setTimeout(updateChartsTheme, 200);
                }
            });

            // Listen for custom theme change events
            document.addEventListener('themeChanged', function() {
                // console.log('Custom theme change event detected');
                setTimeout(updateChartsTheme, 100);
            });
        }

        // Ecosystem Contribution Charts
        let ecosystemContributionTypesChart = null;
        let ecosystemContributionStatusChart = null;
        let ecosystemMemberStatusChart = null;
        let ecosystemRoleDiversityChart = null;

        function initializeEcosystemContributionCharts() {
            console.log('Initializing ecosystem contribution charts...');

            // Destroy existing charts
            if (ecosystemContributionTypesChart) {
                ecosystemContributionTypesChart.destroy();
                ecosystemContributionTypesChart = null;
            }
            if (ecosystemContributionStatusChart) {
                ecosystemContributionStatusChart.destroy();
                ecosystemContributionStatusChart = null;
            }
            if (ecosystemMemberStatusChart) {
                ecosystemMemberStatusChart.destroy();
                ecosystemMemberStatusChart = null;
            }
            if (ecosystemRoleDiversityChart) {
                ecosystemRoleDiversityChart.destroy();
                ecosystemRoleDiversityChart = null;
            }

            // Get current theme
            const isDark = document.documentElement.classList.contains('dark') ||
                (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
            const textColor = isDark ? '#e2e8f0' : '#374151';
            const gridColor = isDark ? '#475569' : '#e5e7eb';

            // === Ambil data dari backend ===
            const rawData = @json($acceptedContributions);

            // --- 1. Hitung kontribusi berdasarkan kategori ---
            const contributionTypes = {
                volunteer: 0,
                funding: 0,
                expertise: 0,
                resources: 0,
                promotion: 0,
                other: 0
            };

            rawData.forEach(item => {
                const name = item.contribution?.name?.toLowerCase() || '';
                if (name.includes('relawan')) contributionTypes.volunteer++;
                else if (name.includes('dana')) contributionTypes.funding++;
                else if (name.includes('keahlian')) contributionTypes.expertise++;
                else if (name.includes('sumber')) contributionTypes.resources++;
                else if (name.includes('promosi')) contributionTypes.promotion++;
                else contributionTypes.other++;
            });

            // --- 2. Hitung status kontribusi ---
            const contributionStatus = {
                offered: 0,
                accepted: 0,
                completed: 0,
                declined: 0
            };

            rawData.forEach(item => {
                if (item.status === 'offered') contributionStatus.offered++;
                else if (item.status === 'accepted') contributionStatus.accepted++;
                else if (item.status === 'completed') contributionStatus.completed++;
                else if (item.status === 'declined') contributionStatus.declined++;
            });

            // --- 3. (Opsional) Hitung status anggota ---
            // Kalau mau: bisa hitung dari item.user.status (jika ada)
            const memberStatus = {
                accepted: 0,
                pending: 0,
                rejected: 0
            };
            rawData.forEach(item => {
                if (item.user?.status === 'accepted') memberStatus.accepted++;
                else if (item.user?.status === 'pending') memberStatus.pending++;
                else if (item.user?.status === 'rejected') memberStatus.rejected++;
            });

            // --- 4. (Opsional) Role diversity ---
            const roleDiversity = {};
            rawData.forEach(item => {
                const role = item.user?.role || 'Lainnya';
                roleDiversity[role] = (roleDiversity[role] || 0) + 1;
            });

            // === Buat chart ===

            // Contribution Types Chart
            const contributionTypesCtx = document.getElementById('ecosystemContributionTypesChart');
            if (contributionTypesCtx) {
                const labels = ['Relawan', 'Dana', 'Keahlian', 'Sumber Daya', 'Promosi', 'Lainnya'];
                const data = [
                    contributionTypes.volunteer,
                    contributionTypes.funding,
                    contributionTypes.expertise,
                    contributionTypes.resources,
                    contributionTypes.promotion,
                    contributionTypes.other
                ];

                const colors = [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(156, 163, 175, 0.8)'
                ];

                ecosystemContributionTypesChart = new Chart(contributionTypesCtx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: colors,
                            borderColor: colors.map(c => c.replace('0.8', '1')),
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: textColor,
                                    padding: 20
                                }
                            }
                        }
                    }
                });
            }

            // Contribution Status Chart
            const contributionStatusCtx = document.getElementById('ecosystemContributionStatusChart');
            if (contributionStatusCtx) {
                const labels = ['Ditawarkan', 'Diterima', 'Selesai', 'Ditolak'];
                const data = [
                    contributionStatus.offered,
                    contributionStatus.accepted,
                    contributionStatus.completed,
                    contributionStatus.declined
                ];

                const colors = [
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ];

                ecosystemContributionStatusChart = new Chart(contributionStatusCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Kontribusi',
                            data: data,
                            backgroundColor: colors,
                            borderColor: colors.map(c => c.replace('0.8', '1')),
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: textColor
                                },
                                grid: {
                                    color: gridColor
                                }
                            },
                            x: {
                                ticks: {
                                    color: textColor
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Member Status Chart
            // const memberStatusCtx = document.getElementById('ecosystemMemberStatusChart');
            // if (memberStatusCtx) {
            //     const labels = ['Diterima', 'Menunggu', 'Ditolak'];
            //     const data = [
            //         memberStatus.accepted,
            //         memberStatus.pending,
            //         memberStatus.rejected
            //     ];

            //     const colors = [
            //         'rgba(34, 197, 94, 0.8)',
            //         'rgba(245, 158, 11, 0.8)',
            //         'rgba(239, 68, 68, 0.8)'
            //     ];

            //     ecosystemMemberStatusChart = new Chart(memberStatusCtx, {
            //         type: 'doughnut',
            //         data: {
            //             labels: labels,
            //             datasets: [{
            //                 data: data,
            //                 backgroundColor: colors,
            //                 borderColor: colors.map(c => c.replace('0.8', '1')),
            //                 borderWidth: 2
            //             }]
            //         },
            //         options: {
            //             responsive: true,
            //             maintainAspectRatio: false,
            //             plugins: {
            //                 legend: {
            //                     position: 'bottom',
            //                     labels: {
            //                         color: textColor,
            //                         padding: 20
            //                     }
            //                 }
            //             }
            //         }
            //     });
            // }

            // Role Diversity Chart
            // const roleDiversityCtx = document.getElementById('ecosystemRoleDiversityChart');
            // if (roleDiversityCtx) {
            //     const labels = Object.keys(roleDiversity);
            //     const data = Object.values(roleDiversity);

            //     const colors = [
            //         'rgba(59, 130, 246, 0.8)',
            //         'rgba(34, 197, 94, 0.8)',
            //         'rgba(168, 85, 247, 0.8)',
            //         'rgba(245, 158, 11, 0.8)',
            //         'rgba(239, 68, 68, 0.8)',
            //         'rgba(156, 163, 175, 0.8)'
            //     ];

            //     ecosystemRoleDiversityChart = new Chart(roleDiversityCtx, {
            //         type: 'bar',
            //         data: {
            //             labels: labels,
            //             datasets: [{
            //                 label: 'Jumlah Anggota',
            //                 data: data,
            //                 backgroundColor: colors.slice(0, labels.length),
            //                 borderColor: colors.slice(0, labels.length).map(c => c.replace('0.8', '1')),
            //                 borderWidth: 2
            //             }]
            //         },
            //         options: {
            //             responsive: true,
            //             maintainAspectRatio: false,
            //             plugins: {
            //                 legend: {
            //                     display: false
            //                 }
            //             },
            //             scales: {
            //                 y: {
            //                     beginAtZero: true,
            //                     ticks: {
            //                         color: textColor
            //                     },
            //                     grid: {
            //                         color: gridColor
            //                     }
            //                 },
            //                 x: {
            //                     ticks: {
            //                         color: textColor
            //                     },
            //                     grid: {
            //                         display: false
            //                     }
            //                 }
            //             }
            //         }
            //     });
            // }
        }

        // Initialize contribution charts when overview tab is active
        function checkEcosystemContributionCharts() {
            const overviewTab = document.querySelector('button[wire\\:click="setActiveTab(\'overview\')"]');
            if (overviewTab && overviewTab.classList.contains('border-primary-blue')) {
                // console.log('Overview tab is active, initializing contribution charts...');
                setTimeout(initializeEcosystemContributionCharts, 200);
            }
        }

        // Listen for tab changes
        document.addEventListener('livewire:navigated', function() {
            checkEcosystemContributionCharts();
        });

        // Listen for Livewire updates
        document.addEventListener('livewire:updated', function() {
            // console.log('Livewire updated, checking for contribution charts...');
            setTimeout(checkEcosystemContributionCharts, 200);
        });

        // Listen for tab clicks
        document.addEventListener('click', function(e) {
            if (e.target && e.target.getAttribute('wire:click') === "setActiveTab('overview')") {
                // console.log('Overview tab clicked, initializing contribution charts...');
                setTimeout(initializeEcosystemContributionCharts, 300);
            }
        });

        // Check on page load
        document.addEventListener('DOMContentLoaded', function() {
            checkEcosystemContributionCharts();
            
            // Load initial like status
            loadLikeStatus('ecosystem', {{ $ecosystem->id }});
        });

        // Initialize theme listener
        setupThemeListener();
        const test = @json($acceptedContributions);
        console.log(test)

        // Like functionality
        function toggleLike(type, id) {
            // Find the like button (there might be multiple)
            const buttons = document.querySelectorAll('#like-button');
            if (buttons.length === 0) return;
            
            const button = buttons[0]; // Use the first one
            const icon = button.querySelector('#like-icon');
            const text = button.querySelector('#like-text');
            const count = button.querySelector('#like-count');
            
            // Disable button during request
            button.disabled = true;
            
            fetch(`/${type}/${id}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update all like buttons
                    const allButtons = document.querySelectorAll('#like-button');
                    allButtons.forEach(btn => {
                        const btnIcon = btn.querySelector('#like-icon');
                        const btnText = btn.querySelector('#like-text');
                        const btnCount = btn.querySelector('#like-count');
                        
                        if (data.isLiked) {
                            btn.classList.remove('bg-red-500', 'hover:bg-red-600');
                            btn.classList.add('bg-red-600', 'hover:bg-red-700');
                            btnText.textContent = 'Disukai';
                        } else {
                            btn.classList.remove('bg-red-600', 'hover:bg-red-700');
                            btn.classList.add('bg-red-500', 'hover:bg-red-600');
                            btnText.textContent = 'Suka';
                        }
                        
                        // Update count
                        btnCount.textContent = data.likeCount;
                    });
                    
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

        function loadLikeStatus(type, id) {
            const url = `/${type}/${id}/like-status`;
            
            fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Find the like button (there might be multiple)
                    const buttons = document.querySelectorAll('#like-button');
                    buttons.forEach(button => {
                        const icon = button.querySelector('#like-icon');
                        const text = button.querySelector('#like-text');
                        const count = button.querySelector('#like-count');
                        
                        if (data.isLiked) {
                            button.classList.remove('bg-red-500', 'hover:bg-red-600');
                            button.classList.add('bg-red-600', 'hover:bg-red-700');
                            text.textContent = 'Disukai';
                        } else {
                            button.classList.remove('bg-red-600', 'hover:bg-red-700');
                            button.classList.add('bg-red-500', 'hover:bg-red-600');
                            text.textContent = 'Suka';
                        }
                        
                        count.textContent = data.likeCount;
                    });
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

        // Initialize Pusher for real-time ecosystem dashboard updates
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

                    // Listen for ecosystem user status updated events
                    channel.bind('ecosystem.user.status.updated', function(data) {
                        console.log('Ecosystem user status updated:', data);
                        
                        // Show notification
                        showEcosystemStatusNotification(data);
                        
                        // Refresh Livewire component data
                        @this.call('refreshData');
                    });

                    console.log('Pusher initialized for ecosystem dashboard updates');
                } else {
                    console.log('Pusher not configured, using polling fallback');
                }
            } catch (error) {
                console.error('Pusher initialization failed:', error);
            }
        });

        // Show ecosystem status notification
        function showEcosystemStatusNotification(data) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-blue-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-md transform transition-all duration-300 translate-x-full';
            
            let message = '';
            let icon = '';
            
            if (data.action === 'accepted') {
                message = `Anda telah diterima di ekosistem "${data.ecosystem.title}"`;
                icon = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />`;
            } else if (data.action === 'rejected') {
                message = `Permintaan bergabung ke ekosistem "${data.ecosystem.title}" ditolak`;
                icon = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />`;
            }
            
            notification.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${icon}
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold">Update Status Ekosistem</h4>
                        <p class="text-sm mt-1">${message}</p>
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
