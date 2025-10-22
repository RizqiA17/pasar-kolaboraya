<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <div class="flex items-center mb-4">
            <a href="{{ route('ecosystem.browse') }}"
                class="mr-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Bergabung dengan Ekosistem</h1>
        </div>

        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <h2 class="text-xl font-semibold text-blue-900 dark:text-blue-200 mb-2">
                {{ $ecosystem->ecosystem_title }}
            </h2>
            <p class="text-blue-700 dark:text-blue-300 mb-1">
                {{ $ecosystem->organization_name }}
            </p>
            <p class="text-sm text-blue-600 dark:text-blue-400">
                {{ $ecosystem->work_region }}
            </p>
        </div>
    </div>

    <!-- Join Form -->
    <form wire:submit="joinEcosystem" class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm space-y-6">

        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
            Formulir Bergabung
        </h2>

        <p class="text-sm font-semibold text-gray-900 dark:text-white mb-4">
            Syarat dan Ketentuan
        </p>

        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 max-h-96 overflow-y-auto">
            <div class="prose dark:prose-invert max-w-none text-sm">
                {!! nl2br(e($ecosystem->terms_conditions)) !!}
            </div>
        </div>

        <!-- Terms Agreement -->
        <div class="space-y-4">
            <flux:checkbox wire:model="agreed_to_terms" required
                :label="'
                Saya telah membaca dan menyetujui syarat dan ketentuan di atas, serta bersedia mematuhi aturan yang
                berlaku dalam ekosistem ini.
                '">
            </flux:checkbox>
        </div>

        <!-- Join Reason -->
        <flux:textarea wire:model="join_reason" :label="'Alasan Bergabung'" required
            :placeholder="'Jelaskan mengapa Anda ingin bergabung dengan ekosistem ini dan bagaimana Anda dapat berkontribusi...'"
            rows="5" />

        <!-- Submit Button -->
        <div class="flex gap-3">
            <flux:button type="submit" variant="primary" class="flex-1" {{-- :loading="$wire.loading" --}}>
                Kirim Permintaan Bergabung
            </flux:button>

            <flux:button type="button" variant="outline" onclick="window.history.back()">
                Batal
            </flux:button>
        </div>
    </form>

    <!-- Ecosystem Details -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            Detail Ekosistem
        </h2>

        @if ($ecosystem->description)
            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                    Deskripsi
                </h3>
                <p class="text-gray-700 dark:text-gray-300">
                    {{ $ecosystem->description }}
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Issues Addressed -->
            @if ($ecosystem->issues_addressed)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">
                        Isu yang Diperjuangkan
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($ecosystem->issues_addressed as $issueId)
                            @php
                                // Check if it's a numeric ID (predefined issue) or string (custom issue)
                                if (is_numeric($issueId) && $issueId > 0) {
                                    $interest = \App\Models\Interest::find($issueId);
                                    $issueName = $interest ? $interest->name : null;
                                } else {
                                    // It's a custom issue (string)
                                    $issueName = $issueId;
                                }
                            @endphp
                            @if ($issueName)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    {{ $issueName }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Existing Roles -->
            @if ($ecosystem->existing_roles)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">
                        Keahlian yang Sudah Ada
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($ecosystem->existing_roles as $roleId)
                            @php
                                $skill = \App\Models\Skill::find($roleId);
                            @endphp
                            @if ($skill)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                    {{ $skill->name }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Needed Roles -->
            @if ($ecosystem->needed_roles)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">
                        Keahlian yang Dibutuhkan
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($ecosystem->needed_roles as $roleId)
                            @php
                                $skill = \App\Models\Skill::find($roleId);
                            @endphp
                            @if ($skill)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                    {{ $skill->name }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Stats -->
            <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">
                    Statistik
                </h3>
                <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                    <div class="flex justify-between">
                        <span>Anggota Saat Ini:</span>
                        <span class="font-medium">{{ $ecosystem->acceptedUsers()->count() }}</span>
                    </div>
                    @if ($ecosystem->max_users)
                        <div class="flex justify-between">
                            <span>Maksimal Anggota:</span>
                            <span class="font-medium">{{ $ecosystem->max_users }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span>Dibuat:</span>
                        <span class="font-medium">{{ $ecosystem->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Creator Info -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">
                Ecosystem Builder
            </h3>
            <div class="flex items-center">
                <div class="flex-shrink-0 mr-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-blue-600 to-green-600 rounded-full flex items-center justify-center text-white font-medium">
                        {{ $ecosystem->creator->initials() }}
                    </div>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">
                        {{ $ecosystem->creator->name }}
                    </p>
                    @if ($ecosystem->creator->organization_name)
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $ecosystem->creator->organization_name }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
