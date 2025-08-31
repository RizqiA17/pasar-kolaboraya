<div class="w-full bg-white relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-20 h-20" opacity="opacity-10" />
    <x-svg-accent position="center-right" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="bottom-left" size="w-14 h-14" opacity="opacity-10" />
    
    <!-- Hero Section -->
    <div class="relative">
        <!-- Cover Image -->
        <div class="h-40 w-full overflow-hidden">
            @if (auth()->user()->profile?->banner)
                <img src="{{ asset('storage/' . auth()->user()->profile->banner) }}" alt="Cover"
                    class="w-full h-full object-cover">
            @else
                <img src="https://images.unsplash.com/photo-1620207418302-439b387441b0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80"
                    alt="Cover" class="w-full h-full object-cover">
            @endif
        </div>

        <!-- Profile Info -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
            <div class="relative -mt-32 pb-8">
                <div class="flex flex-col md:flex-row items-start gap-6">
                    <!-- Profile Image -->
                    <div class="relative flex-shrink-0 ">
                        <div class="h-48 w-48 rounded-xl bg-white shadow-xl overflow-hidden">
                            @if (auth()->user()->profile?->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile->profile_photo) }}"
                                    alt="Profile" class="h-full w-full object-cover">
                            @else
                                <div
                                    class="h-full w-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                    <span class="text-white text-6xl font-bold">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </div>
                            @endif
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
                                <h1 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h1>
                                <p class="text-gray-500">{{ auth()->user()->email }}</p>
                                @if (auth()->user()->profile?->organization)
                                    <div class="flex items-center mt-2 text-gray-600">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        <span>{{ auth()->user()->profile->organization }}</span>
                                    </div>
                                @endif
                                @if (auth()->user()->profile?->phone)
                                    <div class="flex items-center mt-2 text-gray-600">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        <span>{{ auth()->user()->profile->phone }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex gap-4">
                                <a href="{{ route('settings.profile-settings') }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Edit Profile
                                </a>
                                <button type="button"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Share
                                </button>
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        @if (auth()->user()->profile?->social_media)
                            <div class="mt-4 flex flex-wrap gap-3">
                                @foreach (auth()->user()->profile->social_media as $platform => $url)
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

    <!-- Tab Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <!-- Profile Tab -->
                <button onclick="showTab('profile')" 
                   class="tab-button border-purple-500 text-purple-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center"
                   data-tab="profile">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil
                </button>
                
                <!-- Collaborations Tab -->
                <button onclick="showTab('collaborations')" 
                   class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center"
                   data-tab="collaborations">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    Kolaborasi
                </button>
                
                <!-- Aksi Tab -->
                <button onclick="showTab('events')" 
                   class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center"
                   data-tab="events">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Aksi
                </button>
                
                <!-- Connections Tab -->
                <button onclick="showTab('connections')" 
                   class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center"
                   data-tab="connections">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                        </path>
                    </svg>
                    Koneksi
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Contents -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Profile Tab Content -->
        <div id="profile-content" class="tab-content">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 py-8">

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
                                @if (auth()->user()->profile?->skills)
                                    <span
                                        class="inline-flex items-center rounded-full bg-[#379eff]/10 px-2.5 py-1 text-xs font-medium text-[#379eff]">
                                        {{ auth()->user()->profile->skills->count() }} skills
                                    </span>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach (auth()->user()->profile?->skills as $skill)
                                        @if ($skill && $skill->name)
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
                    <!-- End Skills Section -->

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
                                @if (auth()->user()->profile?->interests)
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                        {{ auth()->user()->profile->interests->count() }} interests
                                    </span>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach (auth()->user()->profile?->interests as $interest)
                                        @if ($interest && $interest->name)
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
                    <!-- End Interests Section -->

            </div>
                <!-- End Skills & Interests -->

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
                                @if (auth()->user()->profile?->contributions)
                                    <span
                                        class="inline-flex items-center rounded-full bg-[#379eff]/10 px-2.5 py-1 text-xs font-medium text-[#379eff]">
                                            {{ auth()->user()->profile->contributions->count() }} contributions
                                    </span>
                                @endif
                            </div>
                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    @if (auth()->user()->profile?->contributions)
                                        @foreach (auth()->user()->profile->contributions as $contribution)
                                                @if ($contribution && $contribution->name && $contribution->description && $contribution->date)
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
                                                                        <svg class="h-4 w-4 text-[#379eff]"
                                                                            fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                                        </path>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class="min-w-0 flex-1">
                                                                <div class="text-sm text-gray-600">
                                                                    {{ $contribution->name }}</div>
                                                                <div class="text-sm text-gray-600">
                                                                        {{ $contribution->description }}</div>
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

                                    @if (auth()->user()->profile?->vision)
                                        <li>
                                            <div class="relative pb-8">
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span
                                                            class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center ring-8 ring-white">
                                                            <svg class="h-4 w-4 text-purple-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                            <div class="text-sm font-medium text-purple-600 mb-1">Visi
                                                                & Misi</div>
                                                        <div class="text-sm text-gray-600">
                                                            {{ auth()->user()->profile->vision }}</div>
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
                <!-- End Contributions Timeline -->

            </div>
        </div>
        <!-- End Profile Tab Content -->

        <!-- Collaborations Tab Content -->
        <div id="collaborations-content" class="tab-content hidden">
            <div class="py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Active Collaborations -->
                    <div class="col-span-1 md:col-span-2 lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900">Kolaborasi Aktif</h3>
                                    </div>
                                </div>
                                <!-- Collaboration List -->
                                <div class="space-y-4">
                                    @if (auth()->user()->collaborations->isEmpty())
                                        <p class="text-gray-500 text-center py-4">Belum ada kolaborasi aktif</p>
                                    @else
                                        @foreach (auth()->user()->collaborations as $collaboration)
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <span
                                                            class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100">
                                                            <svg class="h-full w-full text-gray-300"
                                                                fill="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">
                                                            {{ $collaboration->title }}</p>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $collaboration->description }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
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

                    <!-- Collaboration Stats -->
                    <div class="col-span-1">
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Kolaborasi</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Total Kolaborasi</span>
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ auth()->user()->collaborations->count() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Kolaborasi Aktif</span>
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ auth()->user()->collaborations->where('status', 'active')->count() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Kolaborasi Selesai</span>
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ auth()->user()->collaborations->where('status', 'completed')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi Tab Content -->
        <div id="events-content" class="tab-content hidden">
            <div class="py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Aksi Mendatang -->
                    <div class="col-span-1 md:col-span-2 lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900">Aksi Mendatang</h3>
                                    </div>
                                </div>
                                <!-- Daftar Aksi -->
                                <div class="space-y-4">
                                    @if (auth()->user()->upcomingEvents()->count() == 0)
                                        <p class="text-gray-500 text-center py-4">Belum ada aksi yang akan datang</p>
                                    @else
                                        @foreach (auth()->user()->upcomingEvents()->get() as $event)
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        @if($event->banner)
                                                            <img src="{{ asset('storage/' . $event->banner) }}" 
                                                                alt="{{ $event->title }}"
                                                                class="h-12 w-12 object-cover rounded-lg">
                                                        @else
                                                            <span class="inline-block h-12 w-12 overflow-hidden rounded-lg bg-gray-100">
                                                                <svg class="h-full w-full text-gray-300"
                                                                    fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">
                                                            {{ $event->title }}</p>
                                                        <p class="text-sm text-gray-500">{{ $event->description }}</p>
                                                        <div class="flex items-center gap-2 mt-1">
                                                            <p class="text-xs text-gray-400">
                                                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y H:i') }}
                                                            </p>
                                                            @if($event->location)
                                                                <span class="text-xs text-gray-400">•</span>
                                                                <p class="text-xs text-gray-400">
                                                                    {{ $event->location }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col items-end gap-2">
                                                    @foreach($event->categories as $category)
                                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                                            {{ $category->name }}
                                                        </span>
                                                    @endforeach
                                                    @if($event->max_participants)
                                                        <span class="inline-flex items-center rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800">
                                                            {{ $event->participants()->count() }}/{{ $event->max_participants }} Peserta
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Aksi -->
                    <div class="col-span-1">
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Aksi</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Total Aksi</span>
                                        <span class="text-sm font-medium text-gray-900">{{ auth()->user()->events()->count() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Aksi Mendatang</span>
                                        <span class="text-sm font-medium text-gray-900">{{ auth()->user()->upcomingEvents()->count() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Aksi Selesai</span>
                                        <span class="text-sm font-medium text-gray-900">{{ auth()->user()->pastEvents()->count() }}</span>
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
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900">Koneksi Saya</h3>
                                    </div>
                                </div>
                                <!-- Connection List -->
                                <div class="space-y-4">
                                    @if (auth()->user()->connections->isEmpty())
                                        <p class="text-gray-500 text-center py-4">Belum ada koneksi</p>
                                    @else
                                        @foreach (auth()->user()->connections as $connection)
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <span
                                                            class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100">
                                                            <svg class="h-full w-full text-gray-300"
                                                                fill="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">
                                                            {{ $connection->name }}</p>
                                                        <p class="text-sm text-gray-500">{{ $connection->email }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <button type="button"
                                                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Lihat Profil
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Stats -->
                    <div class="col-span-1">
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Koneksi</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Total Koneksi</span>
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ auth()->user()->connections->count() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Permintaan Masuk</span>
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ auth()->user()->pendingReceivedConnections()->count() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Permintaan Terkirim</span>
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ auth()->user()->pendingSentConnections()->count() }}</span>
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

<script>
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('border-purple-500', 'text-purple-600');
                button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                    'hover:border-gray-300');
    });
    
    // Show selected tab content
    const selectedContent = document.getElementById(tabName + '-content');
    if (selectedContent) {
        selectedContent.classList.remove('hidden');
    }
    
    // Add active state to selected tab button
    const selectedButton = document.querySelector(`[data-tab="${tabName}"]`);
    if (selectedButton) {
                selectedButton.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                    'hover:border-gray-300');
        selectedButton.classList.add('border-purple-500', 'text-purple-600');
    }
}

// Initialize with profile tab active
document.addEventListener('DOMContentLoaded', function() {
    showTab('profile');
});
</script>
