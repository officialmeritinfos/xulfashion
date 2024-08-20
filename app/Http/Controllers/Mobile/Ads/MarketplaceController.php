<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\Testimonial;
use App\Models\UserAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MarketplaceController extends BaseController
{
    //landing Page
    public function landingPage($countryIso=null)
    {
        $web = GeneralSetting::find(1);
        if ($countryIso==null){
            $hasCountry=2;
            $country = Country::where('status',1)->get();
        }else{
            $hasCountry=1;
            $country = Country::where('iso3',strtoupper($countryIso))->first();
            //let us store the country variable
            Session::put([
                'country'=>$country->iso2,
                'iso3'  =>$country->iso3
            ]);
        }

        $pageName = 'Find the Best Tailors, Fashion Designers, Models & Fashion Stores in your area';
        if ($hasCountry==1){
            $pageName = 'Find the Best Tailors, Fashion Designers, Models & Fashion Stores in '.$country->name;
        }

        return view('mobile.ads.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$pageName,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry,
            'states'        =>($hasCountry==1)?State::where('country_code',$country->iso2)->orderBy('name','asc')->get():'',
            'ads'           =>($hasCountry==1)?UserAd::where(['status'=>1, 'country'=>$country->iso2])
                ->inRandomOrder()->take(30)->get():UserAd::where(['status'=>1])
                ->inRandomOrder()->take(30)->get(),
            'recentAds'     =>($hasCountry==1)?UserAd::where(['status'=>1, 'country'=>$country->iso2])
                ->orderBy('id','desc')->take(30)->get():UserAd::where(['status'=>1])
                ->orderBy('id','desc')->take(30)->get(),
            'testimonials'  =>Testimonial::where('status',1)->get(),
            'iso3'          =>($hasCountry==1)?$country->iso3:'',
            'user'          =>Auth::user()
        ]);
    }
}
