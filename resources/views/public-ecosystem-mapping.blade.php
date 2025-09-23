@auth
    <x-layouts.app title="Peta Ekosistem Kolaboraya - {{ $selectedPasar->name ?? 'Pasar Kolaboraya' }}">
        <script src="https://d3js.org/d3.v7.min.js"></script>

        <style>
            .market-selector {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .market-card {
                transition: all 0.3s ease;
            }

            .market-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            .market-card.selected {
                border-color: #3b82f6;
                background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            }
        </style>
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
                .market-selector {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                }

                .market-card {
                    transition: all 0.3s ease;
                }

                .market-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
                }

                .market-card.selected {
                    border-color: #3b82f6;
                    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
                }
            </style>
        </head>

        <body class="bg-gray-50 dark:bg-gray-900">
            <div class="min-h-screen">
            @endauth

            <!-- Header -->
            <div class="market-selector text-white py-8">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-bold mb-4">
                            Peta Ekosistem Kolaboraya
                        </h1>
                        <p class="text-lg opacity-90 max-w-3xl mx-auto">
                            Visualisasi interaktif ekosistem, peran, dan kolaborator dalam Pasar Kolaboraya.
                            Pilih pasar untuk melihat peta ekosistemnya.
                        </p>
                    </div>

                    <!-- Market Selector -->
                    @if ($pasarKolaborayaList->count() > 1)
                        <div class="max-w-6xl mx-auto">
                            <h2 class="text-2xl font-semibold mb-6 text-center">Pilih Pasar Kolaboraya</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($pasarKolaborayaList as $pasar)
                                    <a href="{{ route('public.ecosystem.mapping', ['pasar_id' => $pasar->id]) }}"
                                        class="market-card block p-6 bg-white/10 backdrop-blur-sm rounded-xl border-2 border-white/20 {{ $selectedPasar && $selectedPasar->id === $pasar->id ? 'selected' : '' }}">
                                        <h3 class="text-xl font-semibold mb-2">{{ $pasar->name }}</h3>
                                        <p class="text-sm opacity-80">{{ Str::limit($pasar->description, 100) }}</p>
                                        @if ($selectedPasar && $selectedPasar->id === $pasar->id)
                                            <div class="mt-3 flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Sedang Dipilih
                                            </div>
                                        @endif
                                    </a>
                                @endforeach
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
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center shadow-lg">
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
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
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

                        <div
                            class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div
                                class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Jaringan</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Temukan koneksi dan peluang kolaborasi baru melalui
                                visualisasi jaringan yang komprehensif.
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
        </div>
        

        <!-- Ecosystem Detail Modal -->
        @include('components.ecosystem-detail-modal')

        @if ($selectedPasar && $ecosystems->count() > 0)
            <script>
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
                        document.getElementById('ecosystem-organization').textContent = ecosystemData.ecosystem.organization || 'N/A';
                        document.getElementById('ecosystem-description').textContent = ecosystemData.ecosystem.description || 'Tidak ada deskripsi tersedia';
                        document.getElementById('ecosystem-work-region').textContent = ecosystemData.ecosystem.work_region || 'N/A';
                        document.getElementById('ecosystem-member-count').textContent = ecosystemData.totalUsers || 0;

                        // Populate issues
                        const issuesContainer = document.getElementById('ecosystem-issues');
                        issuesContainer.innerHTML = '';
                        if (ecosystemData.ecosystem.issues && ecosystemData.ecosystem.issues.length > 0) {
                            ecosystemData.ecosystem.issues.forEach(issue => {
                                const issueTag = document.createElement('span');
                                issueTag.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800';
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
                                roleCard.className = 'bg-white border border-gray-200 rounded-lg p-4 shadow-sm';
                                roleCard.innerHTML = `
                                    <div class="flex items-center justify-between mb-2">
                                        <h6 class="font-medium text-gray-900">${role.role}</h6>
                                        <span class="text-sm text-gray-500">${role.count} orang</span>
                                    </div>
                                    <p class="text-sm text-gray-600">${role.description || 'Tidak ada deskripsi tersedia'}</p>
                                `;
                                existingRolesContainer.appendChild(roleCard);
                            });
                        } else {
                            const noRoles = document.createElement('div');
                            noRoles.className = 'col-span-2 text-center text-gray-500 italic py-8';
                            noRoles.textContent = 'Belum ada peran yang terdefinisi';
                            existingRolesContainer.appendChild(noRoles);
                        }

                        // Populate needed roles
                        const neededRolesContainer = document.getElementById('needed-roles');
                        neededRolesContainer.innerHTML = '';
                        if (ecosystemData.needed_roles && ecosystemData.needed_roles.length > 0) {
                            ecosystemData.needed_roles.forEach(role => {
                                const roleCard = document.createElement('div');
                                roleCard.className = 'bg-orange-50 border border-orange-200 rounded-lg p-4 shadow-sm';
                                roleCard.innerHTML = `
                                    <div class="flex items-center justify-between mb-2">
                                        <h6 class="font-medium text-gray-900">${role}</h6>
                                        <span class="text-sm text-orange-600 font-medium">Dibutuhkan</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Peran ini masih dibutuhkan dalam ekosistem</p>
                                `;
                                neededRolesContainer.appendChild(roleCard);
                            });
                        } else {
                            const noNeededRoles = document.createElement('div');
                            noNeededRoles.className = 'col-span-2 text-center text-gray-500 italic py-8';
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
                    const height = container.node().offsetHeight;
                    
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
                        .attr('stop-color', '#60A5FA');

                    centralGradient.append('stop')
                        .attr('offset', '100%')
                        .attr('stop-color', '#1E40AF');

                    // Ecosystem gradient
                    const ecosystemGradient = defs.append('radialGradient')
                        .attr('id', 'ecosystemGradient')
                        .attr('cx', '30%')
                        .attr('cy', '30%')
                        .attr('r', '70%');

                    ecosystemGradient.append('stop')
                        .attr('offset', '0%')
                        .attr('stop-color', '#34D399');

                    ecosystemGradient.append('stop')
                        .attr('offset', '100%')
                        .attr('stop-color', '#059669');

                    // Role gradient
                    const roleGradient = defs.append('radialGradient')
                        .attr('id', 'roleGradient')
                        .attr('cx', '30%')
                        .attr('cy', '30%')
                        .attr('r', '70%');

                    roleGradient.append('stop')
                        .attr('offset', '0%')
                        .attr('stop-color', '#F59E0B');

                    roleGradient.append('stop')
                        .attr('offset', '100%')
                        .attr('stop-color', '#D97706');

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
                    const radius = Math.min(Math.max(requiredRadius, centerPadding), maxRadius);

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
                        .style('opacity', 0);

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
                            .style('opacity', 1);
                    }

                    function hideEcosystemTooltip() {
                        ecosystemTooltip.style('opacity', 0);
                    }

                    // Tooltip for role details
                    const roleTooltip = d3.select('body').append('div')
                        .attr('class',
                            'absolute z-50 px-4 py-3 bg-gray-900 text-white text-sm rounded-lg shadow-lg pointer-events-none')
                        .style('opacity', 0);

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
            </script>
        @endif
        @auth
    </x-layouts.app>
@else
    </body>

    </html>
@endauth
