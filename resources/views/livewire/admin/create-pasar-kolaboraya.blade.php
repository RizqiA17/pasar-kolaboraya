<div class="p-6">
    <div class="mb-6">
        <p class="text-slate-600 dark:text-slate-400">
            Buat ruang kolaborasi baru dan undang user untuk bergabung
        </p>
    </div>

        <form wire:submit="create" class="space-y-6">
            <!-- Nama Pasar Kolaboraya -->
            <div>
                <flux:field>
                    <flux:label for="name">Nama Pasar Kolaboraya</flux:label>
                    <flux:input 
                        wire:model="name" 
                        id="name"
                        placeholder="Contoh: Kolaborasi Startup Jakarta 2025"
                        required
                    />
                    <flux:error name="name" />
                </flux:field>
            </div>

            <!-- Deskripsi -->
            <div>
                <flux:field>
                    <flux:label for="description">Deskripsi (Opsional)</flux:label>
                    <flux:textarea 
                        wire:model="description" 
                        id="description"
                        placeholder="Jelaskan tujuan dan fokus dari Pasar Kolaboraya ini..."
                        rows="3"
                    />
                    <flux:error name="description" />
                </flux:field>
            </div>

            <!-- Pilih User -->
            <div>
                <flux:field>
                    <flux:label>Pilih User untuk Diundang</flux:label>
                    
                    <!-- Search -->
                    <div class="mb-4">
                        <flux:input 
                            wire:model.live="search" 
                            placeholder="Cari user berdasarkan nama atau email..."
                            class="w-full"
                        />
                    </div>

                    <!-- User List -->
                    <div class="border border-slate-200 dark:border-slate-700 rounded-xl max-h-64 overflow-y-auto bg-slate-50/50 dark:bg-slate-800/50">
                        @forelse($availableUsers as $user)
                            <div class="flex items-center justify-between p-3 hover:bg-slate-100 dark:hover:bg-slate-700/50 border-b border-slate-100 dark:border-slate-600 last:border-b-0 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <flux:checkbox 
                                        wire:click="toggleUser({{ $user->id }})"
                                        :checked="in_array($user->id, $selectedUsers)"
                                    />
<div>
                                        <div class="font-medium text-slate-800 dark:text-slate-200">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm text-slate-500 dark:text-slate-400">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">
                                    {{ $user->role }}
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-slate-500 dark:text-slate-400">
                                @if($search)
                                    Tidak ada user yang ditemukan untuk "{{ $search }}"
                                @else
                                    Tidak ada user yang tersedia
                                @endif
                            </div>
                        @endforelse
                    </div>

                    @if(count($selectedUsers) > 0)
                        <div class="mt-2 text-sm text-blue-600 dark:text-blue-400 font-medium">
                            {{ count($selectedUsers) }} user dipilih
                        </div>
                    @endif
                </flux:field>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                <flux:button 
                    type="button" 
                    wire:click="$dispatch('close-modal')"
                >
                    Batal
                </flux:button>
                <flux:button 
                    type="submit" 
                    variant="primary"
                    :disabled="empty($name)"
                >
                    <flux:icon.plus class="w-4 h-4 mr-2" />
                    Buat Pasar Kolaboraya
                </flux:button>
            </div>
        </form>
</div>
