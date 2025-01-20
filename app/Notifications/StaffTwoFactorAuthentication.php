<?php

namespace App\Notifications;

use App\Models\GeneralSetting;
use App\Models\SystemStaffTwoFactor;
use App\Traits\Helpers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StaffTwoFactorAuthentication extends Notification implements ShouldQueue
{
    use Queueable,Helpers;
    public mixed $user;
    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $user = $this->user;
        $web = GeneralSetting::find(1);
        $token = $this->generateToken('emails','token');

        SystemStaffTwoFactor::create([
            'user'          =>$user->id,
            'email'         =>$user->email,
            'token'         =>bcrypt($token),
            'codeExpire'    =>strtotime($web->codeExpire,time())
        ]);
        return (new MailMessage)
            ->subject('Two-factor Authentication')
            ->greeting('Welcome '.$user->name)
            ->line('There is a Login request on your '.$web->name.'staff account.
                 However, there is a Two factor authentication on your account. Use the code below to
                 authenticate this request. ')
            ->line('<p style="text-align: center;"><b>'.$token.'</b></p>')
            ->line('<p style="text-align: center;">Token is valid for '.$web->codeExpire.'</p>
                            <p>Do not share this code with anybody via mail, sms, or phone call.
                                Be vigilant!
                            </p>')
            ->line('Thank you ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
