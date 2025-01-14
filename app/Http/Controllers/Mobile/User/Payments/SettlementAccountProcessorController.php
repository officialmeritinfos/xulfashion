<?php

namespace App\Http\Controllers\Mobile\User\Payments;

use App\Http\Controllers\BaseController;
use App\Mail\PayoutAccountAddedMail;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\PayoutCurrency;
use App\Models\UserActivity;
use App\Models\UserBank;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SettlementAccountProcessorController extends BaseController
{
    use Helpers;

    /**
     * General method to process any type of settlement account.
     * Handles local, international, and USD payout accounts.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $type ('local', 'international', or 'usd')
     * @return \Illuminate\Http\JsonResponse
     */
    public function processSettlementAccount(Request $request, string $type)
    {
        $user = Auth::user();  // Get the authenticated user
        $web = GeneralSetting::find(1);  // Fetch general site settings
        $country = Country::where('iso3', $user->countryCode)->first();  // Get user's country details

        // Fetch the payout currency details
        $payoutCurrency = PayoutCurrency::where('currency', $request->currency)->first();

        // Determine validation rule for currency based on the account type
        $currencyRule = match ($type) {
            'usd' => Rule::exists('payout_currencies', 'currency')->where('currency', 'USD'),
            'international' => Rule::exists('payout_currencies', 'currency')->where('is_international', true),
            'local' => Rule::exists('payout_currencies', 'currency')->where('currency', $country->currency),
            default => Rule::exists('payout_currencies', 'currency')
        };

        // Base validation rules
        $rules = [
            'currency' => ['required', 'alpha:ascii', $currencyRule],
            'account_bank' => ['required', 'string'],
            'account_number' => ['required', 'string', 'max:150'],
            'password' => ['required', 'current_password:web'],
            'otp' => ['required', 'numeric', 'digits:6'],
        ];

        // Additional validation for local accounts
        if ($type === 'local') {
            $rules['hasBranch'] = ['required', 'boolean'];
            $rules['validateAccount'] = ['required', 'boolean'];
            $rules['destination_branch_code'] = ['required_if:hasBranch,true', 'nullable', 'string'];
            $rules['destinationName'] = ['required_if:hasBranch,true', 'nullable', 'string'];
            $rules['bankName'] = ['required', 'string'];
        }

        // Add dynamic validation for meta fields if they exist
        if (!empty($payoutCurrency->meta)) {
            $metaFields = json_decode($payoutCurrency->meta, true);
            foreach ($metaFields['fields'] ?? [] as $field) {
                $rules[$field] = ['required', 'string', 'max:255'];
            }
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules)->stopOnFirstFailure();
        if ($validator->fails()) {
            return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
        }

        $input = $validator->validated();

        DB::beginTransaction();
        try {
            // ✅ Account Validation for Local Accounts
            if ($type === 'local' && $request->validateAccount) {
                $response = $this->validateBankDetails($input['account_bank'], $input['account_number']);

                if (!$response['success']) {
                    return $this->sendError('validation.error', [
                        'error' => $response['message']
                    ]);
                }

                // Update account name if validation passes
                $input['account_name'] = $response['account']['account_name'];
            }

            // ✅ OTP Verification
            if ($user->otpExpires < time()) {
                return $this->sendError('otp.error', ['error' => 'The OTP has expired. Please request a new one.']);
            }

            if (!Hash::check($request->otp, $user->otp)) {
                return $this->sendError('otp.error', ['error' => 'Invalid OTP. Please try again.']);
            }

            // Clear OTP after successful verification
            $user->otp = null;
            $user->otpExpires = null;
            $user->save();

            // ✅ Create the payout account
            $payoutAccount = UserBank::create([
                'user' => $user->id,
                'bank' => $input['account_bank'],
                'bankName' => $input['bankName'] ?? $input['account_bank'],
                'accountNumber' => $input['account_number'],
                'accountName' => $input['account_name'] ?? $user->name,
                'reference' => $this->generateUniqueReference('user_banks', 'reference', 7),
                'currency' => $input['currency'],
                'destination_branch_code' => $input['destination_branch_code'] ?? null,
                'destination_branch_name' => $input['destinationName'] ?? null,
                'meta' => json_encode(array_intersect_key($input, array_flip($metaFields['fields'] ?? [])))
            ]);

            DB::commit();

            // ✅ Log user activity
            $message = 'A new payout account has been added to your account on ' . $web->name;
            UserActivity::create([
                'user' => $user->id,
                'title' => 'New Payout Account',
                'content' => $message
            ]);

            // ✅ Send email notification
            Mail::to($user->email, $user->name)->send(new PayoutAccountAddedMail($user, $payoutAccount));

            return $this->sendResponse([
                'redirectTo' => url()->previous()
            ], 'Payout account successfully added.');

        } catch (\Exception $exception) {
            DB::rollBack();
            logger('Error adding settlement account: ' . $exception->getMessage());

            return $this->sendError('server.error', [
                'error' => 'A server error occurred. We are unable to process your request.'
            ]);
        }
    }


    /**
     * Process Local Settlement Account
     */
    public function processLocalSettlementAccount(Request $request)
    {
        return $this->processSettlementAccount($request, 'local');
    }

    /**
     * Process International Settlement Account
     */
    public function processInternationalSettlementAccount(Request $request)
    {
        return $this->processSettlementAccount($request, 'international');
    }

    /**
     * Process USD Settlement Account
     */
    public function processUSDSettlementAccount(Request $request)
    {
        return $this->processSettlementAccount($request, 'usd');
    }
}
