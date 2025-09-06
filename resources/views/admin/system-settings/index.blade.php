<x-admin.layout title="System Settings">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Pengaturan Sistem</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">Kelola pengaturan global sistem untuk mengontrol akses dan fitur.</p>
            </div>
            <div class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                Terakhir diperbarui: {{ now()->format('d M Y H:i') }}
            </div>
        </div>

        <!-- System Settings Form -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <form method="POST" action="{{ route('admin.system-settings.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Login Status -->
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl space-y-3 sm:space-y-0">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Status Login</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                Kontrol apakah pengguna dapat masuk ke sistem. Ketika dinonaktifkan, hanya super admin yang dapat masuk.
                            </p>
                        </div>
                        <div class="sm:ml-4 flex-shrink-0">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="login_enabled" value="1" 
                                       {{ (isset($settings['login_enabled']) && $settings['login_enabled']->value === '1') ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Maintenance Mode -->
                    {{-- <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Mode Maintenance</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                Aktifkan mode maintenance untuk menampilkan halaman maintenance kepada pengguna.
                            </p>
                        </div>
                        <div class="ml-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="maintenance_mode" value="1" 
                                       {{ (isset($settings['maintenance_mode']) && $settings['maintenance_mode']->value === '1') ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 dark:peer-focus:ring-yellow-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-yellow-600"></div>
                            </label>
                        </div>
                    </div> --}}

                    <!-- Registration Status -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl space-y-3 sm:space-y-0">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Registrasi Pengguna Baru</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                Kontrol apakah pengguna baru dapat mendaftar ke sistem.
                            </p>
                        </div>
                        <div class="sm:ml-4 flex-shrink-0">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="registration_enabled" value="1" 
                                       {{ (isset($settings['registration_enabled']) && $settings['registration_enabled']->value === '1') ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Connections Status -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl space-y-3 sm:space-y-0">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Koneksi Antar Pengguna</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                Kontrol apakah pengguna dapat membuat dan mengelola koneksi dengan pengguna lain.
                            </p>
                        </div>
                        <div class="sm:ml-4 flex-shrink-0">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="connections_enabled" value="1" 
                                       {{ (isset($settings['connections_enabled']) && $settings['connections_enabled']->value === '1') ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Collaborations Status -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl space-y-3 sm:space-y-0">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Kolaborasi</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                Kontrol apakah pengguna dapat membuat dan mengelola kolaborasi.
                            </p>
                        </div>
                        <div class="sm:ml-4 flex-shrink-0">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="collaborations_enabled" value="1" 
                                       {{ (isset($settings['collaborations_enabled']) && $settings['collaborations_enabled']->value === '1') ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-purple-600"></div>
                            </label>
                        </div>
                    </div>

                    <!-- User Actions Status -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl space-y-3 sm:space-y-0">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Aksi Pengguna</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                Kontrol apakah pengguna dapat melakukan aksi seperti bergabung dengan event, dll.
                            </p>
                        </div>
                        <div class="sm:ml-4 flex-shrink-0">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="user_actions_enabled" value="1" 
                                       {{ (isset($settings['user_actions_enabled']) && $settings['user_actions_enabled']->value === '1') ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Warning Message -->
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                    <div class="flex flex-col sm:flex-row">
                        <div class="flex-shrink-0 mb-3 sm:mb-0">
                            <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="sm:ml-3">
                            <h3 class="text-sm font-medium text-amber-800 dark:text-amber-200">
                                Peringatan Penting
                            </h3>
                            <div class="mt-2 text-sm text-amber-700 dark:text-amber-300">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Menonaktifkan login akan memblokir semua pengguna kecuali super admin</li>
                                    <li>Mode maintenance akan menampilkan halaman maintenance kepada semua pengguna</li>
                                    <li>Menonaktifkan registrasi akan mencegah pengguna baru mendaftar</li>
                                    <li>Menonaktifkan koneksi akan mencegah pengguna membuat koneksi dengan pengguna lain</li>
                                    <li>Menonaktifkan kolaborasi akan mencegah pengguna membuat dan mengelola kolaborasi</li>
                                    <li>Menonaktifkan aksi pengguna akan mencegah pengguna melakukan aksi seperti bergabung event</li>
                                    <li>Perubahan akan berlaku segera setelah disimpan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        <!-- Current Status -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Status Saat Ini</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                <div class="text-center p-3 sm:p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 mx-auto mb-2 rounded-full flex items-center justify-center {{ (isset($settings['login_enabled']) && $settings['login_enabled']->value === '1') ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        @if(isset($settings['login_enabled']) && $settings['login_enabled']->value === '1')
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Login</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ (isset($settings['login_enabled']) && $settings['login_enabled']->value === '1') ? 'Diaktifkan' : 'Dinonaktifkan' }}
                    </p>
                </div>

                <div class="text-center p-3 sm:p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 mx-auto mb-2 rounded-full flex items-center justify-center {{ (isset($settings['maintenance_mode']) && $settings['maintenance_mode']->value === '1') ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600' }}">
                        @if(isset($settings['maintenance_mode']) && $settings['maintenance_mode']->value === '1')
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Maintenance</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ (isset($settings['maintenance_mode']) && $settings['maintenance_mode']->value === '1') ? 'Aktif' : 'Tidak Aktif' }}
                    </p>
                </div>

                <div class="text-center p-3 sm:p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 mx-auto mb-2 rounded-full flex items-center justify-center {{ (isset($settings['registration_enabled']) && $settings['registration_enabled']->value === '1') ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        @if(isset($settings['registration_enabled']) && $settings['registration_enabled']->value === '1')
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Registrasi</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ (isset($settings['registration_enabled']) && $settings['registration_enabled']->value === '1') ? 'Diaktifkan' : 'Dinonaktifkan' }}
                    </p>
                </div>

                <div class="text-center p-3 sm:p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 mx-auto mb-2 rounded-full flex items-center justify-center {{ (isset($settings['connections_enabled']) && $settings['connections_enabled']->value === '1') ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        @if(isset($settings['connections_enabled']) && $settings['connections_enabled']->value === '1')
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Koneksi</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ (isset($settings['connections_enabled']) && $settings['connections_enabled']->value === '1') ? 'Diaktifkan' : 'Dinonaktifkan' }}
                    </p>
                </div>

                <div class="text-center p-3 sm:p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 mx-auto mb-2 rounded-full flex items-center justify-center {{ (isset($settings['collaborations_enabled']) && $settings['collaborations_enabled']->value === '1') ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        @if(isset($settings['collaborations_enabled']) && $settings['collaborations_enabled']->value === '1')
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Kolaborasi</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ (isset($settings['collaborations_enabled']) && $settings['collaborations_enabled']->value === '1') ? 'Diaktifkan' : 'Dinonaktifkan' }}
                    </p>
                </div>

                <div class="text-center p-3 sm:p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 mx-auto mb-2 rounded-full flex items-center justify-center {{ (isset($settings['user_actions_enabled']) && $settings['user_actions_enabled']->value === '1') ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        @if(isset($settings['user_actions_enabled']) && $settings['user_actions_enabled']->value === '1')
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Aksi Pengguna</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ (isset($settings['user_actions_enabled']) && $settings['user_actions_enabled']->value === '1') ? 'Diaktifkan' : 'Dinonaktifkan' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
