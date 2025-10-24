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
                    Manajemen Anggota
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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Anggota</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $pendingCount + $acceptedCount }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Menunggu</p>
                        <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">
                            {{ $pendingCount }}
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
                            {{ $acceptedCount }}
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
                        <p class="text-sm text-gray-600 dark:text-gray-400">Ditolak</p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">
                            {{ $rejectedCount }}
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Search --}}
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cari Anggota
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
                        <option value="pending">Menunggu Persetujuan</option>
                        <option value="accepted">Diterima</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
            </div>

            {{-- Clear Filters --}}
            {{-- @if ($search || $statusFilter !== 'all')
                <div class="mt-4">
                    <button wire:click="$set('search', ''); $set('statusFilter', 'all')"
                        class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                        Hapus Filter
                    </button>
                </div>
            @endif --}}
        </div>

        {{-- Members List --}}
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="p-4 sm:p-6">
                @if ($members->count() > 0)
                    <div class="space-y-3">
                        @foreach ($members as $member)
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 border border-gray-200 dark:border-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                <div class="flex items-center space-x-4 mb-3 sm:mb-0">
                                    {{-- Avatar --}}
                                    <div
                                        class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0 
                                        @if ($member->pivot->status === 'pending') bg-amber-100 dark:bg-amber-900/30
                                        @elseif($member->pivot->status === 'accepted') bg-green-100 dark:bg-green-900/30
                                        @else bg-red-100 dark:bg-red-900/30 @endif">
                                        <span
                                            class="text-lg font-semibold
                                            @if ($member->pivot->status === 'pending') text-amber-600 dark:text-amber-400
                                            @elseif($member->pivot->status === 'accepted') text-green-600 dark:text-green-400
                                            @else text-red-600 dark:text-red-400 @endif">
                                            {{ substr($member->name, 0, 1) }}
                                        </span>
                                    </div>

                                    {{-- Member Info --}}
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $member->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                            {{ $member->email }}
                                        </p>
                                        @if ($member->profile && $member->profile->peran)
                                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                                {{ $member->profile->peran->nama_peran }}
                                            </p>
                                        @endif
                                        @if ($member->pivot->joined_at)
                                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                                Bergabung:
                                                {{ \Carbon\Carbon::parse($member->pivot->joined_at)->format('d M Y') }}
                                            </p>
                                        @endif
                                        {{-- Status Badge --}}
                                        <span
                                            class="px-3 -ml-2 py-1 rounded-full text-xs font-medium
                                         @if ($member->pivot->status === 'pending') bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-200
                                         @elseif($member->pivot->status === 'accepted') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200
                                         @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 @endif">
                                            @if ($member->pivot->status === 'pending')
                                                Menunggu
                                            @elseif($member->pivot->status === 'accepted')
                                                Aktif
                                            @else
                                                Ditolak
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                {{-- Status and Actions --}}
                                <div class="flex items-center justify-between sm:justify-end gap-2 sm:gap-3">

                                    {{-- Action Buttons --}}
                                    <div class="flex gap-2">
                                        {{-- Detail Button --}}
                                        <button wire:click="openMemberDetailModal({{ $member->id }})"
                                            class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-medium transition-colors">
                                            Detail
                                        </button>

                                        @if ($isOwner && $member->pivot->status === 'pending')
                                            {{-- Accept Button --}}
                                            <button wire:click="acceptMember({{ $member->id }})"
                                                class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-medium transition-colors">
                                                Terima
                                            </button>

                                            {{-- Reject Button --}}
                                            <button wire:click="rejectMember({{ $member->id }})"
                                                class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-medium transition-colors">
                                                Tolak
                                            </button>
                                        @endif

                                        {{-- @if ($isOwner && $member->pivot->status === 'accepted')
                                            <!-- Remove Button -->
                                            <button wire:click="removeMember({{ $member->id }})"
                                                onclick="return confirm('Apakah Anda yakin ingin mengeluarkan {{ $member->name }} dari ekosistem ini?')"
                                                class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-medium transition-colors">
                                                Keluarkan
                                            </button>
                                        @endif --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $members->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            Tidak ada anggota
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            @if ($search || $statusFilter !== 'all')
                                Tidak ada anggota yang sesuai dengan filter yang dipilih.
                            @else
                                Belum ada anggota di ekosistem ini.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Member Detail Modal --}}
    @if ($showMemberDetailModal && $selectedMember)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-32 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500/75 -z-[1] dark:bg-gray-900/75 transition-opacity"
                    wire:click="closeMemberDetailModal"></div>

                <!-- Center modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100">
                                Detail Anggota
                            </h3>
                            <button wire:click="closeMemberDetailModal"
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
                                        @if ($selectedMember->profile && $selectedMember->profile->profile_photo)
                                            <img class="h-16 w-16 rounded-full object-cover"
                                                src="{{ asset('storage/' . $selectedMember->profile->profile_photo) }}"
                                                alt="{{ $selectedMember->name }}">
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
                                            {{ $selectedMember->name }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-slate-400">
                                            {{ $selectedMember->email }}</p>
                                        @if ($selectedMember->assigned_role)
                                            <p class="text-sm text-gray-600 dark:text-slate-400">
                                                <span class="font-medium"></span> {{ $selectedMember->assigned_role }}
                                            </p>
                                        @elseif ($selectedMember->profile && $selectedMember->profile->peran)
                                            <p class="text-sm text-gray-600 dark:text-slate-400">
                                                <span class="font-medium"></span>
                                                {{ $selectedMember->profile->peran->nama_peran }}
                                            </p>
                                        @endif
                                        {{-- Status Badge --}}
                                        <div class="mt-2 -ml-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if ($selectedMember->pivot && $selectedMember->pivot->status === 'pending') bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-200
                                                @elseif($selectedMember->pivot && $selectedMember->pivot->status === 'accepted') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200
                                                @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 @endif">
                                                @if ($selectedMember->pivot && $selectedMember->pivot->status === 'pending')
                                                    Menunggu Persetujuan
                                                @elseif($selectedMember->pivot && $selectedMember->pivot->status === 'accepted')
                                                    Diterima / Aktif
                                                @else
                                                    Ditolak
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Information -->
                            @if ($selectedMember->profile)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-slate-100 mb-3">Informasi
                                        Profil</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @if ($selectedMember->profile->organization)
                                            <div
                                                class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                                <span
                                                    class="text-xs text-gray-500 dark:text-slate-400">Organisasi</span>
                                                <p class="text-sm font-medium text-gray-900 dark:text-slate-100 mt-1">
                                                    {{ $selectedMember->profile->organization }}
                                                </p>
                                            </div>
                                        @endif
                                        @if ($selectedMember->profile->location)
                                            <div
                                                class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                                <span class="text-xs text-gray-500 dark:text-slate-400">Lokasi</span>
                                                <p class="text-sm font-medium text-gray-900 dark:text-slate-100 mt-1">
                                                    {{ $selectedMember->profile->location }}
                                                </p>
                                            </div>
                                        @endif
                                        @if ($selectedMember->profile->phone)
                                            <div
                                                class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                                <span class="text-xs text-gray-500 dark:text-slate-400">Telepon</span>
                                                <p class="text-sm font-medium text-gray-900 dark:text-slate-100 mt-1">
                                                    {{ $selectedMember->profile->phone }}
                                                </p>
                                            </div>
                                        @endif
                                        @if ($selectedMember->profile->vision)
                                            <div
                                                class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600 md:col-span-2">
                                                <span class="text-xs text-gray-500 dark:text-slate-400">Visi dan
                                                    Misi</span>
                                                <p class="text-sm text-gray-900 dark:text-slate-100 mt-1">
                                                    {{ $selectedMember->profile->vision }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Skills -->
                            @if ($selectedMember->profile && $selectedMember->profile->allSkills && count($selectedMember->profile->allSkills) > 0)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-slate-100 mb-3">Keahlian
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($selectedMember->profile->allSkills as $skill)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                                {{ $skill ?? 'Tidak ada keahlian' }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Bio -->
                            @if ($selectedMember->profile && $selectedMember->profile->bio)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-slate-100 mb-3">Bio</h4>
                                    <div
                                        class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                        <p class="text-sm text-gray-900 dark:text-slate-100">
                                            {{ $selectedMember->profile->bio }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Time Information -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-slate-100 mb-3">Informasi Waktu
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div
                                        class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                        <span class="text-xs text-gray-500 dark:text-slate-400">Mendaftar</span>
                                        <p class="text-sm font-medium text-gray-900 dark:text-slate-100 mt-1">
                                            {{ $selectedMember->pivot && $selectedMember->pivot->created_at ? \Carbon\Carbon::parse($selectedMember->pivot->created_at)->format('d M Y H:i') : 'Tidak diketahui' }}
                                        </p>
                                    </div>
                                    @if ($selectedMember->pivot && $selectedMember->pivot->joined_at)
                                        <div
                                            class="bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                            <span class="text-xs text-gray-500 dark:text-slate-400">Bergabung</span>
                                            <p class="text-sm font-medium text-gray-900 dark:text-slate-100 mt-1">
                                                {{ \Carbon\Carbon::parse($selectedMember->pivot->joined_at)->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        @if ($isOwner && $selectedMember->pivot && $selectedMember->pivot->status === 'pending')
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                                <div class="flex gap-3">
                                    <button wire:click="acceptMember({{ $selectedMember->id }})"
                                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                                        Terima
                                    </button>
                                    <button wire:click="rejectMember({{ $selectedMember->id }})"
                                        class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                                        Tolak
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
