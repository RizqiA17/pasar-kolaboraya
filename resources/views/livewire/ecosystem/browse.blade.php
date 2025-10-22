<div class="space-y-6" wire:poll.30s="refreshData">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-blue to-secondary-green text-white rounded-xl p-6">
        <div class="flex justify-between items-start max-sm:flex-col">
            <div>
                <h1 class="text-2xl font-bold mb-2">Jelajahi Ekosistem Kolaborasi</h1>
                <p class="text-blue-100">Temukan dan bergabung dengan ekosistem yang sesuai dengan minat dan keahlian
                    Anda</p>
            </div>
            <div class="flex-shrink-0 flex sm:flex-col max-sm:mt-4 max-sm:w-full gap-2 max-sm:flex-wrap">
                @if (auth()->user() && auth()->user()->isApprovedEcosystemBuilder() && !$hasEcosystem)
                    <flux:button class="max-sm:w-full" :href="route('ecosystem.create')" wire:navigate>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Buat Ekosistem
                    </flux:button>
                @endif
                @if (Auth::user()->canJoinEcosystemsAndActions())
                    <flux:button class="max-sm:w-full" :href="route('ecosystem.qr.scanner')" wire:navigate>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                            </path>
                        </svg>
                        Scan QR Code
                    </flux:button>
                @endif
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Filter Pencarian</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <!-- Search -->
            <flux:input wire:model.live.debounce.300ms="search" :placeholder="'Cari ekosistem...'" type="search" />

            <!-- Region Filter -->
            <flux:select wire:model.live="selectedRegion" placeholder="Pilih Wilayah">
                <option value="">Semua Wilayah</option>
                @foreach ($regions as $region)
                    <option value="{{ $region }}">{{ $region }}</option>
                @endforeach
            </flux:select>

            <!-- Issue Filter -->
            <flux:select wire:model.live="selectedIssue" placeholder="Pilih Isu">
                <option value="">Semua Isu</option>
                @foreach ($interests as $interest)
                    <option value="{{ $interest->id }}">{{ $interest->name }}</option>
                @endforeach
            </flux:select>

            <!-- Needed Role Filter -->
            <flux:select wire:model.live="selectedNeededRole" placeholder="Keahlian Dibutuhkan">
                <option value="">Semua Keahlian</option>
                @foreach ($skills as $skill)
                    <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                @endforeach
            </flux:select>
        </div>

        @if ($search || $selectedRegion || $selectedIssue || $selectedNeededRole)
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $ecosystems->total() }} ekosistem ditemukan
                </span>
                <flux:button wire:click="clearFilters" variant="outline" size="sm">
                    Hapus Filter
                </flux:button>
            </div>
        @endif
    </div>

    <!-- Flash Messages -->
    @if (session('error'))
        <div
            class="bg-accent-red/10 dark:bg-accent-red/20 border border-accent-red/20 dark:border-accent-red/30 rounded-xl p-4">
            <p class="text-accent-red dark:text-accent-red">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Ecosystems Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($ecosystems as $ecosystem)
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                <!-- Header -->
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-1 line-clamp-2">
                                {{ $ecosystem->ecosystem_title }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $ecosystem->organization_name }}
                            </p>
                        </div>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 ml-4">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $ecosystem->work_region }}
                        </div>
                    </div>

                    @if ($ecosystem->description)
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 line-clamp-3">
                            {{ $ecosystem->description }}
                        </p>
                    @endif

                    <!-- Issues Addressed -->
                    @if ($ecosystem->issues_addressed)
                        <div class="mb-4">
                            <h4
                                class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                Isu yang Diperjuangkan
                            </h4>
                            <div class="flex flex-wrap gap-1">
                                @foreach (collect($ecosystem->issues_addressed)->take(3) as $issueId)
                                    @php
                                        // Check if it's a numeric ID (predefined issue) or string (custom issue)
                                        if (is_numeric($issueId) && $issueId > 0) {
                                            $interest = $interests->find($issueId);
                                            $issueName = $interest ? $interest->name : null;
                                        } else {
                                            // It's a custom issue (string)
                                            $issueName = $issueId;
                                        }
                                    @endphp
                                    @if ($issueName)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-primary-light-blue dark:bg-primary-blue text-primary-blue dark:text-primary-light-blue">
                                            {{ $issueName }}
                                        </span>
                                    @endif
                                @endforeach
                                @if (count($ecosystem->issues_addressed) > 3)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                        +{{ count($ecosystem->issues_addressed) - 3 }} lainnya
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Needed Roles -->
                    @if ($ecosystem->needed_roles)
                        <div class="mb-4">
                            <h4
                                class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                Keahlian Anggota
                            </h4>
                            <div class="flex flex-wrap gap-1">
                                @foreach (collect($ecosystem->needed_roles)->take(3) as $roleId)
                                    @php
                                        $skill = $skills->find($roleId);
                                    @endphp
                                    @if ($skill)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-neutral-orange/20 dark:bg-neutral-orange/30 text-neutral-orange dark:text-neutral-orange">
                                            {{ $skill->name }}
                                        </span>
                                    @endif
                                @endforeach
                                @if (count($ecosystem->needed_roles) > 3)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                        +{{ count($ecosystem->needed_roles) - 3 }} lainnya
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Stats -->
                    <div class="flex items-center justify-between mb-4 text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            {{ $ecosystem->accepted_users_count ?? $ecosystem->acceptedUsers->count() }} anggota
                        </div>
                        @if ($ecosystem->max_users)
                            <div class="text-xs">
                                Maks: {{ $ecosystem->max_users }}
                            </div>
                        @endif
                    </div>

                    <!-- Creator -->
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 mr-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-r from-primary-blue to-secondary-green rounded-full flex items-center justify-center text-white text-sm font-medium">
                                {{ $ecosystem->creator->initials() }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ecosystem->creator->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Ecosystem Builder
                            </p>
                        </div>
                    </div>

                    <!-- Like Button and Status -->
                    <div class="flex items-center justify-between mb-4 gap-3">
                        <!-- Like Button -->
                        <button id="like-button-{{ $ecosystem->id }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $ecosystem->isLiked ? 'bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600' }}"
                            onclick="toggleLike('ecosystem', {{ $ecosystem->id }}, '{{ $ecosystem->id }}')">
                            <svg id="like-icon-{{ $ecosystem->id }}" class="w-4 h-4" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span id="like-count-{{ $ecosystem->id }}"
                                class="font-medium">{{ $ecosystem->likeCount }}</span>
                        </button>

                        <!-- User Status Badge -->
                        @php
                            $userStatus = Auth::user() ? $ecosystem->getUserStatus(Auth::user()) : null;
                        @endphp
                        @if ($userStatus === 'accepted')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-secondary-green/20 dark:bg-secondary-green/30 text-neutral-green dark:text-white/70">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Sudah Bergabung
                            </span>
                        @elseif($userStatus === 'pending')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-secondary-yellow/20 dark:bg-secondary-yellow/30 text-yellow-700 dark:text-secondary-yellow">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Menunggu Persetujuan
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    @php
                        $canJoin = Auth::user() ? $ecosystem->canUserJoin(Auth::user()) : false;
                    @endphp

                    @if ($canJoin)
                        @if (Auth::user()->canJoinEcosystemsAndActions())
                            <!-- Join button for tamu and partisipan users -->
                            <flux:button wire:click="joinEcosystem({{ $ecosystem->id }})" variant="primary"
                                size="sm" class="w-full">
                                Bergabung
                            </flux:button>
                        @else
                            <!-- Message for komunitas users who can only connect -->
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Hanya dapat terhubung dengan pengguna lain
                            </span>
                        @endif
                    @elseif($ecosystem->canUserContribute(Auth::user()))
                        <!-- Contribute button for users who can contribute -->
                        <flux:button href="{{ route('ecosystem.contribute', $ecosystem) }}" variant="primary"
                            size="sm" class="w-full" wire:navigate>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Berkontribusi
                        </flux:button>
                    @else
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            @if ($ecosystem->max_users && $ecosystem->acceptedUsers->count() >= $ecosystem->max_users)
                                Ekosistem Penuh
                            @endif
                        </span>
                    @endif

                    <!-- Dashboard Link for all authenticated users -->
                    @if (Auth::user())
                        <div class="mt-2">
                            <a href="{{ route('ecosystem.dashboard', $ecosystem) }}"
                                class="w-full inline-flex items-center justify-center px-3 py-2 rounded-lg text-sm {{ $ecosystem->creator_id === Auth::id() ? 'bg-primary-blue hover:bg-primary-blue/90' : 'bg-gray-600 hover:bg-gray-700' }} text-white font-medium transition-colors duration-200"
                                wire:navigate>
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                {{ $ecosystem->creator_id === Auth::id() ? 'Dashboard' : 'Lihat Dashboard' }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    Belum Ada Ekosistem
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    @if ($search || $selectedRegion || $selectedIssue || $selectedNeededRole)
                        Tidak ada ekosistem yang sesuai dengan filter Anda.
                    @else
                        Belum ada ekosistem yang tersedia saat ini.
                    @endif
                </p>
                @if ($search || $selectedRegion || $selectedIssue || $selectedNeededRole)
                    <flux:button wire:click="clearFilters" variant="outline">
                        Hapus Filter
                    </flux:button>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($ecosystems->hasPages())
        <div class="mt-6">
            {{ $ecosystems->links() }}
        </div>
    @endif
</div>

@push('scripts')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Initialize Pusher for real-time ecosystem updates
        document.addEventListener('DOMContentLoaded', function() {
            try {
                if (typeof Pusher !== 'undefined' && '{{ config('broadcasting.default') }}' === 'pusher') {
                    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                        encrypted: true,
                        authEndpoint: '{{ route('broadcasting.auth') }}',
                        auth: {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        }
                    });

                    // Subscribe to user's private channel
                    const userId = {{ auth()->id() }};
                    const channel = pusher.subscribe('private-user.' + userId);

                    // Listen for ecosystem user status updated events
                    channel.bind('ecosystem.user.status.updated', function(data) {
                        console.log('Ecosystem user status updated:', data);

                        // Show notification
                        showEcosystemStatusNotification(data);

                        // Refresh Livewire component data
                        @this.call('refreshData');
                    });

                    console.log('Pusher initialized for ecosystem updates');
                } else {
                    console.log('Pusher not configured, using polling fallback');
                }
            } catch (error) {
                console.error('Pusher initialization failed:', error);
            }
        });

        // Show ecosystem status notification
        function showEcosystemStatusNotification(data) {
            const notification = document.createElement('div');
            notification.className =
                'fixed top-4 right-4 bg-blue-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-md transform transition-all duration-300 translate-x-full';

            let message = '';
            let icon = '';

            if (data.action === 'accepted') {
                message = `Anda telah diterima di ekosistem "${data.ecosystem.title}"`;
                icon = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />`;
            } else if (data.action === 'rejected') {
                message = `Permintaan bergabung ke ekosistem "${data.ecosystem.title}" ditolak`;
                icon = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />`;
            }

            notification.innerHTML = `
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${icon}
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold">Update Status Ekosistem</h4>
                    <p class="text-sm mt-1">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-white hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        `;

            // Add to page
            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }, 5000);
        }

        // Like functionality
        function toggleLike(type, id, elementId) {
            const button = document.getElementById(`like-button-${elementId}`);
            const icon = document.getElementById(`like-icon-${elementId}`);
            const count = document.getElementById(`like-count-${elementId}`);

            // Disable button during request
            button.disabled = true;

            fetch(`/${type}/${id}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update button state
                        if (data.isLiked) {
                            button.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200',
                                'dark:bg-gray-700', 'dark:text-gray-400', 'dark:hover:bg-gray-600');
                            button.classList.add('bg-red-100', 'text-red-600', 'hover:bg-red-200', 'dark:bg-red-900/20',
                                'dark:text-red-400', 'dark:hover:bg-red-900/30');
                        } else {
                            button.classList.remove('bg-red-100', 'text-red-600', 'hover:bg-red-200',
                                'dark:bg-red-900/20', 'dark:text-red-400', 'dark:hover:bg-red-900/30');
                            button.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200',
                                'dark:bg-gray-700', 'dark:text-gray-400', 'dark:hover:bg-gray-600');
                        }

                        // Update count
                        count.textContent = data.likeCount;

                        // Show notification
                        showNotification(data.message, 'success');
                    } else {
                        showNotification(data.message || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat memproses like', 'error');
                })
                .finally(() => {
                    button.disabled = false;
                });
        }

        function loadLikeStatus(type, id, elementId) {
            fetch(`/${type}/${id}/like-status`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const button = document.getElementById(`like-button-${elementId}`);
                        const count = document.getElementById(`like-count-${elementId}`);

                        if (data.isLiked) {
                            button.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200',
                                'dark:bg-gray-700', 'dark:text-gray-400', 'dark:hover:bg-gray-600');
                            button.classList.add('bg-red-100', 'text-red-600', 'hover:bg-red-200', 'dark:bg-red-900/20',
                                'dark:text-red-400', 'dark:hover:bg-red-900/30');
                        } else {
                            button.classList.remove('bg-red-100', 'text-red-600', 'hover:bg-red-200',
                                'dark:bg-red-900/20', 'dark:text-red-400', 'dark:hover:bg-red-900/30');
                            button.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200',
                                'dark:bg-gray-700', 'dark:text-gray-400', 'dark:hover:bg-gray-600');
                        }

                        count.textContent = data.likeCount;
                    }
                })
                .catch(error => {
                    console.error('Error loading like status:', error);
                });
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 3000);
        }

        // Load like status for all ecosystems on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Find all like buttons and load their status
            const likeButtons = document.querySelectorAll('[id^="like-button-"]');
            likeButtons.forEach(button => {
                const elementId = button.id.replace('like-button-', '');
                loadLikeStatus('ecosystem', elementId, elementId);
            });
        });
    </script>
@endpush
