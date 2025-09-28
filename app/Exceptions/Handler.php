<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
            Log::info('TokenMismatchException caught', [
                'url' => $request->url(),
                'livewire' => $request->header('X-Livewire')
            ]);
            if ($request->header('X-Livewire')) {
                // Livewire request → kembalikan response JSON tanpa trigger alert
                return response()->json(['message' => 'CSRF expired'], 419);
            }
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'CSRF token mismatch. Please refresh the page and try again.',
                    'error' => 'token_mismatch'
                ], 419);
            }

            // Show custom 419 error page for page expired errors
            return response()->view('errors.419', [], 419);
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
