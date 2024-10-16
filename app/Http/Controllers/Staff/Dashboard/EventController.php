<?php

namespace App\Http\Controllers\Staff\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends BaseController
{
    //landing page
    public function landingPage(Request $request)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        return view("staff.dashboard.events.index")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>'Events',
        ]);
    }
    //event Detail
    public function eventDetail(Request $request,$eventId)
    {
        $staff = Auth::guard("staff")->user();
        $web = GeneralSetting::where("id",1)->first();

        $event = UserEvent::where('reference',$eventId)->firstOrFail();

        return view("staff.dashboard.events.detail")->with([
            'staff'     => $staff,
            'web'       => $web,
            'siteName'  =>$web->name,
            'user'      =>$staff,
            'pageName'  =>$event->title,
            'event'     =>$event,
        ]);
    }
}
