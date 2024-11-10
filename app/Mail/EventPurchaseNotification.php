<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventPurchaseTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventPurchaseNotification extends Mailable
{
    use Queueable, SerializesModels;

    public UserEventPurchase $purchase;
    public User $eventOwner;
    public UserEvent $event;
    /**
     * Create a new message instance.
     */
    public function __construct(UserEventPurchase $purchase, UserEvent $event)
    {
        $this->purchase = $purchase;
        $this->event = $event;
        $this->eventOwner = User::where('id',$event->user)->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Event Purchase: A New Ticket(s) Purchased for Event '.$this->event->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event_purchase_notification',
            with: [
                'purchase' => $this->purchase,
                'eventOwner' => $this->eventOwner,
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
