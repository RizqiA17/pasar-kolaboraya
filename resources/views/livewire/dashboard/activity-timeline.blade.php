<div
    class="relative overflow-hidden rounded-xl bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700">
    <div class="absolute top-0 left-0 w-20 h-20 opacity-10">
        <img src="{{ Storage::url('web/ASET VISUAL/WEBP/4.webp') }}" alt="" class="w-full h-full object-contain">
    </div>

    <div class="relative z-10 p-6">
        <div class="flex items-center justify-between mb-4 gap-2">
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-slate-200">Aktivitas
                    Terbaru</h3>
                <p class="text-gray-700 dark:text-slate-300 text-sm">Lihat apa yang terjadi di
                    komunitas Anda</p>
            </div>
            <div class="w-12 h-12 min-w-12 bg-secondary-green rounded-lg flex items-center justify-center shadow-lg">
                <flux:icon.clock class="size-6 text-white" />
            </div>
        </div>

        <div class="relative">
            <div class="space-y-4">
                @forelse($activities as $activity)
                    <div class="relative">
                        <!-- Timeline Line -->
                        <div
                            class="absolute max-sm:hidden left-6 top-8 bottom-0 w-0.5 bg-gradient-to-b from-gray-200 to-transparent dark:from-gray-700">
                        </div>

                        <div class="flex items-start relative">
                            <!-- Enhanced Icon -->
                            <div class="relative max-sm:hidden mt-1">
                                <div @class([
                                    'flex h-12 w-12 items-center justify-center rounded-2xl shadow-lg duration-300',
                                    'bg-secondary-green' => $activity->type === 'collective_action',
                                    'bg-accent-red' => $activity->type === 'ecosystem',
                                    'bg-primary-blue' => $activity->type === 'ecosystem_contribution',
                                    'bg-accent-orange' => $activity->type === 'collective_action_contribution',
                                ])>
                                    @if ($activity->type === 'collective_action')
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
                                    'bg-secondary-green' => $activity->type === 'collective_action',
                                    'bg-accent-red' => $activity->type === 'ecosystem',
                                    'bg-primary-blue' => $activity->type === 'ecosystem_contribution',
                                    'bg-accent-orange' => $activity->type === 'collective_action_contribution',
                                ])></div>
                            </div>

                            <!-- Enhanced Content -->
                            <div class="sm:ml-6 flex-grow w-full min-w-0">
                                <div
                                    class="bg-neutral-50 dark:bg-zinc-800 rounded-2xl p-5 dark:border-t dark:border-slate-700 shadow-sm min-h-[140px]">
                                    <div class="flex items-start justify-between h-full gap-4 flex-col">
                                        <div class="flex-1 flex flex-col justify-between w-full min-w-0">
                                            <div>
                                                <h4
                                                    class="text-lg font-semibold text-gray-900 dark:text-white leading-tight break-words overflow-hidden line-clamp-2">
                                                    {{ $activity->title }}
                                                </h4>

                                                <p class="mb-3 text-gray-700 dark:text-slate-300 text-sm w-full truncate min-w-0">
                                                    {{ $activity->description }}
                                                </p>

                                                <div class="flex items-center max-sm:items-start sm:justify-between gap-2 mb-3 flex-wrap">
                                                    @if ($activity->type === 'collective_action')
                                                        <span
                                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-secondary-green/50 dark:text-emerald-200">
                                                            <flux:icon.rocket-launch class="w-3 h-3 mr-1.5" />
                                                            Aksi Kolektif
                                                        </span>
                                                    @elseif($activity->type === 'ecosystem')
                                                        <span
                                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-accent-red/50 dark:text-red-200">
                                                            <flux:icon.building-office class="w-3 h-3 mr-1.5" />
                                                            Ekosistem
                                                        </span>
                                                    @elseif($activity->type === 'ecosystem_contribution')
                                                        <span
                                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-sky-100 text-sky-800 dark:bg-primary-blue/50 dark:text-sky-200">
                                                            <flux:icon.hand-raised class="w-3 h-3 mr-1.5" />
                                                            Kontribusi Ekosistem
                                                        </span>
                                                    @elseif($activity->type === 'collective_action_contribution')
                                                        <span
                                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-accent-orange/50 dark:text-orange-200">
                                                            <flux:icon.heart class="w-3 h-3 mr-1.5" />
                                                            Kontribusi Aksi Kolektif
                                                        </span>
                                                    @endif

                                                    <span
                                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                                        <flux:icon.clock class="w-3 h-3 mr-1.5" />
                                                        {{ Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                                    </span>
                                                </div>

                                                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                                                    @if ($activity->type === 'collective_action')
                                                        Aksi kolektif baru telah dibuat dan melibatkan ekosistem Anda
                                                    @elseif($activity->type === 'ecosystem')
                                                        Anda telah bergabung dengan ekosistem baru
                                                    @elseif($activity->type === 'ecosystem_contribution')
                                                        Anda telah mengajukan kontribusi untuk ekosistem
                                                        {{ $activity->title ?? 'ini' }}
                                                        @if (isset($activity->contribution_description))
                                                            <br><span
                                                                class="text-xs text-gray-400 mt-1 block">{{ Str::limit($activity->contribution_description, 100) }}</span>
                                                        @endif
                                                    @elseif($activity->type === 'collective_action_contribution')
                                                        Anda telah mengajukan kontribusi untuk aksi kolektif
                                                        {{ $activity->collectiveAction->title ?? 'ini' }}
                                                        @if (isset($activity->contribution_description))
                                                            <br><span
                                                                class="text-xs text-gray-400 mt-1 block">{{ Str::limit($activity->contribution_description, 100) }}</span>
                                                        @endif
                                                    @endif
                                                </p>

                                                @if (in_array($activity->type, ['ecosystem_contribution', 'collective_action_contribution']))
                                                    <div class="mt-3">
                                                        @php
                                                            $statusConfig = [
                                                                'offered' => [
                                                                    'class' =>
                                                                        'bg-yellow-100 text-yellow-800 dark:bg-secondary-yellow/50 dark:text-yellow-200',
                                                                    'label' => 'Menunggu Persetujuan',
                                                                ],
                                                                'accepted' => [
                                                                    'class' =>
                                                                        'bg-emerald-100 text-emerald-800 dark:bg-secondary-green/50 dark:text-emerald-200',
                                                                    'label' => 'Diterima',
                                                                ],
                                                                'completed' => [
                                                                    'class' =>
                                                                        'bg-blue-100 text-blue-800 dark:bg-primary-blue/50 dark:text-blue-200',
                                                                    'label' => 'Selesai',
                                                                ],
                                                                'declined' => [
                                                                    'class' =>
                                                                        'bg-red-100 text-red-800 dark:bg-accent-red/50 dark:text-red-200',
                                                                    'label' => 'Ditolak',
                                                                ],
                                                            ];
                                                            $config =
                                                                $statusConfig[$activity->status] ??
                                                                $statusConfig['offered'];
                                                        @endphp
                                                        <span
                                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $config['class'] }}">
                                                            {{ $config['label'] }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Action Button -->
                                        <div class="w-full">
                                            @if ($activity->type === 'collective_action')
                                                <a href="{{ route('collective-action.show', $activity->id) }}"
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-secondary-green hover:bg-emerald-600 rounded-md transition-colors whitespace-nowrap">
                                                    Lihat Aksi Kolektif
                                                    <flux:icon.arrow-right class="w-4 h-4 ml-2" />
                                                </a>
                                            @elseif($activity->type === 'ecosystem')
                                                <a href="{{ route('ecosystem.dashboard', $activity->id) }}"
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-accent-red hover:bg-red-600 rounded-md transition-colors whitespace-nowrap">
                                                    Lihat Ekosistem
                                                    <flux:icon.arrow-right class="w-4 h-4 ml-2" />
                                                </a>
                                            @elseif($activity->type === 'ecosystem_contribution')
                                                <a href="{{ route('ecosystem.dashboard', $activity->ecosystem_id) }}"
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-primary-blue hover:bg-sky-600 rounded-md transition-colors whitespace-nowrap">
                                                    Lihat Ekosistem
                                                    <flux:icon.arrow-right class="w-4 h-4 ml-2" />
                                                </a>
                                            @elseif($activity->type === 'collective_action_contribution')
                                                <a href="{{ route('collective-action.show', $activity->collective_action_id) }}"
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-accent-orange hover:bg-orange-600 rounded-md transition-colors whitespace-nowrap">
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
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <flux:icon.clock class="w-10 h-10 text-gray-400 dark:text-gray-500" />
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Aktivitas</h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Mulai berpartisipasi dalam aksi kolektif dan
                            bergabung dengan ekosistem untuk melihat aktivitas di sini</p>
                        <div class="flex items-center justify-center gap-4">
                            <a href="{{ route('ecosystem.browse') }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-blue hover:bg-primary-blue/90 rounded-lg transition-colors">
                                <flux:icon.building-office class="w-4 h-4 mr-2" />
                                Lihat Ekosistem
                            </a>    
                            <a href="{{ route('collective-action.browse') }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-secondary-green hover:bg-secondary-green/90 rounded-lg transition-colors">
                                <flux:icon.rocket-launch class="w-4 h-4 mr-2" />
                                Lihat Aksi Kolektif
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
