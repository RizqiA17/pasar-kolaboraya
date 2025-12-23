<x-layouts.guest>
    <!-- Browser not supported warning (di atas semua konten) -->
    {{-- <div id="browser-warning"
        style="display:none;position:fixed;top:0;left:0;width:100%;z-index:99999;background:#fff0f3;color:#b91c1c;border-bottom:1px solid #fca5a5;text-align:center;padding:10px;font-size:15px;font-weight:500;box-shadow:0 2px 6px #0001;">
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
            // Show warning banner if old/unsupported
            if (isOldVersion()) {
                var bw = document.getElementById('browser-warning');
                bw.innerHTML = getUnsupportedMessage();
                bw.style.display = 'block';
                // Hide Safari warning if both triggered
                var sw = document.getElementById('safari-warning');
                if (sw) sw.style.display = 'none';
            } else {
                // Safari (optimalisasi saja)
                var ua = navigator.userAgent;
                var isSafari = /^((?!chrome|android).)*safari/i.test(ua) && !/CriOS|FxiOS|OPiOS|EdgiOS/i.test(ua);
                if (isSafari && document.getElementById('safari-warning')) {
                    document.getElementById('safari-warning').style.display = 'block';
                }
            }
        })();
    </script> --}}
    <!-- Hero Section -->
    <div class="relative min-h-screen bg-primary-light-blue dark:bg-slate-900 overflow-hidden">
        <!-- Navigation -->
        <nav class="fixed backdrop-blur-xs top-0 w-full z-50 p-4 sm:p-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="text-navy dark:text-slate-200 text-2xl font-bold">
                    <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}" alt="logo"
                        class="h-8 sm:h-10">
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <x-dark-mode-toggle />
                    @if (Route::has('login'))
                        <div class="space-x-4 flex">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="px-4 py-2 bg-navy dark:bg-secondary-green text-white rounded-full hover:bg-sky-700 dark:hover:bg-teal-600 transition">Beranda</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="px-4 py-2 text-navy dark:text-slate-200 hover:text-sky-700 dark:hover:text-secondary-green transition">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="px-4 py-2 bg-navy dark:bg-secondary-green text-white rounded-full hover:bg-sky-700 dark:hover:bg-teal-600 transition">Daftar</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button"
                        class="p-2 rounded-lg bg-white/10 dark:bg-slate-800/50 backdrop-blur-sm border border-white/20 dark:border-slate-700 hover:bg-white/20 dark:hover:bg-slate-700/50 transition">
                        <svg class="w-6 h-6 text-navy dark:text-slate-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Mobile Dropdown Menu -->
            <div id="mobile-menu"
                class="md:hidden absolute top-full left-0 right-0 mt-2 mx-4 bg-white/95 dark:bg-slate-800/95 backdrop-blur-sm rounded-xl shadow-xl border border-gray-200 dark:border-slate-700 opacity-0 invisible transform translate-y-2 transition-all duration-200">
                <div class="p-4 space-y-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="flex items-center w-full px-4 py-3 bg-navy dark:bg-secondary-green text-white rounded-lg hover:bg-sky-700 dark:hover:bg-teal-600 transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                Beranda
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="flex items-center w-full px-4 py-3 text-navy dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="flex items-center w-full px-4 py-3 bg-navy dark:bg-secondary-green text-white rounded-lg hover:bg-sky-700 dark:hover:bg-teal-600 transition">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                    <!-- Dark Mode Toggle for Mobile -->
                    <div class="pt-3 border-t border-gray-200 dark:border-slate-700">
                        <button id="mobile-dark-mode-toggle"
                            class="flex items-center w-full px-4 py-3 text-navy dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition">
                            <svg id="mobile-sun-icon" class="w-5 h-5 mr-3 hidden dark:block" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            <svg id="mobile-moon-icon" class="w-5 h-5 mr-3 block dark:hidden" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                </path>
                            </svg>
                            <span id="mobile-theme-text">Ganti Tema</span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Main Content -->
        <div class="relative pt-32 pb-16 sm:pt-48">
            <!-- Enhanced Decorative SVG Elements for Welcome Page -->
            <div>
                <div
                    class="absolute top-0 max-md:-translate-x-1/2 max-md:translate-y-1/2 left-0 w-80 h-80 opacity-70 animate-float">
                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/1-1.webp') }}" alt=""
                        class="w-full h-full object-contain">
                </div>
                <div
                    class="absolute top-10 max-md:translate-x-1/2 max-md:translate-y-1/2 right-0 w-96 h-96 opacity-60 animate-float-delay-2">
                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/7-1.webp') }}" alt=""
                        class="w-full h-full object-contain">
                </div>
                <div
                    class="absolute top-0  right-0 translate-x-1/4 -translate-y-1/4 w-72 h-72 opacity-50 animate-float-delay-3">
                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/8-1.webp') }}" alt=""
                        class="w-full h-full object-contain">
                </div>
                <div
                    class="absolute -bottom-50 max-md:translate-x-1/2 max-md:translate-y-1/2 right-5 w-80 h-80 opacity-60 animate-float">
                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/5-1.webp') }}" alt=""
                        class="w-full h-full object-contain">
                </div>
                <div
                    class="absolute -bottom-50 max-md:translate-x-1/2 max-md:translate-y-1/2 left-5 w-64 h-64 opacity-50 animate-float-delay-1">
                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/6-1.webp') }}" alt=""
                        class="w-full h-full object-contain">
                </div>
                <div
                    class="absolute bottom-0 left-0 -translate-x-1/4 translate-y-1/4 w-72 h-72 opacity-60 animate-float-delay-2">
                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/3-1.webp') }}" alt=""
                        class="w-full h-full object-contain">
                </div>
                <!-- Floating Elements with Animation -->
                <div
                    class="absolute top-0 max-md:-translate-x-1/2 max-md:translate-y-1/2 left-7 w-32 h-32 opacity-50 animate-float">
                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/15-1.webp') }}" alt=""
                        class="w-full h-full object-contain">
                </div>
                <div class="max-w-7xl relative z-1 mx-auto px-6 lg:px-8">
                    <div class="text-center">
                        <h1 class="text-4xl sm:text-5xl font-bold text-navy dark:text-slate-100 mb-8 leading-tight">
                            Bangun Koneksi, Kolaborasi, <br>dan Aksi Bersama untuk Perubahan Sosial
                        </h1>
                        <p class="text-xl sm:text-2xl text-gray-600 dark:text-slate-300 mb-12 max-w-3xl mx-auto">
                            Pasar Kolaboraya adalah ruang <span
                                class="text-secondary-green dark:text-sky-400 font-semibold">temu
                                lintas-ekosistem</span> bagi Kreator Perubahan Sosial yang siap <span
                                class="text-coral dark:text-coral-400 font-semibold">memperluas dampak</span>.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="inline-flex items-center px-8 py-4 bg-navy dark:bg-secondary-green text-white rounded-full text-lg font-semibold hover:bg-sky-700 dark:hover:bg-teal-600 transition">
                                    Beranda
                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center px-8 py-4 bg-navy dark:bg-secondary-green text-white rounded-full text-lg font-semibold hover:bg-sky-700 dark:hover:bg-teal-600 transition">
                                    Bergabung Sekarang
                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            @endauth
                            {{-- <a href="{{ route('public.ecosystem.mapping') }}"
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-secondary-green to-primary-blue text-white rounded-full text-lg font-semibold hover:from-teal-600 hover:to-sky-700 transition">
                                <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                    </path>
                                </svg>
                                Lihat Peta Ekosistem
                            </a> --}}
                        </div>
                    </div>
                    <!-- Features -->
                    <div class="mt-32 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div
                            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700">
                            <div
                                class="bg-sky/10 dark:bg-sky-400/20 w-12 h-12 flex items-center justify-center rounded-xl mb-6">
                                <svg class="w-6 h-6 text-sky dark:text-sky-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-navy dark:text-slate-100 mb-3">Koneksi Luas</h3>
                            <p class="text-gray-600 dark:text-slate-300">Terhubung dengan kreator perubahan sosial
                                dari
                                berbagai latar
                                belakang dan fokus.</p>
                        </div>
                        <div
                            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700">
                            <div
                                class="bg-coral/10 dark:bg-coral-400/20 w-12 h-12 flex items-center justify-center rounded-xl mb-6">
                                <svg class="w-6 h-6 text-coral dark:text-coral-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-navy dark:text-slate-100 mb-3">Kolaborasi Efektif
                            </h3>
                            <p class="text-gray-600 dark:text-slate-300">Temukan partner yang sesuai dan kolaborasi
                                untuk menciptakan dampak
                                yang lebih besar.</p>
                        </div>
                        <div
                            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700">
                            <div
                                class="bg-purple/10 dark:bg-purple-400/20 w-12 h-12 flex items-center justify-center rounded-xl mb-6">
                                <svg class="w-6 h-6 text-purple dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-navy dark:text-slate-100 mb-3">Dampak Terukur</h3>
                            <p class="text-gray-600 dark:text-slate-300">Pantau dan ukur dampak dari setiap kolaborasi
                                yang Anda lakukan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="mt-32 pb-8 z-1 relative">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div
                    class="border-t border-gray-200 dark:border-slate-700 pt-8 text-center text-gray-500 dark:text-slate-400">
                    <p>&copy; 2025 Pasar Kolaboraya. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
    <style>
        /* .bg-cream { background-color: #FFFBF5; }
       .bg-navy { background-color: #1E365C; }
       .text-navy { color: #1E365C; }
       .bg-coral { background-color: #FF6B6B; }
       .text-coral { color: #FF6B6B; }
       .bg-sky { background-color: #4ECDC4; }
       .text-sky { color: #4ECDC4; }
       .bg-purple { background-color: #9C6BFF; }
       .text-purple { color: #9C6BFF; } */
        /* SVG Animation Styles */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-rotate {
            animation: rotate 20s linear infinite;
        }

        .animate-float-delay-1 {
            animation: float 6s ease-in-out infinite;
            animation-delay: 1s;
        }

        .animate-float-delay-2 {
            animation: float 6s ease-in-out infinite;
            animation-delay: 2s;
        }

        .animate-float-delay-3 {
            animation: float 6s ease-in-out infinite;
            animation-delay: 3s;
        }

        /* Mobile Menu Styles */
        .mobile-menu-open {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
        }
    </style>
    <script>
        function initializeMobileMenu() {
            console.log('Initializing mobile menu...');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileDarkModeToggle = document.getElementById('mobile-dark-mode-toggle');
            const mobileThemeText = document.getElementById('mobile-theme-text');
            console.log('Elements found:', {
                mobileMenuButton: !!mobileMenuButton,
                mobileMenu: !!mobileMenu,
                mobileDarkModeToggle: !!mobileDarkModeToggle,
                mobileThemeText: !!mobileThemeText
            });
            // Toggle mobile menu
            if (mobileMenuButton && mobileMenu) {
                // Remove existing event listeners
                const newButton = mobileMenuButton.cloneNode(true);
                mobileMenuButton.parentNode.replaceChild(newButton, mobileMenuButton);
                // Add new event listener
                newButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Mobile menu button clicked');
                    mobileMenu.classList.toggle('mobile-menu-open');
                });
                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!newButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.remove('mobile-menu-open');
                    }
                });
            }
            // Mobile dark mode toggle
            if (mobileDarkModeToggle && mobileThemeText) {
                // Remove existing event listeners
                const newDarkModeToggle = mobileDarkModeToggle.cloneNode(true);
                mobileDarkModeToggle.parentNode.replaceChild(newDarkModeToggle, mobileDarkModeToggle);
                // Function to update mobile theme text
                function updateMobileThemeText() {
                    if (document.documentElement.classList.contains('dark')) {
                        mobileThemeText.textContent = 'Mode Terang';
                    } else {
                        mobileThemeText.textContent = 'Mode Gelap';
                    }
                }
                newDarkModeToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Mobile dark mode toggle clicked');
                    // Use same logic as desktop component
                    const html = document.documentElement;
                    const isDark = html.classList.contains('dark');
                    html.classList.toggle('dark', !isDark);
                    localStorage.setItem('theme', isDark ? 'light' : 'dark');
                    localStorage.setItem('flux.appearance', isDark ? 'light' : 'dark');
                    // Update mobile theme text
                    updateMobileThemeText();
                    // Dispatch custom event for theme change (same as desktop)
                    document.dispatchEvent(new CustomEvent('themeChanged', {
                        detail: {
                            theme: isDark ? 'light' : 'dark'
                        }
                    }));
                });
                // Initialize theme text
                updateMobileThemeText();
                // Listen for theme changes from desktop toggle
                document.addEventListener('themeChanged', function(event) {
                    updateMobileThemeText();
                });
            }
        }
        // Initialize immediately
        initializeMobileMenu();
        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded - initializing mobile menu');
            initializeMobileMenu();
        });
        // Re-initialize after Livewire navigation
        document.addEventListener('livewire:navigated', function() {
            console.log('Livewire navigated - reinitializing mobile menu');
            setTimeout(initializeMobileMenu, 100);
        });
        // Also listen for other Livewire events
        document.addEventListener('livewire:load', function() {
            console.log('Livewire load - initializing mobile menu');
            initializeMobileMenu();
        });
        document.addEventListener('livewire:update', function() {
            console.log('Livewire update - reinitializing mobile menu');
            setTimeout(initializeMobileMenu, 200);
        });
        document.addEventListener('livewire:updated', function() {
            console.log('Livewire updated - reinitializing mobile menu');
            setTimeout(initializeMobileMenu, 300);
        });
        // Force initialization after a delay to ensure everything is loaded
        setTimeout(function() {
            console.log('Force initialization after delay');
            initializeMobileMenu();
        }, 1000);
    </script>
</x-layouts.guest>
