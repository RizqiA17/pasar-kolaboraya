<div>
    <h2 class="text-xl font-bold mb-3">Collaboration Manager</h2>

    @if ($friend_id)
        <div class="mb-3 p-2 bg-blue-100 rounded">
            <p class="text-sm text-blue-800">Creating collaboration with: <strong>{{ $this->friendName }}</strong></p>
        </div>
    @endif

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="mb-3 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-3 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form Create / Update --}}

    <div class="mb-3">
        <label class="block text-sm font-medium mb-1">Title</label>
        <input type="text" wire:model="title" placeholder="Judul"
            class="border p-2 w-full @error('title') border-red-500 @enderror">
        @error('title')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label class="block text-sm font-medium mb-1">Description</label>
        <textarea wire:model="description" placeholder="Deskripsi"
            class="border p-2 w-full @error('description') border-red-500 @enderror" rows="3"></textarea>
        @error('description')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <button wire:click="create" class="bg-green-500 text-white p-2 rounded hover:bg-green-600 transition-colors">
        Create Collaboration
    </button>

</div>
