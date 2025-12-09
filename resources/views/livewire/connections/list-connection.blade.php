@php
    $connectionsEnabled = \App\Models\SystemSetting::isConnectionsEnabled();
    $collaborationsEnabled = \App\Models\SystemSetting::isCollaborationsEnabled();
    $isSuperAdmin = auth()->user()->isSuperAdmin();
@endphp

<section class="space-y-4 relative">
    <h2 class="text-base sm:text-lg font-semibold">Semua Koneksi</h2>
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="center-right" size="w-12 h-12" opacity="opacity-10" />
    <x-svg-accent position="bottom-right" size="w-14 h-14" opacity="opacity-10" />

    <div class="grid grid-cols-[repeat(auto-fill,_minmax(16rem,_1fr))] gap-4">
        @forelse ($friends as $friend)
            <x-connection.user-card :friend="$friend" />
        @empty
            <div class="col-span-full  py-12 px-4">
                <div
                    class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/30 dark:to-purple-900/30 border-2 border-blue-100/50 dark:border-blue-800/50 flex  justify-center">
                    <svg class="w-10 h-10 text-blue-400 dark:text-blue-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-slate-200 mb-2">Belum Ada Koneksi</h3>
                <p class="text-gray-600 dark:text-slate-400 max-w-sm mx-auto leading-relaxed">
                    Mulai terhubung dengan pengguna lain untuk membangun jaringan kolaborasi Anda.
                </p>
            </div>
        @endforelse
    </div>
</section>
