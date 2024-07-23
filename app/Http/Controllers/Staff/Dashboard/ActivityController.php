<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    //landing page
    public function landingPage()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.activity.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Staff Activity',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
}
