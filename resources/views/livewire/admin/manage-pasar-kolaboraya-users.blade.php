<div class="space-y-6">
    <!-- Page Header -->
    <x-admin.header title="Kelola User - {{ $pasarKolaboraya->name ?? '' }}" flexSize="lg"
        description="Kelola anggota dan permintaan bergabung di Pasar Kolaboraya ini.">

        <div class="flex items-center gap-2 max-sm:w-full max-sm:grid grid-cols-2">
            <div class="text-sm text-gray-600 dark:text-gray-300">
                Total: {{ $totalMembers }} anggota
            </div>

            <div class="flex justify-end">
                <flux:button href="{{ route('admin.pasar-kolaboraya.manage') }}" size="sm" icon="arrow-left" class="w-fit">
                    Kembali
                </flux:button>
            </div>

            @if ($pasarKolaboraya->status === 'active')
                <flux:button href="{{ route('pasar-kolaboraya.qr.registration', $pasarKolaboraya->qr_code) }}"
                    size="sm" variant="outline" icon="qr-code" class="max-sm:w-full">
                    QR Registrasi
                </flux:button>
            @endif

            <flux:button wire:click="showAddUserForm" variant="primary" size="sm" icon="plus"
                class="max-sm:w-full">
                Tambah User
            </flux:button>
        </div>
    </x-admin.header>

    <!-- Filters -->
    <div
        class="p-4 space-y-4 bg-white shadow-lg sm:p-6 rounded-xl dark:bg-slate-900 dark:border-t dark:border-slate-700">

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 2xl:grid-cols-4">

            <!-- Search -->
            <flux:input wire:model.live.debounce.500ms="search" placeholder="Cari user berdasarkan nama atau email..."
                class="w-full" label="Pencarian User" />

            @if ($search)
                <div class="flex items-end justify-end w-full 2xl:col-span-3">
                    <flux:button wire:click="$set('search', '')" variant="outline">
                        Hapus Filter
                    </flux:button>
                </div>
            @endif
        </div>

        <!-- Active Filters Display -->
        @if ($search)
            <div class="pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                <div class="flex flex-wrap gap-2">
                    <span class="w-full text-xs text-gray-600 sm:text-sm dark:text-slate-300 sm:w-auto">
                        Filter aktif:
                    </span>

                    <span
                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/20 dark:text-blue-400">
                        Pencarian: "{{ $search }}"
                    </span>
                </div>
            </div>
        @endif
    </div>


    <!-- Users List -->
    <div class="space-y-4">
        @forelse($users as $userPivot)
            <div
                class="p-4 transition-all duration-300 bg-white shadow-lg sm:p-6 rounded-xl dark:bg-slate-900 dark:border-t dark:border-slate-700">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl">
                            <span class="text-lg font-semibold text-white">
                                {{ substr($userPivot->user->name ?? '', 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">
                                {{ $userPivot->user->name ?? '' }}
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                {{ $userPivot->user->email ?? '' }}
                            </p>
                            <div class="flex items-center mt-1 space-x-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full
                                    @if ($userPivot->status === 'accepted') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                    @elseif($userPivot->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300
                                    @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 @endif">
                                    {{ $userPivot->status_label ?? '' }}
                                </span>
                                <span
                                    class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/20 dark:text-blue-300">
                                    {{ $userPivot->role_label ?? '' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        @if ($userPivot->status === 'pending')
                            <flux:button wire:click="approveUser({{ $userPivot->user->id ?? '' }})" variant="primary"
                                size="sm" icon="check">
                                Setujui
                            </flux:button>
                            <flux:button wire:click="rejectUser({{ $userPivot->user->id ?? '' }})" variant="danger"
                                size="sm" icon="x-mark">
                                Tolak
                            </flux:button>
                        @elseif($userPivot->status === 'accepted')
                            <flux:button wire:click="removeUser({{ $userPivot->user->id ?? '' }})" variant="danger"
                                size="sm" wire:confirm="Apakah Anda yakin ingin mengeluarkan user ini?"
                                icon="user-minus">
                                Keluarkan
                            </flux:button>
                        @endif
                    </div>
                </div>

                @if ($userPivot->join_reason)
                    <div class="p-3 mt-4 rounded-lg bg-slate-50 dark:bg-slate-700/50">
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            <span class="font-medium">Alasan bergabung:</span> {{ $userPivot->join_reason }}
                        </p>
                    </div>
                @endif

                @if ($userPivot->admin_notes)
                    <div class="p-3 mt-2 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            <span class="font-medium">Catatan admin:</span> {{ $userPivot->admin_notes }}
                        </p>
                    </div>
                @endif

                <div class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                    @if ($userPivot->joined_at)
                        Bergabung: {{ $userPivot->joined_at->format('d M Y H:i') }}
                    @endif
                    @if ($userPivot->invitedBy)
                        • Diundang oleh: {{ $userPivot->invitedBy->name ?? '' }}
                    @endif
                </div>
            </div>
        @empty
            @if ($search)
                <div
                    class="p-8 text-center border shadow-lg bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl sm:p-12 border-white/20 dark:border-slate-700/50">
                    <div
                        class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl">
                        <flux:icon.users class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-slate-800 dark:text-slate-200">
                        Tidak ada user yang cocok
                    </h3>
                    <p class="max-w-md mx-auto mb-6 text-slate-600 dark:text-slate-400">
                        Coba sesuaikan filter pencarian anda.
                    </p>
                </div>
            @else
                <div
                    class="p-8 text-center border shadow-lg bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl sm:p-12 border-white/20 dark:border-slate-700/50">
                    <div
                        class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl">
                        <flux:icon.users class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-slate-800 dark:text-slate-200">
                        Belum ada user
                    </h3>
                    <p class="max-w-md mx-auto mb-6 text-slate-600 dark:text-slate-400">
                        Belum ada user yang bergabung dengan Pasar Kolaboraya ini.
                    </p>
                    <flux:button wire:click="showAddUserForm" variant="primary" size="sm" icon="plus">
                        Tambah User
                    </flux:button>
                </div>
            @endif
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif

    <!-- Add User Modal -->
    @if ($showAddUserModal)
        <div class="fixed inset-0 z-50 w-full h-full overflow-y-auto bg-black/50 backdrop-blur-sm">
            <div class="relative w-11/12 p-4 mx-auto top-4 sm:top-8 sm:w-3/4 lg:w-1/2 xl:w-2/5">
                <div
                    class="border shadow-2xl bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-2xl border-white/20 dark:border-slate-700/50">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">
                                Tambah User ke Pasar Kolaboraya
                            </h3>
                            <flux:button wire:click="closeAddUserModal" {{-- variant="secondary" --}} size="sm"
                                icon="x-mark">
                                Batal
                            </flux:button>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <flux:input wire:model.live="search"
                                    placeholder="Cari user berdasarkan nama atau email..." class="w-full" />
                            </div>

                            <div
                                class="flex items-center justify-between p-3 border-b border-slate-200 dark:border-slate-700 bg-slate-100/50 dark:bg-slate-700/50 rounded-t-xl">
                                <div class="flex items-center space-x-3">
                                    <flux:checkbox wire:click="toggleSelectAll" :checked="$allUsersSelected" />
                                    <div class="font-medium text-slate-800 dark:text-slate-200">
                                        Pilih Semua
                                    </div>
                                </div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">
                                    {{ $availableUsers->whereNotIn('id', $pasarKolaboraya->users->pluck('id'))->count() }}
                                    user tersedia
                                </div>
                            </div>
                            <div
                                class="overflow-y-auto border-b border-l border-r border-slate-200 dark:border-slate-700 rounded-b-xl max-h-64 bg-slate-50/50 dark:bg-slate-800/50">
                                @forelse($availableUsers as $user)
                                    @if (!$pasarKolaboraya->isUserMember($user))
                                        <div
                                            class="flex items-center justify-between p-3 transition-colors border-b hover:bg-slate-100 dark:hover:bg-slate-700/50 border-slate-100 dark:border-slate-600 last:border-b-0">
                                            <div class="flex items-center space-x-3">
                                                <flux:checkbox wire:click="toggleUser({{ $user->id }})"
                                                    :checked="in_array($user->id, $selectedUsers)" />
                                                <div>
                                                    <div class="font-medium text-slate-800 dark:text-slate-200">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-slate-500 dark:text-slate-400">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="p-4 text-center text-slate-500 dark:text-slate-400">
                                        Tidak ada user yang tersedia
                                    </div>
                                @endforelse
                            </div>

                            @if (count($selectedUsers) > 0)
                                <div class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                    {{ count($selectedUsers) }} user dipilih
                                </div>
                            @endif

                            <div
                                class="flex justify-end pt-4 space-x-3 border-t border-slate-200 dark:border-slate-700">
                                <flux:button wire:click="closeAddUserModal" {{-- variant="secondary" --}}>
                                    Batal
                                </flux:button>
                                <flux:button wire:click="addSelectedUsers" variant="primary" icon="plus">
                                    Tambah User
                                </flux:button>
                            </div>
                        </div>
                    </div>
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
