<?php

namespace App\Console\Commands;

use App\Jobs\SendEventNotificationMail;
use App\Models\UserEvent;
use App\Models\UserEventGuest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendNextOccurrenceReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-next-occurrence-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to guests for the next occurrence';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $events = UserEvent::where('eventScheduleType', '!=', 1)
            ->where('status', 1) // Active events only
            ->whereDate('nextOccurrence', '=', $now->addDay()->toDateString()) // 1 day before next occurrence
            ->get();

        if ($events->count() >0){
            foreach ($events as $event) {
                try {
                    // Fetch guests
                    $guests = UserEventGuest::where('event', $event->id)->get();

                    if ($guests->isNotEmpty()) {
                        foreach ($guests as $guest) {
                            // Dispatch reminder email
                            SendEventNotificationMail::dispatch($guest, $event, $event->nextOccurrence);
                        }

                        Log::info("Reminders sent for event '{$event->title}' (ID: {$event->reference}).");
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to send reminders for event '{$event->title}' (ID: {$event->reference}): " . $e->getMessage());
                }
            }

            return 0;
        }
    }
}
