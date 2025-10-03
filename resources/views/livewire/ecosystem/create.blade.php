<div class="flex flex-col gap-6 relative">
    <!-- Header Section with Illustration -->
    <div class="relative">
        <!-- SVG Accent Elements with enhanced positioning and animation -->
        <div
            class="absolute top-0 right-0 -mt-8 -mr-8 transform rotate-12 transition-transform duration-500 hover:rotate-45">
            <x-svg-accent position="top-right" size="w-24 h-24" opacity="opacity-20" />
        </div>
        <div
            class="absolute bottom-0 left-0 -mb-8 -ml-8 transform -rotate-12 transition-transform duration-500 hover:-rotate-45">
            <x-svg-accent position="bottom-left" size="w-20 h-20" opacity="opacity-20" />
        </div>

        <!-- Enhanced Header Content -->
        <div class="text-center relative z-10 py-8">
            <div class="inline-block mb-4">
                <svg class="w-16 h-16 mx-auto text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-3 tracking-tight">Buat Ekosistem Baru
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
                Buat ekosistem baru untuk mengundang kolaborator bergabung dalam gerakan perubahan sosial Anda
            </p>
        </div>
    </div>

    <!-- Session Status -->
    @if (session('message'))
        <div
            class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 text-center">
            <p class="text-green-700 dark:text-green-300">{{ session('message') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 text-center">
            <p class="text-red-700 dark:text-red-300">{{ session('error') }}</p>
        </div>
    @endif

    <form wire:submit="createEcosystem" class="flex flex-col gap-6 max-w-6xl mx-auto">
        <!-- Form Section: Informasi Dasar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Dasar</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Organization Name -->
                <div class="relative">
                    <flux:input wire:model="organization_name" :label="'Nama Lembaga'" type="text" required
                        :placeholder="'Contoh: Yayasan Perubahan Sosial Indonesia'" class=""
                        icon="building-office" />
                    {{-- <div class="absolute left-3 top-[2.15rem] text-gray-400 dark:text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div> --}}
                    @error('organization_name')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>

                <!-- Ecosystem Title -->
                <div class="relative">
                    <flux:input wire:model="ecosystem_title" :label="'Judul Ekosistem'" type="text" required
                        :placeholder="'Contoh: Gerakan Lingkungan Hijau Jakarta'" class=""
                        icon="presentation-chart-line" />
                    @error('ecosystem_title')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Section: Isu dan Peran -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Isu dan Peran</h2>

            <!-- Issues Addressed -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Isu yang Diperjuangkan <span class="text-red-500">*</span>
                    </label>
                    <div class="mb-6">
                        <div x-data="{
                            open: false,
                            search: '',
                            selectedItems: @entangle('selectedIssues').live,
                            mainInput: '',
                            isProcessing: false,
                            updateMainInput() {
                                this.mainInput = this.selectedItems.map(id =>
                                    document.getElementById('issue_label_' + id)?.textContent || ''
                                ).filter(Boolean).join(', ');
                            },
                            async toggleItem(id) {
                                if (this.isProcessing) return;
                                this.isProcessing = true;
                                try {
                                    await $wire.toggleIssue(id);
                                    this.updateMainInput();
                                } finally {
                                    this.isProcessing = false;
                                }
                            }
                        }" x-init="updateMainInput()" @click.away="open = false"
                            class="multi-select-container relative">
                            <!-- Main Selector Input -->
                            <div class="relative">
                                <input type="text" x-model="mainInput" placeholder="Pilih isu yang diperjuangkan..."
                                    class="w-full pl-10 pr-12 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 cursor-pointer transition-all duration-200"
                                    readonly @click="open = !open">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
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
                                    <input type="text" wire:model.live="issueSearch" placeholder="Cari isu..."
                                        class="w-full pl-10 pr-4 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 shadow-sm"
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
                                        <div class="multi-option {{ in_array($interest->id, is_array($selectedIssues) ? $selectedIssues : []) ? 'bg-blue-50 dark:bg-blue-900/20' : '' }} px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-all duration-200"
                                            @click.stop="toggleItem({{ $interest->id }})">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex items-center justify-center w-5 h-5">
                                                        <input type="checkbox" id="issue_{{ $interest->id }}"
                                                            :checked="selectedItems.includes({{ $interest->id }})"
                                                            @click.stop="toggleItem({{ $interest->id }})"
                                                            class="h-4 w-4 text-blue-600 focus:ring-2 focus:ring-blue-500/20 border-gray-300 dark:border-gray-600 rounded transition-colors duration-200">
                                                    </div>
                                                    <div>
                                                        <span id="issue_label_{{ $interest->id }}"
                                                            class="font-medium text-gray-700 dark:text-gray-300">{{ $interest->name }}</span>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                            Pilih untuk menambahkan ke ekosistem Anda</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center"
                                                    x-show="selectedItems.includes({{ $interest->id }})">
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
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

                        <!-- Selected Issues Display -->
                        @if (count($selectedIssues) > 0)
                            <div class="mt-4 border-t border-gray-100 dark:border-gray-700 pt-4">
                                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Isu yang Dipilih:
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($selectedIssues as $issueId)
                                        @php
                                            $interest = $interests->firstWhere('id', $issueId);
                                        @endphp
                                        @if ($interest)
                                            <div
                                                class="group inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-700 transition-all duration-200 hover:bg-blue-100 dark:hover:bg-blue-900/30">
                                                <svg class="w-4 h-4 mr-1.5 text-blue-500 dark:text-blue-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                                </svg>
                                                <span>{{ $interest->name }}</span>
                                                <button type="button" wire:click="removeIssue({{ $issueId }})"
                                                    class="ml-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @error('selectedIssues')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </div>

                    <!-- Form Section: Informasi Lokasi dan Kapasitas -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-5 mb-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Lokasi dan
                            Kapasitas</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Work Region -->
                            <div class="relative md:col-span-1">
                                <flux:input wire:model="work_region" :label="'Wilayah Kerja'" icon="map-pin"
                                    type="text" required
                                    :placeholder="'Contoh: Jakarta, Bogor, Depok, Tangerang, Bekasi'" />
                                @error('work_region')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </div>

                            <!-- Max Users -->
                            <div class="relative md:col-span-1">
                                <flux:input wire:model="max_users" :label="'Maksimal Anggota (Opsional)'"
                                    type="number" min="1" :placeholder="'Kosongkan jika tidak ada batasan'"
                                    icon="users" class="" />
                                @error('max_users')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Existing Roles -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Peran yang Sudah Ada
                        </label>
                        <div class="mb-6">
                            <div x-data="{
                                open: false,
                                search: '',
                                selectedItems: @entangle('selectedExistingRoles').live,
                                mainInput: '',
                                isProcessing: false,
                                updateMainInput() {
                                    this.mainInput = this.selectedItems.map(id =>
                                        document.getElementById('role_label_' + id)?.textContent || ''
                                    ).filter(Boolean).join(', ');
                                },
                                async toggleItem(id) {
                                    if (this.isProcessing) return;
                                    this.isProcessing = true;
                                    try {
                                        await $wire.toggleRole(id);
                                        this.updateMainInput();
                                    } finally {
                                        this.isProcessing = false;
                                    }
                                }
                            }" x-init="updateMainInput()" @click.away="open = false"
                                class="multi-select-container relative">
                                <!-- Main Selector Input -->
                                <div class="relative">
                                    <input type="text" x-model="mainInput"
                                        placeholder="Pilih peran yang sudah ada..."
                                        class="w-full pl-10 pr-12 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 cursor-pointer transition-all duration-200"
                                        readonly @click="open = !open">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
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
                                        <input type="text" wire:model.live="roleSearch"
                                            placeholder="Cari peran..."
                                            class="w-full pl-10 pr-4 py-3 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 shadow-sm"
                                            @click.stop>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Dropdown List -->
                                    <div
                                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                        @foreach ($this->getFilteredRoles() as $role)
                                            <div class="multi-option {{ in_array($role->id, is_array($selectedExistingRoles) ? $selectedExistingRoles : []) ? 'bg-green-50 dark:bg-green-900/20' : '' }} px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-all duration-200"
                                                @click.stop="toggleItem({{ $role->id }})">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="flex items-center justify-center w-5 h-5">
                                                            <input type="checkbox" id="role_{{ $role->id }}"
                                                                :checked="selectedItems.includes({{ $role->id }})"
                                                                @click.stop="toggleItem({{ $role->id }})"
                                                                class="h-4 w-4 text-green-600 focus:ring-2 focus:ring-green-500/20 border-gray-300 dark:border-gray-600 rounded transition-colors duration-200">
                                                        </div>
                                                        <div>
                                                            <span id="role_label_{{ $role->id }}"
                                                                class="font-medium text-gray-700 dark:text-gray-300">{{ $role->nama }}</span>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                                {{ $role->deskripsi }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center"
                                                        x-show="selectedItems.includes({{ $role->id }})">
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                            Terpilih
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($this->getFilteredRoles()->isEmpty())
                                            <div
                                                class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                                                Tidak ada hasil yang ditemukan
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Roles Display -->
                            @if (count($selectedExistingRoles) > 0)
                                <div class="mt-4 border-t border-gray-100 dark:border-gray-700 pt-4">
                                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Peran yang
                                        Dipilih:
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($selectedExistingRoles as $roleId)
                                            @php
                                                $role = $roles->firstWhere('id', $roleId);
                                            @endphp
                                            @if ($role)
                                                <div
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-700">
                                                    <span>{{ $role->nama }}</span>
                                                    <button type="button"
                                                        wire:click="removeRole({{ $roleId }})"
                                                        class="ml-2 text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200">
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

                            @error('selectedExistingRoles')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </div>

                        <!-- Required All Roles Info -->
                        <div
                            class="bg-gradient-to-br mb-6 from-green-50 to-green-50/50 dark:from-green-900/30 dark:to-green-900/20 border border-green-200/70 dark:border-green-800 rounded-xl p-6 shadow-sm backdrop-blur-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/50">
                                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-base font-semibold text-green-800 dark:text-green-200">
                                        Ekosistem Memerlukan Semua Peran
                                    </h3>
                                </div>
                            </div>
                            <p class="text-sm text-green-700 dark:text-green-300 mt-2 leading-relaxed">
                                Setiap ekosistem secara otomatis memerlukan semua peran yang tersedia dalam
                                sistem untuk memastikan kolaborasi yang komprehensif dan efektif.
                            </p>
                            <div
                                class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $roles->count() }} peran diperlukan</span>
                            </div>
                        </div>

                        <!-- Max Users -->
                        <flux:input wire:model="max_users" :label="'Maksimal Anggota (Opsional)'" type="number"
                            min="1" :placeholder="'Kosongkan jika tidak ada batasan'" class="mb-6" />
                        @error('max_users')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror

                        <!-- Form Section: Deskripsi dan Ketentuan -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border mb-6 border-gray-100 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Deskripsi dan
                                Ketentuan</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Description -->
                                <div class="relative md:col-span-2">
                                    <flux:textarea wire:model="description" :label="'Deskripsi Ekosistem'" required
                                        :placeholder="'Jelaskan lebih detail tentang ekosistem Anda...'"
                                        rows="3" class="pl-10" />
                                    <div class="absolute left-3 top-[2.15rem] text-gray-400 dark:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 6h16M4 12h16M4 18h7" />
                                        </svg>
                                    </div>
                                    @error('description')
                                        <flux:error>{{ $message }}</flux:error>
                                    @enderror
                                </div>

                                <!-- Terms & Conditions -->
                                <div class="relative md:col-span-2">
                                    <flux:textarea :label="'Syarat dan Ketentuan'" required
                                        wire:model="terms_conditions"
                                        :placeholder="'Tuliskan syarat dan ketentuan untuk bergabung dengan ekosistem Anda...'"
                                        rows="3" class="pl-10" />
                                    <div class="absolute left-3 top-[2.15rem] text-gray-400 dark:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                    </div>
                                    @error('terms_conditions')
                                        <flux:error>{{ $message }}</flux:error>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Auto Join Collective Actions Setting -->
                        {{-- <div
                            class="bg-gradient-to-br from-blue-50 to-blue-50/50 dark:from-green-900/30 dark:to-green-900/20 border border-blue-200/70 dark:border-green-800 rounded-xl p-6 shadow-sm backdrop-blur-sm">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 pt-1">
                                    <flux:checkbox wire:model="auto_join_collective_actions"
                                        id="auto_join_collective_actions"
                                        class="h-5 w-5 text-blue-600 focus:ring-2 focus:ring-blue-500/20 border-gray-300 dark:border-gray-600 rounded transition-colors duration-200" />
                                </div>
                                <div class="flex-1">
                                    <label for="auto_join_collective_actions"
                                        class="text-base font-semibold text-gray-900 dark:text-green-200">
                                        Anggota Otomatis Bergabung ke Aksi Kolektif
                                    </label>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-green-300 mt-2 leading-relaxed">
                                Jika diaktifkan, semua anggota ekosistem akan otomatis bergabung ke aksi
                                kolektif yang mengundang ekosistem ini.
                                Jika tidak diaktifkan, anggota perlu persetujuan admin aksi kolektif untuk
                                bergabung.
                            </p>
                            <div class="mt-3 flex items-center text-sm text-blue-600 dark:text-green-400">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Pengaturan ini dapat diubah nanti di halaman pengaturan ekosistem</span>
                            </div>
                        </div> --}}

                        <!-- Action Buttons -->
                        <div class="flex gap-4 mt-4 flex-col sm:flex-row-reverse">
                            <flux:button type="submit" variant="primary"
                                class="w-full cursor-pointer py-3 text-base font-medium transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span>Buat Ekosistem</span>
                                </div>
                            </flux:button>
                            <flux:button type="button" variant="outline"
                                class="w-full cursor-pointer py-3 text-base font-medium transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
                                wire:click="$dispatch('redirect', { url: '{{ route('ecosystem.browse') }}' })">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    <span>Batal</span>
                                </div>
                            </flux:button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
