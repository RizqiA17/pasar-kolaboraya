<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Handle CSRF token mismatch
        $this->renderable(function (TokenMismatchException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'CSRF token mismatch. Please refresh the page and try again.',
                    'error' => 'token_mismatch'
                ], 419);
            }

            // For logout requests, redirect to home with message
            if ($request->is('logout')) {
                return redirect('/')->with('error', 'Session expired. You have been logged out.');
            }

            // For dashboard and other authenticated pages, redirect to login
            if ($request->is('dashboard*') || $request->is('profile*') || $request->is('settings*') || $request->is('connections*') || $request->is('collaborations*') || $request->is('events*')) {
                return redirect()->route('login')->with('error', 'Session Anda telah berakhir. Silakan login kembali.');
            }

            // For other requests, redirect back with error
            return redirect()->back()->withInput()->with('error', 'Halaman telah expired. Silakan refresh dan coba lagi.');
        });

        // Handle authentication exceptions
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                    'error' => 'unauthenticated'
                ], 401);
            }

            return redirect()->route('login')->with('error', 'Please login to continue.');
        });

        // Handle validation exceptions
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $e->errors(),
                    'error' => 'validation_failed'
                ], 422);
            }

            return redirect()->back()->withInput()->withErrors($e->errors());
        });

        // Handle HTTP exceptions (404, 500, etc.)
        $this->renderable(function (HttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'error' => 'http_exception',
                    'code' => $e->getStatusCode()
                ], $e->getStatusCode());
            }

            $statusCode = $e->getStatusCode();
            
            if ($statusCode === 404) {
                return response()->view('errors.404', [], 404);
            }
            
            if ($statusCode >= 500) {
                return response()->view('errors.500', [], 500);
            }

            return response()->view('errors.generic', [
                'message' => $e->getMessage(),
                'code' => $statusCode
            ], $statusCode);
        });
    }
}
