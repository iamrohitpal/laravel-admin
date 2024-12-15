<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\Admin\Components\layout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Router;
use App\Http\Middleware\RoleCheck;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Blade::component('admin.layout', layout::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        $router->aliasMiddleware('admin', RoleCheck::class);
    }
}
