<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function landingPage()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.staffs.list")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Staff List',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
    public function roles()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.staffs.roles")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Role',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
    public function permissions()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.staffs.permissions")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Permissions',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
}
