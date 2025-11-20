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

                    <!-- Profile Photo Upload Section -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-900 dark:text-slate-100">Foto
                                Profil</label>
                            <div class="flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    @if($tempProfilePhoto)
                                        <div class="relative">
                                            <img src="{{ $tempProfilePhoto->temporaryUrl() }}" alt="Preview" 
                                                 class="w-24 h-24 rounded-full object-cover border-4 border-blue-200 dark:border-blue-800">
                                            <button type="button" wire:click="resetTempProfilePhoto"
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <x-ui.avatar :user="auth()->user()" size="xl" />
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <input type="file" wire:model="tempProfilePhoto" id="profilePhoto"
                                            accept="image/*"
                                            onchange="validateFileSize(this, 25, 'profilePhoto')"
                                            class="block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50">
                                        <button type="button" wire:click="updateProfilePhoto"
                                            wire:loading.attr="disabled"
                                            @if(!$this->canUploadProfilePhoto) disabled @endif
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
                                    @if($tempProfilePhoto)
                                        @if($this->canUploadProfilePhoto)
                                            <p class="mt-2 text-sm text-green-600 dark:text-green-400">
                                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                File siap diupload
                                            </p>
                                        @else
                                            <p class="mt-2 text-sm text-amber-600 dark:text-amber-400">
                                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                </svg>
                                                Simpan perubahan data terlebih dahulu
                                            </p>
                                        @endif
                                    @endif
                                    <p class="mt-2 text-sm text-gray-500 dark:text-slate-400">Format: JPG, PNG,
                                        GIF. Maksimal 25MB.</p>
                                    <div id="profilePhoto-error" class="hidden mt-2 text-sm text-red-600 dark:text-red-400"></div>
                                    @error('profilePhoto')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Banner Upload Section -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="space-y-4">
                            <label
                                class="block text-sm font-medium text-gray-900 dark:text-slate-100">Banner</label>
                            <div class="space-y-4">
                                @if($tempBanner)
                                    <div class="relative">
                                        <img src="{{ $tempBanner->temporaryUrl() }}" alt="Banner Preview" 
                                             class="w-full h-32 object-cover rounded-lg border-4 border-blue-200 dark:border-blue-800">
                                        <button type="button" wire:click="resetTempBanner"
                                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @else
                                    <x-ui.banner :user="auth()->user()" height="h-32" />
                                @endif
                                <div class="flex items-center space-x-3">
                                    <input type="file" wire:model="tempBanner" id="banner" accept="image/*"
                                        onchange="validateFileSize(this, 25, 'banner')"
                                        class="block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50">
                                    <button type="button" wire:click="updateBanner" wire:loading.attr="disabled"
                                        @if(!$this->canUploadBanner) disabled @endif
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
                                @if($tempBanner)
                                    @if($this->canUploadBanner)
                                        <p class="text-sm text-green-600 dark:text-green-400">
                                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            File siap diupload
                                        </p>
                                    @else
                                        <p class="text-sm text-amber-600 dark:text-amber-400">
                                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            Simpan perubahan data terlebih dahulu
                                        </p>
                                    @endif
                                @endif
                                <p class="text-sm text-gray-500 dark:text-slate-400">Format: JPG, PNG, GIF.
                                    Maksimal 25MB.</p>
                                <div id="banner-error" class="hidden mt-2 text-sm text-red-600 dark:text-red-400"></div>
                                @error('banner')
                                    <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="space-y-6">

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
                                            class="pl-12! pr-4 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6"
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
                                            class="pl-12! pr-4 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6"
                                            placeholder="Masukkan email Anda">
                                    </div>
                                    @error('email')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="gender"
                                        class="block text-sm font-medium text-gray-900 dark:text-slate-100">Jenis Kelamin</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400 dark:text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                        <select wire:model="gender" id="gender" required
                                            class="pl-12! pr-4 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 dark:bg-slate-800 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6">
                                            <option value="" class="text-gray-400 dark:text-slate-500 dark:bg-slate-800">Pilih jenis kelamin</option>
                                            <option value="laki-laki" class="dark:bg-slate-800 dark:text-slate-100">Laki-laki</option>
                                            <option value="perempuan" class="dark:bg-slate-800 dark:text-slate-100">Perempuan</option>
                                            <option value="non-biner" class="dark:bg-slate-800 dark:text-slate-100">Non-biner</option>
                                            <option value="yang_lainnya" class="dark:bg-slate-800 dark:text-slate-100">Lainnya</option>
                                            <option value="tidak_ingin_menyebutkan" class="dark:bg-slate-800 dark:text-slate-100">Tidak ingin menyebutkan</option>
                                        </select>
                                    </div>
                                    @error('gender')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="organization_type"
                                        class="block text-sm font-medium text-gray-900 dark:text-slate-100">Tipe Organisasi</label>
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
                                        <select wire:model.live="organization_type" id="organization_type" required
                                            class="pl-12! pr-4 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 dark:bg-slate-800 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6">
                                            <option value="" class="text-gray-400 dark:text-slate-500 dark:bg-slate-800">Pilih tipe organisasi</option>
                                            <option value="organisasi" class="dark:bg-slate-800 dark:text-slate-100">Organisasi</option>
                                            <option value="komunitas" class="dark:bg-slate-800 dark:text-slate-100">Komunitas</option>
                                            <option value="individu" class="dark:bg-slate-800 dark:text-slate-100">Individu</option>
                                        </select>
                                    </div>
                                    @error('organization_type')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="organization_name"
                                        class="block text-sm font-medium text-gray-900 dark:text-slate-100">Nama Organisasi/Komunitas</label>
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
                                        <input type="text" wire:model.live="organization_name" id="organization_name"
                                            :required="$organization_type === 'organisasi' || $organization_type === 'komunitas'"
                                            :disabled="!$organization_type"
                                            :readonly="$organization_type === 'individu'"
                                            :placeholder="$organization_type === 'individu' ? 'Individu' : ($organization_type ? 'Masukkan nama organisasi atau komunitas' : 'Pilih tipe organisasi terlebih dahulu')"
                                            class="pl-12! pr-4 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6">
                                    </div>
                                    @error('organization_name')
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
                                        <input type="tel" wire:model="phone_number" id="phone_number" required autocomplete="tel"
                                            class="pl-12! pr-4 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6"
                                            placeholder="Masukkan nomor telepon">
                                    </div>
                                    @error('phone_number')
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
                                            class="pl-12! pr-4 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6">
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
                                        class="pl-12! pr-4 block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 sm:text-sm sm:leading-6"
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
                                <div class="space-y-4">
                                    @foreach($socialMediaItems as $index => $item)
                                        <div class="social-media-item bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 p-4">
                                            <!-- Header -->
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 flex items-center justify-center">
                                                        {!! \App\Helpers\SocialLinkFormatter::getPlatformIcon($item['platform'] ?? '') !!}
                                            </div>
                                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                                        @php
                                                            $platforms = \App\Helpers\SocialLinkFormatter::getAvailablePlatforms();
                                                            $platformLabel = collect($platforms)->firstWhere('value', $item['platform'])['label'] ?? ucfirst($item['platform']);
                                                        @endphp
                                                        {{ $platformLabel }}
                                                    </span>
                                                </div>
                                                <button type="button" wire:click="removeSocialMedia({{ $index }})"
                                                        class="p-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                            </div>
                                            
                                            <!-- Input Fields -->
                                            <div class="space-y-4">
                                                <!-- Toggle Switch -->
                                                <div class="flex items-center justify-between">
                                                    <label class="flex items-center space-x-2 cursor-pointer">
                                                        <div class="relative">
                                                            <input type="checkbox" wire:click="toggleCustomLink({{ $index }})"
                                                                   @if($item['use_custom_link'] ?? false) checked @endif class="sr-only">
                                                            <div class="block w-10 h-5 rounded-full transition-colors duration-200 {{ ($item['use_custom_link'] ?? false) ? 'bg-blue-500' : 'bg-slate-300 dark:bg-slate-600' }}"></div>
                                                            <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition-transform duration-200 ease-in-out {{ ($item['use_custom_link'] ?? false) ? 'translate-x-5' : '' }}"></div>
                                                        </div>
                                                        <span class="text-sm text-slate-600 dark:text-slate-400">Gunakan Link</span>
                                                    </label>
                                                </div>
                                                
                                                <!-- Single Input Field - Saling Mengganti -->
                                                <div>
                                                    @if($item['use_custom_link'] ?? false)
                                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-2">Link</label>
                                                        <input type="text" wire:model="socialMediaItems.{{ $index }}.custom_link"
                                                               placeholder="{{ $this->getPlaceholderForPlatform($item['platform'] ?? '', true) }}"
                                                               class="w-full px-3 py-2 text-sm bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md text-slate-700 dark:text-slate-300 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('socialMediaItems.'.$index.'.custom_link') border-red-500 @enderror">
                                                        @error('socialMediaItems.'.$index.'.custom_link')
                                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                                        @enderror
                                                    @else
                                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-2">Username</label>
                                                        <input type="text" wire:model="socialMediaItems.{{ $index }}.username"
                                                               placeholder="{{ $this->getPlaceholderForPlatform($item['platform'] ?? '', false) }}"
                                                               class="w-full px-3 py-2 text-sm bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md text-slate-700 dark:text-slate-300 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('socialMediaItems.'.$index.'.username') border-red-500 @enderror">
                                                        @error('socialMediaItems.'.$index.'.username')
                                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                                        @enderror
                                                    @endif
                                                </div>
                                                
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                    
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
                                            class="add-social-media-btn mb-6 w-full flex items-center justify-center space-x-2 px-4 py-3 bg-slate-100 dark:bg-slate-800 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:border-slate-400 dark:hover:border-slate-500 transition-colors">
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

                            
            <p class="text-[12px] text-gray-600 dark:text-gray-400 border-t border-gray-700 p-6">
                Data pribadi yang dikumpulkan dalam aplikasi ini hanya akan digunakan untuk pendataan terkait kegiatan
                Pasar
                Kolaboraya dan keperluan internal Roemi. Data pribadi tidak akan digunakan untuk keperluan lainnya tanpa
                seizin pemilik data pribadi.
            </p>
                            <div class="flex items-center justify-between p-6 border-t border-gray-700">
                                <div class="flex items-center space-x-3">
                                    <button wire:click="updateProfileInformation"
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
                        </div>
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
                                    {{ count($selectedInterests) + count($customInterests) }}</div>
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
                                            {{ count($selectedInterests) ." + ". count($customInterests) }}</div>
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

                        <!-- Custom Interests Input -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-600">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-slate-300">Minat Kustom</h4>
                                <button type="button" wire:click="addCustomInterest"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 border border-purple-200 dark:border-purple-700 rounded-md hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Minat
                                </button>
                            </div>

                            @foreach ($customInterests as $index => $customInterest)
                                <div class="flex items-center space-x-3 mb-3 p-3 bg-gray-50 dark:bg-slate-800/50 rounded-lg border border-gray-200 dark:border-slate-700">
                                    <div class="flex-1">
                                        <input type="text" wire:model="customInterests.{{ $index }}.name"
                                            placeholder="Nama minat kustom"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-md focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-slate-300">
                                    </div>
                                    <div class="flex items-center">
                                        <button type="button" wire:click="removeCustomInterest({{ $index }})"
                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
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
                                {{ count($selectedSkills) + count($customSkills) }} dipilih
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

                        <!-- Custom Skills Input -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-600">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-slate-300">Keahlian Kustom</h4>
                                <button type="button" wire:click="addCustomSkill"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 border border-green-200 dark:border-green-700 rounded-md hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Keahlian
                                </button>
                            </div>

                            @foreach ($customSkills as $index => $customSkill)
                                <div class="flex items-center space-x-3 mb-3 p-3 bg-gray-50 dark:bg-slate-800/50 rounded-lg border border-gray-200 dark:border-slate-700">
                                    <div class="flex-1">
                                        <input type="text" wire:model="customSkills.{{ $index }}.name"
                                            placeholder="Nama keahlian kustom"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-md focus:ring-green-500 focus:border-green-500 dark:bg-slate-700 dark:text-slate-300">
                                    </div>
                                    <div class="flex items-center">
                                        <button type="button" wire:click="removeCustomSkill({{ $index }})"
                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
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
        let csrfTokenRefreshInterval;
        
        // CSRF Token Management
        function refreshCsrfToken() {
            fetch('/csrf-token-refresh', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    // Update CSRF token in meta tag
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
                    
                    // Update CSRF token in forms
                    document.querySelectorAll('input[name="_token"]').forEach(input => {
                        input.value = data.token;
                    });
                    
                    console.log('CSRF token refreshed successfully');
                }
            })
            .catch(error => {
                console.error('Failed to refresh CSRF token:', error);
            });
        }
        
        // Refresh CSRF token every 15 minutes
        csrfTokenRefreshInterval = setInterval(refreshCsrfToken, 60 * 60 * 1000);

        // Track form changes for profile section
        function trackProfileChanges() {
            const inputs = document.querySelectorAll('input[wire\\:model], textarea[wire\\:model], select[wire\\:model]');
            if (!inputs.length) return;

            // Store original values
            inputs.forEach(input => {
                originalFormData[input.name || input.id] = input.value;
            });

            // Listen for changes
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const currentValue = this.value;
                    const originalValue = originalFormData[this.name || this.id];

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
                const inputs = document.querySelectorAll('input[wire\\:model], textarea[wire\\:model], select[wire\\:model]');
                inputs.forEach(input => {
                    originalFormData[input.name || input.id] = input.value;
                });
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
        
        // Handle Livewire errors
        document.addEventListener('livewire:init', () => {
            Livewire.on('profile-updated', () => {
                hasUnsavedChanges = false;
                hideUnsavedWarning();
            });
            
            // Listen for validation errors
            Livewire.on('validation-error', (error) => {
                console.error('Validation error:', error);
                // Show user-friendly error message
                if (error.message) {
                    showErrorNotification(error.message);
                }
            });
        });
        
        // Clean up interval when page unloads
        window.addEventListener('beforeunload', function() {
            if (csrfTokenRefreshInterval) {
                clearInterval(csrfTokenRefreshInterval);
            }
        });
    });
    
    // Helper function to show error notifications
    function showErrorNotification(message) {
        // Create error notification element
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg';
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-red-500 hover:text-red-700">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    // File size validation function
    function validateFileSize(input, maxSizeMB, fieldName) {
        const file = input.files[0];
        const errorElement = document.getElementById(fieldName + '-error');
        const uploadButton = input.parentElement.querySelector('button[type="submit"]');
        
        // Clear previous errors
        if (errorElement) {
            errorElement.classList.add('hidden');
            errorElement.textContent = '';
        }
        
        if (file) {
            const fileSizeMB = file.size / (1024 * 1024);
            
            if (fileSizeMB > maxSizeMB) {
                // Show error
                if (errorElement) {
                    errorElement.classList.remove('hidden');
                    errorElement.textContent = `Ukuran file terlalu besar. Maksimal ${maxSizeMB}MB. File Anda: ${fileSizeMB.toFixed(2)}MB`;
                }
                
                // Disable upload button
                if (uploadButton) {
                    uploadButton.disabled = true;
                    uploadButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
                
                // Clear the input
                input.value = '';
                return false;
            } else {
                // Enable upload button
                if (uploadButton) {
                    uploadButton.disabled = false;
                    uploadButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }
        
        return true;
    }

    // Clear form after successful upload
    document.addEventListener('livewire:init', () => {
        Livewire.on('profile-updated', () => {
            // Clear file inputs after successful upload
            const profilePhotoInput = document.getElementById('profilePhoto');
            const bannerInput = document.getElementById('banner');
            
            if (profilePhotoInput) {
                profilePhotoInput.value = '';
                const profilePhotoError = document.getElementById('profilePhoto-error');
                if (profilePhotoError) {
                    profilePhotoError.classList.add('hidden');
                    profilePhotoError.textContent = '';
                }
            }
            
            if (bannerInput) {
                bannerInput.value = '';
                const bannerError = document.getElementById('banner-error');
                if (bannerError) {
                    bannerError.classList.add('hidden');
                    bannerError.textContent = '';
                }
            }
        });
    });
</script>
