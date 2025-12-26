<?php

use App\Models\Connection;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifiedEmail;
use App\Livewire\Collaborations\Create;
use App\Livewire\Connections\Suggestion;
use App\Http\Controllers\QrCodeController;
use App\Livewire\Settings\ProfileSettings;
use App\Livewire\Connections\ConnectionsTab;
use App\Livewire\Connections\ListConnection;
use App\Livewire\Collaborations\NewCollaboration;
use App\Livewire\Collaborations\ListCollaboration;

Route::get('/', function () {
    return view('welcome');
})->name('home');


// Admin Market Statistics Route (Admin Only)
Route::middleware(['auth', 'check.login.status', VerifiedEmail::class, 'super.admin'])->group(function () {
    Route::get('admin/market-statistics', [App\Http\Controllers\AdminMarketStatisticsController::class, 'index'])->name('admin.market.statistics');
});

// Pasar Kolaboraya QR Registration Routes (Admin Only - Auth Required)
Route::middleware(['auth', 'check.login.status', VerifiedEmail::class, 'check.user.approval'])->group(function () {
    Route::get('pasar-kolaboraya/qr/{code?}', [App\Http\Controllers\PasarKolaborayaQrController::class, 'showRegistrationQr'])->name('pasar-kolaboraya.qr.registration');
    Route::get('pasar-kolaboraya/qr-data/{code?}', [App\Http\Controllers\PasarKolaborayaQrController::class, 'getQrData'])->name('pasar-kolaboraya.qr.data');
    Route::get('pasar-kolaboraya/qr-download/{code?}', [App\Http\Controllers\PasarKolaborayaQrController::class, 'downloadQr'])->name('pasar-kolaboraya.qr.download');
    Route::get('pasar-kolaboraya/qr-printable/{code?}', [App\Http\Controllers\PasarKolaborayaQrController::class, 'showPrintableQr'])->name('pasar-kolaboraya.qr.printable');
});

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

    Route::get('/test/camera', function () {
        return view('test-camera');
    })->name('test.camera');
}

// CSRF token refresh route
Route::post('/csrf-token-refresh', function () {
    if (Auth::check()) {
        // Regenerate CSRF token
        session()->put('_previous_token', csrf_token());
        session()->regenerateToken();
        session()->put('_token_created_at', time());

        return response()->json([
            'token' => csrf_token(),
            'timestamp' => time(),
            'session_expired_at' => time() + (config('session.lifetime') * 60),
            'previous_token' => session()->get('_previous_token'),
        ]);
    }

    return response()->json(['error' => 'Unauthenticated'], 401);
})->middleware(['auth', 'check.login.status', VerifiedEmail::class, 'check.user.approval'])->name('csrf.token.refresh');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'check.login.status', VerifiedEmail::class, 'check.user.approval'])
    ->name('dashboard');

Route::middleware(['auth', 'check.login.status', VerifiedEmail::class, 'check.user.approval'])->group(function () {
    // Broadcasting auth route
    Route::post('/broadcasting/auth', function () {
        return response()->json(['status' => 'success']);
    })->name('broadcasting.auth');

    // QR status check route (for polling fallback)
    Route::get('/qr/status', [QrCodeController::class, 'checkStatus'])->name('qr.status');

    Route::post('/set-pasar', [QrCodeController::class, 'setPasar'])->name('set.pasar');

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

    // Notification Routes - Specific routes must come before parameterized routes
    Route::get('notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/recent', [App\Http\Controllers\NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::get('notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::post('notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('notifications/read/all', [App\Http\Controllers\NotificationController::class, 'destroyAllRead'])->name('notifications.destroy-all-read');
    Route::get('notifications/test', [App\Http\Controllers\NotificationController::class, 'test'])->name('notifications.test');

    // Parameterized routes must come after specific routes
    Route::get('notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('notifications/{notification}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::delete('notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');


    // Ecosystem Routes (Protected by ecosystems feature check and active session)
    Route::middleware(['check.feature.access:ecosystems', 'check.active.pasar.kolaboraya'])->group(function () {
        Route::get('ecosystem', \App\Livewire\Ecosystem\Browse::class)->name('ecosystem.browse');
        Route::get('ecosystem/create', \App\Livewire\Ecosystem\Create::class)->name('ecosystem.create');
        Route::get('ecosystem/{ecosystem}/join', \App\Livewire\Ecosystem\Join::class)->name('ecosystem.join')->middleware('can.join.ecosystems.and.actions');
        Route::get('ecosystem/{ecosystem}/dashboard', \App\Livewire\Ecosystem\Dashboard::class)->name('ecosystem.dashboard');
        Route::get('ecosystem/{ecosystem}/settings', \App\Livewire\Ecosystem\Settings::class)->name('ecosystem.settings');
        Route::get('ecosystem/{ecosystem}/edit', \App\Livewire\Ecosystem\Edit::class)->name('ecosystem.edit');
        Route::get('ecosystem/{ecosystem}/contribute', \App\Livewire\Ecosystem\Contribute::class)->name('ecosystem.contribute');
        Route::get('ecosystem/{ecosystem}/members', \App\Livewire\Ecosystem\Members::class)->name('ecosystem.members');
        Route::get('ecosystem/{ecosystem}/contributions', \App\Livewire\Ecosystem\Contributions::class)->name('ecosystem.contributions');

        // Ecosystem QR Code routes
        Route::get('ecosystem/{ecosystem}/qr', [App\Http\Controllers\EcosystemQrController::class, 'showQr'])->name('ecosystem.qr.show');
        Route::get('ecosystem/{ecosystem}/qr/generate', [App\Http\Controllers\EcosystemQrController::class, 'generateQr'])->name('ecosystem.qr.generate');
        Route::get('ecosystem/{ecosystem}/qr/data', [App\Http\Controllers\EcosystemQrController::class, 'getQrData'])->name('ecosystem.qr.data');
    });

    // Public Ecosystem Mapping Route
    Route::get('ecosystem-mapping', function () {
        return view('ecosystem-mapping');
    })->name('ecosystem.mapping');


    // Collective Action QR Scanner route - only for tamu and partisipan users
    Route::get('collective-actions/qr-scanner', \App\Livewire\CollectiveAction\QrScanner::class)->name('collective-action.qr.scanner')->middleware('can.join.ecosystems.and.actions');
    Route::post('collective-actions/qr-scanner/process', [App\Http\Controllers\CollectiveActionQrController::class, 'processScan'])->name('collective-action.qr.process-scan');

    // Ecosystem QR Scanner route - only for tamu and partisipan users
    Route::get('ecosystem/qr-scanner', \App\Livewire\Ecosystem\QrScanner::class)->name('ecosystem.qr.scanner')->middleware('can.join.ecosystems.and.actions');

    // Collective Action Routes (Protected by collective_actions feature check and active session)
    Route::middleware(['check.feature.access:collective_actions', 'check.active.pasar.kolaboraya'])->group(function () {
        Route::get('collective-actions', \App\Livewire\CollectiveAction\Browse::class)->name('collective-action.browse');
        Route::get('collective-actions/create', \App\Livewire\CollectiveAction\Create::class)->name('collective-action.create')->middleware('ecosystem.builder.only');
        Route::get('collective-actions/{collectiveAction}', \App\Livewire\CollectiveAction\Dashboard::class)->name('collective-action.show');
        Route::get('collective-actions/{collectiveAction}/edit', \App\Livewire\CollectiveAction\Edit::class)->name('collective-action.edit')->middleware('ecosystem.builder.only');
        Route::get('collective-actions/{collectiveAction}/join', \App\Livewire\CollectiveAction\Join::class)->name('collective-action.join')->middleware('can.join.ecosystems.and.actions');
        Route::get('collective-actions/{collectiveAction}/contribute', \App\Livewire\CollectiveAction\Contribute::class)->name('collective-action.contribute');
        Route::get('collective-actions/{collectiveAction}/members', \App\Livewire\CollectiveAction\Members::class)->name('collective-action.members');
        Route::get('collective-actions/{collectiveAction}/contributions', \App\Livewire\CollectiveAction\Contributions::class)->name('collective-action.contributions');
        Route::get('collective-actions/{collectiveAction}/approvals', \App\Livewire\CollectiveAction\UserApprovals::class)->name('collective-action.user-approvals');
        Route::get('collective-actions/invitations/{invitation}/respond', \App\Livewire\CollectiveAction\RespondInvitation::class)->name('collective-action.respond-invitation')->middleware('ecosystem.builder.only');

        // Collective Action QR Code routes
        Route::get('collective-actions/{collectiveAction}/qr', [App\Http\Controllers\CollectiveActionQrController::class, 'showQr'])->name('collective-action.qr.show');
        // Route::get('collective-actions/{collectiveAction}/qr/generate', [App\Http\Controllers\CollectiveActionQrController::class, 'generateQr'])->name('collective-action.qr.generate');
        Route::get('collective-actions/{collectiveAction}/qr/data', [App\Http\Controllers\CollectiveActionQrController::class, 'getQrData'])->name('collective-action.qr.data');
    });

    // Like functionality routes (accessible to all approved users)
    Route::middleware(['check.user.approval'])->group(function () {
        // Collective Action Like routes
        Route::post('collective-actions/{collectiveAction}/like', [App\Http\Controllers\LikeController::class, 'toggleCollectiveActionLike'])->name('collective-action.like');
        Route::get('collective-actions/{collectiveAction}/like-status', [App\Http\Controllers\LikeController::class, 'getCollectiveActionLikeStatus'])->name('collective-action.like-status');

        // Ecosystem Like routes
        Route::post('ecosystem/{ecosystem}/like', [App\Http\Controllers\LikeController::class, 'toggleEcosystemLike'])->name('ecosystem.like');
        Route::get('ecosystem/{ecosystem}/like-status', [App\Http\Controllers\LikeController::class, 'getEcosystemLikeStatus'])->name('ecosystem.like-status');
    });


});

// Pasar Kolaboraya Routes - These should be accessible without active session check
Route::middleware(['auth', 'check.login.status', VerifiedEmail::class, 'check.user.approval'])->group(function () {
    Route::get('pasar-kolaboraya/select', \App\Livewire\PasarKolaboraya\SessionSelector::class)->name('pasar-kolaboraya.select');
    Route::get('pasar-kolaboraya/join-request', \App\Livewire\PasarKolaboraya\JoinRequest::class)->name('pasar-kolaboraya.join-request');
});

// QR Code Routes
Route::middleware(['auth', 'check.login.status', VerifiedEmail::class, 'check.user.approval'])->group(function () {
    Route::get('qr-code', [App\Http\Controllers\QrCodeController::class, 'show'])->name('qr.show');
    Route::post('qr-code/generate', [App\Http\Controllers\QrCodeController::class, 'generate'])->name('qr.generate');
    Route::post('qr-code/validate', [App\Http\Controllers\QrCodeController::class, 'validate'])->name('qr.validate');
    Route::post('qr-code/grant-access', [App\Http\Controllers\QrCodeController::class, 'grantAccess'])->name('qr.grant-access');
});

// Admin routes - only accessible by super admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'check.login.status', VerifiedEmail::class, 'super.admin'])->group(function () {
    Route::get('/', App\Livewire\Admin\Dashboard::class)->name('dashboard');

    // Users management
    Route::get('/users', App\Livewire\Admin\User::class)->name('users');
    Route::get('/users/{user}', [App\Http\Controllers\AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', App\Livewire\Admin\UserEdit::class)->name('users.edit');
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

    // Registration Keys management
    Route::get('/registration-keys', App\Livewire\Admin\ManageRegistrationKeys::class)->name('registration-keys');

    // User Approval management
    Route::get('/user-approvals', App\Livewire\Admin\UserApprovalManagement::class)->name('user-approvals');

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
    Route::get('/pasar-kolaboraya', App\Livewire\Admin\PasarKolaboraya::class)->name('pasar-kolaboraya.manage');
    Route::get('/pasar-kolaboraya/create', \App\Livewire\Admin\CreatePasarKolaboraya::class)->name('pasar-kolaboraya.create');
    Route::get('/pasar-kolaboraya/{pasarKolaboraya}/users', \App\Livewire\Admin\ManagePasarKolaborayaUsers::class)->name('pasar-kolaboraya.users');
    Route::get('/pasar-kolaboraya/{pasarKolaboraya}/qr-scanner', \App\Livewire\Admin\PasarKolaborayaQrScanner::class)->name('pasar-kolaboraya.qr-scanner');

    // Pasar Kolaboraya export routes
    Route::get('/pasar-kolaboraya/{pasarKolaboraya}/export-csv', [App\Http\Controllers\Admin\PasarKolaborayaExportController::class, 'exportCsv'])->name('pasar-kolaboraya.export-csv');
    Route::get('/pasar-kolaboraya/{pasarKolaboraya}/export-sql', [App\Http\Controllers\Admin\PasarKolaborayaExportController::class, 'exportSql'])->name('pasar-kolaboraya.export-sql');

    // QR Code Scanner for admin
    Route::get('/qr-scanner', \App\Livewire\Admin\QrScanner::class)->name('qr-scanner');
});

Route::get('/sse/notifications', function () {
    $userId = auth()->id();

    return response()->stream(function () use ($userId) {
        set_time_limit(0);

        while (true) {
            $count = Redis::get("user:$userId:notifications:unread_count");

            if ($count > 0) {
                echo "event: notification\n";
                echo "data: {$count}\n\n";
                ob_flush();
                flush();
            }

            sleep(3);
        }
    }, 200, [
        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
        'X-Accel-Buffering' => 'no',
    ]);
})->middleware('auth');


// Route::get('/test', function () {
//     return view('test');
// });

require __DIR__ . '/auth.php';
