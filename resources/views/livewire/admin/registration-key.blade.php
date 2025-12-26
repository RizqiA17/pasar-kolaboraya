<div class="space-y-6">
    <!-- Page Header -->
    <x-admin.header title="Kelola Kode Registrasi"
        description="Buat dan kelola kode registrasi untuk menentukan tipe user yang dapat mendaftar">
        <flux:button wire:click="openCreateModal" variant="primary" icon="plus">
            Buat Kode Baru
        </flux:button>
    </x-admin.header>


    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <x-admin.dashboard.stat-card iconColor="text-primary-blue dark:text-secondary-green" title="Total Kode" :stats="$stats['total'] ?? 0"/>
        <x-admin.dashboard.stat-card iconColor="text-green-600 dark:text-green-400" title="Aktif" :stats="$stats['active'] ?? 0"/>
        <x-admin.dashboard.stat-card iconColor="text-purple-600 dark:text-purple-400" title="Partisipan" :stats="$stats['partisipan'] ?? 0"/>
        <x-admin.dashboard.stat-card iconColor="text-yellow-600 dark:text-yellow-400" title="Tamu" :stats="$stats['tamu'] ?? 0"/>
        <x-admin.dashboard.stat-card iconColor="text-indigo-600 dark:text-indigo-400" title="Komunitas" :stats="$stats['komunitas'] ?? 0"/>
    </div>

    <!-- Keys List -->
    <div class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-primary-blue dark:text-secondary-green">Daftar Kode Registrasi</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase">
                            Kode</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase">
                            Tipe User</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase">
                            Deskripsi</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase">
                            Penggunaan</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase">
                            Status</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase">
                            Dibuat</th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody
                    class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($keys as $key)
                        <tr>
                            <td class="px-6 py-4">
                                <code
                                    class="text-sm font-mono text-primary-blue dark:text-secondary-green bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded select-all cursor-pointer"
                                    onclick="navigator.clipboard.writeText('{{ $key->key }}')"
                                    title="Klik untuk menyalin">{{ $key->key }}</code>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $key->user_type === 'partisipan'
                                        ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
                                        : ($key->user_type === 'tamu'
                                            ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                                            : 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200') }}">
                                    {{ $key->user_type_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-300">
                                {{ $key->description ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">
                                {{ $key->usage_count }}
                                @if ($key->max_usage)
                                    / {{ $key->max_usage }}
                                @else
                                    / ∞
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $key->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $key->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">
                                {{ $key->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="toggleKeyStatus({{ $key->id }})"
                                    class="text-accent-orange hover:text-orange-700 dark:text-accent-orange-400 dark:hover:text-orange-400 mr-2">
                                    {{ $key->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                                <button wire:click="deleteKey({{ $key->id }})"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kode ini?')"
                                    class="text-accent-red hover:text-red-700 dark:text-accent-red-400 dark:hover:text-red-400">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-600 dark:text-slate-300">
                                Tidak ada kode registrasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($keys->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $keys->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    @if ($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto  lg:max-h-svh max-h-[calc(100svh_-_104px)]">
            <div class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="fixed inset-0 bg-black/75 transition-opacity -z-10" wire:click="closeModals"></div>

                <div
                    class="inline-block bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <form wire:submit="createKey">
                        <div
                            class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-medium text-primary-blue dark:text-secondary-green mb-4">Buat Kode
                                Registrasi Baru
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-slate-400 mb-2">Kode
                                        Registrasi (Opsional)</label>
                                    <div class="flex">
                                        <input type="text" wire:model="key"
                                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                            placeholder="Kosongkan untuk generate otomatis">
                                        <button type="button" wire:click="generateRandomKey"
                                            class="px-3 py-2 bg-primary-blue dark:bg-secondary-green text-white text-sm font-medium rounded-r-md hover:bg-sky-800 dark:hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Generate
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">Kosongkan untuk generate
                                        kode random otomatis</p>
                                    @error('key')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-slate-400 mb-2">Tipe
                                        User</label>
                                    <select wire:model="user_type"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="partisipan">Partisipan</option>
                                        <option value="tamu">Tamu</option>
                                        <option value="komunitas">Komunitas</option>
                                    </select>
                                    @error('user_type')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-slate-400 mb-2">Deskripsi
                                        (Opsional)</label>
                                    <textarea wire:model="description" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Deskripsi untuk kode ini..."></textarea>
                                    @error('description')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-slate-400 mb-2">Maksimal
                                        Penggunaan (Opsional)</label>
                                    <input type="number" wire:model="max_usage" min="1"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Kosongkan untuk tidak terbatas">
                                    @error('max_usage')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-slate-400 mb-2">Kadaluarsa
                                        (Opsional)</label>
                                    <input type="datetime-local" wire:model="expires_at"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    @error('expires_at')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="is_active"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label class="ml-2 block text-sm text-gray-600 dark:text-slate-300">Aktifkan kode
                                        ini</label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-blue dark:bg-secondary-green text-base font-medium text-white hover:bg-sky-800 dark:hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Buat Kode
                            </button>
                            <button type="button" wire:click="closeModals"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 text-base font-medium text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    @endif

    <!-- Edit Modal -->
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="fixed inset-0 bg-black/75 transition-opacity -z-10" wire:click="closeModals"></div>

                <div
                    class="inline-block align-bottom bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit="updateKey">
                        <div
                            class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-medium text-primary-blue dark:text-secondary-green mb-4">Edit Kode
                                Registrasi
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-slate-400 mb-2">Kode
                                        Registrasi</label>
                                    <div class="flex">
                                        <input type="text" wire:model="key"
                                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        <button type="button" wire:click="generateRandomKey"
                                            class="px-3 py-2 bg-primary-blue dark:bg-secondary-green text-white text-sm font-medium rounded-r-md hover:bg-sky-800 dark:hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Generate
                                        </button>
                                    </div>
                                    @error('key')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-slate-400 mb-2">Tipe
                                        User</label>
                                    <select wire:model="user_type"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="partisipan">Partisipan</option>
                                        <option value="tamu">Tamu</option>
                                        <option value="komunitas">Komunitas</option>
                                    </select>
                                    @error('user_type')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-slate-400 mb-2">Deskripsi
                                        (Opsional)</label>
                                    <textarea wire:model="description" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Deskripsi untuk kode ini..."></textarea>
                                    @error('description')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-slate-400 mb-2">Maksimal
                                        Penggunaan (Opsional)</label>
                                    <input type="number" wire:model="max_usage" min="1"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Kosongkan untuk tidak terbatas">
                                    @error('max_usage')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-slate-400 mb-2">Kadaluarsa
                                        (Opsional)</label>
                                    <input type="datetime-local" wire:model="expires_at"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    @error('expires_at')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="is_active"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label class="ml-2 block text-sm text-gray-600 dark:text-slate-300">Aktifkan kode
                                        ini</label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-blue dark:bg-secondary-green text-base font-medium text-white hover:bg-sky-800 dark:hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan Perubahan
                            </button>
                            <button type="button" wire:click="closeModals"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 text-base font-medium text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
