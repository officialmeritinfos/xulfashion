<?php

namespace App\Livewire\Staff\Staffs;

use App\Models\GeneralSetting;
use App\Models\SystemStaff;
use App\Models\SystemStaffAction;
use App\Notifications\StaffWelcomeMail;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class StaffDetails extends Component
{
    use WithPagination,LivewireAlert;

    public $staffs;
    public $staff;
    public $web;
    public function mount(SystemStaff $staffs)
    {
        $this->staffs = $staffs;
        $this->staff = Auth::guard('staff')->user();
        $this->web = GeneralSetting::find(1);
    }
    public function render()
    {
        return view('livewire.staff.staffs.staff-details',[
            'activities' => SystemStaffAction::where('staff',$this->staffs->id)->paginate(10),
        ]);
    }
    //suspend user
    public function suspendUser()
    {
        $user = SystemStaff::where('id', $this->staffs->id)->first();
        $staff = $this->staff;


        if (!$staff->can('update SuperAdmin')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to suspend a staff.',
                'width' => '400',
            ]);
            return;
        }


        $user->update([
            'status' => 3
        ]);

        SystemStaffAction::create([
            'staff'         =>$staff->id,
            'action'        =>'Suspended Staff Account',
            'isSuper'       =>$staff->role=='superadmin'?1:2,
            'model'         =>get_class($user),
            'model_id'      =>$user->id
        ]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Staff suspended successfully.',
            'width' => '400'
        ]);

    }
    //activate user
    public function activateUser()
    {
        $user = SystemStaff::where('id', $this->staffs->id)->first();
        $staff = $this->staff;


        if (!$staff->can('update SuperAdmin')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to activate a staff.',
                'width' => '400',
            ]);
            return;
        }


        $user->update([
            'status' => 1
        ]);

        SystemStaffAction::create([
            'staff'         =>$staff->id,
            'action'        =>'Activated Staff Account',
            'isSuper'       =>$staff->role=='superadmin'?1:2,
            'model'         =>get_class($user),
            'model_id'      =>$user->id
        ]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Staff activated successfully.',
            'width' => '400'
        ]);

    }
    //resend verification mail
    public function resendVerificationMail()
    {
        //staff
        $user = SystemStaff::where('id', $this->staffs->id)->first();
        //logged-in staff
        $staff = $this->staff;


        if (!$staff->can('update SuperAdmin')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to perform this action.',
                'width' => '400',
            ]);
            return;
        }


        $user->notify(new StaffWelcomeMail($user,$this->web));

        SystemStaffAction::create([
            'staff'         =>$staff->id,
            'action'        =>'Resent Staff Verification Code',
            'isSuper'       =>$staff->role=='superadmin'?1:2,
            'model'         =>get_class($user),
            'model_id'      =>$user->id
        ]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Verification Mail resent',
            'width' => '400'
        ]);
    }
}
