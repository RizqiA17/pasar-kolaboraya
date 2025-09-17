<div class="flex flex-col gap-6 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="center-right" size="w-12 h-12" opacity="opacity-10" />
    <x-svg-accent position="bottom-right" size="w-14 h-14" opacity="opacity-10" />
    
    <x-auth-header :title="'Lengkapi Profil Anda'" :description="'Bantu kami mengenal Anda lebih baik untuk pengalaman yang lebih personal'" />

    <!-- Progress Bar -->
    <div class="w-full">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700 dark:text-slate-300">Langkah {{ $currentStep }} dari
                {{ $totalSteps }}</span>
            <span class="text-sm font-medium text-gray-700 dark:text-slate-300">{{ $progress }}%</span>
        </div>
        <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
            <div class="bg-blue-600 dark:bg-blue-500 h-2 rounded-full transition-all duration-300"
                style="width: {{ $progress }}%">
            </div>
        </div>
    </div>

    <!-- Step Content -->
    <div
        class="bg-white dark:bg-slate-800 rounded-lg shadow-sm dark:shadow-slate-900/50 border border-gray-200 dark:border-slate-700 p-6 relative">
        <!-- SVG Accent for Step Content -->
        <x-svg-accent position="top-right" size="w-8 h-8" opacity="opacity-5" />
        
        <!-- Data Saved Indicator -->
        @if($hasChanges)
            <div class="absolute top-4 right-4 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 px-3 py-1 rounded-full text-xs font-medium">
                Ada perubahan data
            </div>
        @endif
        
        @if ($currentStep === 1)
            <!-- Step 1: Basic Information -->
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900/50 mb-4">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-2">Informasi Dasar</h3>
                    <p class="text-sm text-gray-600 dark:text-slate-400">Berikan informasi dasar tentang diri Anda</p>
                </div>

                <flux:input wire:model="organization" :label="'Organisasi/Perusahaan'" type="text"
                    :placeholder="'Nama organisasi atau perusahaan Anda'" />

                <flux:input wire:model="phone" :label="'Nomor Telepon'" type="tel"
                    :placeholder="'0812-3456-7890'" />

                <flux:textarea wire:model="vision" rows="2" :label="'Visi/Misi'"
                    :placeholder="'Ceritakan visi dan misi Anda'" />
            </div>
        @elseif($currentStep === 2)
            <!-- Step 2: Social Media -->
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/50 mb-4">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-2">Media Sosial</h3>
                    <p class="text-sm text-gray-600 dark:text-slate-400">Bagikan link media sosial Anda (opsional)</p>
                </div>

                <!-- Social Media List -->
                <div class="space-y-4">
                    <div class="text-sm font-medium text-gray-700 dark:text-slate-300 mb-3">Media Sosial</div>
                    
                    <!-- Existing Social Media Items -->
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
                                    <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.004 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.418-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.244c-.875.807-2.026 1.297-3.323 1.297zm7.718-1.297c-.875.807-2.026 1.297-3.323 1.297s-2.448-.49-3.323-1.297c-.928-.875-1.418-2.026-1.418-3.323s.49-2.448 1.418-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.244z"/>
                                    </svg>
                                @elseif($item['type'] === 'facebook')
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                @elseif($item['type'] === 'youtube')
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
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
                                       class="w-full px-12 py-4 m-0 text-sm bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md text-slate-700 dark:text-slate-300 placeholder-slate-400 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            
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
                        <div class="relative platform-selection-container">
                            <div class="absolute top-0 left-0 right-0 z-10 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg mt-2">
                                <div class="p-4">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-3">Pilih Platform Media Sosial</h3>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach($this->getAvailablePlatforms() as $platform)
                                            <button type="button" 
                                                    wire:click="selectPlatform('{{ $platform['value'] }}')"
                                                    class="platform-option flex items-center space-x-2 p-2 text-left border border-slate-200 dark:border-slate-600 rounded-md hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
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
        @elseif($currentStep === 3)
            <!-- Step 3: Skills -->
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 dark:bg-purple-900/50 mb-4">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-2">Keahlian</h3>
                    <p class="text-sm text-gray-600 dark:text-slate-400">Pilih keahlian yang Anda miliki</p>
                </div>

                <!-- Skills Multi-Select -->
                <div class="mb-6">
                    <div class="multi-select-container">
                        <!-- Main Selector Input -->
                        <div class="relative">
                            <input type="text" 
                                   id="skillsMainInput"
                                   placeholder="Pilih keahlian Anda..." 
                                   class="w-full"
                                   readonly
                                   onclick="toggleSkillsDropdown()">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Search Input (Shows when dropdown is open) -->
                        <div id="skillsSearchInput" class="hidden mt-2">
                            <input type="text" 
                                   wire:model.live="skillSearch" 
                                   placeholder="Cari keahlian..." 
                                   class="multi-search-input w-full">
                        </div>

                        <!-- Dropdown List -->
                        <div id="skillsDropdown" class="hidden absolute z-10 w-full mt-1 multi-dropdown">
                            @foreach($this->getFilteredSkills() as $skill)
                                <div class="multi-option {{ in_array($skill->id, $selectedSkills) ? 'selected' : '' }}"
                                     wire:click="toggleSkill({{ $skill->id }})"
                                     onclick="toggleSkillAndUpdate({{ $skill->id }}, '{{ $skill->name }}')">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <input type="checkbox" 
                                                   id="skill_{{ $skill->id }}" 
                                                   wire:model="selectedSkills" 
                                value="{{ $skill->id }}"
                                                   class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-slate-600 bg-slate-700">
                                            <span class="font-medium">{{ $skill->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Selected Skills Display -->
                @if(count($selectedSkills) > 0)
                    <div class="mb-4">
                        <div class="flex flex-wrap gap-2">
                            @foreach($selectedSkills as $skillId)
                                @php
                                    $skill = $skills->firstWhere('id', $skillId);
                                @endphp
                                @if($skill)
                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 dark:bg-purple-900/20 text-purple-800 dark:text-purple-200 border border-purple-200 dark:border-purple-700">
                                        <span>{{ $skill->name }}</span>
                                        <button type="button" 
                                                wire:click="removeSkill({{ $skillId }})"
                                                class="ml-2 text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @elseif($currentStep === 4)
            <!-- Step 4: Interests & Contributions -->
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 dark:bg-orange-900/50 mb-4">
                        <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-2">Minat</h3>
                    <p class="text-sm text-gray-600 dark:text-slate-400">Pilih minat Anda</p>
                </div>

                <!-- Interests Multi-Select -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-slate-100 mb-3">Minat</h4>
                    <div class="mb-6">
                        <div class="multi-select-container">
                            <!-- Main Selector Input -->
                            <div class="relative">
                                <input type="text" 
                                       id="interestsMainInput"
                                       placeholder="Pilih minat Anda..." 
                                       class="w-full"
                                       readonly
                                       onclick="toggleInterestsDropdown()">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Search Input (Shows when dropdown is open) -->
                            <div id="interestsSearchInput" class="hidden mt-2">
                                <input type="text" 
                                       wire:model.live="interestSearch" 
                                       placeholder="Cari minat..." 
                                       class="multi-search-input w-full">
                            </div>

                            <!-- Dropdown List -->
                            <div id="interestsDropdown" class="hidden absolute z-10 w-full mt-1 multi-dropdown">
                                @foreach($this->getFilteredInterests() as $interest)
                                    <div class="multi-option {{ in_array($interest->id, $selectedInterests) ? 'selected' : '' }}"
                                         wire:click="toggleInterest({{ $interest->id }})"
                                         onclick="toggleInterestAndUpdate({{ $interest->id }}, '{{ $interest->name }}')">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <input type="checkbox" 
                                                       id="interest_{{ $interest->id }}" 
                                                       wire:model="selectedInterests" 
                                                       value="{{ $interest->id }}"
                                                       class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-slate-600 bg-slate-700">
                                                <span class="font-medium">{{ $interest->name }}</span>
                                            </div>
                                        </div>
                            </div>
                        @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Selected Interests Display -->
                    @if(count($selectedInterests) > 0)
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedInterests as $interestId)
                                    @php
                                        $interest = $interests->firstWhere('id', $interestId);
                                    @endphp
                                    @if($interest)
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 dark:bg-orange-900/20 text-orange-800 dark:text-orange-200 border border-orange-200 dark:border-orange-700">
                                            <span>{{ $interest->name }}</span>
                                            <button type="button" 
                                                    wire:click="removeInterest({{ $interestId }})"
                                                    class="ml-2 text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-200">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Contributions -->
                {{-- <div>
                    <h4 class="text-md font-medium text-gray-900 mb-3">Kontribusi</h4>
                    <div class="space-y-3">
                        @foreach ($contributions as $contribution)
                            <div class="flex items-center space-x-3 p-3 border border-gray-200 dark:border-slate-600 rounded-lg">
                                <input type="checkbox" id="contribution_{{ $contribution->id }}"
                                    wire:model="selectedContributions" value="{{ $contribution->id }}"
                                    class="rounded border-gray-300 dark:border-slate-600 dark:bg-slate-700 text-blue-600 dark:text-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400">
                                <label for="contribution_{{ $contribution->id }}"
                                    class="flex-1 text-sm font-medium text-gray-700">
                                    {{ $contribution->name }}
                                </label> --}}

                                {{-- @if (in_array($contribution->id, $selectedContributions))
                                    <div class="flex flex-col space-y-2">
                                        <input type="text"
                                            wire:model="contributionDescriptions.{{ $contribution->id }}"
                                            placeholder="Deskripsi kontribusi"
                                            class="text-xs border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                        <input type="date" wire:model="contributionDates.{{ $contribution->id }}"
                                            class="text-xs border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                @endif --}}
                            {{-- </div>
                        @endforeach
                    </div>
                </div> --}}
            </div>
        @elseif($currentStep === 5)
            <!-- Step 5: Role Selection -->
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900/50 mb-4">
                        <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-2">Pilih Peran Anda</h3>
                    <p class="text-sm text-gray-600 dark:text-slate-400">Pilih peran yang paling sesuai dengan Anda</p>
                </div>

                <!-- Role Search Selector -->
                <div class="mb-6">
                    <div class="role-selector">
                        <!-- Main Selector Input -->
                        <div class="relative">
                            <input type="text" id="roleMainInput" placeholder="Select value" class="w-full"
                                readonly onclick="toggleRoleDropdown()">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Search Input (Shows when dropdown is open) -->
                        <div id="roleSearchInput" class="hidden">
                            <input type="text" wire:model.live="roleSearch" placeholder="Cari peran..."
                                class="role-search-input w-full">
                        </div>

                        <!-- Dropdown List -->
                        <div id="roleDropdown" class="hidden absolute z-10 w-full mt-1 role-dropdown">
                            @foreach ($this->getFilteredRoles() as $role)
                                <div class="role-option {{ $selectedRole == $role->id ? 'selected' : '' }}"
                                    wire:click="selectRole({{ $role->id }})"
                                    onclick="selectRoleAndClose({{ $role->id }}, '{{ $role->nama }}')">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <span class="font-medium">{{ $role->nama }}</span>
                                        </div>
                                        <div class="relative group">
                                            <button type="button" class="role-info-btn"
                                                onmouseenter="showRoleDetail({{ $role->id }})"
                                                onmouseleave="hideRoleDetail()">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <!-- Detail Tooltip -->
                                            <div id="roleDetail_{{ $role->id }}"
                                                class="hidden absolute right-0 top-6 role-tooltip">
                                                <div class="text-sm w-64">
                                                    <div class="font-semibold text-white mb-2">{{ $role->nama }}
                                                    </div>
                                                    <div class="text-slate-300 leading-relaxed">{{ $role->deskripsi }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Selected Role Display -->
                @if ($selectedRole)
                    @php
                        $selectedRoleData = $this->peran->firstWhere('id', $selectedRole);
                    @endphp
                    @if ($selectedRoleData)
                        <div
                            class="mb-4 p-4 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-700 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 bg-purple-100 dark:bg-purple-900/50 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-purple-900 dark:text-purple-100">
                                        {{ $selectedRoleData->nama }}</div>
                                    <div class="text-sm text-purple-700 dark:text-purple-300">
                                        {{ Str::limit($selectedRoleData->deskripsi, 100) }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                @error('selectedRole')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        @endif

        <!-- Navigation Buttons -->
        <div
            class="grid grid-cols-3 items-center justify-between mt-8 pt-6 border-t border-gray-200 dark:border-slate-600">
            <div class="col-span-1 px-1">
                @if ($currentStep > 1)
                    <flux:button wire:click="previousStep" variant="subtle" icon="chevron-left">
                        <p class="max-md:hidden">Kembali</p>
                    </flux:button>
                @endif
            </div>


            <div class="grid grid-cols-2 col-span-2 items-center space-x-3">
                @if ($currentStep < $totalSteps)
                    <flux:button wire:click="skipStep" variant="subtle" class="col-span-1">
                        Skip
                    </flux:button>

                    <flux:button wire:click="nextStep" variant="primary" icon:trailing="chevron-right"
                        class="col-span-1">
                        <p class="max-md:hidden">Lanjut</p>
                    </flux:button>
                @else
                    <div class="col-span-1"></div>
                        <flux:button wire:click="saveProfile" variant="primary" class="w-full sm:w-auto col-span-1"
                            icon:trailing="chevron-right">
                            <p class="max-md:hidden">Selesai</p>
                        </flux:button>
                @endif
            </div>
        </div>
        
        <div class="w-full mt-4">
            <flux:button wire:click="skipAllSteps" variant="subtle" class="w-full text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300">
                <p class="max-md:hidden">Lengkapi Nanti</p>
            </flux:button>
        </div>
    </div>

    <!-- Completion Percentage -->
    <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400 dark:text-blue-300" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Kelengkapan Profil</h3>
                <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                    <p>Profil Anda sudah <strong>{{ $completionPercentage }}%</strong> lengkap</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Select2-like styling */
        .role-selector {
            position: relative;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .role-selector input {
            background: #1e293b;
            border: 2px solid #8b5cf6;
            color: white;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .role-selector input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .role-selector input::placeholder {
            color: #94a3b8;
        }

        .role-dropdown {
            background: #1e293b;
            border: 1px solid #475569;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            max-height: 240px;
            overflow-y: auto;
            z-index: 1000;
        }

        .role-option {
            padding: 12px 16px;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #334155;
        }

        .role-option:hover {
            background-color: #334155;
        }

        .role-option.selected {
            background-color: #8b5cf6;
        }

        .role-option:last-child {
            border-bottom: none;
        }

        .role-info-btn {
            color: #94a3b8;
            padding: 4px;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .role-info-btn:hover {
            color: white;
            background-color: #475569;
        }

        .role-tooltip {
            background: #0f172a;
            border: 1px solid #475569;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            padding: 16px;
            max-width: 320px;
            z-index: 1001;
        }

        .role-tooltip::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 16px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid #0f172a;
        }

        .role-search-input {
            background: #334155;
            border: 1px solid #475569;
            color: white;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 14px;
            margin-top: 8px;
        }

        .role-search-input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.1);
        }

        .role-search-input::placeholder {
            color: #94a3b8;
        }

        /* Multi-Select Styling */
        .multi-select-container {
            position: relative;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .multi-select-container input {
            background: #1e293b;
            border: 2px solid #8b5cf6;
            color: white;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .multi-select-container input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .multi-select-container input::placeholder {
            color: #94a3b8;
        }

        .multi-dropdown {
            background: #1e293b;
            border: 1px solid #475569;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            max-height: 240px;
            overflow-y: auto;
            z-index: 1000;
        }

        .multi-option {
            padding: 12px 16px;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #334155;
        }

        .multi-option:hover {
            background-color: #334155;
        }

        .multi-option.selected {
            background-color: #8b5cf6;
        }

        .multi-option:last-child {
            border-bottom: none;
        }

        .multi-search-input {
            background: #334155;
            border: 1px solid #475569;
            color: white;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 14px;
            margin-top: 8px;
        }

        .multi-search-input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.1);
        }

        .multi-search-input::placeholder {
            color: #94a3b8;
        }

        /* Selected Items Display */
        .selected-item {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            margin: 2px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .selected-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .selected-item button {
            margin-left: 6px;
            padding: 2px;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .selected-item button:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        /* Scrollbar styling */
        .role-dropdown::-webkit-scrollbar,
        .multi-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .role-dropdown::-webkit-scrollbar-track,
        .multi-dropdown::-webkit-scrollbar-track {
            background: #1e293b;
        }

        .role-dropdown::-webkit-scrollbar-thumb,
        .multi-dropdown::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 3px;
        }

        .role-dropdown::-webkit-scrollbar-thumb:hover,
        .multi-dropdown::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Social Media Styling */
        .social-media-item {
            transition: all 0.2s ease;
        }

        .social-media-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .social-media-item select {
            transition: all 0.2s ease;
        }

        .social-media-item select:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .social-media-item input {
            transition: all 0.2s ease;
        }

        .social-media-item input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .social-media-item button {
            transition: all 0.2s ease;
        }

        .social-media-item button:hover {
            transform: scale(1.1);
        }

        /* Add Button Styling */
        .add-social-media-btn {
            transition: all 0.2s ease;
        }

        .add-social-media-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Platform Selection Dropdown */
        .platform-selection-container {
            position: relative;
        }

        .platform-selection-container .absolute {
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .platform-option {
            transition: all 0.2s ease;
        }

        .platform-option:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dark .platform-option:hover {
            background-color: #374151;
        }
    </style>

    <script>
        // Role Selector Functions
        function toggleRoleDropdown() {
            const dropdown = document.getElementById('roleDropdown');
            const searchInput = document.getElementById('roleSearchInput');

            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                searchInput.classList.remove('hidden');
                // Focus on search input
                setTimeout(() => {
                    searchInput.querySelector('input').focus();
                }, 100);
            } else {
                dropdown.classList.add('hidden');
                searchInput.classList.add('hidden');
            }
        }

        function selectRoleAndClose(roleId, roleName) {
            // Close dropdown
            document.getElementById('roleDropdown').classList.add('hidden');
            document.getElementById('roleSearchInput').classList.add('hidden');

            // Update the main input to show selected role
            document.getElementById('roleMainInput').value = roleName;
        }

        function showRoleDetail(roleId) {
            // Hide all other tooltips
            document.querySelectorAll('[id^="roleDetail_"]').forEach(tooltip => {
                tooltip.classList.add('hidden');
            });

            // Show current tooltip
            const tooltip = document.getElementById(`roleDetail_${roleId}`);
            if (tooltip) {
                tooltip.classList.remove('hidden');
            }
        }

        function hideRoleDetail() {
            // Hide all tooltips
            document.querySelectorAll('[id^="roleDetail_"]').forEach(tooltip => {
                tooltip.classList.add('hidden');
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const roleSelector = document.querySelector('input[placeholder="Select value"]');
            if (roleSelector) {
                const roleSelectorContainer = roleSelector.closest('.relative');
                if (roleSelectorContainer && !roleSelectorContainer.contains(event.target)) {
                    document.getElementById('roleDropdown').classList.add('hidden');
                    document.getElementById('roleSearchInput').classList.add('hidden');
                }
            }
        });

        // Skills Multi-Select Functions
        function toggleSkillsDropdown() {
            const dropdown = document.getElementById('skillsDropdown');
            const searchInput = document.getElementById('skillsSearchInput');
            
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                searchInput.classList.remove('hidden');
                // Focus on search input
                setTimeout(() => {
                    searchInput.querySelector('input').focus();
                }, 100);
            } else {
                dropdown.classList.add('hidden');
                searchInput.classList.add('hidden');
            }
        }

        function toggleSkillAndUpdate(skillId, skillName) {
            // Update the main input to show selected count
            updateSkillsMainInput();
        }

        function updateSkillsMainInput() {
            const selectedCount = document.querySelectorAll('input[name="selectedSkills"]:checked').length;
            const mainInput = document.getElementById('skillsMainInput');
            
            if (selectedCount > 0) {
                mainInput.value = `${selectedCount} keahlian dipilih`;
            } else {
                mainInput.value = '';
            }
        }

        // Interests Multi-Select Functions
        function toggleInterestsDropdown() {
            const dropdown = document.getElementById('interestsDropdown');
            const searchInput = document.getElementById('interestsSearchInput');
            
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                searchInput.classList.remove('hidden');
                // Focus on search input
                setTimeout(() => {
                    searchInput.querySelector('input').focus();
                }, 100);
            } else {
                dropdown.classList.add('hidden');
                searchInput.classList.add('hidden');
            }
        }

        function toggleInterestAndUpdate(interestId, interestName) {
            // Update the main input to show selected count
            updateInterestsMainInput();
        }

        function updateInterestsMainInput() {
            const selectedCount = document.querySelectorAll('input[name="selectedInterests"]:checked').length;
            const mainInput = document.getElementById('interestsMainInput');
            
            if (selectedCount > 0) {
                mainInput.value = `${selectedCount} minat dipilih`;
            } else {
                mainInput.value = '';
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            // Role selector
            const roleSelector = document.querySelector('input[placeholder="Select value"]');
            if (roleSelector) {
                const roleSelectorContainer = roleSelector.closest('.relative');
                if (roleSelectorContainer && !roleSelectorContainer.contains(event.target)) {
                    document.getElementById('roleDropdown').classList.add('hidden');
                    document.getElementById('roleSearchInput').classList.add('hidden');
                }
            }

            // Skills selector
            const skillsSelector = document.querySelector('input[placeholder="Pilih keahlian Anda..."]');
            if (skillsSelector) {
                const skillsSelectorContainer = skillsSelector.closest('.multi-select-container');
                if (skillsSelectorContainer && !skillsSelectorContainer.contains(event.target)) {
                    document.getElementById('skillsDropdown').classList.add('hidden');
                    document.getElementById('skillsSearchInput').classList.add('hidden');
                }
            }

            // Interests selector
            const interestsSelector = document.querySelector('input[placeholder="Pilih minat Anda..."]');
            if (interestsSelector) {
                const interestsSelectorContainer = interestsSelector.closest('.multi-select-container');
                if (interestsSelectorContainer && !interestsSelectorContainer.contains(event.target)) {
                    document.getElementById('interestsDropdown').classList.add('hidden');
                    document.getElementById('interestsSearchInput').classList.add('hidden');
                }
            }

            // Platform selection dropdown
            const platformSelectionContainer = document.querySelector('.platform-selection-container');
            if (platformSelectionContainer && !platformSelectionContainer.contains(event.target)) {
                @this.call('closePlatformModal');
            }
        });
    </script>

</div>
