<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyCustomer extends Notification implements ShouldQueue
{
    use Queueable;
    public $customer, $actionTitle,$actionLink,$store,$message,$title;

    /**
     * Create a new notification instance.
     */
    public function __construct($customer,$store,$title,$message,$actionTitle='Access Now',$actionLink=null)
    {
        $this->customer=$customer;
        $this->actionTitle=$actionTitle;
        $this->actionLink=$actionLink;
        $this->store=$store;
        $this->message=$message;
        $this->title=$title;
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
                    ->subject($this->title)
                    ->greeting('Hello '.$this->customer->name)
                    ->line($this->message)
                    ->action($this->actionTitle,$this->actionLink??url('/') )
                    ->line('Thank you for using '.$this->store->name);
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
