<x-layouts.app.header :title="$title ?? null">
    <flux:main class="z-[1] pt-4">
        {{ $slot }}
    </flux:main>
</x-layouts.app.header>
