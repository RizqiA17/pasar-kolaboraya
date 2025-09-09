<div class="flex flex-col gap-6 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-right" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="bottom-left" size="w-12 h-12" opacity="opacity-10" />
    
    <x-auth-header 
        :title="'Setup Ekosistem Kolaborasi'" 
        :description="'Buat ekosistem untuk mengundang kolaborator bergabung dalam gerakan perubahan sosial Anda'" 
    />

    <!-- Session Status -->
    @if (session('message'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 text-center">
            <p class="text-green-700 dark:text-green-300">{{ session('message') }}</p>
        </div>
    @endif

    <form wire:submit="setupEcosystem" class="flex flex-col gap-6">
        <!-- Organization Name -->
        <flux:input
            wire:model="organization_name"
            :label="'Nama Lembaga'"
            type="text"
            required
            :placeholder="'Contoh: Yayasan Perubahan Sosial Indonesia'"
        />
        @error('organization_name')
            <flux:error>{{ $message }}</flux:error>
        @enderror

        <!-- Ecosystem Title -->
        <flux:input
            wire:model="ecosystem_title"
            :label="'Judul Ekosistem'"
            type="text"
            required
            :placeholder="'Contoh: Gerakan Lingkungan Hijau Jakarta'"
        />
        @error('ecosystem_title')
            <flux:error>{{ $message }}</flux:error>
        @enderror

        <!-- Issues Addressed -->
        <div>
            <flux:field :label="'Isu yang Diperjuangkan'" required>
                <div class="grid grid-cols-2 gap-3 mt-2">
                    @foreach($interests as $interest)
                        <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                            <input 
                                type="checkbox" 
                                wire:model="selectedIssues" 
                                value="{{ $interest->id }}" 
                                class="mr-3 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $interest->name }}</span>
                        </label>
                    @endforeach
                </div>
            </flux:field>
        </div>

        <!-- Work Region -->
        <flux:input
            wire:model="work_region"
            :label="'Wilayah Kerja'"
            type="text"
            required
            :placeholder="'Contoh: Jakarta, Bogor, Depok, Tangerang, Bekasi'"
        />
        @error('work_region')
            <flux:error>{{ $message }}</flux:error>
        @enderror
        <!-- Existing Roles -->
        <div>
            <flux:field :label="'Peran/Keahlian yang Sudah Ada'" required>
                <div class="grid grid-cols-2 gap-3 mt-2">
                    @foreach($skills as $skill)
                        <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                            <input 
                                type="checkbox" 
                                wire:model="selectedExistingRoles" 
                                value="{{ $skill->id }}" 
                                class="mr-3 rounded border-gray-300 text-green-600 focus:ring-green-500"
                            >
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $skill->name }}</span>
                        </label>
                    @endforeach
                </div>
            </flux:field>
            @error('selectedExistingRoles')
                <flux:error>{{ $message }}</flux:error>
            @enderror   
        </div>

        <!-- Needed Roles -->
        <div>
            <flux:field :label="'Peran/Keahlian yang Dibutuhkan'" required>
                <div class="grid grid-cols-2 gap-3 mt-2">
                    @foreach($skills as $skill)
                        <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                            <input 
                                type="checkbox" 
                                wire:model="selectedNeededRoles" 
                                value="{{ $skill->id }}" 
                                class="mr-3 rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                            >
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $skill->name }}</span>
                        </label>
                    @endforeach
                </div>
            </flux:field>
            @error('selectedNeededRoles')
                <flux:error>{{ $message }}</flux:error>
            @enderror
        </div>

        <!-- Max Users -->
        <flux:input
            wire:model="max_users"
            :label="'Maksimal Anggota (Opsional)'"
            type="number"
            min="1"
            :placeholder="'Kosongkan jika tidak ada batasan'"
        />
        @error('max_users')
            <flux:error>{{ $message }}</flux:error>
        @enderror
        <!-- Description -->
        <flux:textarea
            wire:model="description"
            :label="'Deskripsi Tambahan (Opsional)'"
            :placeholder="'Jelaskan lebih detail tentang ekosistem Anda...'"
            rows="3"
        />
        @error('description')
            <flux:error>{{ $message }}</flux:error>
        @enderror
        <!-- Terms & Conditions -->
        <flux:textarea
            wire:model="terms_conditions"
            :label="'Syarat dan Ketentuan'"
            required
            :placeholder="'Tuliskan syarat dan ketentuan untuk bergabung dengan ekosistem Anda...'"
            rows="5"
        />
        @error('terms_conditions')
            <flux:error>{{ $message }}</flux:error>
        @enderror

        <!-- Auto Join Collective Actions Setting -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex items-start space-x-3">
                <flux:checkbox wire:model="auto_join_collective_actions" id="auto_join_collective_actions" />
                <div class="flex-1">
                    <label for="auto_join_collective_actions" class="text-sm font-medium text-gray-900 dark:text-white">
                        Anggota Otomatis Bergabung ke Aksi Kolektif
                    </label>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                        Jika diaktifkan, semua anggota ekosistem akan otomatis bergabung ke aksi kolektif yang mengundang ekosistem ini. 
                        Jika tidak diaktifkan, anggota perlu persetujuan admin aksi kolektif untuk bergabung.
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col gap-3">
            <flux:button 
                type="submit" 
                variant="primary" 
                class="w-full cursor-pointer"
            >
                {{ 'Buat Ekosistem' }}
            </flux:button>
            
            <flux:button 
                type="button" 
                variant="outline" 
                class="w-full cursor-pointer"
                wire:click="skip"
            >
                {{ 'Lewati (Buat Nanti)' }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600">
        <span>{{ 'Ingin kembali?' }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ 'Login' }}</flux:link>
    </div>
</div>