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
        <div class="flex justify-between items-start mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 flex-1">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $adminUsers->count() }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Admin</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $memberUsers->count() }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Anggota</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $contributorUsers->count() }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Kontributor</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-600">{{ $adminUsers->count() + $memberUsers->count() + $contributorUsers->count() }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Total</div>
                </div>
            </div>
            <div class="flex flex-col space-y-2">
                <a href="{{ route('collective-action.user-approvals', $collectiveAction) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Persetujuan Anggota
                    @if($collectiveAction->pendingApprovalUsers()->count() > 0)
                        <span class="ml-2 bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                            {{ $collectiveAction->pendingApprovalUsers()->count() }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('collective-action.show', $collectiveAction) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Admin Users -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Admin Aksi Kolektif
        </h2>
        
        @if($adminUsers->count() > 0)
            <div class="space-y-4">
                @foreach($adminUsers as $user)
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-4">
                                <span class="text-blue-600 dark:text-blue-400 font-semibold">
                                    {{ $user->initials() }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                    {{ $user->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $user->email }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-500">
                                    {{ $user->pivot->join_type_label }}
                                </p>
                                @if($user->id === $collectiveAction->created_by)
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
                            @if($user->id !== $collectiveAction->created_by)
                                <div class="flex items-center space-x-1">
                                    <select 
                                        wire:change="updateUserRole({{ $user->id }}, $event.target.value)"
                                        class="text-xs border border-gray-300 rounded px-2 py-1"
                                    >
                                        <option value="admin" selected>Admin</option>
                                        <option value="member">Anggota</option>
                                        <option value="contributor">Kontributor</option>
                                    </select>
                                    <button 
                                        wire:click="removeMember({{ $user->id }})"
                                        wire:confirm="Apakah Anda yakin ingin menghapus user ini?"
                                        class="text-red-600 hover:text-red-800 text-sm"
                                    >
                                        Hapus
                                    </button>
                                </div>
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

    <!-- Member Users -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
            Anggota Aksi Kolektif
        </h2>
        
        @if($memberUsers->count() > 0)
            <div class="space-y-4">
                @foreach($memberUsers as $user)
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-4">
                                <span class="text-green-600 dark:text-green-400 font-semibold">
                                    {{ $user->initials() }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                    {{ $user->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $user->email }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-500">
                                    {{ $user->pivot->join_type_label }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-sm font-medium">
                                {{ $user->pivot->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                            <div class="flex items-center space-x-1">
                                <select 
                                    wire:change="updateUserRole({{ $user->id }}, $event.target.value)"
                                    class="text-xs border border-gray-300 rounded px-2 py-1"
                                >
                                    <option value="admin">Admin</option>
                                    <option value="member" selected>Anggota</option>
                                    <option value="contributor">Kontributor</option>
                                </select>
                                <button 
                                    wire:click="toggleMemberStatus({{ $user->id }})"
                                    class="text-blue-600 hover:text-blue-800 text-sm"
                                >
                                    {{ $user->pivot->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                                <button 
                                    wire:click="removeMember({{ $user->id }})"
                                    wire:confirm="Apakah Anda yakin ingin menghapus user ini?"
                                    class="text-red-600 hover:text-red-800 text-sm"
                                >
                                    Hapus
                                </button>
                            </div>
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

    <!-- Contributor Users -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
            </svg>
            Kontributor Aksi Kolektif
        </h2>
        
        @if($contributorUsers->count() > 0)
            <div class="space-y-4">
                @foreach($contributorUsers as $user)
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mr-4">
                                <span class="text-purple-600 dark:text-purple-400 font-semibold">
                                    {{ $user->initials() }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                    {{ $user->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $user->email }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-500">
                                    {{ $user->pivot->join_type_label }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-sm font-medium">
                                {{ $user->pivot->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                            <div class="flex items-center space-x-1">
                                <select 
                                    wire:change="updateUserRole({{ $user->id }}, $event.target.value)"
                                    class="text-xs border border-gray-300 rounded px-2 py-1"
                                >
                                    <option value="admin">Admin</option>
                                    <option value="member">Anggota</option>
                                    <option value="contributor" selected>Kontributor</option>
                                </select>
                                <button 
                                    wire:click="toggleMemberStatus({{ $user->id }})"
                                    class="text-blue-600 hover:text-blue-800 text-sm"
                                >
                                    {{ $user->pivot->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                                <button 
                                    wire:click="removeMember({{ $user->id }})"
                                    wire:confirm="Apakah Anda yakin ingin menghapus user ini?"
                                    class="text-red-600 hover:text-red-800 text-sm"
                                >
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
                <p class="text-gray-600 dark:text-gray-400">Belum ada kontributor</p>
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
                <h3 class="font-semibold text-blue-900 dark:text-blue-200">Informasi Manajemen User</h3>
                <ul class="text-sm text-blue-700 dark:text-blue-300 mt-2 space-y-1">
                    <li>• <strong>Admin:</strong> Dapat mengelola aksi kolektif dan semua user</li>
                    <li>• <strong>Anggota:</strong> Dapat berpartisipasi penuh dalam aksi kolektif</li>
                    <li>• <strong>Kontributor:</strong> Fokus pada kontribusi spesifik</li>
                    <li>• <strong>Pembuat Aksi:</strong> Tidak dapat dihapus atau diubah role</li>
                    <li>• <strong>Role Management:</strong> Admin dapat mengubah role user sesuai kebutuhan</li>
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