<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;

class EventController extends BaseController
{
    //landing page
    public function landingPage(Request $request)
    {
        if (!Cache::has('hasAdsCountry')){
            $position = (config('location.testing.enabled'))?Location::get():Location::get($request->ip());
            $country = Country::where('iso2',$position->countryCode)->first();
            Cache::put('hasAdsCountry',$country->iso3,now()->addDays(7));
            $countryIso = $country->iso3;
        }else{
            $countryIso = Cache::get('hasAdsCountry');
        }

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

        $pageName = 'Fashion events';
        if ($hasCountry==1){
            $pageName = 'Fashion Events in '.$country->name;
        }

        $countries = Country::where('status',1)->get();

        $stores = UserEvent::where('country',$country->iso2)->where('status',1)->latest()->paginate(30);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.ads.layout.store_listing', compact('stores','country','countries'))->render(),
                'nextPage' => $stores->currentPage() + 1,
                'hasMorePages' => $stores->hasMorePages()
            ]);
        }

    }
    //event detail
    public function eventDetail(Request $request, $eventId)
    {

    }
}
