<?php

namespace App\Mail;

use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserBank;
use App\Models\UserWithdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DebitNotification extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public UserWithdrawal $withdrawal;
    public Fiat $userFiat;
    public UserBank $bank;
    public Fiat $bankFiat;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, UserWithdrawal $withdrawal, Fiat $userFiat, UserBank $bank, Fiat $bankFiat)
    {
        $this->user = $user;
        $this->withdrawal = $withdrawal;
        $this->userFiat = $userFiat;
        $this->bank = $bank;
        $this->bankFiat = $bankFiat;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Debit Alert: ' . $this->userFiat->sign . number_format($this->withdrawal->amount, 2),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.debit-notification',
            with: [
                'user' => $this->user,
                'withdrawal' => $this->withdrawal,
                'userFiat' => $this->userFiat,
                'bank' => $this->bank,
                'web' => GeneralSetting::find(1),
                'bankFiat' => $this->bankFiat,
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
