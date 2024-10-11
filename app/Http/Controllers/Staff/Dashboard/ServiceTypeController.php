<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceTypeController extends BaseController
{
    //landing page
    public function landingPage()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.service-types.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Service Types',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }

    //event category
    public function eventCategory()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.service-types.event-categories")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Event Categories',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
}
