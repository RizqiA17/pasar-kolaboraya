<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleEmailController;

/*
|--------------------------------------------------------------------------
| Email Testing Routes
|--------------------------------------------------------------------------
|
| Routes untuk testing dan preview email templates
| Hanya aktif di environment development
|
*/

if (app()->environment('local', 'development')) {
    
    // Preview email templates
    Route::prefix('email-preview')->group(function () {
        Route::get('/welcome', function () {
            return app(ExampleEmailController::class)->previewEmailTemplate(
                new \Illuminate\Http\Request(['template' => 'welcome'])
            );
        })->name('email.preview.welcome');
        
        Route::get('/event-notification', function () {
            return app(ExampleEmailController::class)->previewEmailTemplate(
                new \Illuminate\Http\Request(['template' => 'event-notification'])
            );
        })->name('email.preview.event');
        
        Route::get('/new-connection', function () {
            return app(ExampleEmailController::class)->previewEmailTemplate(
                new \Illuminate\Http\Request(['template' => 'new-connection'])
            );
        })->name('email.preview.connection');
        
        Route::get('/collaboration-invitation', function () {
            return app(ExampleEmailController::class)->previewEmailTemplate(
                new \Illuminate\Http\Request(['template' => 'collaboration-invitation'])
            );
        })->name('email.preview.collaboration-invitation');
        
        Route::get('/collaboration-status-update', function () {
            return app(ExampleEmailController::class)->previewEmailTemplate(
                new \Illuminate\Http\Request(['template' => 'collaboration-status-update'])
            );
        })->name('email.preview.collaboration-status');
        
        Route::get('/reset-password', function () {
            return app(ExampleEmailController::class)->previewEmailTemplate(
                new \Illuminate\Http\Request(['template' => 'reset-password'])
            );
        })->name('email.preview.reset-password');
    });
    
    // Test pengiriman email (dengan data dummy)
    Route::prefix('email-test')->group(function () {
        Route::post('/welcome', [ExampleEmailController::class, 'sendWelcomeEmail'])
            ->name('email.test.welcome');
            
        Route::post('/event-notification', [ExampleEmailController::class, 'sendEventNotification'])
            ->name('email.test.event');
            
        Route::post('/new-connection', [ExampleEmailController::class, 'sendConnectionNotification'])
            ->name('email.test.connection');
            
        Route::post('/collaboration-invitation', [ExampleEmailController::class, 'sendCollaborationInvitation'])
            ->name('email.test.collaboration-invitation');
            
        Route::post('/collaboration-status-update', [ExampleEmailController::class, 'sendStatusUpdate'])
            ->name('email.test.collaboration-status');
    });
    
    // Dashboard untuk testing email
    Route::get('/email-testing-dashboard', function () {
        return view('emails.testing.dashboard');
    })->name('email.testing.dashboard');
}
