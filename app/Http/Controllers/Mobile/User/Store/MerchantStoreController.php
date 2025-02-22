<?php

namespace App\Http\Controllers\Mobile\User\Store;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantStoreController extends Base
{
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $store = UserStore::where('user',$user->id)->first();

        return view('mobile.users.store.index')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' => $store->name ?? 'New storefront',
            'store' => $store,
        ]);
    }
    //initialize store
    public function initializeStore()
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $store = UserStore::where('user',$user->id)->first();
        if ($store) {
            return back()->with('error','Store already created. Edit instead.');
        }

        return view('mobile.users.store.initialize')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Create Store',
        ]);
    }
    //initialize store
    public function editStore()
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $store = UserStore::where('user',$user->id)->first();
        if (!$store) {
            return back()->with('error','Store not found. Please create one');
        }

        return view('mobile.users.store.edit')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Edit Store',
            'store' => $store,
        ]);
    }
}
