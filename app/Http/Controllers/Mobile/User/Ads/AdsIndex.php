<?php

namespace App\Http\Controllers\Mobile\User\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdsIndex extends BaseController
{
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.ads.index')->with([
            'pageName'  =>'Landing Page',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }
}
