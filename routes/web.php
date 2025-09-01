<?php

use App\Models\Connection;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifiedEmail;
use App\Livewire\Collaborations\Create;
use App\Livewire\Connections\Suggestion;
use App\Livewire\Settings\ProfileSettings;
use App\Livewire\Connections\ConnectionsTab;
use App\Livewire\Connections\ListConnection;
use App\Livewire\Collaborations\NewCollaboration;
use App\Livewire\Collaborations\ListCollaboration;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Test routes for error pages (remove in production)
if (app()->environment('local', 'development')) {
    Route::get('/test/404', function () {
        abort(404, 'Test 404 page');
    })->name('test.404');
    
    Route::get('/test/500', function () {
        abort(500, 'Test 500 page');
    })->name('test.500');
    
    Route::get('/test/csrf', function () {
        abort(419, 'Test CSRF token mismatch');
    })->name('test.csrf');
}

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', VerifiedEmail::class])
    ->name('dashboard');

Route::middleware(['auth', VerifiedEmail::class])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('settings/profile-settings', ProfileSettings::class)->name('settings.profile-settings');

    // Route untuk melihat profile user lain
    Route::get('profile/{userId}', \App\Livewire\Profile\ViewProfile::class)->name('profile.view');

    Route::get('connections', ConnectionsTab::class)->name('connections');

    Route::get('collaborations', \App\Livewire\Collaborations\CollaborationManager::class)->name('collaborations.manage');
    Route::get('collaborations/list', ListCollaboration::class)->name('collaborations');
    Route::get('collaborations/create', Create::class)->name('collaborations.create');
    Route::get('collaborations/new', NewCollaboration::class)->name('collaborations.new-collaboration');
    Route::get('collaborations/{collaboration}/todos', \App\Livewire\Collaborations\TodoList::class)->name('collaboration.todos');

    // Event Routes
    Route::get('events', \App\Livewire\Events\ListEvent::class)->name('events');
    Route::get('events/create', \App\Livewire\Events\CreateEvent::class)->name('events.create');
    Route::get('events/{event}', \App\Livewire\Events\ShowEvent::class)->name('events.show');

});

require __DIR__ . '/auth.php';
