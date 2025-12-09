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

    public function placeholder(){
        return <<<'HTML'
        <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-slate-900 shadow-xl dark:border-t dark:border-slate-700 p-8 animate-pulse">

            <!-- Accent SVG Placeholder -->
            <div class="absolute top-0 left-0 w-32 h-32 opacity-10 bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
            <div class="absolute bottom-0 right-0 w-24 h-24 opacity-10 bg-gray-200 dark:bg-gray-700 rounded-xl"></div>

            <div class="relative z-10">

                <!-- Header -->
                <div class="flex items-center text-center justify-between mb-8">
                    <div class="space-y-2">
                        <div class="h-6 w-48 bg-gray-200 dark:bg-gray-700 rounded"></div>
                        <div class="h-4 w-64 bg-gray-200 dark:bg-gray-700 rounded"></div>
                    </div>
                </div>

                <!-- Main Quality Score -->
                <div class="mb-8">
                    <div class="flex items-center flex-col gap-4 mb-4">
                        <div class="h-16 w-32 bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                        <div class="h-7 w-28 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="p-4 text-center space-y-2">
                        <div class="h-6 w-16 bg-gray-200 dark:bg-gray-700 rounded mx-auto"></div>
                        <div class="h-4 w-24 bg-gray-200 dark:bg-gray-700 rounded mx-auto"></div>
                    </div>

                    <div class="p-4 text-center space-y-2">
                        <div class="h-6 w-24 bg-gray-200 dark:bg-gray-700 rounded mx-auto"></div>
                        <div class="h-4 w-28 bg-gray-200 dark:bg-gray-700 rounded mx-auto"></div>
                    </div>
                </div>

                <!-- Role Diversity Breakdown -->
                <div class="mb-6 border-t border-gray-200 dark:border-gray-700 pt-12">

                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-700 rounded-lg"></div>
                        <div class="h-5 w-40 bg-gray-200 dark:bg-gray-700 rounded"></div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="h-4 w-40 bg-gray-200 dark:bg-gray-700 rounded"></div>
                            <div class="h-4 w-10 bg-gray-300 dark:bg-gray-600 rounded"></div>
                        </div>

                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gray-300 dark:bg-gray-600 h-2 rounded-full w-1/3"></div>
                        </div>

                        <div class="h-3 w-64 bg-gray-200 dark:bg-gray-700 rounded"></div>

                        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 space-y-3">
                            <div class="h-4 w-48 bg-gray-300 dark:bg-gray-600 rounded"></div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="h-3 w-20 bg-gray-200 dark:bg-gray-700 rounded"></div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 bg-gray-300 dark:bg-gray-600 h-1.5 rounded-full"></div>
                                        <div class="h-3 w-6 bg-gray-300 dark:bg-gray-600 rounded"></div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="h-3 w-20 bg-gray-200 dark:bg-gray-700 rounded"></div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 bg-gray-300 dark:bg-gray-600 h-1.5 rounded-full"></div>
                                        <div class="h-3 w-6 bg-gray-300 dark:bg-gray-600 rounded"></div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="h-3 w-20 bg-gray-200 dark:bg-gray-700 rounded"></div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 bg-gray-300 dark:bg-gray-600 h-1.5 rounded-full"></div>
                                        <div class="h-3 w-6 bg-gray-300 dark:bg-gray-600 rounded"></div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="h-3 w-20 bg-gray-200 dark:bg-gray-700 rounded"></div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 bg-gray-300 dark:bg-gray-600 h-1.5 rounded-full"></div>
                                        <div class="h-3 w-6 bg-gray-300 dark:bg-gray-600 rounded"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="bg-orange-50 dark:bg-orange-800/20 rounded-2xl p-6 space-y-3">
                    <div class="h-4 w-56 bg-orange-200 dark:bg-orange-700 rounded"></div>

                    <ul class="space-y-2">
                        <li class="h-3 w-full bg-orange-100 dark:bg-orange-700/40 rounded"></li>
                        <li class="h-3 w-full bg-orange-100 dark:bg-orange-700/40 rounded"></li>
                        <li class="h-3 w-full bg-orange-100 dark:bg-orange-700/40 rounded"></li>
                        <li class="h-3 w-full bg-orange-100 dark:bg-orange-700/40 rounded"></li>
                    </ul>
                </div>
            </div>
        </div>
        HTML;
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
            // dd($koneksiData['details']['total_roles_in_database']);

            // Get detailed metrics for display
            $qualityMetrics = Connection::getConnectionQualityMetrics($user->id);

            // Set diversity-focused metrics
            $this->diversityScore = $koneksiData['diversity_score'];
            $this->totalRolesInDatabase = $koneksiData['details']['total_roles_in_database'];
            $this->acceptedConnections = $koneksiData['details']['accepted_connections'];
            $this->connectedUsersCount = $koneksiData['details']['connected_users_count'];
            $this->roleCategories = $koneksiData['details']['role_categories'];
            $this->uniqueRolesCount = $koneksiData['details']['unique_roles_count'];
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
        if ($score >= 80)
            return 'Excellent';
        if ($score >= 60)
            return 'Good';
        if ($score >= 40)
            return 'Fair';
        if ($score >= 20)
            return 'Poor';
        return 'Very Poor';
    }

    public function render()
    {
        return view('livewire.dashboard.connection-quality');
    }
}
