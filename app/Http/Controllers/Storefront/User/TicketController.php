<?php

namespace App\Http\Controllers\Storefront\User;

use App\Http\Controllers\BaseController;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreSetting;
use App\Traits\Helpers;
use App\Traits\Themes;
use Illuminate\Http\Request;

class TicketController extends BaseController
{
    use Helpers,Themes;
    //landing page
    public function landingPage(Request $request,$subdomain)
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
            'pageName'        =>'Support Tickets',
            'customer'        =>$customer
        ];
        return view('storefront.account.tickets.index')->with($data);
    }
    //new ticket page
    public function newTicket(Request $request,$subdomain)
    {
        $userStore = UserStore::where('slug',$subdomain)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>'Create a Support Ticket for '.$userStore->name,
        ];
        return view('storefront.account.tickets.new')->with($data);
    }
}
