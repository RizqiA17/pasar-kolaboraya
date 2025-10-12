<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register custom middleware
        $middleware->alias([
            'refresh.csrf' => \App\Http\Middleware\RefreshCsrfToken::class,
            'session.refresh' => \App\Http\Middleware\SessionRefresh::class,
            'csrf.manager' => \App\Http\Middleware\CsrfTokenManager::class,
            'super.admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'check.login.status' => \App\Http\Middleware\CheckLoginStatus::class,
            'check.feature.access' => \App\Http\Middleware\CheckFeatureAccess::class,
            'check.form.feature.access' => \App\Http\Middleware\CheckFormFeatureAccess::class,
            'ecosystem.builder.only' => \App\Http\Middleware\EcosystemBuilderOnly::class,
            'read.only.access' => \App\Http\Middleware\ReadOnlyAccess::class,
            'check.active.pasar.kolaboraya' => \App\Http\Middleware\CheckActivePasarKolaboraya::class,
            'check.user.approval' => \App\Http\Middleware\CheckUserApproval::class,
            'can.join.ecosystems.and.actions' => \App\Http\Middleware\CanJoinEcosystemsAndActions::class,
        ]);
        
        // Apply CSRF refresh middleware to web routes
        $middleware->web(append: [
            // \App\Http\Middleware\RefreshCsrfToken::class,
            // \App\Http\Middleware\SessionRefresh::class,
            // \App\Http\Middleware\CsrfTokenManager::class,
        ]);
        
        // Note: CheckUserApproval middleware is applied per-route, not globally
        // to avoid redirect loops with pending-approval and rejected routes
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Report specific exceptions
        $exceptions->reportable(function (\Illuminate\Session\TokenMismatchException $e) {
            \Illuminate\Support\Facades\Log::warning('CSRF token mismatch detected', [
                'url' => request()->url(),
                'method' => request()->method(),
                'user_id' => \Illuminate\Support\Facades\Auth::id() ?? 'guest',
                'session_id' => \Illuminate\Support\Facades\Session::getId(),
            ]);
        });
    })->create();

// Include email testing routes in development
if (app()->environment('local', 'development')) {
    require_once __DIR__.'/../routes/email-testing.php';
}
