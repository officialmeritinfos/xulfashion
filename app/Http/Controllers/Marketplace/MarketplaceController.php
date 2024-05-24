<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\UserAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketplaceController extends BaseController
{
    //landing page
    public function landingPage($country=null)
    {
        $web = GeneralSetting::find(1);
        if ($country==null){
            $hasCountry=2;
            $country = Country::where('status',1)->get();
        }else{
            $hasCountry=1;
            $country = Country::where('iso3',strtoupper($country))->first();
        }

        return view('marketplace.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Find the Best Tailors, Fashion Designers in your area',
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry,
            'states'        =>($hasCountry==1)?State::where('country_code',$country->iso2)->orderBy('name','asc')->get():'',
            'ads'           =>($hasCountry==1)?UserAd::where(['status'=>1, 'country'=>$country->iso2])
                ->inRandomOrder()->take(30)->get():UserAd::where(['status'=>1])
                ->inRandomOrder()->take(30)->get(),
            'recentAds'     =>($hasCountry==1)?UserAd::where(['status'=>1, 'country'=>$country->iso2])
                ->orderBy('id','desc')->take(30)->get():UserAd::where(['status'=>1])
                ->orderBy('id','desc')->take(30)->get()
        ]);
    }
}
