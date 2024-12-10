<?php

namespace App\Console\Commands;

use App\Models\UserEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateRecurringEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-recurring-events';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Update currentRecurring and nextOccurrence for recurring events';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $events = UserEvent::where('eventScheduleType', '!=', 1)
            ->where('status', 1) // Active events only
            ->where(function ($query) use ($now) {
                $query->where('nextOccurrence', '<=', $now)
                    ->orWhereNull('nextOccurrence'); // Include events where nextOccurrence is null
            })
            ->get();

        if ($events->count() > 0) {
            foreach ($events as $event) {
                try {
                    $timezone = new \DateTimeZone($event->eventTimeZone);

                    // If nextOccurrence is null, calculate from startDate and recurrenceInterval
                    if (is_null($event->nextOccurrence)) {
                        $intervalValue = extractIntervalFromRecurrenceInterval($event->recurrenceInterval);
                        $intervalPeriod = extractPeriodFromRecurrenceInterval($event->recurrenceInterval);

                        $event->nextOccurrence = Carbon::parse("{$event->startDate} {$event->startTime}", $timezone)
                            ->add(new \DateInterval('P' . $intervalValue . strtoupper(substr($intervalPeriod, 0, 1))));
                    } else {
                        // Increment currentRecurring
                        $event->currentRecurring += 1;

                        // Calculate the new nextOccurrence
                        $intervalValue = extractIntervalFromRecurrenceInterval($event->recurrenceInterval);
                        $intervalPeriod = extractPeriodFromRecurrenceInterval($event->recurrenceInterval);
                        $event->nextOccurrence = Carbon::parse($event->nextOccurrence, $timezone)
                            ->add(new \DateInterval('P' . $intervalValue . strtoupper(substr($intervalPeriod, 0, 1))));
                    }

                    // Update event
                    $event->save();

                    $this->info("Updated recurring event '{$event->title}' (ID: {$event->reference}).");
                } catch (\Exception $e) {
                    $this->error("Failed to update event '{$event->title}' (ID: {$event->reference}): " . $e->getMessage());
                }
            }
        } else {
            $this->info('No events found to update.');
        }

        return 0;
    }
}
