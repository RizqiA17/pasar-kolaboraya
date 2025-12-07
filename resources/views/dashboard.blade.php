<x-layouts.app :title="__('Dashboard')">
    <!-- Browser not supported warning (di atas semua konten) -->
    {{-- <div id="browser-warning"
        style="position:fixed;top:0;left:0;width:100%;z-index:99999;background:#fff0f3;color:#b91c1c;border-bottom:1px solid #fca5a5;text-align:center;padding:10px;font-size:15px;font-weight:500;box-shadow:0 2px 6px #0001;">
    </div>
    <div id="safari-warning"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; z-index: 99998; background: #fffbe6; color: #856404; border-bottom: 1px solid #ffeeba; text-align: center; padding: 10px; font-size: 15px; font-weight: 500; box-shadow: 0 2px 6px #0001;">
        Kami mendeteksi Anda menggunakan <b>Safari</b>. Untuk pengalaman optimal, silakan gunakan <b>Chrome</b> dan
        perangkat terbaru.
    </div>
    <script>
        (function() {
            function getBrowserMeta() {
                var ua = navigator.userAgent;
                var tem, M = ua.match(
                    /(Opera|OPR|Edg|Edge|Chrome|CriOS|Firefox|FxiOS|Safari|SamsungBrowser|MSIE|Trident)\/?\s*(\d+\.?\d*)/i
                ) || [];
                var browser = (M[1] || "");
                var version = (M[2] || "0");

                // Handle edge cases for IE/Trident
                if (/trident/i.test(browser)) {
                    var tem2 = ua.match(/rv:(\d+\.?\d*)/i);
                    return {
                        name: 'IE',
                        version: tem2 ? tem2[1] : version
                    };
                }
                if (browser === 'Chrome') {
                    // detect Edge
                    if (/Edg/i.test(ua)) {
                        return {
                            name: 'Edge',
                            version: (ua.match(/Edg\/(\d+\.?\d*)/i) || [])[1] || "0"
                        };
                    }
                    // detect Opera
                    if (/OPR/i.test(ua)) {
                        return {
                            name: 'Opera',
                            version: (ua.match(/OPR\/(\d+\.?\d*)/i) || [])[1] || "0"
                        };
                    }
                    // detect Samsung
                    if (/SamsungBrowser/i.test(ua)) {
                        return {
                            name: 'Samsung Internet',
                            version: (ua.match(/SamsungBrowser\/(\d+\.?\d*)/i) || [])[1] || "0"
                        };
                    }
                }
                // Handle Safari on iOS
                if (/safari/i.test(browser) && /CriOS|FxiOS|OPiOS|EdgiOS/.test(ua)) {
                    if (/CriOS/.test(ua)) return {
                        name: 'Chrome',
                        version: (ua.match(/CriOS\/(\d+\.?\d*)/i) || [])[1] || '0'
                    };
                    if (/FxiOS/.test(ua)) return {
                        name: 'Firefox',
                        version: (ua.match(/FxiOS\/(\d+\.?\d*)/i) || [])[1] || '0'
                    };
                    if (/OPiOS/.test(ua)) return {
                        name: 'Opera',
                        version: (ua.match(/OPiOS\/(\d+\.?\d*)/i) || [])[1] || '0'
                    };
                    if (/EdgiOS/.test(ua)) return {
                        name: 'Edge',
                        version: (ua.match(/EdgiOS\/(\d+\.?\d*)/i) || [])[1] || '0'
                    };
                }
                if (/Safari/.test(browser) && !/Chrome|Chromium|OPR|Edg|SamsungBrowser|CriOS|FxiOS|OPiOS|EdgiOS/.test(
                        ua)) {
                    // Standalone Safari or iOS Safari
                    // add version parse for iOS
                    var safariVer = (ua.match(/Version\/(\d+\.?\d*)/) || [])[1] || version;
                    return {
                        name: 'Safari',
                        version: safariVer
                    };
                }
                return {
                    name: browser,
                    version
                };
            }

            function isOldVersion() {
                var meta = getBrowserMeta();
                // to number
                function verN(str) {
                    return Number(str.split('.')[0] || 0) + (Number(str.split('.')[1] || 0) / 100);
                }
                var v = verN(meta.version);
                // Chrome
                if (meta.name.indexOf('Chrome') !== -1 && v <= 110) return true;
                if (meta.name === 'Edge' && v <= 110) return true;
                if (meta.name === 'Opera' && v <= 96) return true;
                if (meta.name === 'Firefox' && v <= 127) return true;
                if (meta.name === 'Safari' && v <= 16.3) return true;
                if (meta.name === 'Samsung Internet') return true;
                if (meta.name === 'IE' || meta.name === 'MSIE' || /trident/i.test(navigator.userAgent)) return true;
                return false;
            }

            function getUnsupportedMessage() {
                var meta = getBrowserMeta();
                return 'Browser yang Anda gunakan (' + meta.name + ' versi ' + meta.version +
                    ') tidak didukung. Silakan gunakan browser versi terbaru (Chrome 111+, Safari 16.4+, Firefox 128+, Edge 111+, Opera 97+) untuk pengalaman terbaik.';
            }
            if (localStorage.get("browser-warning-off") !== "true") {
                // Show warning banner if old/unsupported
                if (isOldVersion()) {
                    var bw = document.getElementById('browser-warning');
                    bw.innerHTML = getUnsupportedMessage();
                    bw.style.display = 'block';
                    // Hide Safari warning if both triggered
                    var sw = document.getElementById('safari-warning');
                    if (sw) sw.style.display = 'none';
                    localStorage.set("browser-warning-off", "true");
                } else {
                    // Safari (optimalisasi saja)
                    var ua = navigator.userAgent;
                    var isSafari = /^((?!chrome|android).)*safari/i.test(ua) && !/CriOS|FxiOS|OPiOS|EdgiOS/i.test(ua);
                    if (isSafari && document.getElementById('safari-warning')) {
                        document.getElementById('safari-warning').style.display = 'block';
                    }
                    localStorage.set("browser-warning-off", "true");
                }
            }
        })();
    </script> --}}
    <div class="">

        <!-- Main Dashboard Grid -->
        <div class="pb-6">
            <div class="mx-auto max-w-7xl space-y-6">
                <!-- Stats Cards Row - Consistent 3-column grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="col-span-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Hero Section with Floating SVGs -->
                        <div class="relative overflow-hidden px-4 col-span-1 sm:col-span-2 lg:col-span-3">
                            <div class="mx-auto max-w-7xl flex justify-between">
                                <div class="text-left mb-6">
                                    <h1
                                        class="text-xl md:text-3xl font-bold bg-primary-blue dark:bg-secondary-green bg-clip-text text-transparent mb-2">
                                        Selamat Datang!
                                    </h1>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 max-w-2xl">
                                        Mari jelajahi dunia kolaborasi dan koneksi yang menakjubkan
                                    </p>
                                </div>

                                <!-- Floating SVG Backgrounds -->
                                <div class="absolute inset-0 pointer-events-none">
                                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/1.webp') }}" alt=""
                                        class="absolute top-8 left-4 w-16 h-16 opacity-20 animate-float-slow">
                                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/15.webp') }}" alt=""
                                        class="absolute top-12 right-8 w-12 h-12 opacity-15 animate-float">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-1 lg:hidden sm:col-span-2 lg:col-span-3">
                            <livewire:dashboard.active-session-info />
                        </div>

                        <!-- Connections Card -->
                        <div
                            class="col-span-1 group relative overflow-hidden rounded-xl p-5 text-gray-900 dark:text-slate-200 shadow-lg hover:shadow-xl transition-all duration-500 hover:scale-105 bg-white dark:bg-slate-900 backdrop-blur-sm dark:border-t! border-gray-200 dark:border-slate-700 flex flex-col">
                            <div class="absolute top-0 right-0 w-16 h-16 opacity-20">
                                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/7.webp') }}" alt=""
                                    class="w-full h-full object-contain">
                            </div>
                            <div class="relative z-10 flex flex-col flex-grow">
                                <div class="flex items-center justify-between mb-3">
                                    <div
                                        class="w-10 h-10 bg-blue-200/80 dark:bg-blue-400/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                        <flux:icon.link class="size-5 text-gray-900 dark:text-blue-400" />
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xl font-bold text-gray-900 dark:text-slate-200">
                                            <livewire:dashboard.stats type="connections" />
                                        </div>
                                        <div class="text-gray-900 dark:text-slate-300 text-xs">Total</div>
                                    </div>
                                </div>
                                <h3 class="text-sm font-bold mb-1 text-gray-900 dark:text-slate-200">Koneksi</h3>
                                <p class="text-gray-900 dark:text-slate-300 mb-3 text-xs">Jaringan profesional yang
                                    terhubung</p>
                                <flux:link href="{{ route('connections') . '?tab=list' }}" wire:navigate
                                    class="inline-flex items-end pb-2 text-xs font-medium transition-colors flex-grow">
                                    Lihat Semua
                                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </flux:link>
                            </div>
                        </div>

                        @if (auth()->user()->canAccessEcosystem())
                            <!-- Ecosystems Card -->
                            <div
                                class="col-span-1 group relative overflow-hidden rounded-xl p-5 text-gray-900 dark:text-slate-200 shadow-lg hover:shadow-xl transition-all duration-500 hover:scale-105 bg-white dark:bg-slate-900 backdrop-blur-sm dark:border-t! border-gray-200 dark:border-slate-700 flex flex-col">
                                <div class="absolute top-0 left-0 w-16 h-16 opacity-20">
                                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/2.webp') }}" alt=""
                                        class="w-full h-full object-contain">
                                </div>
                                <div class="relative z-10 flex flex-col flex-grow">
                                    <div class="flex items-center justify-between mb-3">
                                        <div
                                            class="w-10 h-10 bg-purple-200/80 dark:bg-purple-400/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                            <flux:icon.users class="size-5 text-gray-900 dark:text-purple-400" />
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xl font-bold text-gray-900 dark:text-slate-200">
                                                <livewire:dashboard.stats type="ecosystems" />
                                            </div>
                                            <div class="text-gray-900 dark:text-slate-300 text-xs">Total</div>
                                        </div>
                                    </div>
                                    <h3 class="text-sm font-bold mb-1 text-gray-900 dark:text-slate-200">Kolaborasi</h3>
                                    <p class="text-gray-900 dark:text-slate-300 mb-3 text-xs">Ekosistem yang diikuti
                                    </p>
                                    <flux:link wire:navigate href="{{ route('ecosystem.browse') }}"
                                        class="inline-flex items-end pb-2 text-xs font-medium transition-colors flex-grow">
                                        Lihat Semua
                                        <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </flux:link>
                                </div>
                            </div>
                        @endif

                        @if (auth()->user()->canAccessEcosystem())
                            <!-- Collective Actions Card -->
                            <div
                                class="col-span-1 group relative overflow-hidden rounded-xl p-5 text-gray-900 dark:text-slate-200 shadow-lg hover:shadow-xl transition-all duration-500 hover:scale-105 bg-white dark:bg-slate-900 backdrop-blur-sm dark:border-t! border-gray-200 dark:border-slate-700 flex flex-col">
                                <div class="absolute bottom-0 right-0 w-16 h-16 opacity-20">
                                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/11.webp') }}" alt=""
                                        class="w-full h-full object-contain">
                                </div>
                                <div class="relative z-10 flex flex-col flex-grow">
                                    <div class="flex items-center justify-between mb-3">
                                        <div
                                            class="w-10 h-10 bg-emerald-200/80 dark:bg-emerald-400/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                            <flux:icon.user-group class="size-5 text-gray-900 dark:text-emerald-400" />
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xl font-bold text-gray-900 dark:text-slate-200">
                                                <livewire:dashboard.stats type="collective_actions" />
                                            </div>
                                            <div class="text-gray-900 dark:text-slate-300 text-xs">Total</div>
                                        </div>
                                    </div>
                                    <h3 class="text-sm font-bold mb-1 text-gray-900 dark:text-slate-200">Aksi Kolektif
                                    </h3>
                                    <p class="text-gray-900 dark:text-slate-300 mb-3 text-xs">Aksi kolektif yang diikuti
                                    </p>
                                    <flux:link wire:navigate href="{{ route('collective-action.browse') }}"
                                        class="inline-flex items-end pb-2 text-xs font-medium transition-colors flex-grow">
                                        Lihat Semua
                                        <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </flux:link>
                                </div>
                            </div>
                        @endif


                        <!-- QR Code Card -->
                        <div
                            class="col-span-1 lg:hidden group relative overflow-hidden rounded-xl bg-white dark:bg-slate-900 shadow-lg dark:border-t! border-gray-100 dark:border-slate-700">
                            <div class="absolute top-0 right-0 w-16 h-16 opacity-10">
                                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/7.webp') }}" alt=""
                                    class="w-full h-full object-contain">
                            </div>
                            <div class="relative z-10 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-slate-200">QR Code
                                            Saya</h3>
                                        <p class="text-gray-700 dark:text-slate-300 text-sm">Akses ke Pasar Kolaboraya
                                        </p>
                                    </div>
                                    <div
                                        class="w-12 h-12 bg-secondary-green rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-500 dark:text-slate-400 text-sm mb-4">Tunjukkan QR code ini kepada
                                    admin untuk masuk ke Pasar Kolaboraya</p>
                                <flux:link wire:navigate href="{{ route('qr.show') }}"
                                    class="inline-flex items-center text-sm font-medium transition-colors">
                                    Lihat QR Code
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </flux:link>
                            </div>
                        </div>
                    </div>
                    <!-- QR Code Card -->

                    <div class="col-span-1 flex-col gap-4 lg:flex mt-6 hidden">
                        <livewire:dashboard.active-session-info />

                        <div
                            class="col-span-1 mt-auto h-fit hidden lg:block group relative overflow-hidden rounded-xl bg-white dark:bg-slate-900 shadow-lg dark:border-t! border-gray-100 dark:border-slate-700">
                            <div class="absolute top-0 right-0 w-16 h-16 opacity-10">
                                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/7.webp') }}" alt=""
                                    class="w-full h-full object-contain">
                            </div>
                            <div class="relative z-10 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-slate-200">QR Code
                                            Saya
                                        </h3>
                                        <p class="text-gray-700 dark:text-slate-300 text-sm">Akses ke Pasar Kolaboraya
                                        </p>
                                    </div>
                                    <div
                                        class="w-12 h-12 bg-secondary-green rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-500 dark:text-slate-400 text-sm mb-4">Tunjukkan QR code ini kepada
                                    admin untuk masuk ke Pasar Kolaboraya</p>
                                <flux:link wire:navigate href="{{ route('qr.show') }}"
                                    class="inline-flex items-center text-sm font-medium transition-colors">
                                    Lihat QR Code
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </flux:link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid - Consistent 3-column layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Profile Progress - Takes 3 columns on large screens -->
                    <div class="lg:col-span-2 space-y-6 order-2 lg:order-1">
                        <livewire:dashboard.profile-progress />

                        <!-- Activity Section - Consistent spacing and layout -->
                        <div
                            class="relative overflow-hidden rounded-xl bg-white dark:bg-zinc-800 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-purple-50/50 dark:from-blue-900/10 dark:to-purple-900/10">
                            </div>
                            <div class="absolute top-0 left-0 w-20 h-20 opacity-10">
                                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/4.webp') }}" alt=""
                                    class="w-full h-full object-contain">
                            </div>

                            <div class="relative z-10 p-6">
                                <div class="flex items-center justify-between mb-4 gap-2">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-slate-200">Aktivitas
                                            Terbaru</h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">Lihat apa yang terjadi di
                                            komunitas Anda</p>
                                    </div>
                                    <div
                                        class="w-12 h-12 min-w-12 bg-primary-blue rounded-lg flex items-center justify-center shadow-lg">
                                        <flux:icon.clock class="size-6 text-white" />
                                    </div>
                                </div>

                                <div class="relative">
                                    <livewire:dashboard.activity-timeline />
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Sidebar - Single column, consistent spacing -->
                    <div class="space-y-6 order-1 lg:order-2">
                        <!-- Survey Card - Show active survey -->
                        <livewire:dashboard.survey-card />
                        <!-- Connection Quality - Only show if connections exist -->
                        <livewire:dashboard.connection-quality />
                        <!-- Profile Summary - Only show if profile exists and has data -->
                        <livewire:dashboard.profile-summary />
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-6px) rotate(1deg);
            }
        }

        @keyframes float-slow {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-4px) rotate(-0.5deg);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-slow {
            animation: float-slow 8s ease-in-out infinite;
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
    </style>
</x-layouts.app>
