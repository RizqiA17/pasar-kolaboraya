<x-layouts.app :title="__('Peta Ekosistem Kolaboraya')">
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="px-4 py-8">
            <div class="mx-auto max-w-7xl">
                <!-- Header Section -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Peta Ekosistem Kolaboraya
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        Visualisasi interaktif ekosistem, peran, dan kolaborator dalam Pasar Kolaboraya. 
                        Zoom dan pan untuk menjelajahi jaringan kolaborasi yang luas.
                    </p>
                </div>

                <!-- Mapping Container -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <livewire:dashboard.ecosystem-mapping />
                </div>

                <!-- Instructions -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Interaktif</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            Gunakan mouse untuk zoom in/out dan drag untuk memindahkan peta. 
                            Hover pada peran untuk melihat detail pengguna.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Kolaborasi</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            Lihat bagaimana ekosistem terhubung dan peran-peran yang dibutuhkan 
                            untuk membangun kolaborasi yang efektif.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Jaringan</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            Temukan koneksi dan peluang kolaborasi baru melalui 
                            visualisasi jaringan yang komprehensif.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
