<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MerchantProfileReminder extends Mailable
{
    use Queueable, SerializesModels;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($merchant)
    {
        $this->user = $merchant;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Complete Your Xulfashion Profile',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $merchant = User::where('id', $this->user->id)->first();
        $profileCompletionLink = empty($merchant->google_id)?route('mobile.user.profile.settings.complete-profile'):route('mobile.user.profile.settings.complete-profile.socialite');
        return new Content(
            view: 'emails.merchant_profile_reminder',
            with: [
                'merchant' => $merchant,
                'web' =>GeneralSetting::find(1),
                'profileCompletionLink' => $profileCompletionLink,
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
