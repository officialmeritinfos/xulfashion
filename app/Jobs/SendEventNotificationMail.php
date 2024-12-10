<?php

namespace App\Jobs;

use App\Mail\NextOccurrenceNotificationMail;
use App\Models\UserEvent;
use App\Models\UserEventGuest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEventNotificationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $guest;
    public $event;
    public $nextOccurrence;

    /**
     * Create a new job instance.
     */
    public function __construct(UserEventGuest $guest, UserEvent $event, $nextOccurrence)
    {
        $this->guest = $guest;
        $this->event = $event;
        $this->nextOccurrence = $nextOccurrence;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->guest->email)->send(new NextOccurrenceNotificationMail($this->guest, $this->event, $this->nextOccurrence));
    }
}
