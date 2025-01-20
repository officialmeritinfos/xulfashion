<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventTicketBuyer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEventBuyerMailAboutPurchaseCancellation extends Mailable
{
    use Queueable, SerializesModels;
    public UserEvent $event;
    public UserEventTicketBuyer $buyer;
    public UserEventPurchase $purchase;

    /**
     * Create a new message instance.
     */
    public function __construct(UserEvent $event, UserEventTicketBuyer $buyer,UserEventPurchase $purchase)
    {
        $this->event = $event;
        $this->buyer = $buyer;
        $this->purchase = $purchase;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Ticket Cancellation Notification: Event - {$this->event->title}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event_purchase_cancelled_buyer',
            with: [
                'event' => $this->event,
                'buyer' => $this->buyer,
                'web' => GeneralSetting::find(1),
                'purchase' => $this->purchase,
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
