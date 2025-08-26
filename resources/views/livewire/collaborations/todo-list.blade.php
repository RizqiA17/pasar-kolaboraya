<div class="max-w-4xl mx-auto py-6 px-4">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-2">{{ $collaboration->title }}</h2>
        <p class="text-gray-600">{{ $collaboration->description }}</p>
    </div>

    {{-- Form tambah task --}}
    <div class="mb-6 space-y-3">
        <div class="flex gap-2">
            <input type="text" wire:model="newTitle" placeholder="Judul task"
                class="flex-1 border border-gray-300 p-2 rounded-md">
            <button wire:click="addTodo"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                Tambah Task
            </button>
        </div>
        <input type="text" wire:model="newDescription" placeholder="Deskripsi (opsional)"
            class="w-full border border-gray-300 p-2 rounded-md">
    </div>

    {{-- Daftar task --}}
    <div class="space-y-4">
        {{-- {{ dd($todos) }} --}}
        @forelse ($todos as $todo)
            <div class="border border-gray-200 rounded-lg p-4 {{ $todo->completed ? 'bg-gray-50' : 'bg-white' }}">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" wire:click="toggleCompleted({{ $todo->id }})" 
                            @checked($todo->completed)
                            class="mt-1">
                        <div>
                            <h3 class="font-medium {{ $todo->completed ? 'line-through text-gray-500' : '' }}">
                                {{ $todo->title }}
                            </h3>
                            @if ($todo->description)
                                <p class="text-sm text-gray-600 mt-1">{{ $todo->description }}</p>
                            @endif
                            <div class="mt-2 text-sm text-gray-500">
                                Dibuat oleh: {{ $todo->creator->name }}
                            </div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $todo->created_at->diffForHumans() }}
                    </div>
                </div>

                @if ($todo->comments->count() > 0)
                    <div class="mt-4 pl-8 border-l-2 space-y-2">
                        @foreach ($todo->comments as $comment)
                            <div class="text-sm">
                                <span class="font-medium">{{ $comment->user->name }}:</span>
                                <span class="text-gray-600">{{ $comment->comment }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                Belum ada task yang dibuat.
            </div>
        @endforelse
    </div>
</div>
{{-- Nothing in the world is as soft and yielding as water. --}}
</div>
