<?php

namespace App\Http\Controllers\Mobile\Ads\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Email;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Notifications\CustomNotification;
use App\Notifications\EmailVerification;
use App\Rules\ReCaptcha;
use App\Traits\Helpers;
use Carbon\Carbon;
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
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

        if (\auth()->check()){
           return redirect()->route('mobile.user.profile.landing-page');
        }


        return view('mobile.ads.auth.register')->with([
            'web'       =>$web,
            'pageName'  =>"Create an account on ".$web->name,
            'siteName'  =>$web->name,
            'referral'=>(Cookie::has('ref'))?Cookie::get('ref'):$request->get('ref'),
            'countries' => Country::where('status',1)->get()
        ]);
    }
    //process form
    public function processRegistration(Request $request)
    {
        // Define Rate Limiting Key
        $rateLimitKey = 'register-attempts-' . md5(session()->getId() . $request->ip());

        // Check if the user has exceeded the limit
        $allowed = RateLimiter::attempt($rateLimitKey, 10, function () {}, 600);

        // Apply Rate Limiting (Max 5 attempts per 10 minutes)
        if (!$allowed) {
           return $this->sendError('rate.limit', ['error' => 'Too many registration attempts. Try again in 10 minutes.']);
        }


        DB::beginTransaction();
        try {
            $web = GeneralSetting::find(1);
            // Validate request
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'username' => ['required', 'alpha_num', 'unique:users,username'],
                'password' => ['required', Password::min(8)],
                'password_confirmation' => ['required', 'same:password'],
                'g-recaptcha-response' => ['required', new ReCaptcha],
                'referral' => ['nullable', 'string', 'exists:users,username'],
                'country' => ['required',Rule::exists('countries','iso3')->where('status',1)],
                'phoneNumber' => ['required','numeric','unique:users,phone'],
            ], [
                'email.unique' => 'User already exists with this email. Please login instead.',
                'g-recaptcha-response.required'=>'Recaptcha must be passed first.',
                'username.alpha_num'=>'Username must be only alphabets and numbers, no spaces.',
                'phoneNumber.unique'=>'Account already exists with this phone number. Please login instead.',
            ], [
                'g-recaptcha-response' => 'Recaptcha',
                'phoneNumber'=>'Phone Number'
            ])->stopOnFirstFailure();

            if ($validator->fails()) {

                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            // Get Country from Cookie
            $country =  Country::where('iso3',$input['country'])->where('status',1)->first();
            if (!$country) {
                return $this->sendError('validation.error', ['error' => 'Country selection is required. Please reload this page.']);
            }

            //check if the user's country currency is supported
            $fiat = Fiat::where('code',$country->currency)->first();
            if (empty($fiat)){
                $currency = 'USD';
            }else{
                $currency = $fiat->code;
            }

            // Handle Referral
            $refBy = $request->filled('referral') ? User::where('username', $input['referral'])->value('id') : 0;

            $reference = $this->generateUniqueId('users', 'reference');

            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'username' => $input['username'],
                'reference' => $reference,
                'password' => Hash::make($input['password']),
                'country' => $country->name,
                'countryCode' => $country->iso3,
                'mainCurrency' => $currency,
                'registrationIp' => $request->ip(),
                'referral' => $refBy, 'phone' => $input['phoneNumber']
            ]);

            // Initialize User Settings
            $this->initializeUserSettings($user);

            // Email Verification Handling
            if ($web->emailVerification == 1) {
                Auth::login($user);
                $user->markEmailAsVerified();
                $user->loggedIn=1;
                $user->save();
                $message = 'Account successfully created. Redirecting to complete account setup.';

                $urlTo = Cookie::has('redirect') ?  : route('mobile.user.profile.settings.complete-profile');
            } else {
                // Encrypt user ID and set verification session
                session([
                    'pending_email_verification_user' => encrypt($user->id),
                    'pending_email_verification_expires_at' => Carbon::now()->add($web->codeExpire)
                ]);
                // Send email verification
                $user->notify(new EmailVerification($user));

                // Redirect to email verification page
                $message = 'A verification code has been sent to your email. Verify your email to proceed.';
                $urlTo = route('mobile.email-verification');
            }

            // Commit Transaction
            DB::commit();

            // Reset Rate Limiting on Success
            RateLimiter::clear($rateLimitKey);

            return $this->sendResponse(['redirectTo' => $urlTo], $message);

        }catch (\Exception $exception){
            DB::rollBack();
            Log::alert($exception->getMessage() . ' on line ' . $exception->getLine() . ' in file ' . $exception->getFile());
            return $this->sendError('account.error', ['error' => 'Internal Server error.']);
        }
    }

    //email verification landing page
    public function emailVerification()
    {
        $web = GeneralSetting::find(1);

        // Retrieve user ID from encrypted session
        $encryptedUserId = session('pending_email_verification_user');
        if (!$encryptedUserId) {
            return redirect()->route('mobile.auth.register')->with('error', 'Session expired. Please register again.');
        }

        $userId = decrypt($encryptedUserId);
        $user = User::select('id', 'email')->where('id', $userId)->first();

        if (!$user) {
            return redirect()->route('mobile.auth.register')->with('error', 'User not found. Please register again.');
        }

        return view('mobile.ads.auth.email_verification')->with([
            'pageName' => 'Email Verification',
            'siteName' => $web->name,
            'web'      => $web,
            'user'     => $user,
        ]);
    }

    //process email verification
    public function processEmailVerification(Request $request): JsonResponse
    {
        try {
            $web = GeneralSetting::find(1);

            // Retrieve user ID from encrypted session
            $encryptedUserId = session('pending_email_verification_user');
            $expiresAt = session('pending_email_verification_expires_at');

            if (!$encryptedUserId || now()->greaterThan(Carbon::parse($expiresAt))) {
                session()->forget(['pending_email_verification_user', 'pending_email_verification_expires_at']); // Clear expired session
                return $this->sendError('session.error', ['error' => 'Session expired. Please register again.']);
            }

            $userId = decrypt($encryptedUserId);
            $user = User::find($userId);
            if (!$user) {
                return $this->sendError('user.error', ['error' => 'User not found. Please register again.']);
            }

            // Apply rate limiting to prevent brute-force attacks (5 attempts per 10 minutes)
            $rateLimitKey = 'email-verification-attempts-' . $user->id;
            // Check if the user has exceeded the limit
            $allowed = RateLimiter::attempt($rateLimitKey, 5, function () {}, 600);

            // Apply Rate Limiting (Max 5 attempts per 10 minutes)
            if (!$allowed) {
                return $this->sendError('rate.limit', ['error' => 'Too many attempts. Try again in 10 minutes.']);
            }

            // Validate request
            $validator = Validator::make($request->all(), [
                'code' => ['required', 'digits:6'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }

            $input = $validator->validated();

            // Fetch the latest stored email verification token
            $tokens = Email::where('user', $user->id)
                ->where('codeExpire', '>', time()) // Ensure token is still valid
                ->orderBy('created_at', 'desc') // Order by latest first
                ->get();

            if ($tokens->isEmpty()) {
                return $this->sendError('token.error', ['error' => 'No valid token found. Request a new one.']);
            }

            // Loop through the tokens and check if any match the entered token
            $validToken = null;
            foreach ($tokens as $token) {
                // Check if the token is expired (based on created_at + expiry duration)
                if (Carbon::parse($token->created_at)->add($web->codeExpire)->isPast()) {
                    continue;
                }

                // Verify the token (hashed comparison)
                if (Hash::check($input['code'], $token->token)) {
                    $validToken = $token; // Store the matched token
                    break; // Exit loop since we found a valid token
                }
            }

            // If no valid token was found, return an error
            if (!$validToken) {
                return $this->sendError('token.error', ['error' => 'Invalid token entered.']);
            }

            // Reset rate limiter on successful verification
            RateLimiter::clear($rateLimitKey);

            // Mark email as verified
            $user->update([
                'email_verified_at' => now(),
                'loggedIn' => 1
            ]);

            // Authenticate user after successful verification
            Auth::login($user);

            // Cleanup session and delete old verification tokens
            session()->forget(['pending_email_verification_user', 'pending_email_verification_expires_at']);
            Email::where('user', $user->id)->delete();

            // Determine redirect location
            $urlTo = Cookie::has('redirect') ? Cookie::get('redirect') : route('mobile.user.profile.settings.complete-profile');
            Cookie::forget('redirect');

            return $this->sendResponse([
                'redirectTo' => $urlTo
            ], 'Email successfully verified.');

        }catch (\Exception $exception){
            Log::alert('Email Verification Error: ' . $exception->getMessage());
            session()->forget(['pending_email_verification_user', 'pending_email_verification_expires_at']);
            return $this->sendError('error', ['error' => 'Internal Server error']);
        }
    }
    //verify with link
    public function emailVerificationWithLink(Request $request,$email,$tokenWeb)
    {
        try {
            $web = GeneralSetting::find(1);

            // Retrieve user ID from request
           $user = User::where('email', $email)->first();
           if (!$user) {
               return redirect()->route('mobile.login')->with('error','User not found. Please register again.');
           }

            // Fetch the latest stored email verification token
            $tokens = Email::where('user', $user->id)
                ->orderBy('created_at', 'desc') // Order by latest first
                ->get();

            if ($tokens->isEmpty()) {
                return redirect()->route('mobile.login')->with('error','Token not found. Please login to request a new one again.');
            }

            // Loop through the tokens and check if any match the entered token
            $validToken = null;

            foreach ($tokens as $token) {
                // Check if the token is expired (based on created_at + expiry duration)
                if (Carbon::parse($token->created_at)->add($web->codeExpire)->isPast()) {
                    continue;
                }

                // Verify the token (hashed comparison)
                if (Hash::check($tokenWeb, $token->token)) {
                    $validToken = $token; // Store the matched token
                    break; // Exit loop since we found a valid token
                }
            }

            // If no valid token was found, return an error
            if (!$validToken) {
                return redirect()->route('mobile.login')->with('error','Invalid token. Please login to request a new one');
            }

            // Mark email as verified
            $user->update([
                'email_verified_at' => now(),
                'loggedIn' => 1
            ]);

            // Authenticate user after successful verification
            Auth::login($user);

            // Cleanup session and delete old verification tokens
            session()->forget(['pending_email_verification_user', 'pending_email_verification_expires_at']);
            Email::where('user', $user->id)->delete();

            // Determine redirect location
            $urlTo = Cookie::has('redirect') ? Cookie::get('redirect') : route('mobile.user.profile.settings.complete-profile');
            Cookie::forget('redirect');

            return redirect()->to($urlTo)->with('success', 'Email successfully verified.');

        }catch (\Exception $exception){
            Log::alert('Email Verification Error: ' . $exception->getMessage());
            session()->forget(['pending_email_verification_user', 'pending_email_verification_expires_at']);
            return redirect()->route('mobile.login')->with('error', 'An error occurred, please try again later.');
        }
    }
    //resend verification email
    public function resendVerificationMail(Request $request){

        try {

            $web = GeneralSetting::find(1);

            // Retrieve user ID from encrypted session
            $encryptedUserId = session('pending_email_verification_user');
            if (!$encryptedUserId) {
                return $this->sendError('session.error', ['error' => 'Session expired. Please register again.']);
            }

            $userId = decrypt($encryptedUserId);
            $user = User::find($userId);
            if (!$user) {
                return $this->sendError('user.error', ['error' => 'User not found. Please register again.']);
            }

            // Rate limit resend requests (Max 1 request per minute)
            $rateLimitKey = 'resend-email-verification-' . $user->id;

            // Check if the user has exceeded the limit
            $allowed = RateLimiter::attempt($rateLimitKey, 5, function () {}, 600);

            // Apply Rate Limiting (Max 5 attempts per 10 minutes)
            if (!$allowed) {
                return $this->sendError('rate.limit', ['error' => 'Too many attempts. Try again in 10 minutes.']);
            }

            // Send new email verification token
            $user->notify(new EmailVerification($user));

            return $this->sendResponse([], 'A new verification code has been sent to your email.');

        }catch (\Exception $exception){
            Log::alert('Error occurred while resending email verification mail: ' . $exception->getMessage());
            return $this->sendError('error', ['error' => 'Internal Server error']);
        }

    }
}
