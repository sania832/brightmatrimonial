<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Spatie\Permission\Middlewares\RoleMiddleware;
// use Spatie\Permission\Middlewares\PermissionMiddleware;
// use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->booting(function () {
        //     $loader = app(Facade::class);
        //     $loader->alias('role', RoleMiddleware::class);
        //     $loader->alias('permission', PermissionMiddleware::class);
        //     $loader->alias('role_or_permission', RoleOrPermissionMiddleware::class);
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
