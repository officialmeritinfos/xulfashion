<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class SolutionsController extends Controller
{
    //sell online
    public function sellOnline()
    {
        $web = GeneralSetting::find(1);

        return view('company.solutions.sell-online')->with([
            'pageName'      =>'Sell Online',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //invoice management
    public function invoiceManagement()
    {
        $web = GeneralSetting::find(1);

        return view('company.solutions.invoice')->with([
            'pageName'      =>'Create, Send, Manage and Pay Invoice',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //inventory management
    public function inventory()
    {
        $web = GeneralSetting::find(1);

        return view('company.solutions.inventory')->with([
            'pageName'      =>'Inventory Management',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //point of sale
    public function pointOfSale()
    {
        $web = GeneralSetting::find(1);

        return view('company.solutions.pos')->with([
            'pageName'      =>'Point-of-sales & Checkout System',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //Receive payments
    public function payments()
    {
        $web = GeneralSetting::find(1);

        return view('company.solutions.payments')->with([
            'pageName'      =>'Receive Payments on '.$web->name,
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //booking solutions
    public function bookingSolution()
    {
        $web = GeneralSetting::find(1);

        return view('company.solutions.booking')->with([
            'pageName'      =>'Mange booking & Appointments',
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //listing
    public function businessListing()
    {
        $web = GeneralSetting::find(1);

        return view('company.solutions.listing')->with([
            'pageName'      =>'Get Listed On '.$web->name,
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //event management
    public function eventManagement()
    {
        $web = GeneralSetting::find(1);

        return view('company.solutions.events')->with([
            'pageName'      =>'Create & manage Events on '.$web->name,
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
    //academy
    public function academy()
    {
        $web = GeneralSetting::find(1);

        return view('company.solutions.academy')->with([
            'pageName'      =>'Manage Admission & Enrollment in your school with '.$web->name,
            'siteName'      =>$web->name,
            'web'           =>$web
        ]);
    }
}
