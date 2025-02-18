<?php

namespace App\Livewire\Staff\Users;

use App\Mail\CustomMerchantNotification;
use App\Mail\MerchantProfileReminder;
use App\Models\SystemStaffAction;
use App\Models\User;
use App\Notifications\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserDetail extends Component
{
    use LivewireAlert;

    public $userId;
    public $user;
    public $staff;
    public $email;

    #[Validate('required|digits:6')]
    public $pin;
    #[Validate('required|string|max:200')]
    public $title;
    #[Validate('required|string')]
    public $content;
    #[Validate('required|in:mail,push')]
    public $notificationType;

    public $showEmailUpdate=false;


    public function mount($userId){
        $this->userId = $userId;
        $this->user = User::where('reference', $this->userId)->first();
        $this->staff = Auth::guard('staff')->user();
        $this->email = $this->user->email;
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
    //suspend user
    public function suspendUser()
    {
        $user = User::where('reference', $this->userId)->first();
        $staff = $this->staff;


        if (!$staff->can('update User')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to suspend a user.',
                'width' => '400',
            ]);
            return;
        }


        $user->update([
            'status' => 3
        ]);

        SystemStaffAction::create([
            'staff'         =>$staff->id,
            'action'        =>'Suspended Merchant Account',
            'isSuper'       =>$staff->role=='superadmin'?1:2,
            'model'         =>get_class($user),
            'model_id'      =>$user->id
        ]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'User suspended successfully.',
            'width' => '400'
        ]);

    }
    //activate user
    public function activateUser()
    {
        $user = User::where('reference', $this->userId)->first();
        $staff = $this->staff;


        if (!$staff->can('update User')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to activate a user.',
                'width' => '400',
            ]);
            return;
        }


        $user->update([
            'status' => 1
        ]);

        SystemStaffAction::create([
            'staff'         =>$staff->id,
            'action'        =>'Activated Merchant Account',
            'isSuper'       =>$staff->role=='superadmin'?1:2,
            'model'         =>get_class($user),
            'model_id'      =>$user->id
        ]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'User activated successfully.',
            'width' => '400'
        ]);

    }
    //remind user to complete profile
    public function remindAboutProfile()
    {
        $user = User::where('reference', $this->userId)->first();
        $staff = $this->staff;


        if (!$staff->can('create User')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have the permission to send this reminder',
                'width' => '400',
            ]);
            return;
        }

        Mail::to($user->email)->queue(new MerchantProfileReminder($user));

        SystemStaffAction::create([
            'staff'         =>$staff->id,
            'action'        =>'Sends Merchant reminder about their incomplete profile',
            'isSuper'       =>$staff->role=='superadmin'?1:2,
            'model'         =>get_class($user),
            'model_id'      =>$user->id
        ]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'User reminded successfully.',
            'width' => '400'
        ]);

    }
    //submit custom notification
    public function submitNotification(Request $request)
    {
        $user = User::where('reference', $this->userId)->first();
        $staff = $this->staff;


        if (!$staff->can('create User')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have the permission to send this notification',
                'width' => '400',
            ]);
            return;
        }
        $this->validate();

        try {

            if ($this->notificationType=='push'){

                scheduleUserNotification($user->id,$this->title,$this->content);

                SystemStaffAction::create([
                    'staff'         =>$staff->id,
                    'action'        =>'Sent a Push notification to Merchant',
                    'isSuper'       =>$staff->role=='superadmin'?1:2,
                    'model'         =>get_class($user),
                    'model_id'      =>$user->id
                ]);

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Push Notification  sent successfully.',
                    'width' => '400'
                ]);
                return;
            }else{

                Mail::to($user->email)->send(new CustomMerchantNotification($user,$this->title,$this->content));

                SystemStaffAction::create([
                    'staff'         =>$staff->id,
                    'action'        =>'Sent a Mail notification to Merchant',
                    'isSuper'       =>$staff->role=='superadmin'?1:2,
                    'model'         =>get_class($user),
                    'model_id'      =>$user->id
                ]);

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Mail Notification  sent successfully.',
                    'width' => '400'
                ]);
            }

        }catch (\Exception $exception){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while sending notification the merchant.',
                'width' => '400',
            ]);
            logger($exception->getMessage());
        }
    }

    public function toggleShowUpdateEmail()
    {
       if ($this->showEmailUpdate){
           $this->showEmailUpdate = false;
           return;
       }else{
           $this->showEmailUpdate = true;
           return;
       }
    }

    public function updateEmail()
    {
        $user = User::where('reference', $this->userId)->first();
        $staff = $this->staff;


        if (!$staff->can('update UserEmail')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have the permission to update user email',
                'width' => '400',
            ]);
            return;
        }

        $this->validate([
            'email' => ['required','email',Rule::unique('users','email')->ignore($this->user->id,'id')],
        ]);
        try {

            $hashed = Hash::check($this->pin,$staff->accountPin);
            if (!$hashed) {
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Invalid Account pin. Access denied.',
                    'width' => '400',
                ]);
                return;
            }

            $user->update([
                'email' => $this->email
            ]);

            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Email successfully updated.',
                'width' => '400',
            ]);
            $this->showEmailUpdate = false;
        }catch (\Exception $exception){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while sending notification the merchant.',
                'width' => '400',
            ]);
            logger($exception->getMessage());
        }
    }
}
