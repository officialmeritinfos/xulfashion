<?php

namespace App\Http\Controllers\Dashboard;

use App\Custom\Flutterwave;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\AccountFunding;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserBank;
use App\Models\UserDeposit;
use App\Models\UserWithdrawal;
use App\Notifications\CustomNotification;
use App\Notifications\SendPushNotification;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\Exception;

class Account extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);
        $transactions= Transaction::where('user',$user->id)->paginate(15);

        return view('dashboard.common.account')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$this->userAccountType($user).' Account',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'transactions'  =>$transactions,
            'banks'         =>UserBank::where([
                'user' => $user->id,
                'status' => 1
            ])->get(),
            'withdrawals'   =>UserWithdrawal::where('user',$user->id)->paginate(15,['*'],'transfer'),
            'referrals'     =>User::where('referral',$user->id)->paginate(15,['*'],'referrals'),
        ]);
    }
    //convert from referral to Main Balance
    public function convertFromReferralToMain(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);
            $validator = Validator::make($request->all(), [
                'amount' => ['required', 'numeric'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()],422);
            }

            $input = $validator->validated();

            //check for balance
            if ($user->referralBalance <$input['amount']){
                return $this->sendError('balance.error',['error'=>'Insufficient balance in referral account']);
            }

            $balanceAfter =$user->referralBalance-$input['amount'];
            $user->referralBalance = $user->referralBalance-$input['amount'];

            $balance = $user->accountBalance;
            $newBalance = $balance+$input['amount'];
            $user->accountBalance = $newBalance;
            $account = 'account';


            $transaction = Transaction::create([
                'user'=>$user->id,'reference'=>$this->generateUniqueReference('tutor_transactions','reference',20),
                'amount'=>$input['amount'],'transactionType'=>2,'currency'=>$user->mainCurrency,
                'newBalance'=>$balanceAfter,'status' => 1
            ]);
            if (!empty($transaction)){
                $user->save();

                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Conversion was successful.');
            }
        }catch (\Exception $exception){
            Log::alert($exception->getMessage().' on line '.$exception->getLine().' on '.$exception->getFile());
            return $this->sendError('error',['error'=>'Internal Server error']);
        }
    }
    //fund your account
    public function fundAccount(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);
            $validator = Validator::make($request->all(),[
                'amount'=>['required','numeric','min:100','max:500000'],
            ],[
                'min'=>'Amount cannot be less than '.$user->mainCurrency.'100',
                'max'=>'Amount cannot be more than '.$user->mainCurrency.'500,000',
            ])->stopOnFirstFailure();

            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);

            $input = $validator->validated();

            $reference = $this->generateUniqueReference('user_deposits','reference',20);
            //collate the data to generate account
            $dataCollate = [
                'email'=>$user->email,
                'currency'=>'NGN',
                'amount'=>$input['amount'],
                'tx_ref'=>$reference,
                'is_permanent'=>false,
                'narration'=>$user->name
            ];

            //collect payment
            $gateway = new Flutterwave();
            $response = $gateway->createVirtualAccount($dataCollate);
            if ($response->ok()){
                $response = $response->json();

                if ($response['status']=='success'){
                    $dataDeposit = [
                        'user'=>$user->id,'reference'=>$reference,
                        'currency'=>'NGN',
                        'amount'=>$input['amount'],
                        'amountToPay'=>$response['data']['amount'],
                        'orderReference'=>$response['data']['order_ref'],
                        'flutterRef'=>$response['data']['flw_ref'],
                        'bank'=>$response['data']['bank_name'],
                        'accountNumber'=>$response['data']['account_number'],
                        'expiryDate'=>strtotime($response['data']['expiry_date']),
                        'channel'=>'Bank Transfer'
                    ];

                    $deposit = UserDeposit::create($dataDeposit);
                    if (!empty($deposit)){
                        return $this->sendResponse([
                            'accountNumber'=>$deposit->accountNumber,
                            'bank'=>$deposit->bank,
                            'reference'=>strtoupper($deposit->reference),
                            'amount'=>$deposit->amountToPay
                        ],$response['data']['note']);
                    }
                }
            }
            Log::info($response->json());
            return $this->sendError('funding.error',
                ['error'=>'An error occurred while processing your funding request. Please try again.']
            );
        }catch (Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('error',['error'=>'Internal Server error']);
        }
    }
    //withdraw from account balance
    public function withdrawFromAccount(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'current_password:web'],
                'otp'=>['required','digits:6','numeric'],
                'amount'=>['required','numeric'],
                'bank'=>['required','string',Rule::exists('user_banks','reference')->where('user',$user->id)]
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();
            DB::beginTransaction();
            //check the otp.
            if ($user->otpExpires<time()){
                return $this->sendError('authentication.error', ['error' => 'OTP has timed out.']);
            }

            if (!Hash::check($input['otp'],$user->otp)){
                return $this->sendError('authentication.error', ['error' => 'Invalid OTP']);
            }
            $user->otp='';
            $user->otpExpires='';
            $user->save();

            if ($user->accountBalance <$input['amount']){
                return $this->sendError('balance.error', ['error' => 'Insufficient balance to process withdrawal']);
            }

            $fiat = Fiat::where('code',$user->mainCurrency)->first();

            if ($input['amount'] < $fiat->minAmount){
                return $this->sendError('balance.error', ['error' => 'Amount to withdraw must be greater than or equal to '.$fiat->code.number_format($fiat->minAmount,2)]);
            }
            $bank = UserBank::where([
                'reference'=>$input['bank'],'user'=>$user->id
            ])->first();

            $amountCredit = $input['amount']-$fiat->fixedPayoutFee;
            $user->accountBalance = $user->accountBalance-$input['amount'];

            $user->save();
            $reference = $this->generateUniqueReference('user_withdrawals','reference',6);

            $withdrawal= UserWithdrawal::create([
                'user'=>$user->id,'reference'=>$reference,'currency'=>$user->mainCurrency,
                'amount'=>$input['amount'],'amountCredit'=>$amountCredit,'channel'=>1,
                'paymentDetails'=>$bank->reference,
                'paymentStatus'=>2
            ]);
            if (!empty($withdrawal)){
                $user->refresh();

                Transaction::create([
                    'user'=>$user->id,
                    'reference'=>$this->generateUniqueReference('transactions','reference',20),
                    'currency'=>$withdrawal->currency,
                    'amount'=>$input['amount'],
                    'transactionType'=>1,
                    'withdrawalRef'=>$withdrawal->reference,
                    'status'=>2,
                    'newBalance' => $user->accountBalance
                ]);

                DB::commit();
                $message = "A withdrawal of ".$fiat->sign.number_format($input['amount'],2)." has been authenticated on your ".$web->name." account. This should arrive within 24 hours.";
                UserActivity::create([
                    'user'=>$user->id,'title'=>'New Withdrawal',
                    'content'=>$message
                ]);
                //send notification
                $user->notify(new SendPushNotification($user,'New Account Debit on '.$web->name,$message));

                $mailMessage = "A withdrawal of ".$fiat->sign.number_format($input['amount'],2)." has been authenticated
                on your ".$web->name." account. This should arrive within 24 hours.<br/> If you did not place this request, please contact
                support for cancellation before it is processed. Withdrawals are non-refundable once successful.";
                $user->notify(new CustomNotification($user,$mailMessage,'New Account Debit on '.$web->name));

                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Withdrawal was successful');
            }

            return  $this->sendError('withdrawal.error',['error'=>'Something went wrong while processing your request.']);

        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error on '.$exception->getFile().' on line '.$exception->getLine().': '.$exception->getMessage());
            return $this->sendError('withdrawal.error',['error'=>'Internal Server error; we are working on this now']);
        }
    }
}
