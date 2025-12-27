<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold sm:text-3xl text-primary-blue dark:text-secondary-green">
                Pengaturan Sistem
            </h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-slate-300 sm:text-base">
                Kelola pengaturan global sistem untuk mengontrol akses dan fitur.
            </p>
        </div>

        <div class="text-xs text-gray-500 sm:text-sm dark:text-slate-400">
            Terakhir diperbarui: {{ now()->format('d M Y H:i') }}
        </div>
    </div>

    <!-- Settings -->
    <div
        class="p-4 space-y-4 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">

        <!-- Login -->
        <div
            class="flex flex-col p-4 sm:flex-row sm:items-center sm:justify-between bg-slate-50 dark:bg-slate-700/50 rounded-xl">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">
                    Status Login
                </h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Kontrol apakah pengguna dapat masuk ke sistem.
                </p>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="settings.login_enabled" class="sr-only peer">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer
                    peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px]
                    after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all
                    peer-checked:bg-primary-blue">
                </div>
            </label>
        </div>

        <!-- Registration -->
        <div
            class="flex flex-col p-4 sm:flex-row sm:items-center sm:justify-between bg-slate-50 dark:bg-slate-700/50 rounded-xl">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">
                    Registrasi Pengguna Baru
                </h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Kontrol apakah pengguna baru dapat mendaftar ke sistem.
                </p>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="settings.registration_enabled" class="sr-only peer">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer
                    peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px]
                    after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all
                    peer-checked:bg-secondary-green">
                </div>
            </label>
        </div>

        <!-- Connections -->
        <div
            class="flex flex-col p-4 sm:flex-row sm:items-center sm:justify-between bg-slate-50 dark:bg-slate-700/50 rounded-xl">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">
                    Koneksi Antar Pengguna
                </h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Kontrol fitur koneksi antar pengguna.
                </p>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="settings.connections_enabled" class="sr-only peer">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer
                    peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px]
                    after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all
                    peer-checked:bg-primary-blue">
                </div>
            </label>
        </div>

        <!-- Collaborations -->
        <div
            class="flex flex-col p-4 sm:flex-row sm:items-center sm:justify-between bg-slate-50 dark:bg-slate-700/50 rounded-xl">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">
                    Kolaborasi & Ekosistem
                </h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Akses fitur kolaborasi dan ekosistem.
                </p>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="settings.collaborations_enabled" class="sr-only peer">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer
                    peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px]
                    after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all
                    peer-checked:bg-neutral-purple">
                </div>
            </label>
        </div>

        <!-- User Actions -->
        <div
            class="flex flex-col p-4 sm:flex-row sm:items-center sm:justify-between bg-slate-50 dark:bg-slate-700/50 rounded-xl">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">
                    Aksi Kolektif & Bersama
                </h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Kontrol fitur aksi kolektif dan aksi bersama.
                </p>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="settings.user_actions_enabled" class="sr-only peer">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer
                    peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px]
                    after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all
                    peer-checked:bg-neutral-orange">
                </div>
            </label>
        </div>
    </div>

    <!-- Current Status -->
    <div
        class="p-4 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
        <h3 class="mb-4 text-lg font-semibold text-primary-blue dark:text-secondary-green">
            Status Saat Ini
        </h3>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($settings as $key => $value)
                <div class="p-4 text-center bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                    <p class="text-sm font-semibold text-primary-blue dark:text-secondary-green">
                        {{ str_replace('_', ' ', ucfirst($key)) }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-slate-400">
                        {{ $value ? 'Diaktifkan' : 'Dinonaktifkan' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

</div>
