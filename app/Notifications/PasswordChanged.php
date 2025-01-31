<?php

namespace App\Notifications;

use App\Models\UserActivity;
use App\Models\UserNotification;
use App\Models\UserSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChanged extends Notification
{
    use Queueable;
    public mixed $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $settings = UserSetting::where('user',$this->user->id)->first();
        if ($settings && $settings->notifications==1){
            UserNotification::create([
                'user' => $this->user->id,
                'title' => 'Account Password Change',
                'content' => 'Your account password has been changed.',
                'status' => 2,
            ]);
        }

        UserActivity::create([
            'user' => $this->user->id,
            'content' => 'Your account password has been changed.',
            'title' => 'Account Password Change',
            'status' => 2
        ]);

        return (new MailMessage)
            ->subject('Account Password Changed')
            ->greeting('Hello '.$this->user->name)
            ->line('The password to your account on '.env('APP_NAME').' has been changed.')
            ->line('If this activity was not performed by you, please contact support immediately.')
            ->action('Go to Dashboard',route('login'))
            ->line('Thank you for using our choosing '.env('APP_NAME'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
