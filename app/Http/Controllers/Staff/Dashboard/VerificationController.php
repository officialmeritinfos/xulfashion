<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends BaseController
{
    //merchants verification documents
    public function merchantsKYC()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.verifications.merchant")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Merchant Verification Submissions',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }

    //stores verifications
    public function storeKYC()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.verifications.stores")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Stores Verification Submissions',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
}
