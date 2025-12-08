<div
    class="relative overflow-hidden rounded-2xl bg-white dark:bg-slate-900 shadow-xl dark:border-t dark:border-slate-700 p-8">
    {{-- SVG Accent Elements --}}
    <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/SVG/6.svg') }}" alt="" class="w-full h-full object-contain">
    </div>
    <div class="absolute bottom-0 left-0 w-24 h-24 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/SVG/12.svg') }}" alt="" class="w-full h-full object-contain">
    </div>

    <div class="relative z-10">
        {{-- <div class="flex items-center justify-between mb-6 flex-wrap">
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-slate-200">Kelengkapan Profil</h3>
                <p class="text-gray-700 dark:text-slate-300 text-sm">Lengkapi profil Anda untuk pengalaman terbaik</p>
            </div>
            @if ($completionPercentage < 100)
                <flux:button wire:click="goToProfileSetup" variant="primary" size="sm" icon="pencil-square"
                    class="bg-primary-blue hover:bg-teal-600 transition-colors">
                    Lengkapi Profil
                </flux:button>
            @endif
        </div> --}}

        <!-- Enhanced Status Message -->
        <div class="mb-8">
            <div class="flex items-center justify-between">

                @if ($completionPercentage >= 100)
                    <div class="flex items-center rounded-2xl">
                        <div
                            class="w-12 min-w-12 h-12 text-xl font-bold bg-secondary-green rounded-full flex items-center justify-center mr-4">
                            <flux:icon.rocket-launch class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <div class="text-lg font-bold text-secondary-green">Profil Lengkap!
                            </div>
                            <div class="text-gray-700 dark:text-slate-300 text-sm">Anda siap untuk berkolaborasi!</div>
                        </div>
                    </div>
                @elseif($completionPercentage >= 70)
                    <div class="flex items-center rounded-2xl">
                        <div
                            class="w-12 min-w-12 h-12 text-xl font-bold bg-yellow-400 rounded-full flex items-center justify-center mr-4">
                            <flux:icon.sparkles class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <div class="text-lg font-bold text-yellow-400">Hampir Sempurna!</div>
                            <div class="text-gray-700 dark:text-slate-300 text-sm">Tinggal sedikit lagi untuk profil
                                lengkap
                            </div>
                        </div>
                    </div>
                @elseif($completionPercentage >= 40)
                    <div class="flex items-center">
                        <div
                            class="w-12 min-w-12 h-12 text-xl font-bold bg-accent-orange rounded-full flex items-center justify-center mr-4">
                            <flux:icon.clock class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <div class="text-lg font-bold text-accent-orange">Sedang Berproses!</div>
                            <div class="text-gray-700 dark:text-slate-300 text-sm">Lanjutkan melengkapi profil Anda
                            </div>
                        </div>
                    </div>
                @else
                    <div
                        class="flex items-center p-4 bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border border-red-200 dark:border-red-700 rounded-2xl">
                        <div
                            class="w-12 min-w-12 h-12 text-xl font-bold bg-gradient-to-br from-red-400 to-pink-500 rounded-full flex items-center justify-center mr-4">
                            <flux:icon.exclamation-triangle class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <div class="text-lg font-bold text-red-800 dark:text-red-200">Ayo Mulai!</div>
                            <div class="text-red-600 dark:text-red-300">Lengkapi profil untuk pengalaman terbaik</div>
                        </div>
                    </div>
                @endif

                <div class="flex flex-col items-center">
                    <div class="text-secondary-green text-lg font-bold">
                        <span
                            class="@if ($completionPercentage >= 100) text-secondary-green @elseif ($completionPercentage >= 70) text-yellow-400 @elseif($completionPercentage >= 40) text-accent-orange @endif">{{ $filledFields }}</span>/{{ $totalFields }}
                    </div>
                    <div class="text-sm text-gray-700 dark:text-slate-300">Field Terisi</div>
                </div>

            </div>
        </div>

        <!-- Enhanced Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <span class="text-lg font-semibold text-gray-700 dark:text-slate-200">Progress</span>
                <div class="flex items-center space-x-2">
                    <span
                        class="text-lg font-semibold @if ($completionPercentage >= 100) text-secondary-green @elseif($completionPercentage >= 70) text-yellow-400 @elseif($completionPercentage >= 40) text-accent-orange @endif">
                        {{ $completionPercentage }}%
                    </span>
                    @if ($completionPercentage >= 100)
                        <span class="text-2xl"></span>
                    @elseif($completionPercentage >= 70)
                        <span class="text-2xl"></span>
                    @elseif($completionPercentage >= 40)
                        <span class="text-2xl"></span>
                    @else
                        <span class="text-2xl"></span>
                    @endif
                </div>
            </div>

            <div class="relative">
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div class="h-4 rounded-full transition-all duration-1000 ease-out relative overflow-hidden {{ $completionPercentage >= 100 ? 'bg-secondary-green' : ($completionPercentage >= 70 ? 'bg-gradient-to-r from-accent-orange to-yellow-400' : ($completionPercentage >= 40 ? 'bg-gradient-to-r from-accent-red via-orange-700 to-accent-orange' : 'bg-accent-red')) }}"
                        style="width: {{ $completionPercentage }}%">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-pulse">
                        </div>
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

        <!-- Missing Fields with Better Design -->
        @if (count($missingFields) > 0)
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-semibold text-gray-700 dark:text-slate-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                    Field yang Belum Diisi
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach ($missingFields as $field)
                        <div
                            class="flex items-center p-3 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-200 dark:border-red-800/50">
                            <div class="w-2 h-2 bg-red-400 rounded-full mr-3"></div>
                            <span class="text-sm font-medium text-red-700 dark:text-red-300">{{ $field }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Enhanced Quick Actions -->
        @if ($completionPercentage < 100)
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                <div class="flex items-end justify-between max-sm:flex-col max-sm:items-start gap-4">
                    <div class="flex-1">
                        <div class="text-lg font-semibold text-gray-700 dark:text-slate-200 mb-2">Siap untuk Memulai?
                        </div>
                        <div class="text-gray-700 dark:text-slate-300 text-sm">Lengkapi profil Anda untuk mendapatkan
                            rekomendasi yang lebih baik dan meningkatkan peluang kolaborasi</div>
                    </div>
                    <flux:button wire:click="goToProfileSetup" variant="primary">
                        Mulai Sekarang
                    </flux:button>
                </div>
            </div>
        @endif
    </div>
</div>
