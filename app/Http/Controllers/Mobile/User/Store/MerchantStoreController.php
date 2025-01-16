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

        return view('mobile.users.store.index')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Your Stores',
            'store' => UserStore::where('user',$user->id)->first(),
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
}
