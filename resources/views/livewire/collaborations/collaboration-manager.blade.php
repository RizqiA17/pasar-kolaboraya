@php
    $collaborationsEnabled = \App\Models\SystemSetting::isCollaborationsEnabled();
    $isSuperAdmin = auth()->user()->isSuperAdmin();
    $isFormDisabled = !$collaborationsEnabled && !$isSuperAdmin;
@endphp

<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
    <!-- Header -->
    <div class="grid xl:grid-cols-3 sm:grid-cols-2 grid-cols-1 items-center mb-8">
        <div class="col-span-1">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Manajemen Kolaborasi</h2>
            <p class="text-gray-600 dark:text-gray-400">Kelola semua kolaborasi Anda dalam satu tempat</p>
        </div>
        <!-- Search Bar for Collaborations -->
        <div class="col-span-1 max-xl:hidden">
            <div class="relative max-w-2xl mx-auto">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.live="collaborationSearchQuery"
                    class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-2xl leading-5 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-lg"
                    placeholder="Cari kolaborasi berdasarkan judul atau deskripsi...">
            </div>
        </div>
        <div class="col-span-1 max-sm:mt-4 flex justify-end">
            @if($isFormDisabled)
                <div class="group relative" x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                    <button disabled
                        class="max-sm:w-full px-6 py-3 bg-gray-400 text-gray-200 rounded-xl cursor-not-allowed opacity-60">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728">
                            </path>
                        </svg>
                        Fitur Dinonaktifkan
                    </button>
                    <!-- Tooltip -->
                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg shadow-lg whitespace-nowrap z-50">
                        Fitur kolaborasi sedang dinonaktifkan oleh administrator
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
                    </div>
                </div>
            @else
                <button wire:click="toggleCreateForm"
                    class="max-sm:w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                        </path>
                    </svg>
                    Buat Kolaborasi Baru
                </button>
            @endif
        </div>
    </div>

    <div class="xl:hidden w-full mb-8">
        <div class="relative max-w-2xl mx-auto">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" wire:model.live="collaborationSearchQuery"
                class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-2xl leading-5 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-lg"
                placeholder="Cari kolaborasi berdasarkan judul atau deskripsi...">
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div
            class="mb-6 p-4 bg-gradient-to-r from-green-100 to-green-50 border border-green-200 text-green-800 rounded-xl shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div
            class="mb-6 p-4 bg-gradient-to-r from-red-100 to-red-50 border border-red-200 text-red-800 rounded-xl shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                    </path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Feature Disabled Message -->
    @if($isFormDisabled)
        <div class="mb-8 p-6 bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-xl shadow-lg">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-red-800 mb-2">
                        Fitur Kolaborasi Dinonaktifkan
                    </h3>
                    <p class="text-red-700 mb-4">
                        Fitur kolaborasi sedang dinonaktifkan oleh administrator. Anda masih dapat melihat kolaborasi yang sudah ada, tetapi tidak dapat membuat yang baru.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Create Collaboration Form -->
    @if ($showCreateForm && !$isFormDisabled)
        <div
            class="mb-8 p-8 bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl border border-gray-200 dark:border-gray-600 shadow-lg">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Buat Kolaborasi Baru</h3>
                <p class="text-gray-600 dark:text-gray-400">Mulai perjalanan kolaborasi yang menginspirasi</p>
            </div>
            <form wire:submit.prevent="createCollaboration">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Judul Kolaborasi
                            </span>
                        </label>
                        <input type="text" wire:model="title"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="Masukkan judul kolaborasi yang menarik">
                        @error('title')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Deskripsi
                            </span>
                        </label>
                        <textarea wire:model="description" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                            placeholder="Jelaskan visi dan tujuan kolaborasi Anda"></textarea>
                        @error('description')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                            Undang Anggota Kolaborasi
                        </span>
                    </label>
                    <div class="flex gap-3 mb-3">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="searchQuery"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200"
                                placeholder="Cari teman yang terkoneksi untuk diundang...">
                        </div>
                    </div>

                    @if ($searchQuery && $availableUsers->isEmpty())
                        <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                            <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm">Tidak ada user yang ditemukan</p>
                        </div>
                    @else
                        <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-lg">
                            @foreach ($availableUsers as $user)
                                <label
                                    class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer">
                                    <input type="checkbox" wire:model="selectedUsers" value="{{ $user->id }}"
                                        class="mr-2 text-blue-600">
                                    <div class="flex items-center justify-between w-full">
                                        <div class="flex items-center">
                                            <div class="mr-3">
                                                <x-ui.avatar :user="$user" size="sm" />
                                            </div>
                                            <span
                                                class="text-sm text-gray-700 dark:text-gray-300">{{ $user->name }}</span>
                                        </div>
                                        <a href="{{ route('profile.view', $user->id) }}"
                                            class="text-xs text-blue-600 hover:text-blue-800 transition-colors ml-2">
                                            Lihat Profile
                                        </a>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    @if ($selectedUsers)
                        <div class="mt-2">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">User yang dipilih:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($selectedUsers as $selectedUserId)
                                    @php
                                        $selectedUser = $availableUsers->firstWhere('id', $selectedUserId);
                                    @endphp
                                    @if ($selectedUser)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $selectedUser->name }}
                                            <button type="button"
                                                wire:click="removeSelectedUser({{ $selectedUserId }})"
                                                class="ml-1 inline-flex items-center justify-center w-4 h-4 rounded-full text-blue-400 hover:bg-blue-200 hover:text-blue-500 dark:hover:bg-blue-800">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @error('selectedUsers')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-3 justify-center">
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Kolaborasi
                    </button>
                    <button type="button" wire:click="toggleCreateForm"
                        class="px-8 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600 transition-all duration-300 font-semibold">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Overview Tab -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
        <!-- Pending Invitations Card -->
        <div
            class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 border border-yellow-200 dark:border-yellow-600 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 bg-yellow-100 dark:bg-yellow-800 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-yellow-600 dark:text-yellow-400 uppercase tracking-wide">
                        Undangan Masuk</h3>
                    <p class="text-3xl font-bold text-yellow-900 dark:text-yellow-100">
                        {{ $this->pendingInvitations->count() }}</p>
                </div>
            </div>
        </div>

        <!-- My Collaborations Card -->
        <div
            class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-600 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wide">Kolaborasi
                        Saya</h3>
                    <p class="text-3xl font-bold text-blue-900 dark:text-blue-100">
                        {{ $this->myCollaborations->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Created Collaborations Card -->
        <div
            class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border border-green-200 dark:border-green-600 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-green-600 dark:text-green-400 uppercase tracking-wide">Yang
                        Saya Buat</h3>
                    <p class="text-3xl font-bold text-green-900 dark:text-green-100">
                        {{ $this->createdCollaborations->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Completed Collaborations Card -->
        <div
            class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 border border-purple-200 dark:border-purple-600 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 bg-purple-100 dark:bg-purple-800 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-purple-600 dark:text-purple-400 uppercase tracking-wide">
                        Selesai</h3>
                    <p class="text-3xl font-bold text-purple-900 dark:text-purple-100">
                        {{ $this->completedCollaborations->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700 mb-8">
        <div class="flex space-x-8">
            <button wire:click="setTab('my-collaborations')"
                class="py-3 px-1 border-b-2 font-medium text-sm transition-all duration-200 {{ $activeTab === 'my-collaborations' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Kolaborasi Saya
                </span>
            </button>
            <button wire:click="setTab('created')"
                class="py-3 px-1 border-b-2 font-medium text-sm transition-all duration-200 {{ $activeTab === 'created' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Yang Saya Buat
                </span>
            </button>
            <button wire:click="setTab('pending')"
                class="py-3 px-1 border-b-2 font-medium text-sm transition-all duration-200 {{ $activeTab === 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-5 5v-5zM4 19h6a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    Undangan Masuk
                    @if ($this->pendingInvitations->count() > 0)
                        <span
                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            {{ $this->pendingInvitations->count() }}
                        </span>
                    @endif
                </span>
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">

        <!-- Pending Invitations Tab -->
        @if ($activeTab === 'pending')
            <div class="mb-8">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Undangan Kolaborasi</h3>
                    <p class="text-gray-600 dark:text-gray-400">Terima atau tolak undangan untuk bergabung dalam
                        kolaborasi</p>
                </div>
                @if ($this->pendingInvitations->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($this->pendingInvitations as $invitation)
                            <div
                                class="p-6 bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border border-yellow-200 dark:border-yellow-700 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">
                                            {{ $invitation->collaboration->title }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                                            {{ $invitation->collaboration->description ?? 'Tidak ada deskripsi' }}
                                        </p>
                                    </div>
                                    <div class="ml-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Undangan Baru
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center mb-4 p-3 bg-white dark:bg-gray-800 rounded-lg">
                                    <div
                                        class="w-8 h-8 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Dibuat oleh</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $invitation->collaboration->creator->name }}</p>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <button wire:click="acceptInvitation({{ $invitation->collaboration->id }})"
                                        class="flex-1 px-4 py-3 bg-gradient-to-r flex items-center justify-center from-green-500 to-green-600 text-white text-sm font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-200 transform hover:scale-105 shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Terima
                                    </button>
                                    <button wire:click="declineInvitation({{ $invitation->collaboration->id }})"
                                        class="flex-1 px-4 py-3 bg-gradient-to-r flex items-center justify-center from-red-500 to-red-600 text-white text-sm font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-200 transform hover:scale-105 shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tolak
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div
                            class="w-20 h-20 mx-auto mb-4 bg-yellow-100 dark:bg-yellow-900/20 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-yellow-600 dark:text-yellow-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5v-5zM4 19h6a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Tidak ada undangan</h3>
                        <p class="text-gray-500 dark:text-gray-400">Anda belum memiliki undangan kolaborasi saat ini
                        </p>
                    </div>
                @endif
            </div>
        @endif

        <!-- My Collaborations Tab -->
        @if ($activeTab === 'my-collaborations')
            <div class="mb-8">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Kolaborasi Saya</h3>
                    <p class="text-gray-600 dark:text-gray-400">Kolaborasi yang Anda ikuti dan kelola bersama</p>
                </div>
                @if ($this->myCollaborations->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($this->myCollaborations as $collaboration)
                            <div
                                class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-700 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">
                                            {{ $collaboration->collaboration->title }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                                            {{ $collaboration->collaboration->description ?? 'Tidak ada deskripsi' }}
                                        </p>
                                    </div>
                                    <div class="ml-4">
                                        @if ($collaboration->collaboration->status === 'completed')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Selesai
                                            </span>
                                        @elseif($collaboration->collaboration->status === 'active')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Menunggu
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center mb-4 p-3 bg-white dark:bg-gray-800 rounded-lg">
                                    <div
                                        class="w-8 h-8 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Anggota</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $collaboration->collaboration->collaborationUsers->where('status', 'accepted')->count() }}
                                            orang</p>
                                    </div>
                                </div>

                                <div class="flex gap-2 mb-4">
                                    <a href="{{ route('collaboration.todos', $collaboration->collaboration_id) }}"
                                        class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all duration-200 text-center">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                            </path>
                                        </svg>
                                        Lihat Tugas
                                    </a>
                                    <button wire:click="toggleInviteForm({{ $collaboration->collaboration->id }})"
                                        class="flex-1 px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-all duration-200">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                            </path>
                                        </svg>
                                        Undang
                                    </button>
                                </div>

                                <div class="flex gap-2">
                                    @if ($collaboration->collaboration->status === 'pending')
                                        <button wire:click="markAsActive({{ $collaboration->collaboration->id }})"
                                            class="w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Aktifkan Kolaborasi
                                        </button>
                                    @elseif($collaboration->collaboration->status === 'active')
                                        <button wire:click="markAsCompleted({{ $collaboration->collaboration->id }})"
                                            class="w-full px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-semibold rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Tandai Selesai
                                        </button>
                                    @elseif($collaboration->collaboration->status === 'completed')
                                        <button wire:click="markAsActive({{ $collaboration->collaboration->id }})"
                                            class="w-full px-4 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-sm font-semibold rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Aktifkan Kembali
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div
                            class="w-20 h-20 mx-auto mb-4 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum ada kolaborasi</h3>
                        <p class="text-gray-500 dark:text-gray-400">Bergabunglah dengan kolaborasi yang menarik</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Tab Kolaborasi yang Dibuat -->
        @if ($activeTab === 'created')
            <div class="mb-8">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Kolaborasi Yang Saya Buat</h3>
                    <p class="text-gray-600 dark:text-gray-400">Kolaborasi yang Anda buat dan kelola</p>
                </div>
                @if ($this->createdCollaborations->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($this->createdCollaborations as $collaboration)
                            <div
                                class="p-6 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-700 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">
                                            {{ $collaboration->title }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                                            {{ $collaboration->description ?? 'Tidak ada deskripsi' }}
                                        </p>
                                    </div>
                                    <div class="ml-4">
                                        @if ($collaboration->status === 'completed')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Selesai
                                            </span>
                                        @elseif($collaboration->status === 'active')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Menunggu
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center mb-4 p-3 bg-white dark:bg-gray-800 rounded-lg">
                                    <div
                                        class="w-8 h-8 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Anggota</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $collaboration->collaborationUsers->where('status', 'accepted')->count() }}
                                            orang</p>
                                    </div>
                                </div>

                                <div class="flex gap-2 mb-4">
                                    <a href="{{ route('collaboration.todos', $collaboration->id) }}"
                                        class="flex-1 px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-all duration-200 text-center">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                            </path>
                                        </svg>
                                        Lihat Tugas
                                    </a>
                                    <button wire:click="toggleInviteForm({{ $collaboration->id }})"
                                        class="flex-1 px-3 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all duration-200">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                            </path>
                                        </svg>
                                        Undang
                                    </button>
                                </div>

                                <div class="flex gap-2">
                                    @if ($collaboration->status === 'pending')
                                        <button wire:click="markAsActive({{ $collaboration->id }})"
                                            class="w-full px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-semibold rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Aktifkan Kolaborasi
                                        </button>
                                    @elseif($collaboration->status === 'active')
                                        <button wire:click="markAsCompleted({{ $collaboration->id }})"
                                            class="w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Tandai Selesai
                                        </button>
                                    @elseif($collaboration->status === 'completed')
                                        <button wire:click="markAsActive({{ $collaboration->id }})"
                                            class="w-full px-4 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-sm font-semibold rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Aktifkan Kembali
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div
                            class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center">
                            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Kolaborasi yang
                            Dibuat</h3>
                        <p class="text-gray-600 dark:text-gray-400 max-w-sm mx-auto leading-relaxed">
                            Mulai buat kolaborasi pertama Anda untuk menghubungkan kreator dan menciptakan dampak yang
                            lebih besar.
                        </p>
                        <div class="mt-8">
                            @if($isFormDisabled)
                                <div class="group relative inline-block" x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                    <button disabled
                                        class="inline-flex items-center gap-2 px-6 py-3 bg-gray-400 text-gray-200 font-medium rounded-xl cursor-not-allowed opacity-60">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                        </svg>
                                        Fitur Dinonaktifkan
                                    </button>
                                    <!-- Tooltip -->
                                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg shadow-lg whitespace-nowrap z-50">
                                        Fitur kolaborasi sedang dinonaktifkan oleh administrator
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
                                    </div>
                                </div>
                            @else
                                <button wire:click="$set('showCreateForm', true)"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Buat Kolaborasi Pertama
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Invite Users Form -->
    @if ($showInviteForm && $selectedCollaboration)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">
                    Undang User ke "{{ $selectedCollaboration->title }}"
                </h3>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pilih User
                    </label>
                    <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-lg">
                        @foreach ($availableUsers as $user)
                            <label class="flex items-center p-2 hover:bg-gray-100 cursor-pointer">
                                <input type="checkbox" wire:model="selectedUsers" value="{{ $user->id }}"
                                    class="mr-2 text-blue-600">
                                <div class="flex items-center justify-between w-full">
                                    <span class="text-sm text-gray-700">{{ $user->name }}</span>
                                    <a href="{{ route('profile.view', $user->id) }}"
                                        class="text-xs text-blue-600 hover:text-blue-800 transition-colors ml-2">
                                        Lihat Profile
                                    </a>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-2">
                    <button wire:click="inviteUsers"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Kirim Undangan
                    </button>
                    <button wire:click="closeInviteForm"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if (
        $activeTab === 'overview' &&
            $this->pendingInvitations->count() == 0 &&
            $this->myCollaborations->count() == 0 &&
            $this->createdCollaborations->count() == 0)
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada kolaborasi</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Mulai dengan membuat kolaborasi baru atau bergabung dengan kolaborasi yang ada.
            </p>
            <div class="mt-6">
                <button wire:click="toggleCreateForm"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Buat Kolaborasi
                </button>
            </div>
        </div>
    @endif
</div>
