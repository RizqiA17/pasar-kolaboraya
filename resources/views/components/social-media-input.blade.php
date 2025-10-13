<!-- Social Media List -->
<div class="space-y-4">
    @foreach($socialMediaItems as $index => $item)
        <div class="social-media-item bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 p-4">
            <!-- Header with Platform Info and Remove Button -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <!-- Platform Icon -->
                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                        {!! \App\Helpers\SocialLinkFormatter::getPlatformIcon($item['platform'] ?? '') !!}
                    </div>
                    
                    <!-- Platform Label -->
                    <div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            @php
                                $platforms = \App\Helpers\SocialLinkFormatter::getAvailablePlatforms();
                                $platformLabel = collect($platforms)->firstWhere('value', $item['platform'])['label'] ?? ucfirst($item['platform']);
                            @endphp
                            {{ $platformLabel }}
                        </span>
                    </div>
                </div>
                
                <!-- Remove Button -->
                <button type="button" 
                        wire:click="removeSocialMedia({{ $index }})"
                        class="p-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Input Fields -->
            <div class="space-y-4">
                <!-- Username Input -->
                <div>
                    <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-2">
                        Username
                    </label>
                    <input type="text" 
                           wire:model="socialMediaItems.{{ $index }}.username"
                           placeholder="{{ \App\Helpers\SocialLinkFormatter::getPlaceholderForPlatform($item['platform'] ?? '') }}"
                           class="w-full px-3 py-2 text-sm bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md text-slate-700 dark:text-slate-300 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           @if($item['use_custom_link'] ?? false) disabled @endif>
                </div>
                
                <!-- Custom Link Toggle -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" 
                                   wire:click="toggleCustomLink({{ $index }})"
                                   @if($item['use_custom_link'] ?? false) checked @endif
                                   class="sr-only">
                            <div class="block bg-slate-300 dark:bg-slate-600 w-10 h-5 rounded-full transition-colors duration-200 {{ $item['use_custom_link'] ? 'bg-blue-500' : '' }}"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition-transform duration-200 ease-in-out {{ $item['use_custom_link'] ? 'translate-x-5' : '' }}"></div>
                        </div>
                        <span class="text-sm text-slate-600 dark:text-slate-400">Gunakan Custom Link</span>
                    </label>
                </div>
                
                <!-- Custom Link Input -->
                @if($item['use_custom_link'] ?? false)
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-2">
                            Custom Link
                        </label>
                        <input type="url" 
                               wire:model="socialMediaItems.{{ $index }}.custom_link"
                               placeholder="{{ \App\Helpers\SocialLinkFormatter::getPlaceholderForPlatform($item['platform'] ?? '', true) }}"
                               class="w-full px-3 py-2 text-sm bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md text-slate-700 dark:text-slate-300 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                @endif
                
                <!-- Generated URL Preview -->
                <div class="text-xs text-slate-500 dark:text-slate-400">
                    <span class="font-medium">Preview:</span>
                    <a href="{{ \App\Helpers\SocialLinkFormatter::generateProfileUrl($item['platform'] ?? '', $item['username'] ?? null, $item['custom_link'] ?? null) }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 ml-1 break-all">
                        {{ \App\Helpers\SocialLinkFormatter::generateProfileUrl($item['platform'] ?? '', $item['username'] ?? null, $item['custom_link'] ?? null) }}
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>