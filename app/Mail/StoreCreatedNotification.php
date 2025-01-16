<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StoreCreatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $storeName;
    public $storeUrl;
    public $userName;

    public $verifyUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($storeName, $storeUrl, $userName,$verifyUrl)
    {
        $this->storeName = $storeName;
        $this->storeUrl = $storeUrl;
        $this->userName = $userName;
        $this->verifyUrl = $verifyUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚀 Your Store "' . $this->storeName . '" is Live!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.store_created_notification',
            with: [
                'storeName' => $this->storeName,
                'storeUrl' => $this->storeUrl,
                'userName' => $this->userName,
                'web' =>GeneralSetting::find(1),
                'verifyUrl' => $this->verifyUrl,
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
