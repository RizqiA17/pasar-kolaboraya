<div class="w-full bg-white">
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 z-50">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
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

    <!-- Hero Section -->
    <div class="relative">
        <!-- Cover Image -->
        <div class="h-40 w-full overflow-hidden">
            <img src="https://images.unsplash.com/photo-1620207418302-439b387441b0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80"
                alt="Cover" class="w-full h-full object-cover">
        </div>

        <!-- Profile Info -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
            <div class="relative -mt-32 pb-8">
                <div class="flex flex-col md:flex-row items-start gap-6">
                    <!-- Profile Image -->
                    <div class="relative flex-shrink-0 ">
                        <div class="h-48 w-48 rounded-xl bg-white shadow-xl overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80"
                                alt="Profile" class="h-full w-full object-cover">
                        </div>
                        <div class="absolute -bottom-2 -right-2">
                            <span class="relative flex h-5 w-5">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span
                                    class="relative inline-flex rounded-full h-5 w-5 bg-emerald-500 ring-2 ring-white"></span>
                            </span>
                        </div>
                    </div>

                    <!-- Profile Details -->
                    <div class="flex-1 min-w-0 mt-18">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-gray-500">{{ $user->email }}</p>
                                @if ($profile?->organization)
                                    <div class="flex items-center mt-2 text-gray-600">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        <span>{{ $profile->organization }}</span>
                                    </div>
                                @endif
                                @if ($profile?->phone)
                                    <div class="flex items-center mt-2 text-gray-600">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        <span>{{ $profile->phone }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex gap-4">
                                @if (auth()->id() === $user->id)
                                    <a href="{{ route('settings.profile-settings') }}"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Edit Profile
                                    </a>
                                @else
                                    <!-- Action Buttons Section -->
                                    @if (auth()->id() !== $user->id)
                                        <!-- Connection Status & Actions -->
                                        @php
                                            $connectionStatus = auth()->user()->getConnectionStatus($user->id);
                                        @endphp

                                        @if ($connectionStatus === 'not_connected')
                                            <button wire:click="connect({{ $user->id }})"
                                                class="flex-1 py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Tambah Koneksi
                                            </button>
                                        @elseif($connectionStatus === 'pending_sent')
                                            <button disabled
                                                class="flex-1 py-3 px-4 bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
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
                                                    class="flex-1 py-3 px-4 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Terima Permintaan
                                                </button>
                                                <button wire:click="rejectConnection({{ $user->id }})"
                                                    class="flex-1 py-3 px-4 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
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
                                                <button wire:click="startCollaboration({{ $user->id }})"
                                                    class="flex-1 py-3 px-4 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                        </path>
                                                    </svg>
                                                    Mulai Kolaborasi
                                                </button>
                                                <button wire:click="disconnect({{ $user->id }})"
                                                    class="flex-1 py-3 px-4 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
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
                                @endif
                                <button type="button"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Share
                                </button>
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        @if ($profile?->social_media)
                            <div class="mt-4 flex flex-wrap gap-3">
                                @foreach ($profile->social_media as $platform => $url)
                                    @if ($url !== '')
                                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors">
                                            @switch(strtolower($platform))
                                                @case('linkedin')
                                                    <svg class="h-5 w-5 mr-1.5 text-blue-600" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                                    </svg>
                                                @break

                                                @case('twitter')
                                                    <svg class="h-5 w-5 mr-1.5 text-blue-400" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                                    </svg>
                                                @break

                                                @case('github')
                                                    <svg class="h-5 w-5 mr-1.5 text-gray-900" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                                    </svg>
                                                @break

                                                @default
                                                    <svg class="h-5 w-5 mr-1.5 text-gray-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                    </svg>
                                            @endswitch
                                            {{ ucfirst($platform) }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif



                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Skills & Interests -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Skills Section -->
                <div class="group relative">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-[#379eff]/50 to-blue-500/50 rounded-xl opacity-50 group-hover:opacity-75 blur transition duration-1000 group-hover:duration-200">
                    </div>
                    <div class="relative bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="h-5 w-5 text-[#379eff]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900">Keahlian</h3>
                                </div>
                                @if ($profile?->skills)
                                    <span
                                        class="inline-flex items-center rounded-full bg-[#379eff]/10 px-2.5 py-1 text-xs font-medium text-[#379eff]">
                                        {{ $profile->skills->count() }} skills
                                    </span>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($profile?->skills as $skill)
                                    @if (trim($skill))
                                        <span
                                            class="group/item inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-[#379eff]/5 text-[#379eff] ring-1 ring-inset ring-[#379eff]/10 transition-all duration-200 hover:bg-[#379eff]/10">
                                            {{ $skill->name }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Interests Section -->
                <div class="group relative">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500/50 to-green-500/50 rounded-xl opacity-50 group-hover:opacity-75 blur transition duration-1000 group-hover:duration-200">
                    </div>
                    <div class="relative bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900">Minat & Ketertarikan</h3>
                                </div>
                                @if ($profile?->interests)
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                        {{ $profile->interests->count() }} interests
                                    </span>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($profile?->interests as $interest)
                                    @if (trim($interest))
                                        <span
                                            class="group/item inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 transition-all duration-200 hover:bg-emerald-100">
                                            {{ $interest->name }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contributions Timeline -->
            <div class="lg:col-span-2">
                <div class="group relative">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-[#379eff]/50 to-blue-500/50 rounded-xl opacity-50 group-hover:opacity-75 blur transition duration-1000 group-hover:duration-200">
                    </div>
                    <div class="relative bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-2">
                                    <svg class="h-5 w-5 text-[#379eff]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900">Kontribusi & Pencapaian</h3>
                                </div>
                                @if ($profile?->contributions)
                                    <span
                                        class="inline-flex items-center rounded-full bg-[#379eff]/10 px-2.5 py-1 text-xs font-medium text-[#379eff]">
                                        {{ $profile->contributions->count() }}
                                        contributions
                                    </span>
                                @endif
                            </div>
                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    @if ($profile?->contributions)
                                        @foreach ($profile->contributions as $contribution)
                                            @if (trim($contribution))
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
                                                                    class="h-8 w-8 rounded-full bg-[#379eff]/10 flex items-center justify-center ring-8 ring-white">
                                                                    <svg class="h-4 w-4 text-[#379eff]" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                                        </path>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class="min-w-0 flex-1">
                                                                <div class="text-sm text-gray-600">
                                                                    {{ $contribution->name }}</div>
                                                                <div class="text-sm text-gray-600">
                                                                    {{ $contribution->description }}
                                                                </div>
                                                            </div>
                                                            <div class="text-sm text-gray-600">
                                                                {{ \Carbon\Carbon::parse($contribution->date)->format('d M Y') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif

                                    @if ($profile?->vision)
                                        <li>
                                            <div class="relative pb-8">
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span
                                                            class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center ring-8 ring-white">
                                                            <svg class="h-4 w-4 text-purple-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div class="text-sm font-medium text-purple-600 mb-1">Visi &
                                                            Misi</div>
                                                        <div class="text-sm text-gray-600">
                                                            {{ $profile->vision }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
