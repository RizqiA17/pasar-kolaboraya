<div class="space-y-6">
    <!-- Page Header -->
    <x-admin.header title="Manajemen Ekosistem" description="Kelola semua ekosistem pengguna dalam sistem" />

    <!-- Filters and Cari -->
    <div
        class="p-4 space-y-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">

        <!-- Search & Filters -->
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 2xl:grid-cols-4">
            <!-- Search Input -->
            <flux:input wire:model.live.debounce.500ms="search" placeholder="Cari ekosistem berdasarkan judul..."
                class="w-full" label="Cari" />
            <flux:select wire:model.live="status" placeholder="Filter berdasarkan status" label="Status">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif
                </option>
            </flux:select>
            <flux:input wire:model.live="date_from" type="date" placeholder="Dari tanggal" class="w-full"
                label="Dari Tanggal" />
            <!-- Date To -->
            <flux:input wire:model.live="date_to" type="date" placeholder="Sampai tanggal" class="w-full"
                label="Sampai Tanggal" />
            @if ($search || $status || $date_from || $date_to)
                <div class="w-full sm:w-auto 2xl:col-span-4 lg:col-span-2 col-span-1 flex justify-end items-end">
                    <flux:button wire:click="clearFilters" variant="outline">
                        Hapus Filter
                    </flux:button>
                </div>
            @endif
        </div>
        @if ($search || $status || $date_from || $date_to)
            <!-- Active Filters Display -->
            <div class="pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                <div class="flex flex-wrap gap-2">
                    <span class="w-full text-xs text-gray-600 sm:text-sm dark:text-slate-300 sm:w-auto">
                        Filter aktif:
                    </span>

                    @if ($search)
                        <span
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/20 dark:text-blue-400">
                            Pencarian: "{{ $search }}"
                        </span>
                    @endif

                    @if ($status)
                        <span
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-orange-800 bg-orange-100 rounded-full dark:bg-orange-900/20 dark:text-orange-400">
                            Status: {{ $status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    @endif

                    @if ($date_from)
                        <span
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900/20 dark:text-green-400">
                            Dari: {{ \Carbon\Carbon::parse($date_from)->format('d M Y') }}
                        </span>
                    @endif

                    @if ($date_to)
                        <span
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900/20 dark:text-green-400">
                            Sampai: {{ \Carbon\Carbon::parse($date_to)->format('d M Y') }}
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Ecosystems Table -->
    <div class="overflow-hidden rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
        <!-- Mobile Card View (hidden on larger screens) -->
        <div class="block lg:hidden">
            @forelse($ecosystems as $ecosystem)
                <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                    <div class="space-y-3">
                        <div>
                            <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                {{ $ecosystem->ecosystem_title }}</div>
                            <div class="text-xs text-gray-600 dark:text-slate-300 mt-1">
                                {{ Str::limit($ecosystem->description, 80) }}</div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <x-ui.avatar :user="$ecosystem->creator" size="sm" />
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-medium text-primary-blue dark:text-secondary-green">
                                    {{ $ecosystem->creator->name }}</div>
                                <div class="text-xs text-gray-600 dark:text-slate-300">{{ $ecosystem->creator->email }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                @php
                                    $statusColors = [
                                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'inactive' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ];
                                    $status = $ecosystem->is_active ? 'active' : 'inactive';
                                @endphp
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                    {{ $ecosystem->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $ecosystem->created_at->format('M d, Y') }}
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 pt-2">
                            {{-- <a href="{{ route('admin.ecosystems.show', $ecosystem) }}"
                                class="text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400 text-xs font-medium">
                                Lihat
                            </a> --}}
                            <form method="POST" action="{{ route('admin.ecosystems.delete', $ecosystem) }}"
                                class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this ecosystem? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-accent-red hover:text-red-700 dark:text-accent-red-400 dark:hover:text-red-400 text-xs font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <flux:icon.clipboard-document-list class="size-16 text-gray-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-primary-blue dark:text-secondary-green mb-2">Tidak ada ekosistem
                        ditemukan</h3>
                    <p class="text-gray-600 dark:text-slate-300 mb-4">Coba sesuaikan kriteria pencarian Anda</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (hidden on mobile) -->
        <div class="relative hidden lg:block">
            <!-- Horizontal Scroll Wrapper -->
            <div class="overflow-x-auto max-w-[calc(100svw_-_320px)]">
                <table class="min-w-[1100px] w-full border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                                Ekosistem
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                                Pembuat
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                                Status
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                                Dibuat
                            </th>

                            <!-- STICKY HEADER -->
                            <th
                                class="sticky right-0 z-20 px-6 py-4 text-xs font-medium tracking-wider text-right uppercase
                        text-primary-blue/60 dark:text-slate-300
                        bg-slate-50 dark:bg-slate-700/50">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($ecosystems as $ecosystem)
                            <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <!-- Ekosistem -->
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                            {{ $ecosystem->ecosystem_title }}
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-slate-300 truncate max-w-xs">
                                            {{ Str::limit($ecosystem->description, 60) }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Pembuat -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <x-ui.avatar :user="$ecosystem->creator" size="sm" />
                                        <div>
                                            <div
                                                class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                                {{ $ecosystem->creator->name }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-slate-300">
                                                {{ $ecosystem->creator->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'active' =>
                                                'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                            'inactive' =>
                                                'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                                        ];
                                        $status = $ecosystem->is_active ? 'active' : 'inactive';
                                    @endphp

                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                        {{ $ecosystem->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>

                                <!-- Created -->
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-300">
                                    {{ $ecosystem->created_at->format('M d, Y') }}
                                </td>

                                <!-- STICKY ACTION CELL -->
                                <td
                                    class="px-6 py-4 text-right sticky right-0 z-10
                            bg-white dark:bg-slate-900
                            shadow-[-8px_0_12px_-8px_rgba(0,0,0,0.15)]">

                                    <div class="flex items-center justify-end gap-3">
                                        {{-- <a href="{{ route('admin.ecosystems.show', $ecosystem) }}"
                                            class="text-sm font-medium text-primary-blue dark:text-secondary-green
                                    hover:text-sky-800 dark:hover:text-teal-400">
                                            Lihat
                                        </a> --}}

                                        <form method="POST"
                                            action="{{ route('admin.ecosystems.delete', $ecosystem) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this ecosystem? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm font-medium text-accent-red hover:text-red-700 dark:hover:text-red-300">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <p class="text-lg font-medium text-primary-blue dark:text-secondary-green">
                                        Tidak ada ekosistem ditemukan
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-slate-300">
                                        Coba sesuaikan kriteria pencarian Anda
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if ($ecosystems->hasPages())
        <div class="flex justify-center">
            {{ $ecosystems->links() }}
        </div>
    @endif
</div>
