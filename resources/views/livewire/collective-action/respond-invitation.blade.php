<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-600 to-purple-600 text-white rounded-xl p-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('ecosystem.dashboard', $invitation->ecosystem) }}" class="mr-4 text-white/80 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Undangan Aksi Kolektif</h1>
        </div>
        <p class="text-orange-100">
            Anda diundang untuk berkolaborasi dalam aksi kolektif
        </p>
    </div>

    <!-- Invitation Details -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            Detail Undangan
        </h2>

        <!-- Collective Action Info -->
        <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4 mb-6">
            <h3 class="text-xl font-semibold text-purple-900 dark:text-purple-200 mb-2">
                {{ $invitation->collectiveAction->title }}
            </h3>
            
            <div class="flex items-center gap-4 mb-3">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs 
                    @if($invitation->collectiveAction->scale === 'kecil') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                    @elseif($invitation->collectiveAction->scale === 'sedang') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                    @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 @endif">
                    {{ $invitation->collectiveAction->scale_label }}
                </span>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                    {{ $invitation->collectiveAction->scope_label }}
                </span>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    {{ $invitation->collectiveAction->status_label }}
                </span>
            </div>

            <p class="text-purple-700 dark:text-purple-300 mb-4">
                {{ $invitation->collectiveAction->description }}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-medium text-purple-900 dark:text-purple-200 mb-2">Tujuan</h4>
                    <p class="text-sm text-purple-700 dark:text-purple-300">
                        {{ $invitation->collectiveAction->goals }}
                    </p>
                </div>
                
                <div>
                    <h4 class="font-medium text-purple-900 dark:text-purple-200 mb-2">Timeline</h4>
                    <p class="text-sm text-purple-700 dark:text-purple-300">
                        {{ $invitation->collectiveAction->start_date->format('d M Y') }} - 
                        {{ $invitation->collectiveAction->end_date->format('d M Y') }}
                    </p>
                    @if($invitation->collectiveAction->location)
                        <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">
                            📍 {{ $invitation->collectiveAction->location }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Invitation Message -->
        @if($invitation->invitation_message)
            <div class="mb-6">
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Pesan dari Pengirim</h4>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-700 dark:text-gray-300">{{ $invitation->invitation_message }}</p>
                </div>
            </div>
        @endif

        <!-- Invitation Sender -->
        <div class="mb-6">
            <h4 class="font-medium text-gray-900 dark:text-white mb-2">Diundang oleh</h4>
            <div class="flex items-center">
                <div class="flex-shrink-0 mr-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-orange-600 to-purple-600 rounded-full flex items-center justify-center text-white font-medium">
                        {{ $invitation->invitedBy->initials() }}
                    </div>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">
                        {{ $invitation->invitedBy->name }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Ecosystem Builder
                    </p>
                </div>
            </div>
        </div>

        <!-- Required Resources -->
        @if($invitation->collectiveAction->required_resources)
            <div class="mb-6">
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Sumber Daya yang Dibutuhkan</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($invitation->collectiveAction->required_resources as $resource)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                            {{ ucfirst($resource) }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Collaboration Terms -->
        <div class="mb-6">
            <h4 class="font-medium text-gray-900 dark:text-white mb-2">Syarat Kolaborasi</h4>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <p class="text-gray-700 dark:text-gray-300 text-sm">
                    {{ $invitation->collectiveAction->collaboration_terms }}
                </p>
            </div>
        </div>
    </div>

    <!-- Response Form -->
    <form wire:submit="respondToInvitation" class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm space-y-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
            Respons Undangan
        </h2>

        <!-- Response Action -->
        <div class="space-y-3">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Keputusan Anda <span class="text-red-500">*</span>
            </label>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                    <input 
                        type="radio" 
                        wire:model="response_action" 
                        value="accept" 
                        class="mr-3 text-green-600 focus:ring-green-500"
                    >
                    <div>
                        <div class="font-medium text-green-800 dark:text-green-200">
                            ✅ Terima Undangan
                        </div>
                        <div class="text-sm text-green-600 dark:text-green-400">
                            Bergabung dalam aksi kolektif ini
                        </div>
                    </div>
                </label>

                <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                    <input 
                        type="radio" 
                        wire:model="response_action" 
                        value="decline" 
                        class="mr-3 text-red-600 focus:ring-red-500"
                    >
                    <div>
                        <div class="font-medium text-red-800 dark:text-red-200">
                            ❌ Tolak Undangan
                        </div>
                        <div class="text-sm text-red-600 dark:text-red-400">
                            Tidak dapat berpartisipasi saat ini
                        </div>
                    </div>
                </label>
            </div>
            @error('response_action')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Response Message -->
        <flux:textarea
            wire:model="response_message"
            :label="'Pesan Respons (Opsional)'"
            :placeholder="'Tambahkan pesan untuk menjelaskan keputusan Anda...'"
            rows="4"
        />

        <!-- Submit Buttons -->
        <div class="flex gap-3">
            <flux:button 
                type="submit" 
                variant="primary" 
                class="flex-1"
                :loading="$wire.loading"
            >
                @if($response_action === 'accept')
                    Terima Undangan
                @elseif($response_action === 'decline')
                    Tolak Undangan
                @else
                    Kirim Respons
                @endif
            </flux:button>
            
            <flux:button 
                type="button" 
                variant="outline"
                onclick="window.history.back()"
            >
                Batal
            </flux:button>
        </div>
    </form>

    <!-- Current Status -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="font-semibold text-blue-900 dark:text-blue-200">Informasi Penting</h3>
                <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                    Keputusan Anda akan menentukan apakah ekosistem {{ $invitation->ecosystem->ecosystem_title }} 
                    dapat berpartisipasi dalam aksi kolektif ini. Silakan pertimbangkan dengan matang.
                </p>
            </div>
        </div>
    </div>
</div>