<?php

namespace App\Http\Controllers\Mobile\User\Payments;

use App\Custom\Flutterwave;
use App\Custom\NombaPayment;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Notifications\CustomNotification;
use App\Traits\Helpers;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class BankFetchingController extends BaseController
{
    use Helpers;
    /**
     * Fetches the list of banks for a specific country and returns only the name and code.
     *
     * This method determines the payment provider based on the provided country code.
     * If the country is Nigeria (`NG`), it uses NombaPayment; otherwise, it defaults to Flutterwave.
     * It extracts only the `name` and `code` fields from the banks array and returns them.
     *
     * @param string $default The country code for which the bank list is to be fetched. Defaults to 'NG' (Nigeria).
     *
     * @return \Illuminate\Http\JsonResponse
     *         A JSON response containing the list of banks (name and code) or an error message if no banks are found.
     */
    public function fetchBanksByCountry($default = 'NG')
    {
        // Determine the payment provider based on the country
        $provider = $default === 'NG' ? new NombaPayment() : new Flutterwave();
        // Fetch banks from the respective provider
        $response = $default === 'NG' ? $provider->fetchBanks() : $provider->fetchBank($default);

        if ($response && $response->ok()) {
            // Extract the banks array and map it to include only name, code, and id (when available)
            $banks = collect($response->json()['data'])->map(function ($bank) use ($default) {
                return [
                    'name' => $bank['name'] ?? null,
                    'code' => $bank['code'] ?? null,
                    'id' => $default !== 'NG' ? ($bank['id'] ?? null) : null, // Include id only for non-NGN responses,
                    'url'=>route('mobile.user.payments.payout-method.fetch-bank-branch-code',['bankId'=>$default !== 'NG' ? ($bank['id'] ?? null) : null])
                ];
            })
                ->filter(function ($bank) {
                    return !empty($bank['name']) && !empty($bank['code']);
                })
                ->sortBy('name') // Sort alphabetically by name
                ->values();      // Reindex the collection

            // Return a success response with the filtered banks array
            return $this->sendResponse([
                'redirects' => false,
                'banks' => $banks,
            ], 'Banks Retrieved');
        }

        // Return an error response if the fetch fails
        return $this->sendError('bank.error', ['error' => 'No banks found for your country. Please add a USD account instead.']);
    }
    /**
     * Fetches the branch codes for a specific bank using its ID.
     *
     * This method retrieves the list of branches for a given bank ID from the Flutterwave API.
     * It filters the response data to include only non-null `branch_name` and `branch_code`.
     * If branches are found, it returns them in a success response; otherwise, it returns an error.
     *
     * @param string|int $id The ID of the bank for which branch codes are to be fetched.
     *
     * @return \Illuminate\Http\JsonResponse
     *         A success response with the list of branches or an error response if no branches are found.
     */
    public function fetchBankBranchCode($id)
    {
        $provider = new Flutterwave();
        $response = $provider->fetchBankBranches($id);

        if ($response && $response->ok()) {
            // Extract the branch data and filter to include only non-null names and codes
            $branches = collect($response->json()['data'])->map(function ($branch) {
                return [
                    'branch_name' => $branch['branch_name'] ?? null,
                    'branch_code' => $branch['branch_code'] ?? null,
                ];
            })->filter(function ($branch) {
                return !empty($branch['branch_name']) && !empty($branch['branch_code']);
            })->values(); // Re-index the collection

            return $this->sendResponse([
                'branches' => $branches,
            ], 'Branch codes retrieved successfully.');
        }
        // Return an error response if no branches were found
        return $this->sendError('bank.branch.error', ['error' => 'No branch found for this bank. Please select another bank.']);
    }
    /**
     * Retrieves and standardizes bank account details based on the country.
     *
     * This method determines the appropriate payment provider (Nomba or Flutterwave)
     * based on the provided country. It sends a request to the respective API to fetch
     * the bank account details using the bank code and account number. The response is
     * then standardized to ensure consistency regardless of the provider.
     *
     * @param string $bank The code of the bank.
     * @param string $accountNumber The bank account number to validate.
     * @param string $default The country code (defaults to 'NG').
     *
     * @return \Illuminate\Http\JsonResponse
     *         A success response with the standardized account details
     *         (containing 'account_number' and 'account_name'), or an error response
     *         if the validation fails.
     *
     * Standardized Response Structure:
     * - 'account_number' (string): The validated bank account number.
     * - 'account_name' (string): The name associated with the bank account.
     *
     * Error Handling:
     * - Returns an error response if the API request fails or if invalid data
     *   is returned by the provider.
     */
    public function retrieveAccountDetail($bank, $accountNumber, $default = 'NG')
    {
        // Determine the payment provider based on the country
        $provider = $default === 'NG' ? new NombaPayment() : new Flutterwave();

        // Prepare the request data based on the provider
        $data = $default === 'NG'
            ? ['bankCode' => $bank, 'accountNumber' => $accountNumber]
            : ['account_number' => $accountNumber, 'account_bank' => $bank];

        // Fetch account details from the respective provider
        $response = $default === 'NG'
            ? $provider->retrieveAccountDetail($data)
            : $provider->verifyAccountNumber($data);

        if ($response && $response->ok()) {
            // Extract account details from the response
            $responseData = $response->json()['data'] ?? [];
            $accountDetails = [
                'account_number' => $responseData['accountNumber'] ?? $responseData['account_number'] ?? null,
                'account_name' => $responseData['accountName'] ?? $responseData['account_name'] ?? null,
            ];

            // Validate that the required fields are present
            if (!empty($accountDetails['account_number']) && !empty($accountDetails['account_name'])) {

                 return $this->sendResponse([
                     'redirects' => false,
                     'account'=>$accountDetails
                 ],'Account details retrieved successfully.');
            }

            return $this->sendError('account.validation.error', ['error' => 'Invalid account details received.']);
        }
        // Return an error response if the fetch fails
        return $this->sendError('account.validation.error', ['error' => 'Unable to validate account.']);
    }
    /**
     * Sends a One-Time Password (OTP) to the authenticated user's email for verification.
     *
     * This method generates a new OTP, encrypts it, and saves it for the authenticated user.
     * It then sends the OTP to the user's email via a custom notification.
     * The OTP expires after a predefined time as specified in the system settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *         Returns a success response if the OTP is sent, or an error response if an exception occurs.
     *
     * Error Responses:
     * - ThrottleRequestsException: Indicates the user has exceeded the OTP request limit.
     * - Generic Exception: Logs the error and returns a generic error message.
     */
    public function sendOTP(Request $request)
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

            // Return a success response
            return response()->json([
                'status' => true,
                'message' => 'OTP has been sent to your email.',
            ]);
        } catch (ThrottleRequestsException $exception) {
            // Return a throttling error response
            return response()->json([
                'status' => false,
                'message' => 'You can only request for OTP once every minute. Please wait.',
            ]);
        } catch (\Exception $exception) {
            // Log the exception and return a generic error response
            Log::error('Error on ' . $exception->getFile() . ' on line ' . $exception->getLine() . ': ' . $exception->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Internal server error; we are working on this now.',
            ]);
        }
    }
    /**
     * Verifies the One-Time Password (OTP) provided by the user.
     *
     * This method checks if the provided OTP matches the encrypted OTP stored for the authenticated user
     * and ensures the OTP has not expired. If the verification is successful, the OTP is cleared to prevent reuse.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *         Returns a success response if the OTP is valid, or an error response if the OTP is invalid or expired.
     */
    public function verifyOTP(Request $request)
    {
        try {
            $user = Auth::user(); // Get the authenticated user

            // Validate the request
            $request->validate([
                'otp' => 'required|string',
            ]);

            $providedOtp = $request->otp; // Retrieve the OTP from the request

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

            // Return a success response
            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            // Handle validation errors
            return response()->json([
                'status' => false,
                'message' => $exception->errors(),
            ]);
        } catch (\Exception $exception) {
            // Log and handle general errors
            Log::error('Error verifying OTP: ' . $exception->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while verifying the OTP. Please try again.',
            ]);
        }
    }

}
