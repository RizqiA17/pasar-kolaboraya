<div class="space-y-8">
    {{-- Interests Section --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Minat & Ketertarikan</h3>
            <p class="text-sm text-gray-600 mb-4">Pilih minat dan ketertarikan Anda untuk terhubung dengan kreator yang memiliki minat serupa.</p>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                @foreach($interests as $interest)
                    <label class="relative flex items-start p-4 cursor-pointer bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                        <div class="min-w-0 flex flex-col">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="selectedInterests" value="{{ $interest->id }}"
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm font-medium text-gray-900">{{ $interest->name }}</span>
                            </div>
                            @if($interest->description)
                                <p class="mt-1 text-xs text-gray-500">{{ $interest->description }}</p>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="mt-6">
                <button wire:click="updateInterests" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    {{-- Skills Section --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Keahlian</h3>
            <p class="text-sm text-gray-600 mb-4">Pilih keahlian yang Anda miliki untuk memudahkan kolaborasi dengan kreator lain.</p>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                @foreach($skills as $skill)
                    <label class="relative flex items-start p-4 cursor-pointer bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                        <div class="min-w-0 flex flex-col">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="selectedSkills" value="{{ $skill->id }}"
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm font-medium text-gray-900">{{ $skill->name }}</span>
                            </div>
                            @if($skill->description)
                                <p class="mt-1 text-xs text-gray-500">{{ $skill->description }}</p>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="mt-6">
                <button wire:click="updateSkills" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    {{-- Contributions Section --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Kontribusi</h3>
            <p class="text-sm text-gray-600 mb-4">Tambahkan kontribusi yang telah Anda berikan untuk menginspirasi kreator lain.</p>

            {{-- Add New Contribution Form --}}
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-4">Tambah Kontribusi Baru</h4>
                <div class="grid gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kontribusi</label>
                        <select wire:model="newContribution.contribution_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Pilih jenis kontribusi</option>
                            @foreach($contributions as $contribution)
                                <option value="{{ $contribution->id }}">{{ $contribution->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea wire:model="newContribution.description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" wire:model="newContribution.date" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <button wire:click="addContribution" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Tambah Kontribusi
                        </button>
                    </div>
                </div>
            </div>

            {{-- Existing Contributions List --}}
            <div class="space-y-4">
                @foreach($userContributions as $contribution)
                    <div class="flex items-start justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">{{ $contribution->name }}</h4>
                            <p class="mt-1 text-sm text-gray-600">{{ $contribution->pivot->description }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ \Carbon\Carbon::parse($contribution->pivot->date)->format('d M Y') }}</p>
                        </div>
                        <button wire:click="removeContribution({{ $contribution->id }})" class="text-gray-400 hover:text-red-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
