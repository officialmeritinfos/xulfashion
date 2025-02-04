<?php

namespace App\Livewire\Staff\Users;

use App\Models\SystemStaffAction;
use App\Models\User;
use App\Notifications\EmailVerification;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UserDetail extends Component
{
    use LivewireAlert;

    public $userId;
    public $user;
    public $staff;

    public function mount($userId){
        $this->userId = $userId;
        $this->user = User::where('reference', $this->userId)->first();
        $this->staff = Auth::guard('staff')->user();
    }

    public function render()
    {
        return view('livewire.staff.users.user-detail');
    }
    //verify email
    public function verifyEmail()
    {
        $user = User::where('reference', $this->userId)->first();
        $staff = $this->staff;


        if (!$staff->can('update User')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to onboard a user.',
                'width' => '400',
            ]);
            return;
        }


        $user->update([
            'email_verified_at' => now(),
            'welcomeSent' => 2
        ]);

        SystemStaffAction::create([
            'staff'         =>$staff->id,
            'action'        =>'Verified merchant Email',
            'isSuper'       =>$staff->role=='superadmin'?1:2,
            'model'         =>get_class($user),
            'model_id'      =>$user->id
        ]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'User email verified successfully.',
            'width' => '400'
        ]);

    }
    //resend verification mail
    public function resendVerificationMail()
    {
        $user = User::where('reference', $this->userId)->first();
        $staff = $this->staff;


        if (!$staff->can('create User')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to onboard a user.',
                'width' => '400',
            ]);
            return;
        }


        $user->notify(new EmailVerification($user));

        SystemStaffAction::create([
            'staff'         =>$staff->id,
            'action'        =>'Resent Merchant Verification Code',
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
