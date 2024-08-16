<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class Home extends Controller
{
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);
        return view('mobile.home')->with([
            'web'       =>$web,
            'pageName'  =>"Welcome to ".$web->name,
            'siteName'  =>$web->name
        ]);
    }

    public function base()
    {
        $web = GeneralSetting::find(1);
        return view('mobile.home_base')->with([
            'web'       =>$web,
            'pageName'  =>"Sign-in & Sign-up for ".$web->name.' Account',
            'siteName'  =>$web->name
        ]);
    }
}
