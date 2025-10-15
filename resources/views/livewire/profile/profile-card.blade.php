@php
    $connectionsEnabled = \App\Models\SystemSetting::isConnectionsEnabled();
    $collaborationsEnabled = \App\Models\SystemSetting::isCollaborationsEnabled();
    $isSuperAdmin = auth()->user()->isSuperAdmin();
@endphp

<div>
    @if($showModal && $selectedUser)
        <!-- Modal Backdrop -->
        <div class="fixed inset-0 bg-black/50 dark:bg-black/70 z-50 flex items-center justify-center p-4" 
             wire:click="closeModal">
            
            <!-- Modal Content -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl dark:shadow-slate-900/50 max-w-md w-full max-h-[90vh] overflow-y-auto relative" 
                 wire:click.stop>
                
                <!-- SVG Accent for Modal -->
                <x-svg-accent position="top-right" size="w-8 h-8" opacity="opacity-10" />
                
                <!-- Header -->
                <div class="p-6 border-b border-gray-100 dark:border-slate-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Profil Pengguna</h3>
                        <button wire:click="closeModal" 
                                class="text-gray-400 dark:text-slate-400 hover:text-gray-600 dark:hover:text-slate-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="p-6">
                    <!-- Cover Image -->
                    <x-ui.banner :user="$selectedUser" height="h-24" />
                    
                    <!-- Avatar -->
                    <div class="relative -mt-16 mb-4">
                        <x-ui.avatar :user="$selectedUser" size="2xl" class="ring-4 rounded-full ring-white dark:ring-slate-800" />
                    </div>

                    <!-- User Info -->
                    <div class="text-center mb-6">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-slate-100 mb-1">{{ $selectedUser->name }}</h4>
                        <p class="text-gray-500 dark:text-slate-400 text-sm">{{ $selectedUser->email }}</p>
                        
                        @if($selectedUser->organization_name)
                            <div class="flex items-center justify-center gap-2 mt-2 text-gray-600 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="text-sm">{{ $selectedUser->organization_name }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Skills -->
                    @if($allSkills && $allSkills->count() > 0)
                        <div class="mb-4">
                            <h5 class="text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Keahlian</h5>
                            <div class="flex flex-wrap gap-2">
                                @foreach($allSkills->take(5) as $skillData)
                                    @if($skillData->custom_name)
                                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs rounded-full">
                                            {{ $skillData->custom_name }}
                                            <span class="ml-1 text-xs opacity-75">(Custom)</span>
                                        </span>
                                    @else
                                        @php
                                            $skill = $selectedUser->profile->skills->firstWhere('id', $skillData->skill_id);
                                        @endphp
                                        @if($skill && $skill->name)
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs rounded-full">
                                                {{ $skill->name }}
                                            </span>
                                        @endif
                                    @endif
                                @endforeach
                                @if($allSkills->count() > 5)
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 text-xs rounded-full">
                                        +{{ $allSkills->count() - 5 }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Interests -->
                    @if($allInterests && $allInterests->count() > 0)
                        <div class="mb-6">
                            <h5 class="text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Minat</h5>
                            <div class="flex flex-wrap gap-2">
                                @foreach($allInterests->take(5) as $interestData)
                                    @if($interestData->custom_name)
                                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-xs rounded-full">
                                            {{ $interestData->custom_name }}
                                            <span class="ml-1 text-xs opacity-75">(Custom)</span>
                                        </span>
                                    @else
                                        @php
                                            $interest = $selectedUser->profile->interests->firstWhere('id', $interestData->interest_id);
                                        @endphp
                                        @if($interest && $interest->name)
                                            <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-xs rounded-full">
                                                {{ $interest->name }}
                                            </span>
                                        @endif
                                    @endif
                                @endforeach
                                @if($allInterests->count() > 5)
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 text-xs rounded-full">
                                        +{{ $allInterests->count() - 5 }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Vision -->
                    @if($selectedUser->profile?->vision)
                        <div class="mb-6">
                            <h5 class="text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Visi</h5>
                            <p class="text-sm text-gray-600 dark:text-slate-400 bg-gray-50 dark:bg-slate-700 p-3 rounded-lg">
                                {{ $selectedUser->profile->vision }}
                            </p>
                        </div>
                    @endif

                    <!-- View Full Profile Button -->
                    <div class="border-t border-gray-100 dark:border-slate-700 pt-4 mb-4">
                        <a href="{{ route('profile.view', $selectedUser->id) }}" 
                           class="w-full py-3 px-4 bg-gray-600 hover:bg-gray-700 dark:bg-slate-600 dark:hover:bg-slate-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Profile Lengkap
                        </a>
                    </div>

                    <!-- Connection Status & Actions -->
                    <div class="border-t border-gray-100 dark:border-slate-700 pt-4">
                        @if(!$connectionsEnabled && !$isSuperAdmin)
                            <button disabled 
                                    class="w-full py-3 px-4 bg-gray-400 dark:bg-slate-600 text-white text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Fitur Koneksi Dinonaktifkan
                            </button>
                        @elseif($connectionStatus === 'not_connected')
                            <button wire:click="connect({{ $selectedUser->id }})" 
                                    class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Koneksi
                            </button>
                        @elseif($connectionStatus === 'pending_sent')
                            <button disabled 
                                    class="w-full py-3 px-4 bg-gray-400 dark:bg-slate-600 text-white text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Menunggu Konfirmasi
                            </button>
                        @elseif($connectionStatus === 'pending_received')
                            <div class="space-y-2">
                                <button wire:click="acceptConnection({{ $selectedUser->id }})" 
                                        class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Terima Permintaan
                                </button>
                                <button wire:click="rejectConnection({{ $selectedUser->id }})" 
                                        class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Tolak Permintaan
                                </button>
                            </div>
                        @elseif($connectionStatus === 'connected')
                            <div class="space-y-2">
                                @if($collaborationsEnabled || $isSuperAdmin)
                                    <button wire:click="startCollaboration({{ $selectedUser->id }})" 
                                            class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Mulai Kolaborasi
                                    </button>
                                @else
                                    <button disabled 
                                            class="w-full py-3 px-4 bg-gray-400 dark:bg-slate-600 text-white text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        Kolaborasi Dinonaktifkan
                                    </button>
                                @endif
                                <button wire:click="disconnect({{ $selectedUser->id }})" 
                                        class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Putuskan Koneksi
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
