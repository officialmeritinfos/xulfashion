<?php

namespace App\Http\Controllers\Mobile\User\Events;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserEventPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantPurchaseController extends BaseController
{
    //landing page
    public function landingPage()
    {

    }
    //Purchase Detail
    public function purchaseDetail(Request $request,$eventRef, $purchaseRef)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $purchase= UserEventPurchase::where([
            'reference' => $purchaseRef,
        ])->with([
            'events','guests','tickets.ticket','users'
        ])->firstOrFail();

        return view('mobile.users.events.purchases.merchant_purchase_detail')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Purchase Detail: '.$purchase->events->title,
            'purchase' => $purchase,
            'event' =>$purchase->events
        ]);
    }
}
