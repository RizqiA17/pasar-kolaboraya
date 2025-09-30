<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-emerald-50 dark:from-zinc-800 dark:to-emerald-900/20 shadow-xl border border-gray-100 dark:border-gray-700 p-8">
    {{-- SVG Accent for Connection Quality --}}
    <div class="absolute top-0 left-0 w-32 h-32 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/SVG/9.svg') }}" alt="" class="w-full h-full object-contain">
    </div>
    <div class="absolute bottom-0 right-0 w-24 h-24 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/SVG/5.svg') }}" alt="" class="w-full h-full object-contain">
    </div>
    
    <div class="relative z-10">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Keragaman Peran Koneksi</h3>
                <p class="text-gray-600 dark:text-gray-400">Analisis keragaman peran dalam jaringan koneksi Anda</p>
            </div>
        </div>
        
        <!-- Main Quality Score -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="text-5xl font-bold bg-gradient-to-r @if($connectionQuality >= 75) from-emerald-600 to-teal-600 @elseif($connectionQuality >= 50) from-yellow-600 to-orange-600 @else from-orange-600 to-red-600 @endif bg-clip-text text-transparent">
                    {{ $connectionQuality }}%
                </div>
                <div class="flex items-center">
                    @if($qualityLevel === 'Excellent')
                        <span class="inline-flex items-center rounded-full bg-gradient-to-r from-green-100 to-emerald-100 px-4 py-2 text-sm font-bold text-green-800 dark:from-green-900/30 dark:to-emerald-900/30 dark:text-green-200 border border-green-200 dark:border-green-700">
                            Luar Biasa
                        </span>
                    @elseif($qualityLevel === 'Good')
                        <span class="inline-flex items-center rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 px-4 py-2 text-sm font-bold text-blue-800 dark:from-blue-900/30 dark:to-indigo-900/30 dark:text-blue-200 border border-blue-200 dark:border-blue-700">
                            Baik
                        </span>
                    @elseif($qualityLevel === 'Fair')
                        <span class="inline-flex items-center rounded-full bg-gradient-to-r from-yellow-100 to-orange-100 px-4 py-2 text-sm font-bold text-yellow-800 dark:from-yellow-900/30 dark:to-orange-900/30 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-700">
                            Cukup
                        </span>
                    @elseif($qualityLevel === 'Poor')
                        <span class="inline-flex items-center rounded-full bg-gradient-to-r from-orange-100 to-red-100 px-4 py-2 text-sm font-bold text-orange-800 dark:from-orange-900/30 dark:to-red-900/30 dark:text-orange-200 border border-orange-200 dark:border-orange-700">
                            Kurang
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-gradient-to-r from-red-100 to-pink-100 px-4 py-2 text-sm font-bold text-red-800 dark:from-red-900/30 dark:to-pink-900/30 dark:text-red-200 border border-red-200 dark:border-red-700">
                            Sangat Kurang
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-2xl p-4 border border-emerald-100 dark:border-emerald-800">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 mb-2">
                    <strong>Sistem Skor Keragaman Peran</strong>
                </p>
                <p class="text-xs text-emerald-600 dark:text-emerald-400 mb-1">
                    <strong>Rumus:</strong> (Peran dalam koneksi / Total peran di database) × 100%
                </p>
                <p class="text-xs text-emerald-600 dark:text-emerald-400 mb-1">
                    <strong>Fokus:</strong> Cakupan peran dalam jaringan koneksi Anda
                </p>
                <p class="text-xs text-emerald-600 dark:text-emerald-400">
                    <strong>Terakhir diperbarui:</strong> {{ $lastUpdated }}
                </p>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-4 border border-blue-100 dark:border-blue-800 text-center">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ $acceptedConnections }}</div>
                <div class="text-xs font-medium text-blue-700 dark:text-blue-300">Total Koneksi</div>
            </div>
            <div class="bg-red-50 dark:bg-red-900/20 rounded-2xl p-4 border border-red-100 dark:border-red-800 text-center">
                <div class="text-2xl font-bold text-red-600 dark:text-red-400 mb-1">{{ $connectedUsersCount }}</div>
                <div class="text-xs font-medium text-red-700 dark:text-red-300">Pengguna Terhubung</div>
            </div>
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-4 border border-green-100 dark:border-green-800 text-center">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-1">{{ $uniqueRolesCount }}</div>
                <div class="text-xs font-medium text-green-700 dark:text-green-300">Peran Unik</div>
            </div>
            <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-2xl p-4 border border-orange-100 dark:border-orange-800 text-center">
                <div class="text-2xl font-bold text-orange-600 dark:text-orange-400 mb-1">{{ $uniqueRolesCount }}/{{ $totalRolesInDatabase }}</div>
                <div class="text-xs font-medium text-orange-700 dark:text-orange-300">Peran Terkoneksi</div>
            </div>
        </div>

        <!-- Role Diversity Breakdown -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <div class="w-8 h-8 bg-secondary-green rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                Analisis Keragaman Peran
            </h4>
            
            <div class="space-y-4">
                <div class="bg-gradient-to-r from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/20 rounded-xl p-4 border border-teal-100 dark:border-teal-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-teal-700 dark:text-teal-300" title="Persentase cakupan peran dalam koneksi dibandingkan total peran di database">
                            Cakupan Peran dalam Koneksi
                        </span>
                        <span class="text-lg font-bold text-teal-800 dark:text-teal-200">{{ $diversityScore }}%</span>
                    </div>
                    <div class="w-full bg-teal-200 dark:bg-teal-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-teal-400 to-cyan-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $diversityScore }}%"></div>
                    </div>
                    <div class="text-xs text-teal-600 dark:text-teal-400 mt-1">
                        {{ $uniqueRolesCount }} dari {{ $totalRolesInDatabase }} peran tersedia dalam koneksi Anda
                    </div>
                </div>

                @if(!empty($roleCategories))
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-4 border border-blue-100 dark:border-blue-800">
                    <div class="text-sm font-medium text-blue-700 dark:text-blue-300 mb-3">Distribusi Peran dalam Jaringan</div>
                    <div class="space-y-2">
                        @foreach($roleCategories as $role => $count)
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-blue-600 dark:text-blue-400">{{ $role }}</span>
                            <div class="flex items-center gap-2">
                                <div class="w-16 bg-blue-200 dark:bg-blue-700 rounded-full h-1.5">
                                    <div class="bg-primary-blue h-1.5 rounded-full" style="width: {{ ($count / $connectedUsersCount) * 100 }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-blue-700 dark:text-blue-300">{{ $count }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Recommendations -->
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl p-4 border border-amber-100 dark:border-amber-800">
            <h4 class="text-sm font-semibold text-amber-800 dark:text-amber-200 mb-3 flex items-center">
                Rekomendasi Peningkatan Keragaman Peran
            </h4>
            <div class="space-y-2 text-sm text-amber-700 dark:text-amber-300">
                @if($diversityScore < 20)
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Koneksi dengan pengguna dari berbagai peran untuk meningkatkan cakupan peran</span>
                    </div>
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Target minimal 5-10 peran berbeda dari {{ $totalRolesInDatabase }} peran yang tersedia</span>
                    </div>
                @elseif($diversityScore < 40)
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Terus perluas koneksi dengan peran yang belum ada dalam jaringan</span>
                    </div>
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Fokus pada peran yang berbeda dari latar belakang profesional Anda</span>
                    </div>
                @elseif($diversityScore < 60)
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Jaringan Anda sudah cukup beragam, pertahankan keseimbangan peran</span>
                    </div>
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Koneksi dengan peran yang jarang ditemukan untuk meningkatkan cakupan</span>
                    </div>
                @else
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Excellent! Jaringan Anda memiliki cakupan peran yang sangat baik</span>
                    </div>
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Pertahankan keseimbangan dan terus kembangkan koneksi yang bermakna</span>
                    </div>
                @endif
                @if($uniqueRolesCount < 5)
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Usahakan memiliki minimal 5 peran berbeda dalam jaringan koneksi</span>
                    </div>
                @endif
                <div class="flex items-start">
                    <span class="text-amber-600 mr-2">•</span>
                    <span>Total {{ $totalRolesInDatabase }} peran tersedia di platform - Anda telah mengkoneksi {{ $uniqueRolesCount }} peran</span>
                </div>
            </div>
        </div>
    </div>
</div>
