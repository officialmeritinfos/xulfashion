<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserSetting;
use App\Models\UserStore;
use App\Models\UserStoreCoupon;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use App\Models\UserStoreOrder;
use App\Models\UserStoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    //landing page
    public function landingPage()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();


        return view("staff.dashboard.users.components.store.list")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Stores',
        ]);
    }
    //coupons
    public function coupons($storeRef)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $store = UserStore::where('reference',$storeRef)->firstOrFail();

        return view("staff.dashboard.users.components.store.coupons")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Store Coupons',
            'coupons'   =>UserStoreCoupon::where('store',$store->id)->latest()->paginate(15),
            'store'     =>$store
        ]);
    }
    //customer
    public function customers($storeRef)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $store = UserStore::where('reference',$storeRef)->firstOrFail();

        return view("staff.dashboard.users.components.store.customers.list")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Store Customers',
            'customers' =>UserStoreCustomer::where('store',$store->id)->latest()->paginate(15),
            'store'     =>$store
        ]);
    }
    //customer detail
    public function customerDetail($storeRef,$customerId)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $store = UserStore::where('reference',$storeRef)->firstOrFail();
        $customer = UserStoreCustomer::where([
            'store'=>$store->id,'reference' => $customerId
        ])->latest()->firstOrFail();

        return view("staff.dashboard.users.components.store.customers.detail")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Store Customers Detail',
            'customer' =>$customer,
            'store'     =>$store,
        ]);
    }
    //customer detail
    public function invoices($storeRef)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $store = UserStore::where('reference',$storeRef)->firstOrFail();

        return view("staff.dashboard.users.components.store.invoices.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Store Invoices',
            'store'     =>$store,
        ]);
    }
    public function invoicesDetail($storeRef,$invoiceRef)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $store = UserStore::where('reference',$storeRef)->firstOrFail();
        $invoice = UserStoreInvoice::where([
            'store' => $store->id,'reference' => $invoiceRef
        ])->firstOrFail();

        return view("staff.dashboard.users.components.store.invoices.detail")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Store Invoice Detail',
            'store'     =>$store,
            'invoice'   =>$invoice
        ]);
    }
    public function categories($storeRef)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $store = UserStore::where('reference',$storeRef)->firstOrFail();
        return view("staff.dashboard.users.components.store.categories.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Store Categories',
            'store'     =>$store,
        ]);
    }
    public function products($storeRef)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $store = UserStore::where('reference',$storeRef)->firstOrFail();

        return view("staff.dashboard.users.components.store.products.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Store Products',
            'store'     =>$store,
        ]);
    }
    public function orders($storeRef)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $store = UserStore::where('reference',$storeRef)->firstOrFail();

        return view("staff.dashboard.users.components.store.order.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Store Orders',
            'store'     =>$store,
        ]);
    }
    //settings
    public function settings($storeRef)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $store = UserStore::where('reference',$storeRef)->firstOrFail();

        return view("staff.dashboard.users.components.store.settings")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Store Settings',
            'store'     =>$store,
        ]);
    }
    //kyb
    public function kyb($storeRef)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $store = UserStore::where('reference',$storeRef)->firstOrFail();

        return view("staff.dashboard.users.components.store.kyb.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Store KYB',
            'store'     =>$store,
        ]);
    }
}
