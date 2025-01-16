<?php

namespace App\Mail;

use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountCreditedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public int|float $amount;
    public Fiat $currency;
    public string $transactionRef;
    public string $source;
    public int|float $availableBalance;
    public $date;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, float|int $amount, Fiat $currency, string $transactionRef, string $source, float|int $availableBalance, $date)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->transactionRef = $transactionRef;
        $this->source = $source;
        $this->availableBalance = $availableBalance;
        $this->date = $date;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Credit Alert: '.$this->currency->sign.number_format($this->amount),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.account_credited',
            with: [
                'user' => $this->user,
                'amount' => $this->amount,
                'currency' => $this->currency,
                'transactionRef' => $this->transactionRef,
                'source' => $this->source,
                'availableBalance' => $this->availableBalance,
                'date' => $this->date,
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
