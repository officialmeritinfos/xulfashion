<?php

namespace App\Notifications;

use App\Models\UserStore;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class SendStoreCustomerLoginAuthentication extends Notification
{
    use Queueable;

    public $customer;

    /**
     * Create a new notification instance.
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
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
        $store = UserStore::where('id',$this->customer->store)->first();

        $expiration = Carbon::now()->addMinutes(30);
        $signedUrl = URL::temporarySignedRoute('merchant.store.login.authenticate', $expiration, ['subdomain'=>$store->slug,'customer' => $this->customer->reference]);

        return (new MailMessage)
                    ->subject('Login Authentication on '.$store->name)
                    ->greeting('Hello '.$this->customer->name)
                    ->line('This is a short mail to notify you of a login request on your account on '.$store->name.'. Click the button below to authenticate this request.')
                    ->action('Authenticate Login', $signedUrl)
                    ->line('Thank you for patronizing '.$store->name);
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
