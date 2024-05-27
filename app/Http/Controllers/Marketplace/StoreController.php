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
use Illuminate\Support\Facades\Session;

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
        $country = Session::get('country');
        if (!$country){
            return to_route('marketplace.index');
        }
        $query = UserStore::query();

        $query->where('country',$country);

        if ($request->filled('state')) {
            $query->where('state', $request->input('state'));
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->input('city') . '%');
        }

        if ($request->filled('serviceType')) {
            $query->where('service', $request->input('serviceType'));
        }

        $stores = $query->inRandomOrder()->paginate(30);

        $otherAds = UserStore::where('country',$country)->where('status',1)->inRandomOrder()->paginate(9);

        $web = GeneralSetting::find(1);

        $params = $request->input();

        return view('marketplace.store_search_result')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Search Results",
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry=1,
            'stores'        =>$stores,
            'iso3'          =>Session::get('iso3'),
            'states'        =>State::where('country_code',$country)->orderBy('name','asc')->get(),
            'params'        =>$params,
            'others'        =>$otherAds
        ]);
    }
}
