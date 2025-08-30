<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CollaborationService;

class CollaborationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CollaborationService::class, function ($app) {
            return new CollaborationService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
