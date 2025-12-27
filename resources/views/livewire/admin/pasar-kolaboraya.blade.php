<div class="space-y-6">
    <x-admin.header title="Manajemen Pasar Kolaboraya"
        description="Kelola semua sesi Pasar Kolaboraya dan pengguna yang terlibat di dalamnya.">
        <div class="flex items-center gap-3 max-sm:justify-between">
            <div class="text-sm text-gray-600 dark:text-gray-300">
                Total: {{ $stats['total'] }} sesi
            </div>

            <flux:button wire:click="showCreateForm" variant="primary" icon="plus">
                Buat Pasar Kolaboraya
            </flux:button>
        </div>
    </x-admin.header>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4 sm:gap-4 lg:gap-6">
        <!-- Active Sessions -->
        <x-admin.pasar-kolaboraya.stat-card title="Sesi Aktif" :stats="$pasarKolaborayas->where('status', 'active')->count()" icon="check-circle"
            iconColor="text-secondary-green dark:text-emerald-400" iconBg="bg-emerald-100 dark:bg-emerald-900/20" />

        <!-- Inactive Sessions -->
        <x-admin.pasar-kolaboraya.stat-card title="Tidak Aktif" :stats="$pasarKolaborayas->where('status', 'inactive')->count()" icon="pause-circle"
            iconColor="text-neutral-orange dark:text-orange-400" iconBg="bg-yellow-100 dark:bg-yellow-900/20" />

        <!-- Archived Sessions -->
        <x-admin.pasar-kolaboraya.stat-card title="Diarsipkan" :stats="$pasarKolaborayas->where('status', 'archived')->count()" icon="archive-box"
            iconColor="text-accent-red dark:text-red-400" iconBg="bg-red-100 dark:bg-red-900/20" />

        <!-- Total Users -->
        <x-admin.pasar-kolaboraya.stat-card title="Total Anggota" :stats="$pasarKolaborayas->sum(function ($pk) {
            return $pk->acceptedUsers->count();
        })" icon="users"
            iconColor="text-primary-blue dark:text-sky-400" iconBg="bg-sky-100 dark:bg-sky-900/20" />
    </div>

    <!-- Filters -->
    <div
        class="p-4 space-y-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 2xl:grid-cols-4">

            <!-- Search -->
            <flux:input wire:model.live.debounce.500ms="search" placeholder="Cari nama atau deskripsi..." class="w-full"
                label="Pencarian" />

            <!-- Status -->
            <flux:select wire:model.live="statusFilter" class="w-full" label="Status">
                <flux:select.option value="all">Semua Status</flux:select.option>
                <flux:select.option value="active">Aktif</flux:select.option>
                <flux:select.option value="inactive">Tidak Aktif</flux:select.option>
                <flux:select.option value="archived">Diarsipkan</flux:select.option>
            </flux:select>

            <!-- Clear Filter -->
            @if ($search || $statusFilter !== 'all')
                <div class="flex items-end justify-end lg:col-span-2 2xl:col-span-2">
                    <flux:button wire:click="clearFilters" variant="outline">
                        Hapus Filter
                    </flux:button>
                </div>
            @endif
        </div>

        <!-- Active Filters -->
        @if ($search || $statusFilter !== 'all')
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

                    @if ($statusFilter !== 'all')
                        <span
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900/20 dark:text-green-400">
                            Status: {{ ucfirst($statusFilter) }}
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>



    <!-- Pasar Kolaboraya List -->
    <div class="grid sm:grid-cols-[repeat(auto-fill,_minmax(512px,_1fr))] gap-4">
        @forelse($pasarKolaborayas as $pasarKolaboraya)
            <x-admin.pasar-kolaboraya.list-card :pasar="$pasarKolaboraya">
                <x-slot:actions>

                    <a href="{{ route('admin.pasar-kolaboraya.users', $pasarKolaboraya) }}"
                        class="flex items-center w-full px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <flux:icon.users class="w-4 h-4 mr-2" />
                        Kelola User
                    </a>

                    @if ($pasarKolaboraya->status === 'active')
                        <a href="{{ route('pasar-kolaboraya.qr.registration', $pasarKolaboraya->qr_code) }}"
                            class="flex items-center w-full px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-800">
                            <flux:icon.qr-code class="w-4 h-4 mr-2" />
                            QR Registrasi
                        </a>
                        <a href="{{ route('admin.pasar-kolaboraya.qr-scanner', $pasarKolaboraya) }}"
                            class="flex items-center w-full px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-800">
                            <flux:icon.camera class="w-4 h-4 mr-2" />
                            Buka Scanner
                        </a>
                    @endif

                    <a href="{{ route('admin.pasar-kolaboraya.users', $pasarKolaboraya) }}"
                        class="flex items-center w-full px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <flux:icon.users class="w-4 h-4 mr-2" />
                        Kelola User
                    </a>

                    <!-- Export Data Buttons -->
                    <a href="{{ route('admin.pasar-kolaboraya.export-csv', $pasarKolaboraya) }}"
                        class="flex items-center w-full px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <flux:icon.arrow-down-tray class="w-4 h-4 mr-2" />
                        Export CSV
                    </a>
                    {{-- <a href="{{ route('admin.pasar-kolaboraya.export-sql', $pasarKolaboraya) }}"
                                variant="outline" arrow-down-tray"
                                title="Download data user dalam format SQL untuk import ke database">
                                Export SQL
                            </a> --}}

                    @if ($pasarKolaboraya->status !== 'archived')
                        <button wire:click="deletePasarKolaboraya({{ $pasarKolaboraya->id }})"
                            wire:confirm="Apakah Anda yakin ingin mengarsipkan Pasar Kolaboraya ini?"
                            class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <flux:icon.archive-box class="w-4 h-4 mr-2" />
                            Arsipkan
                        </button>
                    @endif

                </x-slot:actions>
            </x-admin.pasar-kolaboraya.list-card>
        @empty
            @if ($search || $statusFilter !== 'all')
                <div
                    class="p-8 col-span-full text-center border shadow-lg bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl sm:p-12 border-white/20 dark:border-slate-700/50">
                    <div
                        class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl">
                        <flux:icon.cube class="w-8 h-8 text-primary-blue dark:text-primary-blue" />
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-primary-blue dark:text-secondary-green">
                        Tidak ada Pasar Kolaboraya yang cocok
                    </h3>
                    <p class="max-w-md mx-auto mb-6 text-gray-600 dark:text-slate-300">
                        Coba sesuaikan filter pencarian anda.
                    </p>
                </div>
            @else
                <div
                    class="p-8 col-span-full text-center border shadow-lg bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl sm:p-12 border-white/20 dark:border-slate-700/50">
                    <div
                        class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl">
                        <flux:icon.cube class="w-8 h-8 text-primary-blue dark:text-primary-blue" />
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-primary-blue dark:text-secondary-green">
                        Belum ada Pasar Kolaboraya
                    </h3>
                    <p class="max-w-md mx-auto mb-6 text-gray-600 dark:text-slate-300">
                        Mulai dengan membuat Pasar Kolaboraya pertama Anda untuk mengelola sesi kolaborasi pengguna.
                    </p>
                    <flux:button wire:click="showCreateForm" variant="primary" icon="plus">
                        Buat Pasar Kolaboraya
                    </flux:button>
                </div>
            @endif
        @endforelse
    </div>

    @if ($hasMore)
        <div x-data x-intersect.debounce.500ms="$wire.loadMore()" class="flex flex-col items-center py-6">
            <div class="w-6 h-6 border-b-2 border-primary-blue rounded-full animate-spin"></div>
            <div class="mt-2 text-xs text-gray-500">
                Memuat data...
            </div>
        </div>
    @endif

    <!-- Create Modal -->
    @if ($showCreateModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 lg:max-h-svh max-h-[calc(100svh_-_104px)]"
            wire:click="closeCreateModal" x-data x-on:keydown.escape.window="closeCreateModal">
            <div class="relative w-11/12 p-4 mx-auto top-4 sm:top-8 sm:w-3/4 lg:w-1/2 xl:w-2/5" wire:click.stop>
                <div
                    class="border shadow-2xl bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-2xl border-white/20 dark:border-slate-700/50">
                    <!-- Modal Header with Close Button -->
                    <div class="flex items-center justify-between p-6 border-b border-slate-200 dark:border-slate-700">
                        <h2 class="text-xl font-semibold text-primary-blue dark:text-secondary-green">
                            Buat Pasar Kolaboraya Baru
                        </h2>
                        <button wire:click="closeCreateModal"
                            class="transition-colors text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <flux:icon.x-mark class="w-6 h-6" />
                        </button>
                    </div>
                    <livewire:admin.create-pasar-kolaboraya />
                </div>
            </div>
        </div>
    @endif

    <script>
        function downloadQR(pasarCode) {
            // Generate QR code data
            const registrationUrl = `{{ url('/register/pasar-kolaboraya') }}/${encodeURIComponent(pasarCode)}`;

            // Create QR code using a simple approach
            const qrCodeData = registrationUrl;

            // Create a simple QR code using a library or generate SVG
            // For now, we'll redirect to the QR page and trigger download
            window.open(`{{ url('/pasar-kolaboraya/qr') }}/${encodeURIComponent(pasarCode)}?download=1`, '_blank');
        }
    </script>
</div>
