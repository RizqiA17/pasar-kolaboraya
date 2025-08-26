<?php

use App\Livewire\Collaborations\ListCollaboration;
use App\Models\Connection;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Connections\Suggestion;
use App\Livewire\Connections\ConnectionsTab;
use App\Livewire\Connections\ListConnection;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('connections', ConnectionsTab::class)->name('connections');

    // Route::get('connections/list', ListConnection::class)->name('connections.list');
    // Route::get('connections/suggestion', Suggestion::class)->name('connections.suggestion');
    // Route::get('connections/request', Appearance::class)->name('connections.request');

    Route::get('collaborations', ListCollaboration::class)->name('collaborations');

});

require __DIR__ . '/auth.php';
