@props(['friend'])

@php
    $user = App\Models\User::find($friend['id']);
@endphp

<a href="{{ route('profile.view', $friend['id']) }}"
    class="block min-w-0 w-full bg-white dark:bg-slate-800 rounded-xl dark:border-t dark:border-slate-700 shadow-lg hover:shadow-lg transition-shadow duration-200 relative hover:scale-105 transition-transform"
    data-user-id="{{ $friend['id'] }}">

    <x-svg-accent position="top-right" size="w-6 h-6" opacity="opacity-5" />

    {{-- Cover Image --}}
    <x-ui.banner :user="$user" height="h-24" class="rounded-t-xl" />

    <div class="p-4 min-w-0">
        {{-- Avatar --}}
        <div class="relative -mt-12 mb-3 flex gap-4 items-end min-w-0 w-full">
            <x-ui.avatar :user="$user" size="xl" class="ring-4 rounded-full ring-white dark:ring-slate-800" />

            <div
                class="min-w-0 px-2 py-1 -ml-0.5 rounded-full text-sky-800 dark:text-sky-200 text-sm font-medium bg-sky-100 dark:bg-primary-blue/50">
                <p class="w-full min-w-0 truncate">{{ $user->assigned_role }}</p>
            </div>



        </div>

        <div class="flex flex-col min-w-0">
            <div class="text-xl font-bold text-gray-900 dark:text-slate-200 mb-1 cursor-pointer"
                wire:click="$dispatch('showProfileCard', { userId: {{ $friend['id'] }} })">
                {{ $friend['name'] }}
            </div>
        </div>
    </div>
</a>
