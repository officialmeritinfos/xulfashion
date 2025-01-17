<?php

namespace App\Http\Controllers\Mobile\User\Store;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreKYBController extends Controller
{
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $store = UserStore::where('user',$user->id)->first();
        if (!$store) {
            return back()->with('error','Business account not found. Please create a store to proceed.');
        }

        return view('mobile.users.store.kyb')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Business Verification',
            'store' => $store
        ]);
    }
}
