<?php

namespace App\Livewire\Ecosystem;

use App\Models\Ecosystem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Pengaturan Ekosistem'])]
class Settings extends Component
{
    public Ecosystem $ecosystem;
    public $auto_join_collective_actions;

    protected $rules = [
        'auto_join_collective_actions' => 'boolean',
    ];

    public function mount(Ecosystem $ecosystem)
    {
        // Check if user can manage this ecosystem
        if ($ecosystem->creator_id !== Auth::id()) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola ekosistem ini.');
            return redirect()->route('ecosystem.browse');
        }

        $this->ecosystem = $ecosystem;
        $this->auto_join_collective_actions = $ecosystem->auto_join_collective_actions;
    }

    public function updateSettings()
    {
        $this->validate();

            // $this->ecosystem->update([
            //     'auto_join_collective_actions' => $this->auto_join_collective_actions,
            // ]);

        session()->flash('message', 'Pengaturan ekosistem berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.ecosystem.settings');
    }
}
