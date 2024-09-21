<?php

namespace App\Notifications;

use App\Models\SystemStaff;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class StaffCustomNotification extends Notification
{
    use Queueable;
    public $user;
    public $message;
    public $subject;
    public $lockAccount;

    /**
     * Create a new notification instance.
     */
    public function __construct($user,$message,$subject, $hasLockAccount=false)
    {
        $this->user = $user;
        $this->message = $message;
        $this->subject = $subject;
        $this->lockAccount = $hasLockAccount;
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
        $url = route('staff.login');
        $actionText = "Login to account";
        if ($this->lockAccount){
            $url = URL::signedRoute('staff.staff.lock.account',['staff'=>$this->user->id]);
            $actionText = "Lock Account";
        }

        return (new MailMessage)
                ->subject($this->subject)
                ->greeting('Hello '.$this->user->name)
                ->line($this->message."
                    <br/>
                    If you feel your account is compromised, click the button below to lock your account.
                ")
                ->action($actionText,$url);
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
