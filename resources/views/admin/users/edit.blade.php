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
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
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
                            <flux:input name="email" type="email" value="{{ old('email', $user->email) }}"
                                required />
                            @error('email')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Peran -->
                    <div>
                        <flux:field>
                            <flux:label>Role</flux:label>
                            <flux:select name="role" required>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                                    Pengguna</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    Admin</option>
                                <option value="super_admin"
                                    {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Admin
                                </option>
                            </flux:select>
                            @error('role')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Peran Peserta -->
                    <div>
                        <flux:field>
                            <flux:label>Peran Peserta</flux:label>
                            <flux:select name="assigned_role">
                                @if ($user->user_type === 'tamu')
                                    <option value="Tamu">Tamu</option>
                                @elseif ($user->user_type === 'komunitas')
                                    <option value="Komunitas">Komunitas</option>
                                @else
                                    <option value="">Pilih Peran Peserta</option>
                                @endif
                                <option value="Ekosistem Builder"
                                    {{ old('assigned_role', $user->is_ecosystem_builder ? 'Ekosistem Builder' : $user->assigned_role) == 'Ekosistem Builder' ? 'selected' : '' }}>
                                    Ekosistem Builder
                                </option>
                                @foreach (\App\Models\Peran::get() as $peran)
                                    <option value="{{ $peran->nama }}"
                                        {{ old('assigned_role', $user->assigned_role) == $peran->nama ? 'selected' : '' }}>
                                        {{ $peran->nama }}
                                    </option>
                                @endforeach
                            </flux:select>
                            @error('assigned_role')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Jenis Pengguna -->
                    <div>
                        <flux:field>
                            <flux:label>Jenis Pengguna</flux:label>
                            <flux:select name="user_type" id="userTypeSelect" required>
                                <option value="partisipan"
                                    {{ old('user_type', $user->user_type) === 'partisipan' ? 'selected' : '' }}>
                                    Partisipan</option>
                                <option value="tamu"
                                    {{ old('user_type', $user->user_type) === 'tamu' ? 'selected' : '' }}>
                                    Tamu</option>
                                <option value="komunitas"
                                    {{ old('user_type', $user->user_type) === 'komunitas' ? 'selected' : '' }}>
                                    Komunitas</option>
                            </flux:select>
                            @error('user_type')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Status Ekosistem Builder -->
                    {{-- <div>
                        <flux:field>
                            <flux:label>Status Ekosistem Builder</flux:label>
                            <div class="mt-2">
                                @if ($user->is_ecosystem_builder)
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400">
                                            Ekosistem Builder Aktif
                                        </span>
                                        @if ($user->ecosystem_builder_approved_at)
                                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                                Disetujui:
                                                {{ $user->ecosystem_builder_approved_at->format('M d, Y H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400">
                                        Bukan Ekosistem Builder
                                    </span>
                                @endif
                            </div>
                        </flux:field>
                    </div> --}}

                    <!-- Email Verified Status -->
                    <div>
                        <flux:field>
                            <flux:label>Status Verifikasi Email</flux:label>
                            <div class="mt-2">
                                @if ($user->email_verified_at)
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                        Terverifikasi pada {{ $user->email_verified_at->format('M d, Y H:i') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
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
                <div
                    class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ route('admin.users.show', $user) }}"
                        class="w-full sm:w-auto px-4 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Perbarui Pengguna
                    </button>
                </div>
            </form>
        </div>

        <!-- Zona Bahaya -->
        @if (!$user->isSuperAdmin() || \App\Models\User::where('role', 'super_admin')->count() > 1)
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-4">Zona Bahaya</h3>
                <p class="text-red-700 dark:text-red-300 mb-4">
                    Setelah Anda menghapus pengguna, tidak ada cara untuk mengembalikannya. Harap pastikan.
                </p>
                <form method="POST" action="{{ route('admin.users.delete', $user) }}"
                    onsubmit="return confirm('Are you absolutely sure you want to delete this user? This action cannot be undone and will permanently remove all user data.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Hapus Pengguna
                    </button>
                </form>
            </div>
        @endif
    </div>
    <script>
        let oldRole = '{{ old('assigned_role') }}';

        document.addEventListener("DOMContentLoaded", function() {
            const selectEl = document.getElementById("userTypeSelect");
            gantiPeran(selectEl.value); // inisialisasi saat load

            selectEl.addEventListener("change", function(e) {
                gantiPeran(e.target.value);
            });
        });

        function gantiPeran(value) {
            const roleSelect = document.querySelector('select[name="assigned_role"]');

            // simpan role lama kalau bukan tamu/komunitas
            if (roleSelect.value !== "Tamu" && roleSelect.value !== "Komunitas") {
                oldRole = roleSelect.value || oldRole;
            }

            // helper: tambahkan option kalau belum ada
            function ensureOption(text, val) {
                let existing = Array.from(roleSelect.options).find(opt => opt.value === val);
                if (!existing) {
                    let newOpt = new Option(text, val, false, false);
                    roleSelect.add(newOpt);
                    return newOpt;
                }
                return existing;
            }

            if (value === "tamu") {
                ensureOption("Tamu", "Tamu");
                roleSelect.value = "Tamu";

            } else if (value === "komunitas") {
                ensureOption("Komunitas", "Komunitas");
                roleSelect.value = "Komunitas";

            } else {
                ensureOption("Ekosistem Builder", "Ekosistem Builder");

                if (!oldRole || oldRole === "Tamu" || oldRole === "Komunitas") {
                    // Tambahkan placeholder kalau belum ada
                    let placeholder = Array.from(roleSelect.options).find(opt => opt.value === "");
                    if (!placeholder) {
                        roleSelect.add(new Option("-- Pilih Peran --", ""), roleSelect.options[0]);
                    }
                    roleSelect.value = ""; // reset ke kosong
                } else {
                    roleSelect.value = oldRole;
                }
            }

        }
    </script>
</x-admin.layout>
