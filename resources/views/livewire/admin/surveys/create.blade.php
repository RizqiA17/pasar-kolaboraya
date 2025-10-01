<form wire:submit.prevent="save" class="space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-primary-blue/70 dark:text-primary-blue/70 mb-2">
            Nama Pasar Kecil
        </label>
        <input 
            type="text" 
            id="name"
            wire:model="name"
            class="w-full px-3 py-2 border border-primary-blue/30 dark:border-primary-blue/40 rounded-lg focus:ring-2 focus:ring-primary-blue dark:bg-slate-700 dark:text-white"
            placeholder="Masukkan nama Pasar Kecil..."
        >
        @error('name') 
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-primary-blue/70 dark:text-primary-blue/70 mb-2">
            Deskripsi Pasar Kecil
        </label>
        <textarea 
            id="description"
            wire:model="description"
            rows="4"
            class="w-full px-3 py-2 border border-primary-blue/30 dark:border-primary-blue/40 rounded-lg focus:ring-2 focus:ring-primary-blue dark:bg-slate-700 dark:text-white"
            placeholder="Masukkan deskripsi Pasar Kecil..."
        ></textarea>
        @error('description') 
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
{{-- 
    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">Informasi Pasar Kecil</h4>
        <p class="text-xs text-sky-700 dark:text-blue-300">
            Pasar Kecil akan memiliki 3 kategori pertanyaan:
        </p>
        <ul class="text-xs text-sky-700 dark:text-blue-300 mt-2 space-y-1">
            <li>• <strong>Koneksi:</strong> Jumlah koneksi, kualitas koneksi, keluasan jejaring</li>
            <li>• <strong>Kolaborasi:</strong> Kualitas kolaborasi, keragaman kolaborator, proyek kolaborasi, sumber daya</li>
            <li>• <strong>Aksi:</strong> Jumlah aksi besar, sedang, dan kecil</li>
        </ul>
    </div> --}}

    <div class="flex justify-end space-x-3 pt-4">
        <button 
            type="button"
            wire:click="$dispatch('closeModal')"
            class="px-4 py-2 border border-primary-blue/30 dark:border-primary-blue/40 text-primary-blue/70 dark:text-primary-blue/70 rounded-lg hover:bg-primary-blue/5 dark:hover:bg-primary-blue/20 transition-colors"
        >
            Batal
        </button>
        <button 
            type="submit"
            class="px-4 py-2 bg-primary-blue text-white rounded-lg hover:bg-sky-700 transition-colors"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-50"
        >
            <span wire:loading.remove>Buat Pasar Kecil</span>
            <span wire:loading>Membuat...</span>
        </button>
    </div>
</form>