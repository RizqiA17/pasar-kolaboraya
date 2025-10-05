<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-xl p-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('collective-action.browse') }}" class="mr-4 text-white/80 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Berkontribusi pada Aksi Kolektif</h1>
        </div>
        <p class="text-green-100">
            Berikan kontribusi terbaik Anda untuk mendukung gerakan perubahan sosial yang lebih besar
        </p>
    </div>

    <!-- Collective Action Info -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            Detail Aksi Kolektif
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white text-xl mb-2">
                    {{ $collectiveAction->title }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                    {{ $collectiveAction->description }}
                </p>
                
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-xs font-medium">
                        {{ ucfirst($collectiveAction->scale) }}
                    </span>
                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-xs font-medium">
                        {{ ucfirst($collectiveAction->scope) }}
                    </span>
                    <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-xs font-medium">
                        {{ ucfirst($collectiveAction->status) }}
                    </span>
                </div>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">Mulai:</span>
                    <span class="ml-2 text-gray-900 dark:text-white font-medium">
                        {{ \Carbon\Carbon::parse($collectiveAction->start_date)->format('d M Y') }}
                    </span>
                </div>
                
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">Selesai:</span>
                    <span class="ml-2 text-gray-900 dark:text-white font-medium">
                        {{ \Carbon\Carbon::parse($collectiveAction->end_date)->format('d M Y') }}
                    </span>
                </div>
                
                @if($collectiveAction->location)
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">Lokasi:</span>
                    <span class="ml-2 text-gray-900 dark:text-white font-medium">
                        {{ $collectiveAction->location }}
                    </span>
                </div>
                @endif
            </div>
        </div>
        
        @if($collectiveAction->goals)
        <div class="mt-6">
            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Tujuan Aksi:</h4>
            <p class="text-gray-700 dark:text-gray-300">{{ $collectiveAction->goals }}</p>
        </div>
        @endif
        
        @if($collectiveAction->required_resources && count($collectiveAction->required_resources) > 0)
        <div class="mt-6">
            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Sumber Daya yang Dibutuhkan:</h4>
            <div class="flex flex-wrap gap-2">
                @foreach($collectiveAction->required_resources as $resource)
                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm">
                        {{ $resourceTypes[$resource] ?? $resource }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Contribution Form -->
    <form wire:submit="submitContribution" class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
                Form Kontribusi
            </h2>
            
            <!-- Contribution Type -->
            <div class="mb-6">
                <flux:select 
                    wire:model="contribution_id" 
                    :label="'Jenis Kontribusi'" 
                    required
                    class="mb-4"
                >
                    @foreach($contributionTypes as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </flux:select>
                
                <!-- Custom Contribution Type (shown when "Lainnya" is selected) -->
                @php
                    $selectedContribution = \App\Models\Contribution::find($contribution_id);
                    $isOther = $selectedContribution && (str_contains(strtolower($selectedContribution->name), 'lainnya') || str_contains(strtolower($selectedContribution->name), 'other'));
                @endphp
                @if($isOther)
                    <div class="mt-4">
                        <flux:input
                            wire:model="contribution_custom_type"
                            :label="'Jenis Kontribusi Custom'"
                            type="text"
                            required
                            :placeholder="'Masukkan jenis kontribusi yang ingin Anda berikan...'"
                        />
                    </div>
                @endif
                
                <!-- Dynamic form based on contribution type -->
                @php
                    $selectedContribution = \App\Models\Contribution::find($contribution_id);
                    $isFunding = $selectedContribution && (str_contains(strtolower($selectedContribution->name), 'funding') || str_contains(strtolower($selectedContribution->name), 'dana'));
                @endphp
                @if($isFunding)
                    <div class="mt-4">
                        <flux:input
                            wire:model="contribution_amount"
                            :label="'Jumlah Kontribusi (Rupiah)'"
                            type="number"
                            min="0"
                            step="1000"
                            :placeholder="'Masukkan jumlah yang ingin Anda kontribusikan'"
                        />
                    </div>
                @endif
            </div>

            <!-- Contribution Description -->
            <div class="mb-6">
                <flux:textarea
                    wire:model="contribution_description"
                    :label="'Deskripsi Kontribusi'"
                    required
                    :placeholder="'Jelaskan secara detail kontribusi yang ingin Anda berikan...'"
                    rows="5"
                />
                
                <!-- Help text based on contribution type -->
                <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    @if($contribution_type === 'volunteer')
                        Jelaskan keahlian, waktu yang tersedia, dan jenis bantuan yang dapat Anda berikan.
                    @elseif($contribution_type === 'funding')
                        Jelaskan tujuan penggunaan dana dan apakah ada syarat khusus untuk penggunaannya.
                    @elseif($contribution_type === 'expertise')
                        Jelaskan keahlian spesifik, pengalaman, dan bagaimana Anda dapat membantu.
                    @elseif($contribution_type === 'resources')
                        Jelaskan jenis sumber daya, fasilitas, atau peralatan yang dapat Anda sediakan.
                    @elseif($contribution_type === 'promotion')
                        Jelaskan platform promosi yang Anda miliki dan jangkauan audiens.
                    @else
                        Jelaskan secara detail kontribusi yang ingin Anda berikan.
                    @endif
                </div>
            </div>

            <!-- Additional Details for specific types -->
            @if($contribution_type === 'volunteer')
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Detail Relawan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input
                            wire:model="contribution_details.available_hours"
                            :label="'Jam Tersedia per Minggu'"
                            type="number"
                            min="1"
                            max="40"
                            :placeholder="'Contoh: 10'"
                        />
                        <flux:input
                            wire:model="contribution_details.skills"
                            :label="'Keahlian Utama'"
                            type="text"
                            :placeholder="'Contoh: Marketing, Design, Programming'"
                        />
                    </div>
                </div>
            @elseif($selectedContribution && (str_contains(strtolower($selectedContribution->name), 'expertise') || str_contains(strtolower($selectedContribution->name), 'keahlian')))
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Detail Keahlian</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input
                            wire:model="contribution_details.experience_years"
                            :label="'Tahun Pengalaman'"
                            type="number"
                            min="1"
                            :placeholder="'Contoh: 5'"
                        />
                        <flux:input
                            wire:model="contribution_details.certifications"
                            :label="'Sertifikasi (Opsional)'"
                            type="text"
                            :placeholder="'Contoh: PMP, Google Analytics'"
                        />
                    </div>
                </div>
            @elseif($selectedContribution && (str_contains(strtolower($selectedContribution->name), 'resource') || str_contains(strtolower($selectedContribution->name), 'sumber daya')))
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Detail Sumber Daya</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input
                            wire:model="contribution_details.resource_type"
                            :label="'Jenis Sumber Daya'"
                            type="text"
                            :placeholder="'Contoh: Ruang Meeting, Kendaraan, Peralatan'"
                        />
                        <flux:input
                            wire:model="contribution_details.availability"
                            :label="'Ketersediaan'"
                            type="text"
                            :placeholder="'Contoh: Senin-Jumat, 9-17 WIB'"
                        />
                    </div>
                </div>
            @elseif($selectedContribution && (str_contains(strtolower($selectedContribution->name), 'promotion') || str_contains(strtolower($selectedContribution->name), 'promosi')))
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Detail Promosi</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input
                            wire:model="contribution_details.platform"
                            :label="'Platform Promosi'"
                            type="text"
                            :placeholder="'Contoh: Instagram, Facebook, Website'"
                        />
                        <flux:input
                            wire:model="contribution_details.reach"
                            :label="'Jangkauan Audiens'"
                            type="text"
                            :placeholder="'Contoh: 10,000 followers'"
                        />
                    </div>
                </div>
            @endif

            <!-- Terms and Conditions -->
            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">Syarat dan Ketentuan</h4>
                        <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                            <li>• Kontribusi yang Anda berikan akan ditinjau oleh penyelenggara aksi</li>
                            <li>• Anda akan menerima notifikasi jika kontribusi diterima atau ditolak</li>
                            <li>• Pastikan informasi yang diberikan akurat dan dapat dipertanggungjawabkan</li>
                            <li>• Kontribusi yang diterima akan terikat dengan syarat kolaborasi yang telah ditetapkan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-3">
            <flux:button 
                type="submit" 
                variant="primary" 
                class="flex-1"
                {{-- :loading="$wire.loading" --}}
            >
                Kirim Kontribusi
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
</div>

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