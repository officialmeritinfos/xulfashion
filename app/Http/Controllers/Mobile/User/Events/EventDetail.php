<?php

namespace App\Http\Controllers\Mobile\User\Events;

use App\Custom\GoogleUpload;
use App\Enums\EventPlatform;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventDetail extends BaseController
{
    //landing page
    public function landingPage(Request $request, $eventId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $country = Country::where('iso3',$user->countryCode)->first();

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
            'country' => $country,
        ]);
    }
    //sales
    public function sales(Request $request,$eventId)
    {

    }
}
