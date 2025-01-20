<?php

namespace App\Livewire\Staff\Events;

use App\Models\Country;
use App\Models\SystemStaffAction;
use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventSettlement;
use App\Models\UserEventTicket;
use App\Notifications\CustomNotificationNoLink;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Details extends Component
{
    use WithPagination, LivewireAlert,WithFileUploads;

    public $user;
    public $userId;
    public $eventId;
    public $event;
    public $accountPin;
    public $showApproveForm=false;
    public $showRejectForm=false;
    public $showEditFeaturedImage=false;
    public $rejectReason;
    #[Url]
    public $ticketShow=5;
    #[Url]
    public $ticketStatus='all';
    #[Url]
    public $settlementShow=5;
    #[Url]
    public $settlementStatus='all';
    #[Url]
    public $purchaseShow=5;
    #[Url]
    public $purchaseStatus='all';


    public function mount($eventId)
    {
        $this->eventId = $eventId;

        $this->event = UserEvent::where([
            'id'=>$this->eventId
        ])->first();

        $this->user = User::where([
            'id'=>$this->event->user
        ])->first();
    }
    //toggle show approve form
    public function toggleShowApproveForm()
    {
        $this->showApproveForm = !$this->showApproveForm;
        if ($this->showRejectForm){
            $this->showRejectForm=false;
        }
    }

    //toggle show reject form
    public function toggleShowRejectForm()
    {
        $this->showRejectForm = !$this->showRejectForm;
        if ($this->showApproveForm){
            $this->showApproveForm=false;
        }
    }

    public function render()
    {
        $tickets = UserEventTicket::query()
            ->when($this->ticketStatus != 'all', function ($query) {
                $query->where('status', $this->ticketStatus);
            })->with(['events','purchaseTickets'])->where('event_id', $this->event->id) ->paginate($this->ticketShow,'*','tickets');

        $settlements = UserEventSettlement::query()
            ->when($this->settlementStatus != 'all', function ($query) {
                $query->where('status', $this->settlementStatus);
            })->with('banks')->where('event', $this->event->id)->orderBy('created_at','desc')->paginate($this->settlementShow,'*','settlements');

        $purchases = UserEventPurchase::query()
            ->when($this->purchaseStatus != 'all', function ($query) {
                $query->where('status', $this->purchaseStatus);
            })->with(['events','tickets','buyers'])->where('event_id', $this->event->id)
            ->orderBy('created_at','desc')->paginate($this->purchaseShow,'*','purcahses');

        $country = Country::where('iso3',$this->user->countryCode)->first();
        return view('livewire.staff.events.details',[
            'event'=>$this->event,
            'user'=>$this->user,
            'ticketSold'=>UserEventTicket::where(['event_id' => $this->event->id,])->sum('ticketSold'),
            'tickets'=>$tickets,
            'settlements'=>$settlements,
            'purchases'=>$purchases,
            'country' =>$country,
            'staff' => Auth::guard('staff')->user()
        ]);
    }

    //submit approve ad
    public function submitApprove()
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('update UserEvent')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have the clearance ti perform this action',
                'width' => '400',
            ]);
        }

        $this->validate([
            'accountPin' =>'required|string|max:6|min:6',
        ]);

        try {
            $hashed = Hash::check($this->accountPin, $staff->accountPin);
            if (!$hashed) {
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Access Denied. Wrong authorization pin',
                    'width' => '400',
                ]);
                return;
            }
            //begin transaction
            DB::beginTransaction();

            $merchant = User::where('reference',$this->user->reference)->first();

            $event = UserEvent::where([
                'id'=>$this->event->id,'user'=>$merchant->id
            ])->first();

            //check if it had been approved already
            if ($event->status==1){
                $this->alert('warning', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Event already approved.',
                    'width' => '400',
                ]);
                return;
            }

            $dataUpdate = [
                'status'=>1,
                'reason'=>$this->rejectReason,
                'approvedBy'=>$staff->id,
            ];

            $message = "
                Your Event, <b>".$this->event->title."</b> with ID <b>".$this->event->reference."</b> has been approved
                and is active on the platform.
            ";
            $event->update($dataUpdate);

            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Approved Event',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->event),
                'model_id' => $this->event->reference,
            ]);
            scheduleUserNotification($merchant->id,'Event approved','Your Event, '.$this->event->title.' has been approved and is now active.',
                route('mobile.user.events.detail',['event'=>$this->event->reference]));
            DB::commit();
            $merchant->notify(new CustomNotificationNoLink($merchant->name,'Event approved',$message));
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Event posting approved.',
                'width' => '400',
            ]);
            $this->dispatch('renderAd');
            $this->showRejectForm=false;
            $this->showApproveForm=false;
            $this->reset(['accountPin','rejectReason']);

            return;

        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while approving merchant event.',
                'width' => '400',
            ]);
            Log::error('Error approving merchant event: ' . $exception->getMessage());
        }

    }
    //submit reject ad
    public function submitReject()
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('update UserEvent')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have the clearance to perform this action',
                'width' => '400',
            ]);
        }

        $this->validate([
            'accountPin' =>'required|string|max:6|min:6',
            'rejectReason'=>['required','string'],
        ]);

        try {
            $hashed = Hash::check($this->accountPin, $staff->accountPin);
            if (!$hashed) {
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Access Denied. Wrong authorization pin',
                    'width' => '400',
                ]);
                return;
            }
            //begin transaction
            DB::beginTransaction();

            $merchant = User::where('reference',$this->user->reference)->first();

            $event = UserEvent::where([
                'id'=>$this->event->id,'user'=>$merchant->id
            ])->first();

            //check if it had been approved already
            if ($event->status==4){
                $this->alert('warning', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Event already rejected.',
                    'width' => '400',
                ]);
                return;
            }

            $dataUpdate = [
                'status'=>4,
                'reason'=>$this->rejectReason,
                'approvedBy'=>$staff->id
            ];

            $message = "
                Your Event, <b>".$this->event->title."</b> with ID <b>".$this->event->reference."</b> has been disproved
                for the reason below:<hr/>
                <p>$this->rejectReason</p>
            ";
            $event->update($dataUpdate);

            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Disproved Event Submission',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->event),
                'model_id' => $this->event->reference,
            ]);
            scheduleUserNotification($merchant->id,'Event Rejected','Your Event, '.$this->event->title.' has been rejected. Please check your mail for the reason.',
                route('mobile.user.events.detail',['event'=>$this->event->reference]));
            DB::commit();
            $merchant->notify(new CustomNotificationNoLink($merchant->name,'Event post rejected',$message));
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Event posting rejected.',
                'width' => '400',
            ]);
            $this->dispatch('renderAd');
            $this->showRejectForm=false;
            $this->showApproveForm=false;
            $this->reset(['accountPin','rejectReason']);

            return;

        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while disproving merchant event.',
                'width' => '400',
            ]);
            Log::error('Error disproving merchant event: ' . $exception->getMessage());
        }

    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
           <svg width="100%" height="400px" viewBox="0 0 400 400" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="skeleton-gradient">
                        <stop offset="0%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="50%" stop-color="#e0e0e0">
                            <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="100%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                    </linearGradient>
                </defs>

                <!-- Card Placeholder 1 -->
                <rect x="10" y="10" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="25" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="55" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="75" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 2 -->
                <rect x="10" y="130" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="145" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="175" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="195" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 3 -->
                <rect x="10" y="250" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="265" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="295" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="315" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />
            </svg>
        </div>
        HTML;
    }
}
