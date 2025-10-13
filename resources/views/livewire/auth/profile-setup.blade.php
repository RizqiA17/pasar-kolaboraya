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
            <div class="bg-primary-blue dark:bg-neutral-green h-2 rounded-full transition-all duration-300"
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
        @if ($hasChanges)
            <div
                class="absolute top-4 right-4 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 px-3 py-1 rounded-full text-xs font-medium">
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

                <flux:textarea wire:model="vision" rows="4" :label="'Visi/Misi'"
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
                                            <span class="text-sm text-slate-600 dark:text-slate-400">Gunakan Custom Link</span>
                                        </label>
                                    </div>
                                    
                                    <!-- Single Input Field - Saling Mengganti -->
                                    <div>
                                        @if($item['use_custom_link'] ?? false)
                                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-2">Custom Link</label>
                                            <input type="url" wire:model="socialMediaItems.{{ $index }}.custom_link"
                                                   placeholder="{{ $this->getPlaceholderForPlatform($item['platform'] ?? '', true) }}"
                                                   class="w-full px-3 py-2 text-sm bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md text-slate-700 dark:text-slate-300 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        @else
                                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-2">Username</label>
                                            <input type="text" wire:model="socialMediaItems.{{ $index }}.username"
                                                   placeholder="{{ $this->getPlaceholderForPlatform($item['platform'] ?? '', false) }}"
                                                   class="w-full px-3 py-2 text-sm bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md text-slate-700 dark:text-slate-300 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Platform Selection Dropdown -->
                    @if ($showPlatformModal)
                        <div class="relative platform-selection-container">
                            <div
                                class="absolute top-0 left-0 right-0 z-10 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg mt-2">
                                <div class="p-4">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-3">Pilih Platform Media Sosial</h3>
                                    <div class="grid min-[416px]:grid-cols-2 gap-2">
                                        @foreach ($this->getAvailablePlatforms() as $platform)
                                            <button type="button"
                                                wire:click="selectPlatform('{{ $platform['value'] }}')"
                                                class="platform-option flex items-center space-x-2 p-2 text-left border border-slate-200 dark:border-slate-600 rounded-md hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                                <div class="w-4 h-4 flex items-center justify-center">
                                                    {!! $platform['icon'] !!}
                                                </div>
                                                <span
                                                    class="text-xs font-medium text-slate-700 dark:text-slate-300">{{ $platform['label'] }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Add Social Media Button -->
                    <button type="button" wire:click="showPlatformSelection"
                        class="add-social-media-btn w-full flex items-center justify-center space-x-2 px-4 py-3 bg-slate-100 dark:bg-slate-800 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:border-slate-400 dark:hover:border-slate-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="font-medium max-md:hidden">Tambah Media Sosial</span>
                        <span class="font-medium md:hidden">Tambah Medsos</span>
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
                    <div x-data="{
                        open: false,
                        search: '',
                        selectedItems: @entangle('selectedSkills').live,
                        mainInput: '',
                        isProcessing: false,
                        updateMainInput() {
                            this.mainInput = this.selectedItems.map(id =>
                                document.getElementById('skill_label_' + id)?.textContent || ''
                            ).filter(Boolean).join(', ');
                        },
                        async toggleItem(id) {
                            if (this.isProcessing) return;
                            this.isProcessing = true;
                            try {
                                await $wire.toggleSkill(id);
                                this.updateMainInput();
                            } finally {
                                this.isProcessing = false;
                            }
                        }
                    }" x-init="updateMainInput()" @click.away="open = false"
                        class="multi-select-container relative">
                        <!-- Main Selector Input -->
                        <div class="relative">
                            <input type="text" x-model="mainInput" placeholder="Pilih keahlian Anda..."
                                class="w-full pl-10 pr-12 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 cursor-pointer transition-all duration-200"
                                readonly @click="open = !open">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Dropdown Panel -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="absolute left-0 right-0 z-10 mt-2">
                            <!-- Search Input -->
                            <div class="relative">
                            <input type="text" wire:model.live="skillSearch" placeholder="Cari keahlian..."
                                    class="w-full pl-10 pr-4 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all duration-200 shadow-sm"
                                    @click.stop>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                        </div>

                        <!-- Dropdown List -->
                            <div
                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            @foreach ($this->getFilteredSkills() as $skill)
                                    <div class="multi-option {{ in_array($skill->id, is_array($selectedSkills) ? $selectedSkills : []) ? 'bg-purple-50 dark:bg-purple-900/20' : '' }} px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-all duration-200"
                                        @click.stop="toggleItem({{ $skill->id }})">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                                <div class="flex items-center justify-center w-5 h-5">
                                            <input type="checkbox" id="skill_{{ $skill->id }}"
                                                            :checked="selectedItems.includes({{ $skill->id }})"
                                                            @click.stop="toggleItem({{ $skill->id }})"
                                                            class="h-4 w-4 text-purple-600 focus:ring-2 focus:ring-purple-500/20 border-gray-300 dark:border-gray-600 rounded transition-colors duration-200">
                                                </div>
                                                <div>
                                                    <span id="skill_label_{{ $skill->id }}"
                                                        class="font-medium text-gray-700 dark:text-gray-300">{{ $skill->name }}</span>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                        Pilih untuk menambahkan ke profil Anda</p>
                                                </div>
                                            </div>
                                                <div class="flex items-center"
                                                    x-show="selectedItems.includes({{ $skill->id }})">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                                    Terpilih
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                                @if ($this->getFilteredSkills()->isEmpty())
                                    <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                                        Tidak ada hasil yang ditemukan
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Selected Skills Display -->
                @if (count($selectedSkills) > 0)
                    <div class="mb-4">
                        <div class="flex flex-wrap gap-2">
                            @foreach ($selectedSkills as $skillId)
                                @php
                                    $skill = $skills->firstWhere('id', $skillId);
                                @endphp
                                @if ($skill)
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 dark:bg-purple-900/20 text-purple-800 dark:text-purple-200 border border-purple-200 dark:border-purple-700">
                                        <span>{{ $skill->name }}</span>
                                        <button type="button" wire:click="removeSkill({{ $skillId }})"
                                            class="ml-2 text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Custom Skills Input -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-slate-300">Keahlian Kustom</h4>
                        <button type="button" wire:click="addCustomSkill"
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 border border-purple-200 dark:border-purple-700 rounded-md hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
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
                                    class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-md focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-slate-300">
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
                    <div x-data="{
                        open: false,
                        search: '',
                        selectedItems: @entangle('selectedInterests').live,
                        mainInput: '',
                        isProcessing: false,
                        updateMainInput() {
                            this.mainInput = this.selectedItems.map(id =>
                                document.getElementById('interest_label_' + id)?.textContent || ''
                            ).filter(Boolean).join(', ');
                        },
                        async toggleItem(id) {
                            if (this.isProcessing) return;
                            this.isProcessing = true;
                            try {
                                await $wire.toggleInterest(id);
                                this.updateMainInput();
                            } finally {
                                this.isProcessing = false;
                            }
                        }
                    }" x-init="updateMainInput()" @click.away="open = false"
                        class="multi-select-container relative">
                            <!-- Main Selector Input -->
                            <div class="relative">
                                <input type="text" x-model="mainInput" placeholder="Pilih minat Anda..."
                                    class="w-full pl-10 pr-12 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 cursor-pointer transition-all duration-200"
                                    readonly @click="open = !open">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Dropdown Panel -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="absolute left-0 right-0 z-10 mt-2">
                                <!-- Search Input -->
                                <div class="relative">
                                <input type="text" wire:model.live="interestSearch" placeholder="Cari minat..."
                                        class="w-full pl-10 pr-4 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 shadow-sm"
                                        @click.stop>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                            </div>

                            <!-- Dropdown List -->
                                <div
                                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @foreach ($this->getFilteredInterests() as $interest)
                                        <div class="multi-option {{ in_array($interest->id, is_array($selectedInterests) ? $selectedInterests : []) ? 'bg-orange-50 dark:bg-orange-900/20' : '' }} px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-all duration-200"
                                            @click.stop="toggleItem({{ $interest->id }})">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center justify-center w-5 h-5">
                                                <input type="checkbox" id="interest_{{ $interest->id }}"
                                                            :checked="selectedItems.includes({{ $interest->id }})"
                                                            @click.stop="toggleItem({{ $interest->id }})"
                                                            class="h-4 w-4 text-orange-600 focus:ring-2 focus:ring-orange-500/20 border-gray-300 dark:border-gray-600 rounded transition-colors duration-200">
                                                </div>
                                                    <div>
                                                        <span id="interest_label_{{ $interest->id }}"
                                                            class="font-medium text-gray-700 dark:text-gray-300">{{ $interest->name }}</span>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                            Pilih untuk menambahkan ke profil Anda</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center"
                                                    x-show="selectedItems.includes({{ $interest->id }})">
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300">
                                                        Terpilih
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    @if ($this->getFilteredInterests()->isEmpty())
                                        <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                                            Tidak ada hasil yang ditemukan
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Interests Display -->
                    @if (count($selectedInterests) > 0)
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach ($selectedInterests as $interestId)
                                    @php
                                        $interest = $interests->firstWhere('id', $interestId);
                                    @endphp
                                    @if ($interest)
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 dark:bg-orange-900/20 text-orange-800 dark:text-orange-200 border border-orange-200 dark:border-orange-700">
                                            <span>{{ $interest->name }}</span>
                                            <button type="button" wire:click="removeInterest({{ $interestId }})"
                                                class="ml-2 text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-200">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Custom Interests Input -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-slate-300">Minat Kustom</h4>
                            <button type="button" wire:click="addCustomInterest"
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 border border-orange-200 dark:border-orange-700 rounded-md hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors">
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
                                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-md focus:ring-orange-500 focus:border-orange-500 dark:bg-slate-700 dark:text-slate-300">
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
        @endif

        <!-- Navigation Buttons -->
        <div
            class="grid grid-cols-3 items-center gap-2 justify-between mt-8 pt-6 border-t border-gray-200 dark:border-slate-600">
            <div class="col-span-1 px-1 w-full">
                @if ($currentStep > 1)
                    <flux:button wire:click="previousStep" class="w-full" variant="subtle" icon="chevron-left">
                        <p class="max-md:hidden">Kembali</p>
                    </flux:button>
                @endif
            </div>


            <div class="grid grid-cols-2 col-span-2 items-center gap-2 space-x-3">
                @if ($currentStep < $totalSteps)
                    <flux:button wire:click="skipStep" variant="subtle" class="col-span-1 w-full">
                        Skip
                    </flux:button>

                    <flux:button wire:click="nextStep" variant="primary" icon:trailing="chevron-right"
                        class="col-span-1 w-full">
                        <p class="max-md:hidden">Lanjut</p>
                    </flux:button>
                @else
                    <flux:button wire:click="saveProfile" variant="primary" class="w-full sm:w-auto col-span-2"
                        icon:trailing="check">
                        <p class="">Selesai</p>
                    </flux:button>
                @endif
            </div>
        </div>

        <div class="w-full mt-4">
            <flux:button wire:click="skipAllSteps" variant="subtle"
                class="w-full text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300">
                <p class="">Lengkapi Nanti</p>
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
        /* Multi-Select Styling */
        .multi-select-container {
            position: relative;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .multi-select-container input {
            background: white;
            border: 2px solid #d1d5db;
            color: #374151;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .dark .multi-select-container input {
            background: #1e293b;
            border: 2px solid #8b5cf6;
            color: white;
        }

        .multi-select-container input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .multi-select-container input::placeholder {
            color: #9ca3af;
        }

        .dark .multi-select-container input::placeholder {
            color: #94a3b8;
        }

        .multi-dropdown {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-height: 240px;
            overflow-y: auto;
            z-index: 1000;
        }

        .dark .multi-dropdown {
            background: #1e293b;
            border: 1px solid #475569;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .multi-option {
            padding: 12px 16px;
            color: #374151;
            cursor: pointer;
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #e5e7eb;
        }

        .dark .multi-option {
            color: white;
            border-bottom: 1px solid #334155;
        }

        .multi-option:hover {
            background-color: #f3f4f6;
        }

        .dark .multi-option:hover {
            background-color: #334155;
        }

        .multi-option.selected {
            background-color: #ede9fe;
            color: #8b5cf6;
        }

        .dark .multi-option.selected {
            background-color: #8b5cf6;
            color: white;
        }

        .multi-option:last-child {
            border-bottom: none;
        }

        .multi-search-input {
            background: #f9fafb;
            border: 1px solid #d1d5db;
            color: #374151;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 14px;
            margin-top: 8px;
        }

        .dark .multi-search-input {
            background: #334155;
            border: 1px solid #475569;
            color: white;
        }

        .multi-search-input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.1);
        }

        .multi-search-input::placeholder {
            color: #9ca3af;
        }

        .dark .multi-search-input::placeholder {
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
            background: #f1f5f9;
        }

        .dark .role-dropdown::-webkit-scrollbar-track,
        .dark .multi-dropdown::-webkit-scrollbar-track {
            background: #1e293b;
        }

        .role-dropdown::-webkit-scrollbar-thumb,
        .multi-dropdown::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .dark .role-dropdown::-webkit-scrollbar-thumb,
        .dark .multi-dropdown::-webkit-scrollbar-thumb {
            background: #475569;
        }

        .role-dropdown::-webkit-scrollbar-thumb:hover,
        .multi-dropdown::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark .role-dropdown::-webkit-scrollbar-thumb:hover,
        .dark .multi-dropdown::-webkit-scrollbar-thumb:hover {
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
        // Platform selection dropdown close handler
        document.addEventListener('click', function(event) {
            // Platform selection dropdown
            const platformSelectionContainer = document.querySelector('.platform-selection-container');
            if (platformSelectionContainer && !platformSelectionContainer.contains(event.target)) {
                @this.call('closePlatformModal');
            }
        });
    </script>

</div>
