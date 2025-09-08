{{-- <x-admin.layout title="Manajemen Survey"> --}}
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Manajemen Survey</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">Kelola survey untuk mengukur kolaborasi dalam komunitas</p>
            </div>
            <button 
                wire:click="openCreateModal"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
                <flux:icon.plus class="size-4 mr-2" />
                Buat Pasar Kecil Baru
            </button>
        </div>

        <!-- Search Bar -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <div class="flex items-center space-x-4">
                <div class="flex-1">
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live="search"
                            placeholder="Cari survey berdasarkan nama atau deskripsi..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
                        >
                        <flux:icon.magnifying-glass class="absolute left-3 top-3 size-4 text-gray-400" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Surveys List -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
            @if($surveys->count() > 0)
                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Survey</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Respon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Dibuat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach($surveys as $survey)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $survey->name }}</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">{{ $survey->description }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($survey->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span>
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900 dark:text-slate-100">{{ $survey->responses->count() }} respon</div>
                                        @if($survey->responses->count() > 0)
                                            <a href="{{ route('admin.surveys.results', $survey->id) }}" class="text-blue-600 hover:text-blue-800 text-xs">
                                                Lihat hasil →
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900 dark:text-slate-100">{{ $survey->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">oleh {{ $survey->creator->name }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            @if($survey->is_active)
                                                <button 
                                                    wire:click="deactivateSurvey({{ $survey->id }})"
                                                    wire:confirm="Apakah Anda yakin ingin menonaktifkan survey ini?"
                                                    class="text-yellow-600 hover:text-yellow-800 text-sm"
                                                >
                                                    Nonaktifkan
                                                </button>
                                            @else
                                                <button 
                                                    wire:click="activateSurvey({{ $survey->id }})"
                                                    wire:confirm="Apakah Anda yakin ingin mengaktifkan survey ini? Survey yang sedang aktif akan dinonaktifkan."
                                                    class="text-green-600 hover:text-green-800 text-sm"
                                                >
                                                    Aktifkan
                                                </button>
                                            @endif
                                            
                                            @if($survey->responses->count() > 0)
                                                <a href="{{ route('admin.surveys.results', $survey->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                    Hasil
                                                </a>
                                            @endif
                                            
                                            <button 
                                                wire:click="deleteSurvey({{ $survey->id }})"
                                                wire:confirm="Apakah Anda yakin ingin menghapus survey ini? Semua data respon akan ikut terhapus."
                                                class="text-red-600 hover:text-red-800 text-sm"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="lg:hidden">
                    <div class="p-4 space-y-4">
                        @foreach($surveys as $survey)
                            <div class="bg-white dark:bg-slate-700/50 rounded-xl p-4 border border-slate-200 dark:border-slate-600 shadow-sm">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100 truncate">{{ $survey->name }}</h3>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2">{{ $survey->description }}</p>
                                    </div>
                                    <div class="ml-3 flex-shrink-0">
                                        @if($survey->is_active)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1"></span>
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3 mb-3 text-xs">
                                    <div>
                                        <span class="text-slate-500 dark:text-slate-400">Respon:</span>
                                        <span class="font-medium text-slate-900 dark:text-slate-100 ml-1">{{ $survey->responses->count() }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 dark:text-slate-400">Dibuat:</span>
                                        <span class="font-medium text-slate-900 dark:text-slate-100 ml-1">{{ $survey->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                                
                                <div class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                                    oleh {{ $survey->creator->name }}
                                </div>
                                
                                <div class="flex flex-wrap gap-2">
                                    @if($survey->is_active)
                                        <button 
                                            wire:click="deactivateSurvey({{ $survey->id }})"
                                            wire:confirm="Apakah Anda yakin ingin menonaktifkan survey ini?"
                                            class="px-3 py-1.5 text-xs font-medium text-yellow-700 bg-yellow-100 dark:bg-yellow-900/20 dark:text-yellow-300 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-900/30 transition-colors"
                                        >
                                            Nonaktifkan
                                        </button>
                                    @else
                                        <button 
                                            wire:click="activateSurvey({{ $survey->id }})"
                                            wire:confirm="Apakah Anda yakin ingin mengaktifkan survey ini? Survey yang sedang aktif akan dinonaktifkan."
                                            class="px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 dark:bg-green-900/20 dark:text-green-300 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/30 transition-colors"
                                        >
                                            Aktifkan
                                        </button>
                                    @endif
                                    
                                    @if($survey->responses->count() > 0)
                                        <a href="{{ route('admin.surveys.results', $survey->id) }}" 
                                           class="px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 dark:bg-blue-900/20 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/30 transition-colors">
                                            Lihat Hasil
                                        </a>
                                    @endif
                                    
                                    <button 
                                        wire:click="deleteSurvey({{ $survey->id }})"
                                        wire:confirm="Apakah Anda yakin ingin menghapus survey ini? Semua data respon akan ikut terhapus."
                                        class="px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 dark:bg-red-900/20 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/30 transition-colors"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $surveys->links() }}
                </div>
            @else
                <div class="p-8 text-center">
                    <flux:icon.clipboard-document-list class="size-16 text-gray-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Belum Ada Survey</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Mulai dengan membuat survey pertama untuk komunitas Anda.</p>
                    <button 
                        wire:click="openCreateModal"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        <flux:icon.plus class="size-4 mr-2" />
                        Buat Survey Baru
                    </button>
                </div>
            @endif
        </div>

        <!-- Create Survey Modal -->
        @if($showCreateModal)
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" wire:click="closeCreateModal">
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Buat Survey Baru</h3>
                            <button wire:click="closeCreateModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <livewire:admin.surveys.create @surveyCreated="closeCreateModal(); $refresh();" />
                    </div>
                </div>
            </div>
        @endif
    </div>
{{-- </x-admin.layout> --}}