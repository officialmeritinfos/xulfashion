<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomNotificationNoLink extends Notification implements ShouldQueue
{
    use Queueable;
    public mixed $user,$title,$message,$file;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$title,$message,$file=null)
    {
        $this->user = $user;
        $this->title = $title;
        $this->message = $message;
        $this->file = $file;
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
        return (new MailMessage)
            ->greeting('Hello '.$this->user)
            ->subject($this->title)
            ->line($this->message)
            ->line('Thank you for using '.env('APP_NAME'));
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
