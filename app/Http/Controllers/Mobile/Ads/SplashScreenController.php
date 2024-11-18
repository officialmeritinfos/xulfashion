<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Stevebauman\Location\Facades\Location;

class SplashScreenController extends Controller
{
    //splash screen
    public function landingPage(Request $request)
    {
        if (Cookie::has('hasAdsCountry')){
            return redirect()->to(route('mobile.marketplace.index',['country'=>Cookie::get('hasAdsCountry')]));
        }else{
            $position = (config('location.testing.enabled'))?Location::get():Location::get($request->ip());
            $country = Country::where('iso2',$position->countryCode)->first();
            Cookie::queue('hasAdsCountry',$country->iso3,7 * 24 * 60 * 60);
        }

        $web = GeneralSetting::find(1);
        return view('mobile.ads.splash_screen')->with([
            'web'       =>$web,
            'pageName'  =>"Welcome to ".$web->name,
            'siteName'  =>$web->name,
            'country'   =>$country
        ]);
    }

    //splash screen 2
    public function appStartingPage(Request $request)
    {
        $web = GeneralSetting::find(1);
        return view('mobile.ads.app_starting_page')->with([
            'web'       =>$web,
            'pageName'  =>"Welcome to ".$web->name,
            'siteName'  =>$web->name,
        ]);
    }
}
