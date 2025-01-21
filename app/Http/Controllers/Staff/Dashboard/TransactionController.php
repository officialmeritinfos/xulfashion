<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends BaseController
{
    //account funding
    public function accountFunding()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.transactions.account_funding")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Account Funding',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
    //withdrawal lists
    public function withdrawals()
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.transactions.withdrawals")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Withdrawals',
            'siteName'  =>$web->name,
            'user'      =>$staff
        ]);
    }
}
