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
        if (!$web) {
            Log::error('General settings not found.');
            return;
        }

        DB::beginTransaction();
        try {
            // Fetch all pending NGN withdrawals
            $withdrawals = UserWithdrawal::where([
                'toCurrency' => 'NGN',
                'status' => 4,
                'paymentStatus' => 4,
                'type' => 'withdrawals'
            ])->where('manualUpdate', '!=', 1)->get();

            if ($withdrawals->isEmpty()) {
                Log::info('No pending NGN withdrawals to process.');
                DB::rollBack();
                return;
            }

            foreach ($withdrawals as $withdrawal) {
                $user = User::find($withdrawal->user);

                // Ensure user exists and is active before processing withdrawal
                if (!$user || $user->status != 1) {
                    Log::warning("Skipping withdrawal {$withdrawal->reference}: User is inactive or not found.");
                    continue;
                }

                // Fetch user's bank details
                $bank = UserBank::where([
                    'user' => $withdrawal->user,
                    'reference' => $withdrawal->paymentDetails
                ])->first();

                if (!$bank) {
                    Log::warning("Skipping withdrawal {$withdrawal->reference}: No valid bank details found.");
                    continue;
                }

                $transferData = [
                    'amount' => $withdrawal->amountCredit,
                    'accountNumber' => $bank->accountNumber,
                    'accountName' => $bank->accountName,
                    'bankCode' => $bank->bank,
                    'merchantTxRef' => time(),
                    'senderName' => $web->name,
                    'narration' => "Payout from {$web->name}"
                ];

                $gateway = new NombaPayment();
                $response = $gateway->transferToExternalAccount($transferData);

                if (!$response) {
                    Log::error("Payout error: No response received for withdrawal {$withdrawal->reference}");
                    $admin = SystemStaff::where('role', 'superadmin')->first();
                    if ($admin) {
                        $message = "An error occurred while sending out payout for withdrawal {$withdrawal->reference}. Please investigate.";
                        $admin->notify(new StaffCustomNotification($admin, $message, 'Payout Error'));
                    }
                    continue;
                }

                $responseData = $response->json();

                if (!isset($responseData['description']) || $responseData['description'] !== 'SUCCESS') {
                    // Mark for manual review
                    $withdrawal->update(['manualUpdate' => 1]);

                    $message = "The Payout with reference {$withdrawal->reference} failed and requires manual review.";
                    Log::warning($message);

                    // Notify finance department
                    $this->sendDepartmentMail('finance', $message, 'Payout Needs Manual Review');
                    continue;
                }

                // Update withdrawal details
                $withdrawal->update([
                    'status' => 1,
                    'paymentStatus' => 1,
                    'paymentReference' => $responseData['data']['id'] ?? null,
                    'timeUpdated' => time()
                ]);

                // Update transaction status
                Transaction::where('withdrawalRef', $withdrawal->reference)->update(['status' => 1]);

            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error processing withdrawals: ' . $exception->getMessage());
        }
    }
}
