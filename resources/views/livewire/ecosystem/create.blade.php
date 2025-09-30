<div class="flex flex-col gap-6 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-right" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="bottom-left" size="w-12 h-12" opacity="opacity-10" />

    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Buat Ekosistem Baru</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Buat ekosistem baru untuk mengundang kolaborator bergabung dalam
            gerakan perubahan sosial Anda</p>
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

    <form wire:submit="createEcosystem" class="flex flex-col gap-6">
        <!-- Organization Name -->
        <flux:input wire:model="organization_name" :label="'Nama Lembaga'" type="text" required
            :placeholder="'Contoh: Yayasan Perubahan Sosial Indonesia'" />
        @error('organization_name')
            <flux:error>{{ $message }}</flux:error>
        @enderror

        <!-- Ecosystem Title -->
        <flux:input wire:model="ecosystem_title" :label="'Judul Ekosistem'" type="text" required
            :placeholder="'Contoh: Gerakan Lingkungan Hijau Jakarta'" />
        @error('ecosystem_title')
            <flux:error>{{ $message }}</flux:error>
        @enderror

        <!-- Issues Addressed -->
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
                }" 
                x-init="updateMainInput()"
                @click.away="open = false"
                class="multi-select-container">
                    <!-- Main Selector Input -->
                    <div class="relative">
                        <input type="text" 
                            x-model="mainInput"
                            placeholder="Pilih isu yang diperjuangkan..."
                            class="w-full px-4 py-2.5 pr-12 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 cursor-pointer" 
                            readonly
                            @click="open = !open">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Search Input -->
                    <div x-show="open" class="mt-2">
                        <div class="relative">
                            <input type="text" 
                                wire:model.live="issueSearch" 
                                placeholder="Cari isu..."
                                class="w-full pl-10 pr-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                                @click.stop>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown List -->
                    <div x-show="open" 
                        class="absolute z-10 w-full mt-1 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        @foreach ($this->getFilteredInterests() as $interest)
                            <div class="multi-option {{ in_array($interest->id, is_array($selectedIssues) ? $selectedIssues : []) ? 'bg-blue-50 dark:bg-blue-900/20' : '' }} px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-colors duration-150"
                                @click.stop="toggleItem({{ $interest->id }})">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center w-5 h-5">
                                            <input type="checkbox" 
                                                id="issue_{{ $interest->id }}"
                                                :checked="selectedItems.includes({{ $interest->id }})"
                                                @click.stop="toggleItem({{ $interest->id }})"
                                                class="h-4 w-4 text-blue-600 focus:ring-2 focus:ring-blue-500/20 border-gray-300 dark:border-gray-600 rounded">
                                        </div>
                                        <span id="issue_label_{{ $interest->id }}" class="font-medium text-gray-700 dark:text-gray-300">{{ $interest->name }}</span>
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
                <div class="flex flex-wrap gap-2">
                    @foreach ($selectedIssues as $issueId)
                        @php
                            $interest = $interests->firstWhere('id', $issueId);
                        @endphp
                        @if ($interest)
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-700">
                                <span>{{ $interest->name }}</span>
                                <button type="button" wire:click="removeIssue({{ $issueId }})"
                                    class="ml-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
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
            @endif

            @error('selectedIssues')
                <flux:error>{{ $message }}</flux:error>
            @enderror
        </div>

        <!-- Work Region -->
        <flux:input wire:model="work_region" :label="'Wilayah Kerja'" type="text" required
            :placeholder="'Contoh: Jakarta, Bogor, Depok, Tangerang, Bekasi'" />
        @error('work_region')
            <flux:error>{{ $message }}</flux:error>
        @enderror

        <!-- Existing Roles -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Peran yang Sudah Ada <span class="text-red-500">*</span>
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
                }" 
                x-init="updateMainInput()"
                @click.away="open = false"
                class="multi-select-container">
                    <!-- Main Selector Input -->
                    <div class="relative">
                        <input type="text" 
                            x-model="mainInput"
                            placeholder="Pilih peran yang sudah ada..."
                            class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 cursor-pointer" 
                            readonly
                            @click="open = !open">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Search Input -->
                    <div x-show="open" class="mt-2">
                        <div class="relative">
                            <input type="text" 
                                wire:model.live="roleSearch" 
                                placeholder="Cari peran..."
                                class="w-full pl-10 pr-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                                @click.stop>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown List -->
                    <div x-show="open" 
                        class="absolute z-10 w-full mt-1 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        @foreach ($this->getFilteredRoles() as $role)
                            <div class="multi-option {{ in_array($role->id, is_array($selectedExistingRoles) ? $selectedExistingRoles : []) ? 'bg-green-50 dark:bg-green-900/20' : '' }} px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-colors duration-150"
                                @click.stop="toggleItem({{ $role->id }})">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center w-5 h-5">
                                            <input type="checkbox" 
                                                id="role_{{ $role->id }}"
                                                :checked="selectedItems.includes({{ $role->id }})"
                                                @click.stop="toggleItem({{ $role->id }})"
                                                class="h-4 w-4 text-green-600 focus:ring-2 focus:ring-green-500/20 border-gray-300 dark:border-gray-600 rounded">
                                        </div>
                                        <div>
                                            <span id="role_label_{{ $role->id }}" class="font-medium text-gray-700 dark:text-gray-300">{{ $role->nama }}</span>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $role->deskripsi }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                @endforeach
                        @if ($this->getFilteredRoles()->isEmpty())
                            <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                                Tidak ada hasil yang ditemukan
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Selected Roles Display -->
            @if (count($selectedExistingRoles) > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach ($selectedExistingRoles as $roleId)
                        @php
                            $role = $roles->firstWhere('id', $roleId);
                        @endphp
                        @if ($role)
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-700">
                                <span>{{ $role->nama }}</span>
                                <button type="button" wire:click="removeRole({{ $roleId }})"
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
            @endif

            @error('selectedExistingRoles')
                <flux:error>{{ $message }}</flux:error>
            @enderror
        </div>

        <!-- Required All Roles Info -->
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-lg"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800 dark:text-green-200">
                        Ekosistem Memerlukan Semua Peran
                    </h3>
                    <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                        Setiap ekosistem secara otomatis memerlukan semua peran yang tersedia dalam sistem untuk memastikan kolaborasi yang komprehensif dan efektif.
                    </p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                        <strong>Total peran yang diperlukan:</strong> {{ $roles->count() }} peran
                    </p>
                </div>
            </div>
        </div>

        <!-- Max Users -->
        <flux:input wire:model="max_users" :label="'Maksimal Anggota (Opsional)'" type="number" min="1"
            :placeholder="'Kosongkan jika tidak ada batasan'" />
        @error('max_users')
            <flux:error>{{ $message }}</flux:error>
        @enderror

        <!-- Description -->
        <flux:textarea wire:model="description" :label="'Deskripsi Ekosistem'" required
            :placeholder="'Jelaskan lebih detail tentang ekosistem Anda...'" rows="4" />
        @error('description')
            <flux:error>{{ $message }}</flux:error>
        @enderror

        <!-- Terms & Conditions -->
        <div>
            <flux:textarea :label="'Syarat dan Ketentuan'" required wire:model="terms_conditions"
                :placeholder="'Tuliskan syarat dan ketentuan untuk bergabung dengan ekosistem Anda...'"
                rows="4" />
            @error('terms_conditions')
                <flux:error>{{ $message }}</flux:error>
            @enderror
        </div>

        <!-- Auto Join Collective Actions Setting -->
        <div class="bg-blue-50 dark:bg-green-900/20 border border-blue-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-start space-x-3">
                <flux:checkbox wire:model="auto_join_collective_actions" id="auto_join_collective_actions" />
                <div class="flex-1">
                    <label for="auto_join_collective_actions" class="text-sm font-medium text-gray-900 dark:text-green-200">
                        Anggota Otomatis Bergabung ke Aksi Kolektif
                    </label>
                    <p class="text-sm text-gray-600 dark:text-green-300 mt-1">
                        Jika diaktifkan, semua anggota ekosistem akan otomatis bergabung ke aksi kolektif yang mengundang ekosistem ini. 
                        Jika tidak diaktifkan, anggota perlu persetujuan admin aksi kolektif untuk bergabung.
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col gap-3">
            <flux:button type="submit" variant="primary" class="w-full cursor-pointer">
                {{ 'Buat Ekosistem' }}
            </flux:button>

            <flux:button type="button" variant="outline" class="w-full cursor-pointer"
                wire:click="$dispatch('redirect', { url: '{{ route('ecosystem.browse') }}' })">
                {{ 'Batal' }}
            </flux:button>
        </div>
    </form>

</div>
