<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

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
}
