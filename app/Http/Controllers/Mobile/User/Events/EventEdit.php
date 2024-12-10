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
use App\Models\State;
use App\Models\UserEvent;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventEdit extends BaseController
{
    public $google;
    use Helpers;
    public function __construct()
    {
        $this->google = new GoogleUpload();
    }
    //edit event
    public function landingPage(Request $request, $eventId)
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
            'intervals' =>EventInterval::where('status',1)->get(),
            'countries'=>Country::where('status',1)->get(),
            'fiats'=>Fiat::where('status',1)->get()
        ]);
    }

    //process edit live event
    public function processLiveEventUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();

            $validator = Validator::make($request->all(),[
                'title'=>['required','string','max:200'],
                'description'=>['required','string'],
                'featuredPhoto'=>['nullable','image','max:2048'],
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
                'endDateRecur' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('recurrenceEndType') == 1 && $request->input('scheduleType') != 1 && empty($value)) {
                            $fail('The end date for recurring events is required when the event schedule type is recurrent and end type is specific date.');
                        }
                    },
                    'nullable','date','after_or_equal:startDateRecur'
                ],
                'endTimeRecur' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('recurrenceEndType') == 1 && $request->input('scheduleType') != 1 && empty($value)) {
                            $fail('The end time for recurring events is required when the event schedule type is recurrent and end type is specific date.');
                        }
                    },
                    'nullable','date_format:H:i'
                ],
                'numberOfOccurrence' => ['required_if:recurrenceEndType,2','nullable','integer'],
                'facebook' => ['nullable','url'],
                'twitter' => ['nullable','url'],
                'instagram' => ['nullable','url'],
                'website' => ['nullable','url'],
                'event'=>['required','string',Rule::exists('user_events','reference')->where('user',$user->id)],
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
            $event = UserEvent::where([
                'user' => $user->id,
                'reference' => $input['event'],
            ])->first();

            if (empty($event)) {
                return $this->sendError('event.error',['error'=>'Event not found']);
            }

            $frequency = EventInterval::where('id',$input['frequency'])->first();
            if ($input['scheduleType']!=1){
                $interval = $input['interval'].' '.$frequency->period;
            }

            if ($request->hasFile('featuredPhoto')) {
                //lets upload the address proof
                $result = $this->google->uploadGoogle($request->file('featuredPhoto'));
                $featuredPhoto  = $result['link'];
            }else{
                $featuredPhoto = $event->featuredImage;
            }

            $updated = UserEvent::where('id',$event->id)->update([
                'title' => $input['title'], 'description' => clean($input['description']),
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

            if ($updated){
                DB::commit();
                $this->userNotification($user,'Event Created','Your event was updated successfully and has been sent for review',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.events.detail',['event'=>$event->reference]),
                    'redirects'=>true
                ],'Event updated successful. Redirecting to event page ...');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while updating live event: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //process edit online event
    public function processOnlineEventUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();

            $validator = Validator::make($request->all(),[
                'title'=>['required','string','max:200'],
                'description'=>['required','string'],
                'featuredPhoto'=>['nullable','image','max:2048'],
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
                'endDateRecur' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('recurrenceEndType') == 1 && $request->input('scheduleType') != 1 && empty($value)) {
                            $fail('The end date for recurring events is required when the event schedule type is recurrent and end type is specific date.');
                        }
                    },
                    'nullable','date','after_or_equal:startDateRecur'
                ],
                'endTimeRecur' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('recurrenceEndType') == 1 && $request->input('scheduleType') != 1 && empty($value)) {
                            $fail('The end time for recurring events is required when the event schedule type is recurrent and end type is specific date.');
                        }
                    },
                    'nullable','date_format:H:i'
                ],
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
                'event'=>['required','string',Rule::exists('user_events','reference')->where('user',$user->id)],
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

            $event = UserEvent::where([
                'user' => $user->id,
                'reference' => $input['event'],
            ])->first();

            if (empty($event)) {
                return $this->sendError('event.error',['error'=>'Event not found']);
            }

            $frequency = EventInterval::where('id',$input['frequency'])->first();
            if ($input['scheduleType']!=1){
                $interval = $input['interval'].' '.$frequency->period;
            }

            if ($request->hasFile('featuredPhoto')) {
                //lets upload the address proof
                $result = $this->google->uploadGoogle($request->file('featuredPhoto'));
                $featuredPhoto  = $result['link'];
            }else{
                $featuredPhoto = $event->featuredImage;
            }

            $updated = UserEvent::where('id',$event->id)->update([
                'title' => $input['title'], 'description' => clean($input['description']),
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

            if ($updated){
                DB::commit();
                $this->userNotification($user,'Event Updated','Your event was updated successfully and has been sent for review',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.events.detail',['event'=>$event->reference]),
                    'redirects'=>true
                ],'Event updated successful');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while updating online event: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
