@props([
    'flexSize' => null,
    'title' => null,
    'description' => null
])
<div
    class="flex flex-col gap-4 
    @if ($flexSize) @if ($flexSize == '2xl') 2xl:flex-row 2xl:items-center @elseif ($flexSize == 'xl') xl:flex-row xl:items-center @elseif($flexSize == 'lg') lg:flex-row lg:items-center @elseif($flexSize == 'md') md:flex-row md:items-center @endif
@else
sm:flex-row sm:items-center @endif sm:justify-between">
    <div>
        <h1
            class="mb-2 text-xl font-bold text-transparent md:text-3xl bg-primary-blue dark:bg-secondary-green bg-clip-text">
            {{ $title }}</h1>
        <p class="max-w-2xl text-sm text-gray-600 dark:text-gray-300">{{ $description }}</p>
    </div>
    {{ $slot }}
</div>
