<?php

namespace App\Livewire\Staff\Settings;

use App\Models\SystemStaff;
use App\Models\SystemStaffAction;
use App\Notifications\CustomNotificationNoLink;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Profile extends Component
{
    use LivewireAlert;

    public $staff;
    #[Validate]
    public $oldPassword;
    #[Validate]
    public $password;
    #[Validate]
    public $password_confirmation;
    #[Validate]
    public $accountPin;


    //mount
    public function mount()
    {
        $this->staff = Auth::guard('staff')->user();
    }

    public function rules()
    {
        return [
            'accountPin'=>['required','string','max_digits:6','min_digits:6'],
            'oldPassword'=>['required','current_password:staff'],
            'password'=>['required','confirmed',Password::min(8)->uncompromised(1)],
            'password_confirmation'=>['required','same:password'],
        ];
    }

    public function render()
    {
        return view('livewire.staff.settings.profile');
    }
    //update password
    public function submit()
    {
        $this->validate();
        try {
            //check the account pin
            if (!Hash::check($this->accountPin,$this->staff->accountPin)){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Authorization failed. Please try again.',
                    'width' => '400',
                ]);
            }
            $staff = SystemStaff::where('id',$this->staff->id)->first();
            $staff->update([
                'password' => bcrypt($this->password),
                'hasUpdatedPassword' => 1
            ]);
            SystemStaffAction::create([
                'staff'         =>$staff->id,
                'action'        =>'Password Updated',
                'isSuper'       =>$staff->role=='superadmin'?1:2,
                'model'         =>get_class($staff),
                'model_id'      =>$staff->id
            ]);

            $message = 'You staff password was reently changed. Please login back again to continue your session, or contact
            support immediately if this change was not performed by you.';
            $staff->notify(new CustomNotificationNoLink($staff->name,'Password Changed',$message));

            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Password was successfully changed. You will be logged out now. Login again to continue your session.',
                'width' => '400',
            ]);
            $this->dispatch('passwordUpdated',route('staff.logout'));

        }catch (\Exception $exception){

            Log::info($exception->getMessage());
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Failed to update password. Please try again.',
                'width' => '400',
            ]);
        }
    }
}
