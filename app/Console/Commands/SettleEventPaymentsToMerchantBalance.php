<?php

namespace App\Console\Commands;

use App\Mail\AccountCreditedMail;
use App\Mail\EventBalanceSettledMail;
use App\Models\Fiat;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserEventSettlement;
use App\Services\CurrencyExchangeService;
use App\Traits\Helpers;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SettleEventPaymentsToMerchantBalance extends Command
{
    use Helpers;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:settle-event-payments-to-merchant-balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will settle event payments to the merchant balance';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            // Fetch events where current time >= nextSettlement, considering eventTimeZone
            $events = UserEvent::whereNotNull('nextSettlement')
                ->where('currentBalance', '>', 0)
                ->get();
            $settledEvents = 0;

            foreach ($events as $event) {
                // Convert the nextSettlement time to Carbon based on the event's timezone
                $eventTimeZone = $event->eventTimeZone ?? 'UTC';
                $nextSettlementTime = Carbon::parse($event->nextSettlement, $eventTimeZone);
                // Compare with the current time in the event's timezone
                if (Carbon::now($eventTimeZone)->greaterThanOrEqualTo($nextSettlementTime)) {
                    // Fetch the user
                    $user = User::find($event->user);
                    if ($user) {
                        //fetch exchange rate
                        $rate = $this->fetchExchangeRate($user, $event);
                        if ($rate) {
                            $userFiat = Fiat::where('code',$user->mainCurrency)->first();
                            $eventFiat = Fiat::where('code',$event->currency)->first();
                            // Transfer currentBalance to the user's accountBalance
                            $convertedAmount = $event->currentBalance * $rate;
                            $amount = $event->currentBalance;
                            $user->accountBalance += $convertedAmount;
                            $user->save();

                            // Update the event as settled
                            $event->balanceCleared +=$event->currentBalance;
                            $event->currentBalance = 0;
                            $event->save();

                            //create a record of this settlement
                            $settlement = UserEventSettlement::create([
                                'user' => $event->user,
                                'event' => $event->id,
                                'reference' => $this->generateUniqueReference('user_event_settlements','reference',6),
                                'amount' => $amount,
                                'currency' =>$event->currency,
                                'payoutAccount'=>'balance',
                                'fromCurrency' => $event->currency,
                                'toCurrency' => $user->mainCurrency,
                                'convertedAmount'=>$convertedAmount,
                                'exchangeRate' => $rate,
                                'type' =>1,
                                'transactionId'=>$this->generateUniqueReference('user_event_settlements','transactionId',8),
                                'payoutStatus'=>1,'status' => 1
                            ]);
                            //record on transaction
                            Transaction::create([
                                'user' => $user->id,
                                'reference' => $settlement->reference,
                                'transactionType' => 11,
                                'amount' => $amount,
                                'currency' => $user->mainCurrency,
                                'status' => 1
                            ]);
                            Mail::to($user->email)->send(new EventBalanceSettledMail(
                                $user,
                                $event,
                                $amount,
                                $eventFiat,
                                $convertedAmount,
                                $userFiat,
                                $settlement,
                                now()
                            ));
                            Mail::to($user->email)->queue(new AccountCreditedMail(
                                $user,
                                $convertedAmount,
                                $userFiat,
                                $settlement->transactionId, $event->title.' Balance Settlement',
                                $user->accountBalance,
                                now()
                            ));
                            $settledEvents++;

                            // Log the settlement for audit purposes
                            Log::info("Settled {$event->title} for user {$user->name}. Amount: {$eventFiat->sign}{$event->currentBalance}");
                        }
                    }
                }
            }
            DB::commit();
            $this->info("Settlement completed for {$settledEvents} event(s).");
        }catch (\Exception $e){
            DB::rollBack();
            Log::error('Error settling user event balances: ' . $e->getMessage());
        }
    }
    public function fetchExchangeRate(User $user, UserEvent $event, $userAmount=1)
    {
        // Get the user's main currency and the bank's currency.
        $userCurrency = $user->mainCurrency;
        $eventCurrency = $event->currency;

        try {
            // Attempt to fetch exchange rates for the user's currency.
            $exchangeService = new CurrencyExchangeService();
            $rates = $exchangeService->getExchangeRate($eventCurrency);

            // Check if the rates were successfully retrieved.
            if ($rates && isset($rates[strtolower($eventCurrency)][strtolower($userCurrency)])) {

                // 1. Store the exchange rate for further calculations.
                $exchangeRate = $rates[strtolower($eventCurrency)][strtolower($userCurrency)];

                // 2. Calculate the converted amount based on the exchange rate.
                $convertedAmount = str_replace(',', '', number_format($userAmount * $exchangeRate, 2));

                return $exchangeRate;
            }
            // If rates are not retrieved, notify the user.
            logger('Failed to fetch the exchange rate. Please try again later.');

            return null;


        } catch (\Exception $exception) {
            // Log the error for debugging.
            logger()->error("Exchange rate fetch error: " . $exception->getMessage());
            return null;
        }
    }
}
