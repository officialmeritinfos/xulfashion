<?php

namespace App\Livewire\Mobile\Users\Events;

use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventSettlement;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SalesAnalytics extends Component
{
    use WithPagination;
    public $user;
    public $event;
    #[Url]
    public $salesPerPage = 10;
    #[Url]
    public $salesSearch;
    #[Url]
    public $search;
    #[Url]
    public $perPage=5;

    public function mount(User $user, UserEvent $event)
    {
        $this->user = $user;
        $this->event = $event;
    }
    public function render()
    {
        $purchases = UserEventPurchase::where('event_id', $this->event->id)
            ->when($this->salesSearch, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('reference', 'like', "%{$search}%")
                        ->orWhere('paymentReference', 'like', "%{$search}%")
                        ->orWhere('paymentId', 'like', "%{$search}%");
                });
            })
            ->with(['events', 'tickets'])
            ->simplePaginate($this->salesPerPage);


        $settlements = UserEventSettlement::where([
            'user' => $this->user->id,'event' => $this->event->id,
        ])->when($this->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('reference', 'like', "%{$search}%")
                        ->orWhere('transactionId', 'like', "%{$search}%");
                });
            })->with('banks')->simplePaginate($this->perPage,'*','settlements');


        return view('livewire.mobile.users.events.sales-analytics',[
            'purchases' => $purchases,
            'settlements' => $settlements
        ]);
    }
}
