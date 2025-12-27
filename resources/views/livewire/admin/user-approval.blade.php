<div class="space-y-6">
    <!-- Page Header -->
    <x-admin.header title="Kelola Persetujuan User" description="Kelola persetujuan dan penolakan user yang mendaftar" />

    <!-- Stats -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
        <x-admin.dashboard.stat-card iconColor="text-primary-blue dark:text-secondary-green" title="Total User"
            :stats="$stats['total'] ?? 0" />
        <x-admin.dashboard.stat-card iconColor="text-yellow-600 dark:text-yellow-400" title="Menunggu"
            :stats="$stats['pending'] ?? 0" />
        <x-admin.dashboard.stat-card iconColor="text-green-600 dark:text-green-400" title="Disetujui" :stats="$stats['approved'] ?? 0" />
        <x-admin.dashboard.stat-card iconColor="text-red-600 dark:text-red-400" title="Ditolak" :stats="$stats['rejected'] ?? 0" />
    </div>
    <div
        class="p-4 space-y-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 2xl:grid-cols-4">
            <!-- Search Input -->
            <flux:input wire:model.live.debounce.500ms="search"
                placeholder="Cari aksi kolektif berdasarkan nama atau email..." class="w-full" label="Cari" />
            <flux:select wire:model.live="status" placeholder="Filter berdasarkan status" label="Status">
                <option value="">Semua Status</option>
                <option value="pending">Menunggu</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </flux:select>
            {{-- <flux:input wire:model.live="date_from" type="date" placeholder="Dari tanggal" class="w-full"
                label="Dari Tanggal" />
            <!-- Date To -->
            <flux:input wire:model.live="date_to" type="date" placeholder="Sampai tanggal" class="w-full"
                label="Sampai Tanggal" /> --}}
            @if ($search || $status)
                <div class="flex items-end justify-end w-full col-span-1 sm:w-auto 2xl:col-span-4 lg:col-span-2">
                    <flux:button wire:click="clearFilters" variant="outline">
                        Hapus Filter
                    </flux:button>
                </div>
            @endif
        </div>
        @if ($search || $status)
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
                            Status:
                            {{ $status === 'pending' ? 'Menunggu' : ($status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Users List -->
    <div class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-primary-blue dark:text-secondary-green">Daftar User</h3>
        </div>

        <!-- Horizontal Scroll Wrapper -->
        <div class="overflow-x-auto max-w-[calc(100svw_-_48px)] sm:max-w-[calc(100svw_-_320px)]">
            <table class="min-w-[1200px] w-full border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th
                            class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                            User
                        </th>
                        <th
                            class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                            Tipe
                        </th>
                        <th
                            class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                            Status
                        </th>
                        <th
                            class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                            Peran
                        </th>
                        <th
                            class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                            Tanggal Daftar
                        </th>
                        <th
                            class="px-6 py-4 text-xs font-medium tracking-wider text-left uppercase text-primary-blue/60 dark:text-slate-300">
                            Diapprove Oleh
                        </th>

                        <!-- STICKY HEADER -->
                        <th
                            class="sticky right-0 z-20 px-6 py-4 text-xs font-medium tracking-wider text-right uppercase text-primary-blue/60 dark:text-slate-300 bg-slate-50 dark:bg-slate-700/50">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($users as $user)
                        <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-700/50">

                            <!-- USER -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600">
                                        <span class="text-sm font-medium text-white">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </span>
                                    </div>

                                    <div>
                                        <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-slate-300">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- TIPE -->
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $user->user_type === 'partisipan'
                                    ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400'
                                    : ($user->user_type === 'tamu'
                                        ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400'
                                        : 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-400') }}">
                                    {{ $user->user_type_label }}
                                </span>
                            </td>

                            <!-- STATUS -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $user->approval_status === 'pending'
                                        ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400'
                                        : ($user->approval_status === 'approved'
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400'
                                            : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400') }}">
                                        {{ $user->approval_status_label }}
                                    </span>

                                    @if ($user->trashed())
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full dark:bg-gray-900/20 dark:text-gray-400">
                                            Dihapus
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- PERAN -->
                            <td class="px-6 py-4">
                                @if ($user->assigned_role)
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $user->assigned_role === 'Ecosystem Builder'
                                        ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400'
                                        : 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400' }}">
                                        {{ $user->assigned_role }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- TANGGAL DAFTAR -->
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-300">
                                {{ $user->created_at->format('d M Y H:i') }}
                            </td>

                            <!-- APPROVED BY -->
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-300">
                                @if ($user->approvedBy)
                                    {{ $user->approvedBy->name }}
                                    <div class="text-xs text-gray-500 dark:text-slate-400">
                                        {{ optional($user->approved_at)->format('d M Y H:i') }}
                                    </div>
                                @else
                                    -
                                @endif
                            </td>

                            <!-- STICKY ACTION CELL -->
                            <td
                                class="px-6 py-4 text-right sticky right-0 z-10
                            bg-white dark:bg-slate-900
                            shadow-[-8px_0_12px_-8px_rgba(0,0,0,0.15)]">

                                @if ($user->trashed())
                                    <span class="text-sm text-gray-500 dark:text-slate-400">
                                        Tidak dapat diakses
                                    </span>
                                @elseif($user->approval_status === 'pending')
                                    <button wire:click="openApprovalModal({{ $user->id }})"
                                        class="text-sm font-medium text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400">
                                        Kelola
                                    </button>
                                @else
                                    <button wire:click="openApprovalModal({{ $user->id }})"
                                        class="text-sm font-medium text-gray-600 dark:text-slate-300 hover:text-primary-blue dark:hover:text-secondary-green">
                                        Lihat Detail
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <p class="text-lg font-medium text-primary-blue dark:text-secondary-green">
                                    Tidak ada user
                                </p>
                                <p class="text-sm text-gray-600 dark:text-slate-300">
                                    Belum ada user yang mendaftar
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
    @if ($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $users->links() }}
        </div>
    @endif

    <!-- Approval Modal -->
    @if ($isApprovalModalOpen && $selectedUser)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="fixed inset-0 transition-opacity bg-black/75 -z-10" wire:click="resetApprovalModal"></div>

                <div
                    class="inline-block bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-2xl sm:w-full">
                    <div
                        class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="mb-4 text-lg font-medium text-primary-blue dark:text-secondary-green">
                            @if ($selectedUser->trashed())
                                Detail User (Dihapus): {{ $selectedUser->name }}
                            @elseif($selectedUser->approval_status === 'pending')
                                Kelola User: {{ $selectedUser->name }}
                            @else
                                Detail User: {{ $selectedUser->name }}
                            @endif
                        </h3>

                        <div class="space-y-6">
                            <!-- User Info -->
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0 w-16 h-16">
                                        <div
                                            class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-600">
                                            <span class="text-xl font-medium text-white">
                                                {{ strtoupper(substr($selectedUser->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-medium text-primary-blue dark:text-secondary-green">
                                            {{ $selectedUser->name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-slate-300">
                                            {{ $selectedUser->email }}
                                        </p>
                                        <div class="flex mt-2 space-x-2">
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full
                                                {{ $selectedUser->user_type === 'partisipan'
                                                    ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
                                                    : ($selectedUser->user_type === 'tamu'
                                                        ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                                                        : 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200') }}">
                                                {{ $selectedUser->user_type_label }}
                                            </span>
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full
                                                {{ $selectedUser->approval_status === 'pending'
                                                    ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                                                    : ($selectedUser->approval_status === 'approved'
                                                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                        : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                                {{ $selectedUser->approval_status_label }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Registration Details -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block mb-1 text-sm font-medium text-gray-500 dark:text-slate-400">Tanggal
                                        Daftar</label>
                                    <p class="text-sm text-primary-blue dark:text-secondary-green">
                                        {{ $selectedUser->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-slate-400">Kode
                                        Registrasi</label>
                                    <p class="font-mono text-sm text-primary-blue dark:text-secondary-green">
                                        {{ $selectedUser->registration_key ?: '-' }}</p>
                                </div>
                            </div>

                            @if ($selectedUser->approval_status !== 'pending')
                                @if ($selectedUser->approval_status === 'rejected')
                                    <div
                                        class="p-4 border border-red-200 rounded-lg bg-red-50 dark:bg-red-900/20 dark:border-red-800">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                                    User Ditolak
                                                </h3>
                                                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                                    @if ($selectedUser->approval_reason)
                                                        <p><strong>Alasan Penolakan:</strong>
                                                            {{ $selectedUser->approval_reason }}</p>
                                                    @else
                                                        <p>User ini ditolak dan dihapus dari sistem.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label
                                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-slate-400">Peran</label>
                                            <div class="flex items-center space-x-2">
                                                <p class="text-sm text-primary-blue dark:text-secondary-green">
                                                    {{ $selectedUser->assigned_role ?: '-' }}
                                                </p>
                                                @if ($selectedUser->assigned_role === 'Ecosystem Builder')
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded-full dark:bg-purple-900 dark:text-purple-200">
                                                        Ecosystem Builder
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <label
                                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-slate-400">Diapprove
                                                Oleh</label>
                                            <p class="text-sm text-primary-blue dark:text-secondary-green">
                                                {{ $selectedUser->approvedBy ? $selectedUser->approvedBy->name : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    @if ($selectedUser->approval_reason)
                                        <div>
                                            <label
                                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-slate-400">Alasan</label>
                                            <p class="text-sm text-gray-600 dark:text-slate-300">
                                                {{ $selectedUser->approval_reason }}</p>
                                        </div>
                                    @endif
                                @endif
                            @endif

                            @if ($selectedUser->approval_status === 'pending')
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-medium text-gray-500 dark:text-slate-400">Peran
                                        yang Akan Diberikan</label>
                                    <select wire:model="assignedPeran"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        @if ($selectedUser->user_type === 'tamu')
                                            <option value="Tamu" selected>Tamu</option>
                                        @elseif ($selectedUser->user_type === 'komunitas')
                                            <option value="Komunitas" selected>Komunitas</option>
                                        @else
                                            <option value="">Pilih Peran</option>
                                        @endif
                                        <option value="Ecosystem Builder">Ecosystem Builder</option>
                                        @foreach ($peran as $role)
                                            <option value="{{ $role->nama }}">{{ $role->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('assignedPeran')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block mb-2 text-sm font-medium text-gray-500 dark:text-slate-400">Alasan
                                        (Opsional)</label>
                                    <textarea wire:model="approvalReason" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Alasan persetujuan atau penolakan..."></textarea>
                                    @error('approvalReason')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($selectedUser->trashed())
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button wire:click="resetApprovalModal"
                                class="w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Tutup
                            </button>
                        </div>
                    @elseif($selectedUser->approval_status === 'pending')
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button wire:click="approveUser({{ $selectedUser->id }})"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white border border-transparent rounded-md shadow-sm bg-secondary-green hover:bg-secondary-green/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-green sm:ml-3 sm:w-auto sm:text-sm">
                                Setujui
                            </button>
                            <button wire:click="rejectUser({{ $selectedUser->id }})"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white border border-transparent rounded-md shadow-sm bg-accent-red hover:bg-accent-red/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-red sm:ml-3 sm:w-auto sm:text-sm">
                                Tolak
                            </button>
                            <button wire:click="resetApprovalModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-blue sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    @else
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button wire:click="resetApprovalModal"
                                class="w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Tutup
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
