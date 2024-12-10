<?php

namespace App\Console\Commands;

use App\Jobs\SendEventNotificationMail;
use App\Models\UserEvent;
use App\Models\UserEventGuest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NotifyNextOccurrence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-next-occurrence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify guests of the next occurrence for recurring events';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = UserEvent::where('eventScheduleType', '!=', 1)
            ->where('status', '!=', 5) // Not concluded
            ->where('currentRecurring', '>=', 1)
            ->get();

        if ($events->count() > 0) {
            foreach ($events as $event) {
                try {
                    $timezone = new \DateTimeZone($event->eventTimeZone);

                    // Current time in the event's timezone
                    $now = Carbon::now($timezone);

                    // Start date and time of the event
                    $startDateTime = Carbon::parse("{$event->startDate} {$event->startTime}", $timezone);

                    // Recurrence interval
                    $intervalValue = extractIntervalFromRecurrenceInterval($event->recurrenceInterval);
                    $intervalPeriod = extractPeriodFromRecurrenceInterval($event->recurrenceInterval);

                    // Calculate the next occurrence
                    $nextOccurrence = (clone $startDateTime)
                        ->add(new \DateInterval('P' . ($intervalValue * $event->currentRecurring) . strtoupper(substr($intervalPeriod, 0, 1))));

                    // Skip if the next occurrence is in the past
                    if ($now > $nextOccurrence) {
                        continue;
                    }

                    // Fetch guests for the event
                    $guests = UserEventGuest::where('event', $event->id)->get();

                    // Notify guests
                    if ($guests->isNotEmpty()) {
                        foreach ($guests as $guest) {
                            SendEventNotificationMail::dispatch($guest, $event, $nextOccurrence);
                        }

                        Log::info("Guests notified for next occurrence of event '{$event->title}' (ID: {$event->id}) on {$nextOccurrence->toDateTimeString()}.");
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to notify guests for event '{$event->title}' (ID: {$event->id}): " . $e->getMessage());
                }
            }

            return 0;
        }
    }
}
