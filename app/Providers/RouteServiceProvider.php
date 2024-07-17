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
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        parent::boot();

        Route::pattern('subdomain', '[a-z0-9_\-]+');
        $this->configureRateLimiting();


        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            $this->authRoute();
            $this->staffRoute();
            $this->subdomainRoute();
            $this->adsRoute();
            $this->userRoute();
            $this->homeRoute();
        });
    }
    //auth route
    public function authRoute()
    {
        Route::middleware('web')
            ->prefix('auth')
            ->group(base_path('routes/auth.php'));
    }
    //subdomain route
    public function subdomainRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/subdomain.php'));
    }
    //ads route
    public function adsRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/ads.php'));
    }
    //user dashboard route
    public function userRoute()
    {
        Route::middleware(['web','auth','lockedOut','twoFactor'])
            ->prefix('me')
            ->name('user.')
            ->group(base_path('routes/user.php'));
    }
    //staff dashboard route
    public function staffRoute()
    {
        Route::middleware(['web'])
            ->name('staff.')
            ->group(base_path('routes/staff.php'));
    }
    //landing page
    public function homeRoute()
    {
        Route::middleware(['web'])
            ->name('home.')
            ->group(base_path('routes/home.php'));
    }
    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('token-resend',function(Request $request){
            return Limit::perMinute(2)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
