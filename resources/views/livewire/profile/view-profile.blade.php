<div class="w-full bg-white dark:bg-slate-900 relative min-h-screen">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-20 h-20" opacity="opacity-10 dark:opacity-5" />
    <x-svg-accent position="center-right" size="w-16 h-16" opacity="opacity-10 dark:opacity-5" />
    <x-svg-accent position="bottom-left" size="w-14 h-14" opacity="opacity-10 dark:opacity-5" />

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 z-50">
            <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3"
                    onclick="this.parentElement.remove()">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 0 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 0 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 z-50">
            <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3"
                    onclick="this.parentElement.remove()">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 0 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 0 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <div class="relative">
        <!-- Cover Image -->
        <x-ui.banner :user="$user" height="h-40" />

        <!-- Profile Info -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
            <div class="relative -mt-32 pb-8">
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <!-- Profile Image -->
                    <div class="relative flex-shrink-0 mx-auto sm:mx-0">
                        <div
                            class="h-32 w-32 sm:h-40 sm:w-40 lg:h-48 lg:w-48 rounded-xl bg-white dark:bg-slate-800 shadow-xl dark:shadow-slate-900/50 overflow-hidden">
                            @if ($user->profile?->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile->profile_photo) }}"
                                    alt="{{ $user->name }}'s profile photo" class="h-full w-full object-cover">
                            @else
                                <div
                                    class="h-full w-full bg-gradient-to-br from-blue-400 to-indigo-500 dark:from-blue-500 dark:to-indigo-600 flex items-center justify-center">
                                    <span class="text-white text-3xl sm:text-4xl lg:text-6xl font-bold">
                                        {{ $user->initials() }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="absolute -bottom-2 -right-2">
                            <span class="relative flex h-5 w-5">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 dark:bg-emerald-500 opacity-75"></span>
                                <span
                                    class="relative inline-flex rounded-full h-5 w-5 bg-emerald-500 dark:bg-emerald-600 ring-2 ring-white dark:ring-slate-800"></span>
                            </span>
                        </div>
                    </div>

                    <!-- Profile Details -->
                    <div class="flex-1 min-w-0 w-full sm:w-auto">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="text-center sm:text-left">
                                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-slate-100">
                                    {{ $user->name }}</h1>
                                <p class="text-gray-500 dark:text-slate-400 text-sm sm:text-base">{{ $user->email }}
                                </p>
                                @if ($profile?->organization)
                                    <div
                                        class="flex items-center justify-center sm:justify-start mt-2 text-gray-600 dark:text-slate-400">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        <span class="text-sm sm:text-base">{{ $profile->organization }}</span>
                                    </div>
                                @endif
                                @if ($profile?->phone)
                                    <div
                                        class="flex items-center justify-center sm:justify-start mt-2 text-gray-600 dark:text-slate-400">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        <span class="text-sm sm:text-base">{{ $profile->phone }}</span>
                                    </div>
                                @endif
                                @if ($user->is_ecosystem_builder)
                                    <div
                                        class="flex items-center justify-center sm:justify-start mt-2 bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span class="text-sm sm:text-base">Ekosistem Builder</span>
                                    </div>
                                @elseif ($user->assigned_role)
                                    <div
                                        class="flex items-center justify-center sm:justify-start mt-2 bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span class="text-sm sm:text-base">{{ $user->assigned_role }}</span>
                                    </div>
                                @else
                                    <div
                                        class="flex items-center justify-center sm:justify-start mt-2 bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span class="text-sm sm:text-base">Belum Dipilih</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex justify-center sm:justify-end">
                                @if (auth()->id() === $user->id)
                                    <a href="{{ route('settings.profile-settings') }}"
                                        class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 dark:border-slate-600 shadow-sm text-xs sm:text-sm font-medium rounded-md text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                        <svg class="-ml-1 mr-1 sm:mr-2 h-4 w-4 sm:h-5 sm:w-5 text-gray-400 dark:text-slate-500"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        <span class="hidden sm:inline">Edit Profile</span>
                                        <span class="sm:hidden">Edit</span>
                                    </a>
                                    {{-- @else
                                    <!-- Action Buttons Section -->
                                    @if (auth()->id() !== $user->id)
                                        @php
                                            $connectionsEnabled = \App\Models\SystemSetting::isConnectionsEnabled();
                                            $ecosystemsEnabled = \App\Models\SystemSetting::isEcosystemsEnabled();
                                            $collectiveActionsEnabled = \App\Models\SystemSetting::isCollectiveActionsEnabled();
                                            $isSuperAdmin = auth()->user()->isSuperAdmin();
                                            $connectionStatus = auth()->user()->getConnectionStatus($user->id);
                                        @endphp

                                        @if (!$connectionsEnabled && !$isSuperAdmin)
                                            <!-- Feature Disabled Message -->
                                            <div class="flex-1 py-3 px-4 bg-gray-400 dark:bg-slate-600 text-white dark:text-slate-300 text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                </svg>
                                                Fitur Koneksi Dinonaktifkan
                                            </div>
                                        @else
                                            <!-- Connection Status & Actions -->
                                            @if ($connectionStatus === 'not_connected')
                                                <button wire:click="connect({{ $user->id }})"
                                                    class="flex-1 py-3 px-4 bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Tambah Koneksi
                                                </button>
                                            @elseif($connectionStatus === 'pending_sent')
                                                <button disabled
                                                    class="flex-1 py-3 px-4 bg-gray-400 dark:bg-slate-600 text-white dark:text-slate-300 text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Menunggu Konfirmasi
                                                </button>
                                            @elseif($connectionStatus === 'pending_received')
                                                <div class="flex flex-col sm:flex-row gap-2 w-full">
                                                    <button wire:click="acceptConnection({{ $user->id }})"
                                                        class="flex-1 py-3 px-4 bg-green-600 dark:bg-green-700 hover:bg-green-700 dark:hover:bg-green-800 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Terima Permintaan
                                                    </button>
                                                    <button wire:click="rejectConnection({{ $user->id }})"
                                                        class="flex-1 py-3 px-4 bg-red-600 dark:bg-red-700 hover:bg-red-700 dark:hover:bg-red-800 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        Tolak Permintaan
                                                    </button>
                                                </div>
                                            @elseif($connectionStatus === 'connected')
                                                <div class="flex flex-col sm:flex-row gap-2 w-full">
                                                    @if ($ecosystemsEnabled || $isSuperAdmin)
                                                        <button wire:click="startEcosystem({{ $user->id }})"
                                                            class="flex-1 py-3 px-4 bg-green-600 dark:bg-green-700 hover:bg-green-700 dark:hover:bg-green-800 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                                </path>
                                                            </svg>
                                                            Mulai Ekosistem
                                                        </button>
                                                    @else
                                                        <button disabled
                                                            class="flex-1 py-3 px-4 bg-gray-400 dark:bg-slate-600 text-white dark:text-slate-300 text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                            </svg>
                                                            Ekosistem Dinonaktifkan
                                                        </button>
                                                    @endif
                                                    <button wire:click="disconnect({{ $user->id }})"
                                                        class="flex-1 py-3 px-4 bg-red-600 dark:bg-red-700 hover:bg-red-700 dark:hover:bg-red-800 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        Putuskan Koneksi
                                                    </button>
                                                </div>
                                            @endif
                                        @endif
                                    @endif --}}
                                @endif
                                {{-- <button type="button"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Share
                                </button> --}}
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        @if ($profile?->social_media)
                            @php
                                $nonEmptyLinks = collect($profile->social_media ?? [])->filter(function ($u) {
                                    return !empty($u);
                                });
                            @endphp
                            <div class="mt-4 flex flex-wrap justify-center sm:justify-start gap-2 sm:gap-3">
                                @forelse ($profile->social_media as $platform => $url)
                                    @if (!empty($url))
                                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center px-2 py-1.5 sm:px-3 sm:py-1.5 rounded-lg text-xs sm:text-sm font-medium bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                                            @switch(strtolower($platform))
                                                @case('linkedin')
                                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-1.5 text-blue-600"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                                    </svg>
                                                @break

                                                @case('twitter')
                                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-1.5 text-blue-400"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                                    </svg>
                                                @break

                                                @case('github')
                                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-1.5 text-gray-900 dark:text-slate-300"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                                    </svg>
                                                @break

                                                @default
                                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-1.5 text-gray-500 dark:text-slate-400"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                    </svg>
                                            @endswitch
                                            <span class="hidden sm:inline">{{ ucfirst($platform) }}</span>
                                            <span class="sm:hidden">{{ ucfirst(substr($platform, 0, 3)) }}</span>
                                        </a>
                                    @endif
                                    @empty
                                        <span
                                            class="text-xs sm:text-sm text-gray-500 dark:text-slate-400 text-center w-full">Belum
                                            menambahkan tautan
                                            sosial</span>
                                    @endforelse
                                </div>
                            @else
                                <div class="mt-4 text-center sm:text-left">
                                    <span class="text-xs sm:text-sm text-gray-500 dark:text-slate-400">Belum menambahkan
                                        tautan
                                        sosial</span>
                                </div>
                            @endif



                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900">
                <nav class="-mb-px flex overflow-x-auto scrollbar-hide" aria-label="Tabs">
                    <!-- Profile Tab -->
                    <button onclick="showTab('profile')"
                        class="tab-button border-purple-500 text-purple-600 dark:text-purple-400 dark:border-purple-400 whitespace-nowrap py-3 sm:py-4 px-2 sm:px-4 border-b-2 font-medium text-xs sm:text-sm flex items-center min-w-0 flex-shrink-0"
                        data-tab="profile">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="hidden sm:inline">Profil</span>
                        <span class="sm:hidden">Profil</span>
                    </button>

                    <!-- Ecosystems Tab -->
                    <button onclick="showTab('ecosystems')"
                        class="tab-button border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600 whitespace-nowrap py-3 sm:py-4 px-2 sm:px-4 border-b-2 font-medium text-xs sm:text-sm flex items-center transition-colors duration-200 min-w-0 flex-shrink-0"
                        data-tab="ecosystems">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                        <span class="hidden sm:inline">Ekosistem</span>
                        <span class="sm:hidden">Eko</span>
                    </button>

                    <!-- Collective Actions Tab -->
                    <button onclick="showTab('collective-actions')"
                        class="tab-button border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600 whitespace-nowrap py-3 sm:py-4 px-2 sm:px-4 border-b-2 font-medium text-xs sm:text-sm flex items-center transition-colors duration-200 min-w-0 flex-shrink-0"
                        data-tab="collective-actions">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="hidden sm:inline">Aksi Kolektif</span>
                        <span class="sm:hidden">Aksi</span>
                    </button>

                    <!-- Connections Tab -->
                    <button onclick="showTab('connections')"
                        class="tab-button border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600 whitespace-nowrap py-3 sm:py-4 px-2 sm:px-4 border-b-2 font-medium text-xs sm:text-sm flex items-center transition-colors duration-200 min-w-0 flex-shrink-0"
                        data-tab="connections">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                            </path>
                        </svg>
                        <span class="hidden sm:inline">Koneksi</span>
                        <span class="sm:hidden">Koneksi</span>
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab Contents -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 lg:pb-8">

            <!-- Profile Tab Content -->
            <div id="profile-content" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 py-6 lg:py-8">
                    <!-- Skills & Interests -->
                    <div class="lg:col-span-1 space-y-6 lg:space-y-8">
                        <!-- Skills Section -->
                        <div class="group relative">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-[#379eff]/50 to-blue-500/50 rounded-xl opacity-50 group-hover:opacity-75 blur transition duration-1000 group-hover:duration-200">
                            </div>
                            <div
                                class="relative bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-slate-900/50 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-5 w-5 text-[#379eff]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Keahlian
                                            </h3>
                                        </div>
                                        @if ($profile?->skills)
                                            <span
                                                class="inline-flex items-center rounded-full bg-[#379eff]/10 dark:bg-[#379eff]/20 px-2.5 py-1 text-xs font-medium text-[#379eff] dark:text-[#379eff]">
                                                {{ $profile->skills->count() }} skills
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse ($profile?->skills ?? [] as $skill)
                                            @if ($skill && $skill->name)
                                                <span
                                                    class="group/item inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-[#379eff]/5 dark:bg-[#379eff]/20 text-[#379eff] dark:text-[#379eff] ring-1 ring-inset ring-[#379eff]/10 dark:ring-[#379eff]/20 transition-all duration-200 hover:bg-[#379eff]/10 dark:hover:bg-[#379eff]/30">{{ $skill->name }}</span>
                                            @endif
                                        @empty
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Belum menambahkan
                                                keahlian</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Interests Section -->
                        <div class="group relative">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500/50 to-green-500/50 rounded-xl opacity-50 group-hover:opacity-75 blur transition duration-1000 group-hover:duration-200">
                            </div>
                            <div
                                class="relative bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-slate-900/50 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Minat &
                                                Ketertarikan</h3>
                                        </div>
                                        @if ($profile?->interests)
                                            <span
                                                class="inline-flex items-center rounded-full bg-emerald-50 dark:bg-emerald-900/30 px-2.5 py-1 text-xs font-medium text-emerald-700 dark:text-emerald-300">
                                                {{ $profile->interests->count() }} interests
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse ($profile?->interests ?? [] as $interest)
                                            @if ($interest && $interest->name)
                                                <span
                                                    class="group/item inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 ring-1 ring-inset ring-emerald-600/20 dark:ring-emerald-600/30 transition-all duration-200 hover:bg-emerald-100 dark:hover:bg-emerald-900/50">{{ $interest->name }}</span>
                                            @endif
                                        @empty
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Belum menambahkan
                                                minat</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Interests Section -->
                    </div>

                    <!-- Contributions Timeline -->
                    <div class="lg:col-span-2">
                        <div class="group relative">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-[#379eff]/50 to-blue-500/50 rounded-xl opacity-50 group-hover:opacity-75 blur transition duration-1000 group-hover:duration-200">
                            </div>
                            <div
                                class="relative bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-slate-900/50 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center gap-2 w-min">
                                            <svg class="h-5 w-5 text-[#379eff]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Kontribusi
                                                & Pencapaian</h3>
                                        </div>
                                        @php
                                            $totalContributions =
                                                \App\Models\EcosystemContribution::where('user_id', $user->id)
                                                    ->whereIn('status', ['accepted', 'completed'])
                                                    ->count() +
                                                \App\Models\CollectiveActionContribution::where('user_id', $user->id)
                                                    ->whereIn('status', ['accepted', 'completed'])
                                                    ->count();
                                        @endphp
                                        @if ($totalContributions > 0)
                                            <span
                                                class="inline-flex items-center rounded-full w-fit bg-[#379eff]/10 dark:bg-[#379eff]/20 px-2.5 py-1 text-xs font-medium text-[#379eff] dark:text-[#379eff]">
                                                {{ $totalContributions }}
                                                contributions
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flow-root">
                                        <ul role="list" class="-mb-8">
                                            @php
                                                // Get ecosystem contributions
                                                $ecosystemContributions = \App\Models\EcosystemContribution::where(
                                                    'user_id',
                                                    $user->id,
                                                )
                                                    ->whereIn('status', ['accepted', 'completed'])
                                                    ->with(['ecosystem', 'contribution'])
                                                    ->orderBy('accepted_at', 'desc')
                                                    ->get();

                                                // Get collective action contributions
                                                $collectiveActionContributions = \App\Models\CollectiveActionContribution::where(
                                                    'user_id',
                                                    $user->id,
                                                )
                                                    ->whereIn('status', ['accepted', 'completed'])
                                                    ->with(['collectiveAction', 'contribution'])
                                                    ->orderBy('accepted_at', 'desc')
                                                    ->get();

                                                // Combine and sort all contributions
                                                $allContributions = collect()
                                                    ->merge(
                                                        $ecosystemContributions->map(function ($contrib) {
                                                            return (object) [
                                                                'type' => 'ecosystem',
                                                                'title' =>
                                                                    $contrib->ecosystem->ecosystem_title ?? 'Ekosistem',
                                                                'description' => $contrib->contribution_description,
                                                                'contribution_type' =>
                                                                    $contrib->contribution->name ?? 'Kontribusi',
                                                                'date' => $contrib->accepted_at,
                                                                'status' => $contrib->status,
                                                            ];
                                                        }),
                                                    )
                                                    ->merge(
                                                        $collectiveActionContributions->map(function ($contrib) {
                                                            return (object) [
                                                                'type' => 'collective_action',
                                                                'title' =>
                                                                    $contrib->collectiveAction->title ??
                                                                    'Aksi Kolektif',
                                                                'description' => $contrib->contribution_description,
                                                                'contribution_type' =>
                                                                    $contrib->contribution->name ?? 'Kontribusi',
                                                                'date' => $contrib->accepted_at,
                                                                'status' => $contrib->status,
                                                            ];
                                                        }),
                                                    )
                                                    ->sortByDesc('date')
                                                    ->take(10); // Limit to 10 most recent
                                            @endphp

                                            @forelse ($allContributions as $contribution)
                                                <li>
                                                    <div class="relative pb-8">
                                                        @if (!$loop->last)
                                                            <span
                                                                class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-[#379eff]/20"
                                                                aria-hidden="true"></span>
                                                        @endif
                                                        <div class="relative flex space-x-3">
                                                            <div>
                                                                <span
                                                                    class="h-8 w-8 rounded-full bg-[#379eff]/10 dark:bg-[#379eff]/20 flex items-center justify-center ring-8 ring-white dark:ring-slate-800">
                                                                    @if ($contribution->type === 'ecosystem')
                                                                        <svg class="h-4 w-4 text-[#379eff]" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                                            </path>
                                                                        </svg>
                                                                    @else
                                                                        <svg class="h-4 w-4 text-[#379eff]" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z">
                                                                            </path>
                                                                        </svg>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="min-w-0 flex-1">
                                                                <div
                                                                    class="text-sm font-medium text-gray-900 dark:text-slate-100">
                                                                    {{ $contribution->title }}
                                                                </div>
                                                                <div class="text-sm text-gray-600 dark:text-slate-400">
                                                                    {{ $contribution->contribution_type }}:
                                                                    {{ $contribution->description }}
                                                                </div>
                                                            </div>
                                                            <div class="text-sm text-gray-600 dark:text-slate-400">
                                                                {{ \Carbon\Carbon::parse($contribution->date)->format('d M Y') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li>
                                                    <div class="text-sm text-gray-500 dark:text-slate-400">Belum ada
                                                        kontribusi yang
                                                        ditambahkan</div>
                                                </li>
                                            @endforelse

                                            <li class="mt-8">
                                                <div class="relative pb-8">
                                                    <div class="relative flex space-x-3">
                                                        <div>
                                                            <span
                                                                class="h-8 w-8 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center ring-8 ring-white dark:ring-slate-800">
                                                                <svg class="h-4 w-4 text-purple-600 dark:text-purple-400"
                                                                    fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div class="min-w-0 flex-1">
                                                            <div
                                                                class="text-sm font-medium text-purple-600 dark:text-purple-400 mb-1">
                                                                Visi &
                                                                Misi</div>
                                                            @if ($profile?->vision)
                                                                <div class="text-sm text-gray-600 dark:text-slate-400">
                                                                    {{ $profile->vision }}</div>
                                                            @else
                                                                <div class="text-sm text-gray-500 dark:text-slate-400">
                                                                    Belum ada visi & misi
                                                                    yang ditambahkan</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ecosystems Tab Content -->
            <div id="ecosystems-content" class="tab-content hidden">
                <div class="py-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Active Ecosystems -->
                        <div class="col-span-1 md:col-span-2 lg:col-span-2">
                            <div
                                class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-slate-900/50 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Ekosistem
                                                Aktif</h3>
                                        </div>
                                    </div>
                                    <!-- Ecosystem List -->
                                    <div class="space-y-4">
                                        @php
                                            $acceptedEcosystems = $user->acceptedEcosystems;
                                        @endphp
                                        @if ($acceptedEcosystems->isEmpty())
                                            <p class="text-gray-500 dark:text-slate-400 text-center py-4">Belum ada
                                                ekosistem aktif</p>
                                        @else
                                            @foreach ($acceptedEcosystems as $ecosystem)
                                                <div
                                                    class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="flex-shrink-0">
                                                            <span
                                                                class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100 dark:bg-slate-700">
                                                                <svg class="h-full w-full text-gray-300 dark:text-slate-400"
                                                                    fill="currentColor" viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <p
                                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">
                                                                {{ $ecosystem->ecosystem_title }}</p>
                                                            <p class="text-sm text-gray-500 dark:text-slate-400">
                                                                {{ $ecosystem->organization_name }}</p>
                                                            <p class="text-xs text-gray-400 dark:text-slate-500">
                                                                {{ $ecosystem->work_region }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/30 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:text-green-300">
                                                            Aktif
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ecosystem Stats -->
                        <div class="col-span-1">
                            <div
                                class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-slate-900/50 overflow-hidden">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4">Statistik
                                        Ekosistem</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Total Ekosistem</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $user->ecosystems->count() }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Ekosistem Aktif</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $user->acceptedEcosystems->count() }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Menunggu
                                                Persetujuan</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $user->pendingEcosystems->count() }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Dibuat Sendiri</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $user->createdEcosystems->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Collective Actions Tab Content -->
            <div id="collective-actions-content" class="tab-content hidden">
                <div class="py-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Aksi Mendatang -->
                        <div class="col-span-1 md:col-span-2 lg:col-span-2">
                            <div
                                class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-slate-900/50 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Aksi
                                                Kolektif Aktif</h3>
                                        </div>
                                    </div>
                                    <!-- Collective Action List -->
                                    <div class="space-y-4">
                                        @php
                                            $activeCollectiveActions = $user->activeCollectiveActions;
                                        @endphp
                                        @if ($activeCollectiveActions->isEmpty())
                                            <p class="text-gray-500 dark:text-slate-400 text-center py-4">Belum ada aksi
                                                kolektif aktif</p>
                                        @else
                                            @foreach ($activeCollectiveActions as $collectiveAction)
                                                <div
                                                    class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="flex-shrink-0">
                                                            <span
                                                                class="inline-block h-12 w-12 overflow-hidden rounded-lg bg-gray-100 dark:bg-slate-700">
                                                                <svg class="h-full w-full text-gray-300 dark:text-slate-400"
                                                                    fill="currentColor" viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <p
                                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">
                                                                {{ $collectiveAction->title }}</p>
                                                            <p class="text-sm text-gray-500 dark:text-slate-400">
                                                                {{ $collectiveAction->description }}
                                                            </p>
                                                            <div class="flex items-center gap-2 mt-1">
                                                                <p class="text-xs text-gray-400 dark:text-slate-500">
                                                                    {{ \Carbon\Carbon::parse($collectiveAction->start_date)->format('d M Y') }}
                                                                </p>
                                                                @if ($collectiveAction->location)
                                                                    <span
                                                                        class="text-xs text-gray-400 dark:text-slate-500">•</span>
                                                                    <p class="text-xs text-gray-400 dark:text-slate-500">
                                                                        {{ $collectiveAction->location }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col items-end gap-2">
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900/30 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:text-blue-300">
                                                            {{ ucfirst($collectiveAction->pivot->role) }}
                                                        </span>
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/30 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:text-green-300">
                                                            {{ ucfirst($collectiveAction->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Collective Action Stats -->
                        <div class="col-span-1">
                            <div
                                class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-slate-900/50 overflow-hidden">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4">Statistik Aksi
                                        Kolektif</h3>
                                    @php
                                        $totalCollectiveActions = $user->collectiveActionMemberships->count();
                                        $activeCount = $user->activeCollectiveActions->count();
                                        $adminCount = $user->adminCollectiveActions->count();
                                        $memberCount = $user->memberCollectiveActions->count();
                                        $contributorCount = $user->contributorCollectiveActions->count();
                                    @endphp
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Total Aksi
                                                Kolektif</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $totalCollectiveActions }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Aksi Aktif</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $activeCount }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Sebagai Admin</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $adminCount }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Sebagai Member</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $memberCount }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Sebagai
                                                Contributor</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $contributorCount }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Connections Tab Content -->
            <div id="connections-content" class="tab-content hidden">
                <div class="py-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Connected Users -->
                        <div class="col-span-1 md:col-span-2 lg:col-span-2">
                            <div
                                class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-slate-900/50 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Koneksi
                                            </h3>
                                        </div>
                                    </div>
                                    <!-- Connection List -->
                                    <div class="space-y-4">
                                        @php
                                            $accepted = $user->getAllConnectionsFlexible(); // All accepted connections for this user
                                        @endphp
                                        @if ($accepted->isEmpty())
                                            <p class="text-gray-500 dark:text-slate-400 text-center py-4">Belum ada koneksi
                                            </p>
                                        @else
                                            @foreach ($accepted as $conn)
                                                @php
                                                    // Determine which user is the connection (not the current user)
                                                    $otherUser =
                                                        $conn->requester_id == $user->id
                                                            ? $conn->receiver
                                                            : $conn->requester;
                                                @endphp
                                                @if ($otherUser)
                                                    <div
                                                        class="flex items-center justify-between max-sm:flex-col p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                                                        <div class="flex items-center space-x-4">
                                                            <div class="flex-shrink-0">
                                                                <span
                                                                    class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100 dark:bg-slate-700">
                                                                    <svg class="h-full w-full text-gray-300 dark:text-slate-400"
                                                                        fill="currentColor" viewBox="0 0 24 24">
                                                                        <path
                                                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <p
                                                                    class="text-sm font-medium text-gray-900 dark:text-slate-100">
                                                                    {{ $otherUser->name }}</p>
                                                                <p class="text-sm text-gray-500 dark:text-slate-400">
                                                                    {{ $otherUser->email }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            <a href="{{ route('profile.view', $otherUser->id) }}"
                                                                class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 dark:bg-indigo-700 hover:bg-indigo-700 dark:hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">Lihat
                                                                Profil</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Connection Stats -->
                        <div class="col-span-1">
                            <div
                                class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-slate-900/50 overflow-hidden">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4">Statistik
                                        Koneksi</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Total Koneksi</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $user->getAllConnectionsFlexible()->count() }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Permintaan Masuk</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $user->pendingReceivedConnections()->count() }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500 dark:text-slate-400">Permintaan
                                                Terkirim</span>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $user->pendingSentConnections()->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Tab Contents -->

        <!-- Mobile Bottom Navigation -->
        <div
            class="fixed bottom-0 left-0 right-0 bg-white dark:bg-slate-900 border-t border-gray-200 dark:border-slate-700 lg:hidden z-50">
            <div class="grid grid-cols-4 gap-1">
                <button onclick="showTab('profile')"
                    class="flex flex-col items-center py-2 px-1 text-xs font-medium text-purple-600 dark:text-purple-400">
                    <svg class="h-5 w-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil
                </button>
                <button onclick="showTab('ecosystems')"
                    class="flex flex-col items-center py-2 px-1 text-xs font-medium text-gray-500 dark:text-slate-400">
                    <svg class="h-5 w-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    Ekosistem
                </button>
                <button onclick="showTab('collective-actions')"
                    class="flex flex-col items-center py-2 px-1 text-xs font-medium text-gray-500 dark:text-slate-400">
                    <svg class="h-5 w-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Aksi
                </button>
                <button onclick="showTab('connections')"
                    class="flex flex-col items-center py-2 px-1 text-xs font-medium text-gray-500 dark:text-slate-400">
                    <svg class="h-5 w-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                        </path>
                    </svg>
                    Koneksi
                </button>
            </div>
        </div>

        <style>
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
        </style>

        <script>
            function showTab(tabName) {
                // Hide all tab contents
                const tabContents = document.querySelectorAll('.tab-content');
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Remove active state from all tab buttons (desktop)
                const tabButtons = document.querySelectorAll('.tab-button');
                tabButtons.forEach(button => {
                    button.classList.remove('border-purple-500', 'text-purple-600', 'dark:text-purple-400',
                        'dark:border-purple-400');
                    button.classList.add('border-transparent', 'text-gray-500', 'dark:text-slate-400',
                        'hover:text-gray-700', 'dark:hover:text-slate-300',
                        'hover:border-gray-300', 'dark:hover:border-slate-600');
                });

                // Remove active state from all mobile bottom nav buttons
                const mobileButtons = document.querySelectorAll('[onclick^="showTab"]');
                mobileButtons.forEach(button => {
                    button.classList.remove('text-purple-600', 'dark:text-purple-400');
                    button.classList.add('text-gray-500', 'dark:text-slate-400');
                });

                // Show selected tab content
                const selectedContent = document.getElementById(tabName + '-content');
                if (selectedContent) {
                    selectedContent.classList.remove('hidden');
                }

                // Add active state to selected tab button (desktop)
                const selectedButton = document.querySelector(`[data-tab="${tabName}"]`);
                if (selectedButton) {
                    selectedButton.classList.remove('border-transparent', 'text-gray-500', 'dark:text-slate-400',
                        'hover:text-gray-700', 'dark:hover:text-slate-300',
                        'hover:border-gray-300', 'dark:hover:border-slate-600');
                    selectedButton.classList.add('border-purple-500', 'text-purple-600', 'dark:text-purple-400',
                        'dark:border-purple-400');
                }

                // Add active state to selected mobile bottom nav button
                const selectedMobileButton = document.querySelector(`[onclick="showTab('${tabName}')"]`);
                if (selectedMobileButton) {
                    selectedMobileButton.classList.remove('text-gray-500', 'dark:text-slate-400');
                    selectedMobileButton.classList.add('text-purple-600', 'dark:text-purple-400');
                }
            }

            // Initialize with profile tab active
            document.addEventListener('DOMContentLoaded', function() {
                showTab('profile');
            });
        </script>
    </div>
