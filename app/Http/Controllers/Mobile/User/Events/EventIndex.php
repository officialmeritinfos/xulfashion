<?php

namespace App\Http\Controllers\Mobile\User\Events;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\EventCategory;
use App\Models\EventInterval;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\UserEvent;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventIndex extends BaseController
{
    public $google;
    use Helpers;
    public function __construct()
    {
        $this->google = new GoogleUpload();
    }
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        return view('mobile.users.events.index')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Events Landing Page',
        ]);
    }
    //create event
    public function createEvent(Request $request)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $country = Country::where('iso3',$user->countryCode)->first();

        return view('mobile.users.events.new')->with([
            'pageName'  =>'Create Events',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>$user,
        ]);
    }
    //create online Events
    public function createOnlineEvent(Request $request)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $country = Country::where('iso3',$user->countryCode)->first();

        return view('mobile.users.events.components.online_events')->with([
            'pageName'  =>'Create Online Event',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>$user,
            'states'    =>State::where('country_code',$country->iso2)->orderBy('name')->get(),
            'categories'=>EventCategory::where('status',1)->get(),
            'timezones' =>\DateTimeZone::listIdentifiers(),
            'intervals' =>EventInterval::where('status',1)->get()
        ]);
    }
    //create live Events
    public function createLiveEvent(Request $request)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $country = Country::where('iso3',$user->countryCode)->first();

        return view('mobile.users.events.components.live_events')->with([
            'pageName'  =>'Create Live Event',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>$user,
            'states'    =>State::where('country_code',$country->iso2)->orderBy('name')->get(),
            'categories'=>EventCategory::where('status',1)->get(),
            'timezones' =>\DateTimeZone::listIdentifiers(),
            'intervals' =>EventInterval::where('status',1)->get()
        ]);
    }
    //process live event creation
    public function processLiveEventCreation(Request $request)
    {
        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();

            $validator = Validator::make($request->all(),[
                'title'=>['required','string','max:200'],
                'description'=>['required','string'],
                'featuredPhoto'=>['required','image','max:2048'],
                'state'=>['required','alpha',Rule::exists('states','iso2')->where('country_code',$country->iso2)],
                'location'=>['required','string','max:1000'],
                'category'=>['required','integer','exists:event_categories,id'],
                'scheduleType'=>['required','integer','in:1,2'],
                'timezone' => ['required','string','timezone'],
                'startDateOnetime' => ['required','date','after_or_equal:today'],
                'startTimeOnetime' => ['required','date_format:H:i'],
                'endDateOnetime' => ['required_if:scheduleType,1','nullable', 'date','after:startDateOnetime'],
                'endTimeOnetime' => ['required_if:scheduleType,1','nullable','date_format:H:i','after:startTimeOnetime'],
                'frequency' => ['required_if:scheduleType,2','nullable','integer','exists:event_intervals,id'],
                'interval' => ['required_if:scheduleType,2','nullable','integer'],
                'recurrenceEndType' => ['required_if:scheduleType,2','nullable','integer'],
                'endDateRecur' => ['required_if:recurrenceEndType,1','nullable','date','after_or_equal:startDateRecur'],
                'endTimeRecur' => ['required_if:recurrenceEndType,1','nullable','date_format:H:i','after:startDateRecur'],
                'numberOfOccurrence' => ['required_if:recurrenceEndType,2','nullable','integer'],
                'facebook' => ['nullable','url'],
                'twitter' => ['nullable','url'],
                'instagram' => ['nullable','url'],
                'website' => ['nullable','url'],
            ],[],[
                'startDateOnetime'=>'Start Date for One-time event',
                'startTimeOnetime'=>'Start Time for One-time event',
                'endDateOnetime'=>'End Date for One-time event',
                'endTimeOnetime'=>'End Time for One-time event',
                'recurrenceEndType'=>'End Type for recurring event',
                'endDateRecur'=>'End date for recurring event',
                'endTimeRecur'=>'End time for recurring event',
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();
            $reference = $this->generateUniqueReference('user_events','reference',16);
            $frequency = EventInterval::where('id',$input['frequency'])->first();
            if ($input['scheduleType']!=1){
                $interval = $input['interval'].' '.$frequency->period;
            }

            if ($request->hasFile('featuredPhoto')) {
                //lets upload the address proof
                $result = $this->google->uploadGoogle($request->file('featuredPhoto'));
                $featuredPhoto  = $result['link'];
            }

            $event = UserEvent::create([
                'reference' => $reference, 'user' => $user->id, 'eventType' => 1,
                'title' => $input['title'], 'description' => $input['description'],
                'hideVenue' => $request->filled('hideVenue')?1:2, 'category' => $input['category'],
                'eventScheduleType' => $input['scheduleType'], 'startDate' => $input['startDateOnetime'],
                'endDate' => ($input['scheduleType']==1)?$input['endDateOnetime']:'', 'eventTimeZone' => $input['timezone'],
                'eventFrequency' => $input['frequency'], 'startTime' => $input['startDateOnetime'],
                'endTime' =>($input['scheduleType']==1)?$input['endDateOnetime']:'',
                'recurrenceInterval'=>($input['scheduleType']!=1)?$interval:'', 'recurrenceEndType'=>($input['scheduleType']!=1)?$input['recurrenceEndType']:'',
                'recurrenceEndCount'=>($input['scheduleType']!=1 && $input['recurrenceEndType']!=1)?$input['numberOfOccurrence']:'',
                'recurrenceEndDate'=>($input['scheduleType']!=1 && $input['recurrenceEndType']==1)?$input['endDateRecur']:'',
                'recurrenceEndTime'=>($input['scheduleType']!=1 && $input['recurrenceEndType']==1)?$input['endTimeRecur']:'',
                'state'=>$input['state'],'location'=>$input['location'],'featuredImage'=>$featuredPhoto,
                'instagram'=>$input['instagram'],'facebook'=>$input['facebook'],'twitter'=>$input['twitter'],
                'website'=>$input['website']
            ]);

            if (!empty($event)){
                DB::commit();
                $this->userNotification($user,'Event Created','Your event was created successfully and is pending review',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.events.tickets.new',['event'=>$event->reference]),
                    'redirects'=>true
                ],'Event created successful. Redirecting to add tickets ...');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while adding new live event: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //process online event creation
    public function processOnlineEventCreation(Request $request)
    {

    }
}
