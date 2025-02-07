<?php

namespace App\Console\Commands;

use App\Custom\NombaPayment;
use App\Models\GeneralSetting;
use App\Models\SystemStaff;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserBank;
use App\Models\UserWithdrawal;
use App\Notifications\CustomNotificationMail;
use App\Notifications\StaffCustomNotification;
use App\Traits\Helpers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessNGNWithdrawals extends Command
{
    use Helpers;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-n-g-n-withdrawals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes NGN withdrawals';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $web = GeneralSetting::find(1);

        DB::beginTransaction();
        try {
            $withdrawals = UserWithdrawal::where([
                'toCurrency' => 'NGN',
                'status' => 4,
                'paymentStatus' => 4,
                'type' => 'withdrawals'
            ])->where('manualUpdate','!=',1)->get();

            if($withdrawals->count() > 0){
                foreach($withdrawals as $withdrawal){
                    $user = User::where('id', $withdrawal->user)->first();
                    //ensure user is active before processing withdrawal
                    if ($user->status==1){
                        //fetch bank details
                        $bank = UserBank::where([
                            'user' => $withdrawal->user,'reference' => $withdrawal->paymentDetails
                        ])->first();
                        if ($bank){
                            $transferData = [
                                'amount' => $withdrawal->amountCredit,
                                'accountNumber' => $bank->accountNumber,
                                'accountName' => $bank->accountName,
                                'bankCode'=>$bank->bank,
                                'merchantTxRef'=>$withdrawal->reference,
                                'senderName'=> $web->name,
                                'narration'=>"Payout from {$web->name}"
                            ];

                            $gateway = new NombaPayment();

                            //proceed to submitting
                            $response = $gateway->transferToExternalAccount($transferData);

                            if (!$response){
                                //notify admin
                                $admin = SystemStaff::where('role', 'superadmin')->first();
                                if ($admin){
                                    $message = "An error occurred while sending out payout for withdrawal {$withdrawal->reference}. Please look into this";
                                    $admin->notify(new StaffCustomNotification($admin,$message,'Payout Error'));
                                }
                            }else{
                                $response = $response->json();
                                logger($response);
                                if ($response['description']=='SUCCESS'){
                                    //update the withdrawal with the details
                                    $withdrawal->update([
                                        'status' => 1,
                                        'paymentStatus' => 1,
                                        'paymentReference' => $response['data']['id'],
                                        'timeUpdated' => time()
                                    ]);
                                    Transaction::where('withdrawalRef',$withdrawal->reference)->update([
                                        'status' => 1,
                                    ]);
                                }else{
                                    $withdrawal->update([
                                        'manualUpdate'=>1
                                    ]);
                                    $message = "
                                        The Payout with reference {$withdrawal->reference} did not process as it should, and needs
                                        a manual review and update.
                                    ";
                                    //send mail to the finance department
                                    $this->sendDepartmentMail('finance',$message,'Payout Needs manual review');
                                }
                            }
                        }
                    }
                }
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error processing withdrawal: '.$exception->getMessage());
        }
    }
}
