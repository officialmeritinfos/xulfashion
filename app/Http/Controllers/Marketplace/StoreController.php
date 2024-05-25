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

class StoreController extends BaseController
{
    //landing page
    public function landingPage(Request $request)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('marketplace.index');
        }
        $countryIso2 = $request->session()->get('country');

        $country = Country::where('iso2',$countryIso2)->first();

        return view('marketplace.stores')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Fashion Stores in ".$country->name,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>1,
            'iso3'          =>$request->session()->get('iso3'),
            'states'        =>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
            'stores'        =>UserStore::where('status',1)->inRandomOrder()->paginate(30)
        ]);
    }
    //filter stores
    public function filterStores(Request $request)
    {

    }
}
