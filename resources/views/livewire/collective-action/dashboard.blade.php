<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <a href="{{ route('collective-action.browse') }}" class="mr-4 text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold">{{ $collectiveAction->title }}</h1>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 bg-white/20 text-white rounded-full text-sm font-medium">
                    {{ $collectiveAction->status_label }}
                </span>
                @if($collectiveAction->canUserManage(Auth::user()))
                    <a href="{{ route('collective-action.members', $collectiveAction) }}" 
                       class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition-colors">
                        Kelola Anggota
                    </a>
                @endif
            </div>
        </div>
        <p class="text-purple-100">{{ $collectiveAction->description }}</p>
    </div>

    <!-- Status Management (Admin Only) -->
    @if($collectiveAction->canUserManage(Auth::user()))
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Kelola Status Aksi</h2>
            <div class="flex flex-wrap gap-3">
                @foreach(['planning' => 'Perencanaan', 'active' => 'Aktif', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $status => $label)
                    <button 
                        wire:click="updateActionStatus('{{ $status }}')"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                            {{ $collectiveAction->status === $status 
                                ? 'bg-blue-600 text-white' 
                                : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' 
                            }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Action Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Admin Count -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Admin</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $adminUsers->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Member Count -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Anggota</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $memberUsers->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Contributor Count -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Kontributor</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $contributorUsers->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Contributions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Kontribusi Pending</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $pendingContributions->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Accepted Contributions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Kontribusi Diterima</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $acceptedContributions->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Aksi</h2>
            
            <div class="space-y-4">
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">Mulai:</span>
                    <span class="ml-2 text-gray-900 dark:text-white font-medium">
                        {{ $collectiveAction->start_date->format('d M Y') }}
                    </span>
                </div>
                
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">Selesai:</span>
                    <span class="ml-2 text-gray-900 dark:text-white font-medium">
                        {{ $collectiveAction->end_date->format('d M Y') }}
                    </span>
                </div>
                
                @if($collectiveAction->location)
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">Lokasi:</span>
                    <span class="ml-2 text-gray-900 dark:text-white font-medium">
                        {{ $collectiveAction->location }}
                    </span>
                </div>
                @endif

                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">Skala:</span>
                    <span class="ml-2 text-gray-900 dark:text-white font-medium">
                        {{ $collectiveAction->scale_label }}
                    </span>
                </div>

                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">Jangkauan:</span>
                    <span class="ml-2 text-gray-900 dark:text-white font-medium">
                        {{ $collectiveAction->scope_label }}
                    </span>
                </div>
            </div>

            @if($collectiveAction->goals)
            <div class="mt-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Tujuan Aksi:</h4>
                <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $collectiveAction->goals }}</p>
            </div>
            @endif
        </div>

        <!-- Participating Ecosystems -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ekosistem yang Berpartisipasi</h2>
            
            @if($participatingEcosystems->count() > 0)
                <div class="space-y-3">
                    @foreach($participatingEcosystems as $ecosystem)
                        <div class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3">
                                <span class="text-blue-600 dark:text-blue-400 font-semibold text-sm">
                                    {{ substr($ecosystem->ecosystem_title, 0, 2) }}
                                </span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">
                                    {{ $ecosystem->ecosystem_title }}
                                </h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $ecosystem->organization_name }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Belum ada ekosistem yang berpartisipasi</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Contribution Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Kontribusi</h2>
            <div class="flex gap-3">
                @if($collectiveAction->canUserJoin(Auth::user()))
                    <button 
                        wire:click="joinCollectiveAction"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors"
                    >
                        Bergabung
                    </button>
                @endif
                @if($collectiveAction->canUserContribute(Auth::user()))
                    <button 
                        wire:click="toggleContributionForm"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors"
                    >
                        {{ $show_contribution_form ? 'Batal' : 'Berkontribusi' }}
                    </button>
                @endif
            </div>
        </div>

        <!-- Contribution Form -->
        @if($show_contribution_form && $collectiveAction->canUserContribute(Auth::user()))
            <form wire:submit="submitContribution" class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            <strong>Info:</strong> Hanya anggota yang sudah bergabung dengan aksi kolektif yang dapat berkontribusi.
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <flux:select 
                            wire:model="contribution_type" 
                            :label="'Jenis Kontribusi'" 
                            required
                        >
                            @foreach($contributionTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                    
                    @if($contribution_type === 'funding')
                        <div>
                            <flux:input
                                wire:model="contribution_amount"
                                :label="'Jumlah Kontribusi (Rupiah)'"
                                type="number"
                                min="0"
                                step="1000"
                                :placeholder="'Masukkan jumlah yang ingin Anda kontribusikan'"
                            />
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <flux:textarea
                        wire:model="contribution_description"
                        :label="'Deskripsi Kontribusi'"
                        required
                        :placeholder="'Jelaskan secara detail kontribusi yang ingin Anda berikan...'"
                        rows="3"
                    />
                </div>

                <div class="flex gap-3">
                    <flux:button 
                        type="submit" 
                        variant="primary" 
                        class="flex-1"
                    >
                        Kirim Kontribusi
                    </flux:button>
                    <flux:button 
                        type="button" 
                        variant="outline"
                        wire:click="toggleContributionForm"
                    >
                        Batal
                    </flux:button>
                </div>
            </form>
        @endif

        <!-- Pending Contributions (Admin Only) -->
        @if($collectiveAction->canUserManage(Auth::user()) && $pendingContributions->count() > 0)
            <div class="mb-6">
                <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Kontribusi Menunggu Persetujuan</h3>
                <div class="space-y-3">
                    @foreach($pendingContributions as $contribution)
                        <div class="p-4 border border-yellow-200 dark:border-yellow-800 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-yellow-600 dark:text-yellow-400 font-semibold text-xs">
                                                {{ $contribution->initials() }}
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $contribution->name }}</h4>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $contribution->email }}</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">
                                        <strong>Alasan Bergabung:</strong> 
                                        {{ $contribution->pivot->join_reason }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Bergabung: {{ $contribution->pivot->joined_at ? $contribution->pivot->joined_at->format('d M Y') : 'N/A' }}
                                    </p>
                                </div>
                                <div class="flex gap-2 ml-4">
                                    <button 
                                        wire:click="acceptContribution({{ $contribution->id }})"
                                        class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-medium transition-colors"
                                    >
                                        Terima
                                    </button>
                                    <button 
                                        wire:click="declineContribution({{ $contribution->id }})"
                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-medium transition-colors"
                                    >
                                        Tolak
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Accepted Contributions -->
        @if($acceptedContributions->count() > 0)
<div>
                <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Kontribusi yang Diterima</h3>
                <div class="space-y-3">
                    @foreach($acceptedContributions as $contribution)
                        <div class="p-4 border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-green-600 dark:text-green-400 font-semibold text-xs">
                                        {{ $contribution->initials() }}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $contribution->name }}</h4>
                                        <span class="ml-2 px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-xs">
                                            Diterima
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        <strong>Kontributor:</strong> 
                                        {{ $contribution->pivot->join_reason }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Bergabung: {{ $contribution->pivot->joined_at ? $contribution->pivot->joined_at->format('d M Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($pendingContributions->count() === 0 && $acceptedContributions->count() === 0)
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
                <p class="text-gray-600 dark:text-gray-400">Belum ada kontribusi</p>
                @if(!$collectiveAction->canUserContribute(Auth::user()) && !$collectiveAction->isUserMember(Auth::user()) && !$collectiveAction->isUserAdmin(Auth::user()) && !$collectiveAction->isUserContributor(Auth::user()))
                    <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">
                        Bergabung terlebih dahulu untuk dapat berkontribusi
                    </p>
                @endif
            </div>
        @endif
    </div>

    <!-- Members Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Admin Users -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Admin</h2>
            
            @if($adminUsers->count() > 0)
                <div class="space-y-3">
                    @foreach($adminUsers as $user)
                        <div class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3">
                                <span class="text-blue-600 dark:text-blue-400 font-semibold text-sm">
                                    {{ $user->initials() }}
                                </span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $user->name }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500">
                                    {{ $user->pivot->join_type_label }}
                                </p>
                            </div>
                            @if($user->id === $collectiveAction->created_by)
                                <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-xs">
                                    Pembuat
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Belum ada admin</p>
                </div>
            @endif
        </div>

        <!-- Member Users -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Anggota</h2>
            
            @if($memberUsers->count() > 0)
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @foreach($memberUsers as $user)
                        <div class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-3">
                                <span class="text-green-600 dark:text-green-400 font-semibold text-sm">
                                    {{ $user->initials() }}
                                </span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $user->name }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500">
                                    {{ $user->pivot->join_type_label }}
                                </p>
                            </div>
                            <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-xs">
                                {{ $user->pivot->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Belum ada anggota</p>
                </div>
            @endif
        </div>

        <!-- Contributor Users -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Kontributor</h2>
            
            @if($contributorUsers->count() > 0)
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @foreach($contributorUsers as $user)
                        <div class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mr-3">
                                <span class="text-purple-600 dark:text-purple-400 font-semibold text-sm">
                                    {{ $user->initials() }}
                                </span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $user->name }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500">
                                    {{ $user->pivot->join_type_label }}
                                </p>
                            </div>
                            <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-xs">
                                {{ $user->pivot->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Belum ada kontributor</p>
                </div>
            @endif
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