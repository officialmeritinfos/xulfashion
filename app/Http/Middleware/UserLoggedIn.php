<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\Response;

class UserLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $agent = new Agent();
        $user = Auth::user();

        if ($user->loggedIn!=1){
            Auth::logout();
            $request->session()->regenerate();

            if ($agent->isMobile()){
                return to_route('login')->with('error','Two-factor Authentication Required');
            }else{
                return to_route('mobile.login')->with('error','Two-factor Authentication Required');
            }
        }

        return $next($request);
    }
}
