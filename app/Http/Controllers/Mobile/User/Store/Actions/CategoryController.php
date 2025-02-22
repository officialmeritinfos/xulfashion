<?php

namespace App\Http\Controllers\Mobile\User\Store\Actions;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $store = UserStore::where('user',$user->id)->firstOrFail();

        return view('mobile.users.store.actions.category.index')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' => "{$store->name} Catalog categories",
            'store' => $store,
            'action'=>'list'
        ]);
    }

}
