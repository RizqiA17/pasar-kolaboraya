<x-layouts.app.header :title="$title ?? 'Panel Admin'">
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
        <div class="flex">
            <!-- Mobile Sidebar Overlay -->
            <div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>

            <!-- Sidebar -->
            <div id="mobile-sidebar"
                class="flex lg:max-h-[100svh_-_56px] mt-14 w-64 flex-col fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50">
                <div
                    class="flex flex-col flex-grow bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border-r border-white/20 dark:border-slate-700/50 shadow-xl">

                    <!-- Mobile Close Button -->
                    <div
                        class="lg:hidden flex items-center justify-between p-4 border-b border-slate-200 dark:border-slate-700">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-pink-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h1 class="text-lg font-bold text-slate-800 dark:text-slate-200">Panel Admin</h1>
                        </div>
                        <button type="button" id="mobile-sidebar-close"
                            class="text-slate-500 dark:text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 p-3 sm:p-4 space-y-1 sm:space-y-2 overflow-y-auto max-h-[calc(100svh_-_159px)]">
                        <a href="{{ route('admin.dashboard') }}"
                            class="group flex items-center px-2 sm:px-3 py-2 sm:py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-pink-100 dark:bg-pink-900/20 text-pink-700 dark:text-pink-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            <span class="truncate">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.surveys') }}"
                            class="group flex items-center px-2 sm:px-3 py-2 sm:py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.surveys*') ? 'bg-teal-100 dark:bg-teal-900/20 text-teal-700 dark:text-teal-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                            <span class="truncate">Pasar Kecil</span>
                        </a>

                        {{-- <a href="{{ route('admin.ecosystem-builders') }}"
                            class="group flex items-center px-2 sm:px-3 py-2 sm:py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.ecosystem-builders*') ? 'bg-teal-100 dark:bg-teal-900/20 text-teal-700 dark:text-teal-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></circle>
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M6.05 17.95l-1.414 1.414m12.728 0l-1.414-1.414M6.05 6.05L4.636 4.636">
                                </path>
                            </svg>
                            <span class="truncate">Ecosystem Builder</span> --}}
                        </a>

                        <a href="{{ route('admin.pasar-kolaboraya.manage') }}"
                            class="group flex items-center px-2 sm:px-3 py-2 sm:py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.pasar-kolaboraya*') ? 'bg-purple-100 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            <span class="truncate">Pasar Kolaboraya</span>
                        </a>

                        <div class="pt-4">
                            <h3
                                class="px-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Manajemen</h3>
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('admin.users') }}"
                                    class="group flex items-center px-2 sm:px-3 py-2 sm:py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users*') ? 'bg-blue-100 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                        </path>
                                    </svg>
                                    <span class="truncate">Peserta</span>
                                </a>

                                <a href="{{ route('admin.ecosystems') }}"
                                    class="group flex items-center px-2 sm:px-3 py-2 sm:py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.ecosystems*') ? 'bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    <span class="truncate">Ekosistem</span>
                                </a>

                                <a href="{{ route('admin.collective-actions') }}"
                                    class="group flex items-center px-2 sm:px-3 py-2 sm:py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.collective-actions*') ? 'bg-purple-100 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="truncate">Aksi Kolektif</span>
                                </a>

                                <a href="{{ route('admin.connections') }}"
                                    class="group flex items-center px-2 sm:px-3 py-2 sm:py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.connections*') ? 'bg-yellow-100 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                        </path>
                                    </svg>
                                    <span class="truncate">Koneksi</span>
                                </a>

                                <a href="{{ route('admin.registration-keys') }}"
                                    class="group flex items-center px-2 sm:px-3 py-2 sm:py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.registration-keys*') ? 'bg-indigo-100 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                        </path>
                                    </svg>
                                    <span class="truncate">Kunci Registrasi</span>
                                </a>

                                <a href="{{ route('admin.user-approvals') }}"
                                    class="group flex items-center px-2 sm:px-3 py-2 sm:py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.user-approvals*') ? 'bg-emerald-100 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <span class="truncate">Persetujuan User</span>
                                </a>

                            </div>
                        </div>

                        <div class="pt-4">
                            <h3
                                class="px-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Data Master</h3>
                            <div class="mt-2 space-y-1">
                                {{-- <a href="{{ route('admin.interests') }}"
                                    class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.interests*') ? 'bg-red-100 dark:bg-red-900/20 text-red-700 dark:text-red-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                    Minat
                                </a>

                                <a href="{{ route('admin.skills') }}"
                                    class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.skills*') ? 'bg-yellow-100 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                        </path>
                                    </svg>
                                    Keahlian
                                </a>

                                <a href="{{ route('admin.contributions') }}"
                                    class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.contributions*') ? 'bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                        </path>
                                    </svg>
                                    Kontribusi
                                </a> --}}

                                <a href="{{ route('admin.peran') }}"
                                    class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.peran*') ? 'bg-indigo-100 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    Peran
                                </a>

                                {{-- <a href="{{ route('admin.event-categories') }}" 
                                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.event-categories*') ? 'bg-purple-100 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Event Categories
                                </a> --}}
                            </div>
                        </div>

                        <div class="pt-4">
                            <h3
                                class="px-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Pengaturan Sistem</h3>
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('admin.system-settings') }}"
                                    class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.system-settings*') ? 'bg-orange-100 dark:bg-orange-900/20 text-orange-700 dark:text-orange-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Pengaturan Sistem
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Main content -->
            <div class="lg:pl-64 flex flex-col flex-1">
                <!-- Mobile menu button -->
                <div class="lg:hidden max-w-svw">
                    <div
                        class="flex items-center justify-between h-16 px-4 bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border-b border-white/20 dark:border-slate-700/50">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-pink-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h1 class="text-lg font-bold text-slate-800 dark:text-slate-200">Panel Admin</h1>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="mobile-menu-button"
                                class="text-slate-500 dark:text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Page content -->
                <main class="flex-1 p-4 sm:p-6 max-lg:mb-24">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar JavaScript -->
    <script>
        function initializeMobileSidebar() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
            const mobileSidebarClose = document.getElementById('mobile-sidebar-close');

            if (!mobileMenuButton || !mobileSidebar || !mobileSidebarOverlay || !mobileSidebarClose) {
                return; // Elements not found, skip initialization
            }

            function toggleMobileSidebar() {
                const isOpen = !mobileSidebar.classList.contains('-translate-x-full');

                if (isOpen) {
                    // Close sidebar
                    mobileSidebar.classList.add('-translate-x-full');
                    mobileSidebarOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    // Open sidebar
                    mobileSidebar.classList.remove('-translate-x-full');
                    mobileSidebarOverlay.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                }
            }

            function closeMobileSidebar() {
                mobileSidebar.classList.add('-translate-x-full');
                mobileSidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Remove existing event listeners to prevent duplicates
            const newMobileMenuButton = mobileMenuButton.cloneNode(true);
            mobileMenuButton.parentNode.replaceChild(newMobileMenuButton, mobileMenuButton);

            const newMobileSidebarClose = mobileSidebarClose.cloneNode(true);
            mobileSidebarClose.parentNode.replaceChild(newMobileSidebarClose, mobileSidebarClose);

            const newMobileSidebarOverlay = mobileSidebarOverlay.cloneNode(true);
            mobileSidebarOverlay.parentNode.replaceChild(newMobileSidebarOverlay, mobileSidebarOverlay);

            // Toggle sidebar on button click
            newMobileMenuButton.addEventListener('click', toggleMobileSidebar);

            // Close sidebar on close button click
            newMobileSidebarClose.addEventListener('click', closeMobileSidebar);

            // Close sidebar on overlay click
            newMobileSidebarOverlay.addEventListener('click', closeMobileSidebar);

            // Close sidebar when clicking on navigation links (mobile only)
            const navLinks = mobileSidebar.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) { // lg breakpoint
                        closeMobileSidebar();
                    }
                });
            });
        }

        // Initialize on DOM content loaded
        document.addEventListener('DOMContentLoaded', initializeMobileSidebar);

        // Re-initialize after Livewire navigation
        document.addEventListener('livewire:navigated', initializeMobileSidebar);

        // Close sidebar on escape key (global listener)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const mobileSidebar = document.getElementById('mobile-sidebar');
                const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');

                if (mobileSidebar && mobileSidebarOverlay) {
                    mobileSidebar.classList.add('-translate-x-full');
                    mobileSidebarOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }
        });

        // Handle window resize (global listener)
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) { // lg breakpoint
                const mobileSidebar = document.getElementById('mobile-sidebar');
                const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');

                if (mobileSidebar && mobileSidebarOverlay) {
                    mobileSidebar.classList.add('-translate-x-full');
                    mobileSidebarOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }
        });
    </script>
</x-layouts.app.header>
