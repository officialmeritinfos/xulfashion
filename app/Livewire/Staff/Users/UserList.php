<?php

namespace App\Livewire\Staff\Users;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;
    #[Url]
    public $search = '';
    public $status = 'all';
    public $duration = 'month'; // default duration
    public $customStartDate;
    public $customEndDate;

    protected $queryString = ['search', 'status', 'duration', 'customStartDate', 'customEndDate'];

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
        $activeUsersCount = User::where('status', 1)->count();
        $inactiveUsersCount = User::where('status', '!=', 1)->count();

        [$startDate, $endDate] = $this->getDateRange();

        $newUsersThisPeriod = User::whereBetween('created_at', [$startDate, $endDate])->count();
        $newActiveUsersThisPeriod = User::where('status', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $newInactiveUsersThisPeriod = User::where('status', '!=', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Assuming "previous period" means the same length of time immediately before the selected period
        $previousStartDate = $startDate->copy()->subDays($startDate->diffInDays($endDate) + 1);
        $previousEndDate = $endDate->copy()->subDays($startDate->diffInDays($endDate) + 1);

        $newUsersPreviousPeriod = User::whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();
        $newActiveUsersPreviousPeriod = User::where('status', 1)
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        $newInactiveUsersPreviousPeriod = User::where('status', '!=', 1)
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        $newUsersIncrease = $newUsersThisPeriod - $newUsersPreviousPeriod;
        $activeUsersIncrease = $newActiveUsersThisPeriod - $newActiveUsersPreviousPeriod;
        $inactiveUsersIncrease = $newInactiveUsersThisPeriod - $newInactiveUsersPreviousPeriod;

        $users = User::query()
            ->when($this->search, function($query) {
                $query->where('email', 'like', '%' . $this->search . '%')
                      ->orWhere('reference', 'like', '%' . $this->search . '%');
            })
            ->when($this->status != 'all', function($query) {
                $query->where('status', $this->status);
            })->latest()
            ->paginate(10);

        $staff = Auth::guard('staff')->user();

        return view('livewire.staff.users.user-list', [
            'users' => $users,
            'activeUsersCount' => $activeUsersCount,
            'inactiveUsersCount' => $inactiveUsersCount,
            'newUsersThisPeriod' => $newUsersThisPeriod,
            'newUsersIncrease' => $newUsersIncrease,
            'activeUsersIncrease' => $activeUsersIncrease,
            'inactiveUsersIncrease' => $inactiveUsersIncrease,
            'staff' => $staff
        ]);
    }
}
