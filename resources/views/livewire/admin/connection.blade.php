<div class="space-y-6">
    <!-- Page Header -->
    <x-admin.header title="Manajemen Koneksi" description="Kelola semua koneksi pengguna dalam sistem" />

    <!-- Filters -->
    <div
        class="p-4 space-y-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 2xl:grid-cols-4">

            <!-- Date From -->
            <flux:input wire:model.live="date_from" type="date" placeholder="Dari tanggal" class="w-full"
                label="Dari Tanggal" />
            <!-- Date To -->
            <flux:input wire:model.live="date_to" type="date" placeholder="Sampai tanggal" class="w-full"
                label="Sampai Tanggal" />

            @if ($date_from || $date_to)
                <div class="flex items-end justify-end w-full lg:col-span-2 col-span-1 sm:w-auto">
                    <flux:button wire:click="clearFilters" variant="outline">
                        Hapus Filter
                    </flux:button>
                </div>
            @endif
        </div>

        <!-- Active Filters Display -->
        @if ($date_from || $date_to)
            <div class="pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                <div class="flex flex-wrap gap-2">
                    <span class="w-full text-xs text-gray-600 sm:text-sm dark:text-slate-300 sm:w-auto">
                        Filter aktif:
                    </span>

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

    <!-- Connections Table -->
    <div class="overflow-hidden rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
        <!-- Mobile Card View (hidden on larger screens) -->
        <div class="block lg:hidden">
            @forelse($connections as $connection)
                <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <x-ui.avatar :user="$connection->requester" size="sm" />
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-medium text-primary-blue dark:text-secondary-green">
                                    {{ $connection->requester->name }}</div>
                                <div class="text-xs text-gray-600 dark:text-slate-300">
                                    {{ $connection->requester->email }}</div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <x-ui.avatar :user="$connection->receiver" size="sm" />
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-medium text-primary-blue dark:text-secondary-green">
                                    {{ $connection->receiver->name }}</div>
                                <div class="text-xs text-gray-600 dark:text-slate-300">
                                    {{ $connection->receiver->email }}</div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                @php
                                    $statusColors = [
                                        'pending' =>
                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                        'accepted' =>
                                            'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                        'declined' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$connection->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                    {{ ucfirst($connection->status) }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $connection->created_at->format('M d, Y H:i') }}
                            </div>
                        </div>

                        <div class="flex items-center pt-2 space-x-3">
                            {{-- <a href="{{ route('admin.connections.show', $connection) }}"
                                class="text-xs font-medium text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400">
                                Lihat
                            </a> --}}
                            <form method="POST" action="{{ route('admin.connections.delete', $connection) }}"
                                class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this connection? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs font-medium text-accent-red dark:text-accent-red hover:text-red-700 dark:hover:text-red-300">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="text-gray-600 dark:text-slate-300">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-slate-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                            </path>
                        </svg>
                        <p class="text-lg font-medium text-primary-blue dark:text-secondary-green">Tidak ada koneksi
                            ditemukan</p>
                        <p class="text-sm">Coba sesuaikan kriteria filter Anda</p>
                    </div>
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
                                Peminta
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                                Penerima
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                                Diminta
                            </th>

                            <!-- STICKY HEADER -->
                            <th
                                class="sticky right-0 z-20 px-6 py-4 text-xs font-medium tracking-wider text-right uppercase text-primary-blue/60 dark:text-slate-300 bg-slate-50 dark:bg-slate-700/50">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($connections as $connection)
                            <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <x-ui.avatar :user="$connection->requester" size="sm" />
                                        <div>
                                            <div
                                                class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                                {{ $connection->requester->name }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-slate-300">
                                                {{ $connection->requester->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <x-ui.avatar :user="$connection->receiver" size="sm" />
                                        <div>
                                            <div
                                                class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                                {{ $connection->receiver->name }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-slate-300">
                                                {{ $connection->receiver->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' =>
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                            'accepted' =>
                                                'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                            'declined' =>
                                                'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $statusColors[$connection->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                        {{ ucfirst($connection->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-300">
                                    {{ $connection->created_at->format('M d, Y H:i') }}
                                </td>

                                <!-- STICKY ACTION CELL -->
                                <td
                                    class="px-6 py-4 text-right sticky right-0 z-10
                            bg-white dark:bg-slate-900
                            shadow-[-8px_0_12px_-8px_rgba(0,0,0,0.15)]">

                                    <div class="flex items-center justify-end gap-3">
                                        {{-- <a href="{{ route('admin.connections.show', $connection) }}"
                                            class="text-sm font-medium text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400">
                                            Lihat
                                        </a> --}}

                                        <form method="POST"
                                            action="{{ route('admin.connections.delete', $connection) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this connection? This action cannot be undone.')">
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
                                        Tidak ada koneksi ditemukan
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-slate-300">
                                        Coba sesuaikan kriteria filter Anda
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
    @if ($connections->hasPages())
        <div class="flex justify-center">
            {{ $connections->links() }}
        </div>
    @endif
</div>
