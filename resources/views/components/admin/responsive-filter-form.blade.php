@props([
    'searchPlaceholder' => 'Cari...',
    'filters' => [],
    'showSearch' => true,
    'showFilters' => true
])

<div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
    <div class="space-y-4">
        @if($showSearch)
            <!-- Search Bar -->
            <div class="flex items-center space-x-4">
                <div class="flex-1">
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live="search"
                            placeholder="{{ $searchPlaceholder }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
                        >
                        <flux:icon.magnifying-glass class="absolute left-3 top-2.5 size-4 text-gray-400" />
                    </div>
                </div>
            </div>
        @endif

        @if($showFilters && count($filters) > 0)
            <!-- Filters -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($filters as $filter)
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                            {{ $filter['label'] }}
                        </label>
                        @if($filter['type'] === 'select')
                            <select 
                                wire:model.live="{{ $filter['key'] }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
                            >
                                <option value="">{{ $filter['placeholder'] ?? 'Pilih...' }}</option>
                                @foreach($filter['options'] as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        @elseif($filter['type'] === 'date')
                            <input 
                                type="date"
                                wire:model.live="{{ $filter['key'] }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
                            >
                        @elseif($filter['type'] === 'text')
                            <input 
                                type="text"
                                wire:model.live="{{ $filter['key'] }}"
                                placeholder="{{ $filter['placeholder'] ?? '' }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
                            >
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
            <button 
                wire:click="resetFilters"
                class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors"
            >
                Reset Filter
            </button>
            
            @if(isset($exportRoute))
                <a 
                    href="{{ $exportRoute }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors text-center"
                >
                    Export Data
                </a>
            @endif
        </div>
    </div>
</div>