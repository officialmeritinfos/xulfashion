<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\UserAd;
use App\Models\UserAdView;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreProduct;
use App\Models\UserStoresView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

class StoreController extends BaseController
{
    //landing page
    public function landingPage(Request $request)
    {
        if (\auth()->check()) {
            $hasCountry=1;
            $country = Country::where('iso3',strtoupper(\auth()->user()->countryCode))->first();
            Session::put([
                'country'=>$country->iso2,
                'iso3'  =>$country->iso3
            ]);
        }else{
            if (!Cookie::has('hasAdsCountry')){
                $position = (config('location.testing.enabled'))?Location::get():Location::get($request->ip());
                $country = Country::where('iso2',$position->countryCode)->first();
                Cookie::queue('hasAdsCountry',$country->iso3,7 * 24 * 60 * 60);
                $countryIso = $country->iso3;
            }else{
                $countryIso = Cookie::get('hasAdsCountry');
            }
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
        }

        $web = GeneralSetting::find(1);

        $pageName = 'Beauty & Fashion Businesses';
        if ($hasCountry==1){
            $pageName = 'Beauty & Fashion Businesses in '.$country->name;
        }

        $stores = UserStore::where('country',$country->iso2)->where('status',1)->latest()->paginate(30);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.ads.layout.store_listing', compact('stores','country'))->render(),
                'nextPage' => $stores->currentPage() + 1,
                'hasMorePages' => $stores->hasMorePages()
            ]);
        }

        return view('mobile.ads.store_list')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$pageName,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'hasCountry'    =>$hasCountry,
            'states'        =>($hasCountry==1)?State::where('country_code',$country->iso2)->orderBy('name','asc')->get():'',
            'stores'        =>$stores
        ]);
    }

    public function searchSuggestion(Request $request)
    {
        if (!\auth()->check()) {
            $countryIso = Cookie::get('hasAdsCountry');
            $country = Country::where('iso3', strtoupper($countryIso))->first();
        }else{
            $countryIso = \auth()->user()->countryCode;
            $country = Country::where('iso3', strtoupper($countryIso))->first();
        }
        $query = $request->input('query');
        $state = $request->input('state');
        $countryIso2 = $country->iso2;

        // Search stores based on the user query
        $stores = UserStore::where('country', $countryIso2)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")
                    ->orWhere('description', 'LIKE', "%$query%")
                    ->orWhere('city', 'LIKE', "%$query%")
                    ->orWhere('address', 'LIKE', "%$query%");
            })
            ->when($state, function($q) use ($state) {
                $q->where('state', $state);
            })
            ->with(['serviceType', 'state' => function($q) use ($countryIso2) {
                $q->where('country_code', $countryIso2);
            }])
            ->get();

        // Prepare the results array
        $results = [];

        // Add stores to the results
        foreach ($stores as $store) {
            $stateM = State::where([
                'iso2' => $store->state,
                'country_code' => $countryIso2
            ])->first();

            $results[] = [
                'search' => $store->name,
                'category' => $store->serviceType->name ?? 'N/A',
                'location' => $store->city ?? 'N/A',
                'state' => $store->state->iso2 ?? 'N/A',
                'stateName' =>$stateM->name ,
                'url' => route('mobile.marketplace.store.detail', ['id' => $store->reference])
            ];
        }

        // Add service types as suggestions to the results
        $serviceTypes = ServiceType::get();
        foreach ($serviceTypes as $serviceType) {
            if (!empty($state)){
                $states = State::where([
                    'iso2' => $state,'country_code' => $countryIso2
                ])->first();

                $statement = $states->name;
            }else{
                $statement = 'All of ' . $country->name;
            }
            $results[] = [
                'search' => ucfirst($query),
                'category' => $serviceType->name,
                'location' => 'N/A',
                'state' => 'N/A',
                'stateName' => $statement,
                'url' => route('mobile.marketplace.store.category.search', ['category' => $serviceType->id,'location'=>$state,'search'=>$query])
            ];
        }

        return response()->json($results);
    }

    public function storeDetail(Request $request,$id)
    {
        $web = GeneralSetting::find(1);

        //check if the user has a country session and if not, return them back to the main page to choose a country
        if (!$request->session()->has('country')){
            return to_route('mobile.marketplace.index');
        }
        $country = $request->session()->get('country');

        $store = UserStore::where([
            'reference' => $id,'status' => 1
        ])->firstOrFail();

        //if user is logged in
        if (\auth()->check()){
            $hasViewed = UserStoresView::where([
                'user'=>\auth()->user()->id,
                'store'=>$store->reference
            ])->first();
        }else{
            $hasViewed = UserStoresView::where([
                'ipAddress'=>$request->ip(),
                'store'=>$store->reference
            ])->first();
        }
        $agent = new Agent();

        //update view
        if (empty($hasViewed)){
            $store->numberOfViews = $store->numberOfViews+1;
            $store->save();
            $store->refresh();

            UserStoresView::create([
                'ipAddress'=>$request->ip(),
                'user'=>\auth()->user()->id??'',
                'browser'=>$agent->browser(),
                'store'=>$store->reference
            ]);
        }

        $user = User::where('id',$store->user)->first();

        $ads = UserAd::where([
            'status'=>1,'user'=>$user->id
        ])->with('service')->orderBy('id','desc')->paginate(30);

        $storeUrl = route('mobile.marketplace.store.detail',['id'=>$store->reference]);

        // Generate raw share links
        $shareLinks = \Share::page($storeUrl,"{$store->name} on {$web->name} ")
            ->facebook()
            ->twitter()
            ->whatsapp()
            ->getRawLinks();

        return view('mobile.ads.store_detail')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$store->legalName??$store->name,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'catalogs'      =>UserStoreCatalogCategory::where([
                'status' => 1,'store' => $store->id
            ])->get(),
            'store'         =>$store,
            'ads'           =>$ads,
            'country'       =>Country::where('iso2',$country)->first(),
            'shareLinks'    =>$shareLinks,
            'title'         =>$store->name,
            'author'        =>$user->displayName??$user->name,
            'description'   =>$store->name." Catalogues,and listings on ".$web->name,
            'image'         => $store->logo
        ]);
    }

    public function categorySearchResult(Request $request)
    {
        $web = GeneralSetting::find(1);
        $countryIso = Cookie::get('hasAdsCountry');

        $country = Country::where('iso3', strtoupper($countryIso))->first();
        $category = $request->input('category');
        $query = $request->input('search');
        $state = $request->input('location');
        $countryIso2 = $country->iso2;

        $category = ServiceType::where('id',$category)->firstOrFail();
        //find stores in the category and in the location
        $stores = UserStore::where([
            'country' => $countryIso2,'service' => $category->id
        ])->when($query,function($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")
                    ->orWhere('description', 'LIKE', "%$query%")
                    ->orWhere('city', 'LIKE', "%$query%")
                    ->orWhere('address', 'LIKE', "%$query%");
        })->when($state,function ($q) use ($state){
            $q->where('state',$state);
        })->paginate(30);

        if(!empty($state)){
            $state = State::where([
                'iso2' => $state,'country_code' => $countryIso2
            ])->first();

            $pageName = ucfirst($query)." in ".$category->name.' in '.$state->name;
        }else{
            $pageName = ucfirst($query)." in ".$category->name.' in '.$country->name;
        }

        return view('mobile.ads.store_search_result')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$pageName,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'stores'        =>$stores,
            'others'        =>UserStore::where([
                'country' => $countryIso2,'status' => 1
            ])->take(10)->get()
        ]);
    }

    public function searchResult(Request $request)
    {
        $web = GeneralSetting::find(1);
        $countryIso = Cookie::get('hasAdsCountry');
        $country = Country::where('iso3', strtoupper($countryIso))->first();
        $query = $request->input('search');
        $state = $request->input('state');
        $countryIso2 = $country->iso2;

        // Search stores based on the user query
        $stores = UserStore::where('country', $countryIso2)
            ->when($query,function($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")
                    ->orWhere('description', 'LIKE', "%$query%")
                    ->orWhere('city', 'LIKE', "%$query%")
                    ->orWhere('address', 'LIKE', "%$query%");
            })
            ->when($state, function($q) use ($state) {
                $q->where('state', $state);
            })
            ->with(['serviceType', 'state' => function($q) use ($countryIso2) {
                $q->where('country_code', $countryIso2);
            }])
            ->paginate(30);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.ads.layout.store_listing', compact('stores','country'))->render(),
                'nextPage' => $stores->currentPage() + 1,
                'hasMorePages' => $stores->hasMorePages()
            ]);
        }

        if (!empty($state)){
            $states = State::where([
                'iso2' => $state,'country_code' => $countryIso2
            ])->first();

            $statement = $states->name;
        }else{
            $statement = $country->name;
        }

        $pageText = empty($query)?'Fashion & Beauty Stores ':$query;

        $pageName = $pageText.' in '.$statement;

        return view('mobile.ads.store_search_result')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$pageName,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'country'       =>$country,
            'stores'        =>$stores,
            'others'        =>UserStore::where([
                'country' => $countryIso2,'status' => 1
            ])->take(10)->get()
        ]);
    }
}
