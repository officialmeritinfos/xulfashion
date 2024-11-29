<?php

namespace App\Mail;

use App\Models\UserEvent;
use App\Models\UserEventGuest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GuestNotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public UserEventGuest $guest;
    public mixed $default;
    public mixed $message;
    public UserEvent $event;
    /**
     * Create a new message instance.
     */
    public function __construct(UserEventGuest $guest,$default=true,$message=null)
    {
        $this->guest = $guest;
        $this->default = $default;
        $this->message = $message;
        $this->event = UserEvent::where('id',$this->guest->event)->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notification About your registered Event: Important Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->default){
            return new Content(
                view: 'emails.guest_default_notification_mail',
                with: [
                    'guest'=>$this->guest,
                    'event'=>$this->event,
                ]
            );
        }

        return new Content(
            view: 'emails.guest_custom_notification_mail',
            with: [
                'guest'=>$this->guest,
                'event'=>$this->event,
                'message'=>$this->message,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
