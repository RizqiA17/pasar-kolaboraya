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
    public $diversityScore = 0;
    public $connectionCountScore = 0;
    public $contentRichnessScore = 0;
    public $isLoading = false;
    public $lastUpdated = '';
    public $topInterests = [];
    public $topSkills = [];

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
            
            // Get all accepted connections
            $connections = Connection::where('status', 'accepted')
                ->where(function ($query) use ($user) {
                    $query->where('requester_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
                })
                ->forUserActiveSession($user) // Filter by user's active session
                ->with(['requester.profile.interests', 'requester.profile.skills', 
                       'receiver.profile.interests', 'receiver.profile.skills'])
                ->get();

        $allInterests = collect();
        $allSkills = collect();

        foreach ($connections as $connection) {
            // Determine which user is the connection (not the current user)
            $connectedUser = $connection->requester_id == $user->id ? $connection->receiver : $connection->requester;
            
            if ($connectedUser && $connectedUser->profile) {
                // Collect interests
                if ($connectedUser->profile->interests) {
                    $allInterests = $allInterests->merge($connectedUser->profile->interests);
                }
                
                // Collect skills
                if ($connectedUser->profile->skills) {
                    $allSkills = $allSkills->merge($connectedUser->profile->skills);
                }
            }
        }

        // Calculate diversity metrics
        $this->totalInterests = $allInterests->count();
        $this->totalSkills = $allSkills->count();
        $this->uniqueInterests = $allInterests->unique('id')->count();
        $this->uniqueSkills = $allSkills->unique('id')->count();

        // Get top interests and skills (most common)
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

        // Calculate connection quality score (0-100)
        // More realistic formula: Balance between diversity, connection count, and minimum thresholds
        $this->totalConnections = $connections->count();
        if ($this->totalConnections > 0) {
            // Calculate diversity ratio (unique vs total)
            $interestDiversityRatio = $this->uniqueInterests > 0 ? $this->uniqueInterests / $this->totalInterests : 0;
            $skillDiversityRatio = $this->uniqueSkills > 0 ? $this->uniqueSkills / $this->totalSkills : 0;
            
            // Calculate average diversity ratio
            $avgDiversityRatio = ($interestDiversityRatio + $skillDiversityRatio) / 2;
            
            // Calculate diversity score (40% weight) - but with minimum threshold
            $this->diversityScore = round($avgDiversityRatio * 40, 1);
            
            // Calculate connection count score (30% weight) - with realistic scaling
            $connectionCountScore = 0;
            if ($this->totalConnections >= 10) {
                $connectionCountScore = 30; // Max points for 10+ connections
            } elseif ($this->totalConnections >= 5) {
                $connectionCountScore = 20; // Good for 5-9 connections
            } elseif ($this->totalConnections >= 3) {
                $connectionCountScore = 15; // Fair for 3-4 connections
            } elseif ($this->totalConnections >= 2) {
                $connectionCountScore = 10; // Poor for 2 connections
            } else {
                $connectionCountScore = 5; // Very poor for 1 connection
            }
            $this->connectionCountScore = $connectionCountScore;
            
            // Calculate content richness score (30% weight) - based on total unique content
            $totalUniqueContent = $this->uniqueInterests + $this->uniqueSkills;
            $this->contentRichnessScore = 0;
            if ($totalUniqueContent >= 20) {
                $this->contentRichnessScore = 30; // Excellent for 20+ unique items
            } elseif ($totalUniqueContent >= 15) {
                $this->contentRichnessScore = 25; // Good for 15-19 items
            } elseif ($totalUniqueContent >= 10) {
                $this->contentRichnessScore = 20; // Fair for 10-14 items
            } elseif ($totalUniqueContent >= 5) {
                $this->contentRichnessScore = 15; // Poor for 5-9 items
            } else {
                $this->contentRichnessScore = 10; // Very poor for less than 5 items
            }
            
            // Calculate final quality score
            $this->connectionQuality = min(100, round($this->diversityScore + $this->connectionCountScore + $this->contentRichnessScore));
        }

        // Determine quality level
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
