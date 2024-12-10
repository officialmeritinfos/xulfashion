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

class NextOccurrenceNotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $guest;
    public $event;
    public $nextOccurrence;

    /**
     * Create a new message instance.
     */
    public function __construct(UserEventGuest $guest, UserEvent $event, $nextOccurrence)
    {
        $this->guest = $guest;
        $this->event = $event;
        $this->nextOccurrence = $nextOccurrence;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Upcoming Event Notification: '. $this->event->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.next_occurrence_notification',
            with: [
                'guest' => $this->guest,
                'event' => $this->event,
                'nextOccurrence' => $this->nextOccurrence,
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
