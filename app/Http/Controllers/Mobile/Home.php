<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserDevice;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Jenssegers\Agent\Agent;

class Home extends Controller
{
    //landing page
    public function landingPage()
    {
        if (Cookie::has('base')){
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
        //check if a cookie had been stored
        Cookie::queue('base','yes',7 * 24 * 60 * 60);

        //check if it is mobile
        $agent = new Agent();
        $web = GeneralSetting::find(1);

        return view('mobile.home_base')->with([
            'web'       =>$web,
            'pageName'  =>"Sign-in & Sign-up for ".$web->name.' Account',
            'siteName'  =>$web->name
        ]);
    }

    //Register token into database
    public function registerToken(Request $request)
    {
        try{
            UserDevice::updateOrCreate([
                'user'=>$request->user()->id,
                'token'=>$request->token
            ]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    public function push(){
        $user=Auth::user();
        sendPushNotification($user,'Welcome to Xulfashion','We are glad you joined us');
    }
}
