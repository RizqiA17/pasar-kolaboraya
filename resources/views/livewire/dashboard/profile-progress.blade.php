<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 relative overflow-hidden">
    {{-- SVG Accent Elements --}}
    <x-svg-accent position="top-right" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="bottom-left" size="w-12 h-12" opacity="opacity-10" />
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">Kelengkapan Profil</h3>
        @if($completionPercentage < 100)
            <flux:button 
                wire:click="goToProfileSetup" 
                variant="primary" 
                size="sm"
                icon="pencil-square"
            >
                Lengkapi Profil
            </flux:button>
        @endif
    </div>

    <!-- Progress Bar -->
    <div class="mb-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700">Progress</span>
            <span class="text-sm font-medium text-gray-700">{{ $completionPercentage }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div 
                class="h-3 rounded-full transition-all duration-500 {{ $completionPercentage >= 100 ? 'bg-green-500' : ($completionPercentage >= 70 ? 'bg-blue-500' : ($completionPercentage >= 40 ? 'bg-yellow-500' : 'bg-red-500')) }}" 
                style="width: {{ $completionPercentage }}%"
            ></div>
        </div>
    </div>

    <!-- Status Message -->
    <div class="mb-4">
        @if($completionPercentage >= 100)
            <div class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-green-800">Profil Anda sudah 100% lengkap! 🎉</span>
            </div>
        @elseif($completionPercentage >= 70)
            <div class="flex items-center p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-blue-800">Profil Anda hampir lengkap! Tinggal sedikit lagi.</span>
            </div>
        @elseif($completionPercentage >= 40)
            <div class="flex items-center p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                <svg class="w-5 h-5 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <span class="text-sm font-medium text-yellow-800">Profil Anda perlu dilengkapi untuk pengalaman yang lebih baik.</span>
            </div>
        @else
            <div class="flex items-center p-3 bg-red-50 border border-red-200 rounded-lg">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <span class="text-sm font-medium text-red-800">Profil Anda masih sangat minimal. Yuk lengkapi sekarang!</span>
            </div>
        @endif
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="bg-gray-50 rounded-lg p-3 text-center">
            <div class="text-2xl font-bold text-gray-900">{{ $filledFields }}</div>
            <div class="text-xs text-gray-600">Field Terisi</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-3 text-center">
            <div class="text-2xl font-bold text-gray-900">{{ $totalFields }}</div>
            <div class="text-xs text-gray-600">Total Field</div>
        </div>
    </div>

    <!-- Missing Fields -->
    @if(count($missingFields) > 0)
        <div class="border-t border-gray-200 pt-4">
            <h4 class="text-sm font-medium text-gray-900 mb-3">Field yang Belum Diisi:</h4>
            <div class="space-y-2">
                @foreach($missingFields as $field)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ $field }}
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    @if($completionPercentage < 100)
        <div class="border-t border-gray-200 pt-4 mt-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Lengkapi profil Anda untuk mendapatkan rekomendasi yang lebih baik</span>
                <flux:button 
                    wire:click="goToProfileSetup" 
                    variant="subtle" 
                    size="sm"
                >
                    Mulai Sekarang
                </flux:button>
            </div>
        </div>
    @endif
</div>






