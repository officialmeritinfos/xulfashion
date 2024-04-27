<?php

namespace App\Http\Controllers\Dashboard\Tutor;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\TutorTransaction;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Transactions extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.transactions.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Transactions Analytics',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'transactions'  =>TutorTransaction::where('user',$user->id)->paginate()
        ]);
    }
}
