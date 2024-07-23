<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    //landing page
    public function profilePage()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.settings.profile")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Staff Profile',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
    //general settings
    public function generalSettings()
    {
        $staff = Auth::guard("staff")->user();

        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.settings.general")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'General Settings',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
    //security setting
    public function securitySetting()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.settings.security")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Security Setting',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
}
