
    <flux:dropdown position="top" align="center" class="relative z-10">
        <flux:button
            class="group size-10! bg-white/60! hover:bg-white/80! dark:bg-slate-800/60! dark:hover:bg-slate-800/80! backdrop-blur-sm rounded-full! shadow-lg hover:shadow-xl transition-all duration-300 outline-2 outline-white/20 dark:outline-slate-700/50 p-0!">
            <x-ui.avatar :user="auth()->user()" size="md" class="size-10!" />
        </flux:button>
        <div
            class="absolute w-3 h-3 bg-green-500 border-2 border-white rounded-full -bottom-1 -right-1 dark:border-slate-900">
        </div>

        <flux:menu
            class="mt-2 bg-white/90! dark:bg-slate-800/90! backdrop-blur-xl border border-white/20! dark:border-slate-700/50! shadow-2xl shadow-blue-500/20! rounded-2xl overflow-hidden">
            <flux:menu.radio.group>
                <div class="p-4">
                    <div class="flex items-center gap-3">
                        @if (auth()->user()->profile?->profile_photo)
                            <img class="relative flex w-12 h-12 overflow-hidden shrink-0 rounded-xl"
                                src="{{ asset('storage/' . auth()->user()->profile->profile_photo) }}" alt="">
                        @else
                            <span class="relative flex w-12 h-12 overflow-hidden shrink-0 rounded-xl">
                                <span
                                    class="flex items-center justify-center w-full h-full text-lg font-semibold text-white shadow-lg rounded-xl bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>
                        @endif

                        <div class="grid flex-1 text-start">
                            <span
                                class="font-semibold truncate text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</span>
                            <span
                                class="text-sm truncate text-slate-500 dark:text-slate-400">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <div class="flex items-center gap-3 px-4 py-3">
                @if ($user->is_ecosystem_builder)
                    <span
                        class="inline-flex px-2 py-1 text-xs font-semibold text-purple-800 bg-purple-100 rounded-full dark:bg-purple-900/20 dark:text-purple-400">
                        Ecosystem Builder
                    </span>
                @elseif($user->assigned_role)
                    <span
                        class="inline-flex px-2 py-1 text-xs font-semibold text-indigo-800 bg-indigo-100 rounded-full dark:bg-indigo-900/20 dark:text-indigo-400">
                        {{ $user->assigned_role }}
                    </span>
                @else
                    <span
                        class="inline-flex px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full dark:bg-gray-900/20 dark:text-gray-400">
                        Belum Dipilih
                    </span>
                @endif
            </div>

            <!-- Active Session Information -->
            @if (auth()->user()->hasActivePasarKolaboraya())
                <div class="px-4 py-3 border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900/20">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full dark:bg-blue-800">
                            <flux:icon.cube class="w-4 h-4 text-blue-600 dark:text-blue-300" />
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-200">
                                Sesi Aktif
                            </h4>
                            <p class="text-xs text-blue-600 dark:text-blue-300">
                                {{ auth()->user()->activePasarKolaboraya->name }}
                            </p>
                            <p class="text-xs text-blue-500 dark:text-blue-400">
                                {{ auth()->user()->activePasarKolaboraya->acceptedUsers->count() }} anggota
                            </p>
                        </div>
                        <flux:button href="{{ route('pasar-kolaboraya.select') }}" size="xs"
                            {{-- variant="secondary" --}}>
                            Ganti
                        </flux:button>
                    </div>
                </div>
            @elseif(auth()->user()->hasPasarKolaborayas())
                <div class="px-4 py-3 border-l-4 border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20">
                    <div class="flex items-center space-x-3">
                        <div
                            class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-full dark:bg-yellow-800">
                            <flux:icon.exclamation-triangle class="w-4 h-4 text-yellow-600 dark:text-yellow-300" />
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">
                                Pilih Sesi
                            </h4>
                            <p class="text-xs text-yellow-600 dark:text-yellow-300">
                                {{ auth()->user()->acceptedPasarKolaborayas->count() }} Pasar Kolaboraya
                                tersedia
                            </p>
                        </div>
                        <flux:button href="{{ route('pasar-kolaboraya.select') }}" size="xs" variant="primary">
                            Pilih
                        </flux:button>
                    </div>
                </div>
            @else
                <div class="px-4 py-3 border-l-4 border-gray-400 bg-gray-50 dark:bg-gray-800/20">
                    <div class="flex items-center space-x-3">
                        <div
                            class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-700">
                            <flux:icon.information-circle class="w-4 h-4 text-gray-600 dark:text-gray-300" />
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                Belum Bergabung
                            </h4>
                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                Hubungi admin untuk diundang
                            </p>
                        </div>
                        <flux:button href="{{ route('pasar-kolaboraya.join-request') }}" size="xs"
                            {{-- variant="secondary" --}}>
                            Minta
                        </flux:button>
                    </div>
                </div>
            @endif

            <div class="h-px bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-600 to-transparent">
            </div>

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" icon="user" wire:navigate
                    class="px-4 py-3 transition-all duration-200 text-slate-700 hover:text-blue-600 hover:bg-blue-50 dark:text-slate-200 dark:hover:text-blue-400 dark:hover:bg-blue-900/20">
                    {{ __('Profile') }}</flux:menu.item>
                @if (auth()->user()->isSuperAdmin())
                    <flux:menu.item :href="route('admin.dashboard')" icon="shield-check" wire:navigate
                        class="px-4 py-3 transition-all duration-200 text-slate-700 hover:text-blue-600 hover:bg-blue-50 dark:text-slate-200 dark:hover:text-blue-400 dark:hover:bg-blue-900/20">
                        {{ __('Admin') }}</flux:menu.item>
                @endif
            </flux:menu.radio.group>

            <div class="h-px bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-600 to-transparent">
            </div>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                    class="w-full px-4 py-3 transition-all duration-200 text-slate-700 hover:text-red-600 hover:bg-red-50 dark:text-slate-200 dark:hover:text-red-400 dark:hover:bg-red-900/20">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>