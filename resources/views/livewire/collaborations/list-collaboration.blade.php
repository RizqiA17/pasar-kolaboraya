<section>
    {{-- <livewire:components.search-bar :model="\App\Models\Collaboration::class" :fields="['title']" :placeholder="'Cari kolaborasi...'" /> --}}
    {{-- {{ dd($collaborations) }} --}}
    @forelse ($collaborations as $collaboration)
        <div class="border-b py-2">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-semibold">{{ $collaboration->collaboration->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $collaboration->collaboration->description }}</p>
                    <p class="mt-2 text-sm"><span class="font-medium">Partner:</span> {{ $collaboration->user->name }}</p>
                </div>
                <a href="{{ route('collaboration.todos', $collaboration->collaboration_id) }}"
                    class="px-3 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600 transition">
                    Lihat Todo
                </a>
            </div>
        </div>
    @empty
        <p class="text-gray-500">Belum ada kolaborasi.</p>
    @endforelse

</section>
