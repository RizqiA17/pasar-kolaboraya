@props([
    'user' => null,
    'bannerHeight' => 'h-40',
    'avatarSize' => '4xl',
    'showStatus' => true,
    'class' => ''
])

@if($user)
<div class="relative {{ $class }}">
    <!-- Banner -->
    <x-ui.banner :user="$user" :height="$bannerHeight" />
    
    <!-- Profile Info -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="relative -mt-32 pb-8">
            <div class="flex flex-col md:flex-row items-start gap-6">
                <!-- Profile Image -->
                <div class="relative flex-shrink-0">
                    <div class="h-48 w-48 rounded-xl bg-white shadow-xl overflow-hidden">
                        @if($user->profile?->profile_photo)
                            <img 
                                src="{{ asset('storage/' . $user->profile->profile_photo) }}"
                                alt="{{ $user->name }}'s profile photo" 
                                class="h-full w-full object-cover"
                            >
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                <span class="text-white text-6xl font-bold">
                                    {{ $user->initials() }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    @if($showStatus)
                        <div class="absolute -bottom-2 -right-2">
                            <span class="relative flex h-5 w-5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-5 w-5 bg-emerald-500 ring-2 ring-white"></span>
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Profile Details -->
                <div class="flex-1 min-w-0 mt-18 w-full">
                    <div class="space-y-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $user->name }}
                            </h1>
                            <p class="text-lg text-gray-600 dark:text-gray-400">
                                {{ $user->email }}
                            </p>
                        </div>
                        
                        @if($user->profile?->organization)
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="text-lg">{{ $user->profile->organization }}</span>
                            </div>
                        @endif
                        
                        @if($user->profile?->vision)
                            <div class="max-w-2xl">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {{ $user->profile->vision }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
