<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreCustomerLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check if the customer is loggedIn
        if (session()->has('loggedIn') && session('loggedIn')==1){
            return $next($request);
        }else{
            $subdomain = $request->route('subdomain');
            //redirect to the login page of the store
            return redirect()->to(route('merchant.store.login',['subdomain'=>$subdomain]))->with('error','Access denied; you must login first before proceeding.');
        }
    }
}
