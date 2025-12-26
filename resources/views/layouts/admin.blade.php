@extends('layouts.app')

@section('content')
        <div class="flex">

            <x-admin.sidebar />

            <!-- Main content -->
            <div class="lg:pl-64 flex flex-col flex-1">
                <!-- Mobile menu button -->
                <div class="lg:hidden max-w-svw">
                    <div
                        class="flex items-center justify-between h-16 px-4 bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border-b border-white/20 dark:border-slate-700/50">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-pink-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
@endsection
