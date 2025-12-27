<x-flux::dropdown align="right" width="128" class="relative z-10" x-data="notificationDropdown" x-init="init" x-cloak
    class="relative">
    <flux:button icon="bell" @click="toggle"
        class="relative m-auto transition-all duration-300 border rounded-full shadow-lg group text-slate-600 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 bg-white/60 hover:bg-white/80 dark:bg-slate-800/60 dark:hover:bg-slate-800/80 backdrop-blur-sm size-10 hover:shadow-xl border-white/20 dark:border-slate-700/50">
    </flux:button>
    @if ($hasUnread)
        <div
            class="absolute top-0 right-0 w-3 h-3 rounded-full bg-gradient-to-r from-pink-500 to-rose-500 animate-pulse">
        </div>
    @endif
    <flux:menu x-show="open" @click.outside="close"
        class="mt-2 overflow-hidden shadow-2xl bg-white/90 dark:bg-slate-800/90 dark:border backdrop-blur-xl dark:border-slate-700/50 shadow-blue-500/20 rounded-2xl">
        <div class="lg:w-128 w-80 max-w-[calc(100vw-2rem)]">
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200 dark:border-slate-700">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                    Notifikasi
                </h3>
                <div class="flex items-center space-x-2">
                    @if ($unreadCount > 0)
                        <span
                            class="px-2 py-0.5 text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-full">
                            {{ $unreadCount }} baru
                        </span>
                    @endif
                </div>
            </div>
            <div x-show="loading" x-transition class="flex flex-col items-center py-6">
                <div class="w-6 h-6 border-b-2 border-blue-600 rounded-full animate-spin"></div>
                <div class="mt-2 text-xs text-gray-500">
                    Memuat notifikasi...
                </div>
            </div>
            <!-- List -->
            <div class="overflow-y-auto divide-y max-h-96 divide-slate-200 dark:divide-slate-700" x-show="!loading">
                @forelse ($notifications as $notification)
                    <div class="flex items-center w-full gap-4 px-4 py-3 hover:bg-gray-500/10">
                        <div class="flex-grow transition-all cursor-pointer" wire:click="seeNotification(`{{ $notification['redirect_url'] }}`, {{ $notification['id'] }})">
                            <h4 class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                {{ $notification['title'] }}
                            </h4>
                            <p class="mt-0.5 text-xs text-slate-600 dark:text-slate-400 line-clamp-2">
                                {{ $notification['message'] }}
                            </p>
                            <span class="text-[11px] text-slate-500">
                                {{ $notification['created_at'] }}
                            </span>
                        </div>
                        <div wire:click="markAsRead({{ $notification['id'] }})" class="cursor-pointer py-4">
                            <flux:icon.x-mark />
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center">
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Tidak ada notifikasi
                        </p>
                    </div>
                @endforelse
            </div>
            <!-- Footer -->
            {{-- <a href="{{ route('notifications.index') }}"
                class="block px-4 py-3 text-xs font-medium text-center text-blue-600 border-t dark:text-blue-400 border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800">
                Lihat semua notifikasi
            </a> --}}
        </div>
    </flux:menu>
</x-flux::dropdown>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notificationDropdown', () => ({
            open: false,
            loading: false,
            unreadInterval: null,
            notificationInterval: null,
            init() {
                this.startUnreadPolling();
            },
            startUnreadPolling() {
                this.unreadInterval = setInterval(() => {
                    this.$wire.dispatch('refreshUnread');
                }, 15000);
            },
            startNotificationPolling() {
                if (this.notificationInterval) {
                    return;
                }
                this.notificationInterval = setInterval(() => {
                    this.$wire.dispatch('refreshNotifications');
                }, 15000);
            },
            stopNotificationPolling() {
                if (this.notificationInterval) {
                    clearInterval(this.notificationInterval);
                    this.notificationInterval = null;
                }
            },
            toggle() {
                this.open = !this.open;
                if (this.open) {
                    this.loading = true;
                    this.$wire.call('loadNotifications')
                        .then(() => {
                            this.loading = false;
                        });
                    this.startNotificationPolling();
                } else {
                    this.stopNotificationPolling();
                }
            },
            close() {
                this.open = false;
                this.stopNotificationPolling();
            }
        }));
    });
</script>
