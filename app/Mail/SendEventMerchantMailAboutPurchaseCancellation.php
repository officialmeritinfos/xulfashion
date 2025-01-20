<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventTicketBuyer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEventMerchantMailAboutPurchaseCancellation extends Mailable
{
    use Queueable, SerializesModels;
    public UserEvent $event;
    public UserEventTicketBuyer $buyer;
    public UserEventPurchase $purchase;
    public User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, UserEvent $event, UserEventTicketBuyer $buyer,UserEventPurchase $purchase)
    {
        $this->event = $event;
        $this->buyer = $buyer;
        $this->purchase = $purchase;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Ticket Order Cancellation Notification: Event - {$this->event->title}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event_purchase_cancelled_merchant',
            with: [
                'event' => $this->event,
                'buyer' => $this->buyer,
                'purchase' => $this->purchase,
                'user' => $this->user,
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
