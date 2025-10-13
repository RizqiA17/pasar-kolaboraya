<div
    class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-purple-50 dark:from-zinc-800 dark:to-purple-900/20 shadow-xl border border-gray-100 dark:border-gray-700 p-8">
    {{-- SVG Accent Elements --}}
    <div class="absolute top-0 left-0 w-32 h-32 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/SVG/8.svg') }}" alt="" class="w-full h-full object-contain">
    </div>
    <div class="absolute bottom-0 right-0 w-24 h-24 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/SVG/13.svg') }}" alt="" class="w-full h-full object-contain">
    </div>

    <div class="relative z-10">
        <div class="flex items-center justify-between mb-6 relative">
            <div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Ringkasan Profil</h3>
                <p class="text-gray-600 dark:text-gray-400">Informasi lengkap tentang Anda</p>
            </div>
            <flux:button href="{{ route(name: 'settings.profile-settings') }}" variant="subtle" size="sm"
                class="bg-accent-red! absolute! right-0 top-0 text-white! hover:bg-accent-red/90! border-purple-200">
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
            <div class="space-y-4 mb-8">
                @if ($profile->organization)
                    <div
                        class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-blue-100 dark:border-blue-800">
                        <div class="min-w-10! w-10 h-10 bg-primary-blue rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-blue-700 dark:text-blue-300">Organisasi</div>
                            <div class="text-lg font-semibold text-blue-900 dark:text-blue-100">
                                {{ $profile->organization }}</div>
                        </div>
                    </div>
                @endif

                @if ($profile->phone)
                    <div
                        class="flex items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl border border-green-100 dark:border-green-800">
                        <div class="min-w-10! w-10 h-10 bg-secondary-green rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-green-700 dark:text-green-300">Telepon</div>
                            <div class="text-lg font-semibold text-green-900 dark:text-green-100">{{ $profile->phone }}
                            </div>
                        </div>
                    </div>
                @endif

                @if ($profile->vision)
                    <div
                        class="flex items-start p-4 bg-red-50 dark:bg-red-900/20 rounded-2xl border border-red-100 dark:border-red-800">
                        <div
                            class="min-w-10! h-10! bg-accent-red rounded-xl flex items-center justify-center mr-4 mt-1">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-red-700 dark:text-red-300">Visi</div>
                            <div class="text-base text-red-900 dark:text-red-100">
                                {{ Str::limit($profile->vision, 100) }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Skills with Enhanced Design -->
            @if ($allSkills && $allSkills->count() > 0)
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <div
                            class="w-8 h-8 bg-primary-blue transition-colors rounded-lg flex items-center justify-center mr-3">
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
                            @if($skillData->custom_name)
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 dark:from-blue-900/30 dark:to-indigo-900/30 dark:text-blue-200 border border-blue-200 dark:border-blue-700 shadow-sm">
                                    {{ $skillData->custom_name }}
                                    <span class="ml-1 text-xs opacity-75">(Custom)</span>
                                </span>
                            @else
                                @php
                                    $skill = $skills->firstWhere('id', $skillData->skill_id);
                                @endphp
                                @if($skill && $skill->name)
                                    <span
                                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 dark:from-blue-900/30 dark:to-indigo-900/30 dark:text-blue-200 border border-blue-200 dark:border-blue-700 shadow-sm">
                                        {{ $skill->name }}
                                        @if ($skillData->is_primary)
                                            <svg class="w-4 h-4 ml-2 text-blue-600 dark:text-blue-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </span>
                                @endif
                            @endif
                        @endforeach
                        @if ($allSkills->count() > 5)
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-gray-100 to-slate-100 text-gray-700 dark:from-gray-800 dark:to-slate-800 dark:text-gray-300 border border-gray-200 dark:border-gray-600 shadow-sm">
                                +{{ $allSkills->count() - 5 }} lagi
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Interests with Enhanced Design -->
            @if ($allInterests && $allInterests->count() > 0)
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-secondary-green rounded-lg flex items-center justify-center mr-3">
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
                            @if($interestData->custom_name)
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 dark:from-green-900/30 dark:to-emerald-900/30 dark:text-green-200 border border-green-200 dark:border-green-700 shadow-sm">
                                    {{ $interestData->custom_name }}
                                    <span class="ml-1 text-xs opacity-75">(Custom)</span>
                                </span>
                            @else
                                @php
                                    $interest = $interests->firstWhere('id', $interestData->interest_id);
                                @endphp
                                @if($interest && $interest->name)
                                    <span
                                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 dark:from-green-900/30 dark:to-emerald-900/30 dark:text-green-200 border border-green-200 dark:border-green-700 shadow-sm">
                                        {{ $interest->name }}
                                    </span>
                                @endif
                            @endif
                        @endforeach
                        @if ($allInterests->count() > 5)
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-gray-100 to-slate-100 text-gray-700 dark:from-gray-800 dark:to-slate-800 dark:text-gray-300 border border-gray-200 dark:border-gray-600 shadow-sm">
                                +{{ $allInterests->count() - 5 }} lagi
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Social Media with Enhanced Design -->
            @if ($profile->social_media && is_array($profile->social_media) && count($profile->social_media) > 0)
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <div
                            class="w-8 h-8 bg-accent-red transition-colors rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2">
                                </path>
                            </svg>
                        </div>
                        Media Sosial
                    </h4>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($profile->formatted_social_media as $platform => $url)
                            @if ($url && !empty($url))
                                <div
                                    class="flex items-center p-3 bg-red-100 dark:bg-red-900/50 rounded-xl border border-red-100 dark:border-red-800">
                                    <div
                                        class="w-8 h-8 bg-accent-red transition-colors rounded-lg flex items-center justify-center mr-3">
                                        <span
                                            class="text-white text-sm font-bold">{{ strtoupper(substr($platform, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-xs font-medium text-red-600 dark:text-red-200">
                                            {{ ucfirst($platform) }}</div>
                                        <div class="text-sm font-semibold text-red-900 dark:text-red-100">
                                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="hover:underline">
                                                {{ $url }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Location with Enhanced Design -->
            @if ($profile->location)
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        Lokasi
                    </h4>
                    <div
                        class="flex items-center p-4 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-2xl border border-orange-100 dark:border-orange-800">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-orange-700 dark:text-orange-300">Lokasi</div>
                            <div class="text-lg font-semibold text-orange-900 dark:text-orange-100">
                                {{ $profile->location }}</div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State with Enhanced Design -->
            <div class="text-center py-12">
                <div
                    class="w-20 h-20 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Profil</h4>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Buat profil Anda untuk memulai perjalanan kolaborasi
                </p>
                <flux:button href="{{ route(name: 'settings.profile-settings') }}" variant="primary"
                    class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700">
                    Buat Profil
                </flux:button>
            </div>
        @endif
    </div>
</div>
