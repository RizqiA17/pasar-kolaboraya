<div class="space-y-4">
    @forelse($activities as $activity)
        <div class="group relative">
            <!-- Timeline Line -->
            <div class="absolute left-6 top-8 bottom-0 w-0.5 bg-gradient-to-b from-gray-200 to-transparent dark:from-gray-700"></div>
            
            <div class="flex items-start relative">
                <!-- Enhanced Icon -->
                <div class="relative mt-1">
                    <div @class([
                        'flex h-12 w-12 items-center justify-center rounded-2xl shadow-lg transition-all duration-300 group-hover:scale-110',
                        'bg-gradient-to-br from-green-400 to-emerald-500' => $activity->type === 'collective_action',
                        'bg-gradient-to-br from-purple-400 to-pink-500' => $activity->type === 'ecosystem',
                        'bg-gradient-to-br from-blue-400 to-cyan-500' => $activity->type === 'ecosystem_contribution',
                        'bg-gradient-to-br from-orange-400 to-red-500' => $activity->type === 'collective_action_contribution',
                    ])>
                        @if($activity->type === 'collective_action')
                            <flux:icon.rocket-launch class="h-6 w-6 text-white" />
                        @elseif($activity->type === 'ecosystem')
                            <flux:icon.building-office class="h-6 w-6 text-white" />
                        @elseif($activity->type === 'ecosystem_contribution')
                            <flux:icon.hand-raised class="h-6 w-6 text-white" />
                        @elseif($activity->type === 'collective_action_contribution')
                            <flux:icon.heart class="h-6 w-6 text-white" />
                        @endif
                    </div>
                    
                    <!-- Pulse Effect -->
                    <div @class([
                        'absolute inset-0 rounded-2xl animate-ping opacity-20',
                        'bg-gradient-to-br from-green-400 to-emerald-500' => $activity->type === 'collective_action',
                        'bg-gradient-to-br from-purple-400 to-pink-500' => $activity->type === 'ecosystem',
                        'bg-gradient-to-br from-blue-400 to-cyan-500' => $activity->type === 'ecosystem_contribution',
                        'bg-gradient-to-br from-orange-400 to-red-500' => $activity->type === 'collective_action_contribution',
                    ])></div>
                </div>

                <!-- Enhanced Content -->
                <div class="ml-6 flex-1">
                    <div class="bg-white dark:bg-zinc-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300 group-hover:border-blue-200 dark:group-hover:border-blue-700 min-h-[140px]">
                        <div class="flex items-start justify-between h-full max-sm:flex-col">
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors leading-tight">
                                        {{ $activity->title }}
                                    </h4>
                                    
                                    <div class="flex items-center gap-2 mb-3 flex-wrap">
                                        @if($activity->type === 'collective_action')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                <flux:icon.rocket-launch class="w-3 h-3 mr-1.5" />
                                                Aksi Kolektif
                                            </span>
                                        @elseif($activity->type === 'ecosystem')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                                <flux:icon.building-office class="w-3 h-3 mr-1.5" />
                                                Ekosistem
                                            </span>
                                        @elseif($activity->type === 'ecosystem_contribution')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                <flux:icon.hand-raised class="w-3 h-3 mr-1.5" />
                                                Kontribusi Ekosistem
                                            </span>
                                        @elseif($activity->type === 'collective_action_contribution')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300">
                                                <flux:icon.heart class="w-3 h-3 mr-1.5" />
                                                Kontribusi Aksi Kolektif
                                            </span>
                                        @endif
                                        
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                            <flux:icon.clock class="w-3 h-3 mr-1.5" />
                                            {{ Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                                        @if($activity->type === 'collective_action')
                                            Aksi kolektif baru telah dibuat dan melibatkan ekosistem Anda
                                        @elseif($activity->type === 'ecosystem')
                                            Anda telah bergabung dengan ekosistem baru
                                        @elseif($activity->type === 'ecosystem_contribution')
                                            Anda telah mengajukan kontribusi untuk ekosistem {{ $activity->ecosystem_title ?? 'ini' }}
                                            @if(isset($activity->contribution_description))
                                                <br><span class="text-xs text-gray-400 mt-1 block">{{ Str::limit($activity->contribution_description, 100) }}</span>
                                            @endif
                                        @elseif($activity->type === 'collective_action_contribution')
                                            Anda telah mengajukan kontribusi untuk aksi kolektif {{ $activity->collectiveAction->title ?? 'ini' }}
                                            @if(isset($activity->contribution_description))
                                                <br><span class="text-xs text-gray-400 mt-1 block">{{ Str::limit($activity->contribution_description, 100) }}</span>
                                            @endif
                                        @endif
                                    </p>
                                    
                                    @if(in_array($activity->type, ['ecosystem_contribution', 'collective_action_contribution']))
                                        <div class="mt-3">
                                            @php
                                                $statusConfig = [
                                                    'offered' => ['class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300', 'label' => 'Menunggu Persetujuan'],
                                                    'accepted' => ['class' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300', 'label' => 'Diterima'],
                                                    'completed' => ['class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300', 'label' => 'Selesai'],
                                                    'declined' => ['class' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300', 'label' => 'Ditolak']
                                                ];
                                                $config = $statusConfig[$activity->status] ?? $statusConfig['offered'];
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $config['class'] }}">
                                                {{ $config['label'] }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Action Button -->
                            <div class="sm:ml-4 flex-shrink-0 max-sm:w-full max-sm:mt-4">
                                @if($activity->type === 'collective_action')
                                    <a href="{{ route('collective-action.show', $activity->id) }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-green-600 bg-green-50 hover:bg-green-100 dark:text-green-400 dark:bg-green-900/30 dark:hover:bg-green-900/50 rounded-lg transition-colors whitespace-nowrap">
                                        Lihat Aksi Kolektif
                                        <flux:icon.arrow-right class="w-4 h-4 ml-2" />
                                    </a>
                                @elseif($activity->type === 'ecosystem')
                                    <a href="{{ route('ecosystem.dashboard', $activity->id) }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 dark:text-purple-400 dark:bg-purple-900/30 dark:hover:bg-purple-900/50 rounded-lg transition-colors whitespace-nowrap">
                                        Lihat Ekosistem
                                        <flux:icon.arrow-right class="w-4 h-4 ml-2" />
                                    </a>
                                @elseif($activity->type === 'ecosystem_contribution')
                                    <a href="{{ route('ecosystem.dashboard', $activity->ecosystem_id) }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 rounded-lg transition-colors whitespace-nowrap">
                                        Lihat Ekosistem
                                        <flux:icon.arrow-right class="w-4 h-4 ml-2" />
                                    </a>
                                @elseif($activity->type === 'collective_action_contribution')
                                    <a href="{{ route('collective-action.show', $activity->collective_action_id) }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-orange-600 bg-orange-50 hover:bg-orange-100 dark:text-orange-400 dark:bg-orange-900/30 dark:hover:bg-orange-900/50 rounded-lg transition-colors whitespace-nowrap">
                                        Lihat Aksi Kolektif
                                        <flux:icon.arrow-right class="w-4 h-4 ml-2" />
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <!-- Enhanced Empty State -->
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <flux:icon.clock class="w-10 h-10 text-gray-400 dark:text-gray-500" />
            </div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Aktivitas</h4>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Mulai berpartisipasi dalam aksi kolektif dan bergabung dengan ekosistem untuk melihat aktivitas di sini</p>
            <div class="flex items-center justify-center gap-4">
                <a href="{{ route('collective-action.browse') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-600 bg-green-50 hover:bg-green-100 dark:text-green-400 dark:bg-green-900/30 dark:hover:bg-green-900/50 rounded-lg transition-colors">
                    <flux:icon.rocket-launch class="w-4 h-4 mr-2" />
                    Lihat Aksi Kolektif
                </a>
                <a href="{{ route('ecosystem.browse') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 dark:text-purple-400 dark:bg-purple-900/30 dark:hover:bg-purple-900/50 rounded-lg transition-colors">
                    <flux:icon.building-office class="w-4 h-4 mr-2" />
                    Lihat Ekosistem
                </a>
            </div>
        </div>
    @endforelse
</div>
