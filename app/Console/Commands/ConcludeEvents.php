<?php

namespace App\Console\Commands;

use App\Jobs\SendEventThankYouMail;
use App\Mail\OrganizerThankYouMail;
use App\Models\UserEvent;
use App\Models\UserEventGuest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ConcludeEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:conclude-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Conclude events with eventScheduleType = 1 when the current time exceeds endDate + endTime.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        // Fetch events with eventScheduleType = 1 and not already concluded
        $events = UserEvent::where('eventScheduleType', 1)
            ->where('status', 1)
            ->get();
        foreach ($events as $event) {
            // Combine endDate and endTime to create a full datetime
            $endDateTime = Carbon::parse($event->endDate . ' ' . $event->endTime, $event->eventTimeZone);

            if ($now->greaterThan($endDateTime)) {
                // Update the status of the event to concluded (5)
                $event->update(['status' => 5]);

                // Fetch guests for the event
                $guests = UserEventGuest::where('event', $event->id)->get();

                if ($guests->isNotEmpty()) {
                    // Dispatch a job to send thank-you emails to all guests
                    SendEventThankYouMail::dispatch($guests, $event);
                }

                if ($event->user) {
                    Mail::to($event->users->email)->send(new OrganizerThankYouMail($event));
                }

                // Log the event as concluded
                Log::info("Event '{$event->title}' (ID: {$event->reference}) has been concluded and emails dispatched.");
            }
        }

        return 0;
    }
}
