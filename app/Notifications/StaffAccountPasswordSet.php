<?php

namespace App\Notifications;

use App\Models\SystemStaff;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class StaffAccountPasswordSet extends Notification
{
    use Queueable;

    public $staff;
    /**
     * Create a new notification instance.
     */
    public function __construct(SystemStaff $staff)
    {
        $this->staff = $staff;
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
        $urlToDeactivateAccount = URL::signedRoute('staff.staff.lock.account',['staff'=>$this->staff->id]);
        return (new MailMessage)
                    ->subject('Staff Account Password Updated.')
                    ->greeting('Hello '.$this->staff->name)
                    ->line('Your account on '.config('app.name').' CRM has been updated. If you did not make this
                    change, please click the button below to lock your account immediately.'
                    )
                    ->action('Lock Account', url($urlToDeactivateAccount))
                    ->line('Thank you for being part of the family.');
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
