<?php

namespace App\Livewire\PasarKolaboraya;

use App\Models\PasarKolaboraya;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Pilih Sesi Pasar Kolaboraya'])]
class SessionSelector extends Component
{
    public $pasarKolaborayas;
    public $selectedPasarKolaboraya = null;

    public function mount()
    {
        $this->loadPasarKolaborayas();
        
        // Auto-select if user has only one active pasar kolaboraya and no active session
        if ($this->pasarKolaborayas && $this->pasarKolaborayas->count() === 1) {
            $pasarKolaboraya = $this->pasarKolaborayas->first();
            /** @var User $user */
            $user = Auth::user();
            if ($pasarKolaboraya->status === 'active' && !$user->hasActivePasarKolaboraya()) {
                // Auto-select and redirect to dashboard
                $this->selectSession($pasarKolaboraya->id);
            }
        }
    }

    public function loadPasarKolaborayas()
    {
        /** @var User $user */
        $user = Auth::user();
        $this->pasarKolaborayas = $user->acceptedPasarKolaborayas()
            ->get(); // Show all accepted pasar kolaborayas, not just active ones
    }

    public function selectSession($pasarKolaborayaId)
    {
        $pasarKolaboraya = PasarKolaboraya::find($pasarKolaborayaId);
        
        if (!$pasarKolaboraya || !$pasarKolaboraya->isUserMember(Auth::user())) {
            session()->flash('error', 'Pasar Kolaboraya tidak ditemukan atau Anda bukan anggota');
            return;
        }

        // Check if pasar kolaboraya is active
        if ($pasarKolaboraya->status !== 'active') {
            session()->flash('error', 'Pasar Kolaboraya tidak aktif. Hubungi admin untuk mengaktifkan sesi.');
            return;
        }

        // Set as active session
        /** @var User $user */
        $user = Auth::user();
        $user->setActivePasarKolaboraya($pasarKolaboraya);
        
        session()->flash('message', 'Sesi Pasar Kolaboraya berhasil dipilih!');
        return redirect()->route('dashboard');
    }

    public function requestToJoin($pasarKolaborayaId)
    {
        $pasarKolaboraya = PasarKolaboraya::find($pasarKolaborayaId);
        
        if (!$pasarKolaboraya) {
            session()->flash('error', 'Pasar Kolaboraya tidak ditemukan');
            return;
        }

        if ($pasarKolaboraya->isUserMember(Auth::user())) {
            session()->flash('info', 'Anda sudah menjadi anggota Pasar Kolaboraya ini');
            return;
        }

        // Request to join
        $pasarKolaboraya->requestJoin(Auth::user(), 'Saya ingin bergabung dengan Pasar Kolaboraya ini');
        
        session()->flash('message', 'Permintaan bergabung berhasil dikirim! Menunggu persetujuan admin.');
        $this->loadPasarKolaborayas();
    }

    public function render()
    {
        // Get available Pasar Kolaboraya that user can join
        $availablePasarKolaborayas = PasarKolaboraya::active()
            ->whereDoesntHave('users', function($query) {
                $query->where('users.id', Auth::id());
            })
            ->with('creator')
            ->get();

        return view('livewire.pasar-kolaboraya.session-selector', [
            'pasarKolaborayas' => $this->pasarKolaborayas,
            'availablePasarKolaborayas' => $availablePasarKolaborayas
        ]);
    }
}
