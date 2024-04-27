<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmployerNotification extends Notification
{
    use Queueable;
    public $user;
    public $message;
    public $subject;
    /**
     * Create a new notification instance.
     */
    public function __construct($user,$message,$subject)
    {
        $this->user = $user;
        $this->message = $message;
        $this->subject = $subject;
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
        switch ($this->user->accountType){
            case 1:
                $url = route('user.dashboard');
                break;
            case 3:
                $url = route('school.dashboard');
                break;
            default:
                $url = route('parent.dashboard');
                break;
        }
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting('Hello '.$this->user->name)
            ->line($this->message)
            ->action('Login to Account',$url);
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
