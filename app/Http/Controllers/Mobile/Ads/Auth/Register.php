<?php

namespace App\Http\Controllers\Mobile\Ads\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Email;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Notifications\CustomNotification;
use App\Notifications\EmailVerification;
use App\Rules\ReCaptcha;
use App\Traits\Helpers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Stevebauman\Location\Facades\Location;

class Register extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage(Request $request)
    {
        if ($request->has('ref')){
            Cookie::queue('ref',$request->get('ref'),30 * 24 * 60 * 60);
        }

        if (!Cookie::has('hasAdsCountry')){
            $position = (config('location.testing.enabled'))?Location::get():Location::get($request->ip());
            $country = Country::where('iso2',$position->countryCode)->first();
            Cookie::queue('hasAdsCountry',$country->iso3,7 * 24 * 60 * 60);
            $countryIso = $country->iso3;
        }else{
            $countryIso = Cookie::get('hasAdsCountry');
        }
        $web = GeneralSetting::find(1);


        return view('mobile.ads.auth.register')->with([
            'web'       =>$web,
            'pageName'  =>"Create an account on ".$web->name,
            'siteName'  =>$web->name,
            'referral'=>(Cookie::has('ref'))?Cookie::get('ref'):$request->get('ref'),
        ]);
    }
    //process form
    public function processRegistration(Request $request)
    {
        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            //validate request
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'username' => ['required', 'alpha_num', 'unique:users,username'],
                'password' => ['required', Password::min(8)->uncompromised(1)],
                'password_confirmation' => ['required', 'same:password'],
                'g-recaptcha-response' => ['required', new ReCaptcha],
                'referral' => ['nullable', 'string', 'exists:users,username'],
            ],[
                'email.unique'=>'User already exists with this email. Please login instead.'
            ],[
                'g-recaptcha-response'=>'Recaptcha'
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }

            $input = $validator->validated();

            $country = Cookie::get('hasAdsCountry');

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
            $countryExists = Country::where(['iso3'=>$country,'status'=>1])->first();

            $dataUser = [
                'name'=>$input['name'],
                'email'=>$input['email'],
                'username'=>$input['username'],
                'reference'=>$reference,
                'password'=>bcrypt($input['password']),
                'country'=>$countryExists->name,
                'countryCode'=>$countryExists->iso3,
                'mainCurrency'=>$countryExists->currency,
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
                    if (Cookie::has('redirect')) {
                        $urlTo = Cookie::get('redirect');
                        Cookie::forget('redirect');
                    }else{
                        $urlTo = route('complete-account-setup');
                    }
                }else{
                    Auth::login($user);
                    //send email verification
                    $user->notify(new EmailVerification($user));
                    $urlTo =route('mobile.email-verification');
                    $message = 'A code has been sent to your email. Verify your email to proceed.';
                }
                DB::commit();
                return $this->sendResponse([
                    'redirectTo'=>$urlTo
                ],$message);
            }
            return $this->sendError('account.error',['error'=>'Something went wrong']);

        }catch (\Exception $exception){
            DB::rollBack();
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
            'web'      => $web,
            'user'     =>Auth::user()
        ];
        return view('mobile.ads.auth.email_verification',$dataView);
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

                if (Cookie::has('redirect')) {
                    $urlTo = Cookie::get('redirect');
                    Cookie::forget('redirect');
                }else{
                    $urlTo = route('mobile.marketplace.index',['country'=>strtolower($user->countryCode)]);
                }

                return $this->sendResponse([
                    'redirectTo'=>$urlTo,
                    'token'=>$request->bearerToken()
                ],'Email successfully verified.');
            }
            return $this->sendError('account.error',['error'=>'Unable to verify email']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('error',['error'=>'Internal Server error']);
        }
    }
    //resend verification email
    public function resendVerificationMail(Request $request){
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        try {
            $user->notify(new EmailVerification($user));
            return $this->sendResponse([
                'redirectTo'=>route('email-verification'),
            ],'The verification code has been resent to your registered email.');
        }catch (\Exception $exception){
            Log::alert('Error occurred while resending email verification mail: '.$exception->getMessage());
            return $this->sendError('error',['error'=>'Internal Server error']);
        }

    }
}
