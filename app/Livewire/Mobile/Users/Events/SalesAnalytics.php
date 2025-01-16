<?php

namespace App\Livewire\Mobile\Users\Events;

use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventSettlement;
use App\Models\UserWithdrawal;
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

    public $settlementDetail = null;

    public function mount(User $user, UserEvent $event)
    {
        $this->user = $user;
        $this->event = $event;
    }
    public function placeholder()
    {
        return <<<'HTML'
        <div>
        <svg width="100%" height="100%" viewBox="0 0 500 200" preserveAspectRatio="none">
            <defs>
                <linearGradient id="table-skeleton-gradient">
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

            <!-- Table Header -->
            <rect x="10" y="10" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="10" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 1 -->
            <rect x="10" y="40" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="40" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 2 -->
            <rect x="10" y="70" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="70" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 3 -->
            <rect x="10" y="100" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="100" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
        </svg>

        </div>
        HTML;
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
    public function viewDetails($reference)
    {
        $this->settlementDetail = UserEventSettlement::where('reference', $reference)
            ->where('user', $this->user->id)
            ->first();
    }
}
