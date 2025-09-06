<form wire:submit.prevent="save" class="space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Nama Survey
        </label>
        <input 
            type="text" 
            id="name"
            wire:model="name"
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
            placeholder="Masukkan nama survey..."
        >
        @error('name') 
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Deskripsi Survey
        </label>
        <textarea 
            id="description"
            wire:model="description"
            rows="4"
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
            placeholder="Masukkan deskripsi survey..."
        ></textarea>
        @error('description') 
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">Informasi Survey</h4>
        <p class="text-xs text-blue-700 dark:text-blue-300">
            Survey akan memiliki 3 kategori pertanyaan:
        </p>
        <ul class="text-xs text-blue-700 dark:text-blue-300 mt-2 space-y-1">
            <li>• <strong>Koneksi:</strong> Jumlah koneksi, kualitas koneksi, keluasan jejaring</li>
            <li>• <strong>Kolaborasi:</strong> Kualitas kolaborasi, keragaman kolaborator, proyek kolaborasi, sumber daya</li>
            <li>• <strong>Aksi:</strong> Jumlah aksi besar, sedang, dan kecil</li>
        </ul>
    </div>

    <div class="flex justify-end space-x-3 pt-4">
        <button 
            type="button"
            wire:click="$dispatch('closeModal')"
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
        >
            Batal
        </button>
        <button 
            type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-50"
        >
            <span wire:loading.remove>Buat Survey</span>
            <span wire:loading>Membuat...</span>
        </button>
    </div>
</form>