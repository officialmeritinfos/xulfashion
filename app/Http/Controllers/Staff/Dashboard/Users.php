<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserAd;
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
    //account balance
    public function accountBalance(Request $request,$id)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$id)->firstOrFail();

        return view("staff.dashboard.users.components.account.account")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Merchant Account Balance',
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant
        ]);
    }
    //withdrawal detail
    public function withdrawalDetail(Request $request,$merchant,$id)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$merchant)->firstOrFail();

        return view("staff.dashboard.users.components.account.withdrawal_detail")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Withdrawal Detail',
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant,
            'withdrawal'=>$id
        ]);
    }
    //payout Account
    public function payoutAccount(Request $request,$id)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$id)->firstOrFail();

        return view("staff.dashboard.users.components.account.payout_accounts")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Merchant Payout Accounts',
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant
        ]);
    }
    //edit merchant information
    public function editMerchantInfo(Request $request,$id)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$id)->firstOrFail();

        return view("staff.dashboard.users.edit")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Edit Merchant Information',
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant
        ]);
    }
    //merchant listings
    public function merchantAds(Request $request,$id)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$id)->firstOrFail();

        return view("staff.dashboard.users.components.ads.list")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Merchant Ad listings',
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant
        ]);
    }
    //add merchant listings
    public function newMerchantAds(Request $request,$id)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$id)->firstOrFail();

        return view("staff.dashboard.users.components.ads.add")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>'Create Merchant Ads',
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant
        ]);
    }
    //add merchant listings
    public function merchantAdsDetail(Request $request,$id,$ads)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$id)->firstOrFail();
        $ad = UserAd::where([
            'reference' => $ads,'user'=>$merchant->id
        ])->firstOrFail();

        return view("staff.dashboard.users.components.ads.details")->with([
            'staff'     => $staff,
            'web'       => $web,
            'pageName'  =>$ad->title,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant,
            'ad'        =>$ad
        ]);
    }

    //merchant store
    public function merchantStore($id)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $merchant = User::where("reference",$id)->firstOrFail();

        return view("staff.dashboard.users.components.store.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'merchant'  => $merchant,
            'pageName'  =>'Merchant Store'
        ]);
    }
}
