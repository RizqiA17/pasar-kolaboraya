<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Collaboration;
use App\Models\Event;
use App\Models\Connection;
use App\Models\Interest;
use App\Models\Skill;
use App\Models\Contribution;
use App\Models\EventCategory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default locale to Indonesian
        App::setLocale('id');
        
        // Configure route model binding to include soft deleted models
        $this->configureRouteModelBinding();
    }
    
    /**
     * Configure route model binding to include soft deleted models
     */
    private function configureRouteModelBinding(): void
    {
        // For models that use SoftDeletes, include trashed models in route binding
        Route::bind('user', function ($value) {
            return User::withTrashed()->where('id', $value)->firstOrFail();
        });
        
        Route::bind('collaboration', function ($value) {
            return Collaboration::withTrashed()->where('id', $value)->firstOrFail();
        });
        
        Route::bind('event', function ($value) {
            return Event::withTrashed()->where('id', $value)->firstOrFail();
        });
        
        Route::bind('connection', function ($value) {
            return Connection::withTrashed()->where('id', $value)->firstOrFail();
        });
        
        Route::bind('interest', function ($value) {
            return Interest::withTrashed()->where('id', $value)->firstOrFail();
        });
        
        Route::bind('skill', function ($value) {
            return Skill::withTrashed()->where('id', $value)->firstOrFail();
        });
        
        Route::bind('contribution', function ($value) {
            return Contribution::withTrashed()->where('id', $value)->firstOrFail();
        });
        
        Route::bind('eventCategory', function ($value) {
            return EventCategory::withTrashed()->where('id', $value)->firstOrFail();
        });
    }
}
