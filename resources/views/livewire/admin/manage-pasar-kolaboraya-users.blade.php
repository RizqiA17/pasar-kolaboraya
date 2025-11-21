<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">
                Kelola User - {{ $pasarKolaboraya->name ?? '' }}
            </h1>
            <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">
                Kelola anggota dan permintaan bergabung di Pasar Kolaboraya ini.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <flux:button href="{{ route('admin.pasar-kolaboraya.manage') }}" {{-- variant="secondary" --}} size="sm"
                icon="arrow-left">
                Kembali
            </flux:button>
            @if ($pasarKolaboraya->status === 'active')
                <flux:button href="{{ route('pasar-kolaboraya.qr.registration', $pasarKolaboraya->qr_code) }}"
                    variant="primary" size="sm" icon="qr-code">
                    QR Registrasi
                </flux:button>
                <flux:button onclick="downloadQR('{{ $pasarKolaboraya->qr_code }}')"
                    variant="outline" size="sm" icon="arrow-down-tray">
                    Download QR
                </flux:button>
                {{-- <flux:button href="{{ route('pasar-kolaboraya.qr.printable', $pasarKolaboraya->qr_code) }}"
                    variant="outline" size="sm" icon="printer">
                    Print Poster
                </flux:button> --}}
            @endif
            <flux:button wire:click="showAddUserForm" variant="outline" size="sm" icon="plus">
                Tambah User
            </flux:button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
        <!-- Total Members -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Total Anggota</p>
                    <p class="text-2xl sm:text-3xl font-bold text-blue-600 dark:text-blue-400">
                        {{ $totalMembers }}</p>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 dark:bg-blue-900/20 rounded-xl flex items-center justify-center">
                    <flux:icon.users class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Menunggu Persetujuan
                    </p>
                    <p class="text-2xl sm:text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                        {{ $totalPending }}</p>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-xl flex items-center justify-center">
                    <flux:icon.clock class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600 dark:text-yellow-400" />
                </div>
            </div>
        </div>

        <!-- Rejected -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Ditolak</p>
                    <p class="text-2xl sm:text-3xl font-bold text-red-600 dark:text-red-400">
                        {{ $totalRejected }}</p>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 dark:bg-red-900/20 rounded-xl flex items-center justify-center">
                    <flux:icon.x-mark class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-400" />
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div
        class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <flux:input wire:model.live="search" placeholder="Cari user berdasarkan nama atau email..."
                    class="w-full" />
            </div>
            <div class="sm:w-48">
                <flux:select wire:model.live="statusFilter">
                    <flux:select.option value="all">Semua Status</flux:select.option>
                    <flux:select.option value="accepted">Diterima</flux:select.option>
                    <flux:select.option value="pending">Menunggu</flux:select.option>
                    <flux:select.option value="rejected">Ditolak</flux:select.option>
                </flux:select>
            </div>
        </div>
    </div>

    <!-- Users List -->
    <div class="space-y-4">
        @forelse($users as $userPivot)
            <div
                class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-semibold text-lg">
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
                            <div class="flex items-center space-x-4 mt-1">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full
                                    @if ($userPivot->status === 'accepted') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                    @elseif($userPivot->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300
                                    @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 @endif">
                                    {{ $userPivot->status_label ?? '' }}
                                </span>
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
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
                    <div class="mt-4 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            <span class="font-medium">Alasan bergabung:</span> {{ $userPivot->join_reason }}
                        </p>
                    </div>
                @endif

                @if ($userPivot->admin_notes)
                    <div class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
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
            <div
                class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-8 sm:p-12 border border-white/20 dark:border-slate-700/50 shadow-lg text-center">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <flux:icon.users class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                </div>
                <h3 class="text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2">
                    Belum ada user
                </h3>
                <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-md mx-auto">
                    Belum ada user yang bergabung dengan Pasar Kolaboraya ini.
                </p>
                <flux:button wire:click="showAddUserForm" variant="primary" size="sm" icon="plus">
                    Tambah User
                </flux:button>
            </div>
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
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
            <div class="relative top-4 sm:top-8 mx-auto p-4 w-11/12 sm:w-3/4 lg:w-1/2 xl:w-2/5">
                <div
                    class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-2xl">
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

                            <div class="flex items-center justify-between p-3 border-b border-slate-200 dark:border-slate-700 bg-slate-100/50 dark:bg-slate-700/50 rounded-t-xl">
                                <div class="flex items-center space-x-3">
                                    <flux:checkbox wire:click="toggleSelectAll" :checked="$allUsersSelected" />
                                    <div class="font-medium text-slate-800 dark:text-slate-200">
                                        Pilih Semua
                                    </div>
                                </div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">
                                    {{ $availableUsers->whereNotIn('id', $pasarKolaboraya->users->pluck('id'))->count() }} user tersedia
                                </div>
                            </div>
                            <div
                                class="border-l border-r border-b border-slate-200 dark:border-slate-700 rounded-b-xl max-h-64 overflow-y-auto bg-slate-50/50 dark:bg-slate-800/50">
                                @forelse($availableUsers as $user)
                                    @if (!$pasarKolaboraya->isUserMember($user))
                                        <div
                                            class="flex items-center justify-between p-3 hover:bg-slate-100 dark:hover:bg-slate-700/50 border-b border-slate-100 dark:border-slate-600 last:border-b-0 transition-colors">
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
                                <div class="text-sm text-blue-600 dark:text-blue-400 font-medium">
                                    {{ count($selectedUsers) }} user dipilih
                                </div>
                            @endif

                            <div
                                class="flex justify-end space-x-3 pt-4 border-t border-slate-200 dark:border-slate-700">
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
