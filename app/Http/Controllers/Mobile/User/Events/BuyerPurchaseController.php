<?php

namespace App\Http\Controllers\Mobile\User\Events;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserEventPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerPurchaseController extends BaseController
{
    //landing page
    public function landingPage(Request $request)
    {

    }
    //purchase detail
    public function purchaseDetail(Request $request,$purchaseRef)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $purchase= UserEventPurchase::where([
            'user_id' => $user->id,
            'reference' => $purchaseRef,
        ])->with([
            'events','guests','tickets.ticket'
        ])->first();

        return view('mobile.users.events.purchases.buyer_purchase_detail')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Purchase Detail: '.$purchase->reference,
            'purchase' => $purchase,
        ]);
    }
    //add guests
    public function addGuest($purchaseRef)
    {

    }
}
