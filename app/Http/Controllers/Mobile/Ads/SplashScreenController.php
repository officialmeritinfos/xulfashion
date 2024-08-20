<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Stevebauman\Location\Facades\Location;

class SplashScreenController extends Controller
{
    //splash screen
    public function landingPage(Request $request)
    {
        if (Cache::has('hasAdsCountry')){
            return redirect()->to(route('mobile.marketplace.index',['country'=>Cache::get('hasAdsCountry')]));
        }else{
            $position = (config('location.testing.enabled'))?Location::get():Location::get($request->ip());
            $country = Country::where('iso2',$position->countryCode)->first();
            Cache::put('hasAdsCountry',$country->iso3,now()->addDays(7));
        }

        $web = GeneralSetting::find(1);
        return view('mobile.ads.splash_screen')->with([
            'web'       =>$web,
            'pageName'  =>"Welcome to ".$web->name,
            'siteName'  =>$web->name,
            'country'   =>$country
        ]);
    }
}
