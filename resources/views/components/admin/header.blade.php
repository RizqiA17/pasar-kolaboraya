<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1
            class="mb-2 text-xl font-bold text-transparent md:text-3xl bg-primary-blue dark:bg-secondary-green bg-clip-text">
            {{$title}}</h1>
        <p class="max-w-2xl text-sm text-gray-600 dark:text-gray-300">{{$description}}</p>
    </div>
    {{ $slot }}
</div>
