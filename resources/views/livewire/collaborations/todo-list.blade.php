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
        @forelse ($todos as $todo)
            <div class="bg-white rounded-xl shadow-sm hover:shadow transition-all duration-200 border {{ $todo->completed ? 'border-green-100 bg-green-50/30' : 'border-gray-100' }}">
                <div class="p-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 pt-1">
                            <div class="relative">
                                <input type="checkbox" wire:click="toggleCompleted({{ $todo->id }})" 
                                    @checked($todo->completed)
                                    class="w-5 h-5 rounded-md border-2 border-gray-300 text-sky-500 focus:ring-sky-500 focus:ring-offset-0 transition-colors cursor-pointer">
                                @if($todo->completed)
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <svg class="w-3 h-3 text-sky-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-x-4">
                                <div>
                                    <h3 class="text-base font-medium {{ $todo->completed ? 'line-through text-gray-400' : 'text-gray-900' }}">
                                        {{ $todo->title }}
                                    </h3>
                                    @if ($todo->description)
                                        <p class="mt-1 text-sm text-gray-600">{{ $todo->description }}</p>
                                    @endif
                                </div>
                                <div class="flex-shrink-0 flex items-center gap-2">
                                    <span class="text-xs text-gray-500">{{ $todo->created_at->diffForHumans() }}</span>
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 flex items-center justify-center" title="Dibuat oleh {{ $todo->creator->name }}">
                                        <span class="text-xs font-medium text-gray-600">{{ substr($todo->creator->name, 0, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            @if ($todo->comments->count() > 0)
                                <div class="mt-3 pl-4 border-l-2 border-gray-100 space-y-2">
                                    @foreach ($todo->comments as $comment)
                                        <div class="flex items-start gap-2 group">
                                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center">
                                                <span class="text-xs font-medium text-gray-600">{{ substr($comment->user->name, 0, 2) }}</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-baseline gap-2">
                                                    <span class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</span>
                                                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-sm text-gray-600">{{ $comment->comment }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="w-16 h-16 mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <p class="text-gray-500 text-lg">Belum ada todo</p>
                <p class="text-gray-400 text-sm mt-1">Mulai tambahkan todo untuk kolaborasi ini</p>
                Belum ada task yang dibuat.
            </div>
        @endforelse
    </div>
</div>
{{-- Nothing in the world is as soft and yielding as water. --}}
</div>
