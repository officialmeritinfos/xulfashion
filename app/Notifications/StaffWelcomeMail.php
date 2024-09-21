<?php

namespace App\Notifications;

use App\Models\GeneralSetting;
use App\Models\StaffEmailVerification;
use App\Models\SystemStaff;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StaffWelcomeMail extends Notification
{
    use Queueable;
    public $staff;
    public $web;
    public $password;

    /**
     * Create a new notification instance.
     */
    public function __construct(SystemStaff $staff, GeneralSetting $web,$password=null)
    {
        $this->staff = $staff;
        $this->web = $web;
        $this->password = $password;
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
        $token = sha1(time());

        $additionalText='';
        if (!empty($this->password)){
            $additionalText = "Your default password is ".$this->password." You have to update this password immediately you
            login to your account. Or click the link below to update it before logging in.";
        }

        StaffEmailVerification::create([
            'staff'=>$this->staff->id,'email'=>$this->staff->email,
            'token'=>$token,'codeExpires'=>strtotime($this->web->codeExpire,time())
        ]);
        $url = route('staff.staff.setup.password',['token'=>$token,'email'=>$this->staff->email,'staff'=>$this->staff->id]);
        return (new MailMessage)
                    ->greeting('Hello '.$this->staff->name)
                    ->subject('Welcome to '.config('app.name').' Staff Management System')
                    ->line('Your profile has been created on the '.config('app.name').' CRM, and this is a
                    short mail to advise you to complete your profile. Use the link below to set-up your password, and access your terminal.'.$additionalText
                    )
                    ->action('Set-up Profile', $url)
                    ->line('Thank you and welcome onboard!');
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
