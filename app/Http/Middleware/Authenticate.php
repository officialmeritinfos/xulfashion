<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $agent = new Agent();

        $route = ($agent->isMobile())?route('mobile.login'):route('mobile.login');

        return $request->expectsJson() ? null : $route;
    }
}
