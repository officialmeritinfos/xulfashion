<?php

namespace App\Http\Controllers\Storefront\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreSetting;
use App\Traits\Helpers;
use App\Traits\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseController
{
    use Helpers,Themes;
    //landing page
    public function landingPage(Request $request, $subdomain)
    {
        $userStore = UserStore::where('slug',$subdomain)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);
        $customer = UserStoreCustomer::where([
            'store'=>$userStore->id,'id'=>$request->session()->get('customer')
        ])->firstOrFail();

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>'Dashboard',
            'customer'        =>$customer
        ];
        return view('storefront.account.index')->with($data);
    }
    //logout
    public function logout(Request $request,$subdomain)
    {
        $store = UserStore::where('slug',$subdomain)->firstOrFail();
        $customer = UserStoreCustomer::where([
            'store'=>$store->id,'id'=>$request->session()->get('customer')
        ])->firstOrFail();
        $customer->loggedIn=2;
        $customer->save();
        Auth::guard('customers')->logout();

        $request->session()->forget(['loggedIn', 'customer','loggedInStore']);

        return redirect()->to(route('merchant.store.login',['subdomain'=>$subdomain]))->with('success','Successfully logged out');
    }
}
