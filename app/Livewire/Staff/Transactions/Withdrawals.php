<?php

namespace App\Livewire\Staff\Transactions;

use App\Models\Fiat;
use App\Models\UserWithdrawal;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Withdrawals extends Component
{
    use WithPagination;
    #[Url]
    public $search = '';
    #[Url]
    public $perPage = 10;
    #[Url]
    public $status = 'all';
    #[Url]
    public $duration = 'today';
    #[Url]
    public $customStartDate;
    #[Url]
    public $customEndDate;
    #[Url]
    public $targetCurrency = "USD";
    public $availableCurrencies=[];

    public $UserWithdrawals;
    public $totalwithdrawal;

    protected $queryString = ['search', 'status', 'duration', 'customStartDate', 'customEndDate'];

    public function mount()
    {
        $userWithdrawals= UserWithdrawal::where('status','!=',3)->get();
        $this->calculateTotalwithdrawal($userWithdrawals);
        $this->availableCurrencies = Fiat::where('status',1)->pluck('code')->toArray();
    }

    public function updatedTargetCurrency()
    {
        $userWithdrawals= UserWithdrawal::where('status','!=',3)->get();
        $this->calculateTotalwithdrawal($userWithdrawals);
    }

    protected function calculateTotalwithdrawal($withdrawals)
    {
        $this->totalwithdrawal = 0;

        foreach ($withdrawals as $withdrawal) {
            $converted = $withdrawal->convertToCurrency($withdrawal->amount, $this->targetCurrency);

            if ($converted !== null) {
                $this->totalwithdrawal += $converted;
            }
        }

        $this->totalwithdrawal = number_format($this->totalwithdrawal, 2);
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
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingDuration()
    {
        $this->resetPage();
    }

    private function getDateRange()
    {
        $now = Carbon::now();

        switch ($this->duration) {
            case 'today':
                return [$now->copy()->startOfDay(), $now->copy()->endOfDay()];
            case 'week':
                return [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()];
            case 'year':
                return [$now->copy()->startOfYear(), $now->copy()->endOfYear()];
            case 'custom':
                return [Carbon::parse($this->customStartDate), Carbon::parse($this->customEndDate)];
            default:
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
        }
    }

    public function render()
    {

        [$startDate, $endDate] = $this->getDateRange();

        $newWithdrawal = UserWithdrawal::where('status',2)->whereBetween('created_at', [$startDate, $endDate])->count();
        $newCompletedWithdrawal = UserWithdrawal::where('status', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $newFailedWithdrawal = UserWithdrawal::where('status', 3)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Assuming "previous period" means the same length of time immediately before the selected period
        $previousStartDate = $startDate->copy()->subDays($startDate->diffInDays($endDate) + 1);
        $previousEndDate = $endDate->copy()->subDays($startDate->diffInDays($endDate) + 1);

        $newWithdrawalPreviousPeriod = UserWithdrawal::where('status',2)
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();
        $newCompletedWithdrawalPreviousPeriod = UserWithdrawal::where('status', 1)
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();
        $newFailedWithdrawalPreviousPeriod = UserWithdrawal::where('status', 3)
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        $newWithdrawalIncrease = $newWithdrawal - $newWithdrawalPreviousPeriod;
        $completedWithdrawalIncrease = $newCompletedWithdrawal - $newCompletedWithdrawalPreviousPeriod;
        $failedWithdrawalIncrease = $newFailedWithdrawal - $newFailedWithdrawalPreviousPeriod;

        $withdrawals = UserWithdrawal::query()
            ->when($this->search, function($query) {
                $query->where('paymentReference', 'like', '%' . $this->search . '%')
                    ->orWhere('reference', 'like', '%' . $this->search . '%')
                    ->orWhere('transactionId', 'like', '%' . $this->search . '%')
                    ->orWhere('orderReference', 'like', '%' . $this->search . '%');
            })
            ->when($this->status != 'all', function($query) {
                $query->where('status', $this->status);
            })->with('users')->latest()
            ->paginate(10);


        return view('livewire.staff.transactions.withdrawals',[
            'totalwithdrawalCount' => UserWithdrawal::where('status','!=',3)->count(),
            'withdrawals' => $withdrawals,
            'pendingWithdrawalIncrease' => $newWithdrawalIncrease,
            'completedWithdrawalIncrease' => $completedWithdrawalIncrease,
            'failedWithdrawalIncrease' => $failedWithdrawalIncrease,
            'failedwithdrawalsCount' => UserWithdrawal::where('status',3)->count(),
            'completedWithdrawalsCount' => UserWithdrawal::where('status',1)->count(),
            'pendingWithdrawalCount' => UserWithdrawal::where('status',2)->count(),
        ]);
    }
}
