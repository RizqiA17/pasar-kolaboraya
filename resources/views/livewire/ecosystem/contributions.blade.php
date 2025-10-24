<div
    class="bg-gradient-to-br from-green-50/20 via-blue-50/20 to-purple-50/20 dark:from-slate-900/20 dark:via-slate-800/20 dark:to-slate-900/20 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('ecosystem.dashboard', $ecosystem) }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    Manajemen Kontribusi
                </h1>
            </div>
            <p class="text-gray-600 dark:text-gray-400">
                {{ $ecosystem->nama }}
            </p>
        </div>

        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <div
                class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Kontribusi</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['total'] }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Ditawarkan</p>
                        <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">
                            {{ $stats['offered'] }}
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Diterima</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $stats['accepted'] }}
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Selesai</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $stats['completed'] }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Ditolak</p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">
                            {{ $stats['declined'] }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search and Filter Section --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-4 sm:p-6 mb-6 border border-gray-200 dark:border-slate-700">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Search --}}
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cari Kontribusi
                    </label>
                    <div class="relative">
                        <input type="text" id="search" wire:model.live.debounce.300ms="search"
                            placeholder="Cari nama atau email..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Filter by Status --}}
                <div>
                    <label for="statusFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Filter Status
                    </label>
                    <select id="statusFilter" wire:model.live="statusFilter"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                        <option value="all">Semua Status</option>
                        <option value="offered">Ditawarkan</option>
                        <option value="accepted">Diterima</option>
                        <option value="completed">Selesai</option>
                        <option value="declined">Ditolak</option>
                    </select>
                </div>

                {{-- Filter by Contribution Type --}}
                <div>
                    <label for="contributionTypeFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Filter Jenis Kontribusi
                    </label>
                    <select id="contributionTypeFilter" wire:model.live="contributionTypeFilter"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                        <option value="all">Semua Jenis</option>
                        @foreach ($contributionTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Contributions List --}}
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="p-4 sm:p-6">
                @if ($contributions->count() > 0)
                    <div class="space-y-3">
                        @foreach ($contributions as $contribution)
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 border border-gray-200 dark:border-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                <div class="flex items-center space-x-4 mb-3 sm:mb-0">
                                    {{-- Avatar --}}
                                    <div
                                        class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0 
                                        @if ($contribution->status === 'offered') bg-amber-100 dark:bg-amber-900/30
                                        @elseif($contribution->status === 'accepted') bg-green-100 dark:bg-green-900/30
                                        @elseif($contribution->status === 'completed') bg-blue-100 dark:bg-blue-900/30
                                        @else bg-red-100 dark:bg-red-900/30 @endif">
                                        <span
                                            class="text-lg font-semibold
                                            @if ($contribution->status === 'offered') text-amber-600 dark:text-amber-400
                                            @elseif($contribution->status === 'accepted') text-green-600 dark:text-green-400
                                            @elseif($contribution->status === 'completed') text-blue-600 dark:text-blue-400
                                            @else text-red-600 dark:text-red-400 @endif">
                                            {{ substr($contribution->user->name, 0, 1) }}
                                        </span>
                                    </div>

                                    {{-- Contribution Info --}}
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $contribution->user->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                            {{ $contribution->user->email }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                            {{ $contribution->contribution_type_label }}
                                        </p>
                                        @if ($contribution->contribution_amount)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Rp {{ number_format($contribution->contribution_amount, 0, ',', '.') }}
                                            </p>
                                        @endif
                                        @if ($contribution->offered_at)
                                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                                Ditawarkan:
                                                {{ \Carbon\Carbon::parse($contribution->offered_at)->format('d M Y') }}
                                            </p>
                                        @endif
                                        {{-- Status Badge --}}
                                        <span
                                            class="px-3 -ml-2 py-1 rounded-full text-xs font-medium {{ $contribution->status_color_class }}">
                                            {{ $contribution->status_label }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center justify-between sm:justify-end gap-2 sm:gap-3">
                                    {{-- Action Buttons --}}
                                    <div class="flex gap-2">
                                        {{-- Detail Button --}}
                                        <button wire:click="openContributionDetailModal({{ $contribution->id }})"
                                            class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-medium transition-colors">
                                            Detail
                                        </button>

                                        @if ($isOwner && $contribution->status === 'offered')
                                            {{-- Accept Button --}}
                                            <button wire:click="acceptContribution({{ $contribution->id }})"
                                                class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-medium transition-colors">
                                                Terima
                                            </button>

                                            {{-- Decline Button --}}
                                            <button wire:click="declineContribution({{ $contribution->id }})"
                                                class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-medium transition-colors">
                                                Tolak
                                            </button>
                                        @endif

                                        @if ($isOwner && $contribution->status === 'accepted')
                                            {{-- Complete Button --}}
                                            <button wire:click="completeContribution({{ $contribution->id }})"
                                                class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-medium transition-colors">
                                                Selesaikan
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $contributions->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            Tidak ada kontribusi
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            @if ($search || $statusFilter !== 'all' || $contributionTypeFilter !== 'all')
                                Tidak ada kontribusi yang sesuai dengan filter yang dipilih.
                            @else
                                Belum ada kontribusi di ekosistem ini.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Contribution Detail Modal --}}
    @if ($showContributionDetailModal && $selectedContribution)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-32 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500/75 -z-[1] dark:bg-gray-900/75 transition-opacity"
                    wire:click="closeContributionDetailModal"></div>

                <!-- Center modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100">
                                Detail Kontribusi
                            </h3>
                            <button wire:click="closeContributionDetailModal"
                                class="text-gray-400 hover:text-gray-500 dark:text-slate-400 dark:hover:text-slate-300">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- User Info -->
                            <div class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        @if ($selectedContribution->user->profile && $selectedContribution->user->profile->profile_photo)
                                            <img class="h-16 w-16 rounded-full object-cover"
                                                src="{{ asset('storage/' . $selectedContribution->user->profile->profile_photo) }}"
                                                alt="{{ $selectedContribution->user->name }}">
                                        @else
                                            <div
                                                class="h-16 w-16 rounded-full bg-gray-300 dark:bg-slate-600 flex items-center justify-center">
                                                <svg class="h-10 w-10 text-gray-500 dark:text-slate-400"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-slate-100">
                                            {{ $selectedContribution->user->name }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-slate-400">
                                            {{ $selectedContribution->user->email }}</p>
                                        @if ($selectedContribution->user->profile && $selectedContribution->user->profile->peran)
                                            <p class="text-sm text-gray-600 dark:text-slate-400">
                                                <span class="font-medium">Peran:</span>
                                                {{ $selectedContribution->user->profile->peran->nama_peran }}
                                            </p>
                                        @endif
                                        {{-- Status Badge --}}
                                        <div class="mt-2 -ml-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $selectedContribution->status_color_class }}">
                                                {{ $selectedContribution->status_label }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contribution Information -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-slate-100 mb-3">Informasi
                                    Kontribusi</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div
                                        class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                        <span class="text-xs text-gray-500 dark:text-slate-400">Jenis Kontribusi</span>
                                        <p class="text-sm font-medium text-gray-900 dark:text-slate-100 mt-1">
                                            {{ $selectedContribution->contribution_type_label }}
                                        </p>
                                    </div>
                                    @if ($selectedContribution->contribution_amount)
                                        <div
                                            class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                            <span class="text-xs text-gray-500 dark:text-slate-400">Jumlah</span>
                                            <p class="text-sm font-medium text-gray-900 dark:text-slate-100 mt-1">
                                                Rp {{ number_format($selectedContribution->contribution_amount, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    @endif
                                    <div
                                        class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600 md:col-span-2">
                                        <span class="text-xs text-gray-500 dark:text-slate-400">Deskripsi</span>
                                        <p class="text-sm text-gray-900 dark:text-slate-100 mt-1">
                                            {{ $selectedContribution->contribution_description }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Time Information -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-slate-100 mb-3">Informasi Waktu
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @if ($selectedContribution->offered_at)
                                        <div
                                            class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                            <span class="text-xs text-gray-500 dark:text-slate-400">Ditawarkan</span>
                                            <p class="text-sm font-medium text-gray-900 dark:text-slate-100 mt-1">
                                                {{ \Carbon\Carbon::parse($selectedContribution->offered_at)->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                    @endif
                                    @if ($selectedContribution->accepted_at)
                                        <div
                                            class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                            <span class="text-xs text-gray-500 dark:text-slate-400">Diterima</span>
                                            <p class="text-sm font-medium text-gray-900 dark:text-slate-100 mt-1">
                                                {{ \Carbon\Carbon::parse($selectedContribution->accepted_at)->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                    @endif
                                    @if ($selectedContribution->completed_at)
                                        <div
                                            class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                            <span class="text-xs text-gray-500 dark:text-slate-400">Selesai</span>
                                            <p class="text-sm font-medium text-gray-900 dark:text-slate-100 mt-1">
                                                {{ \Carbon\Carbon::parse($selectedContribution->completed_at)->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        @if ($isOwner && $selectedContribution->status === 'offered')
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                                <div class="flex gap-3">
                                    <button wire:click="acceptContribution({{ $selectedContribution->id }})"
                                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                                        Terima
                                    </button>
                                    <button wire:click="declineContribution({{ $selectedContribution->id }})"
                                        class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                                        Tolak
                                    </button>
                                </div>
                            </div>
                        @elseif ($isOwner && $selectedContribution->status === 'accepted')
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                                <div class="flex gap-3">
                                    <button wire:click="completeContribution({{ $selectedContribution->id }})"
                                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                                        Selesaikan
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
