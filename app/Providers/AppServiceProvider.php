<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Blade::directive('timezoneOffset', function ($expression) {
            return "<?php
            \$dateTimeZone = new DateTimeZone($expression);
            \$dateTime = new DateTime('now', \$dateTimeZone);
            \$offset = \$dateTimeZone->getOffset(\$dateTime);
            \$hours = floor(\$offset / 3600);
            \$minutes = floor((\$offset % 3600) / 60);
            \$formattedOffset = 'UTC' . (\$offset >= 0 ? '+' : '') . \$hours . ':' . str_pad(abs(\$minutes), 2, '0', STR_PAD_LEFT);
            echo \$formattedOffset;
        ?>";
        });
    }
}
