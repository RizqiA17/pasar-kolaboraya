@if($activeSurvey)
<div class="relative overflow-hidden rounded-xl bg-white dark:bg-zinc-800 shadow-lg border border-gray-100 dark:border-gray-700">
    <!-- Background gradient -->
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-50/50 to-teal-50/50 dark:from-emerald-900/10 dark:to-teal-900/10"></div>
    
    <!-- Decorative SVG -->
    <div class="absolute top-0 right-0 w-20 h-20 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/SVG/9.svg') }}" alt="" class="w-full h-full object-contain">
    </div>

    <div class="relative z-10 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center">
                <flux:icon.clipboard-document-list class="size-6 text-white" />
            </div>
            @if($hasResponded)
                <span class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs font-medium rounded-full">
                    Sudah Diisi
                </span>
            @else
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 text-xs font-medium rounded-full">
                    Belum Diisi
                </span>
            @endif
        </div>

        <div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Survey Aktif</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">{{ $activeSurvey->name }}</p>
            <p class="text-gray-500 dark:text-gray-500 text-xs mb-4 line-clamp-2">{{ $activeSurvey->description }}</p>
        </div>

        @if(!$hasResponded)
            <a href="{{ route('survey.participate') }}"
                class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-2 rounded-lg font-medium hover:from-emerald-600 hover:to-teal-700 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl inline-block text-center"
            >
                Ikuti Survey
            </a>
        @else
            <div class="flex items-center text-green-600 dark:text-green-400 text-sm">
                <flux:icon.check-circle class="size-4 mr-2" />
                Terima kasih telah mengisi survey ini!
            </div>
        @endif
    </div>
</div>
@endif