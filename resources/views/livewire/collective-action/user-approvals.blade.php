<div class="max-w-6xl mx-auto p-6">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-slate-900/20">
        <div class="border-b border-gray-200 dark:border-slate-700 px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100">Persetujuan Anggota</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-1">{{ $collectiveAction->title }}</p>
        </div>

        <div class="p-6">
            @if (session()->has('message'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400 dark:text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                {{ session('message') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400 dark:text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800 dark:text-red-200">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if (empty($pendingUsers))
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-slate-100">Tidak ada permintaan yang menunggu persetujuan</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">Semua permintaan bergabung sudah diproses.</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($pendingUsers as $user)
                        <div class="bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-200 dark:border-slate-600 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            @if ($user['profile'] && $user['profile']['photo'])
                                                <img class="h-12 w-12 rounded-full object-cover" 
                                                     src="{{ asset('storage/' . $user['profile']['photo']) }}" 
                                                     alt="{{ $user['name'] }}">
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-gray-300 dark:bg-slate-600 flex items-center justify-center">
                                                    <svg class="h-8 w-8 text-gray-500 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100">{{ $user['name'] }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-slate-400">{{ $user['email'] }}</p>
                                            
                                            <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500 dark:text-slate-400">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                           {{ $user['join_type'] === 'direct' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300' : 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' }}">
                                                    {{ $user['join_type'] === 'direct' ? 'Bergabung Langsung' : 'Melalui Ekosistem' }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-slate-300">
                                                    Role: {{ ucfirst($user['requested_role']) }}
                                                </span>
                                                <span class="text-xs text-gray-400 dark:text-slate-500">
                                                    Diminta pada {{ \Carbon\Carbon::parse($user['approval_requested_at'])->format('d M Y H:i') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($user['join_reason'])
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-slate-100">Alasan Bergabung:</h4>
                                        <p class="mt-1 text-sm text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-700 p-3 rounded-md border border-gray-200 dark:border-slate-600">
                                            {{ $user['join_reason'] }}
                                        </p>
                                    </div>
                                @endif

                                @if ($user['profile'])
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-slate-100">Informasi Profil:</h4>
                                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                            @if ($user['organization_name'])
                                                <div>
                                                    <span class="font-medium text-gray-700 dark:text-slate-300">Organisasi:</span>
                                                    <span class="text-gray-600 dark:text-slate-400">{{ $user['organization_name'] }}</span>
                                                </div>
                                            @endif
                                            @if ($user['profile']['location'])
                                                <div>
                                                    <span class="font-medium text-gray-700 dark:text-slate-300">Lokasi:</span>
                                                    <span class="text-gray-600 dark:text-slate-400">{{ $user['profile']['location'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <label for="notes_{{ $user['id'] }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                                        Catatan Admin (opsional):
                                    </label>
                                    <textarea 
                                        wire:model="selectedUserNotes.{{ $user['id'] }}"
                                        id="notes_{{ $user['id'] }}"
                                        rows="2" 
                                        class="mt-1 p-2 block w-full border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 sm:text-sm placeholder-gray-500 dark:placeholder-slate-400"
                                        placeholder="Tambahkan catatan untuk keputusan ini..."></textarea>
                                </div>

                                <div class="mt-6 flex justify-end space-x-3">
                                    <button wire:click="rejectUser({{ $user['id'] }})" 
                                            type="button"
                                            class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-150 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                                        Tolak
                                    </button>
                                    <button wire:click="approveUser({{ $user['id'] }})" 
                                            type="button"
                                            class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-150 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                                        Setujui
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-8 flex justify-start">
                <a href="{{ route('collective-action.members', $collectiveAction) }}" 
                   class="bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-slate-300 px-4 py-2 rounded-md hover:bg-gray-300 dark:hover:bg-slate-600 transition duration-150 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                    Kembali ke Manajemen Anggota
                </a>
            </div>
        </div>
    </div>
</div>