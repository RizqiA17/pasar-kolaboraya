<section>
    {{-- Form tambah task --}}
    <div class="mb-4">
        <input type="text" wire:model="newTitle" placeholder="Judul task" class="border p-2 rounded">
        <input type="text" wire:model="newDescription" placeholder="Deskripsi (opsional)" class="border p-2 rounded">
        <button wire:click="addTodo" class="bg-blue-500 text-white p-2 rounded">Tambah</button>
    </div>

    {{-- Daftar task --}}
    <ul class="space-y-2">
        @foreach ($todos as $todo)
            <li class="p-2 border rounded flex justify-between items-center">
                <div>
                    <input type="checkbox" wire:click="toggleCompleted({{ $todo->id }})" @if($todo->completed) checked @endif>
                    <span @if($todo->completed) class="line-through text-gray-500" @endif>{{ $todo->title }}</span>
                    <small class="text-gray-400">{{ $todo->description }}</small>
                </div>
                <button wire:click="selectTodo({{ $todo->id }})" class="text-blue-500">Komentar</button>
            </li>
        @endforeach
    </ul>

    {{-- Komentar --}}
    @if($selectedTodo)
        <div class="mt-4 border-t pt-2">
            <h4 class="font-bold">{{ $selectedTodo->title }} - Komentar</h4>
            <ul class="space-y-1">
                @foreach ($selectedTodo->comments as $c)
                    <li><strong>{{ $c->user->name }}:</strong> {{ $c->comment }}</li>
                @endforeach
            </ul>
            <input type="text" wire:model="comment" placeholder="Tambah komentar..." class="border p-2 rounded mt-2">
            <button wire:click="addComment" class="bg-green-500 text-white p-1 rounded mt-1">Kirim</button>
        </div>
    @endif
</section>
