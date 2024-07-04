<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\SystemStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Home extends BaseController
{
    //landing page
    public function landingPage(Request $request){
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Staff Overview',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
    //logout
    public function logout(Request $request){
        $request->session()->flush();

        Auth::guard('staff')->logout();

        $request->session()->regenerate();

        return redirect()->route('staff.login')->with('success','Successfully logged out.');

    }
}
