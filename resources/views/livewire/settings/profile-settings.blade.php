<div class="max-w-7xl mx-auto">
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Hero Header -->
    <div
        class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl shadow-2xl mb-8">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative p-8 sm:p-12 text-white">
            <div class="max-w-3xl">
                <h1 class="text-3xl sm:text-4xl font-bold mb-4">Pengaturan Profil</h1>
                <p class="text-lg text-blue-100 leading-relaxed">Kelola informasi profil, minat, keahlian, dan
                    kontribusi Anda untuk terhubung dengan kreator yang memiliki passion serupa.</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <div class="sticky top-16">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Pengaturan</h3>
                    <nav class="space-y-2">
                        <button wire:click="setTab('profile')"
                            class="flex items-center px-4 w-full py-3 text-sm font-medium rounded-xl 
                            @if ($tab === 'profile') bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 border border-blue-200 shadow-sm 
                            @else text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-700 hover:border hover:border-blue-200 transition-all duration-200 @endif">
                            <div class="h-8 w-8 rounded-lg @if($tab === 'profile') bg-blue-100 @else bg-gray-100 @endif flex items-center justify-center mr-3">
                                <svg class="h-4 w-4  @if ($tab === 'profile') text-blue-600 @else text-gray-600 @endif group-hover:text-blue-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            Informasi Profil
                        </button>
                        <button wire:click="setTab('interests')"
                            class="flex items-center px-4 w-full py-3 text-sm text-left font-medium rounded-xl 
                            @if ($tab === 'interests') bg-gradient-to-r from-purple-50 to-pink-50 text-purple-700 border border-purple-200 shadow-sm 
                            @else text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 hover:border hover:border-purple-200 transition-all duration-200 @endif">
                            <div
                                class="h-8 w-8 rounded-lg @if($tab === 'interests') bg-purple-100 @else bg-gray-100 @endif flex items-center justify-center mr-3 group-hover:bg-purple-100">
                                <svg class="h-4 w-4 @if($tab === 'interests') text-purple-600 @else text-gray-600 @endif group-hover:text-purple-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </div>
                            Minat & Ketertarikan
                        </button>
                        <button wire:click="setTab('skills')"
                            class="flex items-center px-4 w-full py-3 text-sm font-medium rounded-xl @if($tab === 'skills') bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 border border-green-200 shadow-sm @else text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700 hover:border hover:border-green-200 transition-all duration-200 @endif">
                            <div
                                class="h-8 w-8 rounded-lg @if($tab === 'skills') bg-green-100 @else bg-gray-100 @endif flex items-center justify-center mr-3 group-hover:bg-green-100">
                                <svg class="h-4 w-4 @if($tab === 'skills') text-green-600 @else text-gray-600 @endif group-hover:text-green-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                    </path>
                                </svg>
                            </div>
                            Keahlian
                        </button>
                        <button wire:click="setTab('contributions')"
                            class="flex items-center px-4 w-full py-3 text-sm font-medium rounded-xl @if($tab === 'contributions') bg-gradient-to-r from-amber-50 to-orange-50 text-amber-700 border border-amber-200 shadow-sm @else text-gray-700 hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 hover:text-amber-700 hover:border hover:border-amber-200 transition-all duration-200 @endif">
                            <div
                                class="h-8 w-8 rounded-lg @if($tab === 'contributions') bg-amber-100 @else bg-gray-100 @endif flex items-center justify-center mr-3 group-hover:bg-amber-100">
                                <svg class="h-4 w-4 @if($tab === 'contributions') text-amber-600 @else text-gray-600 @endif group-hover:text-amber-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            Kontribusi
                        </button>
                        <button wire:click="setTab('danger')"
                            class="flex items-center px-4 w-full py-3 text-sm font-medium rounded-xl @if($tab === 'danger') bg-gradient-to-r from-red-50 to-pink-50 text-red-700 border border-red-200 shadow-sm @else text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:text-red-700 hover:border hover:border-red-200 transition-all duration-200 @endif">
                            <div class="h-8 w-8 rounded-lg @if($tab === 'danger') bg-red-100 @else bg-gray-100 @endif flex items-center justify-center mr-3">
                                <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
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
                <div id="profile-info" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Informasi Profil</h3>
                                    <p class="text-sm text-gray-600">Update informasi profil dan alamat email Anda.</p>
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800 ring-1 ring-inset ring-blue-200">Required</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <form wire:submit="updateProfileInformation" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="name" class="block text-sm font-medium text-gray-900">Nama
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
                                            class="pl-12 block w-full rounded-xl border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 sm:text-sm sm:leading-6"
                                            placeholder="Masukkan nama lengkap Anda">
                                    </div>
                                    @error('name')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-900">Email</label>
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
                                            class="pl-12 block w-full rounded-xl border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 sm:text-sm sm:leading-6"
                                            placeholder="Masukkan email Anda">
                                    </div>
                                    @error('email')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="organization"
                                        class="block text-sm font-medium text-gray-900">Organisasi</label>
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
                                            class="pl-12 block w-full rounded-xl border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 sm:text-sm sm:leading-6"
                                            placeholder="Nama organisasi atau perusahaan">
                                    </div>
                                    @error('organization')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="phone" class="block text-sm font-medium text-gray-900">Nomor
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
                                            class="pl-12 block w-full rounded-xl border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 sm:text-sm sm:leading-6"
                                            placeholder="Nomor telepon (opsional)">
                                    </div>
                                    @error('phone')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="vision" class="block text-sm font-medium text-gray-900">Visi &
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
                                        class="pl-12 block w-full rounded-xl border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 sm:text-sm sm:leading-6"
                                        placeholder="Ceritakan visi dan misi Anda dalam berkarya..."></textarea>
                                </div>
                                @error('vision')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                                <div class="rounded-xl bg-amber-50 border border-amber-200 p-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-amber-800">
                                                {{ __('Your email address is unverified.') }}
                                                <button type="button"
                                                    wire:click.prevent="resendVerificationNotification"
                                                    class="text-amber-700 hover:text-amber-600 text-sm font-medium underline">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 text-sm font-medium text-emerald-600">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Perubahan
                                </button>

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
                <!-- Interests Section -->
                <div id="interests" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-purple-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Minat & Ketertarikan</h3>
                                <p class="text-sm text-gray-600">Pilih minat dan ketertarikan Anda untuk terhubung
                                    dengan
                                    kreator yang memiliki minat serupa.</p>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                {{ count($selectedInterests) }} selected
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($interests as $interest)
                                <label
                                    class="group relative flex items-start p-5 cursor-pointer bg-white hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 rounded-xl transition-all duration-200 ring-1 ring-gray-200 hover:ring-purple-300 hover:shadow-md transform hover:-translate-y-1">
                                    <div class="min-w-0 flex flex-col flex-1">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="relative flex items-center">
                                                    <input type="checkbox" wire:model.live="selectedInterests"
                                                        value="{{ $interest->id }}"
                                                        class="peer h-5 w-5 text-purple-600 border-gray-300 rounded-lg focus:ring-purple-500 focus:ring-2">
                                                    <div
                                                        class="pointer-events-none absolute top-5 left-5 transform -translate-y-1/2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                                        <svg class="h-3.5 w-3.5 text-purple-600" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <span
                                                    class="ml-3 text-sm font-semibold text-gray-900 group-hover:text-purple-700">{{ $interest->name }}</span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <span
                                                    class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-200 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    {{ rand(10, 50) }} kreator
                                                </span>
                                            </div>
                                        </div>
                                        @if ($interest->description)
                                            <p class="mt-2 text-xs text-gray-600 ml-8 leading-relaxed">
                                                {{ $interest->description }}</p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div class="mt-6 flex items-center justify-between pt-6 border-t border-gray-200">
                            <button wire:click="updateInterests"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl shadow-sm text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-105">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Perubahan
                            </button>

                            <x-action-message class="mr-3" on="interests-updated">
                                <span
                                    class="inline-flex items-center rounded-xl bg-green-50 px-3 py-2 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                    <svg class="mr-2 h-4 w-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('Saved successfully!') }}
                                </span>
                            </x-action-message>
                        </div>
                    </div>
                </div>
            @elseif ($tab === 'skills')
                <!-- Skills Section -->
                <div id="skills" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Keahlian</h3>
                                <p class="text-sm text-gray-600">Pilih keahlian yang Anda miliki untuk memudahkan
                                    kolaborasi dengan kreator lain.</p>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                {{ count($selectedSkills) }} selected
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($skills as $skill)
                                <label
                                    class="group relative flex items-start p-5 cursor-pointer bg-white hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 rounded-xl transition-all duration-200 ring-1 ring-gray-200 hover:ring-green-300 hover:shadow-md transform hover:-translate-y-1">
                                    <div class="min-w-0 flex flex-col flex-1">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="relative flex items-center">
                                                    <input type="checkbox" wire:model.live="selectedSkills"
                                                        value="{{ $skill->id }}"
                                                        class="peer h-5 w-5 text-green-600 border-gray-300 rounded-lg focus:ring-green-500 focus:ring-2">
                                                    <div
                                                        class="pointer-events-none absolute top-5 left-5 transform -translate-y-1/2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                                        <svg class="h-3.5 w-3.5 text-green-600" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <span
                                                    class="ml-3 text-sm font-semibold text-gray-900 group-hover:text-green-700">{{ $skill->name }}</span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <span
                                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-200 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    {{ rand(5, 30) }} kreator
                                                </span>
                                            </div>
                                        </div>
                                        @if ($skill->description)
                                            <p class="mt-2 text-xs text-gray-600 ml-8 leading-relaxed">
                                                {{ $skill->description }}</p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div class="mt-6 flex items-center justify-between pt-6 border-t border-gray-200">
                            <button wire:click="updateSkills"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl shadow-sm text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Perubahan
                            </button>

                            <x-action-message class="mr-3" on="skills-updated">
                                <span
                                    class="inline-flex items-center rounded-xl bg-green-50 px-3 py-2 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                    <svg class="mr-2 h-4 w-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
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
                <div id="contributions" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-amber-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Kontribusi</h3>
                                <p class="text-sm text-gray-600">Tambahkan kontribusi yang telah Anda berikan untuk
                                    menginspirasi kreator lain.</p>
                            </div>
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-amber-700 bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 border border-amber-200 hover:border-amber-300">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Baru
                            </button>
                        </div>
                    </div>

                    {{-- Add New Contribution Form --}}
                    <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-base font-medium text-gray-900">Tambah Kontribusi Baru</h4>
                            <span
                                class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Optional</span>
                        </div>
                        <div class="grid gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Jenis Kontribusi</label>
                                <div class="relative">
                                    <select wire:model="newContribution.contribution_id"
                                        class="block w-full rounded-lg border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                                        <option value="">Pilih jenis kontribusi</option>
                                        @foreach ($contributions as $contribution)
                                            <option value="{{ $contribution->id }}">{{ $contribution->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Deskripsi</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <textarea wire:model="newContribution.description" rows="3"
                                        class="block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                        placeholder="Jelaskan kontribusi Anda..."></textarea>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Tanggal</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <input type="date" wire:model="newContribution.date"
                                        class="block w-full rounded-lg border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                <button wire:click="addContribution"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl shadow-sm text-white bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 transform hover:scale-105">
                                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Kontribusi
                                </button>

                                <x-action-message class="mr-3" on="contribution-added">
                                    <span
                                        class="inline-flex items-center rounded-xl bg-green-50 px-3 py-2 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                        <svg class="mr-2 h-4 w-4 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ __('Added successfully!') }}
                                    </span>
                                </x-action-message>
                            </div>
                        </div>
                    </div>

                    {{-- Existing Contributions List --}}
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @foreach ($userContributions as $contribution)
                                <li>
                                    <div class="relative pb-8">
                                        @if (!$loop->last)
                                            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"
                                                aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex items-start space-x-3">
                                            <div class="relative">
                                                <span
                                                    class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-5 w-5 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $contribution->name }}</div>
                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{ $contribution->pivot->description }}</p>
                                                <div class="mt-2 flex items-center space-x-4">
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                        {{ \Carbon\Carbon::parse($contribution->pivot->date)->format('d M Y') }}
                                                    </div>
                                                    <button wire:click="removeContribution({{ $contribution->id }})"
                                                        class="inline-flex items-center text-sm text-red-600 hover:text-red-900">
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
                <div id="danger" class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 px-6 py-4 border-b border-red-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-xl bg-red-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-red-600">Danger Zone</h3>
                                    <p class="text-sm text-gray-600">Tindakan ini tidak dapat dibatalkan. Harap
                                        berhati-hati.</p>
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800 ring-1 ring-inset ring-red-200">Danger</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="rounded-xl bg-gradient-to-r from-red-50 to-pink-50 p-6 border border-red-200">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                                        <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-red-800 mb-3">Hapus Akun Permanen</h3>
                                    <div class="text-sm text-red-700 space-y-3">
                                        <p class="font-medium">Setelah akun Anda dihapus:</p>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            <div class="flex items-center space-x-2">
                                                <svg class="h-4 w-4 text-red-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span>Semua data profil Anda akan dihapus</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="h-4 w-4 text-red-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span>Kontribusi dan kolaborasi Anda akan dihapus</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="h-4 w-4 text-red-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span>Koneksi dengan kreator lain akan terputus</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="h-4 w-4 text-red-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span>Tindakan ini tidak dapat dibatalkan</span>
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
