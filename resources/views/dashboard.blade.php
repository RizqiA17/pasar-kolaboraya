<x-layouts.app :title="__('Dashboard')">
    <div class="">

        <!-- Main Dashboard Grid -->
        <div class="px-4 pb-6">
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

                                {{-- @if (auth()->user() && auth()->user()->isApprovedEcosystemBuilder())
                                    <div class="flex-shrink-0">
                                        <flux:button :href="route('ecosystem.create')"
                                            size="sm" wire:navigate>
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Buat Ekosistem
                                        </flux:button>
                                    </div>
                                @endif --}}

                                <!-- Floating SVG Backgrounds -->
                                <div class="absolute inset-0 pointer-events-none">
                                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/1.webp') }}" alt=""
                                        class="absolute top-8 left-4 w-16 h-16 opacity-20 animate-float-slow">
                                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/15.webp') }}" alt=""
                                        class="absolute top-12 right-8 w-12 h-12 opacity-15 animate-float">
                                </div>
                            </div>
                        </div>


                        <!-- Connections Card -->
                        <div
                            class="col-span-1 group relative overflow-hidden rounded-xl p-5 text-gray-900 dark:text-slate-100 shadow-lg hover:shadow-xl transition-all duration-500 hover:scale-105 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-gray-200 dark:border-slate-700">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-white/10 dark:from-slate-700/10 to-transparent">
                            </div>
                            <div class="absolute top-0 right-0 w-16 h-16 opacity-20">
                                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/7.webp') }}" alt=""
                                    class="w-full h-full object-contain">
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <div
                                        class="w-10 h-10 bg-blue-200/80 dark:bg-blue-400/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                        <flux:icon.link class="size-5 text-gray-900 dark:text-blue-400" />
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xl font-bold text-gray-900 dark:text-slate-100">
                                            <livewire:dashboard.stats type="connections" />
                                        </div>
                                        <div class="text-gray-900 dark:text-slate-300 text-xs">Total</div>
                                    </div>
                                </div>
                                <h3 class="text-sm font-bold mb-2 text-gray-900 dark:text-slate-100">Koneksi</h3>
                                <p class="text-gray-900 dark:text-slate-300 mb-3 text-xs">Jaringan profesional yang
                                    terhubung</p>
                                <flux:link href="{{ route('connections') . '?tab=list' }}" wire:navigate
                                    class="inline-flex items-center text-xs font-medium transition-colors">
                                    Lihat Semua
                                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </flux:link>
                            </div>
                        </div>

                        @if(auth()->user()->canAccessEcosystem())
                        <!-- Ecosystems Card -->
                        <div
                            class="col-span-1 group relative overflow-hidden rounded-xl p-5 text-gray-900 dark:text-slate-100 shadow-lg hover:shadow-xl transition-all duration-500 hover:scale-105 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-gray-200 dark:border-slate-700">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-white/10 dark:from-slate-700/10 to-transparent">
                            </div>
                            <div class="absolute top-0 left-0 w-16 h-16 opacity-20">
                                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/2.webp') }}" alt=""
                                    class="w-full h-full object-contain">
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <div
                                        class="w-10 h-10 bg-purple-200/80 dark:bg-purple-400/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                        <flux:icon.users class="size-5 text-gray-900 dark:text-purple-400" />
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xl font-bold text-gray-900 dark:text-slate-100">
                                            <livewire:dashboard.stats type="ecosystems" />
                                        </div>
                                        <div class="text-gray-900 dark:text-slate-300 text-xs">Total</div>
                                    </div>
                                </div>
                                <h3 class="text-sm font-bold mb-2 text-gray-900 dark:text-slate-100">Ekosistem</h3>
                                <p class="text-gray-900 dark:text-slate-300 mb-3 text-xs">Ekosistem yang diikuti
                                </p>
                                <flux:link wire:navigate href="{{ route('ecosystem.browse') }}"
                                    class="inline-flex items-center text-xs font-medium transition-colors">
                                    Lihat Semua
                                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </flux:link>
                            </div>
                        </div>
                        @endif

                        @if(auth()->user()->canAccessEcosystem())
                        <!-- Collective Actions Card -->
                        <div
                            class="col-span-1 group relative overflow-hidden rounded-xl p-5 text-gray-900 dark:text-slate-100 shadow-lg hover:shadow-xl transition-all duration-500 hover:scale-105 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-gray-200 dark:border-slate-700">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-white/10 dark:from-slate-700/10 to-transparent">
                            </div>
                            <div class="absolute bottom-0 right-0 w-16 h-16 opacity-20">
                                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/11.webp') }}" alt=""
                                    class="w-full h-full object-contain">
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <div
                                        class="w-10 h-10 bg-emerald-200/80 dark:bg-emerald-400/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                        <flux:icon.user-group class="size-5 text-gray-900 dark:text-emerald-400" />
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xl font-bold text-gray-900 dark:text-slate-100">
                                            <livewire:dashboard.stats type="collective_actions" />
                                        </div>
                                        <div class="text-gray-900 dark:text-slate-300 text-xs">Total</div>
                                    </div>
                                </div>
                                <h3 class="text-sm font-bold mb-2 text-gray-900 dark:text-slate-100">Aksi Kolektif</h3>
                                <p class="text-gray-900 dark:text-slate-300 mb-3 text-xs">Aksi kolektif yang diikuti
                                </p>
                                <flux:link wire:navigate href="{{ route('collective-action.browse') }}"
                                    class="inline-flex items-center text-xs font-medium transition-colors">
                                    Lihat Semua
                                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </flux:link>
                            </div>
                        </div>
                        @endif

                        <div
                            class="col-span-1 lg:hidden w-full h-full relative shadow-lg border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden bg-gradient-to-br from-white via-blue-50 to-purple-50 dark:from-zinc-900 dark:via-blue-950/30 dark:to-purple-900/30">
                            <div class="absolute inset-0 pointer-events-none">
                                <div class="absolute top-0 right-0 w-20 h-20 opacity-20 rotate-12">
                                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/7.webp') }}" alt=""
                                        class="w-full h-full object-contain">
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row items-center h-full relative z-10">
                                <div class="flex-1 flex flex-col justify-center items-start p-8">
                                    <div class="flex items-center mb-3">
                                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                                            Kolaboraya <span
                                                class="text-transparent bg-clip-text bg-gradient-to-r from-primary-blue via-accent-red to-yellow-400">AI</span>
                                        </h3>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300 text-base mb-4">Fitur AI-powered untuk
                                        kolaborasi cerdas, akan hadir untuk Anda!</p>
                                    <span
                                        class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full shadow-sm animate-pulse">Akan
                                        datang...</span>
                                </div>
                                {{-- <div class="flex-1 flex items-center justify-center p-6">
                                    <img src="{{ Storage::url('web/ASET VISUAL/WEBP/7.webp') }}" alt="Kolaboraya AI"
                                        class="w-40 h-40 md:w-56 md:h-56 object-contain drop-shadow-lg transition-transform duration-500 group-hover:scale-110">
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-span-1 w-full h-full hidden lg:block relative shadow-lg border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden bg-gradient-to-br from-white via-blue-50 to-purple-50 dark:from-zinc-900 dark:via-blue-950/30 dark:to-purple-900/30">
                        <div class="absolute inset-0 pointer-events-none">
                            <div class="absolute top-0 right-0 w-20 h-20 opacity-20 rotate-12">
                                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/7.webp') }}" alt=""
                                    class="w-full h-full object-contain">
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row items-center h-full relative z-10">
                            <div class="flex-1 flex flex-col justify-center items-start p-8">
                                <div class="flex items-center mb-3">
                                    <h3 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                                        Kolaboraya <span
                                            class="text-transparent bg-clip-text bg-gradient-to-r from-primary-blue via-accent-red to-yellow-400">AI</span>
                                    </h3>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 text-base mb-4">Fitur AI-powered untuk
                                    kolaborasi cerdas, akan hadir untuk Anda!</p>
                                <span
                                    class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full shadow-sm animate-pulse">Akan
                                    datang...</span>
                            </div>
                            <div class="flex-1 flex items-center justify-center p-6">
                                <img src="{{ Storage::url('web/ASET VISUAL/SVG/7.svg') }}" alt="Kolaboraya AI"
                                    class="w-40 h-40 md:w-56 md:h-56 object-contain animate-pulse drop-shadow-lg transition-transform duration-500 group-hover:scale-110">
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
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-slate-100 mb-2">Aktivitas
                                            Terbaru</h3>
                                        <p class="text-gray-600 dark:text-slate-400 text-sm">Lihat apa yang terjadi di
                                            komunitas Anda</p>
                                    </div>
                                    <div
                                        class="w-12 h-12 bg-primary-blue rounded-lg flex items-center justify-center shadow-lg">
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
                        <!-- QR Code Card -->
                        <div class="group relative overflow-hidden rounded-xl bg-white dark:bg-slate-800 shadow-lg border border-gray-100 dark:border-slate-700">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-purple-50/50 dark:from-blue-900/10 dark:to-purple-900/10"></div>
                            <div class="absolute top-0 right-0 w-16 h-16 opacity-10">
                                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/7.webp') }}" alt="" class="w-full h-full object-contain">
                            </div>
                            <div class="relative z-10 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-slate-100 mb-2">QR Code Saya</h3>
                                        <p class="text-gray-600 dark:text-slate-400 text-sm">Akses ke Pasar Kolaboraya</p>
                                    </div>
                                    <div class="w-12 h-12 bg-secondary-green rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-slate-400 text-sm mb-4">Tunjukkan QR code ini kepada admin untuk masuk ke Pasar Kolaboraya</p>
                                <flux:link wire:navigate href="{{ route('qr.show') }}" class="inline-flex items-center text-sm font-medium transition-colors">
                                    Lihat QR Code
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </flux:link>
                            </div>
                        </div>
                        
                        <!-- Active Session Info - Show current session status -->
                        <livewire:dashboard.active-session-info />
                        <!-- Survey Card - Show active survey -->
                        <livewire:dashboard.survey-card />
                        <!-- Connection Quality - Only show if connections exist -->
                        <livewire:dashboard.connection-quality />
                        <!-- Profile Summary - Only show if profile exists and has data -->
                        <livewire:dashboard.profile-summary />
                    </div>
                </div>

                <!-- Quick Actions Section - Consistent 3-column grid -->
                {{-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div
                        class="group bg-white dark:bg-zinc-800 rounded-xl p-4 shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105 border border-gray-100 dark:border-gray-700">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center mb-3">
                            <flux:icon.bell class="size-4 text-white" />
                        </div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Notifikasi</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-xs">Lihat update terbaru</p>
                    </div>

                    <div
                        class="group bg-white dark:bg-zinc-800 rounded-xl p-4 shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105 border border-gray-100 dark:border-gray-700">
                        <div
                            class="w-8 h-8 bg-secondary-green rounded-lg flex items-center justify-center mb-3">
                            <flux:icon.chat-bubble-left-right class="size-4 text-white" />
                        </div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Pesan</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-xs">Chat dengan koneksi</p>
                    </div>

                    <div
                        class="group bg-white dark:bg-zinc-800 rounded-xl p-4 shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105 border border-gray-100 dark:border-gray-700">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center mb-3">
                            <flux:icon.cog class="size-4 text-white" />
                        </div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Pengaturan</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-xs">Atur preferensi Anda</p>
                    </div>
                </div> --}}
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
