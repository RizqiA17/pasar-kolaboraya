<?php

namespace App\Services;

use App\Models\Ecosystem;
use App\Models\User;
use App\Models\Peran;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class QueryOptimizationService
{
    /**
     * Cache frequently accessed data
     */
    public static function cacheFrequentData(): void
    {
        // Cache total roles count
        Cache::remember('total_roles_count', 3600, function () {
            return Peran::count();
        });

        // Cache all roles IDs
        Cache::remember('all_roles_ids', 3600, function () {
            return Peran::pluck('id')->toArray();
        });

        // Cache roles mapping
        Cache::remember('roles_mapping', 3600, function () {
            return Peran::pluck('nama', 'id')->toArray();
        });
    }

    /**
     * Get ecosystem analytics with optimized queries
     */
    public static function getEcosystemAnalytics(Ecosystem $ecosystem): array
    {
        return Cache::remember("ecosystem_analytics_{$ecosystem->id}", 300, function () use ($ecosystem) {
            return $ecosystem->getEcosystemAnalytics();
        });
    }

    /**
     * Get user connections with optimized query
     */
    public static function getUserConnections(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("user_connections_{$user->id}", 600, function () use ($user) {
            return $user->getAllConnectionsFlexible();
        });
    }

    /**
     * Get ecosystem role diversity with single query
     */
    public static function getEcosystemRoleDiversity(Ecosystem $ecosystem): array
    {
        return Cache::remember("ecosystem_role_diversity_{$ecosystem->id}", 300, function () use ($ecosystem) {
            return $ecosystem->getRoleDiversityDetails();
        });
    }

    /**
     * Bulk update ecosystem scores
     */
    public static function bulkUpdateEcosystemScores(): void
    {
        $ecosystems = Ecosystem::select('id')->get();
        
        foreach ($ecosystems as $ecosystem) {
            $ecosystem->calculateEkosistemScore();
        }
    }

    /**
     * Get dashboard statistics with optimized queries
     */
    public static function getDashboardStats(): array
    {
        return Cache::remember('dashboard_stats', 300, function () {
            return [
                'total_users' => User::count(),
                'total_ecosystems' => Ecosystem::count(),
                'active_ecosystems' => Ecosystem::where('is_active', true)->count(),
                'total_roles' => Peran::count(),
            ];
        });
    }

    /**
     * Optimize ecosystem listing query
     */
    public static function getOptimizedEcosystems($filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Ecosystem::forListing()
            ->where('is_active', true);

        // Apply filters
        if (isset($filters['search']) && $filters['search']) {
            $query->where(function ($q) use ($filters) {
                $q->where('ecosystem_title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('organization_name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['region']) && $filters['region']) {
            $query->where('work_region', 'like', '%' . $filters['region'] . '%');
        }

        if (isset($filters['issue']) && $filters['issue']) {
            $query->whereJsonContains('issues_addressed', $filters['issue']);
        }

        if (isset($filters['needed_role']) && $filters['needed_role']) {
            $query->whereJsonContains('needed_roles', $filters['needed_role']);
        }

        return $query->latest()->paginate(12);
    }

    /**
     * Clear all ecosystem related caches
     */
    public static function clearEcosystemCaches(): void
    {
        $ecosystems = Ecosystem::select('id')->get();
        
        foreach ($ecosystems as $ecosystem) {
            Cache::forget("ecosystem_analytics_{$ecosystem->id}");
            Cache::forget("ecosystem_role_diversity_{$ecosystem->id}");
        }
    }

    /**
     * Clear all user related caches
     */
    public static function clearUserCaches(): void
    {
        $users = User::select('id')->get();
        
        foreach ($users as $user) {
            Cache::forget("user_connections_{$user->id}");
            Cache::forget("user_has_ecosystem_{$user->id}_{$user->active_pasar_kolaboraya_id}");
        }
    }

    /**
     * Clear all caches
     */
    public static function clearAllCaches(): void
    {
        Cache::forget('total_roles_count');
        Cache::forget('all_roles_ids');
        Cache::forget('roles_mapping');
        Cache::forget('admin_dashboard_stats');
        Cache::forget('dashboard_stats');
        
        self::clearEcosystemCaches();
        self::clearUserCaches();
    }
}


