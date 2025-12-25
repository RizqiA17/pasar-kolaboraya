<x-flux::dropdown align="right" width="128" class="relative z-10" x-data="notificationUnread()" x-init="startPolling()">
    <flux:button icon="bell" @click="$wire.emit('refreshNotifications')"
        class="relative m-auto transition-all duration-300 border rounded-full shadow-lg group text-slate-600 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 bg-white/60 hover:bg-white/80 dark:bg-slate-800/60 dark:hover:bg-slate-800/80 backdrop-blur-sm size-10 hover:shadow-xl border-white/20 dark:border-slate-700/50">
    </flux:button>
    <div x-show="haveUnread == true" x-transition
        class="absolute top-0 right-0 w-3 h-3 rounded-full bg-gradient-to-r from-pink-500 to-rose-500 animate-pulse">
    </div>
    <flux:menu
        class="mt-2 bg-white/90! dark:bg-slate-800/90! dark:border backdrop-blur-xl dark:border-slate-700/50! shadow-2xl shadow-blue-500/20! rounded-2xl overflow-hidden">
        <div class="lg:w-128 w-80 max-w-[calc(100vw-2rem)]">
            <livewire:notification.notification-dropdown />

        </div>
    </flux:menu>

</x-flux::dropdown>
<script>
    function notificationUnread() {
        return {
            haveUnread: false,
            interval: null,

            async fetchUnread() {
                try {
                    const res = await fetch('/api/notifications/have-unread', {
                        headers: {
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    });

                    if (!res.ok) {
                        return;
                    }

                    const response = await res.json()

                    const data = response.data;

                    this.haveUnread = data.have_unread;
                } catch (e) {
                    console.error('Failed to fetch unread notifications');
                }
            },

            startPolling() {
                this.fetchUnread();

                this.interval = setInterval(() => {
                    this.fetchUnread();
                }, 15000);
            },

            stopPolling() {
                if (this.interval) {
                    clearInterval(this.interval);
                }
            }
        };
    }
</script>
