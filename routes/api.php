<?php

use App\Http\Controllers\Api\Auth\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'    => '/v1',
], function () {
    // Auth
    Route::group([
        'prefix'     => '/auth',
    ], function () {
        Route::post('/login', [ApiAuthController::class, 'login'])
            ->name('auth.login');
        Route::post('/refresh', [ApiAuthController::class, 'refresh'])
            ->name('auth.refresh');
        Route::post('/logout', [ApiAuthController::class, 'logout'])
            ->name('auth.logout');
    });
});
