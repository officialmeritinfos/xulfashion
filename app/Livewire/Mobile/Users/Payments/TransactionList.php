<?php

namespace App\Livewire\Mobile\Users\Payments;

use App\Models\Transaction;
use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionList extends Component
{
    use WithPagination;
    #[Url]
    public $search;
    #[Url]
    public $perPage = 5;
    #[Url]
    public $status='all';
    #[Locked]
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
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

        $transactions = Transaction::where('user', $this->user->id)
            ->when($this->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('reference', 'like', "%{$search}%")
                        ->orWhere('withdrawalRef', 'like', "%{$search}%");
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('id', 'desc')
            ->simplePaginate($this->perPage);

        return view('livewire.mobile.users.payments.transaction-list',[
            'transactions'=>$transactions
        ]);
    }
}
