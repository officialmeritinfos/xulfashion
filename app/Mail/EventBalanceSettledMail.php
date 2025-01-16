<?php

namespace App\Mail;

use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserEventSettlement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventBalanceSettledMail extends Mailable
{
    use Queueable, SerializesModels;
    public User $user;
    public mixed $eventTitle;
    public mixed $eventId;
    public int|float $amountSettled;
    public $currency;
    public int|float $amountReceived;
    public $userCurrency;
    public mixed $settlementId;
    public $date;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user,UserEvent $event, float|int $amountSettled, Fiat $currency, float|int $amountReceived, Fiat $userCurrency, UserEventSettlement $settlement,$date)
    {
        $this->user = $user;
        $this->eventTitle = $event->title;
        $this->eventId = $event->reference;
        $this->amountSettled = $amountSettled;
        $this->currency = $currency;
        $this->amountReceived = $amountReceived;
        $this->userCurrency = $userCurrency;
        $this->settlementId = $settlement->reference;
        $this->date = $date;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Event Balance Successfully Settled',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event_balance_settled',
            with: [
                'user' => $this->user,
                'eventTitle' => $this->eventTitle,
                'eventId' => $this->eventId,
                'amountSettled' => $this->amountSettled,
                'currency' => $this->currency,
                'amountReceived' => $this->amountReceived,
                'userCurrency' => $this->userCurrency,
                'settlementId' => $this->settlementId,
                'web' => GeneralSetting::find(1),
                'date' => $this->date,
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
