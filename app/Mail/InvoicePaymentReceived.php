<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoicePaymentReceived extends Mailable
{
    use Queueable, SerializesModels;
    public $merchant;
    public $order;
    public $customer;
    public $amountPaid;
    public $totalCharge;
    public $amountCredit;

    /**
     * Create a new message instance.
     */
    public function __construct($merchant, $order, $customer, $amountPaid, $totalCharge, $amountCredit)
    {
        $this->merchant = $merchant;
        $this->order = $order;
        $this->customer = $customer;
        $this->amountPaid = $amountPaid;
        $this->totalCharge = $totalCharge;
        $this->amountCredit = $amountCredit;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Payment Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice_payment_received',
            with: [
                'merchant' => $this->merchant,
                'order' => $this->order,
                'customer' => $this->customer,
                'amountPaid' => $this->amountPaid,
                'totalCharge' => $this->totalCharge,
                'amountCredit' => $this->amountCredit,
                'web'=>GeneralSetting::find(1)
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
