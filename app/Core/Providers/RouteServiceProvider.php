<?php

namespace App\Core\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Auto register domain routes.
     * @var array
     */
    protected $domains = [
        'Artist',
        'Auth',
        'Song',
        'Album',
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });

        $this->mapDomainRoutes();
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }


    protected function mapDomainRoutes()
    {
        $routeApi = Route::prefix('api')->middleware('api');
        $routeWeb = Route::middleware('web');

        foreach ($this->domains as $domain) {
            $domainRouteApi = app_path('Domain/' . $domain . '/Routes/api.php');
            $domainRouteWeb = app_path('Domain/' . $domain . '/Routes/web.php');

            if (file_exists($domainRouteApi)) {
                $routeApi->group($domainRouteApi);
            }

            if(file_exists($domainRouteWeb)) {
                $routeWeb->group($domainRouteWeb);
            }
        }
    }
}
