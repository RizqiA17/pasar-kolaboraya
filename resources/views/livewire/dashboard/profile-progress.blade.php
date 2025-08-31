<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-blue-50 dark:from-zinc-800 dark:to-blue-900/20 shadow-xl border border-gray-100 dark:border-gray-700 p-8">
    {{-- SVG Accent Elements --}}
    <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/SVG/6.svg') }}" alt="" class="w-full h-full object-contain">
    </div>
    <div class="absolute bottom-0 left-0 w-24 h-24 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/SVG/12.svg') }}" alt="" class="w-full h-full object-contain">
    </div>
    
    <div class="relative z-10">
        <div class="flex items-center justify-between mb-6 flex-wrap">
            <div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Kelengkapan Profil</h3>
                <p class="text-gray-600 dark:text-gray-400">Lengkapi profil Anda untuk pengalaman terbaik</p>
            </div>
            @if($completionPercentage < 100)
                <flux:button 
                    wire:click="goToProfileSetup" 
                    variant="primary" 
                    size="sm"
                    icon="pencil-square"
                    class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700"
                >
                    Lengkapi Profil
                </flux:button>
            @endif
        </div>

        <!-- Enhanced Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Progress</span>
                <div class="flex items-center space-x-2">
                    <span class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        {{ $completionPercentage }}%
                    </span>
                    @if($completionPercentage >= 100)
                        <span class="text-2xl">🎉</span>
                    @elseif($completionPercentage >= 70)
                        <span class="text-2xl">🚀</span>
                    @elseif($completionPercentage >= 40)
                        <span class="text-2xl">💪</span>
                    @else
                        <span class="text-2xl">🔥</span>
                    @endif
                </div>
            </div>
            
            <div class="relative">
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div 
                        class="h-4 rounded-full transition-all duration-1000 ease-out relative overflow-hidden {{ $completionPercentage >= 100 ? 'bg-gradient-to-r from-green-400 to-emerald-500' : ($completionPercentage >= 70 ? 'bg-gradient-to-r from-blue-400 to-indigo-500' : ($completionPercentage >= 40 ? 'bg-gradient-to-r from-yellow-400 to-orange-500' : 'bg-gradient-to-r from-red-400 to-pink-500')) }}" 
                        style="width: {{ $completionPercentage }}%"
                    >
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-pulse"></div>
                    </div>
                </div>
                
                <!-- Progress Markers -->
                <div class="flex justify-between mt-2 text-xs text-gray-500 dark:text-gray-400">
                    <span>0%</span>
                    <span>25%</span>
                    <span>50%</span>
                    <span>75%</span>
                    <span>100%</span>
                </div>
            </div>
        </div>

        <!-- Enhanced Status Message -->
        <div class="mb-8">
            @if($completionPercentage >= 100)
                <div class="flex items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-700 rounded-2xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mr-4">
                        <span class="text-2xl">🎉</span>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-green-800 dark:text-green-200">Profil Lengkap!</div>
                        <div class="text-green-600 dark:text-green-300">Anda siap untuk berkolaborasi!</div>
                    </div>
                </div>
            @elseif($completionPercentage >= 70)
                <div class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-700 rounded-2xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center mr-4">
                        <span class="text-2xl">🚀</span>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-blue-800 dark:text-blue-200">Hampir Sempurna!</div>
                        <div class="text-blue-600 dark:text-blue-300">Tinggal sedikit lagi untuk profil lengkap</div>
                    </div>
                </div>
            @elseif($completionPercentage >= 40)
                <div class="flex items-center p-4 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border border-yellow-200 dark:border-yellow-700 rounded-2xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mr-4">
                        <span class="text-2xl">💪</span>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-yellow-800 dark:text-yellow-200">Sedang Berproses!</div>
                        <div class="text-yellow-600 dark:text-yellow-300">Lanjutkan melengkapi profil Anda</div>
                    </div>
                </div>
            @else
                <div class="flex items-center p-4 bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border border-red-200 dark:border-red-700 rounded-2xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-pink-500 rounded-full flex items-center justify-center mr-4">
                        <span class="text-2xl">🔥</span>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-red-800 dark:text-red-200">Ayo Mulai!</div>
                        <div class="text-red-600 dark:text-red-300">Lengkapi profil untuk pengalaman terbaik</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Enhanced Statistics -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 text-center border border-blue-100 dark:border-blue-800">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ $filledFields }}</div>
                <div class="text-sm font-medium text-blue-700 dark:text-blue-300">Field Terisi</div>
                <div class="w-16 h-1 bg-blue-200 dark:bg-blue-700 rounded-full mx-auto mt-3"></div>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl p-6 text-center border border-purple-100 dark:border-purple-800">
                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2">{{ $totalFields }}</div>
                <div class="text-sm font-medium text-purple-700 dark:text-purple-300">Total Field</div>
                <div class="w-16 h-1 bg-purple-200 dark:bg-purple-700 rounded-full mx-auto mt-3"></div>
            </div>
        </div>

        <!-- Missing Fields with Better Design -->
        @if(count($missingFields) > 0)
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    Field yang Belum Diisi
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($missingFields as $field)
                        <div class="flex items-center p-3 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-200 dark:border-red-800">
                            <div class="w-2 h-2 bg-red-400 rounded-full mr-3"></div>
                            <span class="text-sm font-medium text-red-700 dark:text-red-300">{{ $field }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Enhanced Quick Actions -->
        @if($completionPercentage < 100)
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl p-6 border border-blue-100 dark:border-blue-800">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Siap untuk Memulai?</div>
                            <div class="text-gray-600 dark:text-gray-400">Lengkapi profil Anda untuk mendapatkan rekomendasi yang lebih baik dan meningkatkan peluang kolaborasi</div>
                        </div>
                        <flux:button 
                            wire:click="goToProfileSetup" 
                            variant="primary" 
                            class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 shadow-lg"
                        >
                            Mulai Sekarang
                        </flux:button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>






