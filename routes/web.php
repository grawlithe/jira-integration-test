<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\SocialiteAuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SyncController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Route::controller('SocialiteAuthController')->group(function () {
    // 1. Redirect to the provider (e.g., /auth/github)
    Route::get('auth/{provider}',[SocialiteAuthController::class, 'redirectToProvider'])->name('auth.redirect');

    // 2. Handle the callback from the provider (e.g., /auth/github/callback)
    Route::get('auth/{provider}/callback',[SocialiteAuthController::class, 'handleProviderCallback']);
// });

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::get('/sync', [SyncController::class, 'syncAll']);

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/test-jira', function(){
    $client = new \App\Services\Jira\JiraService();
    return $client->get('myself');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
