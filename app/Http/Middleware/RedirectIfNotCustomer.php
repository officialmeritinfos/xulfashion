<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$guard = 'customers'): Response
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('merchant.store.login', ['subdomain' => $request->route('subdomain')])->with('error','You must login first before accessing this page');
        }

        return $next($request);
    }
}
