<?php

namespace App\Livewire\Mobile\Users\Profile;

use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserSetting;
use App\Notifications\CustomNotification;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Settings extends Component
{
    use LivewireAlert, Helpers;

    public $user;
    public $withdrawal;
    public $deposit;
    public $push;
    public $newsletter;
    public $twoFactor;
    public $emailNotification;
    public $otp;
    public bool $showOtpForm = false;
    public $settings;
    public $showResend = false;
    public $twoFactorText;

    public $otpSent = false;

    public $showError=false;
    public $errorMessage = '';

    public $showSuccess=false;
    public $successMessage = '';
    public $enteredOtp;



    public function mount()
    {
        $this->user = Auth::user();
        $this->settings = UserSetting::where('user',$this->user->id)->first();

        if ($this->settings) {
            $this->withdrawal = $this->settings->withdrawalNotification == 1;
            $this->deposit = $this->settings->depositNotification == 1;
            $this->push = $this->settings->notifications == 1;
            $this->newsletter = $this->settings->newsletters == 1;
            $this->twoFactor = $this->settings->twoFactor == 1;
            $this->emailNotification = $this->settings->emailNotification == 1;
        }
    }
    public function updateWithdrawal()
    {
        $this->processUpdate('withdrawalNotification', $this->withdrawal, 'Withdrawal Notifications updated successfully');
    }

    public function updateDeposit()
    {
        $this->processUpdate('depositNotification', $this->deposit, 'Deposit Notifications updated successfully');
    }

    public function updatePush()
    {
        $this->processUpdate('notifications', $this->push, 'Push Notifications updated successfully');
    }

    public function updateNewsletter()
    {
        $this->processUpdate('newsletters', $this->newsletter, 'Newsletter subscription updated successfully');
    }

    public function updateEmailNotification()
    {
        $this->processUpdate('emailNotification', $this->emailNotification, 'Email Notifications updated successfully');
    }

    private function processUpdate($column, $value, $message)
    {
        $this->loading = true;

        $this->settings->update([$column => $value ? 1 : 2]);

        $this->showSuccess = true;
        $this->successMessage = $message;

        $this->dispatch('showSuccessMessage', ['message' => $message]);
        $this->loading = false;
    }
    public function render()
    {
        return view('livewire.mobile.users.profile.settings');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
           <svg width="100%" height="100%" viewBox="0 0 400 130" preserveAspectRatio="none">
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

                <!-- Rectangle Placeholder -->
                <rect x="10" y="10" rx="5" ry="5" width="380" height="20" fill="url(#skeleton-gradient)" />

                <!-- Line Placeholder -->
                <rect x="10" y="40" rx="5" ry="5" width="350" height="15" fill="url(#skeleton-gradient)" />
                <rect x="10" y="65" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="10" y="90" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />


            </svg>
        </div>
        HTML;
    }

    public function updateTwoFactor()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);
        $this->showOtpForm = true;
        $this->twoFactorText =  $this->twoFactor ?"Activate":"Deactivate";

        try {
            // Generate a new OTP
            $otp = $this->generateToken('users', 'otp');

            // Save OTP and expiration time
            $user->otp = bcrypt($otp);
            $user->otpExpires = strtotime("+{$web->codeExpire}");
            $user->save();

            // Compose the OTP notification message
            $message = "There is a new request on your account requiring an OTP. The OTP to use is <b>" . $otp . "</b>.
        <p>This OTP will expire in <b>" . $web->codeExpire . " minutes</b>. Note that neither " . $web->name . " nor her staff will ever ask you for your OTP.</p>";

            // Send the OTP notification
            $user->notify(new CustomNotification($user, $message, 'OTP Authentication'));

            // Set success message
            $this->otpSent = true;
            $this->showSuccess = true;
            $this->successMessage = 'OTP has been sent to your email. Use it to authenticate this action.';
            $this->showResend  = true;

            // Clear any previous errors
            $this->showError = false;
            $this->errorMessage = '';

            session([
                'two-factor'=>$this->twoFactor?1:2
            ]);

            // Dispatch a browser event to clear the success message after 5 seconds
            $this->dispatch('clear-success-message');

            return;
        }catch (\Exception $exception) {
            // Log any other error
            Log::error('Error on ' . $exception->getFile() . ' on line ' . $exception->getLine() . ': ' . $exception->getMessage());
            $this->showError = true;
            $this->errorMessage = 'Internal server error; we are working on this now.';
            return;
        }
    }

    public function resendOtp()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);
        $this->showOtpForm = true;
        $this->twoFactorText =  $this->twoFactor ?"Activate":"Deactivate";

        try {
            // Generate a new OTP
            $otp = $this->generateToken('users', 'otp');

            // Save OTP and expiration time
            $user->otp = bcrypt($otp);
            $user->otpExpires = strtotime("+{$web->codeExpire}");
            $user->save();

            // Compose the OTP notification message
            $message = "There is a new request on your account requiring an OTP. The OTP to use is <b>" . $otp . "</b>.
        <p>This OTP will expire in <b>" . $web->codeExpire . " minutes</b>. Note that neither " . $web->name . " nor her staff will ever ask you for your OTP.</p>";

            // Send the OTP notification
            $user->notify(new CustomNotification($user, $message, 'OTP Authentication'));

            // Set success message
            $this->otpSent = true;
            $this->showSuccess = true;
            $this->successMessage = 'OTP successfully resent.';
            $this->showResend  = true;

            // Clear any previous errors
            $this->showError = false;
            $this->errorMessage = '';

            // Dispatch a browser event to clear the success message after 5 seconds
            $this->dispatch('clear-success-message');

            return;
        }catch (\Exception $exception) {
            // Log any other error
            Log::error('Error on ' . $exception->getFile() . ' on line ' . $exception->getLine() . ': ' . $exception->getMessage());
            $this->showError = true;
            $this->errorMessage = 'Internal server error; we are working on this now.';
            return;
        }
    }

    //process TWO Factor Update
    public function processTwoFactorUpdate(Request $request)
    {
        $web = GeneralSetting::find(1);
        $this->validate([
            'enteredOtp' => ['required','digits:6'],
        ]);
        DB::beginTransaction();
        try {
            $user = User::where('id',$this->user->id)->first();

            if ($user->otpExpires < time()) {
                $this->showError = true;
                $this->errorMessage = 'The OTP has expired. Please request a new one.';
                return;
            }

            if (!Hash::check($this->enteredOtp, $user->otp)) {
                $this->showError = true;
                $this->errorMessage = 'Invalid OTP. Please try again.';
                return;
            }

            $user->otp='';
            $user->otpExpires='';
            $user->save();

            $this->twoFactor = session('two-factor');
            if ($this->twoFactor==1){
                $message = "Two-factor authentication activated for profile on {$web->name}.";
            }else{
                $message = "Two-factor authentication has been deactivated for profile on {$web->name}.";
            }

            $this->userNotification($user,'Two-factor Authentication',$message,$request->ip());
            scheduleUserNotification($user->id,'Two-factor Authentication',$message,route('mobile.user.app.settings'));

            $this->settings->update([
                'twoFactor' => $this->twoFactor,
            ]);
            DB::commit();
            $this->showSuccess = true;
            $this->successMessage = 'Two Factor Authentication updated successfully. Please wait ...';

            $this->dispatch('renderPage');


        }catch (\Exception $exception) {
            DB::rollBack();
            // Log error and show feedback
            Log::error('Error processing two-factor authentication: ' . $exception->getMessage());
            $this->showError = true;
            $this->errorMessage = 'An error occurred while performing your action.';
        }
    }

    public function cancelAction()
    {
        $this->reset([
            'enteredOtp','showOtpForm','twoFactorText','twoFactor'
        ]);
        $this->dispatch('renderPage');
    }
}
