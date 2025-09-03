<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\SystemSetting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app', ['title' => 'Buat Aksi'])]
class CreateEvent extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $location;
    public $latitude;
    public $longitude;
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
        'latitude' => 'required',
        'longitude' => 'required',
        'banner' => 'nullable|image|max:2048',
        'location' => 'nullable|string|max:500'
    ];

    protected $messages = [
        'title.required' => 'Judul event wajib diisi',
        'title.min' => 'Judul event minimal 3 karakter',
        'description.required' => 'Deskripsi event wajib diisi',
        'start_date.required' => 'Tanggal mulai wajib diisi',
        'start_date.date' => 'Format tanggal mulai tidak valid',
        'start_date.after' => 'Tanggal mulai harus setelah hari ini',
        'end_date.required' => 'Tanggal selesai wajib diisi',
        'end_date.date' => 'Format tanggal selesai tidak valid',
        'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai',
        'latitude.required' => 'Latitude wajib diisi',
        'longitude.required' => 'Longitude wajib diisi',
        'banner.image' => 'File harus berupa gambar',
        'banner.max' => 'Ukuran gambar maksimal 2MB',
        'location.string' => 'Lokasi harus berupa teks',
        'location.max' => 'Lokasi maksimal 500 karakter',
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
        // Check if user actions feature is enabled
        if (!SystemSetting::isUserActionsEnabled() && !auth()->user()->isSuperAdmin()) {
            session()->flash('error', 'Fitur aksi pengguna sedang dinonaktifkan oleh administrator.');
            return;
        }

        $this->validate();
        // dd([
        //     $this->location,
        //     $this->latitude,
        //     $this->longitude
        // ]);

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
