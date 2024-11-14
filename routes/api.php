<?php

use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\Company\Employee\ApiEmployeeController;
use App\Http\Controllers\Api\Company\Manager\ApiManagerController;
use App\Http\Controllers\Api\SuperAdmin\ApiSuperAdminController;
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

    // SuperAdmin
    Route::group([
        'prefix'     => '/admin',
    ], function () {
        Route::post('/', [ApiSuperAdminController::class, 'create'])
            ->name('admin.create');
        Route::get('/{id}', [ApiSuperAdminController::class, 'getById'])
            ->name('admin.getOne');
        Route::get('/', [ApiSuperAdminController::class, 'getAll'])
            ->name('admin.get');
        Route::put('/{id}', [ApiSuperAdminController::class, 'update'])
            ->name('admin.update');
        Route::delete('/{id}', [ApiSuperAdminController::class, 'delete'])
            ->name('admin.delete');
    });

    // Manager
    Route::group([
        'prefix'     => '/manager',
    ], function () {
        Route::post('/', [ApiManagerController::class, 'create'])
            ->name('manager.create');
        Route::get('/{id}', [ApiManagerController::class, 'getById'])
            ->name('manager.getOne');
        Route::get('/', [ApiManagerController::class, 'getAll'])
            ->name('manager.get');
        Route::put('/{id}', [ApiManagerController::class, 'update'])
            ->name('manager.update');
        Route::delete('/{id}', [ApiManagerController::class, 'delete'])
            ->name('manager.delete');
    });

    // Employee
    Route::group([
        'prefix'     => '/employee',
    ], function () {
        Route::get('/{id}', [ApiEmployeeController::class, 'getById'])
            ->name('employee.getOne');
        Route::get('/', [ApiEmployeeController::class, 'getAll'])
            ->name('employee.get');
    });
});
