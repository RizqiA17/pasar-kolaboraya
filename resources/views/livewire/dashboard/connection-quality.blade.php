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
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Kualitas Koneksi</h3>
                <p class="text-gray-600 dark:text-gray-400">Analisis jaringan profesional Anda</p>
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
                            🎉 {{ $qualityLevel }}
                        </span>
                    @elseif($qualityLevel === 'Good')
                        <span class="inline-flex items-center rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 px-4 py-2 text-sm font-bold text-blue-800 dark:from-blue-900/30 dark:to-indigo-900/30 dark:text-blue-200 border border-blue-200 dark:border-blue-700">
                            👍 {{ $qualityLevel }}
                        </span>
                    @elseif($qualityLevel === 'Fair')
                        <span class="inline-flex items-center rounded-full bg-gradient-to-r from-yellow-100 to-orange-100 px-4 py-2 text-sm font-bold text-yellow-800 dark:from-yellow-900/30 dark:to-orange-900/30 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-700">
                            💪 {{ $qualityLevel }}
                        </span>
                    @elseif($qualityLevel === 'Poor')
                        <span class="inline-flex items-center rounded-full bg-gradient-to-r from-orange-100 to-red-100 px-4 py-2 text-sm font-bold text-orange-800 dark:from-orange-900/30 dark:to-red-900/30 dark:text-orange-200 border border-orange-200 dark:border-orange-700">
                            🔥 {{ $qualityLevel }}
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-gradient-to-r from-red-100 to-pink-100 px-4 py-2 text-sm font-bold text-red-800 dark:from-red-900/30 dark:to-pink-900/30 dark:text-red-200 border border-red-200 dark:border-red-700">
                            ⚡ {{ $qualityLevel }}
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-2xl p-4 border border-emerald-100 dark:border-emerald-800">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 mb-2">
                    <strong>📊 Pilar I - Koneksi Scoring System (Updated)</strong>
                </p>
                <p class="text-xs text-emerald-600 dark:text-emerald-400 mb-1">
                    <strong>🧮 Rumus:</strong> (Friendship Density + Avg Friends + Acceptance Rate + Recency + Diversity) / 5
                </p>
                <p class="text-xs text-emerald-600 dark:text-emerald-400 mb-1">
                    <strong>📈 Komponen:</strong> Density (20%) + Avg Friends (20%) + Acceptance (20%) + Recency (20%) + Diversity (20%)
                </p>
                <p class="text-xs text-emerald-600 dark:text-emerald-400">
                    <strong>🕒 Terakhir diperbarui:</strong> {{ $lastUpdated }}
                </p>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-4 border border-blue-100 dark:border-blue-800 text-center">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ $acceptedConnections }}</div>
                <div class="text-xs font-medium text-blue-700 dark:text-blue-300">Koneksi Diterima</div>
            </div>
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl p-4 border border-purple-100 dark:border-purple-800 text-center">
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400 mb-1">{{ $connectedUsersCount }}</div>
                <div class="text-xs font-medium text-purple-700 dark:text-purple-300">User Terhubung</div>
            </div>
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-4 border border-green-100 dark:border-green-800 text-center">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-1">{{ $recentConnections }}</div>
                <div class="text-xs font-medium text-green-700 dark:text-green-300">Koneksi 90 Hari</div>
            </div>
            <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-2xl p-4 border border-orange-100 dark:border-orange-800 text-center">
                <div class="text-2xl font-bold text-orange-600 dark:text-orange-400 mb-1">{{ count($roleCategories) }}</div>
                <div class="text-xs font-medium text-orange-700 dark:text-orange-300">Kategori Role</div>
            </div>
        </div>

        <!-- Score Breakdown -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                Pilar I - Koneksi Breakdown
            </h4>
            
            <div class="space-y-4">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-4 border border-blue-100 dark:border-blue-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-blue-700 dark:text-blue-300" title="Kepadatan jaringan berdasarkan koneksi yang diterima">
                            🔗 Friendship Density
                        </span>
                        <span class="text-lg font-bold text-blue-800 dark:text-blue-200">{{ $friendshipDensityScore }}%</span>
                    </div>
                    <div class="w-full bg-blue-200 dark:bg-blue-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $friendshipDensityScore }}%"></div>
                    </div>
                    <div class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                        {{ $acceptedConnections }} koneksi dari {{ $possiblePairs }} kemungkinan pasangan
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-4 border border-purple-100 dark:border-purple-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-purple-700 dark:text-purple-300" title="Rata-rata jumlah teman per user">
                            👥 Average Friends per User
                        </span>
                        <span class="text-lg font-bold text-purple-800 dark:text-purple-200">{{ $avgFriendsScore }}%</span>
                    </div>
                    <div class="w-full bg-purple-200 dark:bg-purple-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-purple-400 to-pink-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $avgFriendsScore }}%"></div>
                    </div>
                    <div class="text-xs text-purple-600 dark:text-purple-400 mt-1">
                        Rata-rata {{ $avgDegree }} teman per user (target: 20)
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-4 border border-green-100 dark:border-green-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-green-700 dark:text-green-300" title="Tingkat penerimaan koneksi">
                            ✅ Connection Acceptance Rate
                        </span>
                        <span class="text-lg font-bold text-green-800 dark:text-green-200">{{ $acceptanceRateScore }}%</span>
                    </div>
                    <div class="w-full bg-green-200 dark:bg-green-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $acceptanceRateScore }}%"></div>
                    </div>
                    <div class="text-xs text-green-600 dark:text-green-400 mt-1">
                        {{ $acceptedCount }} diterima dari {{ $acceptedCount + $rejectedCount }} total
                    </div>
                </div>

                <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-xl p-4 border border-orange-100 dark:border-orange-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-orange-700 dark:text-orange-300" title="Koneksi yang dibuat dalam 90 hari terakhir">
                            🕒 Connection Recency
                        </span>
                        <span class="text-lg font-bold text-orange-800 dark:text-orange-200">{{ $recencyScore }}%</span>
                    </div>
                    <div class="w-full bg-orange-200 dark:bg-orange-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-orange-400 to-red-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $recencyScore }}%"></div>
                    </div>
                    <div class="text-xs text-orange-600 dark:text-orange-400 mt-1">
                        {{ $recentConnections }} koneksi dalam 90 hari terakhir
                    </div>
                </div>

                <div class="bg-gradient-to-r from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/20 rounded-xl p-4 border border-teal-100 dark:border-teal-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-teal-700 dark:text-teal-300" title="Keragaman jaringan berdasarkan role user">
                            🌐 Network Diversity
                        </span>
                        <span class="text-lg font-bold text-teal-800 dark:text-teal-200">{{ $diversityScore }}%</span>
                    </div>
                    <div class="w-full bg-teal-200 dark:bg-teal-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-teal-400 to-cyan-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $diversityScore }}%"></div>
                    </div>
                    <div class="text-xs text-teal-600 dark:text-teal-400 mt-1">
                        {{ count($roleCategories) }} kategori role berbeda
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl p-4 border border-amber-100 dark:border-amber-800">
            <h4 class="text-sm font-semibold text-amber-800 dark:text-amber-200 mb-3 flex items-center">
                <span class="text-lg mr-2">💡</span>
                Rekomendasi Peningkatan Pilar I - Koneksi
            </h4>
            <div class="space-y-2 text-sm text-amber-700 dark:text-amber-300">
                @if($friendshipDensityScore < 50)
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Perluas jaringan koneksi untuk meningkatkan friendship density</span>
                    </div>
                @endif
                @if($avgFriendsScore < 50)
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Bangun lebih banyak koneksi untuk meningkatkan rata-rata teman per user</span>
                    </div>
                @endif
                @if($acceptanceRateScore < 50)
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Perbaiki kualitas profil untuk meningkatkan acceptance rate koneksi</span>
                    </div>
                @endif
                @if($recencyScore < 50)
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Buat koneksi baru secara rutin untuk meningkatkan recency score</span>
                    </div>
                @endif
                @if($diversityScore < 50)
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Koneksi dengan user dari berbagai role untuk meningkatkan network diversity</span>
                    </div>
                @endif
                @if($connectionQuality >= 75)
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Pertahankan kualitas koneksi yang sudah baik</span>
                    </div>
                    <div class="flex items-start">
                        <span class="text-amber-600 mr-2">•</span>
                        <span>Terus kembangkan jaringan profesional yang beragam</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
