<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Kolaborasi</h2>
        <button wire:click="toggleCreateForm"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Buat Kolaborasi
        </button>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Create Collaboration Form -->
    @if ($showCreateForm)
        <div class="mb-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Buat Kolaborasi Baru</h3>
            <form wire:submit.prevent="createCollaboration">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Judul Kolaborasi
                        </label>
                        <input type="text" wire:model="title"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Masukkan judul kolaborasi">
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Deskripsi
                        </label>
                        <textarea wire:model="description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Deskripsi kolaborasi (opsional)"></textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Undang User
                    </label>
                    <div class="flex gap-2 mb-2">
                        <input type="text" wire:model="searchQuery"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Cari user...">
                    </div>

                    <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-lg">
                        @foreach ($availableUsers as $user)
                            <label class="flex items-center p-2 hover:bg-gray-100 cursor-pointer">
                                <input type="checkbox" wire:model="selectedUsers" value="{{ $user->id }}"
                                    class="mr-2 text-blue-600">
                                <span class="text-sm text-gray-700">{{ $user->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('selectedUsers')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Buat Kolaborasi
                    </button>
                    <button type="button" wire:click="toggleCreateForm"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
        <nav class="-mb-px flex space-x-8">
            <button wire:click="setTab('overview')"
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'overview' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Overview
            </button>
            <button wire:click="setTab('pending')"
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Undangan Masuk
                @if ($this->pendingInvitations->count() > 0)
                    <span
                        class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        {{ $this->pendingInvitations->count() }}
                    </span>
                @endif
            </button>
            <button wire:click="setTab('my-collaborations')"
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'my-collaborations' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Kolaborasi Saya
            </button>
            <button wire:click="setTab('created')"
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'created' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Yang Saya Buat
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Overview Tab -->
        @if ($activeTab === 'overview')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Pending Invitations Card -->
                <div
                    class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-600 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-200">Undangan Pending</h3>
                            <p class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">
                                {{ $this->pendingInvitations->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button wire:click="setTab('pending')"
                            class="text-yellow-700 dark:text-yellow-300 hover:text-yellow-600 text-sm font-medium">
                            Lihat semua →
                        </button>
                    </div>
                </div>

                <!-- My Collaborations Card -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-600 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-blue-800 dark:text-blue-200">Kolaborasi Saya</h3>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">
                                {{ $this->myCollaborations->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button wire:click="setTab('my-collaborations')"
                            class="text-blue-700 dark:text-blue-300 hover:text-blue-600 text-sm font-medium">
                            Lihat semua →
                        </button>
                    </div>
                </div>

                <!-- Created Collaborations Card -->
                <div
                    class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-600 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-green-800 dark:text-green-200">Yang Saya Buat</h3>
                            <p class="text-2xl font-bold text-green-900 dark:text-green-100">
                                {{ $this->createdCollaborations->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button wire:click="setTab('created')"
                            class="text-green-700 dark:text-green-300 hover:text-green-600 text-sm font-medium">
                            Lihat semua →
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Pending Invitations Tab -->
        @if ($activeTab === 'pending')
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Undangan Kolaborasi</h3>
                @if ($this->pendingInvitations->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($this->pendingInvitations as $invitation)
                            <div
                                class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $invitation->collaboration->title }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    {{ $invitation->collaboration->description ?? 'Tidak ada deskripsi' }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mb-3">
                                    Oleh: {{ $invitation->collaboration->creator->name }}
                                </p>
                                <div class="flex gap-2">
                                    <button wire:click="acceptInvitation({{ $invitation->collaboration->id }})"
                                        class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition-colors">
                                        Terima
                                    </button>
                                    <button wire:click="declineInvitation({{ $invitation->collaboration->id }})"
                                        class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition-colors">
                                        Tolak
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-5 5v-5zM4 19h6a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada undangan kolaborasi</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- My Collaborations Tab -->
        @if ($activeTab === 'my-collaborations')
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Kolaborasi Saya</h3>
                @if ($this->myCollaborations->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($this->myCollaborations as $collaboration)
                            <div
                                class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $collaboration->collaboration->title }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    {{ $collaboration->collaboration->description ?? 'Tidak ada deskripsi' }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mb-3">
                                    Status: <span
                                        class="font-semibold text-blue-600">{{ ucfirst($collaboration->collaboration->status) }}</span>
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        {{ $collaboration->collaboration->collaborationUsers->where('status', 'accepted')->count() }}
                                        anggota
                                    </span>
                                    <div>
                                        <a href="{{ route('collaboration.todos', $collaboration->collaboration_id) }}"
                                            class="px-3 py-1 bg-blue-600 mr-1 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                                            Lihat Todo
                                        </a>
                                        <button wire:click="toggleInviteForm({{ $collaboration->collaboration->id }})"
                                            class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                                            Undang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada kolaborasi</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Created Collaborations Tab -->
        @if ($activeTab === 'created')
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Kolaborasi Yang Saya Buat</h3>
                @if ($this->createdCollaborations->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($this->createdCollaborations as $collaboration)
                            <div
                                class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $collaboration->title }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    {{ $collaboration->description ?? 'Tidak ada deskripsi' }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mb-3">
                                    Status: <span
                                        class="font-semibold text-green-600">{{ ucfirst($collaboration->status) }}</span>
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        {{ $collaboration->collaborationUsers->where('status', 'accepted')->count() }}
                                        anggota
                                    </span>
                                    <button wire:click="toggleInviteForm({{ $collaboration->id }})"
                                        class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition-colors">
                                        Undang
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada kolaborasi yang dibuat</p>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Invite Users Form -->
    @if ($showInviteForm && $selectedCollaboration)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">
                    Undang User ke "{{ $selectedCollaboration->title }}"
                </h3>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pilih User
                    </label>
                    <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-lg">
                        @foreach ($availableUsers as $user)
                            <label class="flex items-center p-2 hover:bg-gray-100 cursor-pointer">
                                <input type="checkbox" wire:model="selectedUsers" value="{{ $user->id }}"
                                    class="mr-2 text-blue-600">
                                <span class="text-sm text-gray-700">{{ $user->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-2">
                    <button wire:click="inviteUsers"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Kirim Undangan
                    </button>
                    <button wire:click="toggleInviteForm"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if (
        $activeTab === 'overview' &&
            $this->pendingInvitations->count() == 0 &&
            $this->myCollaborations->count() == 0 &&
            $this->createdCollaborations->count() == 0)
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada kolaborasi</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Mulai dengan membuat kolaborasi baru atau bergabung dengan kolaborasi yang ada.
            </p>
            <div class="mt-6">
                <button wire:click="toggleCreateForm"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Buat Kolaborasi
                </button>
            </div>
        </div>
    @endif
</div>
