<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Email;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Notifications\CustomNotification;
use App\Notifications\EmailVerification;
use App\Traits\Helpers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class Register extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage(Request $request)
    {
        if ($request->has('ref')){
            //let us store it for future purpose
            $request->session()->put([
                'ref'=>$request->get('ref'),
            ]);
        }
        $web = GeneralSetting::find(1);

        return view('auth.register')->with([
           'web'        =>$web,
           'siteName'   =>$web->name,
           'pageName'   =>'Sign up for an account',
            'countries' =>Country::where('status',1)->get(),
            'fiats'     =>Fiat::where('status',1)->get(),
            'referral'=>($request->session()->exists('ref'))?$request->session()->get('ref'):$request->get('ref'),
        ]);
    }
    //process form
    public function processRegistration(Request $request)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            //validate request
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'username' => ['required', 'alpha_num', 'unique:users,username'],
                'country' => ['required', 'string', 'exists:countries,iso3'],
                'currency' => ['required', 'string', 'exists:fiats,code'],
                'password' => ['required', Password::min(8)->uncompromised(1)],
                'password_confirmation' => ['required', 'same:password'],
                'referral' => ['nullable', 'string', 'exists:users,username'],
                'phone'    =>['required','numeric']
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }

            $input = $validator->validated();
            //check if the referral type is valid
            if ($request->filled('referral')){
                $referrer = User::where('username',$input['referral'])->first();
                if (empty($referrer)){
                    return $this->sendError('referral.error',['error'=>'Invalid Referral']);
                }
                $refBy = $referrer->id;
            }else{
                $refBy=0;
            }

            $reference = $this->generateUniqueId('users','reference');
            //check if the selected country is valid
            $countryExists = Country::where(['iso3'=>$input['country'],'status'=>1])->first();

            $dataUser = [
                'name'=>$input['name'],
                'email'=>$input['email'],
                'username'=>$input['username'],
                'reference'=>$reference,
                'password'=>bcrypt($input['password']),
                'country'=>$countryExists->name,
                'countryCode'=>$countryExists->iso3,
                'phone'=>$input['phone'],
                'mainCurrency'=>$input['currency'],
                'registrationIp'=>$request->ip(),
                'referral'=>$refBy,
            ];
            $user = User::create($dataUser);
            if (!empty($user)){
                $this->initializeUserSettings($user);//initialize settings
                //check for email verification and initiate it
                if ($web->emailVerification==1){
                    $user->loggedIn = 1;
                    $user->markEmailAsVerified();
                    $user->save();

                    $message = 'Account successfully created. Redirecting to complete account setup.';
                    $urlTo = route('complete-account-setup');
                }else{
                    Auth::login($user);
                    //send email verification
                    $user->notify(new EmailVerification($user));
                    $urlTo =route('email-verification');
                    $message = 'A code has been sent to your email. Verify your email to proceed.';
                }
                //notify referral
                if ($refBy!=0){
                    $mess = "A new sign-up was recorded on ".$web->name." using your referral link. You will receive your commission once user completes a transaction.";
                    $referrer->notify(new CustomNotification($referrer,$mess,'New Referral Signup'));
                }
                return $this->sendResponse([
                    'redirectTo'=>$urlTo
                ],$message);
            }
            return $this->sendError('account.error',['error'=>'Something went wrong']);

        }catch (\Exception $exception){
            Log::alert($exception->getMessage().' on line '.$exception->getLine().' on file '.$exception->getFile());
            return $this->sendError('account.error',['error'=>'Internal Server error.']);
        }
    }
    //email verification landing page
    public function emailVerification(): Factory|View|Application
    {
        $web = GeneralSetting::find(1);

        $dataView = [
            'pageName' => 'Email Verification',
            'siteName' => $web->name,
            'web'      => $web
        ];
        return view('auth.email_verification',$dataView);
    }

    //process email verification
    public function processEmailVerification(Request $request): JsonResponse
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            //validate request
            $validator = Validator::make($request->all(), [
                'code' => ['required', 'digits:6'],
            ])->stopOnFirstFailure();

            if ($validator->fails()){
                return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            }
            $input = $validator->validated();

            $codeExists = Email::where(['user'=>$user->id,'email'=>$user->email])->orderBy('id','desc')->first();
            if (empty($codeExists)) return $this->sendError('token.error',['error'=>'Unidentified token']);

            if (time()>$codeExists->codeExpire)return $this->sendError('token.error',['error'=>'Token timedout.']);

            $hashed = Hash::check($input['code'],$codeExists->token);
            if (!$hashed) return $this->sendError('token.error',['error'=>'Invalid token entered']);

            //update user
            $dataUser = [
                'email_verified_at'=>$this->getCurrentDateTimeString(),
                'loggedIn'=>1
            ];

            if (User::where('id',$user->id)->update($dataUser)){

                Email::where('user',$user->id)->delete();

                return $this->sendResponse([
                    'redirectTo'=>route('complete-account-setup'),
                    'token'=>$request->bearerToken()
                ],'Email successfully verified.');
            }
            return $this->sendError('account.error',['error'=>'Unable to verify email']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('error',['error'=>'Internal Server error']);
        }
    }
}
