<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web','auth','role:SOLICITANTE')
            ->prefix('solicitante')
            ->group(base_path('routes/requester.php'));

            Route::middleware('web','auth','role:LOGISTICA')
            ->prefix('logistica')
            ->group(base_path('routes/logistic.php'));

            Route::middleware('web','auth','role:TESORERO')
            ->prefix('tesorero')
            ->group(base_path('routes/treasurer.php'));

            Route::middleware('web','auth','role:ALMACEN')
            ->prefix('almacen')
            ->group(base_path('routes/storekeeper.php'));

            Route::middleware('web','auth','role:GERENTE')
            ->prefix('gerente')
            ->group(base_path('routes/executive.php'));
        });
    }
}
