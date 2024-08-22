<?php

namespace App\Http\Controllers\Mobile\Ads;

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
use App\Models\UserAdView;
use App\Models\UserStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

class MarketplaceController extends BaseController
{
    //landing Page
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
            'user'          =>Auth::user(),
            'bestSelling'   =>($hasCountry==1)?UserAd::where(['status'=>1, 'country'=>$country->iso2])
                ->orderBy('numberOfViews','desc')->first():UserAd::where(['status'=>1])
                ->orderBy('numberOfViews','desc')->first()
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
        //if user is logged in
        if (\auth()->check()){
            $hasViewed = UserAdView::where([
                'user'=>\auth()->user()->id,
                'ad'=>$ads->reference
            ])->first();
        }else{
            $hasViewed = UserAdView::where([
                'ipAddress'=>$request->ip(),
                'ad'=>$ads->reference
            ])->first();
        }
        $agent = new Agent();

        //update view
        if (empty($hasViewed)){
            $ads->numberOfViews = $ads->numberOfViews+1;
            $ads->save();
            $ads->refresh();

            UserAdView::create([
                'ipAddress'=>$request->ip(),
                'user'=>\auth()->user()->id??'',
                'browser'=>$agent->browser(),
                'ad'=>$ads->reference
            ]);
        }

        $merchant = User::where('id',$ads->user)->first();
        $store = UserStore::where('user',$merchant->id)->first();

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

        return view('mobile.ads.ad_details')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$ads->title,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>Country::where('iso2',$country)->first(),
            'hasCountry'    =>$hasCountry=1,
            'ad'            =>$ads,
            'ads'           =>$relatedAds,
            'store'         =>$store,
            'photos'        =>UserAdPhoto::where('ad',$ads->id)->get(),
            'iso3'          =>$request->session()->get('iso3'),
            'merchant'      =>$merchant,
            'user'          =>Auth::user(),
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

        return view('mobile.ads.merchant_detail')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Listings By ".$user->displayName??$user->name,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>Country::where('iso2',$country)->first(),
            'hasCountry'    =>$hasCountry=1,
            'ads'           =>$ads,
            'iso3'          =>$request->session()->get('iso3'),
            'store'         =>UserStore::where('user',$user->id)->first(),
            'merchant'      =>$user,
            'user'          =>Auth::user(),
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


        return view('mobile.ads.ads_state')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Fashion Designers In ".$state->name,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>Country::where('iso2',$country)->first(),
            'hasCountry'    =>$hasCountry=1,
            'ads'           =>$ads,
            'iso3'          =>$request->session()->get('iso3'),
            'states'        =>State::where('country_code',$country)->orderBy('name','asc')->get(),
            'user'          =>Auth::user(),
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
        ])->latest()->paginate(30);

        $country = Country::where('iso2',$country)->first();

        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.ads.layout.ads_listing', compact('ads','country'))->render(),
                'nextPage' => $ads->currentPage() + 1,
                'hasMorePages' => $ads->hasMorePages()
            ]);
        }


        return view('mobile.ads.ads_service')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Fashion Designers In ".$service->name,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry=1,
            'ads'           =>$ads,
            'iso3'          =>$request->session()->get('iso3'),
            'states'        =>State::where('country_code',$country)->orderBy('name','asc')->get(),
            'user'          =>Auth::user(),
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

        if ($request->filled('category')) {
            $query->where('serviceType', $request->input('category'));
        }

        $ads = $query->inRandomOrder()->paginate(1);
        $otherAds = UserAd::where('country',$country)->where('status',1)->latest()->paginate(9);

        $country = Country::where('iso2',$country)->first();

        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.ads.layout.ads_listing', compact('ads','country'))->render(),
                'nextPage' => $ads->currentPage() + 1,
                'hasMorePages' => $ads->hasMorePages()
            ]);
        }


        $web = GeneralSetting::find(1);

        $params = $request->input();

        return view('mobile.ads.ads_search_result')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Search Results",
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry=1,
            'ads'           =>$ads,
            'iso3'          =>Session::get('iso3'),
            'states'        =>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
            'params'        =>$params,
            'others'        =>$otherAds,
            'user'          =>Auth::user(),
        ]);
    }

    //ad by service
    public function categories(Request $request)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('marketplace.index');
        }
        $country = $request->session()->get('country');

        $ads = UserAd::where([
            'country'=>$country,
            'status'=>1
        ])->groupBy('serviceType')->get();

        $country = Country::where('iso2',$country)->first();

        return view('mobile.ads.categories')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Categories",
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry=1,
            'ads'           =>$ads,
            'iso3'          =>$request->session()->get('iso3'),
            'states'        =>State::where('country_code',$country)->orderBy('name','asc')->get(),
            'user'          =>Auth::user(),
        ]);
    }
}
