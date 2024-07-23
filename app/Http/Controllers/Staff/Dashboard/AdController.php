<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    //landing page
    public function landingPage()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.users.components.ads.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Ads',
        ]);
    }
}
