<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\TutorSalaryPayment;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Payments extends BaseController
{
    use Helpers;
    //landing Page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.payments.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Payments Analytics',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'payments'      =>TutorSalaryPayment::where('tutor',$user->id)->paginate()
        ]);
    }
}
