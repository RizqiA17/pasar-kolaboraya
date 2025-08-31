<x-layouts.app :title="__('Dashboard')">
    <div
        class="">
        <!-- Hero Section with Floating SVGs -->
        <div class="relative overflow-hidden px-4 py-6">
            <div class="mx-auto max-w-7xl">
                <div class="text-center mb-6">
                    <h1
                        class="text-xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                        Selamat Datang! 🎉
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Mari jelajahi dunia kolaborasi dan koneksi yang menakjubkan
                    </p>
                </div>

                <!-- Floating SVG Backgrounds -->
                <div class="absolute inset-0 pointer-events-none">
                    <img src="{{ Storage::url('web/ASET VISUAL/SVG/1.svg') }}" alt=""
                        class="absolute top-8 left-4 w-16 h-16 opacity-20 animate-float-slow">
                    <img src="{{ Storage::url('web/ASET VISUAL/SVG/15.svg') }}" alt=""
                        class="absolute top-12 right-8 w-12 h-12 opacity-15 animate-float">
                </div>
            </div>
        </div>

        <!-- Main Dashboard Grid -->
        <div class="px-4 pb-6">
            <div class="mx-auto max-w-7xl space-y-6">
                <!-- Stats Cards Row - Consistent 3-column grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Connections Card -->
                    <div
                        class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 p-5 text-white shadow-lg hover:shadow-xl transition-all duration-500 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>
                        <div class="absolute top-0 right-0 w-16 h-16 opacity-20">
                            <img src="{{ Storage::url('web/ASET VISUAL/SVG/7.svg') }}" alt=""
                                class="w-full h-full object-contain">
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div
                                    class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                    <flux:icon.link class="size-5 text-white" />
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold">
                                        <livewire:dashboard.stats type="connections" />
                                    </div>
                                    <div class="text-blue-100 text-xs">Total</div>
                                </div>
                            </div>
                            <h3 class="text-sm font-bold mb-2">Koneksi</h3>
                            <p class="text-blue-100 mb-3 text-xs">Jaringan profesional yang terhubung</p>
                            <a href="{{ route('connections') . '?tab=list' }}"
                                class="inline-flex items-center text-xs font-medium text-white hover:text-blue-100 transition-colors">
                                Lihat Semua
                                <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Collaborations Card -->
                    <div
                        class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-purple-500 via-purple-600 to-pink-700 p-5 text-white shadow-lg hover:shadow-xl transition-all duration-500 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>
                        <div class="absolute top-0 left-0 w-16 h-16 opacity-20">
                            <img src="{{ Storage::url('web/ASET VISUAL/SVG/2.svg') }}" alt=""
                                class="w-full h-full object-contain">
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div
                                    class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                    <flux:icon.users class="size-5 text-white" />
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold">
                                        <livewire:dashboard.stats type="collaborations" />
                                    </div>
                                    <div class="text-purple-100 text-xs">Total</div>
                                </div>
                            </div>
                            <h3 class="text-sm font-bold mb-2">Kolaborasi</h3>
                            <p class="text-purple-100 mb-3 text-xs">Proyek kolaborasi yang aktif</p>
                            <a href="{{ route('collaborations') }}"
                                class="inline-flex items-center text-xs font-medium text-white hover:text-purple-100 transition-colors">
                                Lihat Semua
                                <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Events Card -->
                    <div
                        class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-700 p-5 text-white shadow-lg hover:shadow-xl transition-all duration-500 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>
                        <div class="absolute bottom-0 right-0 w-16 h-16 opacity-20">
                            <img src="{{ Storage::url('web/ASET VISUAL/SVG/11.svg') }}" alt=""
                                class="w-full h-full object-contain">
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div
                                    class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                    <flux:icon.user-group class="size-5 text-white" />
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold">
                                        <livewire:dashboard.stats type="events" />
                                    </div>
                                    <div class="text-emerald-100 text-xs">Total</div>
                                </div>
                            </div>
                            <h3 class="text-sm font-bold mb-2">Aksi</h3>
                            <p class="text-emerald-100 mb-3 text-xs">Event dan aksi yang diikuti</p>
                            <a href="{{ route('events') }}"
                                class="inline-flex items-center text-xs font-medium text-white hover:text-emerald-100 transition-colors">
                                Lihat Semua
                                <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid - Consistent 3-column layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Profile Progress - Takes 3 columns on large screens -->
                    <div class="lg:col-span-2 space-y-6">
                        <livewire:dashboard.profile-progress />
                        <!-- Activity Section - Consistent spacing and layout -->
                        <div
                            class="relative overflow-hidden rounded-xl bg-white dark:bg-zinc-800 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-purple-50/50 dark:from-blue-900/10 dark:to-purple-900/10">
                            </div>
                            <div class="absolute top-0 left-0 w-20 h-20 opacity-10">
                                <img src="{{ Storage::url('web/ASET VISUAL/SVG/4.svg') }}" alt=""
                                    class="w-full h-full object-contain">
                            </div>

                            <div class="relative z-10 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Aktivitas
                                            Terbaru</h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">Lihat apa yang terjadi di
                                            komunitas Anda</p>
                                    </div>
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
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
                    <div class="space-y-6">
                        <!-- Connection Quality - Only show if connections exist -->
                        @if (auth()->user()->connections()->count() > 0)
                            <livewire:dashboard.connection-quality />
                        @endif
                        <!-- Profile Summary - Only show if profile exists and has data -->
                        @if (auth()->user()->profile && auth()->user()->profile->organization)
                            <livewire:dashboard.profile-summary />
                        @endif
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
                            class="w-8 h-8 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center mb-3">
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
