<x-flux::dropdown align="right" width="128" class="relative z-10" x-data="notificationDropdown()" @open="refreshNotifications()">
    <flux:button icon="bell"
        class="relative m-auto transition-all duration-300 border rounded-full shadow-lg group text-slate-600 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 bg-white/60 hover:bg-white/80 dark:bg-slate-800/60 dark:hover:bg-slate-800/80 backdrop-blur-sm size-10 hover:shadow-xl border-white/20 dark:border-slate-700/50">
    </flux:button>
    <div x-show="unreadCount > 0"
        class="absolute top-0 right-0 w-3 h-3 rounded-full bg-gradient-to-r from-pink-500 to-rose-500 animate-pulse">
    </div>
    <flux:menu
        class="mt-2 bg-white/90! dark:bg-slate-800/90! dark:border backdrop-blur-xl dark:border-slate-700/50! shadow-2xl shadow-blue-500/20! rounded-2xl overflow-hidden">
        <div class="lg:w-128 w-80 max-w-[calc(100vw-2rem)]">

            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200 dark:border-slate-700">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                    Notifikasi
                </h3>

                <div class="flex items-center space-x-2">
                    <button @click="refreshNotifications()"
                        class="p-1.5 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                        title="Refresh">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>

                    <span x-show="unreadCount > 0"
                        class="px-2 py-0.5 text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-full">
                        <span x-text="unreadCount"></span> baru
                    </span>
                </div>
            </div>

            <!-- Loading -->
            <div x-show="loading" class="flex flex-col items-center py-6">
                <div class="w-6 h-6 border-b-2 border-blue-600 rounded-full animate-spin"></div>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Memuat notifikasi...
                </p>
            </div>

            <!-- List -->
            <div x-show="!loading" class="overflow-y-auto divide-y max-h-96 divide-slate-200 dark:divide-slate-700">

                <template x-for="notification in notifications" :key="notification.id">
                    <div class="px-4 py-3 transition-all cursor-pointer group hover:bg-gray-500/10"
                        @click="viewNotification(notification.redirect_url)">

                        <div class="flex items-start gap-3">
                            <!-- Dot -->
                            <div class="pt-1">
                                <span x-show="!notification.is_read"
                                    class="block w-2 h-2 bg-blue-500 rounded-full"></span>
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-slate-900 dark:text-slate-100"
                                    x-text="notification.title || 'Notifikasi'"></h4>

                                <p class="mt-0.5 text-xs text-slate-600 dark:text-slate-400 line-clamp-2"
                                    x-text="notification.message"></p>

                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-[11px] text-slate-500" x-text="notification.time_ago"></span>

                                    <div class="flex gap-1 transition opacity-0 group-hover:opacity-100">
                                        {{-- <button x-show="notification.redirect_url"
                                            @click="viewNotification(notification.id)"
                                            class="px-2 py-0.5 text-[11px] rounded bg-blue-600 text-white hover:bg-blue-700">
                                            Lihat
                                        </button>

                                        <button x-show="!notification.is_read" @click="markAsRead(notification.id)"
                                            class="px-2 py-0.5 text-[11px] rounded bg-emerald-600 text-white hover:bg-emerald-700">
                                            Tandai
                                        </button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Empty -->
                <div x-show="notifications.length === 0" class="py-10 text-center">
                    <svg class="w-10 h-10 mx-auto text-slate-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-5 5-5-5h5v-5a7.5 7.5 0 0 0-15 0v5h5l-5 5-5-5h5v-5a7.5 7.5 0 0 1 15 0v5z" />
                    </svg>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                        Tidak ada notifikasi
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <a href="{{ route('notifications.index') }}"
                class="block px-4 py-3 text-xs font-medium text-center text-blue-600 border-t dark:text-blue-400 border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800">
                Lihat semua notifikasi
            </a>
        </div>
    </flux:menu>

</x-flux::dropdown>
