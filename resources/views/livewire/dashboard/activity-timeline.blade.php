<div class="space-y-8" wire:poll.10s>
    @forelse($activities as $activity)
        <div class="flex items-start">
            <!-- Icon -->
            <div class="relative mt-1">
                <div @class([
                    'flex h-8 w-8 items-center justify-center rounded-lg',
                    'bg-blue-100 dark:bg-blue-900' => $activity->type === 'event',
                    'bg-purple-100 dark:bg-purple-900' => $activity->type === 'collaboration',
                ])>
                    @if($activity->type === 'event')
                        <flux:icon.calendar class="h-5 w-5 text-blue-600 dark:text-blue-300" />
                    @else
                        <flux:icon.user-group class="h-5 w-5 text-purple-600 dark:text-purple-300" />
                    @endif
                </div>
                <div class="absolute -bottom-6 left-4 h-6 w-px bg-neutral-200 dark:bg-neutral-700"></div>
            </div>

            <!-- Content -->
            <div class="ml-4">
                <p class="text-sm text-neutral-600 dark:text-neutral-300">
                    {{ $activity->title }}
                    <span class="text-neutral-400 dark:text-neutral-500">·</span>
                    <span class="text-neutral-400 dark:text-neutral-500">{{ $activity->created_at->diffForHumans() }}</span>
                </p>
                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    @if($activity->type === 'event')
                        Aksi baru ditambahkan
                    @else
                        Kolaborasi baru dibuat
                    @endif
                </p>
            </div>
        </div>
    @empty
        <div class="text-center text-sm text-neutral-500 dark:text-neutral-400">
            Belum ada aktivitas
        </div>
    @endforelse
</div>
