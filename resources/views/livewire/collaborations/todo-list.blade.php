<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8 px-4 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-24 h-24" opacity="opacity-10" />
    <x-svg-accent position="center-right" size="w-20 h-20" opacity="opacity-10" />
    <x-svg-accent position="bottom-left" size="w-16 h-16" opacity="opacity-10" />
    
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.5s ease-out;
        }

        .task-item {
            animation: fade-in-up 0.5s ease-out;
            animation-fill-mode: both;
        }

        .task-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .task-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .task-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .task-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        .task-item:nth-child(5) {
            animation-delay: 0.5s;
        }

        .checkbox-animation {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .checkbox-animation:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }

        .progress-bar-animation {
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .floating-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            }

            to {
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.6);
            }
        }
    </style>

    <div class="max-w-6xl mx-auto">
        <!-- Pesan Flash -->
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

        <!-- Bagian Header -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-4 floating-animation pulse-glow">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
            </div>
            <h1
                class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2 animate-fade-in-up">
                {{ $collaboration->title }}
            </h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.2s;">
                {{ $collaboration->description }}</p>
        </div>

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div
                class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Tugas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $todos->count() }}</p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Selesai</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $todos->where('status', 'completed')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Menunggu</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $todos->where('status', 'pending')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Komentar</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $todos->sum(function ($todo) {return $todo->comments->count();}) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Progress -->
        @if ($todos->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Progress</h3>
                    <span class="text-sm font-medium text-gray-600">
                        {{ round(($todos->where('status', 'completed')->count() / $todos->count()) * 100) }}% Selesai
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full progress-bar-animation relative"
                        style="width: {{ ($todos->where('status', 'completed')->count() / $todos->count()) * 100 }}%">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-pulse">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filter dan Pencarian -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
            <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                <div class="flex flex-wrap gap-3">
                    <!-- Filter Status -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-gray-700">Status:</span>
                        <select wire:model.live="filter"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="all">Semua Tugas</option>
                            <option value="pending">Menunggu</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>

                    <!-- Urutkan Berdasarkan -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-gray-700">Urutkan:</span>
                        <select wire:model.live="sortBy"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="created_at">Tanggal Dibuat</option>
                            <option value="title">Judul</option>
                            <option value="status">Status</option>
                        </select>
                        <button wire:click="toggleSort('{{ $sortBy }}')"
                            class="p-2 text-gray-500 hover:text-gray-700 transition-colors">
                            @if ($sortOrder === 'asc')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        </button>
                    </div>

                    <!-- Bersihkan Filter -->
                    @if ($filter !== 'all' || $sortBy !== 'created_at' || $sortOrder !== 'desc' || $search)
                        <button wire:click="clearFilters"
                            class="px-3 py-2 text-sm text-gray-600 hover:text-gray-800 transition-colors">
                            Bersihkan Filter
                        </button>
                    @endif
                </div>

                                    <!-- Pencarian -->
                <div class="flex-1 lg:max-w-md">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari tugas..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

                            <!-- Tampilan Filter Aktif -->
            @if ($filter !== 'all' || $search)
                <div class="mt-4 flex flex-wrap gap-2">
                    @if ($filter !== 'all')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                            Status: {{ ucfirst($filter) }}
                            <button wire:click="$set('filter', 'all')" class="ml-2 text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </span>
                    @endif
                    @if ($search)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                            Pencarian: "{{ $search }}"
                            <button wire:click="$set('search', '')" class="ml-2 text-green-600 hover:text-green-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </span>
                    @endif
                </div>
            @endif
        </div>

        <!-- Form Tambah Tugas -->
        <div
            class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100 hover:shadow-xl transition-all duration-300 {{ $collaboration->status === 'pending' ? 'opacity-50' : '' }}">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Tugas Baru
                @if($collaboration->status === 'pending')
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        Kolaborasi Menunggu
                    </span>
                @endif
            </h3>
            
            @if($collaboration->status === 'pending')
                <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Kolaborasi masih dalam status menunggu.</strong> Anda tidak dapat menambah atau mengubah daftar tugas sampai kolaborasi diaktifkan.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="space-y-4">
                <div class="flex gap-3">
                    <div class="flex-1">
                        <input type="text" wire:model="newTitle" placeholder="Apa yang perlu dilakukan?"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 hover:border-blue-400 {{ $collaboration->status === 'pending' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            {{ $collaboration->status === 'pending' ? 'disabled' : '' }}>
                        @error('newTitle')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button wire:click="addTodo" wire:loading.attr="disabled"
                        class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed {{ $collaboration->status === 'pending' ? 'bg-gray-400 cursor-not-allowed hover:from-gray-400 hover:to-gray-500' : '' }}"
                        {{ $collaboration->status === 'pending' ? 'disabled' : '' }}>
                        <svg wire:loading.remove class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <svg wire:loading class="w-5 h-5 inline mr-2 animate-spin" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        <span wire:loading.remove>{{ $collaboration->status === 'pending' ? 'Todo Dinonaktifkan' : 'Tambah Tugas' }}</span>
                        <span wire:loading>Menambahkan...</span>
                    </button>
                </div>
                <div>
                    <textarea wire:model="newDescription" placeholder="Tambahkan deskripsi (opsional)"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 resize-none hover:border-blue-400 {{ $collaboration->status === 'pending' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                        rows="2" {{ $collaboration->status === 'pending' ? 'disabled' : '' }}></textarea>
                </div>
            </div>
        </div>

        <!-- Daftar Tugas -->
        <div class="space-y-4">
            @forelse ($todos as $todo)
                <div
                    class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border {{ $todo->status === 'completed' ? 'border-green-200 bg-green-50/30' : 'border-gray-100' }} task-item">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <!-- Kotak Centang -->
                            <div class="flex-shrink-0 pt-1">
                                <div class="relative">
                                    <button wire:click="toggleCompleted({{ $todo->id }})"
                                        wire:loading.attr="disabled"
                                        class="w-6 h-6 rounded-lg border-2 border-gray-300 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 transition-all duration-200 cursor-pointer hover:border-blue-400 hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center checkbox-animation {{ $collaboration->status === 'pending' ? 'opacity-50 cursor-not-allowed hover:scale-100' : '' }}"
                                        {{ $collaboration->status === 'pending' ? 'disabled' : '' }}>
                                        @if ($todo->status === 'completed')
                                            <svg class="w-4 h-4 text-blue-600" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg wire:loading class="w-4 h-4 text-blue-600 animate-spin"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                        @endif
                                    </button>
                                </div>
                            </div>

                            <!-- Konten Tugas -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-x-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3
                                                class="text-lg font-semibold {{ $todo->status === 'completed' ? 'line-through text-gray-400' : 'text-gray-900' }}">
                                                {{ $todo->title }}
                                            </h3>
                                                                        @if ($todo->status === 'completed')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Selesai
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Menunggu
                                </span>
                            @endif
                            
                            @if($collaboration->status === 'pending')
                                <span
                                    class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Tugas Dinonaktifkan
                                </span>
                            @endif
                                        </div>

                                        @if ($todo->description)
                                            <p class="text-gray-600 mb-3">{{ $todo->description }}</p>
                                        @endif

                                        <!-- Meta Tugas -->
                                        <div class="flex items-center gap-4 text-sm text-gray-500">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $todo->created_at->diffForHumans() }}
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                                {{ $todo->creator->name }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="flex-shrink-0 flex items-center gap-2">
                                        <!-- Avatar Pembuat -->
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 border-2 border-white shadow-lg flex items-center justify-center"
                                                                                         title="Dibuat oleh {{ $todo->creator->name }}">
                                            <span
                                                class="text-sm font-bold text-white">{{ substr($todo->creator->name, 0, 2) }}</span>
                                        </div>

                                        <!-- Tombol Hapus -->
                                        <button wire:click="deleteTodo({{ $todo->id }})"
                                            wire:loading.attr="disabled"
                                                                                         wire:confirm="Apakah Anda yakin ingin menghapus tugas ini?"
                                             class="p-2 text-gray-400 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100 disabled:opacity-50 disabled:cursor-not-allowed"
                                             title="Hapus tugas">
                                            <svg wire:loading.remove class="w-4 h-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            <svg wire:loading class="w-4 h-4 animate-spin" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Bagian Komentar -->
                                @if ($todo->comments->count() > 0)
                                    <div class="mt-6 pl-6 border-l-2 border-blue-200 space-y-3">
                                        <h4 class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                </path>
                                            </svg>
                                            {{ $todo->comments->count() }}
                                                                                         Komentar{{ $todo->comments->count() > 1 ? 's' : '' }}
                                        </h4>
                                        <div class="space-y-3">
                                            @foreach ($todo->comments as $comment)
                                                <div class="flex items-start gap-3 group/comment">
                                                    <div
                                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 border border-gray-200 flex items-center justify-center">
                                                        <span
                                                            class="text-xs font-medium text-gray-600">{{ substr($comment->user->name, 0, 2) }}</span>
                                                    </div>
                                                    <div class="flex-1 min-w-0 bg-gray-50 rounded-xl p-3">
                                                        <div class="flex items-baseline gap-2 mb-1">
                                                            <span
                                                                class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</span>
                                                            <span
                                                                class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-sm text-gray-700">{{ $comment->comment }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Keadaan Kosong -->
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-100 floating-animation">
                    <div
                        class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center pulse-glow">
                        <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                                         <h3 class="text-2xl font-bold text-gray-900 mb-2">Tugas tidak ditemukan!</h3>
                     <p class="text-gray-600 text-lg mb-6">
                         @if ($filter !== 'all' || $search)
                             Coba atur filter atau kata kunci pencarian Anda.
                         @else
                             Mulailah dengan menambahkan tugas pertama Anda untuk memulai.
                         @endif
                     </p>
                    @if ($filter !== 'all' || $search)
                        <button wire:click="clearFilters"
                            class="px-6 py-3 bg-gray-600 text-white font-medium rounded-xl hover:bg-gray-700 transition-colors mr-3 transform hover:scale-105">
                                                         Bersihkan Filter
                        </button>
                    @endif
                    <div
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl transform hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                                                 Tambah Tugas Pertama Anda
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        // Interaksi dan notifikasi yang ditingkatkan
        document.addEventListener('livewire:initialized', () => {
            // Dengarkan event todo
            Livewire.on('todo-added', () => {
                // Tampilkan notifikasi sukses
                showNotification('Tugas berhasil ditambahkan!', 'success');

                // Scroll ke tugas baru
                setTimeout(() => {
                    const tasks = document.querySelectorAll('.task-item');
                    if (tasks.length > 0) {
                        tasks[0].scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }, 100);
            });

            Livewire.on('todo-deleted', () => {
                showNotification('Tugas berhasil dihapus!', 'info');
            });

            // Tambahkan smooth scrolling untuk UX yang lebih baik
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                });
            });
        });

        // Tambahkan shortcut keyboard
        document.addEventListener('keydown', (e) => {
                            // Ctrl/Cmd + Enter untuk menambah tugas
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                const addButton = document.querySelector('button[wire\\:click="addTodo"]');
                if (addButton && !addButton.disabled) {
                    addButton.click();
                }
            }

            // Escape untuk membersihkan pencarian
            if (e.key === 'Escape') {
                const searchInput = document.querySelector(
                'input[wire\\:model\\.live\\.debounce\\.300ms="search"]');
                if (searchInput) {
                    searchInput.value = '';
                    searchInput.dispatchEvent(new Event('input'));
                }
            }
        });

        // Tambahkan efek hover untuk interaktivitas yang lebih baik
        document.addEventListener('DOMContentLoaded', () => {
            // Tambahkan efek ripple pada tombol
            document.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

    <style>
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Enhanced focus states */
        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Smooth transitions for all interactive elements */
        button,
        input,
        textarea,
        select {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Enhanced hover effects */
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</div>
