<div class="max-w-2xl mx-auto space-y-6">
    {{-- {{dd($collectiveAction)}} --}}
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-xl p-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('collective-action.show', $collectiveAction) }}"
                class="mr-4 text-white/80 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Bergabung dengan Aksi Kolektif</h1>
        </div>
        <p class="text-green-100">
            Bergabung dengan: <strong>{{ $collectiveAction->title }}</strong>
        </p>
    </div>

    <!-- Collective Action Info -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            Informasi Aksi Kolektif
        </h2>

        <div class="space-y-4">
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $collectiveAction->title }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ $collectiveAction->description }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-600 dark:text-gray-400">Skala:</span>
                    <span
                        class="ml-2 text-gray-900 dark:text-white font-medium">{{ $collectiveAction->scale_label }}</span>
                </div>
                <div>
                    <span class="text-gray-600 dark:text-gray-400">Jangkauan:</span>
                    <span
                        class="ml-2 text-gray-900 dark:text-white font-medium">{{ $collectiveAction->scope_label }}</span>
                </div>
                <div>
                    <span class="text-gray-600 dark:text-gray-400">Mulai:</span>
                    <span
                        class="ml-2 text-gray-900 dark:text-white font-medium">{{ $collectiveAction->start_date->format('d M Y') }}</span>
                </div>
                <div>
                    <span class="text-gray-600 dark:text-gray-400">Selesai:</span>
                    <span
                        class="ml-2 text-gray-900 dark:text-white font-medium">{{ $collectiveAction->end_date->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Join Form -->
    <form wire:submit="joinCollectiveAction" class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
                Form Bergabung
            </h2>

            <p class="text-sm font-semibold text-gray-900 dark:text-white mb-4">
                Syarat dan Ketentuan
            </p>

            <div class="bg-gray-50 mb-6 dark:bg-gray-700 rounded-lg p-4 max-h-96 overflow-y-auto">
                <div class="prose dark:prose-invert max-w-none text-sm">
                    {!! nl2br(e($collectiveAction->collaboration_terms)) !!}
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="mb-6">
                <label class="flex items-start">
                    <input type="checkbox" wire:model="agreed_to_terms"
                        class="mt-1 mr-3 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Saya menyetujui syarat dan ketentuan aksi kolektif ini dan siap berpartisipasi sesuai dengan
                        peran yang diminta.
                    </span>
                </label>
            </div>

            <!-- Join Reason -->
            <div class="mb-6">
                <flux:textarea wire:model="join_reason" :label="'Alasan Bergabung'" required
                    :placeholder="'Jelaskan mengapa Anda ingin bergabung dengan aksi kolektif ini dan apa yang dapat Anda kontribusikan...'"
                    rows="4" />
            </div>

        </div>

        <!-- Submit Button -->
        <div class="flex gap-3">
            <flux:button type="submit" variant="primary" class="flex-1">
                Bergabung dengan Aksi Kolektif
            </flux:button>

            <flux:button type="button" variant="outline" onclick="window.history.back()">
                Batal
            </flux:button>
        </div>
    </form>

    <!-- Info Box -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">Informasi Bergabung</h3>
                <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                    <li>• Setelah bergabung, Anda akan menjadi bagian dari aksi kolektif</li>
                    <li>• Admin dapat mengubah role Anda sesuai kebutuhan</li>
                    <li>• Anda dapat berkontribusi sesuai dengan kemampuan dan keahlian</li>
                    <li>• Semua aktivitas akan tercatat dalam sistem</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if (session()->has('message'))
    <div class="fixed top-4 right-4 z-50">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('message') }}
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div class="fixed top-4 right-4 z-50">
        <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    </div>
@endif

<script>
    // Auto-hide success/error messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const messages = document.querySelectorAll('.fixed.top-4.right-4');
        messages.forEach(message => {
            setTimeout(() => {
                message.style.opacity = '0';
                message.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => {
                    message.remove();
                }, 500);
            }, 5000);
        });
    });
</script>
