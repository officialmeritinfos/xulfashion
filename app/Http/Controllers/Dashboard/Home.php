<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Home extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.common.home')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$this->userAccountType($user).' Dashboard',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user)
        ]);
    }
}
