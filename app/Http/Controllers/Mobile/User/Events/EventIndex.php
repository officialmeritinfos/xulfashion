<?php

namespace App\Http\Controllers\Mobile\User\Events;

use App\Custom\GoogleUpload;
use App\Enums\EventPlatform;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\EventCategory;
use App\Models\EventInterval;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
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
    public function landingPage(Request $request)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $purchases = UserEventPurchase::where('user_id',$user->id)->with([
            'events','guests'
        ])->orderBy('id','desc')->paginate(10);

        if ($request->ajax()) {
            $html = view('mobile.users.events.components.users_ticket_list', compact('purchases'))->render();
            return response()->json([
                'html' => $html,
                'nextPageUrl' => $purchases->nextPageUrl(),
            ]);
        }

        return view('mobile.users.events.index')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Events Landing Page',
            'purchases' => $purchases,
        ]);
    }
    //create event
    public function manageEvent(Request $request)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $country = Country::where('iso3',$user->countryCode)->first();

        $events = UserEvent::where('user',$user->id)->orderBy('status')->orderBy('updated_at','desc')->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.users.events.components.merchant_event_list', compact('events'))->render(),
                'nextPage' => $events->currentPage() + 1,
                'hasMorePages' => $events->hasMorePages()
            ]);
        }

        return view('mobile.users.events.manage')->with([
            'pageName'  =>'Manage Events',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>$user,
            'country'   =>$country,
            'events'    =>$events
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
            'intervals' =>EventInterval::where('status',1)->get(),
            'countries'=>Country::where('status',1)->get(),
            'fiats'=>Fiat::where('status',1)->get()
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
            'intervals' =>EventInterval::where('status',1)->get(),
            'countries'=>Country::where('status',1)->get(),
            'fiats'=>Fiat::where('status',1)->get()
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
                'country'=>['required','alpha',Rule::exists('countries','iso2')],
                'state'=>['required','alpha',Rule::exists('states','iso2')->where('country_code',$request->country)],
                'location'=>['required','string','max:1000'],
                'category'=>['required','integer','exists:event_categories,id'],
                'scheduleType'=>['required','integer','in:1,2'],
                'timezone' => ['required','string','timezone'],
                'startDateOnetime' => ['required','date','after_or_equal:today'],
                'startTimeOnetime' => ['required','date_format:H:i'],
                'endDateOnetime' => ['required_if:scheduleType,1','nullable', 'date','after_or_equal:startDateOnetime'],
                'endTimeOnetime' => ['required_if:scheduleType,1','nullable','date_format:H:i'],
                'frequency' => ['required_if:scheduleType,2','nullable','integer','exists:event_intervals,id'],
                'interval' => ['required_if:scheduleType,2','nullable','integer'],
                'recurrenceEndType' => ['required_if:scheduleType,2','nullable','integer'],
                'endDateRecur' => ['required_if:recurrenceEndType,1','nullable','date','after_or_equal:startDateRecur'],
                'endTimeRecur' => ['required_if:recurrenceEndType,1','nullable','date_format:H:i'],
                'numberOfOccurrence' => ['required_if:recurrenceEndType,2','nullable','integer'],
                'facebook' => ['nullable','url'],
                'twitter' => ['nullable','url'],
                'instagram' => ['nullable','url'],
                'website' => ['nullable','url'],
                'supportEmail'=>['required','email'],
                'currency' => ['required', 'string', 'max:3', Rule::exists('fiats', 'code')],
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
                'eventFrequency' => $input['frequency'], 'startTime' => $input['startTimeOnetime'],
                'endTime' =>($input['scheduleType']==1)?$input['endTimeOnetime']:'',
                'recurrenceInterval'=>($input['scheduleType']!=1)?$interval:'', 'recurrenceEndType'=>($input['scheduleType']!=1)?$input['recurrenceEndType']:'',
                'recurrenceEndCount'=>($input['scheduleType']!=1 && $input['recurrenceEndType']!=1)?$input['numberOfOccurrence']:'',
                'recurrenceEndDate'=>($input['scheduleType']!=1 && $input['recurrenceEndType']==1)?$input['endDateRecur']:'',
                'recurrenceEndTime'=>($input['scheduleType']!=1 && $input['recurrenceEndType']==1)?$input['endTimeRecur']:'',
                'state'=>$input['state'],'location'=>$input['location'],'featuredImage'=>$featuredPhoto,
                'instagram'=>$input['instagram'],'facebook'=>$input['facebook'],'twitter'=>$input['twitter'],
                'website'=>$input['website'],'supportEmail'=>$input['supportEmail'],'country'=>$input['country'],
                'currency'=>$input['currency']
            ]);

            if (!empty($event)){
                DB::commit();
                $this->userNotification($user,'Event Created','Your event was created successfully and is pending review',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.events.tickets.index',['event'=>$event->reference]),
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
        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();

            $validator = Validator::make($request->all(),[
                'title'=>['required','string','max:200'],
                'description'=>['required','string'],
                'featuredPhoto'=>['required','image','max:2048'],
                'organizer'=>['required','string','max:200'],
                'country'=>['required','alpha',Rule::exists('countries','iso2')],
                'state'=>['required','alpha',Rule::exists('states','iso2')->where('country_code',$request->country)],
                'category'=>['required','integer','exists:event_categories,id'],
                'scheduleType'=>['required','integer','in:1,2'],
                'timezone' => ['required','string','timezone'],
                'startDateOnetime' => ['required','date','after_or_equal:today'],
                'startTimeOnetime' => ['required','date_format:H:i'],
                'endDateOnetime' => ['required_if:scheduleType,1','nullable', 'date','after_or_equal::startDateOnetime'],
                'endTimeOnetime' => ['required_if:scheduleType,1','nullable','date_format:H:i'],
                'frequency' => ['required_if:scheduleType,2','nullable','integer','exists:event_intervals,id'],
                'interval' => ['required_if:scheduleType,2','nullable','integer'],
                'recurrenceEndType' => ['required_if:scheduleType,2','nullable','integer'],
                'endDateRecur' => ['required_if:recurrenceEndType,1','nullable','date','after_or_equal:startDateRecur'],
                'endTimeRecur' => ['required_if:recurrenceEndType,1','nullable','date_format:H:i'],
                'numberOfOccurrence' => ['required_if:recurrenceEndType,2','nullable','integer'],
                'facebook' => ['nullable','url'],
                'twitter' => ['nullable','url'],
                'instagram' => ['nullable','url'],
                'website' => ['nullable','url'],
                'platform'=>['required',function ($attribute, $value, $fail) {
                    if (!EventPlatform::isValid($value)) {
                        $fail('The selected platform is invalid.');
                    }
                }],
                'link'=>['required','url'],
                'supportEmail'=>['required','email'],
                'currency' => ['required', 'string', 'max:3', Rule::exists('fiats', 'code')],
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
                'reference' => $reference, 'user' => $user->id, 'eventType' => 2,
                'title' => $input['title'], 'description' => $input['description'],
                'hideVenue' => $request->filled('hideVenue')?1:2, 'category' => $input['category'],
                'eventScheduleType' => $input['scheduleType'], 'startDate' => $input['startDateOnetime'],
                'endDate' => ($input['scheduleType']==1)?$input['endDateOnetime']:'', 'eventTimeZone' => $input['timezone'],
                'eventFrequency' => $input['frequency'], 'startTime' => $input['startTimeOnetime'],
                'endTime' =>($input['scheduleType']==1)?$input['endTimeOnetime']:'',
                'recurrenceInterval'=>($input['scheduleType']!=1)?$interval:'', 'recurrenceEndType'=>($input['scheduleType']!=1)?$input['recurrenceEndType']:'',
                'recurrenceEndCount'=>($input['scheduleType']!=1 && $input['recurrenceEndType']!=1)?$input['numberOfOccurrence']:'',
                'recurrenceEndDate'=>($input['scheduleType']!=1 && $input['recurrenceEndType']==1)?$input['endDateRecur']:'',
                'recurrenceEndTime'=>($input['scheduleType']!=1 && $input['recurrenceEndType']==1)?$input['endTimeRecur']:'',
                'featuredImage'=>$featuredPhoto, 'instagram'=>$input['instagram'],'facebook'=>$input['facebook'],
                'twitter'=>$input['twitter'], 'website'=>$input['website'],'platform' => $input['platform'],'link' => $input['link'],
                'organizer'=>$input['organizer'],'supportEmail'=>$input['supportEmail'],'state' => $input['state'],'country'=>$input['country'],
                'currency'=>$input['currency']
            ]);

            if (!empty($event)){
                DB::commit();
                $this->userNotification($user,'Event Created','Your event was created successfully and is pending review',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.events.tickets.index',['event'=>$event->reference]),
                    'redirects'=>true
                ],'Event created successful. Redirecting to add tickets ...');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while adding new online event: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
