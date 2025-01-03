<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Home extends BaseController
{
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);
        return view('company.home')->with([
            'pageName'      =>'Find the Best Tailors, Fashion Designers, Models & Fashion Stores in your area',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //about us
    public function about()
    {
        $web = GeneralSetting::find(1);
        return view('company.about')->with([
            'pageName'      =>'About '.$web->name,
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }

    public function faq()
    {
        $web = GeneralSetting::find(1);
        return view('company.faq')->with([
            'pageName'      =>'Frequently Asked Questions',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    public function pricing(Request $request)
    {
        $currency = $request->get('currency');

        $web = GeneralSetting::find(1);
        return view('company.pricing')->with([
            'pageName'      =>'Pricing & Fees',
            'siteName'      =>$web->name,
            'web'           =>$web,
            'fiat'          =>Fiat::where('code',strtoupper($currency))->orWhere('code','USD')->first(),
            'fiats'         =>Fiat::where('status',1)->get()
        ]);
    }
    public function career()
    {
        $web = GeneralSetting::find(1);
        return view('company.career')->with([
            'pageName'      =>'Work with '.$web->name,
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    public function contact()
    {
        $web = GeneralSetting::find(1);
        return view('company.contact')->with([
            'pageName'      =>'Contact '.$web->name,
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    public function features()
    {
        $web = GeneralSetting::find(1);
        return view('company.features')->with([
            'pageName'      =>$web->name.' Features',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }

    public function download()
    {
        $web = GeneralSetting::find(1);
        return view('company.download')->with([
            'pageName'      =>'Download the app',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }

    //download marketplace app
    public function downloadMarketplaceApp()
    {
        $filePath = public_path('app/XulFashionMarketplace.apk');
        if (!File::exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, 'XulfashionMarketplace.apk', [
            'Content-Type' => 'application/vnd.android.package-archive',
            'Content-Disposition' => 'attachment; filename="XulfashionMarketplace.apk"',
        ]);
    }
}
