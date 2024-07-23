<?php

namespace App\Livewire\Staff;

use App\Models\SystemStaffAction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class StaffActivity extends Component
{
    use WithPagination;

    public $staff;

    public $show = 10;

    public function mount()
    {
        $this->staff = Auth::guard('staff')->user();
    }

    public function render()
    {
        $activities = SystemStaffAction::query()
            ->when($this->staff->role !='superadmin', function ($query) {
                $query->where('staff', $this->staff->id);
            })
            ->latest()
            ->paginate($this->show);
        return view('livewire.staff.staff-activity',[
            'activities'=>$activities
        ]);
    }
}
