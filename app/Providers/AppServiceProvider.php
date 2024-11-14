<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Company\Manager\ManagerService;
use App\Services\Company\Manager\ManagerServiceInterface;
use App\Services\SuperAdmin\SuperAdminService;
use App\Services\SuperAdmin\SuperAdminServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );

        $this->app->bind(
            SuperAdminServiceInterface::class,
            SuperAdminService::class
        );

        $this->app->bind(
            ManagerServiceInterface::class,
            ManagerService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
