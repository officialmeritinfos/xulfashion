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
use App\Models\UserAdReview;
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
            'ads'           =>($hasCountry==1)?UserAd::where(['status'=>1, 'country'=>$country->iso2])->with('service')
                ->inRandomOrder()->take(30)->get():UserAd::where(['status'=>1])->with('service')
                ->inRandomOrder()->take(30)->get(),
            'recentAds'     =>($hasCountry==1)?UserAd::where(['status'=>1, 'country'=>$country->iso2])->with('service')
                ->orderBy('id','desc')->take(30)->get():UserAd::where(['status'=>1])->with('service')
                ->orderBy('id','desc')->take(30)->get(),
            'testimonials'  =>Testimonial::where('status',1)->get(),
            'iso3'          =>($hasCountry==1)?$country->iso3:'',
            'user'          =>Auth::user(),
            'bestSelling'   =>($hasCountry==1)?UserAd::where(['status'=>1, 'country'=>$country->iso2])
                ->orderByDesc('numberOfViews')->first():UserAd::where(['status'=>1])
                ->orderBy('numberOfViews','desc')->first()
        ]);
    }
    //ad details
    public function adDetails(Request $request,$slug, $id)
    {
        $web = GeneralSetting::find(1);

        // Check if the user has a country session and, if not, return to the main page to choose a country
        if (!$request->session()->has('country')) {
            return to_route('mobile.marketplace.index');
        }

        $country = $request->session()->get('country');

        // Fetch the ad with its service details
        $ads = UserAd::where([
            'reference' => $id,
            'status' => 1
        ])->with('service')->firstOrFail();

        // Check if the user has viewed the ad (track by user ID or IP address)
        $hasViewed = \auth()->check() ?
            UserAdView::where(['user' => \auth()->user()->id, 'ad' => $ads->reference])->first() :
            UserAdView::where(['ipAddress' => $request->ip(), 'ad' => $ads->reference])->first();

        // Update view count if the ad has not been viewed by the user
        if (empty($hasViewed)) {
            $ads->increment('numberOfViews');
            UserAdView::create([
                'ipAddress' => $request->ip(),
                'user' => \auth()->user()->id ?? null,
                'browser' => (new Agent())->browser(),
                'ad' => $ads->reference
            ]);
        }

        // Fetch the merchant and their store
        $merchant = User::find($ads->user);
        $store = UserStore::where('user', $merchant->id)->first();

        // Get tags array
        $tagsArray = explode(',', $ads->tags);

        // Fetch related ads by the same merchant or by tags and service type
        $relatedAds = UserAd::where('user', $merchant->id)
            ->where('status', 1)
            ->where('id', '!=', $ads->id)
            ->with('service')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        if ($relatedAds->isEmpty()) {
            $relatedAds = UserAd::where('id', '!=', $ads->id)
                ->where('serviceType', $ads->serviceType)
                ->where('status', 1)
                ->where(function($query) use ($tagsArray) {
                    foreach ($tagsArray as $tag) {
                        $query->orWhereRaw('FIND_IN_SET(?, tags)', [$tag]);
                    }
                })
                ->with('service')
                ->paginate(10);
        }

        // Calculate ratings and reviews data
        $totalRating = UserAdReview::where('merchant', $ads->user)->count();
        $averageRating = UserAdReview::where('merchant', $ads->user)->avg('rating');
        $ratingsCount = UserAdReview::where('merchant', $ads->user)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Ensure that each star rating (1-5) has a value even if 0
        $ratingsCount = array_replace([5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0], $ratingsCount);

        $reviews = UserAdReview::where('merchant', $ads->user)->with([
            'reviewers','merchants','responses.users'
        ])->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.ads.components.review_lists', compact('reviews'))->render(),
                'nextPage' => $reviews->currentPage() + 1,
                'hasMorePages' => $reviews->hasMorePages()
            ]);
        }

        return view('mobile.ads.ad_details')->with([
            'web'           => $web,
            'siteName'      => $web->name,
            'pageName'      => $ads->title,
            'serviceTypes'  => ServiceType::where('status', 1)->get(),
            'country'       => Country::where('iso2', $country)->first(),
            'hasCountry'    => 1,
            'ad'            => $ads,
            'ads'           => $relatedAds,
            'store'         => $store,
            'photos'        => UserAdPhoto::where('ad', $ads->id)->get(),
            'iso3'          => $request->session()->get('iso3'),
            'merchant'      => $merchant,
            'user'          => Auth::user(),
            'averageRating' => $averageRating,
            'totalRatings'  => $totalRating,
            'totalReviews'  => $totalRating,
            'ratingsCount'  => $ratingsCount,
            'reviews'       => $reviews,
        ]);
    }
    //ad merchant
    public function merchantDetail(Request $request, $id)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('mobile.marketplace.index');
        }
        $country = $request->session()->get('country');

        $user = User::where('reference',$id)->firstOrFail();

        $ads = UserAd::where([
            'country'=>$country,
            'status'=>1,'user'=>$user->id
        ])->with('service')->orderBy('id','desc')->paginate(30);

        // Calculate ratings and reviews data
        $totalRating = UserAdReview::where('merchant', $user->id)->count();
        $averageRating = UserAdReview::where('merchant', $user->id)->avg('rating');
        $ratingsCount = UserAdReview::where('merchant', $user->id)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Ensure that each star rating (1-5) has a value even if 0
        $ratingsCount = array_replace([5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0], $ratingsCount);

        $reviews = UserAdReview::where('merchant', $user->id)->with([
            'reviewers','merchants','responses.users'
        ])->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.ads.components.review_lists', compact('reviews'))->render(),
                'nextPage' => $reviews->currentPage() + 1,
                'hasMorePages' => $reviews->hasMorePages()
            ]);
        }


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
            'averageRating' => $averageRating,
            'totalRatings'  => $totalRating,
            'totalReviews'  => $totalRating,
            'ratingsCount'  => $ratingsCount,
            'reviews'       => $reviews,
        ]);
    }
    //ad by state
    public function adsByState(Request $request,$state)
    {
        $web = GeneralSetting::find(1);
        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('mobile.marketplace.index');
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
            return to_route('mobile.marketplace.index');
        }
        $country = $request->session()->get('country');
        $service = ServiceType::where('id',$id)->firstOrFail();

        $ads = UserAd::where([
            'country'=>$country,
            'status'=>1,'serviceType'=>$service->id
        ])->with('service')->latest()->paginate(30);

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
        $state = $request->input('state');
        $serviceType = $request->input('category');
        $country = Session::get('country');
        if (!$country){
            return to_route('mobile.marketplace.index');
        }
        $ads = UserAd::where([
            'country'=>$country,'status' => 1
        ])->when($request->filled('state'),function ($fetch) use($state){
            $fetch->where('state', $state);
        })->when($request->filled('category'),function ($fetch) use($serviceType){
            $fetch->where('serviceType', $serviceType);
        })->with('service')->inRandomOrder()->paginate(30);

        //fetch similar ads not in the searched category/state
        $otherAds = UserAd::where([
            'country'=>$country,
            'status'=>1
        ])->when($request->filled('state'),function ($q) use($state){
            $q->whereNot('state',$state);
        })->when($request->filled('category'),function ($q) use($serviceType){
            $q->whereNot('serviceType',$serviceType);
        })->with('service')->latest()->paginate(14);

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
            return to_route('mobile.marketplace.index');
        }
        $country = $request->session()->get('country');

        $country = Country::where('iso2',$country)->first();

        return view('mobile.ads.categories')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>"Categories",
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry=1,
            'iso3'          =>$request->session()->get('iso3'),
            'states'        =>State::where('country_code',$country)->orderBy('name','asc')->get(),
            'user'          =>Auth::user(),
            'categories'    =>ServiceType::where('status',1)->get(),
        ]);
    }
}
