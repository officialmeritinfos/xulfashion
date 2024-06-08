<?php

namespace App\Http\Controllers\Storefront\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use Illuminate\Http\Request;

class Dashboard extends BaseController
{
    //landing page
    public function landingPage()
    {

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

        $request->session()->forget(['loggedIn', 'customer','loggedInStore']);

        return redirect()->to(route('merchant.store.login',['subdomain'=>$subdomain]))->with('success','Successfully logged out');
    }
}
