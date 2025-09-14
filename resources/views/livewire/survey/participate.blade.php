{{-- <x-layouts.app :title="'Ikuti Survey'"> --}}
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4">
            @if($survey)
                <!-- Header -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $survey->name }}</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $survey->description }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Step {{ $currentStep }} dari {{ $totalSteps }}</div>
                            <div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Survey Form -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <form wire:submit.prevent="{{ $currentStep < $totalSteps ? 'nextStep' : 'submit' }}">
                        
                        @if($currentStep == 1)
                            <!-- Kategori Koneksi -->
                            <div class="space-y-6">
                                <div class="text-center mb-6">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Kategori Koneksi</h2>
                                    <p class="text-gray-600 dark:text-gray-400">Berikan informasi tentang koneksi dan jaringan Anda</p>
                                </div>

                                <!-- Jumlah Koneksi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        1. Jumlah Koneksi
                                    </label>
                                    <input 
                                        type="number" 
                                        wire:model="jumlah_koneksi" 
                                        min="0"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                        placeholder="Masukkan jumlah koneksi Anda"
                                    >
                                    @error('jumlah_koneksi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Alasan:</label>
                                        <textarea 
                                            wire:model="jumlah_koneksi_alasan"
                                            rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white text-sm"
                                            placeholder="Jelaskan mengapa jumlah koneksi Anda sebanyak ini..."
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Rata-rata Kualitas Koneksi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        2. Rata-rata Kualitas Koneksi (1-5)
                                    </label>
                                    <select 
                                        wire:model="rata_kualitas_koneksi"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                    >
                                        <option value="">Pilih kualitas koneksi</option>
                                        <option value="1">1 - Sangat Buruk</option>
                                        <option value="2">2 - Buruk</option>
                                        <option value="3">3 - Cukup</option>
                                        <option value="4">4 - Baik</option>
                                        <option value="5">5 - Sangat Baik</option>
                                    </select>
                                    @error('rata_kualitas_koneksi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Alasan:</label>
                                        <textarea 
                                            wire:model="rata_kualitas_koneksi_alasan"
                                            rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white text-sm"
                                            placeholder="Jelaskan penilaian kualitas koneksi Anda..."
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Keluasan Jejaring -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        3. Keluasan Jejaring
                                    </label>
                                    <select 
                                        wire:model="keluasan_jejaring"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                    >
                                        <option value="">Pilih keluasan jejaring</option>
                                        <option value="1">1 - Lokal</option>
                                        <option value="2">2 - Kabupaten</option>
                                        <option value="3">3 - Provinsi</option>
                                        <option value="4">4 - Nasional</option>
                                        <option value="5">5 - Internasional</option>
                                    </select>
                                    @error('keluasan_jejaring') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Alasan:</label>
                                        <textarea 
                                            wire:model="keluasan_jejaring_alasan"
                                            rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white text-sm"
                                            placeholder="Jelaskan keluasan jejaring Anda..."
                                        ></textarea>
                                    </div>
                                </div>
                            </div>

                        @elseif($currentStep == 2)
                            <!-- Kategori Kolaborasi -->
                            <div class="space-y-6">
                                <div class="text-center mb-6">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Kategori Kolaborasi</h2>
                                    <p class="text-gray-600 dark:text-gray-400">Berikan informasi tentang kolaborasi yang pernah Anda lakukan</p>
                                </div>

                                <!-- Kualitas Kolaborasi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        1. Kualitas Kolaborasi (1-5)
                                    </label>
                                    <select 
                                        wire:model="kualitas_kolaborasi"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                    >
                                        <option value="">Pilih kualitas kolaborasi</option>
                                        <option value="1">1 - Sangat Buruk</option>
                                        <option value="2">2 - Buruk</option>
                                        <option value="3">3 - Cukup</option>
                                        <option value="4">4 - Baik</option>
                                        <option value="5">5 - Sangat Baik</option>
                                    </select>
                                    @error('kualitas_kolaborasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Alasan:</label>
                                        <textarea 
                                            wire:model="kualitas_kolaborasi_alasan"
                                            rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white text-sm"
                                            placeholder="Jelaskan penilaian kualitas kolaborasi Anda..."
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Keragaman Kolaborator -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        2. Keragaman Kolaborator (Jumlah Jenis/Segmen)
                                    </label>
                                    <input 
                                        type="number" 
                                        wire:model="keragaman_kolaborator" 
                                        min="0"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                        placeholder="Masukkan jumlah jenis/segmen kolaborator"
                                    >
                                    @error('keragaman_kolaborator') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Alasan:</label>
                                        <textarea 
                                            wire:model="keragaman_kolaborator_alasan"
                                            rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white text-sm"
                                            placeholder="Jelaskan keragaman kolaborator Anda..."
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Jumlah Proyek Kolaborasi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        3. Jumlah Proyek Kolaborasi
                                    </label>
                                    <input 
                                        type="number" 
                                        wire:model="jumlah_proyek_kolaborasi" 
                                        min="0"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                        placeholder="Masukkan jumlah proyek kolaborasi"
                                    >
                                    @error('jumlah_proyek_kolaborasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Alasan:</label>
                                        <textarea 
                                            wire:model="jumlah_proyek_kolaborasi_alasan"
                                            rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white text-sm"
                                            placeholder="Jelaskan jumlah proyek kolaborasi Anda..."
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Tingkat Kolaborasi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        4. Tingkat Kolaborasi (1-5)
                                    </label>
                                    <select 
                                        wire:model="tingkat_kolaborasi"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                    >
                                        <option value="">Pilih tingkat kolaborasi</option>
                                        <option value="1">1 - Sangat Rendah</option>
                                        <option value="2">2 - Rendah</option>
                                        <option value="3">3 - Sedang</option>
                                        <option value="4">4 - Tinggi</option>
                                        <option value="5">5 - Sangat Tinggi</option>
                                    </select>
                                    @error('tingkat_kolaborasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Alasan:</label>
                                        <textarea 
                                            wire:model="tingkat_kolaborasi_alasan"
                                            rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white text-sm"
                                            placeholder="Jelaskan tingkat kolaborasi Anda..."
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Sumber Daya yang Disumbangkan -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        5. Sumber Daya yang Disumbangkan
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        @foreach($sumberDayaOptions as $key => $label)
                                            <label class="flex items-center">
                                                <input 
                                                    type="checkbox" 
                                                    wire:model="sumber_daya_disumbangkan" 
                                                    value="{{ $key }}"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                >
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('sumber_daya_disumbangkan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Alasan:</label>
                                        <textarea 
                                            wire:model="sumber_daya_disumbangkan_alasan"
                                            rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white text-sm"
                                            placeholder="Jelaskan sumber daya yang Anda sumbangkan..."
                                        ></textarea>
                                    </div>
                                </div>
                            </div>

                        @elseif($currentStep == 3)
                            <!-- Kategori Aksi -->
                            <div class="space-y-6">
                                <div class="text-center mb-6">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Kategori Aksi</h2>
                                    <p class="text-gray-600 dark:text-gray-400">Berikan informasi tentang aksi-aksi yang pernah Anda lakukan</p>
                                </div>

                                <!-- Jumlah Aksi Besar -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        1. Jumlah Aksi Besar
                                    </label>
                                    <input 
                                        type="number" 
                                        wire:model="jumlah_aksi_besar" 
                                        min="0"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                        placeholder="Masukkan jumlah aksi besar"
                                    >
                                    @error('jumlah_aksi_besar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Alasan:</label>
                                        <textarea 
                                            wire:model="jumlah_aksi_besar_alasan"
                                            rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white text-sm"
                                            placeholder="Jelaskan aksi besar yang pernah Anda lakukan..."
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Jumlah Aksi Sedang -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        2. Jumlah Aksi Sedang
                                    </label>
                                    <input 
                                        type="number" 
                                        wire:model="jumlah_aksi_sedang" 
                                        min="0"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                        placeholder="Masukkan jumlah aksi sedang"
                                    >
                                    @error('jumlah_aksi_sedang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Alasan:</label>
                                        <textarea 
                                            wire:model="jumlah_aksi_sedang_alasan"
                                            rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white text-sm"
                                            placeholder="Jelaskan aksi sedang yang pernah Anda lakukan..."
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Jumlah Aksi Kecil -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        3. Jumlah Aksi Kecil
                                    </label>
                                    <input 
                                        type="number" 
                                        wire:model="jumlah_aksi_kecil" 
                                        min="0"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                        placeholder="Masukkan jumlah aksi kecil"
                                    >
                                    @error('jumlah_aksi_kecil') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Alasan:</label>
                                        <textarea 
                                            wire:model="jumlah_aksi_kecil_alasan"
                                            rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white text-sm"
                                            placeholder="Jelaskan aksi kecil yang pernah Anda lakukan..."
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div>
                                @if($currentStep > 1)
                                    <button 
                                        type="button"
                                        wire:click="previousStep"
                                        class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                    >
                                        Sebelumnya
                                    </button>
                                @endif
                            </div>

                            <div>
                                @if($currentStep < $totalSteps)
                                    <button 
                                        type="submit"
                                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        Selanjutnya
                                    </button>
                                @else
                                    <button 
                                        type="submit"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                                    >
                                        Kirim Survey
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-6 text-center">
                    <flux:icon.exclamation-triangle class="size-16 text-yellow-500 mx-auto mb-4" />
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Tidak Ada Survey Aktif</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Saat ini tidak ada survey yang tersedia untuk diisi.</p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                        <flux:icon.arrow-left class="size-4 mr-2" />
                        Kembali ke Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
{{-- </x-layouts.app> --}}