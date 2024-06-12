<?php

namespace App\Http\Controllers\Staff\Auth;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    //landing page
    public function landingPage(Request $request)
    {
        //check if the session for two-factor exists
        if (!$request->session()->has('two_factor') || !$request->session()->has('staff')){
            return to_route('staff.login')->with('error','Access denied, please login again.');
        }
        $web = GeneralSetting::find(1);

        return view('staff.auth.two_factor')->with([
            'web'        =>$web,
            'siteName'   =>$web->name,
            'pageName'   =>'Two-factor Authentication',
        ]);
    }
    //process two-factor authentication
    public function processAuthentication(Request $request)
    {

    }
}
