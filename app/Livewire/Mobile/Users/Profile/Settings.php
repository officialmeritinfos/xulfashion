<?php

namespace App\Livewire\Mobile\Users\Profile;

use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Settings extends Component
{
    public $user;
    public $withdrawal;
    public $deposit;
    public $push;
    public $newsletter;
    public $twoFactor;
    public $emailNotification;
    public $otp;
    public bool $showOtpModal = false;
    public $settings;

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

    public function withdrawalNotification()
    {

    }
}
