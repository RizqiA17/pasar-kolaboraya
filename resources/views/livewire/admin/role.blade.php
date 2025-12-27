<div>
    <div class="space-y-6">
        <!-- Header -->
        <x-admin.header title="Manajemen Peran" description="Kelola semua peran dalam sistem">

            <flux:button wire:click="openCreate" variant="primary" icon="plus">
                Tambah Peran
            </flux:button>

        </x-admin.header>

        <!-- Filters -->
        <div
            class="p-4 space-y-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 2xl:grid-cols-4">

                <!-- Search -->
                <flux:input wire:model.live.debounce.500ms="search" placeholder="Cari nama atau deskripsi peran..."
                    label="Pencarian" class="w-full" />

                <!-- Date From -->
                <flux:input wire:model.live="date_from" type="date" label="Dari Tanggal" class="w-full" />

                <!-- Date To -->
                <flux:input wire:model.live="date_to" type="date" label="Sampai Tanggal" class="w-full" />

                @if ($search || $date_from || $date_to)
                    <div class="flex items-end justify-end w-full">
                        <flux:button wire:click="clearFilters" variant="outline">
                            Hapus Filter
                        </flux:button>
                    </div>
                @endif
            </div>

            <!-- Active Filters -->
            @if ($search || $date_from || $date_to)
                <div class="pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                    <div class="flex flex-wrap gap-2">
                        <span class="text-xs text-gray-600 dark:text-slate-300">
                            Filter aktif:
                        </span>

                        @if ($search)
                            <span
                                class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                                "{{ $search }}"
                            </span>
                        @endif

                        @if ($date_from)
                            <span
                                class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                Dari: {{ \Carbon\Carbon::parse($date_from)->format('d M Y') }}
                            </span>
                        @endif

                        @if ($date_to)
                            <span
                                class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                Sampai: {{ \Carbon\Carbon::parse($date_to)->format('d M Y') }}
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>


        <!-- Table -->
        <div
            class="overflow-hidden rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">

            <!-- Mobile -->
            <div class="block lg:hidden">
                @forelse ($roles as $role)
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                        <div class="space-y-3">

                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>

                                <div class="flex-1">
                                    <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                        {{ $role->nama }}
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-slate-300">
                                        {{ $role->profiles_count }} pengguna
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-xs text-gray-600 dark:text-slate-300">
                                <span>{{ $role->created_at->format('d M Y') }}</span>

                                <div class="flex gap-3">
                                    <button wire:click="openEdit({{ $role->id }})" class="text-accent-orange">
                                        Edit
                                    </button>

                                    <button wire:click="delete({{ $role->id }})"
                                        wire:confirm="Yakin hapus peran ini?" class="text-accent-red">
                                        Hapus
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-600 dark:text-slate-300">
                        Tidak ada peran ditemukan
                    </div>
                @endforelse
            </div>

            <!-- Desktop -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-xs font-medium uppercase text-left text-primary-blue/60 dark:text-slate-300">
                                Peran
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-medium uppercase text-left text-primary-blue/60 dark:text-slate-300">
                                Pengguna
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-medium uppercase text-left text-primary-blue/60 dark:text-slate-300">
                                Dibuat
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-medium uppercase text-right text-primary-blue/60 dark:text-slate-300">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse ($roles as $role)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-6 py-4 font-medium text-primary-blue dark:text-secondary-green">
                                    {{ $role->nama }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $role->profiles_count }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-300">
                                    {{ $role->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <button wire:click="openEdit({{ $role->id }})"
                                            class="text-sm font-medium text-accent-orange">
                                            Edit
                                        </button>
                                        <button wire:click="delete({{ $role->id }})"
                                            wire:confirm="Yakin hapus peran ini?"
                                            class="text-sm font-medium text-accent-red">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <p class="text-lg font-medium text-primary-blue dark:text-secondary-green">
                                        Tidak ada peran ditemukan
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-slate-300">
                                        Coba sesuaikan filter
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pagination -->
        @if ($roles->hasPages())
            <div class="flex justify-center">
                {{ $roles->links() }}
            </div>
        @endif
    </div>

    <!-- Modal -->
    @if ($showCreateModal || $showEditModal)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
            <div
                class="bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700 rounded-xl p-6 w-full max-w-md">

                <h3 class="text-lg font-semibold mb-4">
                    {{ $showCreateModal ? 'Tambah Peran' : 'Edit Peran' }}
                </h3>

                <flux:field>
                    <flux:label>Nama Peran</flux:label>
                    <flux:input wire:model.defer="nama" />
                    @error('nama')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <flux:field class="mt-4">
                    <flux:label>Deskripsi</flux:label>
                    <flux:textarea wire:model.defer="deskripsi" rows="3" />
                    @error('deskripsi')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <div class="flex justify-end gap-3 mt-6">
                    <flux:button wire:click="closeModal">
                        Batal
                    </flux:button>

                    @if ($showCreateModal)
                        <flux:button variant="primary" wire:click="save">
                            Simpan
                        </flux:button>
                    @else
                        <flux:button variant="primary" wire:click="update">
                            Perbarui
                        </flux:button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
