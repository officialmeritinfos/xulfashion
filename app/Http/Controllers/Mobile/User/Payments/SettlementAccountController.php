<?php

namespace App\Http\Controllers\Mobile\User\Payments;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\PayoutCurrency;
use App\Models\UserBank;
use App\Models\UserWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettlementAccountController extends BaseController
{
    //landing page
    public function landingPage(Request $request)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $country = Country::where('iso3', $user->countryCode)->first();

        $mainCurrency = PayoutCurrency::getCurrencyOrDefault($country->currency);
        $usdCurrency = $mainCurrency->currency === 'USD' ? $mainCurrency : PayoutCurrency::getCurrencyOrDefault('USD');


        return view('mobile.users.payments.settlement_account')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Settlement Accounts',
            'payoutCurrency' =>$mainCurrency,
            'usdPayoutCurrency' => $usdCurrency,
            'fiat'   =>$country,
        ]);
    }
    /**
     * Set a bank account as the primary account.
     * Only accounts with the user's main currency can be set as primary.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setPrimaryAccount(Request $request)
    {
        $user = Auth::user();
        $bankId = $request->input('bank_id');

        $bank = UserBank::where('id', $bankId)
            ->where('user', $user->id)
            ->first();

        if (!$bank) {
            return response()->json(['status' => false, 'message' => 'Bank account not found.']);
        }

        // Restrict to accounts with the user's main currency
        if ($bank->currency !== $user->mainCurrency) {
            return response()->json(['status' => false, 'message' => 'Only accounts with your main currency can be set as primary.']);
        }

        DB::beginTransaction();
        try {
            // Set all user's banks to secondary
            UserBank::where('user', $user->id)->update(['isPrimary' => 2]);

            // Set selected bank as primary
            $bank->isPrimary = 1;
            $bank->save();

            DB::commit();

            return response()->json(['status' => true, 'message' => 'Primary account updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Failed to update the primary account.']);
        }
    }
    //settlement account details
    public function settlementAccountDetail($ref)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $bank = UserBank::where([
            'user' => $user->id,
            'reference' => $ref
        ])->firstOrFail();

        return view('mobile.users.payments.settlement_account_details')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Settlement Accounts Details',
            'transactions' => UserWithdrawal::where('paymentDetails',$bank->reference)->orderByDesc('created_at')->paginate(10),
            'bank' => $bank,
        ]);
    }
}
