<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\SystemStaff;
use Illuminate\Http\Request;

class Home extends BaseController
{
    //landing page
    public function landingPage(Request $request){
        $staff = SystemStaff::where('id',$request->session()->get('staff'))->firstOrFail();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Staff Overview',
            'siteName'  =>$web->name
        ]);
    }
}
