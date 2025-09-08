<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl p-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('collective-action.browse') }}" class="mr-4 text-white/80 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Manajemen Anggota</h1>
        </div>
        <p class="text-blue-100">
            Kelola anggota dan admin aksi kolektif: <strong>{{ $collectiveAction->title }}</strong>
        </p>
    </div>

    <!-- Collective Action Info -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $adminMembers->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Admin</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $regularMembers->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Anggota</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $adminMembers->count() + $regularMembers->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total</div>
            </div>
        </div>
    </div>

    <!-- Admin Members -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Admin Aksi Kolektif
        </h2>
        
        @if($adminMembers->count() > 0)
            <div class="space-y-4">
                @foreach($adminMembers as $member)
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-4">
                                <span class="text-blue-600 dark:text-blue-400 font-semibold">
                                    {{ $member->initials() }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                    {{ $member->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $member->email }}
                                </p>
                                @if($member->id === $collectiveAction->created_by)
                                    <span class="inline-block px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 text-xs rounded-full mt-1">
                                        Pembuat Aksi
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium">
                                Admin
                            </span>
                            @if($member->id !== $collectiveAction->created_by)
                                <button 
                                    wire:click="removeMember({{ $member->id }})"
                                    wire:confirm="Apakah Anda yakin ingin menghapus admin ini?"
                                    class="text-red-600 hover:text-red-800 text-sm"
                                >
                                    Hapus
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <p class="text-gray-600 dark:text-gray-400">Belum ada admin</p>
            </div>
        @endif
    </div>

    <!-- Regular Members -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
            Anggota Aksi Kolektif
        </h2>
        
        @if($regularMembers->count() > 0)
            <div class="space-y-4">
                @foreach($regularMembers as $member)
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-4">
                                <span class="text-green-600 dark:text-green-400 font-semibold">
                                    {{ $member->initials() }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                    {{ $member->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $member->email }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-500">
                                    Bergabung: {{ $member->pivot->joined_at ? $member->pivot->joined_at->format('d M Y') : 'Tidak diketahui' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-sm font-medium">
                                {{ $member->pivot->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                            <button 
                                wire:click="toggleMemberStatus({{ $member->id }})"
                                class="text-blue-600 hover:text-blue-800 text-sm"
                            >
                                {{ $member->pivot->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                            <button 
                                wire:click="removeMember({{ $member->id }})"
                                wire:confirm="Apakah Anda yakin ingin menghapus anggota ini?"
                                class="text-red-600 hover:text-red-800 text-sm"
                            >
                                Hapus
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <p class="text-gray-600 dark:text-gray-400">Belum ada anggota</p>
            </div>
        @endif
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="font-semibold text-blue-900 dark:text-blue-200">Informasi Manajemen Anggota</h3>
                <ul class="text-sm text-blue-700 dark:text-blue-300 mt-2 space-y-1">
                    <li>• <strong>Admin:</strong> Ecosystem builders yang diundang menjadi admin aksi kolektif</li>
                    <li>• <strong>Anggota:</strong> Semua anggota dari ekosistem yang bergabung secara otomatis</li>
                    <li>• <strong>Pembuat Aksi:</strong> Tidak dapat dihapus atau dinonaktifkan</li>
                    <li>• <strong>Status Aktif:</strong> Anggota aktif dapat berpartisipasi dalam aksi kolektif</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if (session()->has('message'))
    <div class="fixed top-4 right-4 z-50">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('message') }}
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div class="fixed top-4 right-4 z-50">
        <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    </div>
@endif

<script>
    // Auto-hide success/error messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const messages = document.querySelectorAll('.fixed.top-4.right-4');
        messages.forEach(message => {
            setTimeout(() => {
                message.style.opacity = '0';
                message.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => {
                    message.remove();
                }, 500);
            }, 5000);
        });
    });
</script>