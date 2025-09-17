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

                <flux:input wire:model="socialMedia.linkedin" :label="'LinkedIn'" type="url"
                    :placeholder="'https://linkedin.com/in/username'" />

                <flux:input wire:model="socialMedia.twitter" :label="'Twitter/X'" type="url"
                    :placeholder="'https://twitter.com/username'" />

                <flux:input wire:model="socialMedia.instagram" :label="'Instagram'" type="url"
                    :placeholder="'https://instagram.com/username'" />

                <flux:input wire:model="socialMedia.facebook" :label="'Facebook'" type="url"
                    :placeholder="'https://facebook.com/username'" />

                <flux:input wire:model="socialMedia.website" :label="'Website Pribadi'" type="url"
                    :placeholder="'https://website.com'" />
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

                <div class="space-y-4">
                    @foreach ($skills as $skill)
                        <div
                            class="flex items-center space-x-3 p-3 border border-gray-200 dark:border-slate-600 rounded-lg">
                            <input type="checkbox" id="skill_{{ $skill->id }}" wire:model="selectedSkills"
                                value="{{ $skill->id }}"
                                class="rounded border-gray-300 dark:border-slate-600 dark:bg-slate-700 text-blue-600 dark:text-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400">
                            <label for="skill_{{ $skill->id }}"
                                class="flex-1 text-sm font-medium text-gray-700 dark:text-slate-300">
                                {{ $skill->name }}
                            </label>

                            {{-- @if (in_array($skill->id, $selectedSkills))
                                <div class="flex items-center space-x-2">
                                    <select wire:model="skillLevels.{{ $skill->id }}"
                                        class="text-xs border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                        <option value="beginner">Pemula</option>
                                        <option value="intermediate">Menengah</option>
                                        <option value="advanced">Lanjutan</option>
                                        <option value="expert">Ahli</option>
                                    </select>

                                    <label class="flex items-center space-x-1">
                                        <input type="checkbox" wire:model="primarySkills" value="{{ $skill->id }}"
                                            class="rounded border-gray-300 dark:border-slate-600 dark:bg-slate-700 text-blue-600 dark:text-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400">
                                        <span class="text-xs text-gray-600">Utama</span>
                                    </label>
                                </div>
                            @endif --}}
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

                <!-- Interests -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-slate-100 mb-3">Minat</h4>
                    <div class="space-y-3">
                        @foreach ($interests as $interest)
                            <div
                                class="flex items-center space-x-3 p-3 border border-gray-200 dark:border-slate-600 rounded-lg">
                                <input type="checkbox" id="interest_{{ $interest->id }}" wire:model="selectedInterests"
                                    value="{{ $interest->id }}"
                                    class="rounded border-gray-300 dark:border-slate-600 dark:bg-slate-700 text-blue-600 dark:text-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400">
                                <label for="interest_{{ $interest->id }}"
                                    class="flex-1 text-sm font-medium text-gray-700 dark:text-slate-300">
                                    {{ $interest->name }}
                                </label>
                                {{-- 
                                @if (in_array($interest->id, $selectedInterests))
                                    <select wire:model="interestLevels.{{ $interest->id }}"
                                        class="text-xs border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                        <option value="low">Rendah</option>
                                        <option value="medium">Sedang</option>
                                        <option value="high">Tinggi</option>
                                    </select>
                                @endif --}}
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
            <div class="col-span-1">
                @if ($currentStep > 1)
                    <flux:button wire:click="previousStep" variant="subtle" icon="chevron-left">
                        <p class="max-md:hidden">Sebelumnya</p>
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
                        <p class="max-md:hidden">Selanjutnya</p>
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

        /* Scrollbar styling */
        .role-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .role-dropdown::-webkit-scrollbar-track {
            background: #1e293b;
        }

        .role-dropdown::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 3px;
        }

        .role-dropdown::-webkit-scrollbar-thumb:hover {
            background: #64748b;
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
    </script>

</div>
