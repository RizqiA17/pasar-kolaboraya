<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="border-b border-gray-200 px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Ekosistem</h1>
            <p class="text-gray-600 mt-1">{{ $ecosystem->ecosystem_title }}</p>
        </div>

        <div class="p-6">
            @if (session()->has('message'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('message') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="updateSettings">
                <div class="space-y-6">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Aksi Kolektif</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input 
                                        wire:model="auto_join_collective_actions" 
                                        id="auto_join_collective_actions" 
                                        type="checkbox" 
                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                    >
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="auto_join_collective_actions" class="font-medium text-gray-700">
                                        Anggota Otomatis Bergabung ke Aksi Kolektif
                                    </label>
                                    <p class="text-gray-500 mt-1">
                                        Jika diaktifkan, semua anggota ekosistem akan otomatis bergabung ke aksi kolektif yang mengundang ekosistem ini. 
                                        Jika tidak diaktifkan, anggota perlu persetujuan admin aksi kolektif untuk bergabung.
                                    </p>
                                </div>
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-blue-800">Informasi Pengaturan</h4>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <ul class="list-disc list-inside space-y-1">
                                                <li>Pengaturan ini hanya berlaku untuk undangan ekosistem ke aksi kolektif baru</li>
                                                <li>User yang bukan anggota ekosistem tetap memerlukan persetujuan admin untuk bergabung</li>
                                                <li>Anggota dapat tetap keluar dari aksi kolektif meskipun bergabung secara otomatis</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('ecosystem.dashboard', $ecosystem) }}" 
                           class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-150">
                            Kembali
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-150">
                            Simpan Pengaturan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>