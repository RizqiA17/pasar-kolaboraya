<div class="space-y-6">
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div
            class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div
            class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
        <div class="flex items-start justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $ecosystem->ecosystem_title }}
                    </h1>
                    @if ($isOwner)
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pemilik
                        </span>
                    @elseif($isEcosystemBuilder)
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Ecosystem Builder
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Pengunjung
                        </span>
                    @endif
                    @if ($isReadOnly)
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Mode Lihat Saja
                        </span>
                    @endif
                </div>
                <p class="text-gray-600 dark:text-slate-300 mt-1">{{ $ecosystem->organization_name }}</p>
                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500 dark:text-slate-400">
                    <span>📍 {{ $ecosystem->work_region }}</span>
                    <span>👥 {{ $ecosystem->acceptedUsers()->count() }} anggota</span>
                    @if ($ecosystem->max_users)
                        <span>📊 {{ $ecosystem->acceptedUsers()->count() }}/{{ $ecosystem->max_users }} kapasitas</span>
                    @endif
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                    {{ $ecosystemQuality['percentage'] }}%</div>
                <div class="text-sm text-gray-500 dark:text-slate-400">Kualitas Ekosistem</div>
                @if ($isOwner)
                    <div class="mt-3">
                        <a href="{{ route('ecosystem.settings', $ecosystem) }}" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-md text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Pengaturan
                        </a>
                    </div>
                @endif
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
                @if ($isOwner || $isEcosystemBuilder)
                    <button wire:click="setActiveTab('members')"
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'members' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 hover:border-gray-300 dark:hover:border-slate-600' }}">
                        Anggota
                        @if ($pendingRequests->count() > 0)
                            <span
                                class="ml-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 py-1 px-2 rounded-full text-xs">{{ $pendingRequests->count() }}</span>
                        @endif
                    </button>
                    @if ($isOwner)
                        <button wire:click="setActiveTab('invitations')"
                            class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'invitations' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 hover:border-gray-300 dark:hover:border-slate-600' }}">
                            Undangan Aksi
                            @if ($pendingInvitations->count() > 0)
                                <span
                                    class="ml-2 bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 py-1 px-2 rounded-full text-xs">{{ $pendingInvitations->count() }}</span>
                            @endif
                        </button>
                    @endif
                @endif
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
            @if ($activeTab === 'overview')
                <div class="space-y-6">
                    <!-- Quality Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div
                            class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-6 border border-green-200 dark:border-green-800">
                            <div class="flex items-center">
                                <div class="text-3xl">🎯</div>
                                <div class="ml-4">
                                    <div class="text-2xl font-bold text-green-700 dark:text-green-400">
                                        {{ $ecosystemQuality['percentage'] }}%</div>
                                    <div class="text-sm text-green-600 dark:text-green-300">Kualitas Ekosistem</div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center">
                                <div class="text-3xl">🧠</div>
                                <div class="ml-4">
                                    <div class="text-2xl font-bold text-blue-700 dark:text-blue-400">
                                        {{ $ecosystemQuality['covered_skills'] }}</div>
                                    <div class="text-sm text-blue-600 dark:text-blue-300">Keahlian Tercakup</div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg p-6 border border-purple-200 dark:border-purple-800">
                            <div class="flex items-center">
                                <div class="text-3xl">👥</div>
                                <div class="ml-4">
                                    <div class="text-2xl font-bold text-purple-700 dark:text-purple-400">
                                        {{ $ecosystem->acceptedUsers()->count() }}</div>
                                    <div class="text-sm text-purple-600 dark:text-purple-300">Anggota Aktif</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div
                        class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-6 border border-gray-200 dark:border-slate-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-3">Deskripsi Ekosistem
                        </h3>
                        <p class="text-gray-700 dark:text-slate-300">
                            {{ $ecosystem->description ?: 'Belum ada deskripsi.' }}</p>
                    </div>

                    <!-- User Status Info (for non-owners) -->
                    @if (!$isOwner)
                        @php
                            $userStatus = $ecosystem->getUserStatus(Auth::user());
                            $canJoin = $ecosystem->canUserJoin(Auth::user());
                        @endphp

                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">Status Anda</h3>

                            @if ($userStatus === 'accepted')
                                <div class="flex items-center text-green-700 dark:text-green-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="font-medium">Anda adalah anggota aktif dari ekosistem ini</span>
                                </div>
                            @elseif($userStatus === 'pending')
                                <div class="flex items-center text-amber-700 dark:text-amber-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium">Permintaan bergabung Anda sedang menunggu
                                        persetujuan</span>
                                </div>
                            @elseif($canJoin)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-blue-700 dark:text-blue-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span class="font-medium">Anda dapat bergabung dengan ekosistem ini</span>
                                    </div>
                                    <a href="{{ route('ecosystem.join', $ecosystem) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        Bergabung Sekarang
                                    </a>
                                </div>
                            @else
                                <div class="flex items-center text-gray-700 dark:text-gray-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium">Anda tidak dapat bergabung dengan ekosistem ini</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Recent Activities -->
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Aktivitas Terbaru</h3>
                        </div>
                        <div class="p-6">
                            @if ($isOwner)
                                @if ($pendingRequests->count() > 0)
                                    <div class="flex items-center text-amber-600 dark:text-amber-400 mb-4">
                                        <div class="w-3 h-3 bg-amber-500 dark:bg-amber-400 rounded-full mr-3"></div>
                                        <span>{{ $pendingRequests->count() }} permintaan bergabung menunggu
                                            persetujuan</span>
                                    </div>
                                @endif

                                @if ($ecosystem->acceptedUsers()->count() === 0)
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
                            @else
                                @php
                                    $userStatus = $ecosystem->getUserStatus(Auth::user());
                                @endphp

                                @if ($userStatus === 'accepted')
                                    <div class="flex items-center text-green-600 dark:text-green-400 mb-4">
                                        <div class="w-3 h-3 bg-green-500 dark:bg-green-400 rounded-full mr-3"></div>
                                        <span>Anda adalah anggota aktif dari ekosistem ini</span>
                                    </div>
                                @elseif($userStatus === 'pending')
                                    <div class="flex items-center text-amber-600 dark:text-amber-400 mb-4">
                                        <div class="w-3 h-3 bg-amber-500 dark:bg-amber-400 rounded-full mr-3"></div>
                                        <span>Permintaan bergabung Anda sedang menunggu persetujuan</span>
                                    </div>
                                @else
                                    <div class="flex items-center text-blue-600 dark:text-blue-400 mb-4">
                                        <div class="w-3 h-3 bg-blue-500 dark:bg-blue-400 rounded-full mr-3"></div>
                                        <span>Anda dapat bergabung dengan ekosistem ini</span>
                                    </div>
                                @endif

                                <div class="flex items-center text-gray-500 dark:text-slate-400">
                                    <div class="w-3 h-3 bg-gray-400 dark:bg-slate-500 rounded-full mr-3"></div>
                                    <span>{{ $ecosystem->acceptedUsers()->count() }} anggota aktif</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Members Tab -->
            @if ($activeTab === 'members')
                <div class="space-y-6">
                    @if ($isReadOnly)
                        <div
                            class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400 mr-2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <p class="text-orange-800 dark:text-orange-200 text-sm">
                                    <strong>Mode Lihat Saja:</strong> Anda hanya dapat melihat informasi anggota. Untuk
                                    mengelola anggota, Anda perlu menjadi ecosystem builder atau pemilik ekosistem.
                                </p>
                            </div>
                        </div>
                    @endif
                    <!-- Pending Requests -->
                    @if ($pendingRequests->count() > 0)
                        <div
                            class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                            <div class="p-6 border-b border-amber-200 dark:border-amber-800">
                                <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-200">Permintaan
                                    Bergabung ({{ $pendingRequests->count() }})</h3>
                            </div>
                            <div class="divide-y divide-amber-200 dark:divide-amber-800">
                                @foreach ($pendingRequests as $request)
                                    <div class="p-6 flex items-start justify-between">
                                        <div class="flex items-start space-x-4">
                                            <div
                                                class="w-12 h-12 bg-gray-300 dark:bg-slate-600 rounded-full flex items-center justify-center">
                                                @if ($request->profile && $request->profile->profile_photo)
                                                    <img src="{{ asset('storage/' . $request->profile->profile_photo) }}"
                                                        alt="{{ $request->name }}"
                                                        class="w-12 h-12 rounded-full object-cover">
                                                @else
                                                    <span
                                                        class="text-lg text-gray-600 dark:text-slate-300">{{ substr($request->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-slate-100">
                                                    {{ $request->name }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-slate-300">
                                                    {{ $request->email }}</p>
                                                @if ($request->profile && $request->profile->organization)
                                                    <p class="text-sm text-gray-500 dark:text-slate-400">
                                                        {{ $request->profile->organization }}</p>
                                                @endif
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-700 dark:text-slate-300"><strong>Alasan
                                                            bergabung:</strong></p>
                                                    <p class="text-sm text-gray-600 dark:text-slate-400">
                                                        {{ $request->pivot->join_reason }}</p>
                                                </div>
                                                @if ($request->profile && $request->profile->skills->count() > 0)
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-700 dark:text-slate-300 mb-1">
                                                            <strong>Keahlian:</strong>
                                                        </p>
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach ($request->profile->skills->take(5) as $skill)
                                                                <span
                                                                    class="inline-block bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs px-2 py-1 rounded">{{ $skill->name }}</span>
                                                            @endforeach
                                                            @if ($request->profile->skills->count() > 5)
                                                                <span
                                                                    class="inline-block bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 text-xs px-2 py-1 rounded">+{{ $request->profile->skills->count() - 5 }}
                                                                    lainnya</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($isOwner)
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
                                        @else
                                            <div class="text-sm text-gray-500 dark:text-slate-400">
                                                Menunggu persetujuan pemilik
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Accepted Members -->
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Anggota Aktif
                                ({{ $acceptedMembers->total() }})</h3>
                        </div>
                        @if ($acceptedMembers->count() > 0)
                            <div class="divide-y divide-gray-200 dark:divide-slate-700">
                                @foreach ($acceptedMembers as $member)
                                    <div class="p-6 flex items-start justify-between">
                                        <div class="flex items-start space-x-4">
                                            <div
                                                class="w-12 h-12 bg-gray-300 dark:bg-slate-600 rounded-full flex items-center justify-center">
                                                @if ($member->profile && $member->profile->profile_photo)
                                                    <img src="{{ asset('storage/' . $member->profile->profile_photo) }}"
                                                        alt="{{ $member->name }}"
                                                        class="w-12 h-12 rounded-full object-cover">
                                                @else
                                                    <span
                                                        class="text-lg text-gray-600 dark:text-slate-300">{{ substr($member->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-slate-100">
                                                    {{ $member->name }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-slate-300">
                                                    {{ $member->email }}</p>
                                                @if ($member->profile && $member->profile->organization)
                                                    <p class="text-sm text-gray-500 dark:text-slate-400">
                                                        {{ $member->profile->organization }}</p>
                                                @endif
                                                @if ($member->pivot->joined_at)
                                                    <p class="text-sm text-gray-500 dark:text-slate-400">Bergabung:
                                                        {{ Carbon\Carbon::parse($member->pivot->joined_at)->format('d M Y') }}
                                                    </p>
                                                @endif
                                                @if ($member->profile && $member->profile->skills->count() > 0)
                                                    <div class="mt-2">
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach ($member->profile->skills->take(5) as $skill)
                                                                <span
                                                                    class="inline-block bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs px-2 py-1 rounded">{{ $skill->name }}</span>
                                                            @endforeach
                                                            @if ($member->profile->skills->count() > 5)
                                                                <span
                                                                    class="inline-block bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 text-xs px-2 py-1 rounded">+{{ $member->profile->skills->count() - 5 }}
                                                                    lainnya</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($isOwner)
                                            <div class="flex space-x-2">
                                                <button wire:click="removeMember({{ $member->id }})"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengeluarkan {{ $member->name }} dari ekosistem ini?')"
                                                    class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                    Keluarkan
                                                </button>
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-500 dark:text-slate-400">
                                                Anggota aktif
                                            </div>
                                        @endif
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
            @if ($activeTab === 'quality')
                @php
                    $skillsBreakdown = $ecosystem->getSkillsBreakdown();
                    $neededSkillsGap = $ecosystem->getNeededSkillsGap();
                @endphp

                <div class="space-y-6" wire:key="quality-tab-{{ $activeTab }}">
                    <!-- Quality Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                                {{ $ecosystemQuality['percentage'] }}%</div>
                            <div class="text-sm text-gray-600 dark:text-slate-400 mt-1">Kualitas Keseluruhan</div>
                        </div>

                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $ecosystemQuality['covered_skills'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-400 mt-1">Keahlian Tercakup</div>
                        </div>

                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                                {{ $ecosystemQuality['existing_skills_count'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-400 mt-1">Keahlian Ekosistem</div>
                        </div>

                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-orange-600 dark:text-orange-400">
                                {{ $ecosystemQuality['member_skills_count'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-400 mt-1">Keahlian Anggota</div>
                        </div>
                    </div>

                    <!-- Skills Breakdown -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Existing Skills -->
                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Keahlian Ekosistem
                                </h3>
                            </div>
                            <div class="p-6">
                                @if ($skillsBreakdown['existing_skills']->count() > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach ($skillsBreakdown['existing_skills'] as $skill)
                                            <div class="flex items-center space-x-2">
                                                <span
                                                    class="text-sm text-gray-700 dark:text-slate-300">{{ $skill->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-slate-400 text-center">Belum ada keahlian yang
                                        ditetapkan.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Member Skills -->
                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Keahlian Anggota
                                </h3>
                            </div>
                            <div class="p-6">
                                @if ($skillsBreakdown['member_skills']->count() > 0)
                                    <div class="space-y-2">
                                        @foreach ($skillsBreakdown['member_skills'] as $skillData)
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <span
                                                        class="text-sm text-gray-700 dark:text-slate-300">{{ $skillData['skill']->name }}</span>
                                                </div>
                                                <span
                                                    class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs px-2 py-1 rounded">{{ $skillData['user_count'] }}
                                                    orang</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-slate-400 text-center">Belum ada anggota dengan
                                        keahlian.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Connection Quality Analysis -->
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg" 
                         x-data="{ chart: null }"
                         x-init="
                            $nextTick(() => {
                                setTimeout(() => {
                                    if (document.getElementById('connectionQualityRadarChart')) {
                                        initializeConnectionQualityChart();
                                    }
                                }, 100);
                            });
                         ">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Analisis Kualitas Koneksi</h3>
                            <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">Visualisasi kualitas jejaring ekosistem</p>
                        </div>
                        <div class="p-6">
                            <div class="relative" style="height: 500px;">
                                <canvas id="connectionQualityRadarChart" wire:key="chart-{{ $activeTab }}" wire:ignore></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Needed Skills Gap -->
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Analisis Kebutuhan
                                Keahlian</h3>
                            <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">Tingkat kecukupan:
                                {{ $neededSkillsGap['coverage_percentage'] }}%</p>
                        </div>
                        <div class="p-6">
                            @if ($neededSkillsGap['gap_skills']->count() > 0)
                                <div class="mb-4">
                                    <h4 class="font-medium text-red-700 dark:text-red-400 mb-2">🚨 Keahlian yang Masih
                                        Dibutuhkan:</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                        @foreach ($neededSkillsGap['gap_skills'] as $skill)
                                            <div
                                                class="flex items-center space-x-2 bg-red-50 dark:bg-red-900/20 p-2 rounded border border-red-200 dark:border-red-800">
                                                <span
                                                    class="text-sm text-red-700 dark:text-red-300">{{ $skill->name }}</span>
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

                            @if ($neededSkillsGap['needed_skills']->count() > 0)
                                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                                    <h4 class="font-medium text-gray-700 dark:text-slate-300 mb-2">📋 Total Keahlian
                                        yang Dibutuhkan:</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                        @foreach ($neededSkillsGap['needed_skills'] as $skill)
                                            @php
                                                $isCovered = !$neededSkillsGap['gap_skills']->contains(
                                                    'id',
                                                    $skill->id,
                                                );
                                            @endphp
                                            <div
                                                class="flex items-center space-x-2 p-2 rounded {{ $isCovered ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 'bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600' }}">
                                                <span
                                                    class="text-sm {{ $isCovered ? 'text-green-700 dark:text-green-300' : 'text-gray-700 dark:text-slate-300' }}">{{ $skill->name }}</span>
                                                @if ($isCovered)
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
            @if ($activeTab === 'actions')
                <div class="space-y-6">
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Aksi Kolektif</h3>
                        </div>
                        <div class="p-6">
                            @if ($ecosystem->collectiveActions->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($ecosystem->collectiveActions as $action)
                                        <div
                                            class="border border-gray-200 dark:border-slate-700 rounded-lg p-4 bg-gray-50 dark:bg-slate-700/50">
                                            <h4 class="font-semibold text-gray-900 dark:text-slate-100">
                                                {{ $action->title }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-slate-300 mt-1">
                                                {{ $action->description }}</p>
                                            <div
                                                class="flex items-center space-x-4 mt-2 text-sm text-gray-500 dark:text-slate-400">
                                                <span>📅
                                                    {{ $action->start_date ? $action->start_date->format('d M Y') : 'Tanggal belum ditentukan' }}</span>
                                                <span>📍 {{ $action->location ?? 'Lokasi belum ditentukan' }}</span>
                                                <span
                                                    class="px-2 py-1 rounded text-xs {{ $action->status === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-gray-100 dark:bg-slate-600 text-gray-800 dark:text-slate-300' }}">
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
                                    @if ($isOwner || $isEcosystemBuilder)
                                        <a href="{{ route('collective-action.create') }}"
                                            class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            Buat Aksi Kolektif
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Invitations Tab -->
            @if ($activeTab === 'invitations' && $isOwner)
                <div class="space-y-6">
                    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">Undangan Aksi Kolektif
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-slate-300 mt-1">
                                Kelola undangan untuk berkolaborasi dalam aksi kolektif
                            </p>
                        </div>
                        <div class="p-6">
                            @if ($pendingInvitations->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($pendingInvitations as $invitation)
                                        <div
                                            class="border border-orange-200 dark:border-orange-800 rounded-lg p-4 bg-orange-50 dark:bg-orange-900/20">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-900 dark:text-slate-100">
                                                        {{ $invitation->collectiveAction->title }}
                                                    </h4>
                                                    <div class="flex items-center gap-3 mt-2">
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs 
                                                            @if ($invitation->collectiveAction->scale === 'kecil') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                                            @elseif($invitation->collectiveAction->scale === 'sedang') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                                            @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 @endif">
                                                            {{ $invitation->collectiveAction->scale_label }}
                                                        </span>
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                            {{ $invitation->collectiveAction->scope_label }}
                                                        </span>
                                                        <span class="text-xs text-gray-500 dark:text-slate-400">
                                                            📅
                                                            {{ $invitation->collectiveAction->start_date->format('d M Y') }}
                                                        </span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 dark:text-slate-300 mt-2">
                                                        {{ Str::limit($invitation->collectiveAction->description, 150) }}
                                                    </p>
                                                    @if ($invitation->invitation_message)
                                                        <div class="mt-3 p-3 bg-gray-100 dark:bg-slate-700 rounded-lg">
                                                            <p class="text-sm text-gray-700 dark:text-slate-300">
                                                                <strong>Pesan:</strong>
                                                                {{ $invitation->invitation_message }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                    <div
                                                        class="flex items-center mt-3 text-sm text-gray-500 dark:text-slate-400">
                                                        <div class="flex-shrink-0 mr-2">
                                                            <div
                                                                class="w-6 h-6 bg-gradient-to-r from-orange-600 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-medium">
                                                                {{ $invitation->invitedBy->initials() }}
                                                            </div>
                                                        </div>
                                                        <span>Diundang oleh {{ $invitation->invitedBy->name }}</span>
                                                        <span class="mx-2">•</span>
                                                        <span>{{ $invitation->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <a href="{{ route('collective-action.respond-invitation', $invitation) }}"
                                                        class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                        <svg class="w-4 h-4 mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                        </svg>
                                                        Respons
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-gray-500 dark:text-slate-400">
                                    <div class="text-4xl mb-2">📬</div>
                                    <p>Belum ada undangan aksi kolektif.</p>
                                    <p class="text-sm mt-1">Undangan akan muncul di sini ketika ecosystem builders lain
                                        mengundang Anda berkolaborasi.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let connectionQualityRadarChart = null;

        function initializeConnectionQualityChart() {
            console.log('Initializing connection quality chart...');
            const canvas = document.getElementById('connectionQualityRadarChart');
            
            if (!canvas) {
                console.log('Canvas not found');
                return;
            }

            // Check if chart already exists and destroy it
            if (connectionQualityRadarChart) {
                console.log('Destroying existing chart...');
                connectionQualityRadarChart.destroy();
                connectionQualityRadarChart = null;
            }

            const ctx = canvas.getContext('2d');
            const connectionData = @json($connectionQualityData);
            console.log('Connection data:', connectionData);

            // Validate data
            if (!connectionData || typeof connectionData !== 'object') {
                console.error('Invalid connection data:', connectionData);
                return;
            }

            // Check if all required data properties exist
            const requiredProps = ['jumlah_koneksi', 'kualitas_koneksi', 'keluasan_jejaring', 'keragaman_keahlian', 'tingkat_interaksi', 'kekuatan_jejaring'];
            const hasAllProps = requiredProps.every(prop => connectionData.hasOwnProperty(prop));
            
            if (!hasAllProps) {
                console.error('Missing required data properties:', requiredProps.filter(prop => !connectionData.hasOwnProperty(prop)));
                return;
            }

            // Get theme-aware colors
            function getThemeColors() {
                const isDark = localStorage.getItem('theme') === 'dark' || 
                              (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
                
                return {
                    isDark: isDark,
                    gridColor: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                    angleLinesColor: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                    textColor: isDark ? '#ffffff' : '#000000',
                    connection: {
                        bg: 'rgba(59, 130, 246, 0.1)',
                        border: 'rgba(59, 130, 246, 0.8)',
                        point: 'rgba(59, 130, 246, 1)'
                    }
                };
            }

            function customRound(value) {
                if (value > 10) {
                    return Math.ceil(value / 10) * 10;
                } else {
                    return Math.ceil(value);
                }
            }

            const themeColors = getThemeColors();

            try {
            connectionQualityRadarChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: [
                        'Jumlah Koneksi',
                        'Kualitas Koneksi',
                        'Keluasan Jejaring',
                        'Keragaman Keahlian',
                        'Tingkat Interaksi',
                        'Kekuatan Jejaring'
                    ],
                    datasets: [{
                        label: 'Kualitas Koneksi Ekosistem',
                        data: [
                            connectionData.jumlah_koneksi,
                            connectionData.kualitas_koneksi,
                            connectionData.keluasan_jejaring,
                            connectionData.keragaman_keahlian,
                            connectionData.tingkat_interaksi,
                            connectionData.kekuatan_jejaring
                        ],
                        backgroundColor: themeColors.connection.bg,
                        borderColor: themeColors.connection.border,
                        borderWidth: 2,
                        pointBackgroundColor: themeColors.connection.point,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            beginAtZero: true,
                            max: 5,
                            min: 0,
                            ticks: {
                                stepSize: 1,
                                backdropColor: 'transparent'
                            },
                            grid: {
                                color: themeColors.gridColor,
                                circular: true
                            },
                            angleLines: {
                                color: themeColors.angleLinesColor
                            }
                        }
                    },
                    elements: {
                        line: {
                            tension: 0.0
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                color: themeColors.textColor,
                            }
                        }
                    }
                }
            });
            } catch (error) {
                console.error('Error creating chart:', error);
                connectionQualityRadarChart = null;
            }
        }

        // Function to update chart colors when theme changes
        function updateConnectionChartColors() {
            if (connectionQualityRadarChart) {
                initializeConnectionQualityChart();
            }
        }

        // Listen for theme changes
        function setupThemeListener() {
            // Listen for storage changes (when theme is changed in another tab)
            window.addEventListener('storage', function(e) {
                if (e.key === 'theme') {
                    updateConnectionChartColors();
                }
            });

            // Listen for custom theme change events
            document.addEventListener('themeChanged', function() {
                updateConnectionChartColors();
            });

            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
                if (!localStorage.getItem('theme')) {
                    updateConnectionChartColors();
                }
            });
        }

        // Initialize chart when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, checking for quality tab...');
            // Check if quality tab is already active
            const qualityTab = document.querySelector('button[wire\\:click="setActiveTab(\'quality\')"]');
            if (qualityTab && qualityTab.classList.contains('border-blue-500')) {
                console.log('Quality tab is active, initializing chart...');
                setTimeout(initializeConnectionQualityChart, 200);
            }
            setupThemeListener();
        });

        // Re-initialize chart when Livewire updates
        document.addEventListener('livewire:navigated', function() {
                    setTimeout(function() {
                        if (document.getElementById('connectionQualityRadarChart')) {
                            initializeConnectionQualityChart();
                        }
                    }, 200);
            setupThemeListener();
        });

        // Simple approach - just check periodically if chart needs to be initialized
        function checkForChartInitialization() {
            const canvas = document.getElementById('connectionQualityRadarChart');
            const qualityTab = document.querySelector('button[wire\\:click="setActiveTab(\'quality\')"]');
            
            if (canvas && qualityTab && qualityTab.classList.contains('border-blue-500') && !connectionQualityRadarChart) {
                console.log('Initializing chart...');
                initializeConnectionQualityChart();
            }
        }

        // Check every 500ms
        setInterval(checkForChartInitialization, 500);

        // Listen for Livewire updates
        document.addEventListener('livewire:updated', function() {
            console.log('Livewire updated, checking for chart...');
            setTimeout(function() {
                const canvas = document.getElementById('connectionQualityRadarChart');
                const qualityTab = document.querySelector('button[wire\\:click="setActiveTab(\'quality\')"]');
                
                if (canvas && qualityTab && qualityTab.classList.contains('border-blue-500')) {
                    console.log('Quality tab is active, initializing chart...');
                    initializeConnectionQualityChart();
                }
            }, 200);
        });

        // Also listen for tab changes
        document.addEventListener('click', function(e) {
            if (e.target && e.target.getAttribute('wire:click') === "setActiveTab('quality')") {
                setTimeout(function() {
                    if (document.getElementById('connectionQualityRadarChart') && !connectionQualityRadarChart) {
                        console.log('Quality tab clicked, initializing chart...');
                        initializeConnectionQualityChart();
                    }
                }, 300);
            }
        });

        // Also try to initialize when the page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(initializeConnectionQualityChart, 200);
            setupThemeListener();
        });
    </script>
@endpush
