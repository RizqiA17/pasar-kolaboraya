<x-admin.layout title="Edit Pengguna - {{ $user->name }}">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Edit Pengguna</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">{{ $user->name }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.show', $user) }}" 
                   class="w-full sm:w-auto px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors text-center">
                    Batal
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div>
                        <flux:field>
                            <flux:label>Nama</flux:label>
                            <flux:input name="name" value="{{ old('name', $user->name) }}" required />
                            @error('name')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Email -->
                    <div>
                        <flux:field>
                            <flux:label>Email</flux:label>
                            <flux:input name="email" type="email" value="{{ old('email', $user->email) }}" required />
                            @error('email')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Peran -->
                    <div>
                        <flux:field>
                            <flux:label>Peran</flux:label>
                            <flux:select name="role" required>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Pengguna</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            </flux:select>
                            @error('role')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Email Verified Status -->
                    <div>
                        <flux:field>
                            <flux:label>Status Verifikasi Email</flux:label>
                            <div class="mt-2">
                                @if($user->email_verified_at)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                        Terverifikasi pada {{ $user->email_verified_at->format('M d, Y H:i') }}
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                                        Belum Terverifikasi
                                    </span>
                                @endif
                            </div>
                        </flux:field>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="border-t border-slate-200 dark:border-slate-700 pt-6">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Informasi Tambahan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <flux:field>
                                <flux:label>Dibuat Pada</flux:label>
                                <flux:input value="{{ $user->created_at->format('M d, Y H:i:s') }}" readonly />
                            </flux:field>
                        </div>
                        <div>
                            <flux:field>
                                <flux:label>Terakhir Diperbarui</flux:label>
                                <flux:input value="{{ $user->updated_at->format('M d, Y H:i:s') }}" readonly />
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ route('admin.users.show', $user) }}" 
                       class="w-full sm:w-auto px-4 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors text-center">
                        Batal
                    </a>
                    <flux:button type="submit" variant="primary" class="w-full sm:w-auto">
                        Update Pengguna
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Zona Bahaya -->
        @if(!$user->isSuperAdmin() || Pengguna::where('role', 'super_admin')->count() > 1)
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-4">Zona Bahaya</h3>
                <p class="text-red-700 dark:text-red-300 mb-4">
                    Setelah Anda menghapus pengguna, tidak ada cara untuk mengembalikannya. Harap pastikan.
                </p>
                <form method="POST" action="{{ route('admin.users.delete', $user) }}" 
                      onsubmit="return confirm('Are you absolutely sure you want to delete this user? This action cannot be undone and will permanently remove all user data.')">
                    @csrf
                    @method('DELETE')
                    <flux:button type="submit" variant="danger">
                        Delete Pengguna
                    </flux:button>
                </form>
            </div>
        @endif
    </div>
</x-admin.layout>
