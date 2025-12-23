<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    @if ($title)
        <title>{{ $title }} - {{ config('app.name') }}</title>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
    @livewireScripts
</head>

<body class="min-h-screen bg-primary-light-blue block! dark:bg-gray-950/80">
    {{-- Decorative SVG Elements --}}
    <x-decorative-svgs-subtle />

    <!-- Navbar Desktop dan Mobile -->
    <x-navbar />

    {{ $slot }}

    @stack('footer')

    @fluxScripts

    {{-- Chart.js for dashboard visualizations --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Pusher for real-time notifications --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    {{-- Notification System JavaScript --}}
    <script>
        function notificationDropdown() {
            return {
                notifications: [],
                unreadCount: 0,
                loading: true,

                init() {
                    this.loadNotifications();
                    this.setupPusher();

                    // Refresh notifications every 5 seconds for real-time updates
                    setInterval(() => {
                        this.loadNotifications();
                    }, 60000);

                    // Also refresh when page becomes visible (user switches tabs)
                    document.addEventListener('visibilitychange', () => {
                        if (!document.hidden) {
                            this.refreshNotifications();
                        }
                    });
                },

                async loadNotifications() {
                    try {
                        const res = await fetch('/api/notifications/recent', {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                        const response = await res.json();
                        this.notifications = response.data || [];
                        console.log(this.notifications)
                        this.updateUnreadCount();
                        this.loading = false;
                    } catch (error) {
                        console.error('Error loading notifications:', error);
                        this.loading = false;
                    }
                },

                // Method to manually refresh notifications
                refreshNotifications() {
                    this.loading = true;
                    this.loadNotifications();
                },

                async loadUnreadCount() {
                    try {
                        const response = await fetch('/api/notifications/unread-count');
                        const data = await response.json();
                        this.unreadCount = data.unread_count || 0;
                    } catch (error) {
                        console.error('Error loading unread count:', error);
                    }
                },

                updateUnreadCount() {
                    this.unreadCount = this.notifications.filter(n => !n.is_read).length;
                    console.log(this.unreadCount)
                },

                async markAsRead(notificationId) {
                    try {
                        const response = await fetch(`/api/notifications/${notificationId}/mark-read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json',
                            },
                        });

                        if (response.ok) {
                            // Update local state
                            const notification = this.notifications.find(n => n.id === notificationId);
                            if (notification) {
                                notification.is_read = true;
                                this.updateUnreadCount();
                            }
                        }
                    } catch (error) {
                        console.error('Error marking notification as read:', error);
                    }
                },

                viewNotification(target) {
                    window.location.href = target;
                },

                setupPusher() {
                    // Try to setup Pusher for real-time updates
                    try {
                        if (typeof Pusher !== 'undefined' && '{{ config('broadcasting.default') }}' === 'pusher') {
                            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                                encrypted: true
                            });

                            const channel = pusher.subscribe('notifications.{{ auth()->id() }}');

                            channel.bind('notification.created', (data) => {
                                this.notifications.unshift(data.notification);
                                this.updateUnreadCount();

                                // Show browser notification if permission is granted
                                if (Notification.permission === 'granted') {
                                    new Notification(data.notification.title || 'Notifikasi Baru', {
                                        body: data.notification.message,
                                        icon: '/favicon.ico'
                                    });
                                }
                            });

                            channel.bind('notification.updated', (data) => {
                                const index = this.notifications.findIndex(n => n.id === data.notification.id);
                                if (index !== -1) {
                                    this.notifications[index] = data.notification;
                                    this.updateUnreadCount();
                                }
                            });

                            console.log('Pusher connected for real-time notifications');
                        } else {
                            console.log('Pusher not available, using polling fallback');
                        }
                    } catch (error) {
                        console.log('Pusher setup failed, using polling fallback:', error);
                    }
                }
            }
        }

        // Request notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    </script>

    <script>
        // async function refreshCsrfToken() {
        //     const csrfToken = document
        //         .querySelector('meta[name="csrf-token"]')
        //         .getAttribute('content');

        //     try {
        //         const response = await fetch('/csrf-token-refresh', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': csrfToken
        //             },
        //             body: JSON.stringify({
        //                 action: 'refresh'
        //             })
        //         });

        //         if (!response.ok) {
        //             throw new Error(`Gagal refresh CSRF: ${response.statusText}`);
        //         }

        //         const result = await response.json();

        //         // update <meta> csrf token
        //         document
        //             .querySelector('meta[name="csrf-token"]')
        //             .setAttribute('content', result.token);

        //         // update Livewire internal token
        //         if (window.Livewire) {
        //             window.Livewire.csrfToken = result.token;
        //         }

        //         // update default AJAX headers
        //         if (window.axios) {
        //             window.axios.defaults.headers.common['X-CSRF-TOKEN'] = result.token;
        //         }
        //         if (window.jQuery) {
        //             window.jQuery.ajaxSetup({
        //                 headers: {
        //                     'X-CSRF-TOKEN': result.token
        //                 }
        //             });
        //         }

        //         // === Hitung jadwal refresh berdasarkan session_expired_at ===
        //         const clientTimeMs = Date.now();

        //         if (result.session_expired_at) {
        //             const expiredAtMs = result.session_expired_at * 1000;
        //             let delayMs = expiredAtMs - clientTimeMs - (60 * 1000); // 1 menit sebelum expired

        //             if (delayMs < 5000) delayMs = 5000; // minimal 5 detik supaya aman

        //             console.log({
        //                 serverTime: new Date(result.timestamp * 1000).toISOString(),
        //                 clientTime: new Date(clientTimeMs).toISOString(),
        //                 nextRefreshAt: new Date(clientTimeMs + delayMs).toISOString(),
        //                 Token: result.token,
        //                 previousToken: result.previous_token,
        //                 sessionExpiredAt: new Date(expiredAtMs).toISOString(),
        //                 delaySeconds: Math.round(delayMs / 1000)
        //             });

        //             setTimeout(refreshCsrfToken, delayMs);
        //         } else {
        //             console.warn("⚠️ session_expired_at tidak ada di response, fallback 10 menit");
        //             setTimeout(refreshCsrfToken, 10 * 60 * 1000);
        //         }

        //     } catch (error) {
        //         console.error("Kesalahan saat refresh CSRF:", error.message);
        //         setTimeout(refreshCsrfToken, 60000); // retry setelah 1 menit
        //     }
        // }

        // mulai pertama kali
        // refreshCsrfToken();

        document.addEventListener('livewire:init', () => {
            Livewire.hook('request', ({
                fail
            }) => {
                fail(({
                    status,
                    preventDefault
                }) => {
                    if (status === 419) {
                        alert('Maaf, coba lagi')

                        preventDefault()
                    }
                })
            })
        })
    </script>

    {{-- Stack for additional styles and scripts --}}
    @stack('styles')
    @stack('scripts')
</body>

</html>
