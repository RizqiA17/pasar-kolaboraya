<div class="max-w-7xl mx-auto">
    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden mb-8">
        <div class="p-6 sm:p-8 bg-[#379eff] text-white">
            <h2 class="text-2xl font-bold">Pengaturan Profil</h2>
            <p class="mt-1 text-slate-300">Kelola informasi profil dan preferensi Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <nav class="space-y-2 sticky top-16">
                <a href="#profile-info"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-slate-50 text-slate-700">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informasi Profil
                </a>
                <a href="#interests"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-slate-50">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                    Minat & Ketertarikan
                </a>
                <a href="#skills"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-slate-50">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                        </path>
                    </svg>
                    Keahlian
                </a>
                <a href="#contributions"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-slate-50">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Kontribusi
                </a>
                <a href="#danger"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-red-700 hover:bg-red-50">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Danger Zone
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Profile Information Section -->
            <div id="profile-info" class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Profil</h3>
                            <p class="text-sm text-gray-600">Update informasi profil dan alamat email Anda.</p>
                        </div>
                        <span
                            class="inline-flex items-center rounded-full bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-700/10">Required</span>
                    </div>

                    <form wire:submit="updateProfileInformation" class="space-y-6">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-900 mb-1">Nama</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="text" wire:model="name" id="name" required autofocus
                                        autocomplete="name"
                                        class="pl-10 block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-900 mb-1">Email</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="email" wire:model="email" id="email" required
                                        autocomplete="email"
                                        class="pl-10 block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-600 sm:text-sm sm:leading-6">
                                </div>

                                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                                    <div class="mt-2 flex items-center space-x-2">
                                        <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        <div>
                                            <p class="text-sm text-gray-600">
                                                {{ __('Your email address is unverified.') }}
                                                <button type="button"
                                                    wire:click.prevent="resendVerificationNotification"
                                                    class="text-slate-600 hover:text-slate-500 text-sm font-medium">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 text-sm font-medium text-emerald-600">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Perubahan
                            </button>

                            <x-action-message class="mr-3" on="profile-updated">
                                <span
                                    class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                    {{ __('Saved.') }}
                                </span>
                            </x-action-message>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Interests Section --}}
            <!-- Interests Section -->
            <div id="interests" class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Minat & Ketertarikan</h3>
                            <p class="text-sm text-gray-600">Pilih minat dan ketertarikan Anda untuk terhubung dengan
                                kreator yang memiliki minat serupa.</p>
                        </div>
                        <span
                            class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                            {{ count($selectedInterests) }} selected
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($interests as $interest)
                            <label
                                class="group relative flex items-start p-4 cursor-pointer bg-white hover:bg-gray-50 rounded-lg transition-colors ring-1 ring-gray-200">
                                <div class="min-w-0 flex flex-col flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="relative flex items-center">
                                                <input type="checkbox" wire:model.live="selectedInterests"
                                                    value="{{ $interest->id }}"
                                                    class="peer h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                <div
                                                    class="pointer-events-none absolute top-4 left-4 transform -translate-y-1/2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                                    <svg class="h-3.5 w-3.5 text-blue-600" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <span
                                                class="ml-3 text-sm font-medium text-gray-900 group-hover:text-gray-700">{{ $interest->name }}</span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <span
                                                class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 opacity-0 group-hover:opacity-100 transition-opacity">
                                                {{ rand(10, 50) }} kreator
                                            </span>
                                        </div>
                                    </div>
                                    @if ($interest->description)
                                        <p class="mt-1 text-xs text-gray-500 ml-7">{{ $interest->description }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-6 flex items-center justify-between pt-6 border-t border-gray-200">
                        <button wire:click="updateInterests"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>

                        <x-action-message class="mr-3" on="interests-updated">
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                {{ __('Saved.') }}
                            </span>
                        </x-action-message>
                    </div>
                </div>
            </div>

            <!-- Skills Section -->
            <div id="skills" class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Keahlian</h3>
                            <p class="text-sm text-gray-600">Pilih keahlian yang Anda miliki untuk memudahkan
                                kolaborasi dengan kreator lain.</p>
                        </div>
                        <span
                            class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                            {{ count($selectedSkills) }} selected
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($skills as $skill)
                            <label
                                class="group relative flex items-start p-4 cursor-pointer bg-white hover:bg-gray-50 rounded-lg transition-colors ring-1 ring-gray-200">
                                <div class="min-w-0 flex flex-col flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="relative flex items-center">
                                                <input type="checkbox" wire:model.live="selectedSkills"
                                                    value="{{ $skill->id }}"
                                                    class="peer h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                <div
                                                    class="pointer-events-none absolute top-4 left-4 transform -translate-y-1/2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                                    <svg class="h-3.5 w-3.5 text-blue-600" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <span
                                                class="ml-3 text-sm font-medium text-gray-900 group-hover:text-gray-700">{{ $skill->name }}</span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <span
                                                class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 opacity-0 group-hover:opacity-100 transition-opacity">
                                                {{ rand(5, 30) }} kreator
                                            </span>
                                        </div>
                                    </div>
                                    @if ($skill->description)
                                        <p class="mt-1 text-xs text-gray-500 ml-7">{{ $skill->description }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-6 flex items-center justify-between pt-6 border-t border-gray-200">
                        <button wire:click="updateSkills"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>

                        <x-action-message class="mr-3" on="skills-updated">
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                {{ __('Saved.') }}
                            </span>
                        </x-action-message>
                    </div>
                </div>
            </div>

            <!-- Contributions Section -->
            <div id="contributions" class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Kontribusi</h3>
                            <p class="text-sm text-gray-600">Tambahkan kontribusi yang telah Anda berikan untuk
                                menginspirasi kreator lain.</p>
                        </div>
                        <button type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Baru
                        </button>
                    </div>

                    {{-- Add New Contribution Form --}}
                    <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-base font-medium text-gray-900">Tambah Kontribusi Baru</h4>
                            <span
                                class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Optional</span>
                        </div>
                        <div class="grid gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Jenis Kontribusi</label>
                                <div class="relative">
                                    <select wire:model="newContribution.contribution_id"
                                        class="block w-full rounded-lg border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                                        <option value="">Pilih jenis kontribusi</option>
                                        @foreach ($contributions as $contribution)
                                            <option value="{{ $contribution->id }}">{{ $contribution->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Deskripsi</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <textarea wire:model="newContribution.description" rows="3"
                                        class="block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                        placeholder="Jelaskan kontribusi Anda..."></textarea>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Tanggal</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <input type="date" wire:model="newContribution.date"
                                        class="block w-full rounded-lg border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                <button wire:click="addContribution"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Kontribusi
                                </button>

                                <x-action-message class="mr-3" on="contribution-added">
                                    <span
                                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                        {{ __('Added successfully.') }}
                                    </span>
                                </x-action-message>
                            </div>
                        </div>
                    </div>

                    {{-- Existing Contributions List --}}
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @foreach ($userContributions as $contribution)
                                <li>
                                    <div class="relative pb-8">
                                        @if (!$loop->last)
                                            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"
                                                aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex items-start space-x-3">
                                            <div class="relative">
                                                <span
                                                    class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-5 w-5 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $contribution->name }}</div>
                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{ $contribution->pivot->description }}</p>
                                                <div class="mt-2 flex items-center space-x-4">
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                        {{ \Carbon\Carbon::parse($contribution->pivot->date)->format('d M Y') }}
                                                    </div>
                                                    <button wire:click="removeContribution({{ $contribution->id }})"
                                                        class="inline-flex items-center text-sm text-red-600 hover:text-red-900">
                                                        <svg class="mr-1.5 h-5 w-5" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Delete Account Section -->
            <div id="danger" class="bg-white rounded-xl shadow-sm overflow-hidden border border-red-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-red-600">Danger Zone</h3>
                            <p class="text-sm text-gray-600">Tindakan ini tidak dapat dibatalkan. Harap berhati-hati.
                            </p>
                        </div>
                        <span
                            class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                            Danger
                        </span>
                    </div>

                    <div class="rounded-lg bg-red-50 p-6 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Hapus Akun Permanen</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>Setelah akun Anda dihapus:</p>
                                    <ul class="list-disc pl-5 mt-2 space-y-1">
                                        <li>Semua data profil Anda akan dihapus</li>
                                        <li>Kontribusi dan kolaborasi Anda akan dihapus</li>
                                        <li>Koneksi dengan kreator lain akan terputus</li>
                                        <li>Tindakan ini tidak dapat dibatalkan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <livewire:settings.delete-user-form />
                    </div>
                </div>
            </div>
        </div>
