<?php

namespace App\Http\Middleware;

use App\Models\StoreTheme;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreThemeSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ApplyTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $storeId = $request->route('subdomain');
        $store = UserStore::where('slug', $storeId)->firstOrFail();
        $theme = StoreTheme::where('id',$store->theme)->firstOrFail();
        $setting = UserStoreThemeSetting::where('store',$store->id)->firstOrFail();
        $categories = UserStoreCatalogCategory::where('store',$store->id)->get();


        View::share([
            'theme'=>$theme->location,
            'setting'=>$setting,
            'store'=>$store,
            'categories'=>$categories,
            'subdomain'=>$request->route('subdomain')
        ]);

        return $next($request);
    }
}
