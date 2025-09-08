<div class="space-y-6">
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $ecosystem->ecosystem_title }}</h1>
                <p class="text-gray-600 dark:text-slate-300 mt-1">{{ $ecosystem->organization_name }}</p>
                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500 dark:text-slate-400">
                    <span>📍 {{ $ecosystem->work_region }}</span>
                    <span>👥 {{ $ecosystem->acceptedUsers()->count() }} anggota</span>
                    @if($ecosystem->max_users)
                        <span>📊 {{ $ecosystem->acceptedUsers()->count() }}/{{ $ecosystem->max_users }} kapasitas</span>
                    @endif
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $ecosystemQuality['percentage'] }}%</div>
                <div class="text-sm text-gray-500 dark:text-slate-400">Kualitas Ekosistem</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="border-b border-gray-200 dark:border-slate-700">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button wire:click="setActiveTab('overview')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'overview' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 hover:border-gray-300 dark:hover:border-slate-600' }}">
                    Ringkasan
                </button>
                <button wire:click="setActiveTab('members')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'members' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 hover:border-gray-300 dark:hover:border-slate-600' }}">
                    Anggota
                    @if($pendingRequests->count() > 0)
                        <span class="ml-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 py-1 px-2 rounded-full text-xs">{{ $pendingRequests->count() }}</span>
                    @endif
                </button>
                <button wire:click="setActiveTab('quality')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'quality' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 hover:border-gray-300 dark:hover:border-slate-600' }}">
                    Kualitas & Keahlian
                </button>
                <button wire:click="setActiveTab('actions')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'actions' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 hover:border-gray-300 dark:hover:border-slate-600' }}">
                    Aksi Kolektif
                </button>
            </nav>
        </div>

        <div class="p-6">
            <!-- Overview Tab -->
            @if($activeTab === 'overview')
                <div class="space-y-6">
                    <!-- Quality Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-6 border border-green-200 dark:border-green-800">
                            <div class="flex items-center">
                                <div class="text-3xl">🎯</div>
                                <div class="ml-4">
                                    <div class="text-2xl font-bold text-green-700 dark:text-green-400">{{ $ecosystemQuality['percentage'] }}%</div>
                                    <div class="text-sm text-green-600 dark:text-green-300">Kualitas Ekosistem</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center">
                                <div class="text-3xl">🧠</div>
                                <div class="ml-4">
                                    <div class="text-2xl font-bold text-blue-700 dark:text-blue-400">{{ $ecosystemQuality['covered_skills'] }}</div>
                                    <div class="text-sm text-blue-600 dark:text-blue-300">Keahlian Tercakup</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg p-6 border border-purple-200 dark:border-purple-800">
                            <div class="flex items-center">
                                <div class="text-3xl">👥</div>
                                <div class="ml-4">
                                    <div class="text-2xl font-bold text-purple-700 dark:text-purple-400">{{ $ecosystem->acceptedUsers()->count() }}</div>
                                    <div class="text-sm text-purple-600 dark:text-purple-300">Anggota Aktif</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-6 border border-gray-200 dark:border-slate-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-3">Deskripsi Ekosistem</h3>
                        <p class="text-gray-700 dark:text-slate-300">{{ $ecosystem->description ?: 'Belum ada deskripsi.' }}</p>
                    </div>

                    <!-- Recent Activities -->
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Aktivitas Terbaru</h3>
                        </div>
                        <div class="p-6">
                            @if($pendingRequests->count() > 0)
                                <div class="flex items-center text-amber-600 dark:text-amber-400 mb-4">
                                    <div class="w-3 h-3 bg-amber-500 dark:bg-amber-400 rounded-full mr-3"></div>
                                    <span>{{ $pendingRequests->count() }} permintaan bergabung menunggu persetujuan</span>
                                </div>
                            @endif
                            
                            @if($ecosystem->acceptedUsers()->count() === 0)
                                <div class="flex items-center text-gray-500 dark:text-slate-400">
                                    <div class="w-3 h-3 bg-gray-400 dark:bg-slate-500 rounded-full mr-3"></div>
                                    <span>Belum ada anggota yang bergabung</span>
                                </div>
                            @else
                                <div class="flex items-center text-green-600 dark:text-green-400">
                                    <div class="w-3 h-3 bg-green-500 dark:bg-green-400 rounded-full mr-3"></div>
                                    <span>{{ $ecosystem->acceptedUsers()->count() }} anggota telah bergabung</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Members Tab -->
            @if($activeTab === 'members')
                <div class="space-y-6">
                    <!-- Pending Requests -->
                    @if($pendingRequests->count() > 0)
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                            <div class="p-6 border-b border-amber-200 dark:border-amber-800">
                                <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-200">Permintaan Bergabung ({{ $pendingRequests->count() }})</h3>
                            </div>
                            <div class="divide-y divide-amber-200 dark:divide-amber-800">
                                @foreach($pendingRequests as $request)
                                    <div class="p-6 flex items-start justify-between">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-12 h-12 bg-gray-300 dark:bg-slate-600 rounded-full flex items-center justify-center">
                                                @if($request->profile && $request->profile->profile_photo)
                                                    <img src="{{ asset('storage/' . $request->profile->profile_photo) }}" alt="{{ $request->name }}" class="w-12 h-12 rounded-full object-cover">
                                                @else
                                                    <span class="text-lg text-gray-600 dark:text-slate-300">{{ substr($request->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-slate-100">{{ $request->name }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-slate-300">{{ $request->email }}</p>
                                                @if($request->profile && $request->profile->organization)
                                                    <p class="text-sm text-gray-500 dark:text-slate-400">{{ $request->profile->organization }}</p>
                                                @endif
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-700 dark:text-slate-300"><strong>Alasan bergabung:</strong></p>
                                                    <p class="text-sm text-gray-600 dark:text-slate-400">{{ $request->pivot->join_reason }}</p>
                                                </div>
                                                @if($request->profile && $request->profile->skills->count() > 0)
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-700 dark:text-slate-300 mb-1"><strong>Keahlian:</strong></p>
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($request->profile->skills->take(5) as $skill)
                                                                <span class="inline-block bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs px-2 py-1 rounded">{{ $skill->name }}</span>
                                                            @endforeach
                                                            @if($request->profile->skills->count() > 5)
                                                                <span class="inline-block bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 text-xs px-2 py-1 rounded">+{{ $request->profile->skills->count() - 5 }} lainnya</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button wire:click="acceptMember({{ $request->id }})" 
                                                    class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                Terima
                                            </button>
                                            <button wire:click="rejectMember({{ $request->id }})" 
                                                    class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                Tolak
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Accepted Members -->
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Anggota Aktif ({{ $acceptedMembers->total() }})</h3>
                        </div>
                        @if($acceptedMembers->count() > 0)
                            <div class="divide-y divide-gray-200 dark:divide-slate-700">
                                @foreach($acceptedMembers as $member)
                                    <div class="p-6 flex items-start justify-between">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-12 h-12 bg-gray-300 dark:bg-slate-600 rounded-full flex items-center justify-center">
                                                @if($member->profile && $member->profile->profile_photo)
                                                    <img src="{{ asset('storage/' . $member->profile->profile_photo) }}" alt="{{ $member->name }}" class="w-12 h-12 rounded-full object-cover">
                                                @else
                                                    <span class="text-lg text-gray-600 dark:text-slate-300">{{ substr($member->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-slate-100">{{ $member->name }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-slate-300">{{ $member->email }}</p>
                                                @if($member->profile && $member->profile->organization)
                                                    <p class="text-sm text-gray-500 dark:text-slate-400">{{ $member->profile->organization }}</p>
                                                @endif
                                                @if($member->pivot->joined_at)
                                                    <p class="text-sm text-gray-500 dark:text-slate-400">Bergabung: {{ Carbon\Carbon::parse($member->pivot->joined_at)->format('d M Y') }}</p>
                                                @endif
                                                @if($member->profile && $member->profile->skills->count() > 0)
                                                    <div class="mt-2">
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($member->profile->skills->take(5) as $skill)
                                                                <span class="inline-block bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs px-2 py-1 rounded">{{ $skill->name }}</span>
                                                            @endforeach
                                                            @if($member->profile->skills->count() > 5)
                                                                <span class="inline-block bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 text-xs px-2 py-1 rounded">+{{ $member->profile->skills->count() - 5 }} lainnya</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button wire:click="removeMember({{ $member->id }})" 
                                                    onclick="return confirm('Apakah Anda yakin ingin mengeluarkan {{ $member->name }} dari ekosistem ini?')"
                                                    class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                Keluarkan
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="p-6 border-t border-gray-200 dark:border-slate-700">
                                {{ $acceptedMembers->links() }}
                            </div>
                        @else
                            <div class="p-6 text-center text-gray-500 dark:text-slate-400">
                                Belum ada anggota yang bergabung.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quality Tab -->
            @if($activeTab === 'quality')
                @php
                    $skillsBreakdown = $ecosystem->getSkillsBreakdown();
                    $neededSkillsGap = $ecosystem->getNeededSkillsGap();
                @endphp
                
                <div class="space-y-6">
                    <!-- Quality Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $ecosystemQuality['percentage'] }}%</div>
                            <div class="text-sm text-gray-600 dark:text-slate-400 mt-1">Kualitas Keseluruhan</div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $ecosystemQuality['covered_skills'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-400 mt-1">Keahlian Tercakup</div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $ecosystemQuality['existing_skills_count'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-400 mt-1">Keahlian Ekosistem</div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $ecosystemQuality['member_skills_count'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-400 mt-1">Keahlian Anggota</div>
                        </div>
                    </div>

                    <!-- Skills Breakdown -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Existing Skills -->
                        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Keahlian Ekosistem</h3>
                            </div>
                            <div class="p-6">
                                @if($skillsBreakdown['existing_skills']->count() > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach($skillsBreakdown['existing_skills'] as $skill)
                                            <div class="flex items-center space-x-2">
                                                <span class="text-2xl">{{ $skill->icon ?? '🔧' }}</span>
                                                <span class="text-sm text-gray-700 dark:text-slate-300">{{ $skill->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-slate-400 text-center">Belum ada keahlian yang ditetapkan.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Member Skills -->
                        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Keahlian Anggota</h3>
                            </div>
                            <div class="p-6">
                                @if($skillsBreakdown['member_skills']->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($skillsBreakdown['member_skills'] as $skillData)
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-lg">{{ $skillData['skill']->icon ?? '🔧' }}</span>
                                                    <span class="text-sm text-gray-700 dark:text-slate-300">{{ $skillData['skill']->name }}</span>
                                                </div>
                                                <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs px-2 py-1 rounded">{{ $skillData['user_count'] }} orang</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-slate-400 text-center">Belum ada anggota dengan keahlian.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Needed Skills Gap -->
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Analisis Kebutuhan Keahlian</h3>
                            <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">Tingkat kecukupan: {{ $neededSkillsGap['coverage_percentage'] }}%</p>
                        </div>
                        <div class="p-6">
                            @if($neededSkillsGap['gap_skills']->count() > 0)
                                <div class="mb-4">
                                    <h4 class="font-medium text-red-700 dark:text-red-400 mb-2">🚨 Keahlian yang Masih Dibutuhkan:</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                        @foreach($neededSkillsGap['gap_skills'] as $skill)
                                            <div class="flex items-center space-x-2 bg-red-50 dark:bg-red-900/20 p-2 rounded border border-red-200 dark:border-red-800">
                                                <span class="text-lg">{{ $skill->icon ?? '❗' }}</span>
                                                <span class="text-sm text-red-700 dark:text-red-300">{{ $skill->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-green-600 dark:text-green-400">
                                    <div class="text-4xl mb-2">✅</div>
                                    <p class="font-medium">Semua keahlian yang dibutuhkan sudah tercakup!</p>
                                </div>
                            @endif

                            @if($neededSkillsGap['needed_skills']->count() > 0)
                                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                                    <h4 class="font-medium text-gray-700 dark:text-slate-300 mb-2">📋 Total Keahlian yang Dibutuhkan:</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                        @foreach($neededSkillsGap['needed_skills'] as $skill)
                                            @php
                                                $isCovered = !$neededSkillsGap['gap_skills']->contains('id', $skill->id);
                                            @endphp
                                            <div class="flex items-center space-x-2 p-2 rounded {{ $isCovered ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 'bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600' }}">
                                                <span class="text-lg">{{ $skill->icon ?? '🔧' }}</span>
                                                <span class="text-sm {{ $isCovered ? 'text-green-700 dark:text-green-300' : 'text-gray-700 dark:text-slate-300' }}">{{ $skill->name }}</span>
                                                @if($isCovered)
                                                    <span class="text-green-600 dark:text-green-400">✓</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Actions Tab -->
            @if($activeTab === 'actions')
                <div class="space-y-6">
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Aksi Kolektif</h3>
                        </div>
                        <div class="p-6">
                            @if($ecosystem->collectiveActions->count() > 0)
                                <div class="space-y-4">
                                    @foreach($ecosystem->collectiveActions as $action)
                                        <div class="border border-gray-200 dark:border-slate-700 rounded-lg p-4 bg-gray-50 dark:bg-slate-700/50">
                                            <h4 class="font-semibold text-gray-900 dark:text-slate-100">{{ $action->title }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-slate-300 mt-1">{{ $action->description }}</p>
                                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500 dark:text-slate-400">
                                                <span>📅 {{ $action->start_date ? $action->start_date->format('d M Y') : 'Tanggal belum ditentukan' }}</span>
                                                <span>📍 {{ $action->location ?? 'Lokasi belum ditentukan' }}</span>
                                                <span class="px-2 py-1 rounded text-xs {{ $action->status === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-gray-100 dark:bg-slate-600 text-gray-800 dark:text-slate-300' }}">
                                                    {{ ucfirst($action->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-gray-500 dark:text-slate-400">
                                    <div class="text-4xl mb-2">📋</div>
                                    <p>Belum ada aksi kolektif yang dibuat.</p>
                                    <a href="{{ route('collective-action.create') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        Buat Aksi Kolektif
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
