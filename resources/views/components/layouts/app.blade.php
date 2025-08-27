<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="z-[1]">
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
