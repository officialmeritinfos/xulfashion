<?php

namespace App\Jobs;

use App\Mail\EventThankYouMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEventThankYouMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $guests;
    protected $event;

    /**
     * Create a new job instance.
     */
    public function __construct($guests, $event)
    {
        $this->guests = $guests;
        $this->event = $event;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->guests as $guest) {
            Mail::to($guest->email)->send(new EventThankYouMail($guest, $this->event));
        }
    }
}
