<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
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
