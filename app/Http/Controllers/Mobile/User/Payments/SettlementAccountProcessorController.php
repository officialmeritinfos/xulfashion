<?php

namespace App\Http\Controllers\Mobile\User\Payments;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
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
     * Process the addition of a local settlement (payout) account.
     * This method is used for currencies other than USD, GBP, and EUR.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processLocalSettlementAccount(Request $request)
    {
        $user = Auth::user();  // Get the authenticated user
        $web = GeneralSetting::find(1);  // Fetch general site settings
        $country = Country::where('iso3', $user->countryCode)->first();  // Get user's country details
        $mainCurrency = PayoutCurrency::getCurrencyOrDefault($country->currency);  // Get the main currency for the country

        // Fetch the payout currency to access its meta fields
        $payoutCurrency = PayoutCurrency::where('currency', $request->currency)->first();

        // Base validation rules for payout account setup
        $rules = [
            'currency' => [
                'required', 'alpha:ascii',
                Rule::exists('payout_currencies', 'currency')->where('currency', $mainCurrency->currency)
            ],
            'hasBranch' => ['required', 'boolean'],
            'validateAccount' => ['required', 'boolean'],
            'account_bank' => ['required', 'string'],
            'destination_branch_code' => ['required_if:hasBranch,true', 'nullable', 'string'],
            'destinationName' => ['required_if:hasBranch,true', 'nullable', 'string'],
            'account_number' => ['required', 'string', 'max:150'],
            'account_name' => ['required_if:validateAccount,true', 'nullable', 'string'],
            'password' => ['required', 'current_password:web'],
            'otp' => ['required', 'numeric', 'digits:6'],
            'bankName' => ['required', 'string'],
        ];

        // Dynamically add validation rules for meta fields if they exist
        if (!empty($payoutCurrency->meta)) {
            $metaFields = json_decode($payoutCurrency->meta, true);

            foreach ($metaFields['fields'] ?? [] as $field) {
                $rules[$field] = ['required', 'string', 'max:255'];
            }
        }

        // Validate the request data
        $validator = Validator::make($request->all(), $rules)->stopOnFirstFailure();

        if ($validator->fails()) {
            return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
        }

        $input = $validator->validated();

        DB::beginTransaction();
        try {
            // Validate the account details if required
            if ($request->validateAccount) {
                $response = $this->validateBankDetails($input['account_bank'], $input['account_number']);

                if (!$response['success']) {
                    return $this->sendError('validation.error', [
                        'error' => $response['message']
                    ]);
                }

                // Update the account name if validation is successful
                $input['account_name'] = $response['account']['account_name'];
            }

            $providedOtp = $request->otp;

            // Check if the OTP has expired
            if ($user->otpExpires < time()) {
                return response()->json([
                    'status' => false,
                    'message' => 'The OTP has expired. Please request a new one.',
                ]);
            }
            // Verify the OTP
            if (!Hash::check($providedOtp, $user->otp)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP. Please try again.',
                ]);
            }

            // Clear the OTP to prevent reuse
            $user->otp = null;
            $user->otpExpires = null;
            $user->save();
            // Create a new payout account record
            $payoutAccount = UserBank::create([
                'user' => $user->id,
                'bank' => $input['account_bank'],
                'bankName' => $input['bankName'],
                'accountNumber' => $input['account_number'],
                'reference' => $this->generateUniqueReference('user_banks', 'reference', 7),
                'accountName' => $input['account_name']??$user->name,
                'destination_branch_code' => $input['destination_branch_code'] ?? null,
                'destination_branch_name' => $input['destinationName']??null,
                'currency' => $input['currency'],
                'meta' => json_encode(array_intersect_key($input, array_flip($metaFields['fields'] ?? [])))
            ]);


            DB::commit();

            // Log user activity
            $message = 'A new payout account has been added to your account on ' . $web->name;
            UserActivity::create([
                'user' => $user->id,
                'title' => 'New Payout Account',
                'content' => $message
            ]);

            // Send email notification to the user
            Mail::to($user->email, $user->name)->send(new PayoutAccountAddedMail($user, $payoutAccount));

            // Return success response with redirect
            return $this->sendResponse([
                'redirectTo' => url()->previous()
            ], 'Payout account successfully added.');

        } catch (\Exception $exception) {
            DB::rollBack();
            logger('Error adding local settlement account: ' . $exception->getMessage());

            return $this->sendError('server.error', [
                'error' => 'A server error occurred. We are unable to process your request.'
            ]);
        }
    }


}
