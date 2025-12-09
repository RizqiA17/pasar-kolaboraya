<?php

namespace App\Livewire\Dashboard;

use App\Models\CollectiveAction;
use App\Models\Ecosystem;
use App\Models\EcosystemContribution;
use App\Models\CollectiveActionContribution;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ActivityTimeline extends Component
{

    public function placeholder()
    {
        return <<<'HTML'
        <div class="relative overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800 shadow-lg animate-pulse">
            <div class="absolute top-0 left-0 w-20 h-20 opacity-10 bg-gray-200 dark:bg-gray-700 rounded"></div>

            <div class="relative z-10 p-6">
                <div class="flex items-center justify-between mb-4 gap-2">
                    <div>
                        <div class="h-5 w-40 bg-gray-300 dark:bg-gray-600 rounded mb-2"></div>
                        <div class="h-4 w-56 bg-gray-300 dark:bg-gray-600 rounded"></div>
                    </div>
                    <div class="w-12 h-12 min-w-12 bg-gray-300 dark:bg-gray-600 rounded-lg"></div>
                </div>

                <div class="space-y-4">

                    <!-- ITEM 1 -->
                    <div class="relative">
                        <div class="absolute max-sm:hidden left-6 top-8 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>

                        <div class="flex items-start relative">
                            <div class="relative max-sm:hidden mt-1">
                                <div class="h-12 w-12 bg-gray-300 dark:bg-gray-700 rounded-2xl"></div>
                            </div>

                            <div class="sm:ml-6 flex-grow w-full min-w-0">
                                <div class="bg-gray-200 dark:bg-zinc-700 rounded-2xl p-5 min-h-[140px] shadow-sm">
                                    <div class="flex items-start justify-between max-sm:flex-col h-full">

                                        <div class="flex-1 flex flex-col justify-between w-full min-w-0">
                                            <div>
                                                <div class="h-5 w-48 bg-gray-300 dark:bg-gray-600 rounded mb-3"></div>

                                                <div class="h-4 w-full bg-gray-300 dark:bg-gray-600 rounded mb-4"></div>

                                                <div class="flex items-center max-sm:flex-col gap-2 mb-4">
                                                    <div class="h-5 w-32 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                                                    <div class="h-5 w-24 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                                                </div>

                                                <div class="h-4 w-3/4 bg-gray-300 dark:bg-gray-600 rounded"></div>
                                                <div class="h-3 w-1/2 bg-gray-300 dark:bg-gray-600 rounded mt-2"></div>
                                            </div>
                                        </div>

                                        <div class="sm:ml-4 flex-shrink-0 max-sm:w-full max-sm:mt-4">
                                            <div class="h-10 w-40 bg-gray-300 dark:bg-gray-600 rounded-lg"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ITEM 2 -->
                    <div class="relative">
                        <div class="absolute max-sm:hidden left-6 top-8 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>

                        <div class="flex items-start relative">
                            <div class="relative max-sm:hidden mt-1">
                                <div class="h-12 w-12 bg-gray-300 dark:bg-gray-700 rounded-2xl"></div>
                            </div>

                            <div class="sm:ml-6 flex-grow w-full min-w-0">
                                <div class="bg-gray-200 dark:bg-zinc-700 rounded-2xl p-5 min-h-[140px] shadow-sm">
                                    <div class="flex items-start justify-between max-sm:flex-col h-full">

                                        <div class="flex-1 flex flex-col justify-between w-full min-w-0">
                                            <div>
                                                <div class="h-5 w-44 bg-gray-300 dark:bg-gray-600 rounded mb-3"></div>

                                                <div class="h-4 w-full bg-gray-300 dark:bg-gray-600 rounded mb-4"></div>

                                                <div class="flex items-center max-sm:flex-col gap-2 mb-4">
                                                    <div class="h-5 w-28 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                                                    <div class="h-5 w-24 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                                                </div>

                                                <div class="h-4 w-3/4 bg-gray-300 dark:bg-gray-600 rounded"></div>
                                                <div class="h-3 w-1/2 bg-gray-300 dark:bg-gray-600 rounded mt-2"></div>
                                            </div>
                                        </div>

                                        <div class="sm:ml-4 flex-shrink-0 max-sm:w-full max-sm:mt-4">
                                            <div class="h-10 w-40 bg-gray-300 dark:bg-gray-600 rounded-lg"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ITEM 3 -->
                    <div class="relative">
                        <div class="absolute max-sm:hidden left-6 top-8 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>

                        <div class="flex items-start relative">
                            <div class="relative max-sm:hidden mt-1">
                                <div class="h-12 w-12 bg-gray-300 dark:bg-gray-700 rounded-2xl"></div>
                            </div>

                            <div class="sm:ml-6 flex-grow w-full min-w-0">
                                <div class="bg-gray-200 dark:bg-zinc-700 rounded-2xl p-5 min-h-[140px] shadow-sm">
                                    <div class="flex items-start justify-between max-sm:flex-col h-full">

                                        <div class="flex-1 flex flex-col justify-between w-full min-w-0">
                                            <div>
                                                <div class="h-5 w-52 bg-gray-300 dark:bg-gray-600 rounded mb-3"></div>

                                                <div class="h-4 w-full bg-gray-300 dark:bg-gray-600 rounded mb-4"></div>

                                                <div class="flex items-center max-sm:flex-col gap-2 mb-4">
                                                    <div class="h-5 w-32 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                                                    <div class="h-5 w-24 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                                                </div>

                                                <div class="h-4 w-3/4 bg-gray-300 dark:bg-gray-600 rounded"></div>
                                                <div class="h-3 w-1/2 bg-gray-300 dark:bg-gray-600 rounded mt-2"></div>
                                            </div>
                                        </div>

                                        <div class="sm:ml-4 flex-shrink-0 max-sm:w-full max-sm:mt-4">
                                            <div class="h-10 w-40 bg-gray-300 dark:bg-gray-600 rounded-lg"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        HTML;
    }



    public function getActivitiesProperty()
    {
        $user = Auth::user();

        if (!$user || !$user->active_pasar_kolaboraya_id) {
            return collect();
        }

        $cacheKey = "activity_timeline:{$user->id}:{$user->active_pasar_kolaboraya_id}";

        return Cache::tags('activity_timeline')->rememberForever($cacheKey, function () use ($user) {
            $activities = collect();

            // AKSI KOLEKTIF
            $collectiveActions = CollectiveAction::forUserActiveSession($user)
                ->whereHas('acceptedInvitations', function ($query) use ($user) {
                    $query->whereHas('ecosystem', function ($ecosystemQuery) use ($user) {
                        $ecosystemQuery->whereHas('acceptedUsers', function ($userQuery) use ($user) {
                            $userQuery->where('user_id', $user->id);
                        });
                    });
                })->get()->map(function ($item) {
                    $item->type = 'collective_action';
                    return $item;
                });

            // EKOSISTEM
            $userEcosystems = Ecosystem::forUserActiveSession($user)
                ->whereHas('acceptedUsers', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get()
                ->map(function ($item) {
                    $item->type = 'ecosystem';
                    $item->title = $item->ecosystem_title;
                    return $item;
                });

            // KONTRIBUSI EKOSISTEM
            $ecosystemContributions = EcosystemContribution::where('user_id', $user->id)
                ->whereHas('ecosystem', function ($query) use ($user) {
                    $query->forUserActiveSession($user);
                })
                ->with(['ecosystem', 'contribution'])
                ->get()
                ->map(function ($item) {
                    $item->type = 'ecosystem_contribution';
                    $contributionName = $item->contribution->name ?? 'Ekosistem';
                    $item->title = $item->ecosystem->ecosystem_title;
                    $item->description = $contributionName ? 'Kontribusi ' . $contributionName : $item->ecosystem->description;
                    return $item;
                });

            // KONTRIBUSI AKSI KOLEKTIF
            $collectiveActionContributions = CollectiveActionContribution::where('user_id', $user->id)
                ->whereHas('collectiveAction', function ($query) use ($user) {
                    $query->forUserActiveSession($user);
                })
                ->with(['collectiveAction', 'contribution'])
                ->get()
                ->map(function ($item) {
                    $item->type = 'collective_action_contribution';
                    $contributionName = $item->contribution->name ?? 'Aksi Kolektif';
                    $item->title = $item->collectiveAction->title;
                    $item->description = $contributionName ? 'Kontribusi ' . $contributionName : $item->collectiveAction->description;
                    return $item;
                });

            // Merge & deduplicate
            $activities = $activities->merge($collectiveActions)
                ->merge($userEcosystems)
                ->merge($ecosystemContributions)
                ->merge($collectiveActionContributions);

            $uniqueActivities = $activities->unique(fn($item) => $item->type . '_' . $item->id);

            return $uniqueActivities->sortByDesc('created_at')->take(10)->values();
        });
    }


    public function render()
    {
        return view('livewire.dashboard.activity-timeline', [
            'activities' => $this->activities
        ]);
    }
}
