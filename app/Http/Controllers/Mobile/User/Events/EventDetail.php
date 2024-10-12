<?php

namespace App\Http\Controllers\Mobile\User\Events;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\EventCategory;
use App\Models\EventInterval;
use App\Models\GeneralSetting;
use App\Models\State;
use App\Models\UserEvent;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventDetail extends BaseController
{
    public $google;
    use Helpers;
    public function __construct()
    {
        $this->google = new GoogleUpload();
    }
    //landing page
    public function landingPage(Request $request, $eventId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $event = UserEvent::where([
            'reference' => $eventId,
            'user' => $user->id
        ])->firstOrFail();

        return view('mobile.users.events.details')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>$event->title,
            'event' => $event,
        ]);
    }
    //edit event
    public function editEvent(Request $request, $eventId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $event = UserEvent::where([
            'reference' => $eventId,
            'user' => $user->id
        ])->firstOrFail();

        $country = Country::where('iso3',$user->countryCode)->first();

        return view('mobile.users.events.edit')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Edit Event',
            'event' => $event,
            'states'    =>State::where('country_code',$country->iso2)->orderBy('name')->get(),
            'categories'=>EventCategory::where('status',1)->get(),
            'timezones' =>\DateTimeZone::listIdentifiers(),
            'intervals' =>EventInterval::where('status',1)->get()
        ]);
    }
    //process edit live event
    public function processLiveEventUpdate(Request $request)
    {

    }
    //process edit online event
    public function processOnlineEventUpdate(Request $request)
    {

    }
}
