<?php

namespace App\Providers;

use App\Http\Middleware\RoleCheck;
use App\View\Admin\Components\layout;
use App\View\Admin\Components\modal;
use App\View\Web\Components\layout as webLayout;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Blade::component('admin.layout', layout::class);
        Blade::component('admin.modal', modal::class);
        Blade::component('web.layout', webLayout::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        $this->configureRoutes();
        $router->aliasMiddleware('admin', RoleCheck::class);
    }

    /**
     * Define the application's route groups.
     */
    protected function configureRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        Route::middleware('web')
            ->prefix('admin')
            ->group(base_path('routes/auth.php'));

        Route::middleware('web')
            ->prefix('admin')
            ->group(base_path('routes/admin.php'));
    }
}
