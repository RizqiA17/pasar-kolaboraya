<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl p-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('collective-action.browse') }}" class="mr-4 text-white/80 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Buat Aksi Kolektif</h1>
        </div>
        <p class="text-purple-100">
            Ajak ecosystem builders lain untuk berkolaborasi dalam gerakan perubahan sosial yang lebih besar
        </p>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="font-semibold text-blue-900 dark:text-blue-200">Flow Aksi Kolektif</h3>
                <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                    1. Anda membuat aksi kolektif dan mengundang ecosystem builders lain<br>
                    2. Mereka menerima/menolak undangan untuk berkolaborasi<br>
                    3. Setelah minimal 3 ekosistem bergabung, aksi dapat dimulai<br>
                    4. User biasa dapat berkontribusi pada aksi yang aktif
                </p>
            </div>
        </div>
    </div>

    <form wire:submit="createAction" class="space-y-6">
        <!-- Basic Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Informasi Dasar
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div class="md:col-span-2">
                    <flux:input
                        wire:model="title"
                        :label="'Judul Aksi Kolektif'"
                        type="text"
                        required
                        :placeholder="'Contoh: Gerakan Bersih-Bersih Lingkungan Nasional'"
                    />
                </div>

                <!-- Scale -->
                <flux:select wire:model="scale" :label="'Skala Aksi'" required>
                    <option value="kecil">Aksi Kecil</option>
                    <option value="sedang">Aksi Sedang</option>
                    <option value="besar">Aksi Besar</option>
                </flux:select>

                <!-- Scope -->
                <flux:select wire:model="scope" :label="'Jangkauan'" required>
                    <option value="local">Lokal</option>
                    <option value="national">Nasional</option>
                    <option value="international">Internasional</option>
                </flux:select>

                <!-- Description -->
                <div class="md:col-span-2">
                    <flux:textarea
                        wire:model="description"
                        :label="'Deskripsi'"
                        required
                        :placeholder="'Jelaskan detail aksi kolektif yang akan dilakukan...'"
                        rows="4"
                    />
                </div>

                <!-- Goals -->
                <div class="md:col-span-2">
                    <flux:textarea
                        wire:model="goals"
                        :label="'Tujuan Aksi'"
                        required
                        :placeholder="'Apa yang ingin dicapai dari aksi kolektif ini?'"
                        rows="3"
                    />
                </div>
            </div>
        </div>

        <!-- Timeline & Location -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Waktu dan Tempat
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input
                    wire:model="start_date"
                    :label="'Tanggal Mulai'"
                    type="date"
                    required
                />

                <flux:input
                    wire:model="end_date"
                    :label="'Tanggal Selesai'"
                    type="date"
                    required
                />

                <div class="md:col-span-2">
                    <flux:input
                        wire:model="location"
                        :label="'Lokasi (Opsional)'"
                        type="text"
                        :placeholder="'Contoh: Jakarta, Bandung, atau Online'"
                    />
                </div>
            </div>
        </div>

        <!-- Required Resources -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Sumber Daya yang Dibutuhkan
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($resourceTypes as $key => $label)
                    <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                        <input 
                            type="checkbox" 
                            wire:model="required_resources" 
                            value="{{ $key }}" 
                            class="mr-3 rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                        >
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Invite Ecosystems -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Undang Ekosistem untuk Berkolaborasi
            </h2>
            
            @if($availableEcosystems->count() > 0)
                <div class="space-y-4">
                    @foreach($availableEcosystems as $ecosystem)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-start">
                                <input 
                                    type="checkbox" 
                                    wire:model="invited_ecosystems" 
                                    value="{{ $ecosystem->id }}" 
                                    class="mr-3 mt-1 rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                    id="ecosystem-{{ $ecosystem->id }}"
                                >
                                <div class="flex-1">
                                    <label for="ecosystem-{{ $ecosystem->id }}" class="cursor-pointer">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">
                                            {{ $ecosystem->ecosystem_title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $ecosystem->organization_name }} • {{ $ecosystem->work_region }}
                                        </p>
                                        @if($ecosystem->description)
                                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1 line-clamp-2">
                                                {{ $ecosystem->description }}
                                            </p>
                                        @endif
                                    </label>
                                    
                                    <!-- Custom invitation message -->
                                    @if(in_array($ecosystem->id, $invited_ecosystems))
                                        <div class="mt-3">
                                            <flux:textarea
                                                wire:model="invitation_messages.{{ $ecosystem->id }}"
                                                :label="'Pesan Undangan (Opsional)'"
                                                :placeholder="'Tulis pesan personal untuk mengundang ekosistem ini...'"
                                                rows="2"
                                            />
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($availableEcosystems->count() < 2)
                    <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                        <p class="text-yellow-800 dark:text-yellow-200 text-sm">
                            Tersedia {{ $availableEcosystems->count() }} ekosistem untuk diundang. Anda memerlukan minimal 2 ekosistem lain untuk berkolaborasi.
                        </p>
                    </div>
                @endif
            @else
                <div class="text-center py-6">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        Belum Ada Ekosistem Tersedia
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Saat ini belum ada ekosistem lain yang dapat diundang untuk berkolaborasi.
                    </p>
                </div>
            @endif
        </div>

        <!-- Collaboration Terms -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Syarat Kolaborasi
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input
                    wire:model="min_ecosystems"
                    :label="'Minimal Ekosistem yang Diperlukan'"
                    type="number"
                    min="3"
                    required
                />
                
                <div></div>
                
                <div class="md:col-span-2">
                    <flux:textarea
                        wire:model="collaboration_terms"
                        :label="'Syarat dan Ketentuan Kolaborasi'"
                        required
                        :placeholder="'Tuliskan syarat dan ketentuan untuk berkolaborasi dalam aksi ini...'"
                        rows="4"
                    />
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-3">
            @if($availableEcosystems->count() >= 2)
                <flux:button 
                    type="submit" 
                    variant="primary" 
                    class="flex-1"
                    {{-- :loading="$wire.loading" --}}
                >
                    Buat Aksi dan Kirim Undangan
                </flux:button>
            @else
                <flux:button 
                    type="button" 
                    variant="outline" 
                    class="flex-1"
                    disabled
                >
                    Perlu Minimal 2 Ekosistem Lain
                </flux:button>
            @endif
            
            <flux:button 
                type="button" 
                variant="outline"
                onclick="window.history.back()"
            >
                Batal
            </flux:button>
        </div>
    </form>
</div>