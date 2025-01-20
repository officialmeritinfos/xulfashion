<?php

namespace App\Livewire\Mobile\Users\Payments;

use App\Mail\DebitNotification;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserBank;
use App\Models\UserWithdrawal;
use App\Notifications\CustomNotification;
use App\Services\CurrencyExchangeService;
use App\Traits\Helpers;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class SettlementAccountActions extends Component
{
    use LivewireAlert,Helpers;
    public $bank;
    public $enteredOtp;
    public $withdrawAmount;
    public $otpVerified = false;
    public $otpResent = false;
    public $otpSent = false;

    public $amount = 1;
    public $convertedAmount=0;
    public $exchangeRate;
    public $userBalance;

    public $user;

    public $showError=false;
    public $errorMessage = '';

    public $showSuccess=false;
    public $successMessage = '';

    public $transferFee=0;

    protected $exchangeService;
    public $password;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'clearSuccessMessage' => 'resetSuccessMessage',
        'successWithdrawalMessage' => 'reloadSuccessMessage',
    ];

    public function resetSuccessMessage()
    {
        $this->showSuccess = false;
        $this->successMessage = '';
    }
    public function reloadSuccessMessage()
    {
        $this->showSuccess = false;
        $this->successMessage = '';
    }


    public function mount(UserBank $bank, CurrencyExchangeService $exchangeService)
    {
        $this->bank = $bank;
        $this->exchangeService = $exchangeService;

        $this->fetchExchangeRate();

        $this->userBalance = Auth::user()->accountBalance;

        $this->user = Auth::user();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
        <svg width="100%" height="100%" viewBox="0 0 500 200" preserveAspectRatio="none">
            <defs>
                <linearGradient id="table-skeleton-gradient">
                    <stop offset="0%" stop-color="#f0f0f0">
                        <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                    <stop offset="50%" stop-color="#e0e0e0">
                        <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                    <stop offset="100%" stop-color="#f0f0f0">
                        <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                </linearGradient>
            </defs>

            <!-- Table Header -->
            <rect x="10" y="10" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="10" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 1 -->
            <rect x="10" y="40" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="40" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 2 -->
            <rect x="10" y="70" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="70" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 3 -->
            <rect x="10" y="100" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="100" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
        </svg>

        </div>
        HTML;
    }

    // Activate the bank account
    public function activateAccount()
    {
        $this->bank->update(['status' => 1]);
        session()->flash('success', 'Account activated successfully.');
        $this->dispatch('refreshComponent');
    }

    // Deactivate the bank account
    public function deactivateAccount()
    {
        $this->bank->update(['status' => 2]);
        session()->flash('warning', 'Account deactivated successfully.');
        $this->dispatch('refreshComponent');
    }

    // Make the bank account primary
    public function makePrimary()
    {
        if ($this->bank->currency!=Auth::user()->mainCurrency){
            session()->flash('error', 'Primary Payout account must match your primary currency  '.Auth::user()->mainCurrency);
            return;
        }
        UserBank::where('user', Auth::user()->id)->update(['isPrimary' => 2]);
        $this->bank->update(['isPrimary' => 1]);
        session()->flash('success', 'Account set as primary.');
        $this->dispatch('refreshComponent');
    }

    // Delete the bank account
    public function deleteAccount()
    {
        //check if there is a transaction for this account
        $hasWithdrawal = UserWithdrawal::where('paymentDetails',$this->bank->reference)->count();
        if ($hasWithdrawal >0) {
            session()->flash('error', 'Account has processed some withdrawals. Please deactivate instead.');
            return;
        }
        $this->bank->delete();
        session()->flash('success', 'Account deleted successfully.');
        return redirect()->route('mobile.user.settlement.account.index');
    }

    /**
     * Live update the converted amount when the withdrawal amount changes.
     *
     * This method dynamically calculates the equivalent amount in the bank's currency
     * after conversion and deduction of applicable fees. It also validates minimum
     * withdrawal limits and checks for sufficient user balance.
     *
     * @param float $value The amount entered by the user for withdrawal (in the user's main currency).
     */
    public function updatedAmount($value)
    {
        // 1. Check if exchange rate is available and the entered amount is greater than zero.
        if ($this->exchangeRate && $value > 0) {

            // Fetch the user's main currency details.
            $userFiat = Fiat::where('code', $this->user->mainCurrency)->first();

            // 2. Validate if the entered amount meets the minimum withdrawal threshold.
            if ($value < $userFiat->minWithdrawal) {
                $this->errorMessage = "Amount cannot be less than the minimum of {$userFiat->sign}{$userFiat->minWithdrawal}";
                $this->showError = true;
                return;
            }

            // Fetch the receiving bank's currency details.
            $bankFiat = Fiat::where('code', $this->bank->currency)->first();

            // 3. Calculate the converted amount based on the exchange rate.
            $convertedRate = str_replace(',', '', number_format($value * $this->exchangeRate, 2));

            // 4. Calculate the transfer fee in the receiving currency.
            $fee = $this->calculateTransferFee($bankFiat, $convertedRate);
            $this->transferFee = $fee;

            // 5. Validate if the converted amount meets the bank's minimum withdrawal threshold.
            if ($convertedRate < $bankFiat->minWithdrawal) {
                $this->errorMessage = "Minimum withdrawable in {$bankFiat->code} must be at least {$bankFiat->sign}{$bankFiat->minWithdrawal}";
                $this->showError = true;
                $this->convertedAmount = str_replace(',', '', number_format($convertedRate - $fee, 2));
                return;
            }

            // 6. Compute the final amount after deducting the transfer fee.
            $this->convertedAmount = str_replace(',', '', number_format($convertedRate - $fee, 2));

            // 7. Check if the user has sufficient balance for the withdrawal.
            if ($value > $this->userBalance) {
                $this->errorMessage = "Insufficient balance in account.";
                $this->showError = true;
                return;
            }

            // Clear previous error if everything passes
            $this->errorMessage = null;
            $this->showError = false;

        } else {
            // If exchange rate is not available or the value is invalid, reset the converted amount.
            $this->convertedAmount = 0;
        }
    }

    /**
     * Fetches the exchange rate between the user's main currency and the bank's currency.
     *
     * This method retrieves the latest exchange rate using the exchange service and calculates
     * the converted amount based on the user's input. If the exchange rate cannot be fetched,
     * it logs the error and displays a user-friendly message.
     *
     * @param float|int $userAmount The amount entered by the user (default is 1 for initial load).
     * @return void
     */
    public function fetchExchangeRate(float|int $userAmount = 1): void
    {
        // Get the user's main currency and the bank's currency.
        $userCurrency = Auth::user()->mainCurrency;
        $bankCurrency = $this->bank->currency;

        try {
            // Attempt to fetch exchange rates for the user's currency.
            $rates = $this->exchangeService->getExchangeRate($userCurrency);

            // Check if the rates were successfully retrieved.
            if ($rates && isset($rates[strtolower($userCurrency)][strtolower($bankCurrency)])) {

                // 1. Store the exchange rate for further calculations.
                $this->exchangeRate = $rates[strtolower($userCurrency)][strtolower($bankCurrency)];

                // 2. Calculate the converted amount based on the exchange rate.
                $this->convertedAmount = str_replace(',', '', number_format($userAmount * $this->exchangeRate, 2));

                return;
            }

            // If rates are not retrieved, notify the user.
            session()->flash('error', 'Failed to fetch the exchange rate. Please try again later.');

        } catch (\Exception $exception) {
            // Handle any unexpected errors during the exchange rate fetch.
            session()->flash('error', 'An error occurred while fetching the exchange rate.');

            // Log the error for debugging.
            logger()->error("Exchange rate fetch error: " . $exception->getMessage());

            // Reset the exchange rate to prevent incorrect calculations.
            $this->exchangeRate = 0;
        }
    }


    /**
     * Calculate the withdrawal fee for the receiving currency.
     *
     * This function determines the appropriate transfer fee for a given fiat currency
     * based on whether the fee is charged in USD, a percentage, or as a fixed amount.
     *
     * @param Fiat $bankFiat The fiat currency model of the receiving bank.
     * @param float $amount The amount the user wants to withdraw.
     * @return float|int The calculated withdrawal fee in the bank's currency.
     */
    public function calculateTransferFee(Fiat $bankFiat, float $amount): float|int
    {
        // 1. Check if the transfer fee is set to be paid in USD.
        if ($bankFiat->transferFeeInUsd) {
            // Fetch the exchange rate for the bank's currency to USD.
            $rates = $this->exchangeService->getExchangeRate($bankFiat->code);

            if ($rates) {
                // Extract the exchange rate for the bank's currency to USD.
                $rate = $rates[strtolower($bankFiat->code)][strtolower('USD')];

                // Convert the fixed USD fee to the bank's local currency using the rate.
                return $bankFiat->fixedPayoutFee / $rate;
            }
        }

        // 2. Check if the bank charges a percentage-based transfer fee.
        if ($bankFiat->hasPercentageTransferFee) {
            // Calculate the percentage fee from the withdrawal amount.
            $percentageFee = $amount * ($bankFiat->percentTransferFee / 100);

            // Compare the calculated percentage fee with the fixed payout fee.
            // Use the higher fee to ensure minimum fee compliance.
            $fee = $percentageFee > $bankFiat->fixedPayoutFee
                ? $percentageFee  // Use the percentage fee if it's higher.
                : $bankFiat->fixedPayoutFee;  // Otherwise, use the fixed fee.

            return $fee;
        }

        // 3. Default: If no special fee condition applies, return the fixed payout fee.
        return $bankFiat->fixedPayoutFee;
    }
    public function render()
    {
        return view('livewire.mobile.users.payments.settlement-account-actions',[
            'bank' => $this->bank,
        ]);
    }
    // Send OTP
    public function sendOTP()
    {
        try {
            $user = Auth::user(); // Get the authenticated user
            $web = GeneralSetting::find(1); // Fetch general settings

            // Generate a new OTP
            $otp = $this->generateToken('users', 'reference');

            // Save OTP and expiration time
            $user->otp = bcrypt($otp);
            $user->otpExpires = now()->addMinutes($web->codeExpire);
            $user->save();

            // Compose the OTP notification message
            $message = "There is a new request on your account requiring an OTP. The OTP to use is <b>" . $otp . "</b>.
        <p>This OTP will expire in <b>" . $web->codeExpire . " minutes</b>. Note that neither " . $web->name . " nor her staff will ever ask you for your OTP.</p>";

            // Send the OTP notification
            $user->notify(new CustomNotification($user, $message, 'OTP Authentication'));

            // Set success message
            $this->otpSent = true;
            $this->showSuccess = true;
            $this->successMessage = 'OTP has been sent to your email. Use it to authenticate this action.';

            // Clear any previous errors
            $this->showError = false;
            $this->errorMessage = '';

            // Dispatch a browser event to clear the success message after 5 seconds
            $this->dispatch('clear-success-message');

            return;

        } catch (ThrottleRequestsException $exception) {
            // Handle too many OTP requests
            $this->showError = true;
            $this->errorMessage = 'You can only request OTP once every minute. Please wait.';
            return;
        } catch (\Exception $exception) {
            // Log any other error
            Log::error('Error on ' . $exception->getFile() . ' on line ' . $exception->getLine() . ': ' . $exception->getMessage());
            $this->showError = true;
            $this->errorMessage = 'Internal server error; we are working on this now.';
            return;
        }
    }
    //verify OTP
    public function verifyOTP(Request $request)
    {
        $this->validate([
            'enteredOtp' => ['required','digits:6'],
        ]);

        try {
            $user = Auth::user(); // Get the authenticated user


            $providedOtp = $this->enteredOtp;

            // Check if the OTP has expired
            if ($user->otpExpires < time()) {
                $this->showError = true;
                $this->errorMessage = 'The OTP has expired. Please request a new one.';
                return;
            }

            // Verify the OTP
            if (!Hash::check($providedOtp, $user->otp)) {
                $this->showError = true;
                $this->errorMessage = 'Invalid OTP. Please try again.';
                return;
            }

            $this->showSuccess = true;
            $this->successMessage ='OTP verified successfully.';

            $this->showError = false;
            $this->errorMessage='';

            $this->otpVerified = true;
            // Dispatch a browser event to clear the success message after 5 seconds
            $this->dispatch('clear-success-message');

            return;
        } catch (\Illuminate\Validation\ValidationException $exception) {
            $this->showError = true;
            $this->errorMessage = $exception->errors();

        } catch (\Exception $exception) {
            // Log and handle general errors
            Log::error('Error verifying OTP: ' . $exception->getMessage());

            $this->showError = true;
            $this->errorMessage = 'An error occurred while verifying the OTP. Please try again.';
        }
    }
    /**
     * Process the user's withdrawal request.
     *
     * @return void
     */
    public function processWithdrawal()
    {
        $this->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'convertedAmount' => ['required', 'numeric', 'min:1'],
            'enteredOtp' => ['required', 'digits:6'],
            'otpVerified' => ['required', 'boolean', 'accepted'],
            'password' => ['required', 'current_password:web'],
        ]);

        DB::beginTransaction();

        try {
            $user = User::where('id',$this->user->id)->first();
            $bank = $this->bank;
            $web = GeneralSetting::find(1);

            // Refresh the exchange rate to prevent frontend manipulation
            $this->exchangeService = new CurrencyExchangeService();
            $this->fetchExchangeRate();

            // Verify OTP
            if (!$this->otpVerified) {
                $this->showError = true;
                $this->errorMessage = 'Please verify your OTP before proceeding.';
                return;
            }

            if ($user->otpExpires < time()) {
                $this->showError = true;
                $this->errorMessage = 'The OTP has expired. Please request a new one.';
                return;
            }

            if (!Hash::check($this->enteredOtp, $user->otp)) {
                $this->showError = true;
                $this->errorMessage = 'Invalid OTP. Please try again.';
                return;
            }

            //check if account is active or not
            if ($bank->status !=1){
                $this->showError = true;
                $this->errorMessage = 'Withdrawal cannot take place - Account is inactive.';
                return;
            }

            // Fetch user and bank fiat currencies
            $userFiat = Fiat::where('code', $user->mainCurrency)->first();
            $bankFiat = Fiat::where('code', $bank->currency)->first();

            // Validate minimum withdrawal amount
            if ($this->amount < $userFiat->minWithdrawal) {
                $this->showError = true;
                $this->errorMessage = "Amount cannot be less than the minimum of {$userFiat->sign}{$userFiat->minWithdrawal}";
                return;
            }

            // Calculate converted amount and fee
            $convertedRate = str_replace(',', '', number_format($this->amount * $this->exchangeRate, 2));
            $fee = $this->calculateTransferFee($bankFiat, $convertedRate);

            if ($convertedRate < $bankFiat->minWithdrawal) {
                $this->showError = true;
                $this->errorMessage = "Minimum withdrawable in {$bankFiat->code} must be at least {$bankFiat->sign}{$bankFiat->minWithdrawal}";
                return;
            }

            $convertedAmount = str_replace(',', '', number_format($convertedRate - $fee, 2));

            // Check user's balance
            if ($this->amount > $this->userBalance) {
                $this->showError = true;
                $this->errorMessage = "Insufficient balance in account.";
                return;
            }

            // Deduct from user balance
            $user->decrement('accountBalance', $this->amount);
            $user->otp='';
            $user->otpExpires='';
            $user->save();

            // Create withdrawal record
            $withdrawal = UserWithdrawal::create([
                'user' => $user->id,
                'reference' => $this->generateUniqueReference('user_withdrawals', 'reference', 6),
                'currency' => $userFiat->code,
                'amount' => $this->amount,
                'amountCredit' => $convertedAmount,
                'channel' => 1,
                'paymentDetails' => $bank->reference,
                'type' => 'withdrawals',
                'fromCurrency' => $user->mainCurrency,
                'toCurrency' => $bank->currency,
                'rate' => $this->exchangeRate,
                'convertedAmount' => $convertedRate,
            ]);

            if ($withdrawal) {
                $user->refresh();

                // Log the transaction
                Transaction::create([
                    'user' => $user->id,
                    'reference' => $this->generateUniqueReference('transactions', 'reference', 20),
                    'currency' => $withdrawal->currency,
                    'amount' => $withdrawal->amount,
                    'transactionType' => 1,
                    'withdrawalRef' => $withdrawal->reference,
                    'status' => 2, // Pending
                    'newBalance' => $user->accountBalance,
                ]);

                DB::commit();

                // Log user activity
                UserActivity::create([
                    'user' => $user->id,
                    'title' => 'New Withdrawal',
                    'content' => "A withdrawal of {$userFiat->sign}" . number_format($this->amount, 2) . " has been authenticated on your {$web->name} account. This should arrive within 24 hours.",
                ]);

                //Send mail to user
                Mail::to($user->email)->queue(new  DebitNotification($user, $withdrawal, $userFiat, $bank, $bankFiat));

                // Show success message
                $this->showSuccess = true;
                $this->successMessage = "Withdrawal to {$bank->bankName} ({$bank->accountName}) was successful. Funds should arrive within 24 hours.";

                // Trigger browser event for UI feedback
                $this->dispatch('success-withdrawal-message',url:url()->previous());
            }

        } catch (\Exception $exception) {
            DB::rollBack();

            // Log error and show feedback
            Log::error('Error processing withdrawal: ' . $exception->getMessage());
            $this->showError = true;
            $this->errorMessage = 'An error occurred during the withdrawal. Please try again.';
        }
    }

}
