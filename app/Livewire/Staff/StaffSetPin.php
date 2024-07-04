<?php

namespace App\Livewire\Staff;

use App\Models\SystemStaffAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class StaffSetPin extends Component
{
    use LivewireAlert;
    public $newPin;
    public $newPin_confirmation;
    public $password;
    public $isSubmitting = false;

    protected $rules = [
        'newPin' => 'required|min:6|confirmed',
        'password' => 'required',
    ];

    public function submit()
    {
        $this->isSubmitting = true;
        $this->validate();

        $staff = Auth::guard('staff')->user();

        if (!Hash::check($this->password, $staff->password)) {
            $this->isSubmitting = false;
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Incorrect password',
                'width' => '400',
            ]);
            return;
        }

        if($staff->setPin==1){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Authentication pin already set',
                'width' => '400',
            ]);
            return;
        }

        try {
            // Assuming there's a pin column in the SystemStaff table
            $staff->accountPin = Hash::make($this->newPin);
            $staff->setPin=1;
            $staff->save();

            SystemStaffAction::create([
                'staff'         =>$staff->id,
                'action'        =>'Pin Setup',
                'isSuper'       =>$staff->role=='superadmin'?1:2,
                'model'         =>get_class($staff),
                'model_id'      =>$staff->id
            ]);

            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'PIN set successfully',
                'width' => '400'
            ]);
            $this->dispatch('pinSetSuccessfully');
        } catch (\Exception $e) {
            Log::error('Failed to set PIN: ' . $e->getMessage());

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Failed to set PIN. Please try again.',
                'width' => '400',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.staff.staff-set-pin');
    }
}
