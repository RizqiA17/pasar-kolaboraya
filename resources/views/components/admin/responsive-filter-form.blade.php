@props([
    'action' => '',
    'method' => 'GET',
    'searchPlaceholder' => 'Cari...',
    'searchName' => 'search',
    'searchValue' => '',
    'filters' => [],
    'clearUrl' => ''
])

<div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
    <form method="{{ $method }}" action="{{ $action }}" class="space-y-4">
        <!-- Search Input -->
        <div>
            <flux:input 
                name="{{ $searchName }}" 
                placeholder="{{ $searchPlaceholder }}" 
                value="{{ $searchValue }}"
                class="w-full"
            />
        </div>
        
        @if(count($filters) > 0)
            <!-- Filter Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min(count($filters), 4) }} gap-4">
                @foreach($filters as $filter)
                    <div>
                        @if($filter['type'] === 'select')
                            <flux:select name="{{ $filter['name'] }}" placeholder="{{ $filter['placeholder'] }}">
                                @foreach($filter['options'] as $value => $label)
                                    <option value="{{ $value }}" {{ $filter['value'] === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </flux:select>
                        @elseif($filter['type'] === 'date')
                            <flux:input 
                                name="{{ $filter['name'] }}" 
                                type="date"
                                placeholder="{{ $filter['placeholder'] }}"
                                value="{{ $filter['value'] }}"
                                class="w-full"
                            />
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            <flux:button type="submit" variant="primary" class="w-full sm:w-auto">Cari</flux:button>
            
            @if($clearUrl && (request($searchName) || collect($filters)->where('value', '!=', '')->count() > 0))
                <a href="{{ $clearUrl }}" class="w-full sm:w-auto px-4 py-2 text-sm text-center text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    Hapus Filter
                </a>
            @endif
        </div>
        
        <!-- Active Filters Display -->
        @php
            $hasActiveFilters = request($searchName) || collect($filters)->where('value', '!=', '')->count() > 0;
        @endphp
        
        @if($hasActiveFilters)
            <div class="pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                <div class="flex flex-wrap gap-2">
                    <span class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 w-full sm:w-auto">Filter aktif:</span>
                    
                    @if(request($searchName))
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400 rounded-full">
                            Pencarian: "{{ request($searchName) }}"
                        </span>
                    @endif
                    
                    @foreach($filters as $filter)
                        @if($filter['value'])
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium {{ $filter['badgeColor'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }} rounded-full">
                                {{ $filter['label'] }}: {{ $filter['displayValue'] ?? $filter['value'] }}
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </form>
</div>
