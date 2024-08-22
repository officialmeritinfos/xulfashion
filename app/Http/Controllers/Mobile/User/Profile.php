<?php

namespace App\Http\Controllers\Mobile\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Profile extends BaseController
{
    //landing Page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.index')->with([
            'pageName'  =>'Profile Manager',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }
    //landing Page
    public function editProfile()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.edit_profile')->with([
            'pageName'  =>'Edit Profile',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }
}
