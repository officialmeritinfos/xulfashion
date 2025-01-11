<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserBank;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayoutAccountAddedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $accountDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, UserBank $accountDetails)
    {
        $this->user = $user;
        $this->accountDetails = $accountDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Payout Account Added',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payout_account_added',
            with: [
                'accountDetails' => $this->accountDetails,
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
