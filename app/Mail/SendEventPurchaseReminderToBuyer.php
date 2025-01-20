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

class SendEventPurchaseReminderToBuyer extends Mailable
{
    use Queueable, SerializesModels;
    public $event;
    public $buyer;
    public $purchase;

    /**
     * Create a new message instance.
     */
    public function __construct(UserEvent $event, UserEventPurchase $purchase, UserEventTicketBuyer $buyer)
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
            subject: 'Complete your purchase: ' . $this->event->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send_event_buyer_notification_to_complete_payment',
            with: [
                'event' => $this->event,
                'buyer' => $this->buyer,
                'purchase' => $this->purchase,
                'web' => GeneralSetting::find(1)
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
