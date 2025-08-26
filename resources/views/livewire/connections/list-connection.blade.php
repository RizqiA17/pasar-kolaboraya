<section>

    <h2 class="text-xl font-bold my-3">Koneksi Anda</h2>
    <ul class="space-y-2">
        @forelse ($friends as $friend)
            <li class="p-2 border rounded">
                {{ $friend['name'] }}
            </li>
        @empty
            <li class="text-gray-500">Belum ada koneksi.</li>
        @endforelse
    </ul>
</section>
