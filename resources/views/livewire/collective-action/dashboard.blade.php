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

    <!-- Invitation Management (Admin Only) -->
    @if($collectiveAction->canUserManage(Auth::user()))
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Undang Ekosistem Lain</h2>
                @if(count($available_ecosystems) > 0)
                    <button 
                        wire:click="toggleInvitationForm"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg text-sm font-medium transition-colors"
                    >
                        @if($show_invitation_form)
                            Batal
                        @else
                            + Undang Ekosistem
                        @endif
                    </button>
                @endif
            </div>

            @if($show_invitation_form)
                <form wire:submit="sendInvitation" class="space-y-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="relative">
                        <label for="ecosystem_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pilih Ekosistem
                        </label>
                        
                        <!-- Search Input -->
                        <div class="relative">
                            <input 
                                type="text" 
                                wire:model.live="ecosystem_search"
                                wire:click="$set('show_ecosystem_dropdown', true)"
                                id="ecosystem_search"
                                placeholder="🔍 Cari ekosistem berdasarkan nama, organisasi, atau wilayah..."
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 pr-10 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                autocomplete="off"
                            >
                            
                            <!-- Search Icon -->
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                @if($selected_ecosystem)
                                    <button 
                                        type="button"
                                        wire:click="clearEcosystemSelection"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                @else
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                @endif
                            </div>
                        </div>

                        <!-- Dropdown Results -->
                        @if($show_ecosystem_dropdown && count($this->filtered_ecosystems) > 0)
                            <div class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto" data-dropdown-items>
                                @foreach($this->filtered_ecosystems as $ecosystem)
                                    <button 
                                        type="button"
                                        wire:click="selectEcosystem({{ $ecosystem->id }})"
                                        data-ecosystem-item
                                        class="w-full text-left px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600 focus:bg-gray-50 dark:focus:bg-gray-600 focus:outline-none border-b border-gray-100 dark:border-gray-600 last:border-b-0 transition-colors"
                                    >
                                        <div class="flex items-start space-x-3">
                                            <!-- Ecosystem Avatar -->
                                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">
                                                    {{ strtoupper(substr($ecosystem->ecosystem_title, 0, 2)) }}
                                                </span>
                                            </div>
                                            
                                            <!-- Ecosystem Info -->
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-gray-900 dark:text-white text-sm truncate">
                                                    {{ $ecosystem->ecosystem_title }}
                                                </h4>
                                                <p class="text-xs text-gray-600 dark:text-gray-400 truncate">
                                                    {{ $ecosystem->organization_name }}
                                                </p>
                                                <div class="flex items-center mt-1 space-x-2">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                        {{ $ecosystem->work_region }}
                                                    </span>
                                                    @if($ecosystem->description)
                                                        <span class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                            {{ Str::limit($ecosystem->description, 50) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Arrow Icon -->
                                            <div class="flex-shrink-0">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @elseif($show_ecosystem_dropdown && empty($ecosystem_search))
                            <div class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg p-6">
                                <div class="text-center text-gray-500 dark:text-gray-400">
                                    <div class="w-12 h-12 mx-auto mb-3 bg-gradient-to-br from-purple-100 to-blue-100 dark:from-purple-900 dark:to-blue-900 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium">Ketik untuk mencari ekosistem...</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Cari berdasarkan nama, organisasi, atau wilayah</p>
                                </div>
                            </div>
                        @elseif($show_ecosystem_dropdown && count($this->filtered_ecosystems) == 0)
                            <div class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg p-6">
                                <div class="text-center text-gray-500 dark:text-gray-400">
                                    <div class="w-12 h-12 mx-auto mb-3 bg-gradient-to-br from-orange-100 to-red-100 dark:from-orange-900 dark:to-red-900 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium">Tidak ada hasil ditemukan</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                        Tidak ada ekosistem yang cocok dengan "<span class="font-medium">{{ $ecosystem_search }}</span>"
                                    </p>
                                    <button 
                                        type="button"
                                        wire:click="clearEcosystemSelection"
                                        class="mt-2 text-xs text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-200 font-medium"
                                    >
                                        Hapus pencarian
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- Selected Ecosystem Preview -->
                        @if($selected_ecosystem)
                            <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-semibold text-xs">
                                            {{ strtoupper(substr($selected_ecosystem->ecosystem_title, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-blue-900 dark:text-blue-200 text-sm">
                                            {{ $selected_ecosystem->ecosystem_title }}
                                        </h4>
                                        <p class="text-xs text-blue-700 dark:text-blue-300">
                                            {{ $selected_ecosystem->organization_name }} • {{ $selected_ecosystem->work_region }}
                                        </p>
                                        @if($selected_ecosystem->description)
                                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 line-clamp-2">
                                                {{ $selected_ecosystem->description }}
                                            </p>
                                        @endif
                                    </div>
                                    <button 
                                        type="button"
                                        wire:click="clearEcosystemSelection"
                                        class="flex-shrink-0 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- Hidden input for validation -->
                        <input type="hidden" wire:model="selected_ecosystem_id" required>
                        
                        @error('selected_ecosystem_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="invitation_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pesan Undangan
                        </label>
                        <textarea 
                            wire:model="invitation_message"
                            id="invitation_message"
                            rows="4"
                            placeholder="Tuliskan pesan personal untuk mengundang ekosistem ini berkolaborasi..."
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                            required
                        ></textarea>
                        @error('invitation_message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium transition-colors"
                        >
                            Kirim Undangan
                        </button>
                        <button 
                            type="button" 
                            wire:click="toggleInvitationForm"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg text-sm font-medium transition-colors"
                        >
                            Batal
                        </button>
                    </div>
                </form>
            @elseif(count($available_ecosystems) == 0)
                <div class="text-center py-4">
                    <div class="text-gray-400 mb-2">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        Semua ekosistem yang tersedia sudah diundang atau tidak ada ekosistem lain yang dapat diundang.
                    </p>
                </div>
            @endif

            <!-- Show Current Invitations -->
            @if($allInvitations->count() > 0)
                <div class="mt-6">
                    <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Status Undangan</h3>
                    <div class="space-y-3">
                        @foreach($allInvitations as $invitation)
                            <div class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">
                                        {{ $invitation->ecosystem->ecosystem_title }}
                                    </h4>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ $invitation->ecosystem->organization_name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                        Diundang oleh: {{ $invitation->invitedBy->name }}
                                    </p>
                                </div>
                                <div class="flex items-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        {{ $invitation->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : '' }}
                                        {{ $invitation->status === 'accepted' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}
                                        {{ $invitation->status === 'declined' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : '' }}
                                    ">
                                        {{ $invitation->status_label }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                        @endif
        </div>

        <!-- Enhanced Styling -->
        <style>
            .ecosystem-dropdown-enter {
                animation: dropdownFadeIn 0.2s ease-out forwards;
            }
            
            .ecosystem-dropdown-exit {
                animation: dropdownFadeOut 0.15s ease-in forwards;
            }
            
            @keyframes dropdownFadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-4px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @keyframes dropdownFadeOut {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(-4px);
                }
            }
            
            .ecosystem-item-hover {
                background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
                border-left: 3px solid rgba(139, 92, 246, 0.5);
                transform: translateX(2px);
            }
            
            .search-input-focus {
                box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
                border-color: rgba(139, 92, 246, 0.5);
            }
            
            .pulse-animation {
                animation: pulse 2s infinite;
            }
            
            @keyframes pulse {
                0%, 100% {
                    opacity: 1;
                }
                50% {
                    opacity: 0.7;
                }
            }
        </style>

        <!-- Interactive Dropdown Script -->
        <script>
            document.addEventListener('livewire:initialized', () => {
                // Enhanced close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    const dropdown = document.querySelector('.ecosystem-dropdown-wrapper');
                    const searchInput = document.getElementById('ecosystem_search');
                    
                    if (dropdown && !dropdown.contains(event.target) && event.target !== searchInput) {
                        const dropdownElement = dropdown.querySelector('[data-dropdown-items]');
                        if (dropdownElement) {
                            dropdownElement.classList.add('ecosystem-dropdown-exit');
                            setTimeout(() => {
                                @this.set('show_ecosystem_dropdown', false);
                            }, 150);
                        } else {
                            @this.set('show_ecosystem_dropdown', false);
                        }
                    }
                });

                // Enhanced input focus effects
                const searchInput = document.getElementById('ecosystem_search');
                if (searchInput) {
                    searchInput.addEventListener('focus', function() {
                        this.classList.add('search-input-focus');
                    });
                    
                    searchInput.addEventListener('blur', function() {
                        this.classList.remove('search-input-focus');
                    });
                }

                // Enhanced keyboard navigation
                document.addEventListener('keydown', function(event) {
                    const searchInput = document.getElementById('ecosystem_search');
                    const dropdown = document.querySelector('[data-dropdown-items]');
                    
                    if (!dropdown || document.activeElement !== searchInput) return;
                    
                    const items = dropdown.querySelectorAll('[data-ecosystem-item]');
                    let currentIndex = Array.from(items).findIndex(item => 
                        item.classList.contains('bg-gray-100') || item.classList.contains('ecosystem-item-hover')
                    );
                    
                    if (event.key === 'ArrowDown') {
                        event.preventDefault();
                        items.forEach(item => {
                            item.classList.remove('bg-gray-100', 'dark:bg-gray-600', 'ecosystem-item-hover');
                        });
                        currentIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
                        items[currentIndex]?.classList.add('ecosystem-item-hover');
                        items[currentIndex]?.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                    } else if (event.key === 'ArrowUp') {
                        event.preventDefault();
                        items.forEach(item => {
                            item.classList.remove('bg-gray-100', 'dark:bg-gray-600', 'ecosystem-item-hover');
                        });
                        currentIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
                        items[currentIndex]?.classList.add('ecosystem-item-hover');
                        items[currentIndex]?.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                    } else if (event.key === 'Enter' && currentIndex >= 0) {
                        event.preventDefault();
                        items[currentIndex]?.click();
                    } else if (event.key === 'Escape') {
                        const dropdownElement = dropdown;
                        dropdownElement.classList.add('ecosystem-dropdown-exit');
                        setTimeout(() => {
                            @this.set('show_ecosystem_dropdown', false);
                            searchInput.blur();
                        }, 150);
                    }
                });

                // Add entrance animation to dropdown
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1 && node.hasAttribute('data-dropdown-items')) {
                                node.classList.add('ecosystem-dropdown-enter');
                            }
                        });
                    });
                });
                
                observer.observe(document.body, {
                    childList: true,
                    subtree: true
                });
            });
        </script>
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

                @if($collectiveAction->latitude && $collectiveAction->longitude)
                <!-- Map Display -->
                <div class="mt-4">
                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div id="actionMap" style="height: 200px; width: 100%;"></div>
                    </div>
                    
                    <!-- Google Maps Integration -->
                    <div class="mt-3 flex flex-wrap gap-2">
                        <a href="https://www.google.com/maps?q={{ $collectiveAction->latitude }},{{ $collectiveAction->longitude }}" 
                           target="_blank" 
                           class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            Lihat di Google Maps
                        </a>
                        
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $collectiveAction->latitude }},{{ $collectiveAction->longitude }}" 
                           target="_blank" 
                           class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3"/>
                            </svg>
                            Petunjuk Arah
                        </a>

                        <button onclick="openInMapsApp()" 
                                class="inline-flex items-center px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/>
                            </svg>
                            Buka di Aplikasi
                        </button>

                        <button onclick="shareLocation()" 
                                class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                            </svg>
                            Bagikan Lokasi
                        </button>
                    </div>

                    <!-- Alternative Maps Apps -->
                    <div class="mt-3 border-t border-gray-200 dark:border-gray-600 pt-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Buka dengan aplikasi lain:</p>
                        <div class="flex flex-wrap gap-2 text-xs">
                            <a href="https://waze.com/ul?ll={{ $collectiveAction->latitude }},{{ $collectiveAction->longitude }}&navigate=yes" 
                               target="_blank" 
                               class="inline-flex items-center px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-md transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                </svg>
                                Waze
                            </a>
                            
                            <a href="https://maps.apple.com/?q={{ $collectiveAction->latitude }},{{ $collectiveAction->longitude }}" 
                               target="_blank" 
                               class="inline-flex items-center px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                </svg>
                                Apple Maps
                            </a>
                            
                            <button onclick="copyCoordinates()" 
                                    class="inline-flex items-center px-2 py-1 bg-green-100 hover:bg-green-200 text-green-800 rounded-md transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                                Salin Koordinat
                            </button>
                        </div>
                    </div>

                    <!-- Additional Location Info -->
                    <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                        <p>Koordinat: {{ number_format($collectiveAction->latitude, 6) }}, {{ number_format($collectiveAction->longitude, 6) }}</p>
                        <p class="mt-1">• <strong>Google Maps</strong>: Lihat lokasi dan petunjuk arah</p>
                        <p>• <strong>Buka di Aplikasi</strong>: Otomatis membuka aplikasi maps default perangkat</p>
                        <p>• <strong>Bagikan Lokasi</strong>: Bagikan koordinat ke aplikasi lain</p>
                    </div>
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
                                                {{ $contribution->user->initials() }}
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $contribution->user->name }}</h4>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $contribution->user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            <strong>Jenis Kontribusi:</strong> 
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-xs">
                                                {{ $contribution->contribution_type_label }}
                                            </span>
                                        </p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                            <strong>Deskripsi:</strong> {{ $contribution->contribution_description }}
                                        </p>
                                        @if($contribution->contribution_amount)
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            <strong>Jumlah:</strong> Rp {{ number_format($contribution->contribution_amount, 0, ',', '.') }}
                                        </p>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Ditawarkan: {{ $contribution->offered_at ? $contribution->offered_at->format('d M Y H:i') : 'N/A' }}
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
            <div class="mb-6">
                <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Kontribusi yang Diterima</h3>
                <div class="space-y-3">
                    @foreach($acceptedContributions as $contribution)
                        <div class="p-4 border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-green-600 dark:text-green-400 font-semibold text-xs">
                                                {{ $contribution->user->initials() }}
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $contribution->user->name }}</h4>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $contribution->user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            <strong>Jenis Kontribusi:</strong> 
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-xs">
                                                {{ $contribution->contribution_type_label }}
                                            </span>
                                        </p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                            <strong>Deskripsi:</strong> {{ $contribution->contribution_description }}
                                        </p>
                                        @if($contribution->contribution_amount)
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            <strong>Jumlah:</strong> Rp {{ number_format($contribution->contribution_amount, 0, ',', '.') }}
                                        </p>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Diterima: {{ $contribution->accepted_at ? $contribution->accepted_at->format('d M Y H:i') : 'N/A' }}
                                    </p>
                                </div>
                                @if($collectiveAction->canUserManage(Auth::user()))
                                <div class="flex gap-2 ml-4">
                                    <button 
                                        wire:click="completeContribution({{ $contribution->id }})"
                                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-medium transition-colors"
                                    >
                                        Selesai
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Completed Contributions -->
        @if($completedContributions->count() > 0)
            <div class="mb-6">
                <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Kontribusi yang Selesai</h3>
                <div class="space-y-3">
                    @foreach($completedContributions as $contribution)
                        <div class="p-4 border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-blue-600 dark:text-blue-400 font-semibold text-xs">
                                        {{ $contribution->user->initials() }}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $contribution->user->name }}</h4>
                                        <span class="ml-2 px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-xs">
                                            Selesai
                                        </span>
                                    </div>
                                    <div class="mb-2">
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            <strong>Jenis Kontribusi:</strong> 
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-xs">
                                                {{ $contribution->contribution_type_label }}
                                            </span>
                                        </p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                            <strong>Deskripsi:</strong> {{ $contribution->contribution_description }}
                                        </p>
                                        @if($contribution->contribution_amount)
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            <strong>Jumlah:</strong> Rp {{ number_format($contribution->contribution_amount, 0, ',', '.') }}
                                        </p>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Selesai: {{ $contribution->completed_at ? $contribution->completed_at->format('d M Y H:i') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($pendingContributions->count() === 0 && $acceptedContributions->count() === 0 && $completedContributions->count() === 0)
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
                        @php
                            $userContributions = $collectiveAction->contributions()->where('user_id', $user->id)->get();
                            $acceptedCount = $userContributions->where('status', 'accepted')->count();
                            $completedCount = $userContributions->where('status', 'completed')->count();
                            $totalAmount = $userContributions->where('status', 'accepted')->sum('contribution_amount');
                        @endphp
                        <div class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mr-3">
                                <span class="text-purple-600 dark:text-purple-400 font-semibold text-sm">
                                    {{ $user->initials() }}
                                </span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $user->name }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-500 dark:text-gray-500">
                                        {{ $userContributions->count() }} kontribusi
                                    </span>
                                    @if($acceptedCount > 0)
                                        <span class="text-xs text-green-600 dark:text-green-400">
                                            {{ $acceptedCount }} diterima
                                        </span>
                                    @endif
                                    @if($completedCount > 0)
                                        <span class="text-xs text-blue-600 dark:text-blue-400">
                                            {{ $completedCount }} selesai
                                        </span>
                                    @endif
                                </div>
                                @if($totalAmount > 0)
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                        Total: Rp {{ number_format($totalAmount, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-right">
                                @if($acceptedCount > 0)
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-xs">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full text-xs">
                                        Menunggu
                                    </span>
                                @endif
                            </div>
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

@if($collectiveAction->latitude && $collectiveAction->longitude)
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map for collective action location
            const lat = {{ $collectiveAction->latitude }};
            const lng = {{ $collectiveAction->longitude }};
            
            const actionMap = L.map('actionMap').setView([lat, lng], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(actionMap);

            // Add marker with click event to open in Google Maps
            const marker = L.marker([lat, lng]).addTo(actionMap)
                .bindPopup(`
                    <div class="text-center">
                        <p class="font-medium mb-2">{{ addslashes($collectiveAction->location) }}</p>
                        <a href="https://www.google.com/maps?q=${lat},${lng}" 
                           target="_blank" 
                           class="inline-flex items-center px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            Buka di Google Maps
                        </a>
                    </div>
                `)
                .openPopup();
        });

        // Share location function
        function shareLocation() {
            const lat = {{ $collectiveAction->latitude }};
            const lng = {{ $collectiveAction->longitude }};
            const locationName = `{{ addslashes($collectiveAction->location) }}`;
            const actionTitle = `{{ addslashes($collectiveAction->title) }}`;
            
            const googleMapsUrl = `https://www.google.com/maps?q=${lat},${lng}`;
            const shareText = `📍 Lokasi: ${actionTitle}\n${locationName}\n${googleMapsUrl}`;

            // Check if Web Share API is supported
            if (navigator.share) {
                navigator.share({
                    title: `Lokasi: ${actionTitle}`,
                    text: shareText,
                    url: googleMapsUrl
                }).catch(err => {
                    console.log('Error sharing:', err);
                    fallbackShare(shareText);
                });
            } else {
                fallbackShare(shareText);
            }
        }

        // Fallback share function
        function fallbackShare(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    showNotification('Link lokasi berhasil disalin!', 'success');
                }).catch(err => {
                    console.log('Error copying to clipboard:', err);
                    showShareModal(text);
                });
            } else {
                showShareModal(text);
            }
        }

        // Show share modal
        function showShareModal(text) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Bagikan Lokasi</h3>
                    <textarea readonly class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white" rows="4">${text}</textarea>
                    <div class="flex gap-2 mt-4">
                        <button onclick="copyShareText('${text}'); this.closest('.fixed').remove();" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                            Salin Teks
                        </button>
                        <button onclick="this.closest('.fixed').remove();" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        // Copy share text
        function copyShareText(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    showNotification('Text berhasil disalin!', 'success');
                });
            }
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }

        // Add additional maps apps detection and options
        function openInMapsApp() {
            const lat = {{ $collectiveAction->latitude }};
            const lng = {{ $collectiveAction->longitude }};
            const userAgent = navigator.userAgent || navigator.vendor || window.opera;

            // Check for mobile devices
            if (/android/i.test(userAgent)) {
                // Android - try Google Maps app first, then fallback to browser
                window.open(`geo:${lat},${lng}?q=${lat},${lng}`, '_system');
                setTimeout(() => {
                    window.open(`https://www.google.com/maps?q=${lat},${lng}`, '_blank');
                }, 1000);
            } else if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                // iOS - try Apple Maps first, then Google Maps
                window.open(`maps://maps.apple.com/?q=${lat},${lng}`, '_system');
                setTimeout(() => {
                    window.open(`https://www.google.com/maps?q=${lat},${lng}`, '_blank');
                }, 1000);
            } else {
                // Desktop - open Google Maps in browser
                window.open(`https://www.google.com/maps?q=${lat},${lng}`, '_blank');
            }
        }

        // Copy coordinates function
        function copyCoordinates() {
            const lat = {{ $collectiveAction->latitude }};
            const lng = {{ $collectiveAction->longitude }};
            const coordinates = `${lat}, ${lng}`;
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(coordinates).then(() => {
                    showNotification('Koordinat berhasil disalin!', 'success');
                }).catch(err => {
                    console.log('Error copying coordinates:', err);
                    showNotification('Gagal menyalin koordinat', 'error');
                });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = coordinates;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showNotification('Koordinat berhasil disalin!', 'success');
            }
        }
    </script>
@endpush
@endif

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