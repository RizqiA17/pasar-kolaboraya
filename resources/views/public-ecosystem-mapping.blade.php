@auth
    <x-layouts.app title="Peta Ekosistem Kolaboraya - {{ $selectedPasar->name ?? 'Pasar Kolaboraya' }}">
        {{-- {{dd($ecosystems)}} --}}
        <script src="https://d3js.org/d3.v7.min.js"></script>

        <style>
            /* .market-selector {
                                                                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                                                        } */

            .market-card {
                transition: all 0.3s ease;
            }

            .market-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            .market-card.selected {
                border-color: hsl(217, 91%, 60%);
                background: linear-gradient(135deg, hsl(214, 95%, 93%) 0%, hsl(213, 97%, 87%) 100%);
            }

            .dark {
                .market-card.selected {
                    border-color: hsl(124, 41%, 60%);
                    background: linear-gradient(135deg, hsl(124, 45%, 43%) 0%, hsl(124, 47%, 37%) 100%);
                }

                .market-card.selected h3,
                .market-card.selected p,
                .market-card.selected .text-white,
                .market-card.selected .text-white\/90,
                .market-card.selected .text-white\/70,
                .market-card.selected .text-white\/80 {
                    color: oklch(97% 0 0) !important;
                }
            }

            .market-card.selected h3,
            .market-card.selected p,
            .market-card.selected .text-white,
            .market-card.selected .text-white\/90,
            .market-card.selected .text-white\/70,
            .market-card.selected .text-white\/80 {
                color: #1E64C8 !important;
            }

            .market-card.selected .bg-white\/20 {
                background-color: rgba(30, 64, 175, 0.2) !important;
            }
        </style>

        <!-- Header -->
        <div class="market-selector text-white py-8 mt-16">
            <div class="container mx-auto px-4 relative">
                <!-- Back to Landing Page Button -->
                {{-- <div class="absolute text-center mb-6">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm rounded-lg border-2 border-white/30 hover:bg-white/30 transition-all duration-300 text-white font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                    </div> --}}

                <div class="text-center mb-8">
                    <h1 class="text-4xl font-extrabold mb-4 dark:text-neutral-100 text-primary-blue">
                        Peta Ekosistem Kolaboraya
                    </h1>
                    <p class="text-lg opacity-90 max-w-3xl mx-auto text-neutral-800 dark:text-neutral-300">
                        Visualisasi interaktif ekosistem, peran, dan kolaborator dalam Pasar Kolaboraya.
                        Pilih pasar untuk melihat peta ekosistemnya.
                    </p>
                </div>

                <!-- Market Selector -->
                @if ($pasarKolaborayaList->count() > 1)
                    <div class="max-w-6xl mx-auto">
                        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-900 dark:text-white">
                            Pilih Pasar Kolaboraya
                        </h2>

                        <!-- Search and Filter -->
                        {{-- <div class="mb-6">
                                <div class="relative max-w-md mx-auto">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 dark:text-white/60" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="marketSearch"
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-white/30 rounded-lg bg-white dark:bg-white/10 backdrop-blur-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                                        placeholder="Cari pasar kolaboraya...">
                                </div>
                            </div> --}}

                        <!-- Market Cards with Improved Layout -->
                        <div id="marketContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach ($pasarKolaborayaList as $index => $pasar)
                                @php
                                    $colors = [
                                        'bg-neutral-purple',
                                        'bg-neutral-green',
                                        'bg-accent-orange',
                                        'bg-anccent-red',
                                        'bg-primary-blue',
                                        'bg-secondary-green',
                                    ];
                                    $colorClass = $colors[$index % count($colors)];
                                    $icons = [
                                        'Building',
                                        'Rocket',
                                        'Lightbulb',
                                        'Palette',
                                        'Factory',
                                        'Leaf',
                                        'Briefcase',
                                        'Microscope',
                                    ];
                                    $icon = $icons[$index % count($icons)];
                                @endphp
                                <a href="{{ route('public.ecosystem.mapping', ['pasar_id' => $pasar->id]) }}"
                                    class="market-card block p-6 rounded-xl border-2 transition-all duration-300 
                           bg-gray-100 dark:bg-white/10 backdrop-blur-sm 
                           border-gray-200 dark:border-white/20 
                           hover:border-gray-400 dark:hover:border-white/40
                           {{ $selectedPasar && $selectedPasar->id === $pasar->id ? 'selected border-blue-400 bg-gray-200 dark:bg-white/20' : '' }}"
                                    data-market-name="{{ strtolower($pasar->name) }}"
                                    data-market-description="{{ strtolower($pasar->description) }}">

                                    <!-- Header with Icon and Status -->
                                    <div class="flex items-start justify-between mb-3">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br {{ $colorClass }} rounded-lg flex items-center justify-center shadow-lg">
                                            @if ($icon === 'Building')
                                                <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                                    </path>
                                                </svg>
                                            @elseif($icon === 'Rocket')
                                                <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z">
                                                    </path>
                                                </svg>
                                            @elseif($icon === 'Lightbulb')
                                                <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                    <path
                                                        d="M11 3a1 1 0 10-2 0v1a1 1 0 10-2 0V3a3 3 0 016 0v1a1 1 0 10-2 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 011-1H5a1 1 0 000 2h1a1 1 0 01-1-1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.477.859h4z">
                                                    </path>
                                                </svg>
                                            @elseif($icon === 'Palette')
                                                <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            @elseif($icon === 'Factory')
                                                <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2zm6 4a2 2 0 100 4 2 2 0 000-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            @elseif($icon === 'Leaf')
                                                <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            @elseif($icon === 'Briefcase')
                                                <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            @elseif($icon === 'Microscope')
                                                <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        @if ($selectedPasar && $selectedPasar->id === $pasar->id)
                                            <div class="flex items-center text-sm text-primary-blue dark:text-neutral-100">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586
                                                                                                                                                               7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Aktif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">
                                        {{ $pasar->name }}</h3>
                                    <p class="text-sm leading-relaxed text-gray-700 dark:text-white/90">
                                        {{ Str::limit($pasar->description, 80) }}
                                    </p>

                                    <!-- Stats or Badge -->
                                    @if ($selectedPasar && $selectedPasar->id === $pasar->id)
                                        <div class="mt-4 flex items-center justify-between">
                                            <div class="flex items-center text-xs text-gray-600 dark:text-neutral-100">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Pasar Aktif
                                            </div>
                                            <div
                                                class="px-2 py-1 bg-gray-200 dark:bg-white/20 rounded-full text-xs text-gray-700 dark:text-neutral-200">
                                                {{ $index + 1 }}/{{ $pasarKolaborayaList->count() }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-4 flex items-center justify-between">
                                            <div class="flex items-center text-xs text-gray-600 dark:text-white/70">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Pasar Aktif
                                            </div>
                                            <div
                                                class="px-2 py-1 bg-gray-200 dark:bg-white/20 rounded-full text-xs text-gray-700 dark:text-white/80">
                                                {{ $index + 1 }}/{{ $pasarKolaborayaList->count() }}
                                            </div>
                                        </div>
                                    @endif
                                </a>
                            @endforeach
                        </div>

                        <!-- No Results Message -->
                        <div id="noResults" class="hidden text-center py-8">
                            <div class="text-gray-500 dark:text-white/60 text-lg mb-2">Tidak ada pasar yang ditemukan
                            </div>
                            <div class="text-gray-400 dark:text-white/40 text-sm">Coba kata kunci yang berbeda</div>
                        </div>

                        <!-- Pagination Controls -->
                        <div id="paginationControls"
                            class="mt-8 flex justify-center items-center space-x-2 {{ $pasarKolaborayaList->count() <= 8 ? 'hidden' : '' }}">
                            <button id="prevPage"
                                class="px-4 py-2 rounded-lg border transition-all duration-300 
                       bg-gray-100 dark:bg-white/10 backdrop-blur-sm 
                       border-gray-200 dark:border-white/20 
                       text-gray-900 dark:text-white 
                       hover:bg-gray-200 dark:hover:bg-white/20 
                       disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Sebelumnya
                            </button>

                            <div id="pageNumbers" class="flex space-x-1">
                                <!-- Page numbers by JS -->
                            </div>

                            <button id="nextPage"
                                class="px-4 py-2 rounded-lg border transition-all duration-300 
                       bg-gray-100 dark:bg-white/10 backdrop-blur-sm 
                       border-gray-200 dark:border-white/20 
                       text-gray-900 dark:text-white 
                       hover:bg-gray-200 dark:hover:bg-white/20 
                       disabled:opacity-50 disabled:cursor-not-allowed">
                                Selanjutnya
                                <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <!-- Market Count Info -->
                        <div class="mt-4 text-center text-gray-600 dark:text-white/60 text-sm">
                            Menampilkan <span id="showingCount">{{ min(8, $pasarKolaborayaList->count()) }}</span>
                            dari <span id="totalCount">{{ $pasarKolaborayaList->count() }}</span> pasar kolaboraya
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <!-- Mapping Container -->
        <div class="container mx-auto px-4 py-8">
            @if ($selectedPasar && $ecosystems->count() > 0)
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Header -->
                    <div
                        class="relative overflow-hidden rounded-xl bg-white dark:bg-slate-800 shadow-lg border border-gray-100 dark:border-gray-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-purple-50/50 dark:from-blue-900/10 dark:to-purple-900/10">
                        </div>

                        <!-- Header -->
                        <div class="relative z-10 p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-slate-100 mb-2">
                                        Peta Ekosistem {{ $selectedPasar->name }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-slate-400 text-sm">
                                        Visualisasi interaktif ekosistem dan peran dalam {{ $selectedPasar->name }}
                                    </p>
                                </div>
                                <div
                                    class="w-12 h-12 bg-neutral-green rounded-lg flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Mapping Container -->
                        <div class="relative z-10 p-6">
                            <div class="w-full h-[800px] bg-gray-50 dark:bg-gray-900 rounded-lg overflow-hidden">
                                <div id="ecosystem-mapping-container" class="w-full h-full"></div>
                            </div>

                            <!-- Legend -->
                            <div class="mt-4 flex flex-wrap gap-4 text-xs">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                    <span class="text-gray-600 dark:text-gray-400">Pasar Kolaboraya</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-gray-600 dark:text-gray-400">Ekosistem</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                                    <span class="text-gray-600 dark:text-gray-400">Peran</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                        <div
                            class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Interaktif</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            Gunakan mouse untuk zoom in/out dan drag untuk memindahkan peta.
                            Hover pada peran untuk melihat detail pengguna.
                        </p>
                    </div>

                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                        <div
                            class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Kolaborasi</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            Lihat bagaimana ekosistem terhubung dan peran-peran yang dibutuhkan
                            untuk membangun kolaborasi yang efektif.
                        </p>
                    </div>
                </div>
            @elseif($selectedPasar && $ecosystems->count() === 0)
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
                    <div class="flex flex-col items-center justify-center text-center">
                        <div
                            class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                </path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Ekosistem
                        </h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Pasar Kolaboraya "{{ $selectedPasar->name }}" belum memiliki ekosistem yang terdaftar.
                        </p>
                    </div>
                </div>
            @else
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
                    <div class="flex flex-col items-center justify-center text-center">
                        <div
                            class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                </path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Tidak Ada Pasar
                            Kolaboraya
                        </h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Belum ada Pasar Kolaboraya yang aktif untuk ditampilkan.
                        </p>
                    </div>
                </div>
            @endif
        </div>

        @push('footer')
            <!-- Footer -->
            <footer class="mt-32 pb-8 z-1 relative">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div
                        class="border-t border-gray-200 dark:border-slate-700 pt-8 text-center text-gray-500 dark:text-slate-400">
                        <p>&copy; 2025 Pasar Kolaboraya. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        @endpush

        <!-- Ecosystem Detail Modal -->
        @include('components.ecosystem-detail-modal')

        @if ($selectedPasar && $ecosystems->count() > 0)
            <script data-navigate-once>
                // Load D3.js dynamically if not already loaded
                function loadD3() {
                    return new Promise((resolve, reject) => {
                        if (typeof d3 !== 'undefined') {
                            resolve();
                            return;
                        }

                        const script = document.createElement('script');
                        script.src = 'https://d3js.org/d3.v7.min.js';
                        script.onload = resolve;
                        script.onerror = reject;
                        document.head.appendChild(script);
                    });
                }

                async function initializeEcosystemMapping() {
                    console.log('Initializing ecosystem mapping...');

                    // Check if container exists
                    const container = document.getElementById('ecosystem-mapping-container');
                    if (!container) {
                        console.log('Container not found, retrying in 200ms...');
                        setTimeout(initializeEcosystemMapping, 200);
                        return;
                    }

                    console.log('Container found, proceeding with initialization...');

                    try {
                        // Ensure D3.js is loaded
                        await loadD3();
                        console.log('D3.js loaded successfully');

                        // Clear any existing content to prevent duplicates
                        container.innerHTML = '';

                        const data = {
                            pasarKolaboraya: {
                                id: @json($selectedPasar->id),
                                name: @json($selectedPasar->name),
                                description: @json($selectedPasar->description),
                            },
                            ecosystems: @json($roleData),
                        };

                        console.log('Data prepared, creating mapping...', data);
                        createEcosystemMapping(data);
                        console.log('Ecosystem mapping created successfully');
                    } catch (error) {
                        console.error('Failed to initialize ecosystem mapping:', error);
                        // Retry after a delay
                        setTimeout(initializeEcosystemMapping, 500);
                    }
                }

                // Initialize on DOM ready
                document.addEventListener('DOMContentLoaded', initializeEcosystemMapping);

                // Re-initialize after Livewire navigation
                document.addEventListener('livewire:navigated', function() {
                    console.log('Livewire navigated event triggered');
                    // Add a small delay to ensure DOM is fully updated
                    setTimeout(initializeEcosystemMapping, 100);
                });

                // Also listen for wire:navigate specifically
                document.addEventListener('livewire:load', function() {
                    console.log('Livewire load event triggered');
                    initializeEcosystemMapping();
                });

                // Additional event listener for wire:navigate
                document.addEventListener('livewire:update', function() {
                    console.log('Livewire update event triggered');
                    setTimeout(initializeEcosystemMapping, 200);
                });

                // Listen for when Livewire finishes updating the DOM
                document.addEventListener('livewire:updated', function() {
                    console.log('Livewire updated event triggered');
                    setTimeout(initializeEcosystemMapping, 300);
                });

                // Force initialization after a delay to ensure everything is loaded
                setTimeout(function() {
                    console.log('Force initialization after delay');
                    initializeEcosystemMapping();
                }, 1000);

                // Initialize modal event listeners
                function initializeModalListeners() {
                    console.log('Initializing modal listeners...');

                    const modal = document.getElementById('ecosystem-detail-modal');
                    const closeBtn = document.getElementById('close-ecosystem-modal');
                    const closeBtnFooter = document.getElementById('close-ecosystem-modal-btn');

                    if (!modal || !closeBtn || !closeBtnFooter) {
                        console.log('Modal elements not found, retrying in 200ms...');
                        setTimeout(initializeModalListeners, 200);
                        return;
                    }

                    // Remove existing event listeners to prevent duplicates
                    const newCloseBtn = closeBtn.cloneNode(true);
                    const newCloseBtnFooter = closeBtnFooter.cloneNode(true);
                    closeBtn.parentNode.replaceChild(newCloseBtn, closeBtn);
                    closeBtnFooter.parentNode.replaceChild(newCloseBtnFooter, closeBtnFooter);

                    // Close modal functions
                    function closeModal() {
                        console.log('Closing modal...');
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }

                    newCloseBtn.addEventListener('click', closeModal);
                    newCloseBtnFooter.addEventListener('click', closeModal);

                    // Close modal when clicking outside
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            closeModal();
                        }
                    });

                    // Close modal with Escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                            closeModal();
                        }
                    });

                    // Function to show ecosystem details
                    window.showEcosystemDetails = function(ecosystemData) {
                        console.log('showEcosystemDetails called with:', ecosystemData);

                        // Populate general information
                        document.getElementById('ecosystem-name').textContent = ecosystemData.ecosystem.name || 'N/A';
                        document.getElementById('ecosystem-organization').textContent = ecosystemData.ecosystem.organization ||
                            'N/A';
                        document.getElementById('ecosystem-description').textContent = ecosystemData.ecosystem.description ||
                            'Tidak ada deskripsi tersedia';
                        document.getElementById('ecosystem-work-region').textContent = ecosystemData.ecosystem.work_region ||
                            'N/A';
                        document.getElementById('ecosystem-member-count').textContent = ecosystemData.totalUsers || 0;

                        // Populate issues
                        const issuesContainer = document.getElementById('ecosystem-issues');
                        issuesContainer.innerHTML = '';
                        if (ecosystemData.ecosystem.issues && ecosystemData.ecosystem.issues.length > 0) {
                            ecosystemData.ecosystem.issues.forEach(issue => {
                                const issueTag = document.createElement('span');
                                issueTag.className =
                                    'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800';
                                issueTag.textContent = issue;
                                issuesContainer.appendChild(issueTag);
                            });
                        } else {
                            const noIssues = document.createElement('span');
                            noIssues.className = 'text-gray-500 italic';
                            noIssues.textContent = 'Tidak ada isu yang didefinisikan';
                            issuesContainer.appendChild(noIssues);
                        }

                        // Populate existing roles
                        const existingRolesContainer = document.getElementById('existing-roles');
                        existingRolesContainer.innerHTML = '';
                        if (ecosystemData.roles && ecosystemData.roles.length > 0) {
                            ecosystemData.roles.forEach(role => {
                                const roleCard = document.createElement('div');
                                roleCard.className =
                                    'bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-4 shadow-sm dark:shadow-slate-900/30';
                                roleCard.innerHTML = `
                    <div class="flex items-center justify-between mb-2">
                        <h6 class="font-medium text-gray-900 dark:text-slate-100 ">${role.role}</h6>
                        <span class="text-sm text-gray-500 dark:text-slate-400">${role.count} orang</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-slate-300">asdsadsdasdadsa ${role.description || 'Tidak ada deskripsi tersedia'}</p>
                `;
                                existingRolesContainer.appendChild(roleCard);
                            });
                        } else {
                            const noRoles = document.createElement('div');
                            noRoles.className = 'col-span-2 text-center text-gray-500 dark:text-gray-400 italic py-8';
                            noRoles.textContent = 'Belum ada peran yang terdefinisi';
                            existingRolesContainer.appendChild(noRoles);
                        }

                        // Populate needed roles
                        const neededRolesContainer = document.getElementById('needed-roles');
                        neededRolesContainer.innerHTML = '';
                        if (ecosystemData.needed_roles && ecosystemData.needed_roles.length > 0) {
                            ecosystemData.needed_roles.forEach(role => {
                                const roleCard = document.createElement('div');
                                roleCard.className =
                                    'bg-orange-50 dark:bg-slate-800 border border-orange-200 dark:border-slate-700 rounded-lg p-4 shadow-sm dark:shadow-slate-900/30';
                                roleCard.innerHTML = `
                    <div class="flex items-center justify-between mb-2 ">
                        <h6 class="font-medium text-gray-900 dark:text-slate-100">${role}</h6>
                        <span class="text-sm text-orange-600 dark:text-orange-300 font-medium">Dibutuhkan</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-slate-300">Peran ini masih dibutuhkan dalam ekosistem</p>
                `;
                                neededRolesContainer.appendChild(roleCard);
                            });
                        } else {
                            const noNeededRoles = document.createElement('div');
                            noNeededRoles.className =
                                'col-span-2 text-center text-gray-500 dark:text-gray-400 italic py-8';
                            noNeededRoles.textContent = 'Semua peran sudah terpenuhi';
                            neededRolesContainer.appendChild(noNeededRoles);
                        }

                        // Show modal
                        console.log('Showing modal...');
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    };

                    console.log('Modal listeners initialized successfully');
                }

                // Initialize modal listeners on DOM ready
                document.addEventListener('DOMContentLoaded', initializeModalListeners);

                // Re-initialize modal listeners after Livewire navigation
                document.addEventListener('livewire:navigated', function() {
                    console.log('Re-initializing modal listeners after navigation...');
                    setTimeout(initializeModalListeners, 100);
                });

                document.addEventListener('livewire:load', initializeModalListeners);
                document.addEventListener('livewire:update', function() {
                    setTimeout(initializeModalListeners, 200);
                });
                document.addEventListener('livewire:updated', function() {
                    setTimeout(initializeModalListeners, 300);
                });

                function createEcosystemMapping(data) {
                    console.log('Creating ecosystem mapping with data:', data);

                    const container = d3.select('#ecosystem-mapping-container');
                    if (container.empty()) {
                        console.error('Container not found in createEcosystemMapping');
                        return;
                    }

                    const width = container.node().offsetWidth;
                        const height = container.node().offsetHeight > width ? width : 800;

                    console.log('Container dimensions:', width, 'x', height);

                    // Clear previous content
                    container.selectAll('*').remove();

                    // Create SVG
                    const svg = container.append('svg')
                        .attr('width', width)
                        .attr('height', height)
                        .style('background', 'transparent');

                    // Create zoom behavior
                    const zoom = d3.zoom()
                        .scaleExtent([0.1, 4])
                        .on('zoom', (event) => {
                            console.log('Zoom event triggered');
                            g.attr('transform', event.transform);
                        });

                    svg.call(zoom);

                    // Ensure zoom is properly attached
                    console.log('Zoom behavior attached to SVG');

                    // Main group for all elements
                    const g = svg.append('g');

                    // Center point
                    const centerX = width / 2;
                    const centerY = height / 2;

                    // Create ecosystem nodes
                    const ecosystems = data.ecosystems;

                    // Dynamic sizing based on data count
                    let centralRadius, ecosystemRadius, roleRadius, ecosystemTextSize, roleTextSize, maxEcosystemTextLength,
                        maxRoleTextLength;

                    if (ecosystems.length <= 3) {
                        centralRadius = 80;
                        ecosystemRadius = 50;
                        roleRadius = 22;
                        ecosystemTextSize = '14';
                        roleTextSize = '10';
                        maxEcosystemTextLength = 18;
                        maxRoleTextLength = 12;
                    } else if (ecosystems.length <= 6) {
                        centralRadius = 90;
                        ecosystemRadius = 55;
                        roleRadius = 24;
                        ecosystemTextSize = '12';
                        roleTextSize = '9';
                        maxEcosystemTextLength = 15;
                        maxRoleTextLength = 10;
                    } else if (ecosystems.length <= 10) {
                        centralRadius = 100;
                        ecosystemRadius = 60;
                        roleRadius = 26;
                        ecosystemTextSize = '11';
                        roleTextSize = '8';
                        maxEcosystemTextLength = 12;
                        maxRoleTextLength = 8;
                    } else {
                        centralRadius = 110;
                        ecosystemRadius = 65;
                        roleRadius = 28;
                        ecosystemTextSize = '10';
                        roleTextSize = '7';
                        maxEcosystemTextLength = 10;
                        maxRoleTextLength = 6;
                    }

                    // Helper function for text wrapping
                    function wrapText(text, maxWidth, fontSize) {
                        const words = text.split(' ');
                        const lines = [];
                        let currentLine = '';

                        words.forEach(word => {
                            const testLine = currentLine + (currentLine ? ' ' : '') + word;
                            const testWidth = testLine.length * fontSize * 0.6; // Approximate character width

                            if (testWidth <= maxWidth) {
                                currentLine = testLine;
                            } else {
                                if (currentLine) lines.push(currentLine);
                                currentLine = word;
                            }
                        });
                        if (currentLine) lines.push(currentLine);

                        return lines;
                    }

                    // Create gradients and filters
                    const defs = svg.append('defs');

                    // Central gradient
                    const centralGradient = defs.append('radialGradient')
                        .attr('id', 'centralGradient')
                        .attr('cx', '30%')
                        .attr('cy', '30%')
                        .attr('r', '70%');

                    centralGradient.append('stop')
                        .attr('offset', '0%')
                        .attr('stop-color', '#95bdf5');

                    centralGradient.append('stop')
                        .attr('offset', '100%')
                        .attr('stop-color', '#1E64C8');

                    // Ecosystem gradient
                    const ecosystemGradient = defs.append('radialGradient')
                        .attr('id', 'ecosystemGradient')
                        .attr('cx', '30%')
                        .attr('cy', '30%')
                        .attr('r', '70%');

                    ecosystemGradient.append('stop')
                        .attr('offset', '0%')
                        .attr('stop-color', '#2FB89B');

                    ecosystemGradient.append('stop')
                        .attr('offset', '100%')
                        .attr('stop-color', '#2C6B52');

                    // Role gradient
                    const roleGradient = defs.append('radialGradient')
                        .attr('id', 'roleGradient')
                        .attr('cx', '30%')
                        .attr('cy', '30%')
                        .attr('r', '70%');

                    roleGradient.append('stop')
                        .attr('offset', '0%')
                        .attr('stop-color', '#F0673D');

                    roleGradient.append('stop')
                        .attr('offset', '100%')
                        .attr('stop-color', '#E33A37');

                    // Shadow filter
                    const shadowFilter = defs.append('filter')
                        .attr('id', 'shadow')
                        .attr('x', '-50%')
                        .attr('y', '-50%')
                        .attr('width', '200%')
                        .attr('height', '200%');

                    shadowFilter.append('feDropShadow')
                        .attr('dx', 4)
                        .attr('dy', 4)
                        .attr('stdDeviation', 4)
                        .attr('flood-color', 'rgba(0,0,0,0.25)');

                    // Calculate dynamic radius based on ecosystem count and container size
                    const totalEcosystems = Math.max(ecosystems.length, 1);
                    const angleStep = (2 * Math.PI) / totalEcosystems;

                    // Calculate minimum distance between ecosystem centers to prevent overlap
                    const minDistanceBetweenEcosystems = (ecosystemRadius * 2) + 80; // 80px minimum gap between bubbles

                    // Calculate the required radius to fit all ecosystems with equal spacing
                    // Using the formula: circumference = 2 * π * radius
                    // We need: circumference / totalEcosystems >= minDistanceBetweenEcosystems
                    // So: radius >= (minDistanceBetweenEcosystems * totalEcosystems) / (2 * π)
                    const requiredRadius = (minDistanceBetweenEcosystems * totalEcosystems) / (2 * Math.PI);

                    // MUCH LARGER padding from the center circle - this is the key to wider spacing
                    const centerPadding = centralRadius + ecosystemRadius + 200; // Increased from 120 to 200

                    // Calculate maximum allowed radius (70% of container - increased from 60%)
                    const maxRadius = Math.min(width, height) * 0.7;

                    // Use the larger of required radius or center padding, but not exceeding max radius
                    const radius = Math.max(requiredRadius, centerPadding);

                    // FIRST: Draw all lines from center to ecosystems (behind everything)
                    ecosystems.forEach((ecosystem, index) => {
                        const angle = index * angleStep;
                        const x = centerX + Math.cos(angle) * radius;
                        const y = centerY + Math.sin(angle) * radius;

                        // Draw line from center to ecosystem with solid color for better visibility
                        g.append('line')
                            .attr('x1', centerX)
                            .attr('y1', centerY)
                            .attr('x2', x)
                            .attr('y2', y)
                            .attr('stroke', '#3B82F6')
                            .attr('stroke-width', 3)
                            .attr('opacity', 1.0)
                            .attr('class', 'ecosystem-line')
                            .attr('id', `line-${index}`);
                    });

                    // SECOND: Create central Pasar Kolaboraya node (on top of lines)
                    const centralNode = g.append('g')
                        .attr('class', 'central-node')
                        .attr('transform', `translate(${centerX}, ${centerY})`);

                    // Central circle
                    centralNode.append('circle')
                        .attr('r', centralRadius)
                        .attr('fill', 'url(#centralGradient)')
                        .attr('stroke', '#1E3A8A')
                        .attr('stroke-width', 4)
                        .attr('filter', 'url(#shadow)');

                    // Central text with better sizing and wrapping (on top of everything)
                    const centralTextSize = Math.max(centralRadius * 0.15, 12);
                    const centralText = 'PASAR KOLABORAYA';
                    const maxWidth = centralRadius * 1.8; // Leave some padding
                    const lines = wrapText(centralText, maxWidth, centralTextSize);

                    // Create text elements for each line
                    lines.forEach((line, lineIndex) => {
                        centralNode.append('text')
                            .attr('text-anchor', 'middle')
                            .attr('dy', `${(lineIndex - (lines.length - 1) / 2) * 1.2}em`)
                            .attr('fill', 'white')
                            .attr('font-size', centralTextSize)
                            .attr('font-weight', 'bold')
                            .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                            .text(line);
                    });

                    // Store ecosystem groups for later role creation
                    const ecosystemGroups = [];

                    // FIRST: Draw all ecosystem circles and their content
                    ecosystems.forEach((ecosystem, index) => {
                        const angle = index * angleStep;
                        const x = centerX + Math.cos(angle) * radius;
                        const y = centerY + Math.sin(angle) * radius;

                        const ecosystemGroup = g.append('g')
                            .attr('class', 'ecosystem-group')
                            .attr('transform', `translate(${x}, ${y})`);

                        // Store for later role creation
                        ecosystemGroups.push({
                            group: ecosystemGroup,
                            ecosystem: ecosystem,
                            x: x,
                            y: y
                        });

                        // Ecosystem circle with gradient and shadow
                        ecosystemGroup.append('circle')
                            .attr('r', ecosystemRadius)
                            .attr('fill', 'url(#ecosystemGradient)')
                            .attr('stroke', '#047857')
                            .attr('stroke-width', 3)
                            .attr('filter', 'url(#shadow)')
                            .style('cursor', 'pointer')
                            .on('mouseover', function(event) {
                                console.log('Ecosystem hovered:', ecosystem.ecosystem.name);
                                d3.select(this).attr('r', ecosystemRadius + 5);
                                showEcosystemTooltip(ecosystem, event);
                                // Show role containers when ecosystem is hovered
                                g.selectAll('.role-container').style('opacity', 0);
                                g.selectAll(`.role-container-${index}`).style('opacity', 1);
                            })
                            .on('mouseout', function(event) {
                                console.log('Ecosystem mouse out:', ecosystem.ecosystem.name);
                                d3.select(this).attr('r', ecosystemRadius);
                                hideEcosystemTooltip();
                                // Hide role containers when ecosystem is not hovered
                                g.selectAll('.role-container').style('opacity', 0);
                            })
                            .on('click', function(event) {
                                console.log('Ecosystem clicked:', ecosystem.ecosystem.name);
                                // Show ecosystem details modal
                                if (typeof showEcosystemDetails === 'function') {
                                    showEcosystemDetails(ecosystem);
                                }
                            });

                        // Ecosystem text with better sizing and wrapping
                        const ecosystemTextSize = Math.max(ecosystemRadius * 0.2, 10);
                        const ecosystemText = ecosystem.ecosystem.name;
                        const maxWidth = ecosystemRadius * 1.8; // Leave some padding
                        const lines = wrapText(ecosystemText, maxWidth, ecosystemTextSize);

                        // Limit to maximum 3 lines
                        const displayLines = lines.slice(0, 3);
                        if (lines.length > 3) {
                            displayLines[2] = displayLines[2].substring(0, displayLines[2].length - 3) + '...';
                        }

                        // Create text elements for each line
                        displayLines.forEach((line, lineIndex) => {
                            ecosystemGroup.append('text')
                                .attr('text-anchor', 'middle')
                                .attr('dy', `${(lineIndex - (displayLines.length - 1) / 2) * 1.2}em`)
                                .attr('fill', 'white')
                                .attr('font-size', ecosystemTextSize)
                                .attr('font-weight', 'bold')
                                .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                                .text(line);
                        });
                    });

                    // SECOND: Create all role containers in a separate layer (on top of ecosystem circles)
                    ecosystemGroups.forEach(({
                        group: ecosystemGroup,
                        ecosystem
                    }, index) => {
                        const roles = ecosystem.roles;
                        if (roles.length > 0) {
                            const roleAngleStep = (2 * Math.PI) / roles.length;

                            // Calculate role radius - distance from ecosystem center to role centers
                            // Similar to how ecosystems are positioned around the central blue bubble
                            const roleDistance = ecosystemRadius + roleRadius + 60; // 60px gap between ecosystem and roles

                            // Create container for all role groups in separate layer
                            const roleContainer = g.append('g')
                                .attr('class', `role-container role-container-${index}`)
                                .style('opacity', 0)
                                .style('transition', 'opacity 0.3s ease');

                            roles.forEach((role, roleIndex) => {
                                const roleAngle = roleIndex * roleAngleStep;
                                const ecosystemTransform = ecosystemGroup.attr('transform');
                                const ecosystemX = parseFloat(ecosystemTransform.match(
                                    /translate\(([^,]+),([^)]+)\)/)[1]);
                                const ecosystemY = parseFloat(ecosystemTransform.match(
                                    /translate\(([^,]+),([^)]+)\)/)[2]);
                                const roleX = ecosystemX + Math.cos(roleAngle) * roleDistance;
                                const roleY = ecosystemY + Math.sin(roleAngle) * roleDistance;

                                const roleGroup = roleContainer.append('g')
                                    .attr('class', 'role-group')
                                    .attr('transform', `translate(${roleX}, ${roleY})`);

                                // Role circle with gradient and shadow
                                roleGroup.append('circle')
                                    .attr('r', roleRadius)
                                    .attr('fill', 'url(#roleGradient)')
                                    .attr('stroke', '#B45309')
                                    .attr('stroke-width', 2)
                                    .attr('filter', 'url(#shadow)')
                                    .on('mouseover', function(event) {
                                        console.log('Role hovered:', role.role);
                                        d3.select(this).attr('r', roleRadius + 4);
                                        showRoleTooltip(role, event);
                                    })
                                    .on('mouseout', function(event) {
                                        console.log('Role mouse out:', role.role);
                                        d3.select(this).attr('r', roleRadius);
                                        hideRoleTooltip();
                                    });

                                // Role text with better sizing and wrapping
                                const roleTextSize = Math.max(roleRadius * 0.35, 8);
                                const roleText = role.role;
                                const maxWidth = roleRadius * 1.8; // Leave some padding
                                const lines = wrapText(roleText, maxWidth, roleTextSize);

                                // Limit to maximum 2 lines for roles
                                const displayLines = lines.slice(0, 2);
                                if (lines.length > 2) {
                                    displayLines[1] = displayLines[1].substring(0, displayLines[1].length - 3) +
                                        '...';
                                }

                                // Create text elements for each line
                                displayLines.forEach((line, lineIndex) => {
                                    roleGroup.append('text')
                                        .attr('text-anchor', 'middle')
                                        .attr('dy',
                                            `${(lineIndex - (displayLines.length - 1) / 2) * 1.1}em`)
                                        .attr('fill', 'white')
                                        .attr('font-size', roleTextSize)
                                        .attr('font-weight', 'bold')
                                        .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                                        .text(line);
                                });

                                // Role count with better styling
                                roleGroup.append('text')
                                    .attr('text-anchor', 'middle')
                                    .attr('dy', '2.2em')
                                    .attr('fill', 'white')
                                    .attr('font-size', Math.max(roleTextSize - 2, 6))
                                    .attr('font-weight', 'bold')
                                    .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                                    .text(role.count);
                            });
                        }
                    });

                    // Tooltip for ecosystem details
                    const ecosystemTooltip = d3.select('body').append('div')
                        .attr('class',
                            'absolute z-50 px-4 py-3 bg-gray-900 text-white text-sm rounded-lg shadow-lg pointer-events-none')
                        .style('opacity', 0)
                        .style('display', 'none');

                    function showEcosystemTooltip(ecosystem, event) {
                        console.log('Showing ecosystem tooltip for:', ecosystem.ecosystem.name);
                        ecosystemTooltip
                            .html(`
                        <div class="font-bold mb-2">${ecosystem.ecosystem.name}</div>
                        <div class="text-xs text-gray-300 mb-1">${ecosystem.ecosystem.organization || 'Organisasi'}</div>
                        <div class="text-xs text-gray-400">${ecosystem.totalUsers} pengguna • ${ecosystem.roles.length} peran</div>
                    `)
                            .style('left', (event.pageX) + 'px')
                            .style('top', (event.pageY) + 'px')
                            .style('opacity', 1)
                            .style('display', 'block');
                    }

                    function hideEcosystemTooltip() {
                        ecosystemTooltip.style('opacity', 0)
                            .style('display', 'none');
                    }

                    // Tooltip for role details
                    // const roleTooltip = d3.select('body').append('div')
                    //     .attr('class',
                    //         'absolute z-50 px-4 py-3 bg-gray-900 text-white text-sm rounded-lg shadow-lg pointer-events-none')
                    //     .style('opacity', 0);

                    function showRoleTooltip(role, event) {
                        console.log('Showing role tooltip for:', role.role);
                        const users = role.users.map(user => user.name).join(', ');
                        roleTooltip
                            .html(`
                        <div class="font-bold mb-2">${role.role}</div>
                        <div class="text-xs text-gray-300 mb-1">${role.count} pengguna</div>
                        <div class="text-xs text-gray-400">${users}</div>
                    `)
                            .style('left', (event.pageX + 10) + 'px')
                            .style('top', (event.pageY) + 'px')
                            .style('opacity', 1);
                    }

                    function hideRoleTooltip() {
                        roleTooltip.style('opacity', 0);
                    }

                    // Initial zoom to fit all content with proper spacing
                    setTimeout(() => {
                        const bounds = g.node().getBBox();
                        const padding = 150; // Increased padding for much more breathing room
                        const fullWidth = bounds.width + padding * 2;
                        const fullHeight = bounds.height + padding * 2;
                        const scale = Math.min(width / fullWidth, height / fullHeight,
                            0.7); // Further reduced scale for more space
                        const translate = [width / 2 - scale * (bounds.x + bounds.width / 2),
                            height / 2 - scale * (bounds.y + bounds.height / 2)
                        ];

                        svg.call(zoom.transform, d3.zoomIdentity.translate(translate[0], translate[1]).scale(scale));

                        console.log('Ecosystem mapping visualization completed successfully');
                    }, 100);
                }

                // Market search and pagination functionality for guest
                let currentPageGuest = 1;
                const itemsPerPageGuest = 8;
                let allMarketCardsGuest = [];
                let filteredCardsGuest = [];

                function initializeMarketSearchGuest() {
                    const searchInput = document.getElementById('marketSearchGuest');
                    const marketContainer = document.getElementById('marketContainerGuest');
                    const noResults = document.getElementById('noResultsGuest');
                    const paginationControls = document.getElementById('paginationControlsGuest');
                    const showingCount = document.getElementById('showingCountGuest');
                    const totalCount = document.getElementById('totalCountGuest');

                    if (!searchInput || !marketContainer) return;

                    // Store all market cards
                    allMarketCardsGuest = Array.from(marketContainer.querySelectorAll('.market-card'));
                    filteredCardsGuest = [...allMarketCardsGuest];

                    // Initialize pagination
                    updatePaginationGuest();
                    updateMarketCountGuest();

                    searchInput.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase().trim();

                        // Filter cards based on search term
                        filteredCardsGuest = allMarketCardsGuest.filter(card => {
                            const marketName = card.getAttribute('data-market-name') || '';
                            const marketDescription = card.getAttribute('data-market-description') || '';
                            return marketName.includes(searchTerm) || marketDescription.includes(searchTerm);
                        });

                        // Reset to first page when searching
                        currentPageGuest = 1;

                        // Update display
                        updateMarketDisplayGuest();
                        updatePaginationGuest();
                        updateMarketCountGuest();

                        // Show/hide no results message
                        if (filteredCardsGuest.length === 0 && searchTerm !== '') {
                            noResults.classList.remove('hidden');
                            paginationControls.classList.add('hidden');
                        } else {
                            noResults.classList.add('hidden');
                            paginationControls.classList.toggle('hidden', filteredCardsGuest.length <= itemsPerPageGuest);
                        }
                    });

                    // Pagination event listeners
                    document.getElementById('prevPageGuest').addEventListener('click', () => {
                        if (currentPageGuest > 1) {
                            currentPageGuest--;
                            updateMarketDisplayGuest();
                            updatePaginationGuest();
                            updateMarketCountGuest();
                        }
                    });

                    document.getElementById('nextPageGuest').addEventListener('click', () => {
                        const totalPages = Math.ceil(filteredCardsGuest.length / itemsPerPageGuest);
                        if (currentPageGuest < totalPages) {
                            currentPageGuest++;
                            updateMarketDisplayGuest();
                            updatePaginationGuest();
                            updateMarketCountGuest();
                        }
                    });
                }

                function updateMarketDisplayGuest() {
                    // Hide all cards first
                    allMarketCardsGuest.forEach(card => card.style.display = 'none');

                    // Show cards for current page
                    const startIndex = (currentPageGuest - 1) * itemsPerPageGuest;
                    const endIndex = startIndex + itemsPerPageGuest;
                    const cardsToShow = filteredCardsGuest.slice(startIndex, endIndex);

                    cardsToShow.forEach(card => card.style.display = 'block');
                }

                function updatePaginationGuest() {
                    const totalPages = Math.ceil(filteredCardsGuest.length / itemsPerPageGuest);
                    const pageNumbers = document.getElementById('pageNumbersGuest');
                    const prevBtn = document.getElementById('prevPageGuest');
                    const nextBtn = document.getElementById('nextPageGuest');

                    // Update button states
                    prevBtn.disabled = currentPageGuest === 1;
                    nextBtn.disabled = currentPageGuest === totalPages;

                    // Generate page numbers
                    pageNumbers.innerHTML = '';
                    const maxVisiblePages = 5;
                    let startPage = Math.max(1, currentPageGuest - Math.floor(maxVisiblePages / 2));
                    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

                    if (endPage - startPage + 1 < maxVisiblePages) {
                        startPage = Math.max(1, endPage - maxVisiblePages + 1);
                    }

                    for (let i = startPage; i <= endPage; i++) {
                        const pageBtn = document.createElement('button');
                        pageBtn.textContent = i;
                        pageBtn.className = `px-3 py-2 rounded-lg text-sm transition-all duration-300 ${
                                i === currentPageGuest 
                                    ? 'bg-white/20 text-white border border-white/40' 
                                    : 'bg-white/10 text-white/80 hover:bg-white/15'
                            }`;
                        pageBtn.addEventListener('click', () => {
                            currentPageGuest = i;
                            updateMarketDisplayGuest();
                            updatePaginationGuest();
                            updateMarketCountGuest();
                        });
                        pageNumbers.appendChild(pageBtn);
                    }
                }

                function updateMarketCountGuest() {
                    const showingCount = document.getElementById('showingCountGuest');
                    const totalCount = document.getElementById('totalCountGuest');
                    const startIndex = (currentPageGuest - 1) * itemsPerPageGuest;
                    const endIndex = Math.min(startIndex + itemsPerPageGuest, filteredCardsGuest.length);

                    showingCount.textContent = endIndex - startIndex;
                    totalCount.textContent = filteredCardsGuest.length;
                }

                // Initialize search when DOM is loaded
                document.addEventListener('DOMContentLoaded', function() {
                    initializeMarketSearchGuest();
                });
            </script>
        @endif
    </x-layouts.app>
@else
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}">
        <title>{{ __('Peta Ekosistem Kolaboraya') }} - {{ $selectedPasar->name ?? 'Pasar Kolaboraya' }}</title>

        <!-- Tailwind CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- D3.js -->
        <script src="https://d3js.org/d3.v7.min.js"></script>

        <style>
            /* .market-selector {
                                                                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                                                        } */

            .market-card {
                transition: all 0.3s ease;
            }

            .market-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            .market-card.selected {
                border-color: hsl(217, 91%, 60%);
                background: linear-gradient(135deg, hsl(214, 95%, 93%) 0%, hsl(213, 97%, 87%) 100%);
            }



            .dark {
                .market-card.selected {
                    border-color: hsl(124, 41%, 60%);
                    background: linear-gradient(135deg, hsl(124, 45%, 43%) 0%, hsl(124, 47%, 37%) 100%);
                }

                .market-card.selected h3,
                .market-card.selected p,
                .market-card.selected .text-white,
                .market-card.selected .text-white\/90,
                .market-card.selected .text-white\/70,
                .market-card.selected .text-white\/80 {
                    color: oklch(97% 0 0) !important;
                }
            }

            .market-card.selected h3,
            .market-card.selected p,
            .market-card.selected .text-white,
            .market-card.selected .text-white\/90,
            .market-card.selected .text-white\/70,
            .market-card.selected .text-white\/80 {
                color: #1E64C8 !important;
            }

            .market-card.selected .bg-white\/20 {
                background-color: rgba(30, 64, 175, 0.2) !important;
            }

            /* Mobile Menu Styles */
            .mobile-menu-open {
                opacity: 1 !important;
                visibility: visible !important;
                transform: translateY(0) !important;
            }
        </style>

        <script>
            function initializeMobileMenu() {
                console.log('Initializing mobile menu...');
                
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');
                const mobileDarkModeToggle = document.getElementById('mobile-dark-mode-toggle');
                const mobileThemeText = document.getElementById('mobile-theme-text');

                console.log('Elements found:', {
                    mobileMenuButton: !!mobileMenuButton,
                    mobileMenu: !!mobileMenu,
                    mobileDarkModeToggle: !!mobileDarkModeToggle,
                    mobileThemeText: !!mobileThemeText
                });

                // Toggle mobile menu
                if (mobileMenuButton && mobileMenu) {
                    // Remove existing event listeners
                    const newButton = mobileMenuButton.cloneNode(true);
                    mobileMenuButton.parentNode.replaceChild(newButton, mobileMenuButton);
                    
                    // Add new event listener
                    newButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        console.log('Mobile menu button clicked');
                        mobileMenu.classList.toggle('mobile-menu-open');
                    });

                    // Close menu when clicking outside
                    document.addEventListener('click', function(event) {
                        if (!newButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                            mobileMenu.classList.remove('mobile-menu-open');
                        }
                    });
                }

                // Mobile dark mode toggle
                if (mobileDarkModeToggle && mobileThemeText) {
                    // Remove existing event listeners
                    const newDarkModeToggle = mobileDarkModeToggle.cloneNode(true);
                    mobileDarkModeToggle.parentNode.replaceChild(newDarkModeToggle, mobileDarkModeToggle);
                    
                    newDarkModeToggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        console.log('Dark mode toggle clicked');
                        
                        // Toggle dark mode
                        document.documentElement.classList.toggle('dark');
                        
                        // Update theme text
                        if (document.documentElement.classList.contains('dark')) {
                            mobileThemeText.textContent = 'Mode Terang';
                        } else {
                            mobileThemeText.textContent = 'Mode Gelap';
                        }
                        
                        // Store preference
                        localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
                    });

                    // Initialize theme text
                    if (document.documentElement.classList.contains('dark')) {
                        mobileThemeText.textContent = 'Mode Terang';
                    } else {
                        mobileThemeText.textContent = 'Mode Gelap';
                    }
                }
            }

            // Initialize immediately
            initializeMobileMenu();

            // Initialize on DOM ready
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM Content Loaded - initializing mobile menu');
                initializeMobileMenu();
            });

            // Re-initialize after Livewire navigation
            document.addEventListener('livewire:navigated', function() {
                console.log('Livewire navigated - reinitializing mobile menu');
                setTimeout(initializeMobileMenu, 100);
            });

            // Also listen for other Livewire events
            document.addEventListener('livewire:load', function() {
                console.log('Livewire load - initializing mobile menu');
                initializeMobileMenu();
            });
            
            document.addEventListener('livewire:update', function() {
                console.log('Livewire update - reinitializing mobile menu');
                setTimeout(initializeMobileMenu, 200);
            });
            
            document.addEventListener('livewire:updated', function() {
                console.log('Livewire updated - reinitializing mobile menu');
                setTimeout(initializeMobileMenu, 300);
            });

            // Force initialization after a delay to ensure everything is loaded
            setTimeout(function() {
                console.log('Force initialization after delay');
                initializeMobileMenu();
            }, 1000);
        </script>
    </head>

    <body class="">
        <div class="relative min-h-screen bg-primary-light-blue dark:bg-slate-900 overflow-hidden">

            <nav class="fixed backdrop-blur-xs top-0 w-full z-50 p-4 sm:p-6">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <a href="{{ url('/') }}" class="text-navy dark:text-slate-200 text-2xl font-bold">
                        <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}" alt="logo"
                            class="h-8 sm:h-10">
                    </a>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-4">
                        <!-- Dark Mode Toggle -->
                        <x-dark-mode-toggle />

                        @if (Route::has('login'))
                            <div class="space-x-4 flex">
                                @auth
                                    <a href="{{ url('/dashboard') }}"
                                        class="px-4 py-2 bg-navy dark:bg-secondary-green text-white rounded-full hover:bg-sky-700 dark:hover:bg-teal-600 transition">Beranda</a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="px-4 py-2 text-navy dark:text-slate-200 hover:text-sky-700 dark:hover:text-secondary-green transition">Masuk</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="px-4 py-2 bg-navy dark:bg-secondary-green text-white rounded-full hover:bg-sky-700 dark:hover:bg-teal-600 transition">Daftar</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <button id="mobile-menu-button" class="p-2 rounded-lg bg-white/10 dark:bg-slate-800/50 backdrop-blur-sm border border-white/20 dark:border-slate-700 hover:bg-white/20 dark:hover:bg-slate-700/50 transition">
                            <svg class="w-6 h-6 text-navy dark:text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Dropdown Menu -->
                <div id="mobile-menu" class="md:hidden absolute top-full left-0 right-0 mt-2 mx-4 bg-white/95 dark:bg-slate-800/95 backdrop-blur-sm rounded-xl shadow-xl border border-gray-200 dark:border-slate-700 opacity-0 invisible transform translate-y-2 transition-all duration-200">
                    <div class="p-4 space-y-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="flex items-center w-full px-4 py-3 bg-navy dark:bg-secondary-green text-white rounded-lg hover:bg-sky-700 dark:hover:bg-teal-600 transition">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Beranda
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="flex items-center w-full px-4 py-3 text-navy dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Masuk
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="flex items-center w-full px-4 py-3 bg-navy dark:bg-secondary-green text-white rounded-lg hover:bg-sky-700 dark:hover:bg-teal-600 transition">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                        Daftar
                                    </a>
                                @endif
                            @endauth
                        @endif
                        
                        <!-- Dark Mode Toggle for Mobile -->
                        <div class="pt-3 border-t border-gray-200 dark:border-slate-700">
                            <button id="mobile-dark-mode-toggle" class="flex items-center w-full px-4 py-3 text-navy dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition">
                                <svg id="mobile-sun-icon" class="w-5 h-5 mr-3 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <svg id="mobile-moon-icon" class="w-5 h-5 mr-3 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                                <span id="mobile-theme-text">Ganti Tema</span>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            <div
                class="absolute top-0 max-md:-translate-x-1/2 max-md:translate-y-1/2 left-0 w-80 h-80 opacity-70 animate-float">
                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/1.webp') }}" alt=""
                    class="w-full h-full object-contain">
            </div>
            <div
                class="absolute top-10 max-md:translate-x-1/2 max-md:translate-y-1/2 right-0 w-96 h-96 opacity-60 animate-float-delay-2">
                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/7.webp') }}" alt=""
                    class="w-full h-full object-contain">
            </div>
            <div
                class="absolute top-0  right-0 translate-x-1/4 -translate-y-1/4 w-72 h-72 opacity-50 animate-float-delay-3">
                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/8.webp') }}" alt=""
                    class="w-full h-full object-contain">
            </div>
            <div
                class="absolute -bottom-50 max-md:translate-x-1/2 max-md:translate-y-1/2 right-5 w-80 h-80 opacity-60 animate-float">
                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/5.webp') }}" alt=""
                    class="w-full h-full object-contain">
            </div>
            <div
                class="absolute -bottom-50 max-md:translate-x-1/2 max-md:translate-y-1/2 left-5 w-64 h-64 opacity-50 animate-float-delay-1">
                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/6.webp') }}" alt=""
                    class="w-full h-full object-contain">
            </div>
            <div
                class="absolute bottom-0 left-0 -translate-x-1/4 translate-y-1/4 w-72 h-72 opacity-60 animate-float-delay-2">
                <img src="{{ Storage::url('web/ASET VISUAL/WEBP/3.webp') }}" alt=""
                    class="w-full h-full object-contain">
            </div>

            <!-- Header -->
            <div class="market-selector text-white py-8 mt-16">
                <div class="container mx-auto px-4 relative">
                    <!-- Back to Landing Page Button -->
                    {{-- <div class="absolute text-center mb-6">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm rounded-lg border-2 border-white/30 hover:bg-white/30 transition-all duration-300 text-white font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                    </div> --}}

                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-bold mb-4 font-sans dark:text-neutral-100 text-primary-blue">
                            Peta Ekosistem Kolaboraya
                        </h1>
                        <p class="text-lg opacity-90 max-w-3xl mx-auto text-neutral-800 dark:text-neutral-300">
                            Visualisasi interaktif ekosistem, peran, dan kolaborator dalam Pasar Kolaboraya.
                            Pilih pasar untuk melihat peta ekosistemnya.
                        </p>
                    </div>

                    <!-- Market Selector -->
                    @if ($pasarKolaborayaList->count() > 1)
                        <div class="max-w-6xl mx-auto">
                            <h2 class="text-2xl font-semibold mb-6 text-center text-gray-900 dark:text-white">
                                Pilih Pasar Kolaboraya
                            </h2>

                            <!-- Search and Filter -->
                            {{-- <div class="mb-6">
                                <div class="relative max-w-md mx-auto">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 dark:text-white/60" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="marketSearch"
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-white/30 rounded-lg bg-white dark:bg-white/10 backdrop-blur-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                                        placeholder="Cari pasar kolaboraya...">
                                </div>
                            </div> --}}

                            <!-- Market Cards with Improved Layout -->
                            <div id="marketContainer"
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                @foreach ($pasarKolaborayaList as $index => $pasar)
                                    @php
                                        $colors = [
                                            'bg-neutral-purple',
                                            'bg-neutral-green',
                                            'bg-accent-orange',
                                            'bg-anccent-red',
                                            'bg-primary-blue',
                                            'bg-secondary-green',
                                        ];
                                        $colorClass = $colors[$index % count($colors)];
                                        $icons = [
                                            'Building',
                                            'Rocket',
                                            'Lightbulb',
                                            'Palette',
                                            'Factory',
                                            'Leaf',
                                            'Briefcase',
                                            'Microscope',
                                        ];
                                        $icon = $icons[$index % count($icons)];
                                    @endphp
                                    <a href="{{ route('public.ecosystem.mapping', ['pasar_id' => $pasar->id]) }}"
                                        class="market-card block p-6 rounded-xl border-2 transition-all duration-300 
                           bg-gray-100 dark:bg-white/10 backdrop-blur-sm 
                           border-gray-200 dark:border-white/20 
                           hover:border-gray-400 dark:hover:border-white/40
                           {{ $selectedPasar && $selectedPasar->id === $pasar->id ? 'selected border-blue-400 bg-gray-200 dark:bg-white/20' : '' }}"
                                        data-market-name="{{ strtolower($pasar->name) }}"
                                        data-market-description="{{ strtolower($pasar->description) }}">

                                        <!-- Header with Icon and Status -->
                                        <div class="flex items-start justify-between mb-3">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br {{ $colorClass }} rounded-lg flex items-center justify-center shadow-lg">
                                                @if ($icon === 'Building')
                                                    <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                                        </path>
                                                    </svg>
                                                @elseif($icon === 'Rocket')
                                                    <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z">
                                                        </path>
                                                    </svg>
                                                @elseif($icon === 'Lightbulb')
                                                    <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                        <path
                                                            d="M11 3a1 1 0 10-2 0v1a1 1 0 10-2 0V3a3 3 0 016 0v1a1 1 0 10-2 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 011-1H5a1 1 0 000 2h1a1 1 0 01-1-1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.477.859h4z">
                                                        </path>
                                                    </svg>
                                                @elseif($icon === 'Palette')
                                                    <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                @elseif($icon === 'Factory')
                                                    <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2zm6 4a2 2 0 100 4 2 2 0 000-4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                @elseif($icon === 'Leaf')
                                                    <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                @elseif($icon === 'Briefcase')
                                                    <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                @elseif($icon === 'Microscope')
                                                    <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-6 h-6 text-white" fill="white" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            @if ($selectedPasar && $selectedPasar->id === $pasar->id)
                                                <div
                                                    class="flex items-center text-sm text-primary-blue dark:text-neutral-100">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586
                                                                                                                                                               7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Aktif
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Content -->
                                        <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">
                                            {{ $pasar->name }}</h3>
                                        <p class="text-sm leading-relaxed text-gray-700 dark:text-white/90">
                                            {{ Str::limit($pasar->description, 80) }}
                                        </p>

                                        <!-- Stats or Badge -->
                                        @if ($selectedPasar && $selectedPasar->id === $pasar->id)
                                            <div class="mt-4 flex items-center justify-between">
                                                <div class="flex items-center text-xs text-gray-600 dark:text-neutral-100">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Pasar Aktif
                                                </div>
                                                <div
                                                    class="px-2 py-1 bg-gray-200 dark:bg-white/20 rounded-full text-xs text-gray-700 dark:text-neutral-200">
                                                    {{ $index + 1 }}/{{ $pasarKolaborayaList->count() }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="mt-4 flex items-center justify-between">
                                                <div class="flex items-center text-xs text-gray-600 dark:text-white/70">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Pasar Aktif
                                                </div>
                                                <div
                                                    class="px-2 py-1 bg-gray-200 dark:bg-white/20 rounded-full text-xs text-gray-700 dark:text-white/80">
                                                    {{ $index + 1 }}/{{ $pasarKolaborayaList->count() }}
                                                </div>
                                            </div>
                                        @endif
                                    </a>
                                @endforeach
                            </div>

                            <!-- No Results Message -->
                            <div id="noResults" class="hidden text-center py-8">
                                <div class="text-gray-500 dark:text-white/60 text-lg mb-2">Tidak ada pasar yang ditemukan
                                </div>
                                <div class="text-gray-400 dark:text-white/40 text-sm">Coba kata kunci yang berbeda</div>
                            </div>

                            <!-- Pagination Controls -->
                            <div id="paginationControls"
                                class="mt-8 flex justify-center items-center space-x-2 {{ $pasarKolaborayaList->count() <= 8 ? 'hidden' : '' }}">
                                <button id="prevPage"
                                    class="px-4 py-2 rounded-lg border transition-all duration-300 
                       bg-gray-100 dark:bg-white/10 backdrop-blur-sm 
                       border-gray-200 dark:border-white/20 
                       text-gray-900 dark:text-white 
                       hover:bg-gray-200 dark:hover:bg-white/20 
                       disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Sebelumnya
                                </button>

                                <div id="pageNumbers" class="flex space-x-1">
                                    <!-- Page numbers by JS -->
                                </div>

                                <button id="nextPage"
                                    class="px-4 py-2 rounded-lg border transition-all duration-300 
                       bg-gray-100 dark:bg-white/10 backdrop-blur-sm 
                       border-gray-200 dark:border-white/20 
                       text-gray-900 dark:text-white 
                       hover:bg-gray-200 dark:hover:bg-white/20 
                       disabled:opacity-50 disabled:cursor-not-allowed">
                                    Selanjutnya
                                    <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Market Count Info -->
                            <div class="mt-4 text-center text-gray-600 dark:text-white/60 text-sm">
                                Menampilkan <span id="showingCount">{{ min(8, $pasarKolaborayaList->count()) }}</span>
                                dari <span id="totalCount">{{ $pasarKolaborayaList->count() }}</span> pasar kolaboraya
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <!-- Mapping Container -->
            <div class="container mx-auto px-4 py-8">
                @if ($selectedPasar && $ecosystems->count() > 0)
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <!-- Header -->
                        <div
                            class="relative overflow-hidden rounded-xl bg-white dark:bg-slate-800 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-purple-50/50 dark:from-blue-900/10 dark:to-purple-900/10">
                            </div>

                            <!-- Header -->
                            <div class="relative z-10 p-6 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-slate-100 mb-2">
                                            Peta Ekosistem {{ $selectedPasar->name }}
                                        </h3>
                                        <p class="text-gray-600 dark:text-slate-400 text-sm">
                                            Visualisasi interaktif ekosistem dan peran dalam {{ $selectedPasar->name }}
                                        </p>
                                    </div>
                                    <div
                                        class="w-12 h-12 bg-neutral-green rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Mapping Container -->
                            <div class="relative z-10 p-6">
                                <div class="w-full bg-gray-50 dark:bg-gray-900 rounded-lg overflow-hidden">
                                    <div id="ecosystem-mapping-container" class="w-full h-full"></div>
                                </div>

                                <!-- Legend -->
                                <div class="mt-4 flex flex-wrap gap-4 text-xs">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        <span class="text-gray-600 dark:text-gray-400">Pasar Kolaboraya</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        <span class="text-gray-600 dark:text-gray-400">Ekosistem</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                                        <span class="text-gray-600 dark:text-gray-400">Peran</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div
                            class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div
                                class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Interaktif</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Gunakan mouse untuk zoom in/out dan drag untuk memindahkan peta.
                                Hover pada peran untuk melihat detail pengguna.
                            </p>
                        </div>

                        <div
                            class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div
                                class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Kolaborasi</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Lihat bagaimana ekosistem terhubung dan peran-peran yang dibutuhkan
                                untuk membangun kolaborasi yang efektif.
                            </p>
                        </div>
                    </div>
                @elseif($selectedPasar && $ecosystems->count() === 0)
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div
                                class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Ekosistem
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                Pasar Kolaboraya "{{ $selectedPasar->name }}" belum memiliki ekosistem yang terdaftar.
                            </p>
                        </div>
                    </div>
                @else
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div
                                class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Tidak Ada Pasar
                                Kolaboraya
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                Belum ada Pasar Kolaboraya yang aktif untuk ditampilkan.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <footer class="mt-32 pb-8 z-1 relative">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div
                        class="border-t border-gray-200 dark:border-slate-700 pt-8 text-center text-gray-500 dark:text-slate-400">
                        <p>&copy; 2025 Pasar Kolaboraya. All rights reserved.</p>
                    </div>
                </div>
            </footer>

            <!-- Ecosystem Detail Modal -->
            @include('components.ecosystem-detail-modal')

            @if ($selectedPasar && $ecosystems->count() > 0)
                <script data-navigate-once>
                    // Load D3.js dynamically if not already loaded
                    function loadD3() {
                        return new Promise((resolve, reject) => {
                            if (typeof d3 !== 'undefined') {
                                resolve();
                                return;
                            }

                            const script = document.createElement('script');
                            script.src = 'https://d3js.org/d3.v7.min.js';
                            script.onload = resolve;
                            script.onerror = reject;
                            document.head.appendChild(script);
                        });
                    }

                    async function initializeEcosystemMapping() {
                        console.log('Initializing ecosystem mapping...');

                        // Check if container exists
                        const container = document.getElementById('ecosystem-mapping-container');
                        if (!container) {
                            console.log('Container not found, retrying in 200ms...');
                            setTimeout(initializeEcosystemMapping, 200);
                            return;
                        }

                        console.log('Container found, proceeding with initialization...');

                        try {
                            // Ensure D3.js is loaded
                            await loadD3();
                            console.log('D3.js loaded successfully');

                            // Clear any existing content to prevent duplicates
                            container.innerHTML = '';

                            const data = {
                                pasarKolaboraya: {
                                    id: @json($selectedPasar->id),
                                    name: @json($selectedPasar->name),
                                    description: @json($selectedPasar->description),
                                },
                                ecosystems: @json($roleData),
                            };

                            console.log('Data prepared, creating mapping...', data);
                            createEcosystemMapping(data);
                            console.log('Ecosystem mapping created successfully');
                        } catch (error) {
                            console.error('Failed to initialize ecosystem mapping:', error);
                            // Retry after a delay
                            setTimeout(initializeEcosystemMapping, 500);
                        }
                    }

                    // Initialize on DOM ready
                    document.addEventListener('DOMContentLoaded', initializeEcosystemMapping);

                    // Re-initialize after Livewire navigation
                    document.addEventListener('livewire:navigated', function() {
                        console.log('Livewire navigated event triggered');
                        // Add a small delay to ensure DOM is fully updated
                        setTimeout(initializeEcosystemMapping, 100);
                    });

                    // Also listen for wire:navigate specifically
                    document.addEventListener('livewire:load', function() {
                        console.log('Livewire load event triggered');
                        initializeEcosystemMapping();
                    });

                    // Additional event listener for wire:navigate
                    document.addEventListener('livewire:update', function() {
                        console.log('Livewire update event triggered');
                        setTimeout(initializeEcosystemMapping, 200);
                    });

                    // Listen for when Livewire finishes updating the DOM
                    document.addEventListener('livewire:updated', function() {
                        console.log('Livewire updated event triggered');
                        setTimeout(initializeEcosystemMapping, 300);
                    });

                    // Force initialization after a delay to ensure everything is loaded
                    setTimeout(function() {
                        console.log('Force initialization after delay');
                        initializeEcosystemMapping();
                    }, 1000);

                    // Initialize modal event listeners
                    function initializeModalListeners() {
                        console.log('Initializing modal listeners...');

                        const modal = document.getElementById('ecosystem-detail-modal');
                        const closeBtn = document.getElementById('close-ecosystem-modal');
                        const closeBtnFooter = document.getElementById('close-ecosystem-modal-btn');

                        if (!modal || !closeBtn || !closeBtnFooter) {
                            console.log('Modal elements not found, retrying in 200ms...');
                            setTimeout(initializeModalListeners, 200);
                            return;
                        }

                        // Remove existing event listeners to prevent duplicates
                        const newCloseBtn = closeBtn.cloneNode(true);
                        const newCloseBtnFooter = closeBtnFooter.cloneNode(true);
                        closeBtn.parentNode.replaceChild(newCloseBtn, closeBtn);
                        closeBtnFooter.parentNode.replaceChild(newCloseBtnFooter, closeBtnFooter);

                        // Close modal functions
                        function closeModal() {
                            console.log('Closing modal...');
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                        }

                        newCloseBtn.addEventListener('click', closeModal);
                        newCloseBtnFooter.addEventListener('click', closeModal);

                        // Close modal when clicking outside
                        modal.addEventListener('click', function(e) {
                            if (e.target === modal) {
                                closeModal();
                            }
                        });

                        // Close modal with Escape key
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                                closeModal();
                            }
                        });

                        // Function to show ecosystem details
                        window.showEcosystemDetails = function(ecosystemData) {
                            console.log('showEcosystemDetails called with:', ecosystemData);

                            // Populate general information
                            document.getElementById('ecosystem-name').textContent = ecosystemData.ecosystem.name || 'N/A';
                            document.getElementById('ecosystem-organization').textContent = ecosystemData.ecosystem.organization ||
                                'N/A';
                            document.getElementById('ecosystem-description').textContent = ecosystemData.ecosystem.description ||
                                'Tidak ada deskripsi tersedia';
                            document.getElementById('ecosystem-work-region').textContent = ecosystemData.ecosystem.work_region ||
                                'N/A';
                            document.getElementById('ecosystem-member-count').textContent = ecosystemData.totalUsers || 0;

                            // Populate issues
                            const issuesContainer = document.getElementById('ecosystem-issues');
                            issuesContainer.innerHTML = '';
                            if (ecosystemData.ecosystem.issues && ecosystemData.ecosystem.issues.length > 0) {
                                ecosystemData.ecosystem.issues.forEach(issue => {
                                    const issueTag = document.createElement('span');
                                    issueTag.className =
                                        'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800';
                                    issueTag.textContent = issue;
                                    issuesContainer.appendChild(issueTag);
                                });
                            } else {
                                const noIssues = document.createElement('span');
                                noIssues.className = 'text-gray-500 italic';
                                noIssues.textContent = 'Tidak ada isu yang didefinisikan';
                                issuesContainer.appendChild(noIssues);
                            }

                            // Populate existing roles
                            const existingRolesContainer = document.getElementById('existing-roles');
                            existingRolesContainer.innerHTML = '';
                            if (ecosystemData.roles && ecosystemData.roles.length > 0) {
                                ecosystemData.roles.forEach(role => {
                                    const roleCard = document.createElement('div');
                                    roleCard.className =
                                        'bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-4 shadow-sm dark:shadow-slate-900/30';
                                    roleCard.innerHTML = `
                    <div class="flex items-center justify-between mb-2">
                        <h6 class="font-medium text-gray-900 dark:text-slate-100 ">${role.role}</h6>
                        <span class="text-sm text-gray-500 dark:text-slate-400">${role.count} orang</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-slate-300">asdsadsdasdadsa ${role.description || 'Tidak ada deskripsi tersedia'}</p>
                `;
                                    existingRolesContainer.appendChild(roleCard);
                                });
                            } else {
                                const noRoles = document.createElement('div');
                                noRoles.className = 'col-span-2 text-center text-gray-500 dark:text-gray-400 italic py-8';
                                noRoles.textContent = 'Belum ada peran yang terdefinisi';
                                existingRolesContainer.appendChild(noRoles);
                            }

                            // Populate needed roles
                            const neededRolesContainer = document.getElementById('needed-roles');
                            neededRolesContainer.innerHTML = '';
                            if (ecosystemData.needed_roles && ecosystemData.needed_roles.length > 0) {
                                ecosystemData.needed_roles.forEach(role => {
                                    const roleCard = document.createElement('div');
                                    roleCard.className =
                                        'bg-orange-50 dark:bg-slate-800 border border-orange-200 dark:border-slate-700 rounded-lg p-4 shadow-sm dark:shadow-slate-900/30';
                                    roleCard.innerHTML = `
                    <div class="flex items-center justify-between mb-2 ">
                        <h6 class="font-medium text-gray-900 dark:text-slate-100">${role}</h6>
                        <span class="text-sm text-orange-600 dark:text-orange-300 font-medium">Dibutuhkan</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-slate-300">Peran ini masih dibutuhkan dalam ekosistem</p>
                `;
                                    neededRolesContainer.appendChild(roleCard);
                                });
                            } else {
                                const noNeededRoles = document.createElement('div');
                                noNeededRoles.className =
                                    'col-span-2 text-center text-gray-500 dark:text-gray-400 italic py-8';
                                noNeededRoles.textContent = 'Semua peran sudah terpenuhi';
                                neededRolesContainer.appendChild(noNeededRoles);
                            }

                            // Show modal
                            console.log('Showing modal...');
                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                        };

                        console.log('Modal listeners initialized successfully');
                    }

                    // Initialize modal listeners on DOM ready
                    document.addEventListener('DOMContentLoaded', initializeModalListeners);

                    // Re-initialize modal listeners after Livewire navigation
                    document.addEventListener('livewire:navigated', function() {
                        console.log('Re-initializing modal listeners after navigation...');
                        setTimeout(initializeModalListeners, 100);
                    });

                    document.addEventListener('livewire:load', initializeModalListeners);
                    document.addEventListener('livewire:update', function() {
                        setTimeout(initializeModalListeners, 200);
                    });
                    document.addEventListener('livewire:updated', function() {
                        setTimeout(initializeModalListeners, 300);
                    });

                    function createEcosystemMapping(data) {
                        console.log('Creating ecosystem mapping with data:', data);

                        const container = d3.select('#ecosystem-mapping-container');
                        if (container.empty()) {
                            console.error('Container not found in createEcosystemMapping');
                            return;
                        }

                        const width = container.node().offsetWidth;
                        const height = 800 > width ? width : 800;

                        console.log('Container dimensions:', width, 'x', height);

                        // Clear previous content
                        container.selectAll('*').remove();

                        // Create SVG
                        const svg = container.append('svg')
                            .attr('width', width)
                            .attr('height', height)
                            .style('background', 'transparent');

                        // Create zoom behavior
                        const zoom = d3.zoom()
                            .scaleExtent([0.1, 4])
                            .on('zoom', (event) => {
                                console.log('Zoom event triggered');
                                g.attr('transform', event.transform);
                            });

                        svg.call(zoom);

                        // Ensure zoom is properly attached
                        console.log('Zoom behavior attached to SVG');

                        // Main group for all elements
                        const g = svg.append('g');

                        // Center point
                        const centerX = width / 2;
                        const centerY = height / 2;

                        // Create ecosystem nodes
                        const ecosystems = data.ecosystems;

                        // Dynamic sizing based on data count
                        let centralRadius, ecosystemRadius, roleRadius, ecosystemTextSize, roleTextSize, maxEcosystemTextLength,
                            maxRoleTextLength;

                        if (ecosystems.length <= 3) {
                            centralRadius = 80;
                            ecosystemRadius = 50;
                            roleRadius = 22;
                            ecosystemTextSize = '14';
                            roleTextSize = '10';
                            maxEcosystemTextLength = 18;
                            maxRoleTextLength = 12;
                        } else if (ecosystems.length <= 6) {
                            centralRadius = 90;
                            ecosystemRadius = 55;
                            roleRadius = 24;
                            ecosystemTextSize = '12';
                            roleTextSize = '9';
                            maxEcosystemTextLength = 15;
                            maxRoleTextLength = 10;
                        } else if (ecosystems.length <= 10) {
                            centralRadius = 100;
                            ecosystemRadius = 60;
                            roleRadius = 26;
                            ecosystemTextSize = '11';
                            roleTextSize = '8';
                            maxEcosystemTextLength = 12;
                            maxRoleTextLength = 8;
                        } else {
                            centralRadius = 110;
                            ecosystemRadius = 65;
                            roleRadius = 28;
                            ecosystemTextSize = '10';
                            roleTextSize = '7';
                            maxEcosystemTextLength = 10;
                            maxRoleTextLength = 6;
                        }

                        // Helper function for text wrapping
                        function wrapText(text, maxWidth, fontSize) {
                            const words = text.split(' ');
                            const lines = [];
                            let currentLine = '';

                            words.forEach(word => {
                                const testLine = currentLine + (currentLine ? ' ' : '') + word;
                                const testWidth = testLine.length * fontSize * 0.6; // Approximate character width

                                if (testWidth <= maxWidth) {
                                    currentLine = testLine;
                                } else {
                                    if (currentLine) lines.push(currentLine);
                                    currentLine = word;
                                }
                            });
                            if (currentLine) lines.push(currentLine);

                            return lines;
                        }

                        // Create gradients and filters
                        const defs = svg.append('defs');

                        // Central gradient
                        const centralGradient = defs.append('radialGradient')
                            .attr('id', 'centralGradient')
                            .attr('cx', '30%')
                            .attr('cy', '30%')
                            .attr('r', '70%');

                        centralGradient.append('stop')
                            .attr('offset', '0%')
                            .attr('stop-color', '#95bdf5');

                        centralGradient.append('stop')
                            .attr('offset', '100%')
                            .attr('stop-color', '#1E64C8');

                        // Ecosystem gradient
                        const ecosystemGradient = defs.append('radialGradient')
                            .attr('id', 'ecosystemGradient')
                            .attr('cx', '30%')
                            .attr('cy', '30%')
                            .attr('r', '70%');

                        ecosystemGradient.append('stop')
                            .attr('offset', '0%')
                            .attr('stop-color', '#2FB89B');

                        ecosystemGradient.append('stop')
                            .attr('offset', '100%')
                            .attr('stop-color', '#2C6B52');

                        // Role gradient
                        const roleGradient = defs.append('radialGradient')
                            .attr('id', 'roleGradient')
                            .attr('cx', '30%')
                            .attr('cy', '30%')
                            .attr('r', '70%');

                        roleGradient.append('stop')
                            .attr('offset', '0%')
                            .attr('stop-color', '#F0673D');

                        roleGradient.append('stop')
                            .attr('offset', '100%')
                            .attr('stop-color', '#E33A37');

                        // Shadow filter
                        const shadowFilter = defs.append('filter')
                            .attr('id', 'shadow')
                            .attr('x', '-50%')
                            .attr('y', '-50%')
                            .attr('width', '200%')
                            .attr('height', '200%');

                        shadowFilter.append('feDropShadow')
                            .attr('dx', 4)
                            .attr('dy', 4)
                            .attr('stdDeviation', 4)
                            .attr('flood-color', 'rgba(0,0,0,0.25)');

                        // Calculate dynamic radius based on ecosystem count and container size
                        const totalEcosystems = Math.max(ecosystems.length, 1);
                        const angleStep = (2 * Math.PI) / totalEcosystems;

                        // Calculate minimum distance between ecosystem centers to prevent overlap
                        const minDistanceBetweenEcosystems = (ecosystemRadius * 2) + 80; // 80px minimum gap between bubbles

                        // Calculate the required radius to fit all ecosystems with equal spacing
                        // Using the formula: circumference = 2 * π * radius
                        // We need: circumference / totalEcosystems >= minDistanceBetweenEcosystems
                        // So: radius >= (minDistanceBetweenEcosystems * totalEcosystems) / (2 * π)
                        const requiredRadius = (minDistanceBetweenEcosystems * totalEcosystems) / (2 * Math.PI);

                        // MUCH LARGER padding from the center circle - this is the key to wider spacing
                        const centerPadding = centralRadius + ecosystemRadius + 200; // Increased from 120 to 200

                        // Calculate maximum allowed radius (70% of container - increased from 60%)
                        const maxRadius = Math.min(width, height) * 0.7;

                        // Use the larger of required radius or center padding, but not exceeding max radius
                        const radius = Math.max(requiredRadius, centerPadding);

                        // FIRST: Draw all lines from center to ecosystems (behind everything)
                        ecosystems.forEach((ecosystem, index) => {
                            const angle = index * angleStep;
                            const x = centerX + Math.cos(angle) * radius;
                            const y = centerY + Math.sin(angle) * radius;

                            // Draw line from center to ecosystem with solid color for better visibility
                            g.append('line')
                                .attr('x1', centerX)
                                .attr('y1', centerY)
                                .attr('x2', x)
                                .attr('y2', y)
                                .attr('stroke', '#3B82F6')
                                .attr('stroke-width', 3)
                                .attr('opacity', 1.0)
                                .attr('class', 'ecosystem-line')
                                .attr('id', `line-${index}`);
                        });

                        // SECOND: Create central Pasar Kolaboraya node (on top of lines)
                        const centralNode = g.append('g')
                            .attr('class', 'central-node')
                            .attr('transform', `translate(${centerX}, ${centerY})`);

                        // Central circle
                        centralNode.append('circle')
                            .attr('r', centralRadius)
                            .attr('fill', 'url(#centralGradient)')
                            .attr('stroke', '#1E3A8A')
                            .attr('stroke-width', 4)
                            .attr('filter', 'url(#shadow)');

                        // Central text with better sizing and wrapping (on top of everything)
                        const centralTextSize = Math.max(centralRadius * 0.15, 12);
                        const centralText = 'PASAR KOLABORAYA';
                        const maxWidth = centralRadius * 1.8; // Leave some padding
                        const lines = wrapText(centralText, maxWidth, centralTextSize);

                        // Create text elements for each line
                        lines.forEach((line, lineIndex) => {
                            centralNode.append('text')
                                .attr('text-anchor', 'middle')
                                .attr('dy', `${(lineIndex - (lines.length - 1) / 2) * 1.2}em`)
                                .attr('fill', 'white')
                                .attr('font-size', centralTextSize)
                                .attr('font-weight', 'bold')
                                .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                                .text(line);
                        });

                        // Store ecosystem groups for later role creation
                        const ecosystemGroups = [];

                        // FIRST: Draw all ecosystem circles and their content
                        ecosystems.forEach((ecosystem, index) => {
                            const angle = index * angleStep;
                            const x = centerX + Math.cos(angle) * radius;
                            const y = centerY + Math.sin(angle) * radius;

                            const ecosystemGroup = g.append('g')
                                .attr('class', 'ecosystem-group')
                                .attr('transform', `translate(${x}, ${y})`);

                            // Store for later role creation
                            ecosystemGroups.push({
                                group: ecosystemGroup,
                                ecosystem: ecosystem,
                                x: x,
                                y: y
                            });

                            // Ecosystem circle with gradient and shadow
                            ecosystemGroup.append('circle')
                                .attr('r', ecosystemRadius)
                                .attr('fill', 'url(#ecosystemGradient)')
                                .attr('stroke', '#047857')
                                .attr('stroke-width', 3)
                                .attr('filter', 'url(#shadow)')
                                .style('cursor', 'pointer')
                                .on('mouseover', function(event) {
                                    console.log('Ecosystem hovered:', ecosystem.ecosystem.name);
                                    d3.select(this).attr('r', ecosystemRadius + 5);
                                    showEcosystemTooltip(ecosystem, event);
                                    // Show role containers when ecosystem is hovered
                                    g.selectAll('.role-container').style('opacity', 0);
                                    g.selectAll(`.role-container-${index}`).style('opacity', 1);
                                })
                                .on('mouseout', function(event) {
                                    console.log('Ecosystem mouse out:', ecosystem.ecosystem.name);
                                    d3.select(this).attr('r', ecosystemRadius);
                                    hideEcosystemTooltip();
                                    // Hide role containers when ecosystem is not hovered
                                    g.selectAll('.role-container').style('opacity', 0);
                                })
                                .on('click', function(event) {
                                    console.log('Ecosystem clicked:', ecosystem.ecosystem.name);
                                    // Show ecosystem details modal
                                    if (typeof showEcosystemDetails === 'function') {
                                        showEcosystemDetails(ecosystem);
                                    }
                                });

                            // Ecosystem text with better sizing and wrapping
                            const ecosystemTextSize = Math.max(ecosystemRadius * 0.2, 10);
                            const ecosystemText = ecosystem.ecosystem.name;
                            const maxWidth = ecosystemRadius * 1.8; // Leave some padding
                            const lines = wrapText(ecosystemText, maxWidth, ecosystemTextSize);

                            // Limit to maximum 3 lines
                            const displayLines = lines.slice(0, 3);
                            if (lines.length > 3) {
                                displayLines[2] = displayLines[2].substring(0, displayLines[2].length - 3) + '...';
                            }

                            // Create text elements for each line
                            displayLines.forEach((line, lineIndex) => {
                                ecosystemGroup.append('text')
                                    .attr('text-anchor', 'middle')
                                    .attr('dy', `${(lineIndex - (displayLines.length - 1) / 2) * 1.2}em`)
                                    .attr('fill', 'white')
                                    .attr('font-size', ecosystemTextSize)
                                    .attr('font-weight', 'bold')
                                    .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                                    .text(line);
                            });
                        });

                        // SECOND: Create all role containers in a separate layer (on top of ecosystem circles)
                        ecosystemGroups.forEach(({
                            group: ecosystemGroup,
                            ecosystem
                        }, index) => {
                            const roles = ecosystem.roles;
                            if (roles.length > 0) {
                                const roleAngleStep = (2 * Math.PI) / roles.length;

                                // Calculate role radius - distance from ecosystem center to role centers
                                // Similar to how ecosystems are positioned around the central blue bubble
                                const roleDistance = ecosystemRadius + roleRadius + 60; // 60px gap between ecosystem and roles

                                // Create container for all role groups in separate layer
                                const roleContainer = g.append('g')
                                    .attr('class', `role-container role-container-${index}`)
                                    .style('opacity', 0)
                                    .style('transition', 'opacity 0.3s ease');

                                roles.forEach((role, roleIndex) => {
                                    const roleAngle = roleIndex * roleAngleStep;
                                    const ecosystemTransform = ecosystemGroup.attr('transform');
                                    const ecosystemX = parseFloat(ecosystemTransform.match(
                                        /translate\(([^,]+),([^)]+)\)/)[1]);
                                    const ecosystemY = parseFloat(ecosystemTransform.match(
                                        /translate\(([^,]+),([^)]+)\)/)[2]);
                                    const roleX = ecosystemX + Math.cos(roleAngle) * roleDistance;
                                    const roleY = ecosystemY + Math.sin(roleAngle) * roleDistance;

                                    const roleGroup = roleContainer.append('g')
                                        .attr('class', 'role-group')
                                        .attr('transform', `translate(${roleX}, ${roleY})`);

                                    // Role circle with gradient and shadow
                                    roleGroup.append('circle')
                                        .attr('r', roleRadius)
                                        .attr('fill', 'url(#roleGradient)')
                                        .attr('stroke', '#B45309')
                                        .attr('stroke-width', 2)
                                        .attr('filter', 'url(#shadow)')
                                        .on('mouseover', function(event) {
                                            console.log('Role hovered:', role.role);
                                            d3.select(this).attr('r', roleRadius + 4);
                                            showRoleTooltip(role, event);
                                        })
                                        .on('mouseout', function(event) {
                                            console.log('Role mouse out:', role.role);
                                            d3.select(this).attr('r', roleRadius);
                                            hideRoleTooltip();
                                        });

                                    // Role text with better sizing and wrapping
                                    const roleTextSize = Math.max(roleRadius * 0.35, 8);
                                    const roleText = role.role;
                                    const maxWidth = roleRadius * 1.8; // Leave some padding
                                    const lines = wrapText(roleText, maxWidth, roleTextSize);

                                    // Limit to maximum 2 lines for roles
                                    const displayLines = lines.slice(0, 2);
                                    if (lines.length > 2) {
                                        displayLines[1] = displayLines[1].substring(0, displayLines[1].length - 3) +
                                            '...';
                                    }

                                    // Create text elements for each line
                                    displayLines.forEach((line, lineIndex) => {
                                        roleGroup.append('text')
                                            .attr('text-anchor', 'middle')
                                            .attr('dy',
                                                `${(lineIndex - (displayLines.length - 1) / 2) * 1.1}em`)
                                            .attr('fill', 'white')
                                            .attr('font-size', roleTextSize)
                                            .attr('font-weight', 'bold')
                                            .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                                            .text(line);
                                    });

                                    // Role count with better styling
                                    roleGroup.append('text')
                                        .attr('text-anchor', 'middle')
                                        .attr('dy', '2.2em')
                                        .attr('fill', 'white')
                                        .attr('font-size', Math.max(roleTextSize - 2, 6))
                                        .attr('font-weight', 'bold')
                                        .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                                        .text(role.count);
                                });
                            }
                        });

                        // Tooltip for ecosystem details
                        const ecosystemTooltip = d3.select('body').append('div')
                            .attr('class',
                                'absolute z-50 px-4 py-3 bg-gray-900 text-white text-sm rounded-lg shadow-lg pointer-events-none')
                            .style('opacity', 0)
                            .style('display', 'none');

                        function showEcosystemTooltip(ecosystem, event) {
                            console.log('Showing ecosystem tooltip for:', ecosystem.ecosystem.name);
                            ecosystemTooltip
                                .html(`
                        <div class="font-bold mb-2">${ecosystem.ecosystem.name}</div>
                        <div class="text-xs text-gray-300 mb-1">${ecosystem.ecosystem.organization || 'Organisasi'}</div>
                        <div class="text-xs text-gray-400">${ecosystem.totalUsers} pengguna • ${ecosystem.roles.length} peran</div>
                    `)
                                .style('left', (event.pageX) + 'px')
                                .style('top', (event.pageY) + 'px')
                                .style('opacity', 1)
                                .style('display', 'block');
                        }

                        function hideEcosystemTooltip() {
                            ecosystemTooltip.style('opacity', 0)
                                .style('display', 'none');
                        }

                        // Tooltip for role details
                        // const roleTooltip = d3.select('body').append('div')
                        //     .attr('class',
                        //         'absolute z-50 px-4 py-3 bg-gray-900 text-white text-sm rounded-lg shadow-lg pointer-events-none')
                        //     .style('opacity', 0);

                        function showRoleTooltip(role, event) {
                            console.log('Showing role tooltip for:', role.role);
                            const users = role.users.map(user => user.name).join(', ');
                            roleTooltip
                                .html(`
                        <div class="font-bold mb-2">${role.role}</div>
                        <div class="text-xs text-gray-300 mb-1">${role.count} pengguna</div>
                        <div class="text-xs text-gray-400">${users}</div>
                    `)
                                .style('left', (event.pageX + 10) + 'px')
                                .style('top', (event.pageY) + 'px')
                                .style('opacity', 1);
                        }

                        function hideRoleTooltip() {
                            roleTooltip.style('opacity', 0);
                        }

                        // Initial zoom to fit all content with proper spacing
                        setTimeout(() => {
                            const bounds = g.node().getBBox();
                            const padding = 150; // Increased padding for much more breathing room
                            const fullWidth = bounds.width + padding * 2;
                            const fullHeight = bounds.height + padding * 2;
                            const scale = Math.min(width / fullWidth, height / fullHeight,
                                0.7); // Further reduced scale for more space
                            const translate = [width / 2 - scale * (bounds.x + bounds.width / 2),
                                height / 2 - scale * (bounds.y + bounds.height / 2)
                            ];

                            svg.call(zoom.transform, d3.zoomIdentity.translate(translate[0], translate[1]).scale(scale));

                            console.log('Ecosystem mapping visualization completed successfully');
                        }, 100);
                    }

                    // Market search and pagination functionality for guest
                    let currentPageGuest = 1;
                    const itemsPerPageGuest = 8;
                    let allMarketCardsGuest = [];
                    let filteredCardsGuest = [];

                    function initializeMarketSearchGuest() {
                        const searchInput = document.getElementById('marketSearchGuest');
                        const marketContainer = document.getElementById('marketContainerGuest');
                        const noResults = document.getElementById('noResultsGuest');
                        const paginationControls = document.getElementById('paginationControlsGuest');
                        const showingCount = document.getElementById('showingCountGuest');
                        const totalCount = document.getElementById('totalCountGuest');

                        if (!searchInput || !marketContainer) return;

                        // Store all market cards
                        allMarketCardsGuest = Array.from(marketContainer.querySelectorAll('.market-card'));
                        filteredCardsGuest = [...allMarketCardsGuest];

                        // Initialize pagination
                        updatePaginationGuest();
                        updateMarketCountGuest();

                        searchInput.addEventListener('input', function() {
                            const searchTerm = this.value.toLowerCase().trim();

                            // Filter cards based on search term
                            filteredCardsGuest = allMarketCardsGuest.filter(card => {
                                const marketName = card.getAttribute('data-market-name') || '';
                                const marketDescription = card.getAttribute('data-market-description') || '';
                                return marketName.includes(searchTerm) || marketDescription.includes(searchTerm);
                            });

                            // Reset to first page when searching
                            currentPageGuest = 1;

                            // Update display
                            updateMarketDisplayGuest();
                            updatePaginationGuest();
                            updateMarketCountGuest();

                            // Show/hide no results message
                            if (filteredCardsGuest.length === 0 && searchTerm !== '') {
                                noResults.classList.remove('hidden');
                                paginationControls.classList.add('hidden');
                            } else {
                                noResults.classList.add('hidden');
                                paginationControls.classList.toggle('hidden', filteredCardsGuest.length <= itemsPerPageGuest);
                            }
                        });

                        // Pagination event listeners
                        document.getElementById('prevPageGuest').addEventListener('click', () => {
                            if (currentPageGuest > 1) {
                                currentPageGuest--;
                                updateMarketDisplayGuest();
                                updatePaginationGuest();
                                updateMarketCountGuest();
                            }
                        });

                        document.getElementById('nextPageGuest').addEventListener('click', () => {
                            const totalPages = Math.ceil(filteredCardsGuest.length / itemsPerPageGuest);
                            if (currentPageGuest < totalPages) {
                                currentPageGuest++;
                                updateMarketDisplayGuest();
                                updatePaginationGuest();
                                updateMarketCountGuest();
                            }
                        });
                    }

                    function updateMarketDisplayGuest() {
                        // Hide all cards first
                        allMarketCardsGuest.forEach(card => card.style.display = 'none');

                        // Show cards for current page
                        const startIndex = (currentPageGuest - 1) * itemsPerPageGuest;
                        const endIndex = startIndex + itemsPerPageGuest;
                        const cardsToShow = filteredCardsGuest.slice(startIndex, endIndex);

                        cardsToShow.forEach(card => card.style.display = 'block');
                    }

                    function updatePaginationGuest() {
                        const totalPages = Math.ceil(filteredCardsGuest.length / itemsPerPageGuest);
                        const pageNumbers = document.getElementById('pageNumbersGuest');
                        const prevBtn = document.getElementById('prevPageGuest');
                        const nextBtn = document.getElementById('nextPageGuest');

                        // Update button states
                        prevBtn.disabled = currentPageGuest === 1;
                        nextBtn.disabled = currentPageGuest === totalPages;

                        // Generate page numbers
                        pageNumbers.innerHTML = '';
                        const maxVisiblePages = 5;
                        let startPage = Math.max(1, currentPageGuest - Math.floor(maxVisiblePages / 2));
                        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

                        if (endPage - startPage + 1 < maxVisiblePages) {
                            startPage = Math.max(1, endPage - maxVisiblePages + 1);
                        }

                        for (let i = startPage; i <= endPage; i++) {
                            const pageBtn = document.createElement('button');
                            pageBtn.textContent = i;
                            pageBtn.className = `px-3 py-2 rounded-lg text-sm transition-all duration-300 ${
                                i === currentPageGuest 
                                    ? 'bg-white/20 text-white border border-white/40' 
                                    : 'bg-white/10 text-white/80 hover:bg-white/15'
                            }`;
                            pageBtn.addEventListener('click', () => {
                                currentPageGuest = i;
                                updateMarketDisplayGuest();
                                updatePaginationGuest();
                                updateMarketCountGuest();
                            });
                            pageNumbers.appendChild(pageBtn);
                        }
                    }

                    function updateMarketCountGuest() {
                        const showingCount = document.getElementById('showingCountGuest');
                        const totalCount = document.getElementById('totalCountGuest');
                        const startIndex = (currentPageGuest - 1) * itemsPerPageGuest;
                        const endIndex = Math.min(startIndex + itemsPerPageGuest, filteredCardsGuest.length);

                        showingCount.textContent = endIndex - startIndex;
                        totalCount.textContent = filteredCardsGuest.length;
                    }

                    // Initialize search when DOM is loaded
                    document.addEventListener('DOMContentLoaded', function() {
                        initializeMarketSearchGuest();
                    });
                </script>
            @endif
        </div>
    </body>

    </html>
@endauth
