<div class="space-y-6">
    <!-- Page Header -->
    <x-admin.header title="Manajemen Pengguna" description="Kelola semua pengguna dalam sistem" />

    <!-- Filters and Search -->
    <div
        class="p-4 space-y-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">

        <!-- Search & Filters -->
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 2xl:grid-cols-4">
            <!-- Search Input -->
            <flux:input wire:model.live.debounce.500ms="search" placeholder="Cari pengguna berdasarkan nama atau email..."
                class="w-full" label="Cari" />
            <!-- Role Filter -->
            <div>
                <flux:select wire:model.live="role" placeholder="Filter berdasarkan peran" label="Tipe">
                    <option value="">Semua Tipe</option>
                    <option value="user">Pengguna</option>
                    <option value="admin">Admin</option>
                    <option value="super_admin">Super Admin</option>
                </flux:select>
            </div>

            <!-- Peran Peserta Filter -->
            <div>
                <flux:select wire:model.live="peran_peserta" placeholder="Filter berdasarkan peran peserta"
                    label="Peran">
                    <option value="">Semua Peran Peserta</option>
                    <option value="ecosystem_builder">Ecosystem Builder</option>
                    @foreach ($perans as $peran)
                        <option value="{{ $peran->nama }}">{{ $peran->nama }}</option>
                    @endforeach
                </flux:select>
            </div>

            <!-- Status Filter -->
            <div>
                <flux:select wire:model.live="status" placeholder="Filter berdasarkan status" label="Status">
                    <option value="">Semua Status</option>
                    <option value="verified">Terverifikasi</option>
                    <option value="unverified">Belum Terverifikasi</option>
                </flux:select>
            </div>

        </div>
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 2xl:grid-cols-4">

            <!-- Date From -->
            <flux:input wire:model.live="date_from" type="date" placeholder="Dari tanggal" class="w-full"
                label="Dari Tanggal" />
            <!-- Date To -->
            <flux:input wire:model.live="date_to" type="date" placeholder="Sampai tanggal" class="w-full"
                label="Sampai Tanggal" />
            @if ($search || $role || $peran_peserta || $status || $date_from || $date_to)
                <div class="w-full sm:w-auto lg:col-span-2 col-span-1 flex justify-end items-end">
                    <flux:button wire:click="clearFilters" variant="outline">
                        Hapus Filter
                    </flux:button>
                </div>
            @endif
        </div>

        <!-- Active Filters Display -->
        @if ($search || $role || $peran_peserta || $status || $date_from || $date_to)
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

                    @if ($role)
                        <span
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded-full dark:bg-purple-900/20 dark:text-purple-400">
                            Tipe: {{ ucfirst(str_replace('_', ' ', $role)) }}
                        </span>
                    @endif

                    @if ($peran_peserta)
                        <span
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-indigo-800 bg-indigo-100 rounded-full dark:bg-indigo-900/20 dark:text-indigo-400">
                            Peran: {{ $peran_peserta }}
                        </span>
                    @endif

                    @if ($status)
                        <span
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-orange-800 bg-orange-100 rounded-full dark:bg-orange-900/20 dark:text-orange-400">
                            Status: {{ $status === 'verified' ? 'Terverifikasi' : 'Belum Terverifikasi' }}
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

    <!-- Users Table -->
    <div class="overflow-hidden rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
        <!-- Mobile Card View -->
        <div class="block lg:hidden">
            @forelse($users as $user)
                <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                    <div class="flex items-start space-x-3">
                        <x-ui.avatar :user="$user" size="md" />
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                        {{ $user->name }}
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-slate-300">
                                        {{ $user->email }}
                                    </div>
                                </div>

                                @php
                                    $roleColors = [
                                        'user' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'admin' =>
                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'super_admin' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ];
                                @endphp

                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between mt-2">
                                <div class="text-xs text-gray-600 dark:text-slate-300">
                                    {{ $user->created_at->format('M d, Y') }}
                                </div>

                                @if ($user->email_verified_at)
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-200">
                                        Terverifikasi
                                    </span>
                                @else
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold text-orange-800 bg-orange-100 rounded-full dark:bg-orange-900 dark:text-orange-200">
                                        Belum Terverifikasi
                                    </span>
                                @endif
                            </div>

                            <div class="mt-2">
                                @if ($user->is_ecosystem_builder)
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold text-purple-800 bg-purple-100 rounded-full dark:bg-purple-900 dark:text-purple-200">
                                        Ecosystem Builder
                                    </span>
                                @elseif($user->assigned_role)
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-200">
                                        {{ $user->assigned_role }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full dark:bg-gray-600 dark:text-gray-200">
                                        Belum Dipilih
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center mt-3 space-x-3">
                                <a href="{{ route('admin.users.show', $user) }}"
                                    class="text-xs font-medium text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400">
                                    Lihat
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="text-xs font-medium text-accent-orange hover:text-orange-700 dark:text-accent-orange-400 dark:hover:text-orange-400">
                                    Edit
                                </a>
                                @if (!$user->isSuperAdmin() || $superAdminCount > 1)
                                    <button wire:click="delete({{ $user->id }})" wire:confirm="Yakin hapus user ini?"
                                        class="text-xs font-medium text-accent-red hover:text-red-700 dark:text-accent-red-400 dark:hover:text-red-400">
                                        Hapus
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <flux:icon.clipboard-document-list class="mx-auto mb-4 text-gray-400 size-16" />
                    <h3 class="mb-2 text-lg font-medium text-primary-blue dark:text-secondary-green">
                        Tidak ada pengguna ditemukan
                    </h3>
                    <p class="mb-4 text-gray-600 dark:text-slate-300">
                        Coba sesuaikan kriteria pencarian Anda
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block relative">
            <!-- Horizontal Scroll Wrapper -->
            <div class="overflow-x-auto max-w-[calc(100svw_-_320px)]">
                <table class="min-w-[1100px] w-full border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium uppercase text-primary-blue/60 dark:text-slate-300">
                                Pengguna
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium uppercase text-primary-blue/60 dark:text-slate-300">
                                Tipe
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium uppercase text-primary-blue/60 dark:text-slate-300">
                                Peran
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium uppercase text-primary-blue/60 dark:text-slate-300">
                                Bergabung
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium uppercase text-primary-blue/60 dark:text-slate-300">
                                Status
                            </th>

                            <!-- STICKY HEADER -->
                            <th
                                class="px-6 py-4 text-right text-xs font-medium uppercase text-primary-blue/60 dark:text-slate-300 sticky right-0 z-20 bg-slate-50 dark:bg-slate-700/50">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <x-ui.avatar :user="$user" size="md" />
                                        <div>
                                            <div
                                                class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-slate-300">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($user->is_ecosystem_builder)
                                        <span class="badge-purple">Ecosystem Builder</span>
                                    @elseif($user->assigned_role)
                                        <span class="badge-blue">{{ $user->assigned_role }}</span>
                                    @else
                                        <span class="badge-gray">Belum Dipilih</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-primary-blue dark:text-secondary-green">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    @if ($user->email_verified_at)
                                        <span class="badge-green">Terverifikasi</span>
                                    @else
                                        <span class="badge-orange">Belum Terverifikasi</span>
                                    @endif
                                </td>

                                <!-- STICKY ACTION CELL -->
                                <td
                                    class="px-6 py-4 text-right sticky right-0 z-10 bg-white dark:bg-slate-900 shadow-[-8px_0_12px_-8px_rgba(0,0,0,0.15)]">

                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                            class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                            Lihat
                                        </a>

                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="text-sm font-medium text-accent-orange">
                                            Edit
                                        </a>

                                        @if (!$user->isSuperAdmin() || $superAdminCount > 1)
                                            <button wire:click="delete({{ $user->id }})" wire:confirm="Yakin hapus user ini?"
                                                class="text-sm font-medium text-accent-red">
                                                Hapus
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <flux:icon.clipboard-document-list class="mx-auto mb-4 text-gray-400 size-16" />
                                    <h3 class="text-lg font-medium text-primary-blue dark:text-secondary-green">
                                        Tidak ada pengguna ditemukan
                                    </h3>
                                    <p class="text-gray-600 dark:text-slate-300">
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
    @if ($users->hasPages())
        <div class="flex justify-center">
            {{ $users->links() }}
        </div>
    @endif
</div>
