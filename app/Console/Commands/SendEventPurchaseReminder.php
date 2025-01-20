<?php

namespace App\Console\Commands;

use App\Mail\SendEventPurchaseReminderToBuyer;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventTicketBuyer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEventPurchaseReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-purchase-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify the event ticket buyer to complete their payment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Define time intervals for reminders in minutes
        $intervals = [40, 360, 1440, 1800];
        foreach ($intervals as $interval) {
            $this->sendReminderForInterval($interval);
        }
    }
    /**
     * Send reminders for purchases based on a specific interval.
     *
     * @param int $interval
     */
    private function sendReminderForInterval($interval)
    {
        $timeThreshold = Carbon::now()->subMinutes($interval);

        // Fetch purchases with paymentStatus = 2 (incomplete) and created_at within the interval
        $purchases = UserEventPurchase::where('paymentStatus', 2)
            ->where('created_at', '<=', $timeThreshold)
            ->get();

        foreach ($purchases as $purchase) {
            // Send email to the buyer
            $this->sendReminderEmail($purchase);

        }
    }
    /**
     * Send the reminder email to the buyer.
     *
     * @param UserEventPurchase $purchase
     */
    private function sendReminderEmail($purchase)
    {
        $buyer = UserEventTicketBuyer::where('id',$purchase->buyer)->first();
        $event = UserEvent::where('id',$purchase->event_id)->first();

        if (!$buyer->email) {
            logger("No email found for Purchase ID: {$purchase->id}");
            return;
        }

        // Send the email
        Mail::to($buyer->email)->send(new SendEventPurchaseReminderToBuyer(
            $event,$purchase,$buyer
        ));
    }
}
