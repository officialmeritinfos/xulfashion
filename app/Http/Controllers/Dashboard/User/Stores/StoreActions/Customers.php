<?php

namespace App\Http\Controllers\Dashboard\User\Stores\StoreActions;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use App\Models\UserStoreOrder;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customers extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.customers.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Customers',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'customers'     =>UserStoreCustomer::where('store',$store->id)->paginate(20)
        ]);
    }
    //details
    public function customerDetails($ref)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        $customer = UserStoreCustomer::where([
            'reference'=>$ref,'store'=>$store->id
        ])->firstOrFail();

        return view('dashboard.users.stores.components.customers.details')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Customer Detail',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'customer'      =>$customer,
            'orders'        =>UserStoreOrder::where(['store'=>$store->id,'customer'=>$customer->id])->paginate(20),
            'invoices'      =>UserStoreInvoice::where(['store'=>$store->id,'customer'=>$customer->id])->paginate(20,'*','invoice'),
        ]);
    }
    //export subscribers
    public function exportSubscribers()
    {

    }
}
