<div class="max-w-7xl mx-auto min-h-screen">
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div
            class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border border-green-200 dark:border-green-600 rounded-xl shadow-sm dark:shadow-slate-900/50 animate-pulse">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full bg-green-100 dark:bg-green-900/50 flex items-center justify-center">
                        <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('message') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.remove()"
                    class="ml-auto flex-shrink-0">
                    <svg class="h-5 w-5 text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div
            class="mb-6 p-4 bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/30 dark:to-pink-900/30 border border-red-200 dark:border-red-600 rounded-xl shadow-sm dark:shadow-slate-900/50 animate-pulse">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800 dark:text-red-300">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.remove()"
                    class="ml-auto flex-shrink-0">
                    <svg class="h-5 w-5 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    @endif


    <!-- Hero Header -->
    <div
        class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 rounded-2xl shadow-2xl dark:shadow-slate-900/50 mb-8">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative p-8 sm:p-12 text-white">
            <div class="max-w-3xl">
                <h1 class="text-3xl sm:text-4xl font-bold mb-4">Pengaturan Profil</h1>
                <p class="text-lg text-blue-100 dark:text-blue-200 leading-relaxed">Kelola informasi profil, minat, dan
                    keahlian Anda untuk terhubung dengan kreator yang memiliki passion serupa.</p>
                <div class="mt-6 flex items-center space-x-4">
                    <div class="flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2">
                        <svg class="h-5 w-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-sm font-medium">Profil Lengkap</span>
                    </div>
                    <div class="flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2">
                        <svg class="h-5 w-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium">Minat & Keahlian</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white/10"></div>
        <div class="absolute bottom-0 left-0 -mb-4 -ml-4 h-24 w-24 rounded-full bg-white/5"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <div class="sticky top-16">
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm dark:shadow-slate-900/50 border border-gray-100 dark:border-slate-700 p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4">Menu Pengaturan</h3>
                    <nav class="space-y-2">
                        <button wire:click="setTab('profile')"
                            class="flex items-center px-3 sm:px-4 w-full py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-xl 
                            @if ($tab === 'profile') bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-600 shadow-sm 
                            @else text-gray-700 dark:text-slate-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-blue-900/30 dark:hover:to-indigo-900/30 hover:text-blue-700 dark:hover:text-blue-300 hover:border hover:border-blue-200 dark:hover:border-blue-600 transition-all duration-200 @endif">
                            <div
                                class="h-6 w-6 sm:h-8 sm:w-8 rounded-lg @if ($tab === 'profile') bg-blue-100 dark:bg-blue-900/50 @else bg-gray-100 dark:bg-slate-700 @endif flex items-center justify-center mr-2 sm:mr-3">
                                <svg class="h-3 w-3 sm:h-4 sm:w-4  @if ($tab === 'profile') text-blue-600 dark:text-blue-400 @else text-gray-600 dark:text-slate-400 @endif group-hover:text-blue-600 dark:group-hover:text-blue-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="hidden sm:inline">Informasi Profil</span>
                            <span class="sm:hidden">Profil</span>
                        </button>
                        <button wire:click="setTab('interests')"
                            class="flex items-center px-3 sm:px-4 w-full py-2.5 sm:py-3 text-xs sm:text-sm text-left font-medium rounded-xl 
                            @if ($tab === 'interests') bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-600 shadow-sm 
                            @else text-gray-700 dark:text-slate-300 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 dark:hover:from-purple-900/30 dark:hover:to-pink-900/30 hover:text-purple-700 dark:hover:text-purple-300 hover:border hover:border-purple-200 dark:hover:border-purple-600 transition-all duration-200 @endif">
                            <div
                                class="h-6 w-6 sm:h-8 sm:w-8 rounded-lg @if ($tab === 'interests') bg-purple-100 dark:bg-purple-900/50 @else bg-gray-100 dark:bg-slate-700 @endif flex items-center justify-center mr-2 sm:mr-3 group-hover:bg-purple-100 dark:group-hover:bg-purple-900/50">
                                <svg class="h-3 w-3 sm:h-4 sm:w-4 @if ($tab === 'interests') text-purple-600 dark:text-purple-400 @else text-gray-600 dark:text-slate-400 @endif group-hover:text-purple-600 dark:group-hover:text-purple-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </div>
                            <span class="hidden sm:inline">Minat & Ketertarikan</span>
                            <span class="sm:hidden">Minat</span>
                        </button>
                        <button wire:click="setTab('skills')"
                            class="flex items-center px-4 w-full py-3 text-sm font-medium rounded-xl @if ($tab === 'skills') bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-600 shadow-sm @else text-gray-700 dark:text-slate-300 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 dark:hover:from-green-900/30 dark:hover:to-emerald-900/30 hover:text-green-700 dark:hover:text-green-300 hover:border hover:border-green-200 dark:hover:border-green-600 transition-all duration-200 @endif">
                            <div
                                class="h-8 w-8 rounded-lg @if ($tab === 'skills') bg-green-100 dark:bg-green-900/50 @else bg-gray-100 dark:bg-slate-700 @endif flex items-center justify-center mr-3 group-hover:bg-green-100 dark:group-hover:bg-green-900/50">
                                <svg class="h-4 w-4 @if ($tab === 'skills') text-green-600 dark:text-green-400 @else text-gray-600 dark:text-slate-400 @endif group-hover:text-green-600 dark:group-hover:text-green-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                    </path>
                                </svg>
                            </div>
                            Keahlian
                        </button>
                        {{-- <button wire:click="setTab('contributions')"
                            class="flex items-center px-4 w-full py-3 text-sm font-medium rounded-xl @if ($tab === 'contributions') bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/30 dark:to-orange-900/30 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-600 shadow-sm @else text-gray-700 dark:text-slate-300 hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 dark:hover:from-amber-900/30 dark:hover:to-orange-900/30 hover:text-amber-700 dark:hover:text-amber-300 hover:border hover:border-amber-200 dark:hover:border-amber-600 transition-all duration-200 @endif">
                            <div
                                class="h-8 w-8 rounded-lg @if ($tab === 'contributions') bg-amber-100 dark:bg-amber-900/50 @else bg-gray-100 dark:bg-slate-700 @endif flex items-center justify-center mr-3 group-hover:bg-amber-100 dark:group-hover:bg-amber-900/50">
                                <svg class="h-4 w-4 @if ($tab === 'contributions') text-amber-600 dark:text-amber-400 @else text-gray-600 dark:text-slate-400 @endif group-hover:text-amber-600 dark:group-hover:text-amber-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            Kontribusi
                        </button> --}}
                        <button wire:click="setTab('danger')"
                            class="flex items-center px-4 w-full py-3 text-sm font-medium rounded-xl @if ($tab === 'danger') bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/30 dark:to-pink-900/30 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-600 shadow-sm @else text-gray-700 dark:text-slate-300 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 dark:hover:from-red-900/30 dark:hover:to-pink-900/30 hover:text-red-700 dark:hover:text-red-300 hover:border hover:border-red-200 dark:hover:border-red-600 transition-all duration-200 @endif">
                            <div
                                class="h-8 w-8 rounded-lg @if ($tab === 'danger') bg-red-100 dark:bg-red-900/50 @else bg-gray-100 dark:bg-slate-700 @endif flex items-center justify-center mr-3 group-hover:bg-red-100 dark:group-hover:bg-red-900/50">
                                <svg class="h-4 w-4 @if ($tab === 'danger') text-red-600 dark:text-red-400 @else text-gray-600 dark:text-slate-400 @endif group-hover:text-red-600 dark:group-hover:text-red-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </div>
                            Danger Zone
                        </button>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-8">
            @if ($tab === 'profile')
                <!-- Profile Information Section -->
                <div id="profile-info"
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm dark:shadow-slate-900/50 border border-gray-100 dark:border-slate-700 overflow-visible">
                    <div
                        class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 px-6 py-4 border-b border-blue-100 dark:border-blue-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="h-10 w-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Informasi
                                        Profil</h3>
                                    <p class="text-sm text-gray-600 dark:text-slate-400">Update informasi profil dan
                                        alamat email Anda.</p>
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900/30 px-3 py-1 text-xs font-medium text-blue-800 dark:text-blue-300 ring-1 ring-inset ring-blue-200 dark:ring-blue-600">Required</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <form wire:submit="updateProfileInformation" class="space-y-6">
                            <!-- Profile Photo Upload Section -->
                            <div class="space-y-4">
                                <label class="block text-sm font-medium text-gray-900 dark:text-slate-100">Foto
                                    Profil</label>
                                <div class="flex items-center space-x-6">
                                    <div class="flex-shrink-0">
                                        <x-ui.avatar :user="auth()->user()" size="xl" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <input type="file" wire:model="profilePhoto" id="profilePhoto"
                                                accept="image/*"
                                                class="block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50">
                                            <button type="button" wire:click="updateProfilePhoto"
                                                wire:loading.attr="disabled"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-blue-400 disabled:opacity-50 disabled:cursor-not-allowed">
                                                <svg wire:loading.remove class="mr-2 h-4 w-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                                                    </path>
                                                </svg>
                                                <svg wire:loading class="mr-2 h-4 w-4 animate-spin" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                Upload
                                            </button>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500 dark:text-slate-400">Format: JPG, PNG,
                                            GIF. Maksimal 2MB.</p>
                                        @error('profilePhoto')
                                            <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Banner Upload Section -->
                            <div class="space-y-4">
                                <label
                                    class="block text-sm font-medium text-gray-900 dark:text-slate-100">Banner</label>
                                <div class="space-y-4">
                                    <x-ui.banner :user="auth()->user()" height="h-32" />
                                    <div class="flex items-center space-x-3">
                                        <input type="file" wire:model="banner" id="banner" accept="image/*"
                                            class="block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50">
                                        <button type="button" wire:click="updateBanner" wire:loading.attr="disabled"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <svg wire:loading.remove class="mr-2 h-4 w-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                                                </path>
                                            </svg>
                                            <svg wire:loading class="mr-2 h-4 w-4 animate-spin" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            Upload
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-slate-400">Format: JPG, PNG, GIF.
                                        Maksimal 5MB.</p>
                                    @error('banner')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-900 dark:text-slate-100">Nama
                                        Lengkap</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="text" wire:model="name" id="name" required autofocus
                                            autocomplete="name"
                                            class="pl-12 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6"
                                            placeholder="Masukkan nama lengkap Anda">
                                    </div>
                                    @error('name')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-900 dark:text-slate-100">Email</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="email" wire:model="email" id="email" required
                                            autocomplete="email"
                                            class="pl-12 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6"
                                            placeholder="Masukkan email Anda">
                                    </div>
                                    @error('email')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="organization"
                                        class="block text-sm font-medium text-gray-900 dark:text-slate-100">Organisasi</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="text" wire:model="organization" id="organization"
                                            autocomplete="organization"
                                            class="pl-12 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6"
                                            placeholder="Nama organisasi atau perusahaan">
                                    </div>
                                    @error('organization')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-900 dark:text-slate-100">Nomor
                                        Telepon</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="tel" wire:model="phone" id="phone" autocomplete="tel"
                                            class="pl-12 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6"
                                            placeholder="Nomor telepon (opsional)">
                                    </div>
                                    @error('phone')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- <div class="space-y-2">
                                    <label for="selectedRole"
                                        class="block text-sm font-medium text-gray-900 dark:text-slate-100">Peran</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                        <select wire:model="selectedRole" id="selectedRole"
                                            class="pl-12 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6">
                                            <option value="">Pilih peran Anda</option>
                                            @foreach($peran as $role)
                                                <option value="{{ $role->id }}">{{ $role->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('selectedRole')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                            </div>

                            <div class="space-y-2">
                                <label for="vision"
                                    class="block text-sm font-medium text-gray-900 dark:text-slate-100">Visi &
                                    Misi</label>
                                <div class="relative">
                                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 mt-0.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                            </path>
                                        </svg>
                                    </div>
                                    <textarea wire:model="vision" id="vision" rows="4"
                                        class="pl-12 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6"
                                        placeholder="Ceritakan visi dan misi Anda dalam berkarya..."></textarea>
                                </div>
                                @error('vision')
                                    <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Social Media Section -->
                            <div class="space-y-4">
                                <label class="block text-sm font-medium text-gray-900 dark:text-slate-100">Media Sosial</label>
                                <p class="text-sm text-gray-600 dark:text-slate-400">Bagikan link media sosial Anda (opsional)</p>
                                
                                <!-- Social Media List -->
                                <div class="space-y-3">
                                    @foreach($socialMediaItems as $index => $item)
                                        <div class="social-media-item relative flex items-center space-x-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700">
                                            <!-- Platform Icon -->
                                            <div class="absolute left-2 flex-shrink-0 w-8 h-8 flex items-center justify-center">
                                                @if($item['type'] === 'linkedin')
                                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                    </svg>
                                                @elseif($item['type'] === 'twitter')
                                                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                                    </svg>
                                                @elseif($item['type'] === 'instagram')
                                                <svg class="w-5 h-5 text-pink-500" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint0_radial_87_7153)"/>
                                                    <rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint1_radial_87_7153)"/>
                                                    <rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint2_radial_87_7153)"/>
                                                    <path d="M23 10.5C23 11.3284 22.3284 12 21.5 12C20.6716 12 20 11.3284 20 10.5C20 9.67157 20.6716 9 21.5 9C22.3284 9 23 9.67157 23 10.5Z" fill="white"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16 21C18.7614 21 21 18.7614 21 16C21 13.2386 18.7614 11 16 11C13.2386 11 11 13.2386 11 16C11 18.7614 13.2386 21 16 21ZM16 19C17.6569 19 19 17.6569 19 16C19 14.3431 17.6569 13 16 13C14.3431 13 13 14.3431 13 16C13 17.6569 14.3431 19 16 19Z" fill="white"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6 15.6C6 12.2397 6 10.5595 6.65396 9.27606C7.2292 8.14708 8.14708 7.2292 9.27606 6.65396C10.5595 6 12.2397 6 15.6 6H16.4C19.7603 6 21.4405 6 22.7239 6.65396C23.8529 7.2292 24.7708 8.14708 25.346 9.27606C26 10.5595 26 12.2397 26 15.6V16.4C26 19.7603 26 21.4405 25.346 22.7239C24.7708 23.8529 23.8529 24.7708 22.7239 25.346C21.4405 26 19.7603 26 16.4 26H15.6C12.2397 26 10.5595 26 9.27606 25.346C8.14708 24.7708 7.2292 23.8529 6.65396 22.7239C6 21.4405 6 19.7603 6 16.4V15.6ZM15.6 8H16.4C18.1132 8 19.2777 8.00156 20.1779 8.0751C21.0548 8.14674 21.5032 8.27659 21.816 8.43597C22.5686 8.81947 23.1805 9.43139 23.564 10.184C23.7234 10.4968 23.8533 10.9452 23.9249 11.8221C23.9984 12.7223 24 13.8868 24 15.6V16.4C24 18.1132 23.9984 19.2777 23.9249 20.1779C23.8533 21.0548 23.7234 21.5032 23.564 21.816C23.1805 22.5686 22.5686 23.1805 21.816 23.564C21.5032 23.7234 21.0548 23.8533 20.1779 23.9249C19.2777 23.9984 18.1132 24 16.4 24H15.6C13.8868 24 12.7223 23.9984 11.8221 23.9249C10.9452 23.8533 10.4968 23.7234 10.184 23.564C9.43139 23.1805 8.81947 22.5686 8.43597 21.816C8.27659 21.5032 8.14674 21.0548 8.0751 20.1779C8.00156 19.2777 8 18.1132 8 16.4V15.6C8 13.8868 8.00156 12.7223 8.0751 11.8221C8.14674 10.9452 8.27659 10.4968 8.43597 10.184C8.81947 9.43139 9.43139 8.81947 10.184 8.43597C10.4968 8.27659 10.9452 8.14674 11.8221 8.0751C12.7223 8.00156 13.8868 8 15.6 8Z" fill="white"/>
                                                    <defs>
                                                    <radialGradient id="paint0_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(12 23) rotate(-55.3758) scale(25.5196)">
                                                    <stop stop-color="#B13589"/>
                                                    <stop offset="0.79309" stop-color="#C62F94"/>
                                                    <stop offset="1" stop-color="#8A3AC8"/>
                                                    </radialGradient>
                                                    <radialGradient id="paint1_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(11 31) rotate(-65.1363) scale(22.5942)">
                                                    <stop stop-color="#E0E8B7"/>
                                                    <stop offset="0.444662" stop-color="#FB8A2E"/>
                                                    <stop offset="0.71474" stop-color="#E2425C"/>
                                                    <stop offset="1" stop-color="#E2425C" stop-opacity="0"/>
                                                    </radialGradient>
                                                    <radialGradient id="paint2_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(0.500002 3) rotate(-8.1301) scale(38.8909 8.31836)">
                                                    <stop offset="0.156701" stop-color="#406ADC"/>
                                                    <stop offset="0.467799" stop-color="#6A45BE"/>
                                                    <stop offset="1" stop-color="#6A45BE" stop-opacity="0"/>
                                                    </radialGradient>
                                                    </defs>
                                                    </svg>
                                                @elseif($item['type'] === 'facebook')
                                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                    </svg>
                                                @elseif($item['type'] === 'youtube')
                                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.017 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                                    </svg>
                                                @elseif($item['type'] === 'tiktok')
                                                    <svg class="w-5 h-5 text-black dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.08-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                                    </svg>
                                                @elseif($item['type'] === 'github')
                                                    <svg class="w-5 h-5 text-gray-800 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                                    </svg>
                                                @elseif($item['type'] === 'website')
                                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            
                                            <!-- URL Input -->
                                            <input type="url" 
                                                   wire:model="socialMediaItems.{{ $index }}.url"
                                                   placeholder="{{ $this->getPlaceholderForPlatform($item['type']) }}"
                                                   class="w-full px-12 py-3 text-sm m-0 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md text-slate-700 dark:text-slate-300 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            
                                            <!-- Remove Button -->
                                            <button type="button" 
                                                    wire:click="removeSocialMedia({{ $index }})"
                                                    class="p-2 absolute right-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                    
                                    <!-- Platform Selection Dropdown -->
                                    @if($showPlatformModal)
                                        <!-- Backdrop -->
                                        <div class="fixed inset-0 z-40" wire:click="closePlatformModal"></div>
                                        
                                        <div class="relative platform-selection-container mb-4">
                                            <div class="absolute top-0 left-0 right-0 z-50 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-xl mt-2 max-h-80 overflow-y-auto">
                                                <div class="p-4">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Pilih Platform Media Sosial</h3>
                                                        <button type="button" 
                                                                wire:click="closePlatformModal"
                                                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-2">
                                                        @foreach($this->getAvailablePlatforms() as $platform)
                                                            <button type="button" 
                                                                    wire:click="selectPlatform('{{ $platform['value'] }}')"
                                                                    class="platform-option flex items-center space-x-2 p-3 text-left border border-slate-200 dark:border-slate-600 rounded-md hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                                                <div class="w-4 h-4 flex items-center justify-center">
                                                                    {!! $platform['icon'] !!}
                                                                </div>
                                                                <span class="text-xs font-medium text-slate-700 dark:text-slate-300">{{ $platform['label'] }}</span>
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Add Social Media Button -->
                                    <button type="button" 
                                            wire:click="showPlatformSelection"
                                            class="add-social-media-btn w-full flex items-center justify-center space-x-2 px-4 py-3 bg-slate-100 dark:bg-slate-800 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:border-slate-400 dark:hover:border-slate-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        <span class="font-medium">Tambah Media Sosial</span>
                                    </button>
                                </div>
                            </div>

                            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                                <div class="rounded-xl bg-amber-50 border border-amber-200 p-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-amber-600 dark:text-amber-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-amber-800 dark:text-amber-400">
                                                {{ __('Your email address is unverified.') }}
                                                <button type="button"
                                                    wire:click.prevent="resendVerificationNotification"
                                                    class="text-amber-700 dark:text-amber-400 hover:text-amber-600 dark:hover:text-amber-300 text-sm font-medium underline">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>

                                            @if (session('status') === 'verification-link-sent')
                                                <p
                                                    class="mt-2 text-sm font-medium text-emerald-600 dark:text-emerald-400">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan Perubahan
                                    </button>

                                    <!-- Unsaved Changes Indicator -->
                                    <div id="profile-unsaved-indicator" class="hidden">
                                        <span
                                            class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-800 ring-1 ring-inset ring-amber-200">
                                            <svg class="mr-1.5 h-3.5 w-3.5 text-amber-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            </svg>
                                            Belum Disimpan
                                        </span>
                                    </div>
                                </div>

                                <x-action-message class="mr-3" on="profile-updated">
                                    <span
                                        class="inline-flex items-center rounded-xl bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                        <svg class="mr-2 h-4 w-4 text-emerald-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ __('Saved successfully!') }}
                                    </span>
                                </x-action-message>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($tab === 'interests')
                <!-- Enhanced Interests Section -->
                <div id="interests"
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm dark:shadow-slate-900/50 border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <!-- Enhanced Header with Stats -->
                    <div
                        class="bg-gradient-to-br from-purple-50 via-pink-50 to-rose-50 dark:from-purple-900/30 dark:via-pink-900/30 dark:to-rose-900/30 px-6 py-6 border-b border-purple-100 dark:border-purple-800">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="h-12 min-w-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 dark:from-purple-600 dark:to-pink-600 flex items-center justify-center shadow-lg dark:shadow-slate-900/50">
                                    <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-slate-100">Minat &
                                        Ketertarikan</h3>
                                    <p class="text-gray-600 dark:text-slate-400">Pilih minat yang sesuai untuk
                                        terhubung dengan kreator serupa</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                                    {{ count($selectedInterests) }}</div>
                                <div class="text-sm text-gray-600 dark:text-slate-400">Minat Dipilih</div>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div
                                class="bg-white/60 dark:bg-slate-700/60 backdrop-blur-sm rounded-xl p-3 border border-purple-200 dark:border-purple-700">
                                <div class="flex items-center space-x-2">
                                    <div
                                        class="h-8 w-8 rounded-lg bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-purple-600 dark:text-purple-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-lg font-semibold text-gray-900 dark:text-slate-100">
                                            {{ count($selectedInterests) }}</div>
                                        <div class="text-xs text-gray-600 dark:text-slate-400">Dipilih</div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-white/60 dark:bg-slate-700/60 backdrop-blur-sm rounded-xl p-3 border border-purple-200 dark:border-purple-700">
                                <div class="flex items-center space-x-2">
                                    <div
                                        class="h-8 w-8 rounded-lg bg-pink-100 dark:bg-pink-900/50 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-pink-600 dark:text-pink-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-lg font-semibold text-gray-900 dark:text-slate-100">
                                            {{ count($interests) }}</div>
                                        <div class="text-xs text-gray-600 dark:text-slate-400">Tersedia</div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="bg-white/60 backdrop-blur-sm rounded-xl p-3 border border-purple-200">
                                <div class="flex items-center space-x-2">
                                    <div class="h-8 w-8 rounded-lg bg-rose-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-lg font-semibold text-gray-900">{{ count($interests) > 0 ? round((count($selectedInterests) / count($interests)) * 100) : 0 }}%</div>
                                        <div class="text-xs text-gray-600">Lengkapi</div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Progress Indicator -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-slate-300">Progress Pemilihan
                                    Minat</span>
                                <span class="text-sm text-gray-500 dark:text-slate-400">
                                    @php
                                        $interestProgress =
                                            count($interests) > 0
                                                ? round((count($selectedInterests) / count($interests)) * 100)
                                                : 0;
                                    @endphp
                                    {{ $interestProgress }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-600 dark:from-purple-400 dark:to-pink-500 h-2 rounded-full transition-all duration-500 ease-out"
                                    style="width: {{ $interestProgress }}%"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($interests as $interest)
                                <label
                                    class="group relative flex items-start p-5 cursor-pointer bg-white dark:bg-slate-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 dark:hover:from-purple-900/30 dark:hover:to-pink-900/30 rounded-xl transition-all duration-200 ring-1 ring-gray-200 dark:ring-slate-600 hover:ring-purple-300 dark:hover:ring-purple-600 hover:shadow-md dark:hover:shadow-slate-900/50 transform hover:-translate-y-1">
                                    <div class="min-w-0 flex flex-col flex-1">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center">
                                                <div class="relative flex items-center">
                                                    <input type="checkbox" wire:model.live="selectedInterests"
                                                        value="{{ $interest->id }}"
                                                        class="peer h-5 w-5 text-purple-600 dark:text-purple-400 border-gray-300 dark:border-slate-600 dark:bg-slate-700 rounded-lg focus:ring-purple-500 dark:focus:ring-purple-400 focus:ring-2 transition-all duration-200">
                                                    {{-- <div class="pointer-events-none absolute top-5 left-5 transform -translate-y-1/2 opacity-0 peer-checked:opacity-100 transition-all duration-200 scale-75 peer-checked:scale-100">
                                                        <svg class="h-3.5 w-3.5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div> --}}
                                                </div>
                                                <span
                                                    class="ml-3 text-sm font-semibold text-gray-900 dark:text-slate-100 group-hover:text-purple-700 dark:group-hover:text-purple-300 transition-colors duration-200">{{ $interest->name }}</span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <span
                                                    class="inline-flex items-center rounded-full bg-purple-100 dark:bg-purple-900/30 px-3 py-1 text-xs font-medium text-purple-700 dark:text-purple-300 ring-1 ring-inset ring-purple-200 dark:ring-purple-600 opacity-0 group-hover:opacity-100 transition-all duration-200">
                                                    {{ rand(10, 50) }} kreator
                                                </span>
                                            </div>
                                        </div>
                                        @if ($interest->description)
                                            <p
                                                class="text-xs text-gray-600 dark:text-slate-400 ml-8 leading-relaxed group-hover:text-gray-700 dark:group-hover:text-slate-300 transition-colors duration-200">
                                                {{ $interest->description }}
                                            </p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div
                            class="mt-8 flex items-center justify-between pt-6 border-t border-gray-200 dark:border-slate-600">
                            <div class="flex items-center space-x-4">
                                <button wire:click="updateInterests" wire:loading.attr="disabled"
                                    class="inline-flex items-center px-8 py-4 border border-transparent text-base font-semibold rounded-xl shadow-lg dark:shadow-slate-900/50 text-white bg-gradient-to-r from-purple-600 to-pink-600 dark:from-purple-500 dark:to-pink-500 hover:from-purple-700 hover:to-pink-700 dark:hover:from-purple-600 dark:hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 dark:focus:ring-purple-400 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                    <svg wire:loading.remove class="mr-2 h-5 w-5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <svg wire:loading class="mr-2 h-5 w-5 animate-spin" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Simpan Minat
                                </button>

                                <!-- Unsaved Changes Indicator -->
                                <div id="interests-unsaved-indicator" class="hidden">
                                    <span
                                        class="inline-flex items-center rounded-full bg-amber-100 dark:bg-amber-900/30 px-3 py-1 text-xs font-medium text-amber-800 dark:text-amber-300 ring-1 ring-inset ring-amber-200 dark:ring-amber-600">
                                        <svg class="mr-1.5 h-3.5 w-3.5 text-amber-600 dark:text-amber-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        Belum Disimpan
                                    </span>
                                </div>
                            </div>

                            <x-action-message class="mr-3" on="interests-updated">
                                <div
                                    class="inline-flex items-center rounded-xl bg-green-50 dark:bg-green-900/30 px-4 py-3 text-sm font-medium text-green-700 dark:text-green-300 ring-1 ring-inset ring-green-600/20 dark:ring-green-600/30 animate-bounce">
                                    <svg class="mr-2 h-5 w-5 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Minat berhasil disimpan! 🎉
                                </div>
                            </x-action-message>
                        </div>
                    </div>
                </div>
            @elseif ($tab === 'skills')
                <!-- Skills Section -->
                <div id="skills"
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm dark:shadow-slate-900/50 border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 px-6 py-4 border-b border-green-100 dark:border-green-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Keahlian</h3>
                                <p class="text-sm text-gray-600 dark:text-slate-400">Pilih keahlian yang Anda miliki
                                    untuk memudahkan
                                    kolaborasi dengan kreator lain.</p>
                            </div>
                            <span
                                class="inline-flex min-w-fit items-center rounded-full bg-blue-50 dark:bg-blue-900/30 px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-300 ring-1 ring-inset ring-blue-700/10 dark:ring-blue-600/30">
                                {{ count($selectedSkills) }} dipilih
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($skills as $skill)
                                <label
                                    class="group relative flex items-start p-5 cursor-pointer bg-white dark:bg-slate-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 dark:hover:from-green-900/30 dark:hover:to-emerald-900/30 rounded-xl transition-all duration-200 ring-1 ring-gray-200 dark:ring-slate-600 hover:ring-green-300 dark:hover:ring-green-600 hover:shadow-md dark:hover:shadow-slate-900/50 transform hover:-translate-y-1">
                                    <div class="min-w-0 flex flex-col flex-1">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="relative flex items-center">
                                                    <input type="checkbox" wire:model.live="selectedSkills"
                                                        value="{{ $skill->id }}"
                                                        class="peer h-5 w-5 text-green-600 dark:text-green-400 border-gray-300 dark:border-slate-600 dark:bg-slate-700 rounded-lg focus:ring-green-500 dark:focus:ring-green-400 focus:ring-2">
                                                    {{-- <div
                                                        class="pointer-events-none absolute top-5 left-5 transform -translate-y-1/2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                                        <svg class="h-3.5 w-3.5 text-green-600" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div> --}}
                                                </div>
                                                <span
                                                    class="ml-3 text-sm font-semibold text-gray-900 dark:text-slate-100 group-hover:text-green-700 dark:group-hover:text-green-300">{{ $skill->name }}</span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <span
                                                    class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/30 px-3 py-1 text-xs font-medium text-green-700 dark:text-green-300 ring-1 ring-inset ring-green-200 dark:ring-green-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    {{ rand(5, 30) }} kreator
                                                </span>
                                            </div>
                                        </div>
                                        @if ($skill->description)
                                            <p
                                                class="mt-2 text-xs text-gray-600 dark:text-slate-400 ml-8 leading-relaxed">
                                                {{ $skill->description }}</p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div
                            class="mt-6 flex items-center justify-between pt-6 border-t border-gray-200 dark:border-slate-600">
                            <div class="flex items-center space-x-3">
                                <button wire:click="updateSkills"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl shadow-sm dark:shadow-slate-900/50 text-white bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-500 dark:to-emerald-500 hover:from-green-700 hover:to-emerald-700 dark:hover:from-green-600 dark:hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-green-400 transition-all duration-200 transform hover:scale-105">
                                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Perubahan
                                </button>

                                <!-- Unsaved Changes Indicator -->
                                <div id="skills-unsaved-indicator" class="hidden">
                                    <span
                                        class="inline-flex items-center rounded-full bg-amber-100 dark:bg-amber-900/30 px-3 py-1 text-xs font-medium text-amber-800 dark:text-amber-300 ring-1 ring-inset ring-amber-200 dark:ring-amber-600">
                                        <svg class="mr-1.5 h-3.5 w-3.5 text-amber-600 dark:text-amber-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        Belum Disimpan
                                    </span>
                                </div>
                            </div>

                            <x-action-message class="mr-3" on="skills-updated">
                                <span
                                    class="inline-flex items-center rounded-xl bg-green-50 dark:bg-green-900/30 px-3 py-2 text-sm font-medium text-green-700 dark:text-green-300 ring-1 ring-inset ring-green-600/20 dark:ring-green-600/30">
                                    <svg class="mr-2 h-4 w-4 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('Saved successfully!') }}
                                </span>
                            </x-action-message>
                        </div>
                    </div>
                </div>
            @elseif ($tab === 'contributions')
                <!-- Contributions Section -->
                <div id="contributions"
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm dark:shadow-slate-900/50 border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/30 dark:to-orange-900/30 px-6 py-4 border-b border-amber-100 dark:border-amber-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Kontribusi</h3>
                                <p class="text-sm text-gray-600 dark:text-slate-400">Tambahkan kontribusi yang telah
                                    Anda berikan untuk
                                    menginspirasi kreator lain.</p>
                            </div>
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-amber-700 dark:text-amber-300 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/30 dark:to-orange-900/30 hover:from-amber-100 hover:to-orange-100 dark:hover:from-amber-900/50 dark:hover:to-orange-900/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:focus:ring-amber-400 transition-all duration-200 border border-amber-200 dark:border-amber-700 hover:border-amber-300 dark:hover:border-amber-600">
                                Tambah Baru
                            </button>
                        </div>
                    </div>

                    {{-- Enhanced Add New Contribution Form --}}
                    <div class="p-6">
                        <div
                            class="bg-gradient-to-br from-gray-50 to-blue-50 dark:from-slate-700 dark:to-blue-900/30 border-2 border-dashed border-blue-200 dark:border-blue-700 rounded-2xl p-8 mb-8 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                            <div class="text-center mb-6">
                                <div
                                    class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 flex items-center justify-center mx-auto mb-4 shadow-lg dark:shadow-slate-900/50 animate-pulse">
                                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-2">Tambah Kontribusi
                                    Baru</h4>
                                <p class="text-gray-600 dark:text-slate-400">Pilih jenis kontribusi dan ceritakan
                                    pengalaman Anda</p>
                            </div>

                            <!-- Interactive Contribution Type Selection -->
                            <div class="mb-8">
                                <label
                                    class="block text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4 text-center">Pilih
                                    Jenis
                                    Kontribusi</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach ($contributions as $contribution)
                                        <div class="relative group">
                                            <input type="radio" id="contribution_{{ $contribution->id }}"
                                                wire:model="newContribution.contribution_id"
                                                value="{{ $contribution->id }}" class="sr-only peer">
                                            <label for="contribution_{{ $contribution->id }}"
                                                class="flex flex-col items-center p-4 bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-xl cursor-pointer peer-checked:border-blue-500 dark:peer-checked:border-blue-400 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 hover:border-gray-300 dark:hover:border-slate-500 transition-all duration-200 transform hover:scale-105 peer-checked:scale-105 peer-checked:shadow-lg dark:peer-checked:shadow-slate-900/50">
                                                <div
                                                    class="h-12 w-12 rounded-lg bg-gray-100 dark:bg-slate-600 flex items-center justify-center mb-3 peer-checked:bg-blue-100 dark:peer-checked:bg-blue-900/50 transition-colors duration-200 group-hover:bg-gray-50 dark:group-hover:bg-slate-500">
                                                    @switch($contribution->icon)
                                                        @case('academic-cap')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('globe')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('users')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('user-group')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('presentation')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2M9 12l2 2 4-4">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('chat')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('puzzle')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('handshake')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2M9 12l2 2 4-4">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('network')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('light-bulb')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('star')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('document-text')
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @default
                                                            <svg class="h-6 w-6 text-gray-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                                </path>
                                                            </svg>
                                                    @endswitch
                                                </div>
                                                <div class="text-center">
                                                    <div
                                                        class="text-sm font-medium text-gray-900 dark:text-slate-100 peer-checked:text-blue-900 dark:peer-checked:text-blue-300">
                                                        {{ $contribution->name }}</div>
                                                    <div
                                                        class="text-xs text-gray-500 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">
                                                        {{ $contribution->category }}</div>
                                                </div>
                                                <!-- Checkmark for selected -->
                                                <div
                                                    class="absolute top-2 right-2 h-5 w-5 rounded-full bg-blue-500 dark:bg-blue-600 flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-all duration-200 scale-75 peer-checked:scale-100">
                                                    <svg class="h-3 w-3 text-white" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Enhanced Form Fields -->
                            <div class="grid gap-6 max-w-2xl mx-auto">
                                <!-- Description Field -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-900 dark:text-slate-100">
                                        <span class="flex items-center">
                                            <svg class="h-5 w-5 text-blue-500 dark:text-blue-400 mr-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            Ceritakan Kontribusi Anda
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <textarea wire:model="newContribution.description" rows="4"
                                            class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 dark:text-slate-100 dark:bg-slate-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-400 focus:border-blue-600 dark:focus:border-blue-400 transition-all duration-200 resize-none"
                                            placeholder="Jelaskan detail kontribusi Anda, dampak yang dihasilkan, dan pelajaran yang didapat..."></textarea>
                                        <div
                                            class="absolute bottom-3 right-3 text-xs text-gray-400 dark:text-slate-500">
                                            {{ strlen($newContribution['description'] ?? '') }}/500
                                        </div>
                                    </div>
                                    @error('newContribution.description')
                                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date Field -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-900 dark:text-slate-100">
                                        <span class="flex items-center">
                                            <svg class="h-5 w-5 text-blue-500 dark:text-blue-400 mr-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            Kapan Kontribusi Dilakukan?
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="date" wire:model="newContribution.date"
                                            class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 dark:text-slate-100 dark:bg-slate-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-400 focus:border-blue-600 dark:focus:border-blue-400 transition-all duration-200">
                                    </div>
                                    @error('newContribution.date')
                                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center justify-center space-x-4 pt-6">
                                    <button wire:click="addContribution" wire:loading.attr="disabled"
                                        class="inline-flex items-center px-8 py-4 border border-transparent text-base font-semibold rounded-xl shadow-lg dark:shadow-slate-900/50 text-white bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-500 dark:to-indigo-500 hover:from-blue-700 hover:to-indigo-700 dark:hover:from-blue-600 dark:hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                        <svg wire:loading.remove class="mr-2 h-5 w-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        <svg wire:loading class="mr-2 h-5 w-5 animate-spin" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Tambah Kontribusi
                                    </button>

                                    <button type="button"
                                        wire:click="$set('newContribution', {contribution_id: '', description: '', date: ''})"
                                        class="inline-flex items-center px-6 py-4 border border-gray-300 dark:border-slate-600 text-base font-medium rounded-xl text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all duration-200">
                                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Reset
                                    </button>
                                </div>

                                <!-- Success Message -->
                                <x-action-message class="text-center" on="contribution-added">
                                    <div
                                        class="inline-flex items-center rounded-xl bg-green-50 dark:bg-green-900/30 px-4 py-3 text-sm font-medium text-green-700 dark:text-green-300 ring-1 ring-inset ring-green-600/20 dark:ring-green-600/30 animate-bounce">
                                        <svg class="mr-2 h-5 w-5 text-green-600 dark:text-green-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Kontribusi berhasil ditambahkan! 🎉
                                    </div>
                                </x-action-message>
                            </div>
                        </div>
                    </div>

                    {{-- Existing Contributions List --}}
                    <div class="flow-root">
                        <ul role="list" class="m-8">
                            @foreach ($userContributions as $contribution)
                                <li>
                                    <div class="relative pb-8">
                                        @if (!$loop->last)
                                            <span
                                                class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-slate-600"
                                                aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex items-start space-x-3">
                                            <div class="relative">
                                                <span
                                                    class="h-10 w-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center ring-8 ring-white dark:ring-slate-800">
                                                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-gray-900 dark:text-slate-100">
                                                    {{ $contribution->name }}</div>
                                                <p class="mt-1 text-sm text-gray-600 dark:text-slate-400">
                                                    {{ $contribution->pivot->description }}</p>
                                                <div class="mt-2 flex items-center space-x-4">
                                                    <div
                                                        class="flex items-center text-sm text-gray-500 dark:text-slate-400">
                                                        <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400 dark:text-slate-500"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                        {{ \Carbon\Carbon::parse($contribution->pivot->date)->format('d M Y') }}
                                                    </div>
                                                    <button wire:click="removeContribution({{ $contribution->id }})"
                                                        class="inline-flex items-center text-sm text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                        <svg class="mr-1.5 h-5 w-5" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @elseif ($tab === 'danger')
                <!-- Delete Account Section -->
                <div id="danger"
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm dark:shadow-slate-900/50 border border-red-200 dark:border-red-800 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/30 dark:to-pink-900/30 px-6 py-4 border-b border-red-100 dark:border-red-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="h-10 w-10 rounded-xl bg-red-100 dark:bg-red-900/50 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-red-600 dark:text-red-400">Danger Zone</h3>
                                    <p class="text-sm text-gray-600 dark:text-slate-400">Tindakan ini tidak dapat
                                        dibatalkan. Harap
                                        berhati-hati.</p>
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-red-100 dark:bg-red-900/30 px-3 py-1 text-xs font-medium text-red-800 dark:text-red-300 ring-1 ring-inset ring-red-200 dark:ring-red-600">Danger</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div
                            class="rounded-xl bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/30 dark:to-pink-900/30 p-6 border border-red-200 dark:border-red-700">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center">
                                        <svg class="h-7 w-7 text-red-600 dark:text-red-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-red-800 dark:text-red-300 mb-3">Hapus Akun
                                        Permanen</h3>
                                    <div class="text-sm text-red-700 dark:text-red-400 space-y-3">
                                        <p class="font-medium">Setelah akun Anda dihapus:</p>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            <div class="flex items-center space-x-2">
                                                <svg class="h-4 w-4 text-red-500 dark:text-red-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span class="dark:text-slate-300">Semua data profil Anda akan
                                                    dihapus</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="h-4 w-4 text-red-500 dark:text-red-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span class="dark:text-slate-300">Kontribusi dan kolaborasi Anda akan
                                                    dihapus</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="h-4 w-4 text-red-500 dark:text-red-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span class="dark:text-slate-300">Koneksi dengan kreator lain akan
                                                    terputus</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="h-4 w-4 text-red-500 dark:text-red-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span class="dark:text-slate-300">Tindakan ini tidak dapat
                                                    dibatalkan</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <livewire:settings.delete-user-form />
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript for tracking unsaved changes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let hasUnsavedChanges = false;
        let originalFormData = {};

        // Track form changes for profile section
        function trackProfileChanges() {
            const form = document.querySelector('form[wire\\:submit="updateProfileInformation"]');
            if (!form) return;

            const inputs = form.querySelectorAll('input, textarea');

            // Store original values
            inputs.forEach(input => {
                originalFormData[input.name || input.id] = input.value;
            });

            // Listen for changes
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const currentValue = this.value;
                    const originalValue = originalFormData[this.name || input.id];

                    if (currentValue !== originalValue) {
                        showUnsavedIndicator('profile');
                        showUnsavedWarning();
                        hasUnsavedChanges = true;
                    } else {
                        // Check if all other fields are also unchanged
                        const allUnchanged = Array.from(inputs).every(input => {
                            const current = input.value;
                            const original = originalFormData[input.name || input.id];
                            return current === original;
                        });

                        if (allUnchanged) {
                            hideUnsavedIndicator('profile');
                            hasUnsavedChanges = false;
                            hideUnsavedWarning();
                        }
                    }
                });
            });
        }

        // Track changes for interests section
        function trackInterestsChanges() {
            const checkboxes = document.querySelectorAll('input[wire\\:model\\.live="selectedInterests"]');
            if (checkboxes.length === 0) return;

            // Store original state
            const originalInterests = Array.from(checkboxes).map(cb => cb.checked);

            checkboxes.forEach((checkbox, index) => {
                checkbox.addEventListener('change', function() {
                    const currentState = Array.from(checkboxes).map(cb => cb.checked);
                    const hasChanges = currentState.some((checked, i) => checked !==
                        originalInterests[i]);

                    if (hasChanges) {
                        showUnsavedIndicator('interests');
                        showUnsavedWarning();
                        hasUnsavedChanges = true;
                    } else {
                        hideUnsavedIndicator('interests');
                        hasUnsavedChanges = false;
                        hideUnsavedWarning();
                    }
                });
            });
        }

        // Track changes for skills section
        function trackSkillsChanges() {
            const checkboxes = document.querySelectorAll('input[wire\\:model\\.live="selectedSkills"]');
            if (checkboxes.length === 0) return;

            // Store original state
            const originalSkills = Array.from(checkboxes).map(cb => cb.checked);

            checkboxes.forEach((checkbox, index) => {
                checkbox.addEventListener('change', function() {
                    const currentState = Array.from(checkboxes).map(cb => cb.checked);
                    const hasChanges = currentState.some((checked, i) => checked !==
                        originalSkills[i]);

                    if (hasChanges) {
                        showUnsavedIndicator('skills');
                        showUnsavedWarning();
                        hasUnsavedChanges = true;
                    } else {
                        hideUnsavedIndicator('skills');
                        hasUnsavedChanges = false;
                        hideUnsavedWarning();
                    }
                });
            });
        }

        // Track changes for contributions section
        function trackContributionsChanges() {
            const inputs = document.querySelectorAll(
                'input[wire\\:model^="newContribution"], textarea[wire\\:model^="newContribution"]');
            if (inputs.length === 0) return;

            // Store original values
            const originalValues = {};
            inputs.forEach(input => {
                originalValues[input.name || input.id] = input.value;
            });

            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const currentValue = this.value;
                    const originalValue = originalValues[input.name || input.id];

                    if (currentValue !== originalValue) {
                        showUnsavedIndicator('contributions');
                        showUnsavedWarning();
                        hasUnsavedChanges = true;
                    } else {
                        // Check if all other fields are also unchanged
                        const allUnchanged = Array.from(inputs).every(input => {
                            const current = input.value;
                            const original = originalValues[input.name || input.id];
                            return current === original;
                        });

                        if (allUnchanged) {
                            hideUnsavedIndicator('contributions');
                            hasUnsavedChanges = false;
                            hideUnsavedWarning();
                        }
                    }
                });
            });
        }

        // Show unsaved indicator for specific section
        function showUnsavedIndicator(section) {
            const indicator = document.getElementById(`${section}-unsaved-indicator`);
            if (indicator) {
                indicator.classList.remove('hidden');
            }
        }

        // Hide unsaved indicator for specific section
        function hideUnsavedIndicator(section) {
            const indicator = document.getElementById(`${section}-unsaved-indicator`);
            if (indicator) {
                indicator.classList.add('hidden');
            }
        }

        // Show unsaved warning
        function showUnsavedWarning() {
            const warning = document.getElementById('unsaved-changes-warning');
            if (warning) {
                warning.classList.remove('hidden');
            }
        }

        // Hide unsaved warning
        function hideUnsavedWarning() {
            const warning = document.getElementById('unsaved-changes-warning');
            if (warning) {
                warning.classList.add('hidden');
            }
        }

        // Global function to hide warning (accessible from onclick)
        window.hideUnsavedWarning = hideUnsavedWarning;

        // Initialize tracking for all sections
        trackProfileChanges();
        trackInterestsChanges();
        trackSkillsChanges();
        trackContributionsChanges();

        // Listen for Livewire events to reset indicators after successful save
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('profile-updated', () => {
                hideUnsavedIndicator('profile');
                hasUnsavedChanges = false;
                hideUnsavedWarning();
                // Reset original form data
                const form = document.querySelector(
                    'form[wire\\:submit="updateProfileInformation"]');
                if (form) {
                    const inputs = form.querySelectorAll('input, textarea');
                    inputs.forEach(input => {
                        originalFormData[input.name || input.id] = input.value;
                    });
                }
            });

            Livewire.on('interests-updated', () => {
                hideUnsavedIndicator('interests');
                hasUnsavedChanges = false;
                hideUnsavedWarning();
            });

            Livewire.on('skills-updated', () => {
                hideUnsavedIndicator('skills');
                hasUnsavedChanges = false;
                hideUnsavedWarning();
            });

            Livewire.on('contribution-added', () => {
                hideUnsavedIndicator('contributions');
                hasUnsavedChanges = false;
                hideUnsavedWarning();
                // Reset form fields
                const inputs = document.querySelectorAll(
                    'input[wire\\:model^="newContribution"], textarea[wire\\:model^="newContribution"]'
                );
                inputs.forEach(input => {
                    originalFormData[input.name || input.id] = input.value;
                });
            });
        });

        // Warn before leaving page if there are unsaved changes
        window.addEventListener('beforeunload', function(e) {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue =
                    'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman ini?';
                return 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman ini?';
            }
        });
    });
</script>
