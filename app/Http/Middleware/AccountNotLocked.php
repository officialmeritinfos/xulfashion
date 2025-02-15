<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\Response;

class AccountNotLocked
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

        if ($user->status==3){
            Auth::logout();
            $request->session()->regenerate();
            if ($agent->isMobile()){
                return to_route('login')->with('error','Account is locked');
            }else{
                return to_route('mobile.login')->with('error','Account is locked');
            }
        }

        return $next($request);
    }
}
