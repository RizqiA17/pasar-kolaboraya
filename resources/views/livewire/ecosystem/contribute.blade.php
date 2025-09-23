<div class="max-w-4xl mx-auto space-y-6">
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
        <div class="flex max-md:flex-col-reverse max-md:items-start items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100">Berkontribusi pada Ekosistem</h1>
                <p class="text-gray-600 dark:text-slate-300 mt-1">{{ $ecosystem->ecosystem_title }}</p>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">{{ $ecosystem->organization_name }}</p>
            </div>
            <a href="{{ route('ecosystem.dashboard', $ecosystem) }}" 
               class="inline-flex max-md:mb-4 items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-md text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Contribution Form -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Form Kontribusi</h2>
            <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">Isi form di bawah ini untuk mengajukan kontribusi Anda</p>
        </div>

        <form wire:submit="submitContribution" class="p-6 space-y-6">
            <!-- Contribution Type -->
            <div>
                <label for="contribution_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                    Jenis Kontribusi <span class="text-red-500">*</span>
                </label>
                <select wire:model.live="contribution_id" 
                        id="contribution_id"
                        class="mt-1 p-4 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Pilih jenis kontribusi...</option>
                    @foreach($contributionTypes as $contribution)
                        <option value="{{ $contribution->id }}">{{ $contribution->name }}</option>
                    @endforeach
                </select>
                @error('contribution_id') 
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Contribution Description -->
            <div>
                <label for="contribution_description" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                    Deskripsi Kontribusi <span class="text-red-500">*</span>
                </label>
                <textarea wire:model="contribution_description" 
                          id="contribution_description"
                          rows="4"
                          class="mt-1 p-4 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          placeholder="Jelaskan secara detail kontribusi yang ingin Anda berikan..."></textarea>
                @error('contribution_description') 
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                @enderror
                <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">Minimal 10 karakter, maksimal 1000 karakter</p>
            </div>

            <!-- Contribution Amount (for funding) -->
            @php
                $selectedContribution = $contributionTypes->firstWhere('id', $contribution_id);
                $isFunding = $selectedContribution && str_contains(strtolower($selectedContribution->name), 'dana');
            @endphp
            @if($isFunding)
                <div>
                    <label for="contribution_amount" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Jumlah Dana <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-slate-400 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" 
                               wire:model="contribution_amount" 
                               id="contribution_amount"
                               class="pl-10 mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="0">
                    </div>
                    @error('contribution_amount') 
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                    @enderror
                </div>
            @endif

            <!-- Resource Details (for resources) -->
            @php
                $isResources = $selectedContribution && str_contains(strtolower($selectedContribution->name), 'sumber daya');
            @endphp
            @if($isResources)
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Detail Sumber Daya
                    </label>
                    <div class="space-y-4">
                        @foreach($contribution_details as $index => $detail)
                            <div class="border border-gray-200 dark:border-slate-600 rounded-lg p-4 bg-gray-50 dark:bg-slate-700/50">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                                            Jenis Sumber Daya
                                        </label>
                                        <select wire:model="contribution_details.{{ $index }}.type"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="">Pilih jenis...</option>
                                            @foreach($resourceTypes as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                                            Deskripsi
                                        </label>
                                        <input type="text" 
                                               wire:model="contribution_details.{{ $index }}.description"
                                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                               placeholder="Deskripsi sumber daya...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                                            Jumlah/Kuantitas
                                        </label>
                                        <input type="text" 
                                               wire:model="contribution_details.{{ $index }}.quantity"
                                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                               placeholder="Contoh: 5 unit, 10 jam, dll">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                                            Nilai (Opsional)
                                        </label>
                                        <input type="text" 
                                               wire:model="contribution_details.{{ $index }}.value"
                                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                               placeholder="Nilai estimasi...">
                                    </div>
                                </div>
                                <div class="mt-3 flex justify-end">
                                    <button type="button" 
                                            wire:click="removeResourceDetail({{ $index }})"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                                        Hapus Detail
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        
                        <button type="button" 
                                wire:click="addResourceDetail"
                                class="w-full border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg p-4 text-center hover:border-blue-500 dark:hover:border-blue-400 transition-colors">
                            <svg class="w-6 h-6 mx-auto text-gray-400 dark:text-slate-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-slate-400">Tambah Detail Sumber Daya</span>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Additional Information -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Informasi Penting
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Kontribusi Anda akan ditinjau oleh pemilik ekosistem sebelum diterima</li>
                                <li>Pastikan deskripsi kontribusi Anda jelas dan detail</li>
                                <li>Anda akan menerima notifikasi ketika status kontribusi berubah</li>
                                <li>Hanya anggota yang diterima yang dapat berkontribusi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('ecosystem.dashboard', $ecosystem) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-md text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Ajukan Kontribusi
                </button>
            </div>
        </form>
    </div>
</div>
