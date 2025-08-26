<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    {{-- Event Banner --}}
    @if($event->banner)
        <div class="mb-6">
            <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->title }}" 
                class="w-full h-64 object-cover rounded-lg shadow-md">
        </div>
    @endif

    {{-- Event Header --}}
    <div class="mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $event->title }}</h1>
                <p class="text-gray-600">{{ $event->description }}</p>
            </div>
            <div>
                @if(!$isParticipant)
                    <button wire:click="joinEvent" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Ikuti Event
                    </button>
                @else
                    <button wire:click="leaveEvent" 
                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                        Batalkan Keikutsertaan
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Event Details --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-semibold mb-2">Waktu</h3>
            <div class="text-gray-600">
                <div><i class="fas fa-calendar-alt mr-2"></i>Mulai: {{ $event->start_date->format('d M Y H:i') }}</div>
                <div><i class="fas fa-calendar-check mr-2"></i>Selesai: {{ $event->end_date->format('d M Y H:i') }}</div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-semibold mb-2">Peserta ({{ $event->participants->count() }})</h3>
            <div class="space-y-2">
                @foreach($event->participants as $participant)
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                            {{ substr($participant->name, 0, 1) }}
                        </div>
                        <span>{{ $participant->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-semibold mb-2">Kolaborasi ({{ $event->collaborations->count() }})</h3>
            <div class="space-y-2">
                @foreach($event->collaborations as $collaboration)
                    <a href="{{ route('collaboration.todos', $collaboration) }}" 
                       class="block hover:bg-gray-50 p-2 rounded">
                        {{ $collaboration->title }}
                    </a>
                @endforeach
            </div>
        </div> --}}
    </div>
</div>
