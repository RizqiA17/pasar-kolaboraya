<div class="space-y-6" wire:poll.30s="refreshData">
    {{-- Header --}}
    <div class="p-6 text-white bg-gradient-to-r from-primary-blue to-secondary-green rounded-xl">
        <div class="flex items-start justify-between max-sm:flex-col">
            <div>
                <h1 class="mb-2 text-2xl font-bold">Jelajahi Ekosistem Kolaborasi</h1>
                <p class="text-blue-100">Temukan dan bergabung dengan ekosistem sesuai minat dan keahlian Anda</p>
            </div>

            <div class="flex flex-shrink-0 gap-2 sm:flex-col max-sm:mt-4 max-sm:w-full max-sm:flex-wrap">
                @php $user = auth()->user(); @endphp

                @if ($user?->isApprovedEcosystemBuilder() && !$hasEcosystem)
                    <flux:button class="max-sm:w-full" :href="route('ecosystem.create')" wire:navigate>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Buat Ekosistem
                    </flux:button>
                @endif

                @if ($user?->canJoinEcosystemsAndActions())
                    <flux:button class="max-sm:w-full" :href="route('ecosystem.qr.scanner')" wire:navigate>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zM17 8h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        Scan QR Code
                    </flux:button>
                @endif
            </div>
        </div>
    </div>

    {{-- Filter Box --}}
    <div class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-xl p-6">
        <h2 class="mb-4 text-lg font-semibold">Filter Pencarian</h2>

        <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-2 lg:grid-cols-4">
            <flux:input wire:model.live.debounce.300ms="search" type="search" :placeholder="'Cari ekosistem...'" />

            <flux:select wire:model.live="selectedRegion" placeholder="Pilih Wilayah">
                <option value="">Semua Wilayah</option>
                @foreach ($regions as $region)
                    <option value="{{ $region }}">{{ $region }}</option>
                @endforeach
            </flux:select>

            <flux:select wire:model.live="selectedIssue" placeholder="Pilih Isu">
                <option value="">Semua Isu</option>
                @foreach ($interests as $i)
                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                @endforeach
            </flux:select>

            <flux:select wire:model.live="selectedNeededRole" placeholder="Keahlian Dibutuhkan">
                <option value="">Semua Keahlian</option>
                @foreach ($skills as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </flux:select>
        </div>

        @php $filtered = $search || $selectedRegion || $selectedIssue || $selectedNeededRole; @endphp

        @if ($filtered)
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $ecosystems->total() }} ekosistem ditemukan
                </span>
                <flux:button wire:click="clearFilters" variant="outline" size="sm">Hapus Filter</flux:button>
            </div>
        @endif
    </div>

    {{-- Flash Message --}}
    @if (session('error'))
        <div
            class="p-4 border bg-accent-red/10 dark:bg-accent-red/20 border-accent-red/20 dark:border-accent-red/30 rounded-xl">
            <p class="text-accent-red dark:text-accent-red">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Ecosystem List --}}
    <div class="grid grid-cols-[repeat(auto-fill,_minmax(384px,_1fr))] gap-6">
        @forelse ($ecosystems as $e)
            @php
                $userStatus = $user ? $e->getUserStatus($user) : null;
                $issues = collect($e->issues_addressed);
                $roles = collect($e->needed_roles);
                $issuesCount = $issues->count();
                $roleCount = $roles->count();
            @endphp

            <div
                class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-xl  overflow-hidden hover:shadow-md flex flex-col hover:scale-105 transition-[scale,shadow] duration-300">
                <a href="{{ route('ecosystem.dashboard', $e) }}" class="flex flex-col flex-grow p-6">
                    {{-- Title --}}
                    <div class="flex flex-col items-start gap-1 mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-200 line-clamp-1">
                            {{ $e->ecosystem_title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400 line-clamp-1">{{ $e->organization_name }}
                        </p>
                        <div class="flex items-center w-full text-xs text-gray-500 dark:text-slate-400">
                            <svg class="w-4! h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <p class="w-full line-clamp-1">
                                {{ $e->work_region }}
                            </p>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if ($e->description)
                        <p
                            class="flex-grow mb-4 text-sm text-gray-700 dark:text-slate-300 line-clamp-3 min-h-15 max-h-15">
                            {{ $e->description }}</p>
                    @endif

                    {{-- Issues --}}
                    @if ($issuesCount)
                        <div class="mb-4">
                            <h4
                                class="mb-2 text-xs font-medium tracking-wide text-gray-500 uppercase dark:text-slate-400">
                                Isu yang Diperjuangkan</h4>

                            <div class="flex flex-wrap gap-1 h-14">
                                @foreach ($issues->take(3) as $id)
                                    @php
                                        $name = is_numeric($id) ? $interests->find($id)->name ?? null : $id;
                                    @endphp
                                    @if ($name)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-primary-light-blue dark:bg-primary-blue text-primary-blue dark:text-primary-light-blue h-fit">
                                            {{ $name }}
                                        </span>
                                    @endif
                                @endforeach

                                @if ($issuesCount > 3)
                                    <span
                                        class="inline-flex px-2 py-1 text-xs text-gray-500 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-slate-400 h-fit">
                                        +{{ $issuesCount - 3 }} lainnya
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Needed Roles --}}
                    @if ($roleCount)
                        <div class="mb-4">
                            <h4
                                class="mb-2 text-xs font-medium tracking-wide text-gray-500 uppercase dark:text-slate-400">
                                Keahlian Anggota</h4>

                            <div class="flex flex-wrap gap-1 h-14">
                                @foreach ($roles->take(3) as $rid)
                                    @php $skill = $skills->find($rid); @endphp

                                    @if ($skill)
                                        <span
                                            class="inline-flex px-2 py-1 text-xs rounded-full text-emerald-800 dark:text-emerald-200 bg-emerald-100 dark:bg-secondary-green/50 h-fit">
                                            {{ $skill->name }}
                                        </span>
                                    @endif
                                @endforeach

                                @if ($roleCount > 3)
                                    <span
                                        class="inline-flex px-2 py-1 text-xs text-gray-500 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-slate-400 h-fit">
                                        +{{ $roleCount - 3 }} lainnya
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Stats --}}
                    <div class="flex items-center justify-between mb-4 text-sm text-gray-500 dark:text-slate-400">
                        <div class="flex items-center">
                            <flux:icon.users class="w-4 h-4 mr-2" />
                            {{ $e->accepted_users_count ?? $e->acceptedUsers->count() }} anggota
                        </div>

                        @if ($e->max_users)
                            <div class="text-xs">Maks: {{ $e->max_users }}</div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        {{-- Creator --}}
                        <div class="flex items-center">
                            <div
                                class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-medium text-white rounded-full bg-gradient-to-r from-primary-blue to-secondary-green">
                                {{ $e->creator->initials() }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700 dark:text-slate-300">
                                    {{ $e->creator->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">Ecosystem Builder</p>
                            </div>
                        </div>

                        {{-- Like  --}}
                        <button id="like-button-{{ $e->id }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm bg-none font-medium transition-all duration-200
                            {{ $e->isLiked
                                ? 'text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400'
                                : 'text-gray-600 hover:text-gray-700 dark:text-gray-500 dark:hover:text-gray-400' }}"
                            onclick="toggleLike('ecosystem', {{ $e->id }}, '{{ $e->id }}', event)">

                            <svg id="like-icon-{{ $e->id }}" class="w-8 h-8" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                            </svg>

                            <span id="like-count-{{ $e->id }}">{{ $e->likeCount }}</span>
                        </button>
                    </div>
                </a>

                {{-- Footer --}}
                <div class="flex gap-4 px-6 py-4 border-t border-gray-200 bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                    @if ($e->can_join)
                        @if ($user?->canJoinEcosystemsAndActions())
                            <flux:button wire:click="joinEcosystem({{ $e->id }})" variant="primary"
                                size="sm" class="w-full">
                                Bergabung
                            </flux:button>
                        @else
                            <div class="flex items-center h-8!">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Hanya dapat terhubung dengan
                                    pengguna lain</span>
                            </div>
                        @endif
                    @elseif ($e->can_contribute)
                        <flux:button href="{{ route('ecosystem.contribute', $e->id) }}" variant="primary"
                            size="sm" class="w-full" wire:navigate icon="plus">
                            Berkontribusi
                        </flux:button>
                        <span class="flex items-center justify-center w-8 h-8 px-2 py-1 text-xs rounded-full text-emerald-800 dark:text-emerald-200 bg-emerald-100 dark:bg-secondary-green/50">
                            <flux:icon.check class="size-4" />
                        </span>
                    @elseif ($e->is_full)
                        <div class="flex items-center h-8!">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Ekosistem Penuh</span>
                        </div>
                    @elseif($userStatus == 'pending')
                        <span
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-yellow-800 bg-yellow-100 rounded-full dark:text-yellow-200 dark:bg-secondary-yellow/50 w-fit">
                            Menunggu Persetujuan
                        </span>
                    @else
                        <div class="flex items-center h-8!">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Anda sudah aktif dalm
                                ekosistem ini</span>
                        </div>
                    @endif
                </div>
            </div>

        @empty
            <div class="py-12 text-center col-span-full">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>

                <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">Belum Ada Ekosistem</h3>

                <p class="mb-4 text-gray-600 dark:text-gray-400">
                    {{ $filtered ? 'Tidak ada ekosistem yang sesuai dengan filter Anda.' : 'Belum ada ekosistem yang tersedia saat ini.' }}
                </p>

                @if ($filtered)
                    <flux:button wire:click="clearFilters" variant="outline">Hapus Filter</flux:button>
                @endif
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($ecosystems->hasPages())
        <div class="mt-6">{{ $ecosystems->links() }}</div>
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
                    <p class="mt-1 text-sm">${message}</p>
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
        function toggleLike(type, id, elementId, event) {
            event.stopPropagation();
            event.preventDefault();

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
                            button.classList.remove('text-gray-600', 'hover:text-gray-700', 'dark:text-gray-500', 'dark:hover:text-gray-400');
                            button.classList.add('text-red-600', 'hover:text-red-700', 'dark:text-red-500', 'dark:hover:text-red-400');
                        } else {
                            button.classList.remove('text-red-600', 'hover:text-red-700', 'dark:text-red-500', 'dark:hover:text-red-400');
                            button.classList.add('text-gray-600', 'hover:text-gray-700', 'dark:text-gray-500', 'dark:hover:text-gray-400');
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
                            button.classList.remove('text-gray-600', 'hover:text-gray-700', 'dark:text-gray-500', 'dark:hover:text-gray-400');
                            button.classList.add('text-red-600', 'hover:text-red-700', 'dark:text-red-500', 'dark:hover:text-red-400');
                        } else {
                            button.classList.remove('text-red-600', 'hover:text-red-700', 'dark:text-red-500', 'dark:hover:text-red-400');
                            button.classList.add('text-gray-600', 'hover:text-gray-700', 'dark:text-gray-500', 'dark:hover:text-gray-400');
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
