<div class="max-w-2xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Buat Event Baru</h1>
    </div>

    <form wire:submit="createEvent" class="space-y-6">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Judul Event</label>
            <input type="text" id="title" wire:model="title" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="description" wire:model="description" rows="4" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="datetime-local" id="start_date" wire:model="start_date" 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="datetime-local" id="end_date" wire:model="end_date" 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label for="banner" class="block text-sm font-medium text-gray-700">Banner Event</label>
            <input type="file" id="banner" wire:model="banner" accept="image/*" 
                class="mt-1 block w-full">
            @error('banner') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            @if ($banner)
                <div class="mt-2">
                    <img src="{{ $banner->temporaryUrl() }}" alt="Preview" class="w-full h-48 object-cover rounded-lg">
                </div>
            @endif
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('events') }}" 
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" 
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Buat Event
            </button>
        </div>
    </form>
</div>v>
    {{-- Do your work, then step back. --}}
</div>
