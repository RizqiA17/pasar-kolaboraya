<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateEvent extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $location;
    public $latitude = -7.4292;
    public $longitude = 109.2290;
    public $banner;

    protected $listeners = [
        'set-coordinates' => 'setCoordinates',
        'set-location' => 'setLocation'
    ];

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required',
        'start_date' => 'required|date|after:today',
        'end_date' => 'required|date|after:start_date',
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'banner' => 'nullable|image|max:2048',
        'location' => 'nullable|string|max:500'
    ];

    public function updatedBanner()
    {
        $this->validate([
            'banner' => 'image|max:2048'
        ]);
        
        $this->dispatch('refresh-map');
    }

    public function save()
    {
        $this->validate();

        $banner_path = null;
        if ($this->banner) {
            $banner_path = $this->banner->store('event-banners', 'public');
        }

        // Set default location if not provided
        if (empty($this->location)) {
            $this->location = "Lokasi belum ditentukan";
        }

        $event = Event::create([
            'title' => $this->title,
            'description' => $this->description,
            'created_by' => auth()->id(),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'location' => $this->location,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'banner' => $banner_path,
            'status' => 'draft'
        ]);

        // Add current user as participant
        $event->participants()->attach(auth()->id());

        return redirect()->route('events.show', $event)
            ->with('message', 'Event berhasil dibuat!');
    }

    public function setCoordinates($data)
    {
        $this->latitude = $data['latitude'];
        $this->longitude = $data['longitude'];
    }

    public function setLocation($data)
    {
        $this->location = $data['location'];
    }

    public function render()
    {
        return view('livewire.events.create-event');
    }
}
