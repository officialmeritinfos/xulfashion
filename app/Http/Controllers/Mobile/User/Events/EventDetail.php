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
use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventSettlement;
use App\Models\UserEventTicket;
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
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $country = Country::where('iso3',$user->countryCode)->first();

        $event = UserEvent::where([
            'reference' => $eventId,
            'user' => $user->id
        ])->firstOrFail();

        return view('mobile.users.events.sales')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>"Event Sales",
            'event' => $event,
            'country' => $country,
            'ticketSold'=>UserEventTicket::where([
                'event_id' => $event->id,
            ])->sum('ticketSold'),
            'purchases'=>UserEventPurchase::where([
                'event_id' => $event->id,
            ])->with(
                ['events','tickets','buyers']
            )->paginate(15),
            'settlements'=>UserEventSettlement::where([
                'user' => $user->id,'event' => $event->id,
            ])->with('banks')->paginate(15,'*','settlements')
        ]);
    }

    public function eventEmail(Request $request,$eventId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $country = Country::where('iso3',$user->countryCode)->first();

        $event = UserEvent::where([
            'reference' => $eventId,
            'user' => $user->id
        ])->firstOrFail();

        return view('mobile.users.events.email')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>"Customize Event Email",
            'event' => $event,
            'country' => $country,
        ]);
    }
    //update event custom email
    public function processEmail(Request $request,$eventId)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $event = UserEvent::where([
                'reference' => $eventId,
                'user' => $user->id
            ])->first();
            if (empty($event)){
                return $this->sendError('event.error',['error'=>'Event not found']);
            }
            $validator = Validator::make($request->all(),[
                'message'=>['required','string']
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            $event->successMail = clean($input['message']);
            $event->save();

            DB::commit();
            return $this->sendResponse([
                'redirectTo'=>url()->previous(),
                'redirects'=>false
            ],'Message successfully set live.');


        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while setting event message: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }

    public function viewTicket($eventId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $country = Country::where('iso3',$user->countryCode)->first();

        $event = UserEvent::where([
            'reference' => $eventId,
            'user' => $user->id
        ])->firstOrFail();

        return view('tickets.body')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>$event->title,
            'event' => $event,
            'country' => $country,
            'template'=>$event->theme,
            'merchant'=>User::where('id',$event->user)->first()
        ]);
    }
}
