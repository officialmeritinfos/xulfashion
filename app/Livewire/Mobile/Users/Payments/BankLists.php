<?php

namespace App\Livewire\Mobile\Users\Payments;

use App\Models\UserBank;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BankLists extends Component
{
    use WithPagination;

    public $user;
    public $numberPerPage = 10;
    public $bankId;

    #[Url]
    public $search;

    public function mount($user)
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
        $banks =  UserBank::where('user', $this->user->id)
            ->when($this->search, function ($query, $search) {
                $query->where('bankName', 'like', "%{$search}%")
                    ->orWhere('accountNumber', 'like', "%{$search}%")
                    ->orWhere('accountName', 'like', "%{$search}%");
            })
            ->orderBy('isPrimary','asc')
            ->paginate($this->numberPerPage);
        return view('livewire.mobile.users.payments.bank-lists',[
            'banks' => $banks,
        ]);
    }
}
