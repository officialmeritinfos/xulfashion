<?php

namespace App\Http\Controllers\Mobile\User\Payments;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\PayoutCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettlementAccountController extends BaseController
{
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $country = Country::where('iso3', $user->countryCode)->first();

        $mainCurrency = PayoutCurrency::getCurrencyOrDefault($country->currency);
        $usdCurrency = $mainCurrency->currency === 'USD' ? $mainCurrency : PayoutCurrency::getCurrencyOrDefault('USD');

        return view('mobile.users.payments.settlement_account')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Settlement Accounts',
            'payoutCurrency' =>$mainCurrency,
            'usdPayoutCurrency' => $usdCurrency,
            'fiat'   =>$country,
        ]);
    }
}
