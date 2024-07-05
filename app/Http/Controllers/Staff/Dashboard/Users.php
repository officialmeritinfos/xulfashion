<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Users extends BaseController
{
    //landing page
    public function landingPage(){
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.users.list")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Merchants',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
    //create new user
    public function create(Request $request){
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.users.add")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Onboard New merchant',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
    //detail
    public function details(Request $request,$id){
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$id)->firstOrFail();

        return view("staff.dashboard.users.detail")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Merchant Detail',
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant
        ]);
    }
    //complete profile
    public function completeProfile(Request $request,$id){
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$id)->firstOrFail();

        return view("staff.dashboard.users.components.complete-profile")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Complete Merchant Profile',
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant
        ]);
    }
    //list kyc
    public function kyc(Request $request,$id){
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$id)->firstOrFail();

        return view("staff.dashboard.users.components.kyc.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Merchant KYC',
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant
        ]);
    }
    //new kyc
    public function kycSubmission(Request $request,$id){
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$id)->firstOrFail();

        return view("staff.dashboard.users.components.kyc.detail")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Merchant KYC Submission',
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant
        ]);
    }

}
