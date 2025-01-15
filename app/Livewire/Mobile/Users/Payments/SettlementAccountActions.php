<?php

namespace App\Livewire\Mobile\Users\Payments;

use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\UserBank;
use App\Models\UserWithdrawal;
use App\Notifications\CustomNotification;
use App\Services\CurrencyExchangeService;
use App\Traits\Helpers;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class SettlementAccountActions extends Component
{
    use LivewireAlert,Helpers;
    public $bank;
    public $otp;
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

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function mount(UserBank $bank, CurrencyExchangeService $exchangeService)
    {
        $this->bank = $bank;
        $this->exchangeService = $exchangeService;

        $this->fetchExchangeRate();

        $this->userBalance = Auth::user()->accountBalance;

        $this->user = Auth::user();
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
    //send OTP
    public function sendOTP()
    {
        try {
            $user = Auth::user(); // Get the authenticated user
            $web = GeneralSetting::find(1); // Fetch general settings

            // Generate a new OTP
            $otp = $this->generateToken('users', 'reference');
            // Save OTP and expiration time
            $user->otp = bcrypt($otp);
            $user->otpExpires = strtotime('+' . $web->codeExpire, time());
            $user->save();

            // Compose the OTP notification message
            $message = "There is a new request on your account requiring an OTP. The OTP to use is <b>" . $otp . "</b>.
            <p>This OTP will expire in <b>" . $web->codeExpire . "</b>. Note that neither " . $web->name . " nor her staff will ever ask you for your OTP.</p>";

            // Send the OTP notification
            $user->notify(new CustomNotification($user, $message, 'OTP Authentication'));

            $this->otpSent = true;

            $this->showSuccess = true;
            $this->successMessage = 'OTP has been sent to your email. Use it to authenticate this action.';

            $this->showError = false;
            $this->errorMessage='';

            return;

        } catch (ThrottleRequestsException $exception) {
            // Return a throttling error response
            $this->showError = true;
            $this->errorMessage='You can only request for OTP once every minute. Please wait.';
        } catch (\Exception $exception) {
            // Log the exception and return a generic error response
            Log::error('Error on ' . $exception->getFile() . ' on line ' . $exception->getLine() . ': ' . $exception->getMessage());
            $this->showError = true;
            $this->errorMessage='Internal server error; we are working on this now.';
        }
    }
    //resend OTP
    public function resendOTP()
    {

    }
    //verify OTP
    public function verifyOTP()
    {

    }

    public function processWithdrawal()
    {

    }
}
