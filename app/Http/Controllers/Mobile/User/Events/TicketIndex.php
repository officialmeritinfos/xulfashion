<?php

namespace App\Http\Controllers\Mobile\User\Events;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\UserEvent;
use App\Models\UserEventTicket;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TicketIndex extends BaseController
{
    use Helpers;
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

        return view('mobile.users.events.tickets.index')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>"Tickets: ".$event->title,
            'event' => $event,
            'country' => $country,
            'tickets' => UserEventTicket::where([
                'event_id' => $event->id,
            ])->paginate(15)
        ]);
    }
    //create ticket for event
    public function createTicket(Request $request, $eventId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $country = Country::where('iso3',$user->countryCode)->first();

        $event = UserEvent::where([
            'reference' => $eventId,
            'user' => $user->id
        ])->firstOrFail();

        if (!$request->has('type')){
            return back()->with('error','Please select a supported ticket type');
        }

        return view('mobile.users.events.tickets.new')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>"Create New ".ucfirst($request->type)." Ticket",
            'event' => $event,
            'country' => $country,
            'type' => $request->type,
            'fiats'=>Fiat::where('status',1)->get()
        ]);
    }
    //process single ticket creation
    public function processSingleTicketCreation(Request $request, $eventId)
    {
        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();

            $event = UserEvent::where([
                'reference' => $eventId,
                'user' => $user->id
            ])->first();
            if (empty($event)){
                return $this->sendError('event.error',['error'=>'Event not found']);
            }

            $validator = Validator::make($request->all(),[
                'ticketKind'=>['required','integer','in:1,2'],
                'title'=>['required','string','max:200',Rule::unique('user_event_tickets','name')->where('event_id',$event->id)],
                'description'=>['required','string'],
                'inviteOnly'=>['nullable','string'],
                'stock'=>['required','integer','in:1,2'],
                'quantity'=>['required_if:stock,1','nullable','integer','min:1'],
                'purchaseLimit'=>['required','integer','min:1'],
                'perks'=>['nullable','array'],
                'perks.*'=>['required','string','max:150'],
                'transferFee'=>['nullable','string'],
                'currency'=>['required_if:ticketKind,2','string','max:3',Rule::exists('fiats','code')],
                'price'=>['required_if:ticketKind,2','nullable', 'numeric']
            ],[],[
                'ticketKind'=>'Kind of Ticket',
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();
            $reference = $this->generateUniqueReference('user_event_tickets','reference',7);

            $ticket = UserEventTicket::create([
                'event_id' => $event->id,'name'=>$input['title'],'description'=>$input['description'],
                'kindOfTicket' => $input['ticketKind'], 'isGroup' => 2,
                'currency'=>($input['ticketKind']!=1)?$input['currency']:'','price'=>($input['ticketKind']!=1)?$input['price']:'',
                'isFree' => ($input['ticketKind']==1)?1:2, 'inviteOnly' => $request->has('inviteOnly')?1:2,
                'quantity' => ($input['stock']==1)?$input['quantity']:0,'unlimited' => ($input['stock']!=1)?1:2,
                'purchaseLimit' => $input['purchaseLimit'],'guestsShouldPayFee'=>($input['ticketKind']==2 && $request->has('transferFee'))?1:2,
                'ticketType' => 'single','perks' => ($request->has('perks'))?implode(',',$input['perks']):'',
                'reference'=>$reference
            ]);
            if (!empty($ticket)){
                DB::commit();
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.events.tickets.index',['event'=>$event->reference]),
                    'redirects'=>true
                ],'Ticked successfully added.');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while adding new single ticket: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //process group ticket creation
    public function processGroupTicketCreation(Request $request, $eventId)
    {
        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();

            $event = UserEvent::where([
                'reference' => $eventId,
                'user' => $user->id
            ])->first();
            if (empty($event)){
                return $this->sendError('event.error',['error'=>'Event not found']);
            }

            $validator = Validator::make($request->all(),[
                'ticketKind'=>['required','integer','in:1,2'],
                'title'=>['required','string','max:200',Rule::unique('user_event_tickets','name')->where('event_id',$event->id)],
                'description'=>['required','string'],
                'inviteOnly'=>['nullable','string'],
                'stock'=>['required','integer','in:1,2'],
                'quantity'=>['required_if:stock,1','nullable','integer','min:1'],
                'purchaseLimit'=>['required','integer','min:1'],
                'perks'=>['nullable','array'],
                'perks.*'=>['required','string','max:150'],
                'transferFee'=>['nullable','string'],
                'currency'=>['required_if:ticketKind,2','string','max:3',Rule::exists('fiats','code')],
                'price'=>['required_if:ticketKind,2','nullable', 'numeric'],
                'groupSize'=>['required','integer','min:2'],
                'groupPrice'=>['required_if:ticketKind,2','nullable', 'numeric'],
            ],[],[
                'ticketKind'=>'Kind of Ticket',
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();
            $reference = $this->generateUniqueReference('user_event_tickets','reference',7);

            $ticket = UserEventTicket::create([
                'event_id' => $event->id,'name'=>$input['title'],'description'=>$input['description'],
                'kindOfTicket' => $input['ticketKind'], 'isGroup' => 2,
                'currency'=>($input['ticketKind']!=1)?$input['currency']:'','price'=>($input['ticketKind']!=1)?$input['groupPrice']/$input['groupSize']:'',
                'isFree' => ($input['ticketKind']==1)?1:2, 'inviteOnly' => $request->has('inviteOnly')?1:2,
                'quantity' => ($input['stock']==1)?$input['quantity']:0,'unlimited' => ($input['stock']!=1)?1:2,
                'purchaseLimit' => $input['purchaseLimit'],'guestsShouldPayFee'=>($input['ticketKind']==2 && $request->has('transferFee'))?1:2,
                'ticketType' => 'group','perks' => ($request->has('perks'))?implode(',',$input['perks']):'',
                'reference'=>$reference,'groupSize' => $input['groupSize'],'groupPrice'=>($input['ticketKind']!=1)?$input['groupPrice']:''
            ]);
            if (!empty($ticket)){
                DB::commit();
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.events.tickets.index',['event'=>$event->reference]),
                    'redirects'=>true
                ],'Ticked successfully added.');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while adding new group ticket: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }

    //delete ticket
    public function deleteTicket(Request $request, $eventId)
    {
        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3', $user->countryCode)->first();

            $event = UserEvent::where([
                'reference' => $eventId,
                'user' => $user->id
            ])->first();
            if (empty($event)) {
                return $this->sendError('event.error', ['error' => 'Event not found']);
            }

            $validator = Validator::make($request->all(), [
                'ticketId' => ['required', Rule::exists('user_event_tickets','id')->where('event_id',$event->id)],
            ], [], [
                'ticketId' => 'Ticket Id',
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            $ticket = UserEventTicket::where('id',$input['ticketId'])->first();
            $ticket->delete();
            DB::commit();

            return $this->sendResponse([
                'redirectTo'=>url()->previous(),
                'redirects'=>true
            ],'Ticked deleted.');

        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while deleting ticket: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }


}