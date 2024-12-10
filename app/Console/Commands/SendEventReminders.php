<?php

namespace App\Console\Commands;

use App\Jobs\SendEventGuestNotifications;
use App\Models\UserEvent;
use App\Models\UserEventGuest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to event guests at specified intervals before the event start date.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get today's date
        $today = Carbon::now();

        // Define the intervals
        $intervals = [
            7 => '7 days before',
            4 => '4 days before',
            2 => '2 days before',
            1 => '1 day before',
            0 => 'Today'
        ];

        // Fetch events happening at the defined intervals
        foreach ($intervals as $days => $label) {
            $targetDate = $today->copy()->addDays($days);
            $events = UserEvent::where('startDate', '=', $targetDate->format('Y-m-d'))->where('status','=',1)->get();

            if ($events->count() >0){
                foreach ($events as $event) {
                    // Fetch all guests for this event
                    $guests = UserEventGuest::where('event', $event->id)->get();

                    if ($guests->isEmpty()) {
                        Log::info("No guests found for event: {$event->title} ({$label}).");
                        continue;
                    }
                    // Dispatch the job to send notifications
                    SendEventGuestNotifications::dispatch($guests, true, null,"Reminders for event: {$event->title}");
                    // Log successful scheduling
                    Log::info("Reminders for event: {$event->title} ({$label}) have been queued.");
                }
            }
        }

        return 0;
    }
}
