<?php

namespace App\Livewire\Connections;

use App\Models\Connection;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KoneksiScore extends Component
{
    public $koneksiData = [];
    public $isLoading = false;
    public $lastUpdated = '';

    public function mount()
    {
        $this->calculateKoneksiScore();
    }

    public function refresh()
    {
        $this->isLoading = true;
        $this->calculateKoneksiScore();
        $this->isLoading = false;
    }

    public function calculateKoneksiScore()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return;
            }

            // Use the new Pilar I - Koneksi scoring system
            $this->koneksiData = Connection::calculateKoneksiScore($user->id);
            
            // Update last updated timestamp
            $this->lastUpdated = now()->format('H:i');
        } catch (\Exception $e) {
            // Log error and set default values
            Log::error('Error calculating koneksi score: ' . $e->getMessage());
            $this->koneksiData = [
                'friendship_density_score' => 0,
                'avg_friends_score' => 0,
                'acceptance_rate_score' => 0,
                'recency_score' => 0,
                'diversity_score' => 0,
                'koneksi_score' => 0,
                'details' => []
            ];
            $this->lastUpdated = now()->format('H:i');
        }
    }

    public function render()
    {
        return view('livewire.connections.koneksi-score');
    }
}
