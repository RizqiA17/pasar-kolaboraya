<div>
    <div class="space-y-6">
        <!-- Page Header -->
        <x-admin.header title="Manajemen Keahlian" description="Kelola semua keahlian dalam sistem">
            <flux:button wire:click="openCreate" variant="primary" icon="plus">
                Tambah Keahlian
            </flux:button>
        </x-admin.header>

        <!-- Filters -->
        <div
            class="p-4 space-y-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 2xl:grid-cols-4">

                <!-- Search -->
                <flux:input
                    wire:model.live.debounce.500ms="search"
                    placeholder="Cari keahlian..."
                    label="Pencarian"
                    class="w-full" />

                <!-- Date From -->
                <flux:input
                    wire:model.live="date_from"
                    type="date"
                    label="Dari Tanggal"
                    class="w-full" />

                <!-- Date To -->
                <flux:input
                    wire:model.live="date_to"
                    type="date"
                    label="Sampai Tanggal"
                    class="w-full" />

                @if ($search || $status || $date_from || $date_to)
                    <div class="flex items-end justify-end w-full">
                        <flux:button wire:click="clearFilters" variant="outline">
                            Hapus Filter
                        </flux:button>
                    </div>
                @endif
            </div>

            <!-- Active Filters -->
            @if ($search || $status || $date_from || $date_to)
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

                        @if ($status)
                            <span
                                class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                {{ ucfirst($status) }}
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

        <!-- Skills Table -->
        <div
            class="overflow-hidden rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">

            <!-- Mobile -->
            <div class="block lg:hidden">
                @forelse ($skills as $skill)
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>

                                <div class="flex-1">
                                    <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                        {{ $skill->name }}
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-slate-300">
                                        {{ $skill->profiles_count }} pengguna
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-xs text-gray-600 dark:text-slate-300">
                                <span>{{ $skill->created_at->format('M d, Y') }}</span>

                                <div class="flex gap-3">
                                    <button wire:click="openEdit({{ $skill->id }})" class="text-accent-orange">
                                        Edit
                                    </button>
                                    <button
                                        wire:click="delete({{ $skill->id }})"
                                        wire:confirm="Yakin hapus?"
                                        class="text-accent-red">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-600 dark:text-slate-300">
                        Tidak ada keahlian ditemukan
                    </div>
                @endforelse
            </div>

            <!-- Desktop -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-medium uppercase text-left text-primary-blue/60 dark:text-slate-300">
                                Keahlian
                            </th>
                            <th class="px-6 py-4 text-xs font-medium uppercase text-left text-primary-blue/60 dark:text-slate-300">
                                Pengguna
                            </th>
                            <th class="px-6 py-4 text-xs font-medium uppercase text-left text-primary-blue/60 dark:text-slate-300">
                                Dibuat
                            </th>
                            <th class="px-6 py-4 text-xs font-medium uppercase text-right text-primary-blue/60 dark:text-slate-300">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse ($skills as $skill)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-6 py-4 font-medium text-primary-blue dark:text-secondary-green">
                                    {{ $skill->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $skill->profiles_count }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-300">
                                    {{ $skill->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <button wire:click="openEdit({{ $skill->id }})"
                                            class="text-sm font-medium text-accent-orange">
                                            Edit
                                        </button>
                                        <button
                                            wire:click="delete({{ $skill->id }})"
                                            wire:confirm="Yakin hapus?"
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
                                        Tidak ada keahlian ditemukan
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
        @if ($skills->hasPages())
            <div class="flex justify-center">
                {{ $skills->links() }}
            </div>
        @endif
    </div>

    <!-- Modal -->
    @if ($showCreateModal || $showEditModal)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
            <div class="bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700 rounded-xl p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold mb-4">
                    {{ $showCreateModal ? 'Tambah Keahlian Baru' : 'Edit Keahlian' }}
                </h3>

                <flux:field>
                    <flux:label>Nama Keahlian</flux:label>
                    <flux:input wire:model.defer="name" />
                    @error('name')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <div class="flex justify-end space-x-3 mt-6">
                    <flux:button wire:click="closeModal">
                        Batal
                    </flux:button>

                    @if ($showCreateModal)
                        <flux:button variant="primary" wire:click="save">
                            Tambah Keahlian
                        </flux:button>
                    @else
                        <flux:button variant="primary" wire:click="update">
                            Perbarui Keahlian
                        </flux:button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
