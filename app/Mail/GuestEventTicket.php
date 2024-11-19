<?php

namespace App\Mail;

use App\Models\UserEvent;
use App\Models\UserEventGuest;
use App\Models\UserEventPurchaseTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class GuestEventTicket extends Mailable
{
    use Queueable, SerializesModels;
    public int $guestId;

    /**
     * Create a new message instance.
     */
    public function __construct($guest)
    {
        $this->guestId = $guest;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Event Ticket',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $guest =  UserEventGuest::where('id',$this->guestId)->with([
            'events','ticket.ticket','purchase'
        ])->first();


        return new Content(
            view: 'emails.guest_event_ticket',
            with: [
                'guest' => $guest,
                'downloadUrl'=>URL::signedRoute('mobile.event.ticket.guest.download', [
                    'event' => $guest->events->reference,'ticket'=>$guest->ticket->id,
                    'guest'=>$guest->id
                ])
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
