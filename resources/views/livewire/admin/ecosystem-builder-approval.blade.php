<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Ecosystem Builder</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Kelola permintaan dan status Ecosystem Builder</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Menunggu
                                Persetujuan</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['pending'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Disetujui</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['approved'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Ditolak</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['rejected'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cari
                        User</label>
                    <input type="text" wire:model.live="search" id="search" placeholder="Nama atau email..."
                        class="mt-1 p-2 px-4 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="status"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select wire:model.live="status" id="status"
                        class="mt-1 p-2 px-4 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu Persetujuan</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Daftar Ecosystem Builder</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Kelola status dan persetujuan Ecosystem
                Builder</p>
        </div>
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($users as $user)
                <li class="px-4 py-4 sm:px-6 dark:bg-gray-800">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div
                                    class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                    @if ($user->ecosystem_builder_status === 'pending')
                                        <span
                                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                            Menunggu
                                        </span>
                                    @elseif($user->ecosystem_builder_status === 'approved')
                                        <span
                                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                            Disetujui
                                        </span>
                                    @elseif($user->ecosystem_builder_status === 'rejected')
                                        <span
                                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                            Ditolak
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    Daftar: {{ $user->created_at->format('d M Y H:i') }}
                                    @if ($user->ecosystem_builder_approved_at)
                                        | Disetujui: {{ $user->ecosystem_builder_approved_at->format('d M Y H:i') }}
                                        @if ($user->ecosystemBuilderApprovedBy)
                                            oleh {{ $user->ecosystemBuilderApprovedBy->name }}
                                        @endif
                                    @endif
                                </p>
                                @if ($user->ecosystem_builder_reason)
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                        <strong>Alasan:</strong> {{ $user->ecosystem_builder_reason }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if ($user->ecosystem_builder_status === 'pending')
                                <button wire:click="approveUser({{ $user->id }})"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Setujui
                                </button>
                                <button wire:click="rejectUser({{ $user->id }})"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Tolak
                                </button>
                            @else
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ ucfirst($user->ecosystem_builder_status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-8 sm:px-6 text-center">
                    <div class="text-gray-500 dark:text-gray-400">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada data</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Belum ada permintaan Ecosystem
                            Builder.</p>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>

    <!-- Approval Modal -->
    @if ($showApprovalModal && $selectedUser)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 dark:bg-gray-900 dark:bg-opacity-75 overflow-y-auto h-full w-full z-50"
            wire:click="resetApprovalModal">
            <div class="relative top-20 mx-auto p-5 border border-gray-200 dark:border-gray-700 w-96 shadow-lg rounded-md bg-white dark:bg-gray-800"
                wire:click.stop>
                <div class="mt-3">
                    <div
                        class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mt-2 px-7 py-3">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center">Konfirmasi
                            Persetujuan</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                                Apakah Anda yakin ingin
                                <span class="font-medium text-green-600 dark:text-green-400">menyetujui</span> atau
                                <span class="font-medium text-red-600 dark:text-red-400">menolak</span>
                                <strong class="text-gray-900 dark:text-white">{{ $selectedUser->name }}</strong>
                                sebagai Ecosystem Builder?
                            </p>
                        </div>
                        <div class="mt-4">
                            <label for="approvalReason"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alasan
                                (Opsional)</label>
                            <textarea wire:model="approvalReason" id="approvalReason" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Masukkan alasan persetujuan atau penolakan..."></textarea>
                        </div>
                    </div>
                    <div class="items-center px-4 py-3">
                        <div class="flex space-x-3">
                            <button wire:click="approveUser({{ $selectedUser->id }})"
                                class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                                Setujui
                            </button>
                            <button wire:click="rejectUser({{ $selectedUser->id }})"
                                class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                                Tolak
                            </button>
                            <button wire:click="resetApprovalModal"
                                class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
