<?php

namespace App\Http\Controllers\Mobile\User\Payments;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserEventSettlement;
use App\Models\UserWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends BaseController
{
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        return view('mobile.users.payments.index')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Payment History',
        ]);
    }

    public function merchantDashboard()
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        return view('mobile.users.payments.merchant_index')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Financial Account History',
            'withdrawals' => UserWithdrawal::where('user',$user->id)->paginate(10,'*','withdrawals'),
            'settlements' => UserEventSettlement::where('user',$user->id)->with('events')->paginate(10,'*','settlements'),
        ]);
    }
}
