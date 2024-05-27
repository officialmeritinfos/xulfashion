<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\UserStore;
use Illuminate\Http\Request;

class PageController extends BaseController
{
    //faq
    public function faq(Request $request)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('marketplace.index');
        }
        $countryIso2 = $request->session()->get('country');

        $country = Country::where('iso2',$countryIso2)->first();

        return view('marketplace.faq')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Frequently Asked Questions",
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>1,
            'iso3'          =>$request->session()->get('iso3'),
        ]);
    }
    //privacy policy
    public function privacy(Request $request)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('marketplace.index');
        }
        $countryIso2 = $request->session()->get('country');

        $country = Country::where('iso2',$countryIso2)->first();

        return view('marketplace.privacy')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Privacy Policy",
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>1,
            'iso3'          =>$request->session()->get('iso3'),
        ]);
    }
    //terms of operation
    public function terms(Request $request)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('marketplace.index');
        }
        $countryIso2 = $request->session()->get('country');

        $country = Country::where('iso2',$countryIso2)->first();

        return view('marketplace.terms')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Terms of Service",
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>1,
            'iso3'          =>$request->session()->get('iso3'),
        ]);
    }
    //anti-money laundering
    public function aml(Request $request)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('marketplace.index');
        }
        $countryIso2 = $request->session()->get('country');

        $country = Country::where('iso2',$countryIso2)->first();

        return view('marketplace.aml')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Anti-money laundering",
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>1,
            'iso3'          =>$request->session()->get('iso3'),
        ]);
    }
    //about
    public function about(Request $request)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('marketplace.index');
        }
        $countryIso2 = $request->session()->get('country');

        $country = Country::where('iso2',$countryIso2)->first();

        return view('marketplace.about')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Company Overview",
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>1,
            'iso3'          =>$request->session()->get('iso3'),
        ]);
    }
}
