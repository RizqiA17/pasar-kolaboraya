<div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
    {{-- SVG Accent for Connection Quality --}}
    <x-svg-accent position="top-left" size="w-16 h-16" opacity="opacity-5" />
    
    <div class="flex flex-col">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Kualitas Koneksi</h3>
            <div class="flex items-center gap-2">
                <button wire:click="refresh" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 transition-colors" title="Refresh data">
                    @if($isLoading)
                        <flux:icon.arrow-path class="size-4 text-neutral-600 dark:text-neutral-400 animate-spin" />
                    @else
                        <flux:icon.arrow-path class="size-4 text-neutral-600 dark:text-neutral-400" />
                    @endif
                </button>
                <div class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900">
                    <flux:icon.star class="size-5 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <div class="flex items-center gap-3">
                <div class="text-3xl font-bold text-neutral-900 dark:text-white">
                    {{ $connectionQuality }}%
                </div>
                <div class="flex items-center">
                    @if($qualityLevel === 'Excellent')
                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                            {{ $qualityLevel }}
                        </span>
                    @elseif($qualityLevel === 'Good')
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                            {{ $qualityLevel }}
                        </span>
                    @elseif($qualityLevel === 'Fair')
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                            {{ $qualityLevel }}
                        </span>
                    @elseif($qualityLevel === 'Poor')
                        <span class="inline-flex items-center rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-800 dark:bg-orange-900 dark:text-orange-300">
                            {{ $qualityLevel }}
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                            {{ $qualityLevel }}
                        </span>
                    @endif
                </div>
            </div>
            
            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                Berdasarkan keragaman minat & keahlian
            </p>
            <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">
                Semakin beragam jenis minat dan keahlian dari koneksi, semakin bagus kualitasnya
            </p>
            <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">
                <strong>Rumus:</strong> Keragaman (40%) + Jumlah Koneksi (30%) + Kekayaan Konten (30%)
            </p>
            <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">
                Terakhir diperbarui: {{ $lastUpdated }}
            </p>
        </div>

        <div class="mt-4 space-y-3">
            <div class="flex items-center justify-between text-sm">
                <span class="text-neutral-600 dark:text-neutral-400">Total Koneksi:</span>
                <span class="font-medium text-neutral-900 dark:text-white">{{ $totalConnections }}</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-neutral-600 dark:text-neutral-400">Minat Unik:</span>
                <span class="font-medium text-neutral-900 dark:text-white">{{ $uniqueInterests }}</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-neutral-600 dark:text-neutral-400">Keahlian Unik:</span>
                <span class="font-medium text-neutral-900 dark:text-white">{{ $uniqueSkills }}</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-neutral-600 dark:text-neutral-400">Total Minat:</span>
                <span class="font-medium text-neutral-900 dark:text-white">{{ $totalInterests }}</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-neutral-600 dark:text-neutral-400">Total Keahlian:</span>
                <span class="font-medium text-neutral-900 dark:text-white">{{ $totalSkills }}</span>
            </div>
        </div>

        <div class="mt-4 space-y-2">
            <div class="flex items-center justify-between text-xs text-neutral-500 dark:text-neutral-400">
                <span title="Skor berdasarkan keragaman minat dan keahlian yang unik">Skor Keragaman:</span>
                <span>{{ $diversityScore }}/40</span>
            </div>
            <div class="flex items-center justify-between text-xs text-neutral-500 dark:text-neutral-400">
                <span title="Skor berdasarkan jumlah koneksi yang dimiliki">Skor Koneksi:</span>
                <span>{{ $connectionCountScore }}/30</span>
            </div>
            <div class="flex items-center justify-between text-xs text-neutral-500 dark:text-neutral-400">
                <span title="Skor berdasarkan kekayaan konten (total minat + keahlian unik)">Skor Konten:</span>
                <span>{{ $contentRichnessScore }}/30</span>
            </div>
        </div>

        @if(!empty($topInterests) || !empty($topSkills))
        <div class="mt-4 space-y-3">
            @if(!empty($topInterests))
            <div>
                <h4 class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Minat Terpopuler:</h4>
                <div class="space-y-1">
                    @foreach($topInterests as $interest)
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-neutral-600 dark:text-neutral-400">{{ $interest['name'] }}</span>
                        <span class="text-neutral-500 dark:text-neutral-500">{{ $interest['count'] }}x</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(!empty($topSkills))
            <div>
                <h4 class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Keahlian Terpopuler:</h4>
                <div class="space-y-1">
                    @foreach($topSkills as $skill)
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-neutral-600 dark:text-neutral-500">{{ $skill['name'] }}</span>
                        <span class="text-neutral-500 dark:text-neutral-500">{{ $skill['count'] }}x</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Target Goals Section -->
        <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <h4 class="text-sm font-medium text-blue-700 dark:text-blue-300 mb-2">🎯 Target untuk Skor Lebih Baik:</h4>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-blue-600 dark:text-blue-400">Koneksi:</span>
                        <span class="text-blue-700 dark:text-blue-300 font-medium">
                            @if($totalConnections < 3) <span class="text-red-500">{{ $totalConnections }}/3</span>
                            @elseif($totalConnections < 5) <span class="text-yellow-500">{{ $totalConnections }}/5</span>
                            @elseif($totalConnections < 10) <span class="text-blue-500">{{ $totalConnections }}/10</span>
                            @else <span class="text-green-500">✓ {{ $totalConnections }}</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-blue-600 dark:text-blue-400">Minat Unik:</span>
                        <span class="text-blue-700 dark:text-blue-300 font-medium">
                            @if($uniqueInterests < 5) <span class="text-red-500">{{ $uniqueInterests }}/5</span>
                            @elseif($uniqueInterests < 10) <span class="text-yellow-500">{{ $uniqueInterests }}/10</span>
                            @elseif($uniqueInterests < 15) <span class="text-blue-500">{{ $uniqueInterests }}/15</span>
                            @else <span class="text-green-500">✓ {{ $uniqueInterests }}</span>
                            @endif
                        </span>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-blue-600 dark:text-blue-400">Keahlian Unik:</span>
                        <span class="text-blue-700 dark:text-blue-300 font-medium">
                            @if($uniqueSkills < 5) <span class="text-red-500">{{ $uniqueSkills }}/5</span>
                            @elseif($uniqueSkills < 10) <span class="text-yellow-500">{{ $uniqueSkills }}/10</span>
                            @elseif($uniqueSkills < 15) <span class="text-blue-500">{{ $uniqueSkills }}/15</span>
                            @else <span class="text-green-500">✓ {{ $uniqueSkills }}</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-blue-600 dark:text-blue-400">Total Konten:</span>
                        <span class="text-blue-700 dark:text-blue-300 font-medium">
                            @php $totalContent = $uniqueInterests + $uniqueSkills; @endphp
                            @if($totalContent < 10) <span class="text-red-500">{{ $totalContent }}/10</span>
                            @elseif($totalContent < 20) <span class="text-yellow-500">{{ $totalContent }}/20</span>
                            @elseif($totalContent < 30) <span class="text-blue-500">{{ $totalContent }}/30</span>
                            @else <span class="text-green-500">✓ {{ $totalContent }}</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="flex items-center justify-between text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                <span>Kualitas Koneksi</span>
                <span>{{ $connectionQuality }}%</span>
            </div>
            <div class="w-full bg-neutral-200 rounded-full h-2 dark:bg-neutral-700">
                <div class="h-2 rounded-full transition-all duration-500 ease-out
                    @if($qualityLevel === 'Excellent') bg-gradient-to-r from-green-400 to-green-600
                    @elseif($qualityLevel === 'Good') bg-gradient-to-r from-blue-400 to-blue-600
                    @elseif($qualityLevel === 'Fair') bg-gradient-to-r from-yellow-400 to-yellow-600
                    @elseif($qualityLevel === 'Poor') bg-gradient-to-r from-orange-400 to-orange-600
                    @elseif($qualityLevel === 'Error') bg-gradient-to-r from-red-400 to-red-600
                    @else bg-gradient-to-r from-red-400 to-red-600
                    @endif"
                    style="width: {{ $connectionQuality }}%">
                </div>
            </div>
            <div class="mt-2 text-center">
                <span class="text-xs text-neutral-500 dark:text-neutral-400">
                    @if($qualityLevel === 'Excellent')
                        🎉 Koneksi Anda sangat berkualitas tinggi!
                    @elseif($qualityLevel === 'Good')
                        👍 Koneksi Anda berkualitas baik
                    @elseif($qualityLevel === 'Fair')
                        🤔 Koneksi Anda cukup baik
                    @elseif($qualityLevel === 'Poor')
                        ⚠️ Koneksi Anda perlu ditingkatkan
                    @elseif($qualityLevel === 'Error')
                        ❌ Terjadi kesalahan dalam perhitungan
                    @else
                        📉 Koneksi Anda perlu banyak peningkatan
                    @endif
                </span>
                
                @if($connectionQuality < 50)
                <div class="mt-2 p-2 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800">
                    <p class="text-xs text-amber-700 dark:text-amber-300 font-medium mb-1">💡 Tips Meningkatkan Kualitas:</p>
                    <ul class="text-xs text-amber-600 dark:text-amber-400 space-y-1">
                        @if($totalConnections < 3)
                            <li>• Tambah lebih banyak koneksi (target: 5+ koneksi)</li>
                        @endif
                        @if(($uniqueInterests + $uniqueSkills) < 10)
                            <li>• Koneksi dengan orang yang memiliki minat & keahlian beragam</li>
                        @endif
                        @if($uniqueInterests < 5)
                            <li>• Cari koneksi dengan minat yang berbeda-beda</li>
                        @endif
                        @if($uniqueSkills < 5)
                            <li>• Koneksi dengan orang yang memiliki keahlian bervariasi</li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
