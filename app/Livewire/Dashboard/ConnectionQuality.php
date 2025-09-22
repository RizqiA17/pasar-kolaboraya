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
    public $qualityLevel = '';
    public $isLoading = false;
    public $lastUpdated = '';

    // Role diversity focused properties
    public $diversityScore = 0;
    public $acceptedConnections = 0;
    public $connectedUsersCount = 0;
    public $roleCategories = [];
    public $uniqueRolesCount = 0;
    public $totalRolesInDatabase = 0;
    public $roleCoveragePercentage = 0;

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
            
            // Use the role diversity focused scoring system
            $koneksiData = Connection::calculateKoneksiScore($user->id);
            
            // Set the main connection quality score (now only diversity)
            $this->connectionQuality = $koneksiData['koneksi_score'];
            
            // Get detailed metrics for display
            $qualityMetrics = Connection::getConnectionQualityMetrics($user->id);
            
            // Set diversity-focused metrics
            $this->diversityScore = $koneksiData['diversity_score'];
            $this->acceptedConnections = $koneksiData['details']['accepted_connections'];
            $this->connectedUsersCount = $koneksiData['details']['connected_users_count'];
            $this->roleCategories = $koneksiData['details']['role_categories'];
            $this->uniqueRolesCount = $koneksiData['details']['unique_roles_count'];
            $this->totalRolesInDatabase = $koneksiData['details']['total_roles_in_database'];
            $this->roleCoveragePercentage = $koneksiData['details']['role_coverage_percentage'];

            // Determine quality level based on diversity score
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
