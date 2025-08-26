<section>
    {{-- {{ $friends }} --}}
    <flux:modal name="create-collaboration" variant="flyout">
        <livewire:collaborations.new-collaboration :friend-id="null" />
    </flux:modal>
    <h2 class="text-xl font-bold my-3">Koneksi Anda</h2>
    <ul class="space-y-2">
        @forelse ($friends as $friend)
            <li class="p-2 border rounded flex items-center justify-between">
                {{ $friend['name'] }}

                <flux:modal.trigger name="create-collaboration-{{ $friend['id'] }}">
                    <flux:button icon="plus" class="ml-2 text-green-500 flex bg-neutral-600 ms-auto p-2 rounded ">
                        Kolaborasi
                    </flux:button>
                </flux:modal.trigger>
                
                <flux:modal name="create-collaboration-{{ $friend['id'] }}" variant="flyout">
                    <livewire:collaborations.new-collaboration :friend-id="$friend['id']" />
                </flux:modal>
            </li>
        @empty
            <li class="text-gray-500">Belum ada koneksi.</li>
        @endforelse
    </ul>
</section>
