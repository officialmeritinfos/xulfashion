<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\User;
use App\Models\UserStore;
use App\Traits\Helpers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MovePendingBalanceToMain extends Command
{
    use Helpers;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:move-pending-balance-to-main';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move pending balance to main balance upon activating';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            //check all user account where the pending balance from store is greater than zero
            $users = User::where('isVerified',1)->get();
            if ($users->count()>0){
                foreach ($users as $user) {
                    //check if they have a store
                    $store = UserStore::where('user',$user->id)->first();
                    if (!empty($store) && $user->pendingBalanceStore > 0){

                        $newBalanceMain = bcadd($user->accountBalance,$user->pendingBalanceStore,5);
                        $user->accountBalance = bcadd($user->accountBalance,$user->pendingBalanceStore,5);

                        $newBalance = bcsub($user->pendingBalance,$user->pendingBalanceStore,5);
                        $user->pendingBalance = bcsub($user->pendingBalance,$user->pendingBalanceStore,5);

                        $user->pendingBalanceStore = bcsub($user->pendingBalanceStore,$user->pendingBalanceStore,5);
                        $user->pendingBalance = bcsub($user->pendingBalance, $user->pendingBalanceStore,5);



                        //check if the store is verified
                        if ($store->isVerified==1) {
                            //debit the merchant pending balance
                            $dataTransactionPending = [
                                'user'=>$user->id,'reference'=>$this->generateUniqueReference('transactions','reference'),
                                'transactionType'=>9,'amount'=>$user->pendingBalanceStore, 'currency'=>$user->mainCurrency,
                                'newBalance'=> $newBalance,'status'=>1
                            ];
                            //credit the merchant main balance
                            $dataTransactionMain = [
                                'user'=>$user->id,'reference'=>$this->generateUniqueReference('transactions','reference'),
                                'transactionType'=>10,'amount'=>$user->pendingBalanceStore, 'currency'=>$user->mainCurrency,
                                'newBalance'=> $newBalanceMain,'status'=>1
                            ];

                            $transaction = Transaction::create($dataTransactionPending);
                            $transaction1 = Transaction::create($dataTransactionMain);

                            if (!empty($transaction) && !empty($transaction1)){
                                $user->save();
                                DB::commit();
                            }
                        }
                    }
                }
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info($exception->getMessage().' on line '.$exception->getLine().' in file '.$exception->getFile());
        }
    }
}
