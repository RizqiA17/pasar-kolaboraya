<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Manajemen Pasar Kolaboraya</h1>
            <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">Kelola semua sesi Pasar Kolaboraya
                dan pengguna yang terlibat di dalamnya.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                Total: {{ $pasarKolaborayas->total() }} sesi
            </div>
            <flux:button wire:click="showCreateForm" variant="primary" size="sm" icon="plus">
                Buat Pasar Kolaboraya
            </flux:button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
        <!-- Active Sessions -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Sesi Aktif</p>
                    <p class="text-2xl sm:text-3xl font-bold text-green-600 dark:text-green-400">
                        {{ $pasarKolaborayas->where('status', 'active')->count() }}</p>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 dark:bg-green-900/20 rounded-xl flex items-center justify-center">
                    <flux:icon.check-circle class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400" />
                </div>
            </div>
        </div>

        <!-- Inactive Sessions -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Tidak Aktif</p>
                    <p class="text-2xl sm:text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                        {{ $pasarKolaborayas->where('status', 'inactive')->count() }}</p>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-xl flex items-center justify-center">
                    <flux:icon.pause-circle class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600 dark:text-yellow-400" />
                </div>
            </div>
        </div>

        <!-- Archived Sessions -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Diarsipkan</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-600 dark:text-gray-400">
                        {{ $pasarKolaborayas->where('status', 'archived')->count() }}</p>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 dark:bg-gray-900/20 rounded-xl flex items-center justify-center">
                    <flux:icon.archive-box class="w-5 h-5 sm:w-6 sm:h-6 text-gray-600 dark:text-gray-400" />
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Total Anggota</p>
                    <p class="text-2xl sm:text-3xl font-bold text-blue-600 dark:text-blue-400">
                        {{ $pasarKolaborayas->sum(function ($pk) {return $pk->acceptedUsers->count();}) }}</p>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 dark:bg-blue-900/20 rounded-xl flex items-center justify-center">
                    <flux:icon.users class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div
        class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <flux:input wire:model.live="search" placeholder="Cari berdasarkan nama atau deskripsi..."
                    class="w-full" />
            </div>
            <div class="sm:w-48">
                <flux:select wire:model.live="statusFilter">
                    <flux:select.option value="all">Semua Status</flux:select.option>
                    <flux:select.option value="active">Aktif</flux:select.option>
                    <flux:select.option value="inactive">Tidak Aktif</flux:select.option>
                    <flux:select.option value="archived">Diarsipkan</flux:select.option>
                </flux:select>
            </div>
        </div>
    </div>

    <!-- Pasar Kolaboraya List -->
    <div class="space-y-4">
        @forelse($pasarKolaborayas as $pasarKolaboraya)
            <div
                class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                    <flux:icon.cube class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <a href="{{ route('admin.market-analysis.show', $pasarKolaboraya->id) }}"  class="text-lg font-semibold text-slate-800 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ $pasarKolaboraya->name }}
                                    </a>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        Dibuat oleh {{ $pasarKolaboraya->creator->name }}
                                    </p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 text-xs font-medium rounded-full
                                    @if ($pasarKolaboraya->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                    @elseif($pasarKolaboraya->status === 'inactive') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700/20 dark:text-gray-300 @endif">
                                {{ $pasarKolaboraya->status_label }}
                            </span>
                        </div>

                        @if ($pasarKolaboraya->description)
                            <p class="text-slate-600 dark:text-slate-400 mb-4 text-sm leading-relaxed">
                                {{ $pasarKolaboraya->description }}
                            </p>
                        @endif

                        <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 dark:text-slate-400">
                            <div class="flex items-center">
                                <flux:icon.users class="w-4 h-4 mr-2" />
                                <span class="font-medium">{{ $pasarKolaboraya->acceptedUsers->count() }}</span> anggota
                            </div>
                            <div class="flex items-center">
                                <flux:icon.calendar class="w-4 h-4 mr-2" />
                                {{ $pasarKolaboraya->created_at->format('d M Y') }}
                            </div>
                            @if ($pasarKolaboraya->started_at)
                                <div class="flex items-center">
                                    <flux:icon.play class="w-4 h-4 mr-2" />
                                    Dimulai {{ $pasarKolaboraya->started_at->format('d M Y') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 lg:flex-col lg:items-end">
                        @if ($pasarKolaboraya->status === 'active')
                            <flux:button wire:click="deactivatePasarKolaboraya({{ $pasarKolaboraya->id }})"
                                {{-- variant="secondary" --}} size="sm" icon="pause" >
                            Nonaktifkan
                            </flux:button>
                        @elseif($pasarKolaboraya->status === 'inactive')
                            <flux:button wire:click="activatePasarKolaboraya({{ $pasarKolaboraya->id }})"
                                variant="primary" size="sm" icon="play" >
                            Aktifkan
                            </flux:button>
                        @endif

                        @if ($pasarKolaboraya->status !== 'archived')
                            <flux:button wire:click="deletePasarKolaboraya({{ $pasarKolaboraya->id }})"
                                variant="danger" size="sm"
                                wire:confirm="Apakah Anda yakin ingin mengarsipkan Pasar Kolaboraya ini?" icon="archive-box" >
                                Arsipkan
                            </flux:button>
                        @endif

                        @if ($pasarKolaboraya->status === 'active')
                            <flux:button href="{{ route('admin.pasar-kolaboraya.qr-scanner', $pasarKolaboraya) }}"
                                variant="primary" size="sm" icon="qr-code" >
                                Buka Scanner
                            </flux:button>
                        @endif

                        <flux:button href="{{ route('admin.pasar-kolaboraya.users', $pasarKolaboraya) }}"
                            {{-- variant="secondary" --}} size="sm" icon="users" >
                            Kelola User
                        </flux:button>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-8 sm:p-12 border border-white/20 dark:border-slate-700/50 shadow-lg text-center">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <flux:icon.cube class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                </div>
                <h3 class="text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2">
                    Belum ada Pasar Kolaboraya
                </h3>
                <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-md mx-auto">
                    Mulai dengan membuat Pasar Kolaboraya pertama Anda untuk mengelola sesi kolaborasi pengguna.
                </p>
                <flux:button wire:click="showCreateForm" variant="primary" size="sm" icon="plus" >
                    Buat Pasar Kolaboraya
                </flux:button>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($pasarKolaborayas->hasPages())
        <div class="mt-6">
            {{ $pasarKolaborayas->links() }}
        </div>
    @endif

    <!-- Create Modal -->
    @if ($showCreateModal)
        <div 
            class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 lg:max-h-svh max-h-[calc(100svh_-_104px)]"
            wire:click="closeCreateModal"
            x-data
            x-on:keydown.escape.window="closeCreateModal"
        >
            <div 
                class="relative top-4 sm:top-8 mx-auto p-4 w-11/12 sm:w-3/4 lg:w-1/2 xl:w-2/5"
                wire:click.stop
            >
                <div
                    class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-2xl">
                    <!-- Modal Header with Close Button -->
                    <div class="flex items-center justify-between p-6 border-b border-slate-200 dark:border-slate-700">
                        <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200">
                            Buat Pasar Kolaboraya Baru
                        </h2>
                        <button 
                            wire:click="closeCreateModal"
                            class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors"
                        >
                            <flux:icon.x-mark class="w-6 h-6" />
                        </button>
                    </div>
                    <livewire:admin.create-pasar-kolaboraya />
                </div>
            </div>
        </div>
    @endif
</div>
