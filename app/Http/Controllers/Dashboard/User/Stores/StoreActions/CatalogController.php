<?php

namespace App\Http\Controllers\Dashboard\User\Stores\StoreActions;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreProduct;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogController extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.catalog.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Catalog',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
        ]);
    }
    //products
    public function products()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.catalog.products.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Products',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'products'      =>UserStoreProduct::where('store',$store->id)->paginate(15)
        ]);
    }
    //new products
    public function newProducts()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.catalog.products.new')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Add New Store Products',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
        ]);
    }
}
