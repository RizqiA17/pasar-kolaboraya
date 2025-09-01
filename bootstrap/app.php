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
        ]);
        
        // Apply CSRF refresh middleware to web routes
        $middleware->web(append: [
            \App\Http\Middleware\RefreshCsrfToken::class,
        ]);
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
