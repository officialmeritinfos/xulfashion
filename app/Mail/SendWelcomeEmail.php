<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;
    public mixed $user;
    public mixed $web;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,GeneralSetting $web)
    {
        $this->user = $user;
        $this->web = $web;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address($this->web->email,$this->web->name),
            replyTo:[
                $this->web->supportEmail
            ] ,
            subject: 'Welcome to '.$this->web->name,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $user = $this->user;
        $web = $this->web;

        return new Content(
            view: 'emails.welcome_email',
            with: [
                'web'=>$this->web,
                'siteName'=>$web->name,
                'user'  =>$user->name,
                'supportMail'=>$web->supportMail
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
