<div
    class="space-y-6"
    x-data="userRoleHandler({
        userType: '{{ old('user_type', $user->user_type) }}',
        assignedRole: '{{ old('assigned_role', $user->assigned_role) }}'
    })"
>
    <!-- Page Header -->
    <x-admin.header title="Edit Pengguna" :description="$user->name">
        <div class="flex items-center space-x-3">
            <flux:button href="{{ route('admin.users.show', $user) }}">
                Batal
            </flux:button>
        </div>
    </x-admin.header>

    <!-- Edit Form -->
    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <flux:field>
                    <flux:label>Nama</flux:label>
                    <flux:input name="name" value="{{ old('name', $user->name) }}" required />
                    @error('name') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <!-- Email -->
                <flux:field>
                    <flux:label>Email</flux:label>
                    <flux:input name="email" type="email" value="{{ old('email', $user->email) }}" required />
                    @error('email') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <!-- Role -->
                <flux:field>
                    <flux:label>Role</flux:label>
                    <flux:select name="role">
                        <option value="user">Pengguna</option>
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </flux:select>
                </flux:field>

                <!-- Peran Peserta -->
                <flux:field>
                    <flux:label>Peran Peserta</flux:label>
                    <flux:select name="assigned_role" x-model="assignedRole">
                        <template x-if="userType === 'partisipan'">
                            <option value="">Pilih Peran Peserta</option>
                        </template>

                        <template x-if="userType === 'tamu'">
                            <option value="Tamu">Tamu</option>
                        </template>

                        <template x-if="userType === 'komunitas'">
                            <option value="Komunitas">Komunitas</option>
                        </template>

                        <option value="Ecosystem Builder">Ecosystem Builder</option>

                        @foreach (\App\Models\Peran::get() as $peran)
                            <option value="{{ $peran->nama }}">{{ $peran->nama }}</option>
                        @endforeach
                    </flux:select>
                </flux:field>

                <!-- Jenis Pengguna -->
                <flux:field>
                    <flux:label>Jenis Pengguna</flux:label>
                    <flux:select name="user_type" x-model="userType">
                        <option value="partisipan">Partisipan</option>
                        <option value="tamu">Tamu</option>
                        <option value="komunitas">Komunitas</option>
                    </flux:select>
                </flux:field>

                <!-- Status Verifikasi -->
                <flux:field>
                    <flux:label>Status Verifikasi Email</flux:label>
                    <div class="mt-2">
                        @if ($user->email_verified_at)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                Belum Terverifikasi
                            </span>
                        @endif
                    </div>
                </flux:field>
            </div>

            <!-- Informasi Tambahan -->
            <div class="border-t border-slate-200 dark:border-slate-700 pt-6">
                <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">
                    Informasi Tambahan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Dibuat Pada</flux:label>
                        <flux:input value="{{ $user->created_at->format('M d, Y H:i:s') }}" readonly />
                    </flux:field>

                    <flux:field>
                        <flux:label>Terakhir Diperbarui</flux:label>
                        <flux:input value="{{ $user->updated_at->format('M d, Y H:i:s') }}" readonly />
                    </flux:field>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-slate-200 dark:border-slate-700">
                <a href="{{ route('admin.users.show', $user) }}" class="px-4 py-2 text-gray-600 dark:text-slate-300">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-blue dark:bg-secondary-green text-white rounded-lg">
                    Perbarui Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function userRoleHandler(initial)
    {
        return {
            userType: initial.userType,
            assignedRole: initial.assignedRole,
            previousRole: initial.assignedRole,

            init()
            {
                this.$watch('userType', value => {
                    if (value === 'tamu') {
                        this.assignedRole = 'Tamu'
                    } else if (value === 'komunitas') {
                        this.assignedRole = 'Komunitas'
                    } else {
                        if (['Tamu', 'Komunitas'].includes(this.assignedRole)) {
                            this.assignedRole = this.previousRole || ''
                        }
                    }
                })

                this.$watch('assignedRole', value => {
                    if (!['Tamu', 'Komunitas'].includes(value)) {
                        this.previousRole = value
                    }
                })
            }
        }
    }
</script>
