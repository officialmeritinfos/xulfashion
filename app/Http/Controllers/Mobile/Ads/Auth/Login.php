<?php

namespace App\Http\Controllers\Mobile\Ads\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\TwoFactor;
use App\Models\User;
use App\Models\UserSetting;
use App\Notifications\EmailVerification;
use App\Notifications\TwoFactorAuthentication;
use App\Rules\ReCaptcha;
use App\Traits\Helpers;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class Login extends BaseController
{
    use Helpers;
    // Show login page
    public function landingPage(Request $request)
    {
        $web = GeneralSetting::find(1);

        if ($request->has('redirect')) {
            Cookie::queue('redirect', $request->redirect, 30 * 24 * 60 * 60);
        }

        if (\auth()->check()){
            return redirect()->route('mobile.user.profile.landing-page');
        }

        return view('mobile.ads.auth.login')->with([
            'web' => $web,
            'pageName' => "Sign in to " . $web->name,
            'siteName' => $web->name
        ]);
    }
    //profess form
    public function processLogin(Request $request)
    {
        $web = GeneralSetting::find(1);

        try {
            // Rate limiting to prevent brute-force
            $key = 'login-attempts-' . $request->ip();

            // Check if the user has exceeded the limit
            $allowed = RateLimiter::attempt($key, 5, function () {}, 600);

            // Apply Rate Limiting (Max 5 attempts per 10 minutes)
            if (!$allowed) {
                return $this->sendError('rate.limit', ['error' => 'Too many sign-in attempts. Try again in 10 minutes.']);
            }

            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => ['required', Password::min(8)->uncompromised(1)],
                'remember' => ['nullable', 'integer'],
                'g-recaptcha-response' => ['required', new ReCaptcha]
            ],[
                'email.exists'=>"Selected email is not registered in the system"
            ],['g-recaptcha-response'=>'Recaptcha'])->stopOnFirstFailure();

            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            $input = $validator->validated();
            $user = User::where('email', $input['email'])->first();

            // Check if password is correct
            if (!Hash::check($input['password'], $user->password)) {

                return $this->sendError('authentication.error', ['error' => 'Email and Password combination is incorrect']);
            }
            // Check if account is active
            if ($user->status != 1) {
                return $this->sendError('account.error', ['error' => 'Account is inactive; contact support']);
            }
            // Check if email is verified
            if (empty($user->email_verified_at)) {
                session([
                    'pending_email_verification_user' => encrypt($user->id),
                    'pending_email_verification_expires_at' => Carbon::now()->add($web->codeExpire)
                ]);
                $user->notify(new EmailVerification($user));
                return $this->sendResponse(['redirectTo' => route('mobile.email-verification')], 'Verify your email to proceed.');
            }

            // Check if 2FA is enabled
            $settings = UserSetting::where('user', $user->id)->first();
            if ($settings->twoFactor == 1) {
                session(['pending_2fa_user' => $user->id]);
                session([
                    'pending_2fa_user' => encrypt($user->id),
                    'pending_2fa_expires_at' => Carbon::now()->add($web->codeExpire)
                ]);
                $user->notify(new TwoFactorAuthentication($user));
                $user->update(['loggedIn' => 2]);
                return $this->sendResponse(['redirectTo' => route('mobile.login-verification')], "2FA required. Check your email.");
            }

            // Normal login (No 2FA)
            Auth::login($user);
           $user->update(['loggedIn' => 1]);
            if ($settings->emailNotification == 1) {
                $this->notifyLogin($request, $user);
            }
            $url = Cookie::get('redirect', route('mobile.marketplace.index', ['country' => strtolower($user->countryCode)]));
            Cookie::forget('redirect');
            return $this->sendResponse(['redirectTo' => $url, 'user' => $user->email], "Login successful.");

        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('authentication.error',['error'=>'Internal Server Error']);
        }
    }
    //start two-factor authentication
    public function twoFactorAuthentication()
    {
        try {
            $encryptedUserId = session('pending_2fa_user');
            $expiresAt = session('pending_2fa_expires_at');

            if (!$encryptedUserId || now()->greaterThan(Carbon::parse($expiresAt))) {
                session()->forget(['pending_2fa_user', 'pending_2fa_expires_at']);
                return redirect()->route('mobile.login')->with('error', 'Session expired. Please log in again.');
            }

            $userId = decrypt($encryptedUserId); // Decrypt user ID
            $user = User::select('id', 'email')->find($userId);

            if (!$user) {
                return redirect()->route('mobile.login')->with('error', 'User not found. Please log in again.');
            }

            return view('mobile.ads.auth.two_factor')->with([
                'pageName' => 'Login Authorization',
                'siteName' => GeneralSetting::find(1)->name,
                'web'      => GeneralSetting::find(1),
                'user'     => $user
            ]);
        }catch (\Exception $exception){
            session()->forget(['pending_2fa_user', 'pending_2fa_expires_at']);
            return redirect()->route('mobile.login')->with('error', 'Invalid session. Please log in again.');
        }
    }

    //process two factor
    public function processTwoFactor(Request $request): JsonResponse
    {
        $web = GeneralSetting::find(1);
        try {

            // Retrieve and decrypt user ID from session
            $encryptedUserId = session('pending_2fa_user');
            $expiresAt = session('pending_2fa_expires_at');

            // If session is missing or expired, force login again
            if (!$encryptedUserId || now()->greaterThan(Carbon::parse($expiresAt))) {
                session()->forget(['pending_2fa_user', 'pending_2fa_expires_at']);
                return $this->sendError('session.error', ['error' => 'Session expired. Please log in again.']);
            }

            $userId = decrypt($encryptedUserId);
            $user = User::find($userId);
            if (!$user) {
                return $this->sendError('user.error', ['error' => 'User not found. Please log in again.']);
            }

            // Apply rate limiting to prevent brute-force attacks (Max 5 attempts per 10 minutes)
            $rateLimitKey = '2fa-attempts-' . $user->id;

            // Check if the user has exceeded the limit
            $allowed = RateLimiter::attempt($rateLimitKey, 5, function () { }, 600);

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

            // Fetch the latest stored 2FA token
            $codeExists = TwoFactor::where('user', $user->id)->latest()->first();

            if (!$codeExists) {
                return $this->sendError('token.error', ['error' => 'Unidentified token.']);
            }

            // Check if token is expired
            if (Carbon::parse($codeExists->created_at)->add($web->codeExpire)->isPast()) {
                return $this->sendError('token.error', ['error' => 'Token expired. Request a new one.']);
            }

            // Verify token
            if (!Hash::check($input['code'], $codeExists->token)) {
                return $this->sendError('token.error', ['error' => 'Invalid token entered.']);
            }

            // Reset rate limiter on successful verification
            RateLimiter::clear($rateLimitKey);

            // Mark user as fully logged in
            $user->loggedIn = 1;
            $user->save();

            // Authenticate the user now
            Auth::login($user,true);

            // Notify user of login
            $this->notifyLogin($request, $user);

            // Clean up session and old 2FA tokens
            session()->forget(['pending_2fa_user', 'pending_2fa_expires_at']);
            TwoFactor::where('user', $user->id)->delete();

            // Determine redirect location
            $url = Cookie::has('redirect') ? Cookie::get('redirect') : route('mobile.marketplace.index', ['country' => strtolower($user->countryCode)]);
            Cookie::forget('redirect');

            return $this->sendResponse(['redirectTo' => $url], 'Login successfully verified.');

        }catch (\Exception $exception){
            Log::alert('2FA Error: ' . $exception->getMessage());
            session()->forget(['pending_2fa_user', 'pending_2fa_expires_at']);
            return $this->sendError('error', ['error' => 'Internal Server error']);
        }
    }
    //resend verification email
    public function resendVerificationMail(Request $request){
        $web = GeneralSetting::find(1);

        try {
            // Retrieve and decrypt user ID from session
            $encryptedUserId = session('pending_2fa_user');
            if (!$encryptedUserId) {
                return $this->sendError('session.error', ['error' => 'Session expired. Please log in again.']);
            }
            $userId = decrypt($encryptedUserId);
            $user = User::find($userId);

            if (!$user) {
                return $this->sendError('user.error', ['error' => 'User not found. Please log in again.']);
            }

            // Rate limit resend requests (Max 1 request per minute)
            $rateLimitKey = 'resend-2fa-' . $user->id;
            // Check if the user has exceeded the limit
            $allowed = RateLimiter::attempt($rateLimitKey, 5, function () {}, 600);

            // Apply Rate Limiting (Max 5 attempts per 10 minutes)
            if (!$allowed) {
                return $this->sendError('rate.limit', ['error' => 'Too many attempts. Try again in 10 minutes.']);
            }
            // Resend the 2FA code notification
            $user->notify(new TwoFactorAuthentication($user));

            return $this->sendResponse([], 'A new authentication code has been sent to your email.');
        }catch (\Exception $exception){
            Log::alert('Error while resending two-factor verification mail: ' . $exception->getMessage());
            return $this->sendError('error', ['error' => 'Internal Server error']);
        }
    }
}
