<div
    class="relative overflow-visible p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <!-- Left Content -->
        <div class="flex-1">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center space-x-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-primary-blue/20 dark:bg-secondary-green/20 rounded-xl">
                        <flux:icon.cube class="w-5 h-5 text-primary-blue dark:text-secondary-green" />
                    </div>

                    <div>
                        <a href="{{ route('admin.pasar-kolaboraya.users', $pasar->id) }}"
                            class="text-lg font-semibold text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400">
                            {{ $pasar->name }}
                        </a>
                        <p class="text-sm text-gray-600 dark:text-slate-300">
                            Dibuat oleh {{ $pasar->creator->name }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <div class="max-sm:hidden">
                        <x-admin.pasar-kolaboraya.status-badge :status="$pasar->status" :label="$pasar->status_label" />
                    </div>

                    <!-- Dropdown Action -->
                    <div x-data="{ open: false }" class="relative">
                        <button type="button" @click="open = !open" @click.outside="open = false"
                            class="py-2 transition rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700">
                            <flux:icon.ellipsis-vertical class="w-5 h-5" />
                        </button>

                        <div x-show="open" x-transition
                            class="absolute right-0 z-20 w-48 p-1 mt-2 bg-white border rounded-md shadow-xl dark:bg-slate-900 border-slate-200 dark:border-slate-700">
                            <div class="text-sm">
                                {{ $actions }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sm:hidden max-sm:mb-4">
                <x-admin.pasar-kolaboraya.status-badge :status="$pasar->status" :label="$pasar->status_label" />
            </div>

            <p class="mb-4 text-sm leading-relaxed text-gray-600 dark:text-slate-300">
                {{ $pasar->description == '' ? 'Tidak ada deskripsi' : $pasar->description }}
            </p>

            <div
                class="flex flex-wrap gap-4 max-sm:justify-between mb-4 text-sm text-gray-500 items-cente dark:text-slate-400">
                <div class="flex items-center">
                    <flux:icon.users class="w-4 h-4 mr-2" />
                    <span class="font-medium">{{ $pasar->acceptedUsers->count() }} </span> anggota
                </div>

                <div class="flex items-center">
                    <flux:icon.calendar class="w-4 h-4 mr-2" />
                    {{ $pasar->created_at->format('d M Y') }}
                </div>

                @if ($pasar->started_at)
                    <div class="flex items-center">
                        <flux:icon.play class="w-4 h-4 mr-2" />
                        Dimulai {{ $pasar->started_at->format('d M Y') }}
                    </div>
                @endif
            </div>

            <div class="flex flex-wrap gap-2">
                @if ($pasar->status === 'active')
                    <flux:button wire:click="deactivatePasarKolaboraya({{ $pasar->id }})" {{-- variant="secondary" --}}
                        size="sm" class="max-sm:w-full" icon="pause">
                        Nonaktifkan
                    </flux:button>
                @elseif($pasar->status === 'inactive')
                    <flux:button wire:click="activatePasarKolaboraya({{ $pasar->id }})" variant="primary"
                        size="sm" class="max-sm:w-full" icon="play">
                        Aktifkan
                    </flux:button>
                @endif

                @if ($pasar->status === 'active')
                    <flux:button onclick="downloadQR('{{ $pasar->qr_code }}')" variant="outline" size="sm"
                        class="max-sm:w-full" icon="arrow-down-tray">
                        Download QR
                    </flux:button>
                    <flux:button href="{{ route('admin.pasar-kolaboraya.qr-scanner', $pasar) }}" variant="outline"
                        size="sm" class="max-sm:w-full" icon="camera">
                        Buka Scanner
                    </flux:button>
                @endif
            </div>
        </div>

        <!-- Actions -->

    </div>
</div>
