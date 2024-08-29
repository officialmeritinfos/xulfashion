<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserActivity;
use App\Models\UserAd;
use App\Models\UserStore;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            'accountType'   =>$this->userAccountType($user),
            'store'         =>UserStore::where('user',$user->id)->first(),
            'ads'           =>UserAd::where('user',$user->id)->count(),
        ]);
    }
    //landing page
    public function showClientApp()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.client_app_landing')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$this->userAccountType($user).' Dashboard',
        ]);
    }
    //user activities
    public function userActivities()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.common.activities')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$this->userAccountType($user).' Activity',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'activities'    =>UserActivity::where([
                'user'=>$user->id,
            ])->orderBy('status','desc')->orderBy('id','desc')->paginate(10)
        ]);
    }
    //all user activities
    public function allUserActivities()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.common.activities')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$this->userAccountType($user).' Activities',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'activities'    =>UserActivity::where([
                'user'=>$user->id,
            ])->paginate(10)
        ]);
    }
    //read user activities
    public function readUserActivity($id)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $activity = UserActivity::where([
                'user'=>$user->id,'id'=>$id
            ])->firstOrFail();

            $activity->status = 1;
            $activity->save();

            return back()->with('success','successful');
        }catch (\Exception $exception){
            Log::info($exception->getMessage());

            return back()->with('error','Something went wrong');
        }
    }
    public function readAllUserActivity()
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            UserActivity::where('user',$user->id)->whereNot('status',1)->update([
                'status'=>1
            ]);

            return back()->with('success','successful');
        }catch (\Exception $exception){
            Log::info($exception->getMessage());

            return back()->with('error','Something went wrong');
        }
    }
}
