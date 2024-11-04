<?php

namespace App\Providers;

use App\Services\Payments\FlutterwaveGateway;
use App\Services\Payments\PaystackGateway;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('paystack', function ($app) {
            return new PaystackGateway();
        });

        $this->app->singleton('flutterwave', function ($app) {
            return new FlutterwaveGateway();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
