<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;

class LegalController extends Controller
{
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);
        return view('company.legal.index')->with([
            'pageName'      =>'Legal',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //general terms
    public function generalTerms()
    {
        $web = GeneralSetting::find(1);
        return view('company.legal.general_terms')->with([
            'pageName'      =>'General Terms and Conditions',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //general privacy policy
    public function generalPrivacy()
    {
        $web = GeneralSetting::find(1);
        return view('company.legal.general_privacy')->with([
            'pageName'      =>'General Privacy Policy',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //general ads posting policy
    public function adsPolicy()
    {
        $web = GeneralSetting::find(1);
        return view('company.legal.ads-policy')->with([
            'pageName'      =>'Ads Posting Policy',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //AML
    public function amlPolicy()
    {
        $web = GeneralSetting::find(1);
        return view('company.legal.aml')->with([
            'pageName'      =>'Anti-money Laundering Policy',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //Merchant Terms
    public function merchantTerms()
    {
        $web = GeneralSetting::find(1);
        return view('company.legal.merchant_terms')->with([
            'pageName'      =>'Merchant Terms and Conditions',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //Merchant Privacy
    public function merchantPrivacy()
    {
        $web = GeneralSetting::find(1);
        return view('company.legal.merchant_privacy')->with([
            'pageName'      =>'Merchant Privacy Policy',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //guest Privacy
    public function guestPrivacy()
    {
        $web = GeneralSetting::find(1);
        return view('company.legal.guest_privacy')->with([
            'pageName'      =>'Guest Privacy Policy',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //customer Privacy
    public function customerPrivacy()
    {
        $web = GeneralSetting::find(1);
        return view('company.legal.customer_privacy')->with([
            'pageName'      =>'Customers Privacy Policy',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //AUP
    public function acceptableUsePolicy()
    {
        $web = GeneralSetting::find(1);
        return view('company.legal.acceptable_terms')->with([
            'pageName'      =>'Acceptable Terms of Use',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }

    public function deleteMyInformation()
    {
        $web = GeneralSetting::find(1);
        return view('company.legal.delete-my-information')->with([
            'pageName'      =>'Request for Account Deletion',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
}
