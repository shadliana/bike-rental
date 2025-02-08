<?php
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use Laravel\Passport\Passport;

Passport::routes();

Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])
    ->middleware(['throttle'])
    ->name('passport.token');

Route::get('/oauth/authorize', [AuthorizationController::class, 'authorize'])
    ->middleware(['web', 'auth'])
    ->name('passport.authorizations.authorize');

Route::post('/oauth/authorize', [AuthorizationController::class, 'approve'])
    ->middleware(['web', 'auth'])
    ->name('passport.authorizations.approve');

Route::delete('/oauth/authorize', [AuthorizationController::class, 'deny'])
    ->middleware(['web', 'auth'])
    ->name('passport.authorizations.deny');

Route::post('/oauth/token/refresh', [TransientTokenController::class, 'refresh'])
    ->middleware(['throttle'])
    ->name('passport.token.refresh');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/oauth/clients', [ClientController::class, 'forUser'])->name('passport.clients.index');
    Route::post('/oauth/clients', [ClientController::class, 'store'])->name('passport.clients.store');
    Route::put('/oauth/clients/{client_id}', [ClientController::class, 'update'])->name('passport.clients.update');
    Route::delete('/oauth/clients/{client_id}', [ClientController::class, 'destroy'])->name('passport.clients.destroy');

    Route::get('/oauth/personal-access-tokens', [PersonalAccessTokenController::class, 'forUser'])->name('passport.personal.tokens.index');
    Route::post('/oauth/personal-access-tokens', [PersonalAccessTokenController::class, 'store'])->name('passport.personal.tokens.store');
    Route::delete('/oauth/personal-access-tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy'])->name('passport.personal.tokens.destroy');
});
