<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Jenssegers\Agent\Agent;

class Home extends Controller
{
    //landing page
    public function landingPage()
    {
        if (Cache::has('base')){
            return redirect()->to(route('mobile.base'));
        }

        $web = GeneralSetting::find(1);
        return view('mobile.home')->with([
            'web'       =>$web,
            'pageName'  =>"Welcome to ".$web->name,
            'siteName'  =>$web->name
        ]);
    }

    public function base()
    {
        //check if a cache had been stored
        Cache::put('base','yes',now()->addDays(7));

        //check if it is mobile
        $agent = new Agent();
        $web = GeneralSetting::find(1);

        return view('mobile.home_base')->with([
            'web'       =>$web,
            'pageName'  =>"Sign-in & Sign-up for ".$web->name.' Account',
            'siteName'  =>$web->name
        ]);
    }
}
