<?php

namespace App\Jobs;

use App\Mail\GuestNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEventGuestNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $guests;
    public $default;
    public $message;
    public $title;
    /**
     * Create a new job instance.
     */
    public function __construct($guests, $default = true, $message = null,$title = null)
    {
        $this->guests = $guests;
        $this->default = $default;
        $this->message = $message;
        $this->title = $title;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->guests as $guest) {
            // Send email to each guest
            Mail::to($guest->email)->send(new GuestNotificationMail($guest, $this->default, $this->message,$this->title));
        }
    }
}
