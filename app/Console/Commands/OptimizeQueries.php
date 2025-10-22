<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\QueryOptimizationService;
use App\Models\Ecosystem;
use App\Models\User;

class OptimizeQueries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queries:optimize {--warm-cache : Warm up all caches} {--clear-cache : Clear all caches}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize database queries and manage caches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('clear-cache')) {
            $this->clearCaches();
            return;
        }

        if ($this->option('warm-cache')) {
            $this->warmCaches();
            return;
        }

        $this->info('Query optimization completed!');
        $this->line('Use --warm-cache to warm up caches');
        $this->line('Use --clear-cache to clear all caches');
    }

    /**
     * Warm up all caches
     */
    private function warmCaches(): void
    {
        $this->info('Warming up caches...');

        // Cache frequent data
        QueryOptimizationService::cacheFrequentData();
        $this->line('✓ Cached frequent data');

        // Cache dashboard stats
        QueryOptimizationService::getDashboardStats();
        $this->line('✓ Cached dashboard stats');

        // Cache ecosystem analytics
        $ecosystems = Ecosystem::select('id')->get();
        $bar = $this->output->createProgressBar($ecosystems->count());
        $bar->start();

        foreach ($ecosystems as $ecosystem) {
            QueryOptimizationService::getEcosystemAnalytics($ecosystem);
            QueryOptimizationService::getEcosystemRoleDiversity($ecosystem);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->line('✓ Cached ecosystem analytics');

        // Cache user connections
        $users = User::select('id')->get();
        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            QueryOptimizationService::getUserConnections($user);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->line('✓ Cached user connections');

        $this->info('All caches warmed up successfully!');
    }

    /**
     * Clear all caches
     */
    private function clearCaches(): void
    {
        $this->info('Clearing all caches...');
        
        QueryOptimizationService::clearAllCaches();
        
        $this->info('All caches cleared successfully!');
    }
}
