<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\State;
use App\Models\UserStore;
use App\Models\UserStoreCoupon;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreOrder;
use App\Models\UserStoreOrderBreakdown;
use App\Models\UserStoreProduct;
use App\Models\UserStoreSetting;
use App\Traits\Helpers;
use App\Traits\Themes;
use Illuminate\Http\Request;

class Home extends BaseController
{
    use Helpers,Themes;
    //landing page
    public function landingPage($store)
    {
        $userStore = UserStore::where('slug',$store)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>'Home',
            'sliders'         =>UserStoreProduct::where(['status'=>1,'store'=>$userStore->id])->inRandomOrder()->paginate(5),
            'products'        =>UserStoreProduct::where(['status'=>1,'store'=>$userStore->id])->inRandomOrder()->paginate(30),
            'latests'         =>UserStoreProduct::where(['status'=>1,'store'=>$userStore->id])->orderBy('id','desc')->paginate(30),
            'featureds'       =>UserStoreProduct::where(['status'=>1,'store'=>$userStore->id,'featured'=>1])->orderBy('id','desc')->paginate(10),
            'trendings'       =>UserStoreProduct::where(['status'=>1,'store'=>$userStore->id])->orderBy('numberOfViews','desc')->paginate(30),
            'highlighted'     =>UserStoreProduct::where(['status'=>1,'store'=>$userStore->id,'highlighted'=>1])->first()
        ];
        return view('storefront.'.$themeLocation.'.home')->with($data);
    }
    //fetch states in a country
    public function fetchCountryStates($subdomain,$country)
    {
        $states = State::where('country_code', $country)->orderBy('name', 'asc')->get();
        return response()->json($states);
    }
    //refund policy
    public function refundPolicy($store)
    {
        $userStore = UserStore::where('slug',$store)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>'Refund Policy ',
        ];
        return view('storefront.'.$themeLocation.'.refund')->with($data);
    }
    //return policy
    public function returnPolicy($store)
    {
        $userStore = UserStore::where('slug',$store)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>'Return Policy ',
        ];
        return view('storefront.'.$themeLocation.'.return')->with($data);
    }
    //contact page
    public function contactPage($store)
    {
        $userStore = UserStore::where('slug',$store)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>'Contact Page ',
        ];
        return view('storefront.'.$themeLocation.'.contact')->with($data);
    }
    //about
    public function aboutPage($store)
    {
        $userStore = UserStore::where('slug',$store)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>'About '.$userStore->name,
        ];
        return view('storefront.'.$themeLocation.'.about')->with($data);
    }

}
