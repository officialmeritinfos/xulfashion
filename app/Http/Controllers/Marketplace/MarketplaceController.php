<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterAdsRequest;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\UserAd;
use App\Models\UserAdPhoto;
use App\Models\UserStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
            //let us store the country variable
            Session::put([
                'country'=>$country->iso2,
                'iso3'  =>$country->iso3
            ]);
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
                ->orderBy('id','desc')->take(30)->get(),
            'testimonials'  =>Testimonial::where('status',1)->get(),
            'iso3'          =>($hasCountry==1)?$country->iso3:''
        ]);
    }
    //ad details
    public function adDetails(Request $request,$slug, $id)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('marketplace.index');
        }
        $country = $request->session()->get('country');

        $ads = UserAd::where('reference',$id)->where('status',1)->firstOrFail();
        $ads->numberOfViews = $ads->numberOfViews+1;
        $ads->save();
        $ads->refresh();

        $merchant = User::where('id',$ads->user)->first();
        $store = UserStore::where('id',$merchant->id)->first();

        $tagsArray = explode(',', $ads->tags);

        $relatedAds = UserAd::where([
            'user'=>$merchant->id,'status'=>1
        ])->whereNot('id',$ads->id)->orderBy('id','desc')->take(10)->get();
        if ($relatedAds->count()<1){
            $query = UserAd::whereNot('id',$ads->id)->where(function($query) use ($tagsArray,$ads) {
                    $query->where('serviceType',$ads->serviceType)->where(function ($query) use($tagsArray){
                        foreach ($tagsArray as $tag) {
                            $query->orWhereRaw('FIND_IN_SET(?, tags)', [$tag])->where('status',1);
                        }
                    });
                });
            $relatedAds = $query->get();
        }

        return view('marketplace.ad_details')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$ads->name,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry=1,
            'ad'            =>$ads,
            'ads'           =>$relatedAds,
            'store'         =>$store,
            'photos'        =>UserAdPhoto::where('ad',$ads->id)->get(),
            'iso3'          =>$request->session()->get('iso3'),
            'merchant'      =>$merchant,
        ]);
    }
    //ad merchant
    public function merchantDetail(Request $request, $id)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('marketplace.index');
        }
        $country = $request->session()->get('country');

        $user = User::where('reference',$id)->firstOrFail();

        $ads = UserAd::where([
            'country'=>$country,
            'status'=>1,'user'=>$user->id
        ])->orderBy('id','desc')->paginate(30);

        return view('marketplace.merchant_detail')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Listings By ".$user->displayName,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry=1,
            'ads'           =>$ads,
            'iso3'          =>$request->session()->get('iso3'),
            'store'         =>UserStore::where('user',$user->id)->first(),
            'merchant'      =>$user
        ]);
    }
    //ad by state
    public function adsByState(Request $request,$state)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('marketplace.index');
        }
        $country = $request->session()->get('country');
        $state = State::where('country_code',strtolower($country))->where('iso2',strtoupper($state))->firstOrFail();

        $ads = UserAd::where([
            'state'=>$state->iso2,'country'=>$country,
            'status'=>1
        ])->inRandomOrder()->paginate(30);


        return view('marketplace.ads_state')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Fashion Designers In ".$state->name,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry=1,
            'ads'           =>$ads,
            'iso3'          =>$request->session()->get('iso3'),
            'states'        =>State::where('country_code',$country)->orderBy('name','asc')->get(),
        ]);
    }
    //ad by service
    public function adsByService(Request $request,$id)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('marketplace.index');
        }
        $country = $request->session()->get('country');
        $service = ServiceType::where('id',$id)->firstOrFail();

        $ads = UserAd::where([
            'country'=>$country,
            'status'=>1,'serviceType'=>$service->id
        ])->inRandomOrder()->paginate(30);


        return view('marketplace.ads_service')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Fashion Designers In ".$service->name,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry=1,
            'ads'           =>$ads,
            'iso3'          =>$request->session()->get('iso3'),
            'states'        =>State::where('country_code',$country)->orderBy('name','asc')->get(),
        ]);
    }
    //filter results
    public function filterAds(FilterAdsRequest $request)
    {
        $country = Session::get('country');
        if (!$country){
            return to_route('marketplace.index');
        }
        $query = UserAd::query();

        $query->where('country',$country);

        if ($request->filled('state')) {
            $query->where('state', $request->input('state'));
        }

        if ($request->filled('minPrice')) {
            $query->where('amount', '>=', $request->input('minPrice'));
        }

        if ($request->filled('maxPrice')) {
            $query->where('amount', '<=', $request->input('maxPrice'));
        }

        if ($request->filled('serviceType')) {
            $query->where('serviceType', $request->input('serviceType'));
        }

        $ads = $query->inRandomOrder()->paginate(30);

        $otherAds = UserAd::where('country',$country)->where('status',1)->inRandomOrder()->paginate(9);
        $web = GeneralSetting::find(1);

        $params = $request->input();

        return view('marketplace.ads_search_result')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Search Results",
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry=1,
            'ads'           =>$ads,
            'iso3'          =>Session::get('iso3'),
            'states'        =>State::where('country_code',$country)->orderBy('name','asc')->get(),
            'params'        =>$params,
            'others'        =>$otherAds
        ]);
    }
}
