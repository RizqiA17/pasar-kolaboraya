<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <div class="flex flex-col">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Koneksi</h3>
                        <div
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900">
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                            <livewire:dashboard.stats type="connections" />
                        </p>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Total koneksi yang terhubung</p>
                    </div>
                </div>
            </div>

            <div
                class="overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <div class="flex flex-col">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Kolaborasi</h3>
                        <div
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900">
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                            <livewire:dashboard.stats type="collaborations" />
                        </p>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Total kolaborasi aktif</p>
                    </div>
                </div>
            </div>

            <div
                class="overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <div class="flex flex-col">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Aksi</h3>
                        <div
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900">
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
            </div>

        </div>
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div
                class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-800">
                <div class="border-b border-neutral-200 p-6 dark:border-neutral-700">
                    <h3 class="text-base font-semibold text-neutral-900 dark:text-white">Aktivitas Terbaru</h3>
                </div>
                <div class="p-6">
                    <livewire:dashboard.activity-timeline />
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
    </div> --}}
</x-layouts.app>
