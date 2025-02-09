<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class LegalController extends BaseController
{
    //landing page
    public function landingPage()
    {

    }
    //privacy policy
    public function privacyPolicy()
    {
        $web = GeneralSetting::find(1);
        return view('mobile.legal.privacy_policy')->with([
            'web'       =>$web,
            'pageName'  =>"General Privacy Policy",
            'siteName'  =>$web->name
        ]);
    }
    //privacy policy
    public function deleteMyInformation()
    {
        $web = GeneralSetting::find(1);
        return view('mobile.legal.delete_information')->with([
            'web'       =>$web,
            'pageName'  =>"Request Account Deletion",
            'siteName'  =>$web->name
        ]);
    }

    //ads policy
    public function adsPolicy()
    {
        $web = GeneralSetting::find(1);
        return view('mobile.legal.ads-policy')->with([
            'web'       =>$web,
            'pageName'  =>"Ads Posting Policy",
            'siteName'  =>$web->name
        ]);
    }
}
