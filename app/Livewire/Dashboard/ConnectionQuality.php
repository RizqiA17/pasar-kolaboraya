<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use App\Models\Connection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ConnectionQuality extends Component
{
    public $connectionQuality = 0;
    public $totalInterests = 0;
    public $totalSkills = 0;
    public $uniqueInterests = 0;
    public $uniqueSkills = 0;
    public $qualityLevel = '';
    public $totalConnections = 0;
    public $connectionCountScore = 0;
    public $contentRichnessScore = 0;
    public $isLoading = false;
    public $lastUpdated = '';
    public $topInterests = [];
    public $topSkills = [];

    // New Pilar I - Koneksi scoring properties
    public $friendshipDensityScore = 0;
    public $avgFriendsScore = 0;
    public $acceptanceRateScore = 0;
    public $recencyScore = 0;
    public $diversityScore = 0;
    public $acceptedConnections = 0;
    public $connectedUsersCount = 0;
    public $possiblePairs = 0;
    public $avgDegree = 0;
    public $acceptedCount = 0;
    public $rejectedCount = 0;
    public $recentConnections = 0;
    public $roleCategories = [];

    public function mount()
    {
        $this->calculateConnectionQuality();
    }

    public function refresh()
    {
        $this->isLoading = true;
        $this->calculateConnectionQuality();
        $this->isLoading = false;
    }

    public function calculateConnectionQuality()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return;
            }
            
            // Ensure user has an active session
            if (!$user->active_pasar_kolaboraya_id) {
                Log::warning('User ' . $user->id . ' has no active pasar kolaboraya session');
                return;
            }
            
            // Use the new Pilar I - Koneksi scoring system
            $koneksiData = Connection::calculateKoneksiScore($user->id);
            
            // Set the main connection quality score
            $this->connectionQuality = $koneksiData['koneksi_score'];
            
            // Get detailed metrics for display
            $qualityMetrics = Connection::getConnectionQualityMetrics($user->id);
            
            // Set individual scores for display
            $this->friendshipDensityScore = $koneksiData['friendship_density_score'];
            $this->avgFriendsScore = $koneksiData['avg_friends_score'];
            $this->acceptanceRateScore = $koneksiData['acceptance_rate_score'];
            $this->recencyScore = $koneksiData['recency_score'];
            $this->diversityScore = $koneksiData['diversity_score'];
            
            // Set detailed metrics
            $this->acceptedConnections = $koneksiData['details']['accepted_connections'];
            $this->connectedUsersCount = $koneksiData['details']['connected_users_count'];
            $this->possiblePairs = $koneksiData['details']['possible_pairs'];
            $this->avgDegree = $koneksiData['details']['avg_degree'];
            $this->acceptedCount = $koneksiData['details']['accepted_count'];
            $this->rejectedCount = $koneksiData['details']['rejected_count'];
            $this->recentConnections = $koneksiData['details']['recent_connections'];
            $this->roleCategories = $koneksiData['details']['role_categories'];
            
            // Set quality metrics for radar chart
            $this->diversityScore = $qualityMetrics['keragaman_keahlian'];
            $this->connectionCountScore = $qualityMetrics['jumlah_koneksi'];
            $this->contentRichnessScore = $qualityMetrics['kekuatan_jejaring'];
            
            // Get additional data for interests and skills display - only for current user
            $connections = Connection::where('status', 'accepted')
                ->where(function ($query) use ($user) {
                    $query->where('requester_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
                })
                ->where('pasar_kolaboraya_id', $user->active_pasar_kolaboraya_id)
                ->forUserActiveSession($user)
                ->with(['requester.profile.interests', 'requester.profile.skills', 
                       'receiver.profile.interests', 'receiver.profile.skills'])
                ->get();

        $allInterests = collect();
        $allSkills = collect();

        foreach ($connections as $connection) {
            // Double-check that this connection belongs to the current user
            if ($connection->requester_id !== $user->id && $connection->receiver_id !== $user->id) {
                continue; // Skip if connection doesn't belong to current user
            }
            
            $connectedUser = $connection->requester_id == $user->id ? $connection->receiver : $connection->requester;
            
            if ($connectedUser && $connectedUser->profile) {
                if ($connectedUser->profile->interests) {
                    $allInterests = $allInterests->merge($connectedUser->profile->interests);
                }
                
                if ($connectedUser->profile->skills) {
                    $allSkills = $allSkills->merge($connectedUser->profile->skills);
                }
            }
        }

            // Calculate diversity metrics for display
        $this->totalInterests = $allInterests->count();
        $this->totalSkills = $allSkills->count();
        $this->uniqueInterests = $allInterests->unique('id')->count();
        $this->uniqueSkills = $allSkills->unique('id')->count();

            // Get top interests and skills
        $this->topInterests = $allInterests->groupBy('id')
            ->map(function ($group) {
                return [
                    'name' => $group->first()->name,
                    'count' => $group->count()
                ];
            })
            ->sortByDesc('count')
            ->take(3)
            ->values()
            ->toArray();

        $this->topSkills = $allSkills->groupBy('id')
            ->map(function ($group) {
                return [
                    'name' => $group->first()->name,
                    'count' => $group->count()
                ];
            })
            ->sortByDesc('count')
            ->take(3)
            ->values()
            ->toArray();

            // Determine quality level based on new scoring
        $this->qualityLevel = $this->getQualityLevel($this->connectionQuality);
        
        // Update last updated timestamp
        $this->lastUpdated = now()->format('H:i');
        } catch (\Exception $e) {
            // Log error and set default values
            Log::error('Error calculating connection quality: ' . $e->getMessage());
            $this->connectionQuality = 0;
            $this->qualityLevel = 'Error';
            $this->lastUpdated = now()->format('H:i');
        }
    }

    private function getQualityLevel($score)
    {
        if ($score >= 80) return 'Excellent';
        if ($score >= 60) return 'Good';
        if ($score >= 40) return 'Fair';
        if ($score >= 20) return 'Poor';
        return 'Very Poor';
    }

    public function render()
    {
        return view('livewire.dashboard.connection-quality');
    }
}
