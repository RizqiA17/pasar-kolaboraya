<div class="relative overflow-hidden rounded-2xl bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 p-8">
    {{-- SVG Accent Elements --}}
    <div class="absolute top-0 left-0 w-32 h-32 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/SVG/8.svg') }}" alt="" class="object-contain w-full h-full">
    </div>
    <div class="absolute bottom-0 right-0 w-24 h-24 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/SVG/13.svg') }}" alt="" class="object-contain w-full h-full">
    </div>

    <div class="relative z-10">
        <div class="relative flex items-center justify-between w-full min-w-0 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-slate-200">Ringkasan Profil</h3>
                <p class="text-sm text-gray-700 dark:text-slate-300">Informasi tentang Anda</p>
            </div>
            <flux:button href="{{ route(name: 'settings.profile-settings') }}" size="sm" class="">
                <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span class="hidden sm:block">
                    Edit
                </span>
            </flux:button>
        </div>

        @if ($profile)
            <!-- Basic Info with Enhanced Design -->
            <div class="mb-6 space-y-4">
                @if ($user->organization_name)
                    <div class="flex items-center">
                        <div
                            class="min-w-10! w-10 h-10 bg-primary-blue rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-primary-blue">Organisasi</div>
                            <div class="text-lg font-semibold text-gray-700 dark:text-slate-200">
                                {{ $user->organization_name }}</div>
                        </div>
                    </div>
                @endif

                @if ($user->phone_number)
                    <div class="flex items-center">
                        <div
                            class="min-w-10! w-10 h-10 bg-secondary-green rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-secondary-green">Telepon</div>
                            <div class="text-lg font-semibold text-gray-700 dark:text-slate-200">
                                {{ $user->phone_number }}
                            </div>
                        </div>
                    </div>
                @endif

                @if ($profile->vision)
                    <div class="flex items-start w-full min-w-0">
                        <div
                            class="min-w-10! h-10! bg-accent-red rounded-xl flex items-center justify-center mr-4 mt-1">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-bold text-accent-red">Visi/Misi</div>
                            <div class="w-full min-w-0 text-xs text-gray-700 dark:text-slate-200 line-clamp-2">
                                {{ $profile->vision }}</div>
                        </div>
                    </div>
                @endif
            </div>

            @if (
                ($allSkills && $allSkills->count() > 0) ||
                    ($allInterests && $allInterests->count() > 0) ||
                    ($profile->social_media && is_array($profile->social_media) && count($profile->social_media) > 0))
                <div class="my-6 border-t border-gray-200 dark:border-gray-700"></div>
            @endif

            <!-- Skills with Enhanced Design -->
            @if ($allSkills && $allSkills->count() > 0)
                <div class="mb-8">
                    <h4 class="flex items-center mb-4 text-lg font-semibold text-gray-700 dark:text-slate-200">
                        <div
                            class="flex items-center justify-center w-8 h-8 mr-3 transition-colors rounded-lg bg-primary-blue">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                        </div>
                        Keahlian
                    </h4>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($allSkills->take(5) as $skillData)
                            @if ($skillData->custom_name)
                                <span
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-full shadow-sm text-sky-800 dark:text-sky-200 bg-sky-100 dark:bg-primary-blue/50">
                                    {{ $skillData->custom_name }}
                                    <span class="ml-1 text-xs opacity-75">(Custom)</span>
                                </span>
                            @else
                                @php
                                    $skill = $skills->firstWhere('id', $skillData->skill_id);
                                @endphp
                                @if ($skill && $skill->name)
                                    <span
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-full shadow-sm text-sky-800 dark:text-sky-200 bg-sky-100 dark:bg-primary-blue/50">
                                        {{ $skill->name }}
                                    </span>
                                @endif
                            @endif
                        @endforeach
                        @if ($allSkills->count() > 5)
                            <span
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 border border-gray-200 rounded-full shadow-sm bg-gradient-to-r from-gray-100 to-slate-100 dark:from-gray-800 dark:to-slate-800 dark:text-gray-300 dark:border-gray-600">
                                +{{ $allSkills->count() - 5 }} lagi
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Interests with Enhanced Design -->
            @if ($allInterests && $allInterests->count() > 0)
                <div class="mb-8">
                    <h4 class="flex items-center mb-4 text-lg font-semibold text-gray-700 dark:text-slate-200">
                        <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-secondary-green">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </div>
                        Minat
                    </h4>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($allInterests->take(5) as $interestData)
                            @if ($interestData->custom_name)
                                <span
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-full shadow-sm text-emerald-800 dark:text-emerald-200 bg-emerald-100 dark:bg-secondary-green/50">
                                    {{ $interestData->custom_name }}
                                    <span class="ml-1 text-xs opacity-75">(Custom)</span>
                                </span>
                            @else
                                @php
                                    $interest = $interests->firstWhere('id', $interestData->interest_id);
                                @endphp
                                @if ($interest && $interest->name)
                                    <span
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-full shadow-sm text-emerald-800 dark:text-emerald-200 bg-emerald-100 dark:bg-secondary-green/50">
                                        {{ $interest->name }}
                                    </span>
                                @endif
                            @endif
                        @endforeach
                        @if ($allInterests->count() > 5)
                            <span
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 border border-gray-200 rounded-full shadow-sm bg-gradient-to-r from-gray-100 to-slate-100 dark:from-gray-800 dark:to-slate-800 dark:text-gray-300 dark:border-gray-600">
                                +{{ $allInterests->count() - 5 }} lagi
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Social Media with Enhanced Design -->
            @if ($profile->social_media && is_array($profile->social_media) && count($profile->social_media) > 0)
                <div class="mb-6">
                    <h4 class="flex items-center mb-4 text-lg font-semibold text-gray-700 dark:text-slate-200">
                        <div
                            class="flex items-center justify-center w-8 h-8 mr-3 transition-colors rounded-lg bg-accent-red">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2">
                                </path>
                            </svg>
                        </div>
                        Media Sosial
                    </h4>
                    <div class="flex flex-col gap-3">
                        @foreach ($profile->formatted_social_media as $platform => $url)
                            @if ($url && !empty($url))
                            @php
                                $url
                            @endphp
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg">

                                        @if (strtolower($platform) == 'instagram')
                                            <svg class="w-5 h-5 text-pink-500" viewBox="0 0 32 32" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect x="2" y="2" width="28" height="28" rx="6"
                                                    fill="url(#paint0_radial_87_7153)" />
                                                <rect x="2" y="2" width="28" height="28" rx="6"
                                                    fill="url(#paint1_radial_87_7153)" />
                                                <rect x="2" y="2" width="28" height="28" rx="6"
                                                    fill="url(#paint2_radial_87_7153)" />
                                                <path
                                                    d="M23 10.5C23 11.3284 22.3284 12 21.5 12C20.6716 12 20 11.3284 20 10.5C20 9.67157 20.6716 9 21.5 9C22.3284 9 23 9.67157 23 10.5Z"
                                                    fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M16 21C18.7614 21 21 18.7614 21 16C21 13.2386 18.7614 11 16 11C13.2386 11 11 13.2386 11 16C11 18.7614 13.2386 21 16 21ZM16 19C17.6569 19 19 17.6569 19 16C19 14.3431 17.6569 13 16 13C14.3431 13 13 14.3431 13 16C13 17.6569 14.3431 19 16 19Z"
                                                    fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M6 15.6C6 12.2397 6 10.5595 6.65396 9.27606C7.2292 8.14708 8.14708 7.2292 9.27606 6.65396C10.5595 6 12.2397 6 15.6 6H16.4C19.7603 6 21.4405 6 22.7239 6.65396C23.8529 7.2292 24.7708 8.14708 25.346 9.27606C26 10.5595 26 12.2397 26 15.6V16.4C26 19.7603 26 21.4405 25.346 22.7239C24.7708 23.8529 23.8529 24.7708 22.7239 25.346C21.4405 26 19.7603 26 16.4 26H15.6C12.2397 26 10.5595 26 9.27606 25.346C8.14708 24.7708 7.2292 23.8529 6.65396 22.7239C6 21.4405 6 19.7603 6 16.4V15.6ZM15.6 8H16.4C18.1132 8 19.2777 8.00156 20.1779 8.0751C21.0548 8.14674 21.5032 8.27659 21.816 8.43597C22.5686 8.81947 23.1805 9.43139 23.564 10.184C23.7234 10.4968 23.8533 10.9452 23.9249 11.8221C23.9984 12.7223 24 13.8868 24 15.6V16.4C24 18.1132 23.9984 19.2777 23.9249 20.1779C23.8533 21.0548 23.7234 21.5032 23.564 21.816C23.1805 22.5686 22.5686 23.1805 21.816 23.564C21.5032 23.7234 21.0548 23.8533 20.1779 23.9249C19.2777 23.9984 18.1132 24 16.4 24H15.6C13.8868 24 12.7223 23.9984 11.8221 23.9249C10.9452 23.8533 10.4968 23.7234 10.184 23.564C9.43139 23.1805 8.81947 22.5686 8.43597 21.816C8.27659 21.5032 8.14674 21.0548 8.0751 20.1779C8.00156 19.2777 8 18.1132 8 16.4V15.6C8 13.8868 8.00156 12.7223 8.0751 11.8221C8.14674 10.9452 8.27659 10.4968 8.43597 10.184C8.81947 9.43139 9.43139 8.81947 10.184 8.43597C10.4968 8.27659 10.9452 8.14674 11.8221 8.0751C12.7223 8.00156 13.8868 8 15.6 8Z"
                                                    fill="white" />
                                                <defs>
                                                    <radialGradient id="paint0_radial_87_7153" cx="0"
                                                        cy="0" r="1" gradientUnits="userSpaceOnUse"
                                                        gradientTransform="translate(12 23) rotate(-55.3758) scale(25.5196)">
                                                        <stop stop-color="#B13589" />
                                                        <stop offset="0.79309" stop-color="#C62F94" />
                                                        <stop offset="1" stop-color="#8A3AC8" />
                                                    </radialGradient>
                                                    <radialGradient id="paint1_radial_87_7153" cx="0"
                                                        cy="0" r="1" gradientUnits="userSpaceOnUse"
                                                        gradientTransform="translate(11 31) rotate(-65.1363) scale(22.5942)">
                                                        <stop stop-color="#E0E8B7" />
                                                        <stop offset="0.444662" stop-color="#FB8A2E" />
                                                        <stop offset="0.71474" stop-color="#E2425C" />
                                                        <stop offset="1" stop-color="#E2425C" stop-opacity="0" />
                                                    </radialGradient>
                                                    <radialGradient id="paint2_radial_87_7153" cx="0"
                                                        cy="0" r="1" gradientUnits="userSpaceOnUse"
                                                        gradientTransform="translate(0.500002 3) rotate(-8.1301) scale(38.8909 8.31836)">
                                                        <stop offset="0.156701" stop-color="#406ADC" />
                                                        <stop offset="0.467799" stop-color="#6A45BE" />
                                                        <stop offset="1" stop-color="#6A45BE" stop-opacity="0" />
                                                    </radialGradient>
                                                </defs>
                                            </svg>
                                        @elseif(strtolower($platform) == 'facebook')
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                            </svg>
                                        @elseif(strtolower($platform) == 'github')
                                            <svg class="w-5 h-5 text-gray-800 dark:text-white" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                            </svg>
                                        @elseif(strtolower($platform) == 'tiktok')
                                            <svg class="w-5 h-5 text-black dark:text-white" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.08-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                                            </svg>
                                        @elseif(strtolower($platform) == 'youtube')
                                            <svg class="w-5 h-5 text-red-600" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                            </svg>
                                        @elseif(strtolower($platform) == 'x')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                class="w-5 h-5 bi bi-twitter-x" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.6 0.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867 -5.07 -4.425 5.07H0.316l5.733 -6.57L0 0.75h5.063l3.495 4.633L12.601 0.75Zm-0.86 13.028h1.36L4.323 2.145H2.865z"
                                                    stroke-width="1"></path>
                                            </svg>
                                        @elseif(strtolower($platform) == 'linkedin')
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-xs font-medium text-gray-900 dark:text-slate-300">
                                            {{ ucfirst($platform) }}</div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-slate-200">
                                            <a href="{{ strtolower($platform) == 'website' ? $url : str_replace('@', '', $url) }}" target="_blank" rel="noopener noreferrer"
                                                class="hover:underline">
                                                @if (strtolower($platform) == 'website')
                                                    {{ $url }}
                                                @else
                                                    &#64;{{ ltrim(last(explode('/', trim(parse_url($url, PHP_URL_PATH), '/'))), '@') }}
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State with Enhanced Design -->
            <div class="py-12 text-center">
                <div
                    class="flex items-center justify-center w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-gray-300 to-gray-400">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h4 class="mb-2 text-lg font-semibold text-gray-700 dark:text-slate-200">Belum Ada Profil</h4>
                <p class="mb-6 text-gray-600 dark:text-gray-400">Buat profil Anda untuk memulai perjalanan kolaborasi
                </p>
                <flux:button href="{{ route(name: 'settings.profile-settings') }}" variant="primary"
                    class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700">
                    Buat Profil
                </flux:button>
            </div>
        @endif
    </div>
</div>
