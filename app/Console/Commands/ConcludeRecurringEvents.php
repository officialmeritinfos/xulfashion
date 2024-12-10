<?php

namespace App\Console\Commands;

use App\Jobs\SendEventThankYouMail;
use App\Mail\OrganizerThankYouMail;
use App\Models\UserEvent;
use App\Models\UserEventGuest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ConcludeRecurringEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:conclude-recurring-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Conclude recurring events when their end conditions are met.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch events with eventScheduleType != 1 and not already concluded
        $events = UserEvent::where('eventScheduleType', '!=', 1)
            ->where('status', 1)
            ->get();

        if ($events->count() > 0) {
            foreach ($events as $event) {
                // Determine the event's end date
                $endDate = determineEventEndDate($event);


                if ($endDate instanceof \DateTime) {
                    $now = new \DateTime('now', new \DateTimeZone($event->eventTimeZone));
                    $endDateFormatted = $endDate->format('Y-m-d H:i:s');
                    Log::info($endDateFormatted);
                    // Check if the event's end date has passed or recurrenceEndCount is met
                    if ($now > $endDate || ($event->recurrenceEndType == 2 && $event->currentRecurring >= $event->recurrenceEndCount)) {
                        // Mark the event as concluded
                        $event->update(['status' => 5]);

                        // Fetch event guests
                        $guests = UserEventGuest::where('event', $event->id)->get();

                        // Dispatch a job to send thank-you emails to guests
                        if ($guests->isNotEmpty()) {
                            SendEventThankYouMail::dispatch($guests, $event);
                        }

                        // Send thank-you email to the organizer
                        if ($event->user) {
                            Mail::to($event->users->email)->send(new OrganizerThankYouMail($event));
                        }

                        // Log the conclusion
                        Log::info("Recurring event '{$event->title}' (ID: {$event->reference}) concluded.");
                    }
                }
            }
            return 0;
        }
    }
}
