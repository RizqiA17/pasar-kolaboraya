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
use Illuminate\Support\Facades\Auth;

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

// CSRF token refresh route
Route::post('/csrf-token-refresh', function () {
    if (Auth::check()) {
        // Regenerate CSRF token
        session()->regenerateToken();
        session()->put('_token_created_at', time());
        
        return response()->json([
            'token' => csrf_token(),
            'timestamp' => time()
        ]);
    }
    
    return response()->json(['error' => 'Unauthenticated'], 401);
})->middleware(['auth', 'check.login.status'])->name('csrf.token.refresh');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'check.login.status', VerifiedEmail::class])
    ->name('dashboard');

Route::middleware(['auth', 'check.login.status', VerifiedEmail::class])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('settings/profile-settings', ProfileSettings::class)->name('settings.profile-settings');

    // Route untuk melihat profile user lain
    Route::get('profile/{userId}', \App\Livewire\Profile\ViewProfile::class)->name('profile.view');

    // Connection routes - protected by feature access middleware and active session
    Route::middleware(['check.feature.access:connections', 'check.active.pasar.kolaboraya'])->group(function () {
        Route::get('connections', ConnectionsTab::class)->name('connections');
    });

    // Collaboration routes - protected by feature access middleware and active session
    Route::middleware(['check.feature.access:collaborations', 'check.active.pasar.kolaboraya'])->group(function () {
        Route::get('collaborations', \App\Livewire\Collaborations\CollaborationManager::class)->name('collaborations.manage');
        Route::get('collaborations/list', ListCollaboration::class)->name('collaborations');
        Route::get('collaborations/create', Create::class)->name('collaborations.create');
        Route::get('collaborations/new', NewCollaboration::class)->name('collaborations.new-collaboration');
        Route::get('collaborations/{collaboration}/todos', \App\Livewire\Collaborations\TodoList::class)->name('collaboration.todos');
    });

    // Event Routes - protected by user actions middleware and active session
    Route::middleware(['check.feature.access:user_actions', 'check.active.pasar.kolaboraya'])->group(function () {
        Route::get('events', \App\Livewire\Events\ListEvent::class)->name('events');
        Route::get('events/create', \App\Livewire\Events\CreateEvent::class)->name('events.create');
        Route::get('events/{event}', \App\Livewire\Events\ShowEvent::class)->name('events.show');
    });

    // Survey Routes - protected by active session
    // Route::middleware('check.active.pasar.kolaboraya')->group(function () {
        Route::get('survey/participate', \App\Livewire\Survey\Participate::class)->name('survey.participate');
    // });

    // Ecosystem Routes (Protected by ecosystems feature check and active session)
    Route::middleware(['check.feature.access:ecosystems', 'check.active.pasar.kolaboraya'])->group(function () {
        Route::get('ecosystem', \App\Livewire\Ecosystem\Browse::class)->name('ecosystem.browse');
        Route::get('ecosystem/create', \App\Livewire\Ecosystem\Create::class)->name('ecosystem.create');
        Route::get('ecosystem/{ecosystem}/join', \App\Livewire\Ecosystem\Join::class)->name('ecosystem.join');
        Route::get('ecosystem/{ecosystem}/dashboard', \App\Livewire\Ecosystem\Dashboard::class)->name('ecosystem.dashboard');
        Route::get('ecosystem/{ecosystem}/settings', \App\Livewire\Ecosystem\Settings::class)->name('ecosystem.settings');
        Route::get('ecosystem/{ecosystem}/contribute', \App\Livewire\Ecosystem\Contribute::class)->name('ecosystem.contribute');
    });

    // Collective Action Routes (Protected by collective_actions feature check and active session)
    Route::middleware(['check.feature.access:collective_actions', 'check.active.pasar.kolaboraya'])->group(function () {
        Route::get('collective-actions', \App\Livewire\CollectiveAction\Browse::class)->name('collective-action.browse');
        Route::get('collective-actions/create', \App\Livewire\CollectiveAction\Create::class)->name('collective-action.create')->middleware('ecosystem.builder.only');
        Route::get('collective-actions/{collectiveAction}', \App\Livewire\CollectiveAction\Dashboard::class)->name('collective-action.show');
        Route::get('collective-actions/{collectiveAction}/join', \App\Livewire\CollectiveAction\Join::class)->name('collective-action.join');
        Route::get('collective-actions/{collectiveAction}/contribute', \App\Livewire\CollectiveAction\Contribute::class)->name('collective-action.contribute');
        Route::get('collective-actions/{collectiveAction}/members', \App\Livewire\CollectiveAction\MemberManagement::class)->name('collective-action.members');
        Route::get('collective-actions/{collectiveAction}/approvals', \App\Livewire\CollectiveAction\UserApprovals::class)->name('collective-action.user-approvals');
        Route::get('collective-actions/invitations/{invitation}/respond', \App\Livewire\CollectiveAction\RespondInvitation::class)->name('collective-action.respond-invitation')->middleware('ecosystem.builder.only');
    });

});

// Pasar Kolaboraya Routes - These should be accessible without active session check
Route::middleware(['auth', 'check.login.status', VerifiedEmail::class])->group(function () {
    Route::get('pasar-kolaboraya/select', \App\Livewire\PasarKolaboraya\SessionSelector::class)->name('pasar-kolaboraya.select');
    Route::get('pasar-kolaboraya/join-request', \App\Livewire\PasarKolaboraya\JoinRequest::class)->name('pasar-kolaboraya.join-request');
});

// Admin routes - only accessible by super admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'check.login.status', 'super.admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Users management
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [App\Http\Controllers\AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Ecosystems management
    Route::get('/ecosystems', [App\Http\Controllers\AdminController::class, 'ecosystems'])->name('ecosystems');
    Route::get('/ecosystems/{ecosystem}', [App\Http\Controllers\AdminController::class, 'showEcosystem'])->name('ecosystems.show');
    Route::delete('/ecosystems/{ecosystem}', [App\Http\Controllers\AdminController::class, 'deleteEcosystem'])->name('ecosystems.delete');
    
    // Collective Actions management
    Route::get('/collective-actions', [App\Http\Controllers\AdminController::class, 'collectiveActions'])->name('collective-actions');
    Route::get('/collective-actions/{collectiveAction}', [App\Http\Controllers\AdminController::class, 'showCollectiveAction'])->name('collective-actions.show');
    Route::delete('/collective-actions/{collectiveAction}', [App\Http\Controllers\AdminController::class, 'deleteCollectiveAction'])->name('collective-actions.delete');
    
    // Connections management
    Route::get('/connections', [App\Http\Controllers\AdminController::class, 'connections'])->name('connections');
    Route::get('/connections/{connection}', [App\Http\Controllers\AdminController::class, 'showConnection'])->name('connections.show');
    
    // Market Analysis
    Route::get('/market-analysis', [App\Http\Controllers\AdminController::class, 'marketAnalysis'])->name('market-analysis');
    Route::get('/pasar-kolaboraya/{pasarKolaboraya}', [App\Http\Controllers\AdminController::class, 'showMarketAnalysis'])->name('market-analysis.show');
    Route::delete('/connections/{connection}', [App\Http\Controllers\AdminController::class, 'deleteConnection'])->middleware('check.form.feature.access:connections')->name('connections.delete');
    
    // Ecosystem Builder management
    Route::get('/ecosystem-builders', App\Livewire\Admin\EcosystemBuilderApproval::class)->name('ecosystem-builders');
    
    // Master data management
    Route::get('/interests', [App\Http\Controllers\AdminController::class, 'interests'])->name('interests');
    Route::post('/interests', [App\Http\Controllers\AdminController::class, 'createInterest'])->name('interests.create');
    Route::put('/interests/{interest}', [App\Http\Controllers\AdminController::class, 'updateInterest'])->name('interests.update');
    Route::delete('/interests/{interest}', [App\Http\Controllers\AdminController::class, 'deleteInterest'])->name('interests.delete');
    
    Route::get('/skills', [App\Http\Controllers\AdminController::class, 'skills'])->name('skills');
    Route::post('/skills', [App\Http\Controllers\AdminController::class, 'createSkill'])->name('skills.create');
    Route::put('/skills/{skill}', [App\Http\Controllers\AdminController::class, 'updateSkill'])->name('skills.update');
    Route::delete('/skills/{skill}', [App\Http\Controllers\AdminController::class, 'deleteSkill'])->name('skills.delete');
    
    Route::get('/contributions', [App\Http\Controllers\AdminController::class, 'contributions'])->name('contributions');
    Route::post('/contributions', [App\Http\Controllers\AdminController::class, 'createContribution'])->name('contributions.create');
    Route::put('/contributions/{contribution}', [App\Http\Controllers\AdminController::class, 'updateContribution'])->name('contributions.update');
    Route::delete('/contributions/{contribution}', [App\Http\Controllers\AdminController::class, 'deleteContribution'])->name('contributions.delete');
    
    Route::get('/event-categories', [App\Http\Controllers\AdminController::class, 'eventCategories'])->name('event-categories');
    Route::post('/event-categories', [App\Http\Controllers\AdminController::class, 'createEventCategory'])->name('event-categories.create');
    Route::put('/event-categories/{eventCategory}', [App\Http\Controllers\AdminController::class, 'updateEventCategory'])->name('event-categories.update');
    Route::delete('/event-categories/{eventCategory}', [App\Http\Controllers\AdminController::class, 'deleteEventCategory'])->name('event-categories.delete');
    
    // Peran management
    Route::get('/peran', [App\Http\Controllers\AdminController::class, 'peran'])->name('peran');
    Route::post('/peran', [App\Http\Controllers\AdminController::class, 'createPeran'])->name('peran.create');
    Route::put('/peran/{peran}', [App\Http\Controllers\AdminController::class, 'updatePeran'])->name('peran.update');
    Route::delete('/peran/{peran}', [App\Http\Controllers\AdminController::class, 'deletePeran'])->name('peran.delete');
    
    // System settings management
    Route::get('/system-settings', [App\Http\Controllers\AdminController::class, 'systemSettings'])->name('system-settings');
    Route::put('/system-settings', [App\Http\Controllers\AdminController::class, 'updateSystemSettings'])->name('system-settings.update');
    
    // Survey management routes
    Route::get('/surveys', \App\Livewire\Admin\Surveys\Index::class)->name('surveys');
    Route::get('/surveys/{surveyId}/results', \App\Livewire\Admin\Surveys\Results::class)->name('surveys.results');
    
    // Pasar Kolaboraya management routes
    Route::get('/pasar-kolaboraya', \App\Livewire\Admin\PasarKolaborayaManagement::class)->name('pasar-kolaboraya.manage');
    Route::get('/pasar-kolaboraya/create', \App\Livewire\Admin\CreatePasarKolaboraya::class)->name('pasar-kolaboraya.create');
    Route::get('/pasar-kolaboraya/{pasarKolaboraya}/users', \App\Livewire\Admin\ManagePasarKolaborayaUsers::class)->name('pasar-kolaboraya.users');
});

require __DIR__ . '/auth.php';
