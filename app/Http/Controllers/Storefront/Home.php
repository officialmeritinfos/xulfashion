<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
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
}
