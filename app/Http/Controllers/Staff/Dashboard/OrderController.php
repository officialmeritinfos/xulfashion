<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //landing page
    public function landingPage()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.users.components.store.order.list_orders")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Orders',
        ]);
    }
    //order detail
    public function orderDetail($orderId,$storeRef)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $store = UserStore::where('reference',$storeRef)->firstOrFail();
        $order = UserStoreOrder::where([
            'store' => $store->id,
            'reference' => $orderId
        ])->firstOrFail();

        return view("staff.dashboard.users.components.store.order.detail")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Store Order Details',
            'store'     =>$store,
            'order'     =>$order
        ]);
    }
}
