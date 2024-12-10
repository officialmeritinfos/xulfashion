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

class EventThankYouMail extends Mailable
{
    use Queueable, SerializesModels;
    public $guest;
    public $event;
    /**
     * Create a new message instance.
     */
    public function __construct(UserEventGuest $guest,UserEvent $event)
    {
        $this->guest = $guest;
        $this->event = $event;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you for attending '.$this->event->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event_thank_you',
            with: [
                'guest' => $this->guest,
                'event' => $this->event,
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
