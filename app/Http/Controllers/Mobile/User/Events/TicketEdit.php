<?php

namespace App\Http\Controllers\Mobile\User\Events;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\UserEvent;
use App\Models\UserEventTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TicketEdit extends BaseController
{
    //landing page
    public function landingPage(Request $request,$ticketId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $ticket = UserEventTicket::where([
            'reference' => $ticketId,
        ])->firstOrFail();

        $event = UserEvent::where([
            'id' => $ticket->event_id,
            'user' => $user->id
        ])->firstOrFail();

        $country = Country::where('iso3',$user->countryCode)->first();

        return view('mobile.users.events.tickets.edit')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>"Edit Ticket",
            'event' => $event,
            'country' => $country,
            'type' => $request->type,
            'fiats'=>Fiat::where('status',1)->get(),
            'ticket'=>$ticket
        ]);
    }
    //process group ticket edit
    public function processGroupTicketUpdate(Request $request,$eventId,$ticketId)
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
            $ticket = UserEventTicket::where([
                'event_id' => $event->id,
                'reference' => $ticketId,
            ])->first();

            if (empty($ticket)){
                return $this->sendError('ticket.error',['error'=>'Ticket not found']);
            }

            $validator = Validator::make($request->all(),[
                'ticketKind'=>['required','integer','in:1,2'],
                'title'=>['required','string','max:200',Rule::unique('user_event_tickets','name')->where('event_id',$event->id)->ignore($ticket->id)],
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

            $updated = UserEventTicket::where('id',$ticket->id)->update([
                'event_id' => $event->id,'name'=>$input['title'],'description'=>$input['description'],
                'kindOfTicket' => $input['ticketKind'], 'isGroup' => 2,
                'currency'=>($input['ticketKind']!=1)?$input['currency']:'','price'=>($input['ticketKind']!=1)?$input['groupPrice']/$input['groupSize']:'',
                'isFree' => ($input['ticketKind']==1)?1:2, 'inviteOnly' => $request->has('inviteOnly')?1:2,
                'quantity' => ($input['stock']==1)?$input['quantity']:0,'unlimited' => ($input['stock']!=1)?1:2,
                'purchaseLimit' => $input['purchaseLimit'],'guestsShouldPayFee'=>($input['ticketKind']==2 && $request->has('transferFee'))?1:2,
                'ticketType' => 'group','perks' => ($request->has('perks'))?implode(',',$input['perks']):'',
                'groupSize' => $input['groupSize'],'groupPrice'=>($input['ticketKind']!=1)?$input['groupPrice']:''
            ]);
            if ($updated){
                DB::commit();
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.events.tickets.index',['event'=>$event->reference]),
                    'redirects'=>true
                ],'Ticked successfully updated.');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while updating group ticket: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //process single ticket edit
    public function processSingleTicketUpdate(Request $request,$eventId,$ticketId)
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
            $ticket = UserEventTicket::where([
                'event_id' => $event->id,
                'reference' => $ticketId,
            ])->first();

            if (empty($ticket)){
                return $this->sendError('ticket.error',['error'=>'Ticket not found']);
            }

            $validator = Validator::make($request->all(),[
                'ticketKind'=>['required','integer','in:1,2'],
                'title'=>['required','string','max:200',Rule::unique('user_event_tickets','name')->where('event_id',$event->id)->ignore($ticket->id)],
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

            $updated = UserEventTicket::where('id',$ticket->id)->update([
                'event_id' => $event->id,'name'=>$input['title'],'description'=>$input['description'],
                'kindOfTicket' => $input['ticketKind'], 'isGroup' => 2,
                'currency'=>($input['ticketKind']!=1)?$input['currency']:'','price'=>($input['ticketKind']!=1)?$input['price']:'',
                'isFree' => ($input['ticketKind']==1)?1:2, 'inviteOnly' => $request->has('inviteOnly')?1:2,
                'quantity' => ($input['stock']==1)?$input['quantity']:0,'unlimited' => ($input['stock']!=1)?1:2,
                'purchaseLimit' => $input['purchaseLimit'],'guestsShouldPayFee'=>($input['ticketKind']==2 && $request->has('transferFee'))?1:2,
                'ticketType' => 'single','perks' => ($request->has('perks'))?implode(',',$input['perks']):'',
            ]);
            if ($updated){
                DB::commit();
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.events.tickets.index',['event'=>$event->reference]),
                    'redirects'=>true
                ],'Ticked successfully updated.');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while updating single ticket: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
