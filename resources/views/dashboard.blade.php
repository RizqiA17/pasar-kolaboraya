<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <a href="{{ route('connections') . '?tab=list' }}"
                class="hover:scale-105 hover:shadow-lg transition-all ease-in-out duration-300 overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800 relative">
                {{-- SVG Accent for Connections --}}
                <x-svg-accent position="top-right" size="w-16 h-16" opacity="opacity-5" />
                <div class="flex flex-col">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900 text-neutral-900 dark:text-white">Koneksi</h3>
                        <div
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900">
                            <flux:icon.link class="size-5" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                            <livewire:dashboard.stats type="connections" />
                        </p>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Total koneksi yang terhubung</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('collaborations') }}"
                class="hover:scale-105 hover:shadow-lg transition-all ease-in-out duration-300 overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800 relative">
                {{-- SVG Accent for Collaborations --}}
                <x-svg-accent position="top-left" size="w-16 h-16" opacity="opacity-5" />
                <div class="flex flex-col">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Kolaborasi</h3>
                        <div
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900">
                            <flux:icon.users class="size-5" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                            <livewire:dashboard.stats type="collaborations" />
                        </p>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Total kolaborasi aktif</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('events') }}"
                class="hover:scale-105 hover:shadow-lg transition-all ease-in-out duration-300 overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800 relative">
                {{-- SVG Accent for Events --}}
                <x-svg-accent position="bottom-right" size="w-16 h-16" opacity="opacity-5" />
                <div class="flex flex-col">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aksi</h3>
                        <div
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900">
                            <flux:icon.user-group class="size-5" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                            <livewire:dashboard.stats type="events" />
                        </p>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Total aksi yang diikuti
                        </p>
                    </div>
                </div>
            </a>

        </div>
        <!-- Profile Section -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <livewire:dashboard.profile-progress />
            <livewire:dashboard.profile-summary />
            <livewire:dashboard.connection-quality />
        </div>

        <!-- Activity Section -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div
                class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-800 relative">
                {{-- SVG Accent for Activity Timeline --}}
                <x-svg-accent position="center-left" size="w-20 h-20" opacity="opacity-5" />
                <x-svg-accent position="center-right" size="w-16 h-16" opacity="opacity-5" />
                
                <div class="border-b border-neutral-200 p-6 dark:border-neutral-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
                </div>
                <div class="p-6">
                    <livewire:dashboard.activity-timeline />
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
