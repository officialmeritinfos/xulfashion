<?php

namespace App\Http\Controllers\Dashboard\Tutor;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\IntervalType;
use App\Models\Job;
use App\Models\JobType;
use App\Models\RateType;
use App\Models\TutorApplication;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Applications extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.applications.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Job Applications',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'applications'  =>TutorApplication::where([
                'user' => $user->id,
                'status' => 2
            ])->paginate()
        ]);
    }
    public function active()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.applications.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Active Job Applications',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'applications'  =>TutorApplication::where([
                'user' => $user->id,
                'status' => 1
            ])->paginate()
        ]);
    }
    public function interviewing()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.applications.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Interview Invites',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'applications'  =>TutorApplication::where([
                'user' => $user->id,
                'status' => 4
            ])->paginate()
        ]);
    }
    public function closed()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.applications.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Closed Applications',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'applications'  =>TutorApplication::where([
                'user' => $user->id,
                'status' => 3
            ])->paginate()
        ]);
    }

    public function applicationDetail($id)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        $application = TutorApplication::where([
            'user'=>$user->id,
            'reference' => $id
        ])->firstOrFail();

        $job=Job::where('id',$application->jobId)->first();

        return view('dashboard.users.applications.details')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Application Detail',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'application'   =>$application,
            'job'           =>$job,
            'rateType'      =>RateType::where('id',$job->paymentType)->first(),
            'interval'      =>IntervalType::where('id',$job->intervalType)->first(),
            'jobType'       =>JobType::where('id',$job->typeOfJob)->first()
        ]);
    }
}
