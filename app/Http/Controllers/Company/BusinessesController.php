<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class BusinessesController extends Controller
{
    //fashion designers
    public function fashionDesigners()
    {
        $web = GeneralSetting::find(1);

        return view('company.businesses.fashion_designers')->with([
            'pageName'      =>'Fashion Designers',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //beauty entrepreneurs
    public function beautyEntrepreneur()
    {
        $web = GeneralSetting::find(1);

        return view('company.businesses.beauty_entrepreneurs')->with([
            'pageName'      =>'Beauty Entrepreneurs',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //fashion schools
    public function fashionSchool()
    {
        $web = GeneralSetting::find(1);

        return view('company.businesses.fashion_schools')->with([
            'pageName'      =>'Fashion Schools',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //manufacturers
    public function manufacturers()
    {
        $web = GeneralSetting::find(1);

        return view('company.businesses.manufacturers')->with([
            'pageName'      =>'Manufacturers',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //retailers
    public function retailers()
    {
        $web = GeneralSetting::find(1);

        return view('company.businesses.retailers')->with([
            'pageName'      =>'Retail Businesses',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
}
