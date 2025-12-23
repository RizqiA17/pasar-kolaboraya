<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ApiDocumentationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// API Documentation
Route::get('/{version}/docs', [ApiDocumentationController::class, 'index'])
    ->name('api.docs')
    ->where('version', 'v1');

// API Version 1 - User Authentication (Sanctum)
Route::prefix('v1')
    ->middleware(['auth:sanctum', 'throttle:60,1'])
    ->name('api.v1.')
    ->group(function () {

        // User endpoints - protected by Sanctum and rate limiting
        Route::controller(UserController::class)->group(function () {

            // Get user by QR code
            Route::post('/users/qr', 'getByQr')
                ->name('users.qr');

            // Get user by ID
            Route::get('/users/{id}', 'getById')
                ->where('id', '[0-9]+')
                ->name('users.show');

            // Get paginated list of users
            Route::get('/users', 'index')
                ->name('users.index');
        });

    });

// API Version 1 - Secure (Sanctum + Signature)
Route::prefix('v1/secure')
    ->middleware(['auth:sanctum', 'secure.api', 'throttle:30,1'])
    ->name('api.v1.secure.')
    ->group(function () {

        // Secure user endpoints - additional signature verification
        Route::controller(UserController::class)->group(function () {

            // Get user by QR code (secure)
            Route::post('/users/qr', 'getByQr')
                ->name('users.qr');

            // Get user by ID (secure)
            Route::get('/users/{id}', 'getById')
                ->where('id', '[0-9]+')
                ->name('users.show');

            // Get paginated list of users (secure)
            Route::get('/users', 'index')
                ->name('users.index');
        });

    });

// API Version 1 - Application-to-Application (API Key)
Route::prefix('v1/app')
    ->middleware(['api.key', 'throttle:100,1'])
    ->name('api.v1.app.')
    ->group(function () {

        // Application endpoints - protected by API Key
        Route::controller(UserController::class)->group(function () {

            // Get user by QR code (app)
            Route::post('/users/qr', 'getByQr')
                ->name('users.qr');

            // Get user by ID (app)
            Route::get('/users/{id}', 'getById')
                ->where('id', '[0-9]+')
                ->name('users.show');

            // Get paginated list of users (app)
            Route::get('/users', 'index')
                ->name('users.index');
        });

    });

Route::middleware(['web', 'auth'])->prefix('notifications')->group(function () {

    Route::get('/recent', [NotificationController::class, 'recent']);
    Route::get('/unread-count', [NotificationController::class, 'unreadCount']);
    Route::post('/{receiver}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/read-all', [NotificationController::class, 'markAllAsRead']);

});