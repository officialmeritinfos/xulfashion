<?php

namespace App\Console\Commands;

use App\Mail\SendEventBuyerMailAboutPurchaseCancellation;
use App\Mail\SendEventMerchantMailAboutPurchaseCancellation;
use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventPurchaseTicket;
use App\Models\UserEventTicket;
use App\Models\UserEventTicketBuyer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ReturnTicketIfNotPaid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:return-ticket-if-not-paid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will return the ticket back to the Event Ticket is payment is not received within 24 Hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find purchases eligible for refund
        $eligiblePurchases = UserEventPurchase::where('paymentStatus', 2)
            ->where('created_at', '<=', Carbon::now()->subHours(48))
            ->get();
        if ($eligiblePurchases->count() > 0){
            foreach ($eligiblePurchases as $purchase){
                $event = UserEvent::where('id',$purchase->event_id)->first();
                // Retrieve related tickets for this purchase
                $tickets = UserEventPurchaseTicket::where('user_event_purchase_id',$purchase->id)->get();
                foreach ($tickets as $purchaseTicket){
                    $eventTicket = UserEventTicket::where('id',$purchaseTicket->ticket_id)->first();

                    if ($eventTicket) {
                        // Add the quantity back to the UserEventTicket
                        if ($eventTicket->unlimited==1){
                            $eventTicket->decrement('ticketSold',$purchaseTicket->quantity);
                        }else{
                            $eventTicket->update([
                                'ticketSold' => $eventTicket->ticketSold - $purchaseTicket->quantity,
                                'quantity' => $eventTicket->quantity + $purchaseTicket->quantity,
                            ]);
                        }
                        $buyer = UserEventTicketBuyer::where('id',$purchase->buyer)->first();
                        $merchant = User::where('id',$event->user)->first();
                        //send email to merchant & Buyer
                        Mail::to($merchant->email)->queue(new SendEventMerchantMailAboutPurchaseCancellation(
                            $merchant, $event, $buyer,$purchase
                        ));
                        Mail::to($buyer->email)->queue(new SendEventBuyerMailAboutPurchaseCancellation(
                            $event, $buyer,$purchase
                        ));
                    }
                }
                $purchase->update([
                    'paymentStatus'=>3
                ]);
            }
        }
    }
}
