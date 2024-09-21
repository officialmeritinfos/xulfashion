<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\SystemStaff;
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
    public function staffDetails($id)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $staffs = SystemStaff::where('id',$id)->first();
        if (empty($staffs)){
            return back()->with('error','Staff not found');
        }

        return view("staff.dashboard.staffs.detail")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Staff: '.$staffs->name,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'staffs'    =>$staffs
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
