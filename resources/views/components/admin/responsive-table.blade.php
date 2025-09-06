@props([
    'headers' => [],
    'data' => [],
    'mobileCardView' => true,
    'emptyMessage' => 'Tidak ada data ditemukan.',
    'emptyIcon' => 'clipboard-document-list'
])

<div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
    @if(count($data) > 0)
        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        @foreach($headers as $header)
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">
                                {{ $header['label'] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($data as $row)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            @foreach($headers as $header)
                                <td class="px-6 py-4">
                                    {!! $row[$header['key']] ?? '' !!}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($mobileCardView)
            <!-- Mobile Card View -->
            <div class="lg:hidden">
                <div class="p-4 space-y-4">
                    @foreach($data as $row)
                        <div class="bg-white dark:bg-slate-700/50 rounded-xl p-4 border border-slate-200 dark:border-slate-600 shadow-sm">
                            @foreach($headers as $header)
                                @if(isset($row[$header['key']]))
                                    <div class="mb-3 last:mb-0">
                                        <div class="text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">
                                            {{ $header['label'] }}
                                        </div>
                                        <div class="text-sm text-slate-900 dark:text-slate-100">
                                            {!! $row[$header['key']] !!}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @else
        <div class="p-8 text-center">
            <flux:icon.{{ $emptyIcon }} class="size-16 text-gray-400 mx-auto mb-4" />
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">{{ $emptyMessage }}</h3>
        </div>
    @endif
</div>