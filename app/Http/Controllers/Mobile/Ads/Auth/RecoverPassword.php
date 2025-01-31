<?php

namespace App\Http\Controllers\Mobile\Ads\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\EmailVerification;
use App\Notifications\PasswordChanged;
use App\Notifications\PasswordRecovery;
use App\Notifications\TwoFactorAuthentication;
use App\Rules\ReCaptcha;
use App\Traits\Helpers;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RecoverPassword extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);
        return view('mobile.ads.auth.recover_password')->with([
            'web'       =>$web,
            'pageName'  =>"Recover your ".$web->name.' Account',
            'siteName'  =>$web->name
        ]);
    }
    public function processPasswordRecovery(Request $request): JsonResponse
    {
        $web = GeneralSetting::find(1);
        $rateLimitKey = 'password-recovery-' . $request->ip();

        // 🚨 Apply Rate Limiting to prevent spam
        $allowed = RateLimiter::attempt($rateLimitKey, 5, function () {}, 600);

        if (!$allowed) {
            return $this->sendError('rate.limit', [
                'error' => 'Too many password recovery attempts. Try again in 10 minutes.',
            ]);
        }
        try {
            // ✅ Validate Request
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'exists:users,email'],
                'g-recaptcha-response' => ['nullable', new ReCaptcha]
            ],[],[
                'g-recaptcha-response' => "Recaptcha"
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', [
                    'error' => $validator->errors()->all(),
                ]);
            }

            $input = $validator->validated();
            $user = User::where('email', $input['email'])->first();

            if (empty($user->email_verified_at)) {
                session([
                    'pending_email_verification_user' => encrypt($user->id),
                    'pending_email_verification_expires_at' => Carbon::now()->add($web->codeExpire)
                ]);
                $user->notify(new EmailVerification($user));
                return $this->sendResponse([
                    'redirectTo' => route('mobile.email-verification')
                ], 'Your email is not verified. Please verify your email first.');

            }

            // ✅ Send recovery email
            $user->notify(new PasswordRecovery($user));
            // ✅ Store email in session for verification
            session([
                'password_reset_user' => encrypt($user->id),
                'password_reset_expires_at'=> strtotime("+{$web->codeExpire}")
            ]);

            return $this->sendResponse([
                'redirectTo'=>route('mobile.verify-password-reset')
            ],'Account Recovery Code Sent');

        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('password.error',['error'=>'Internal Server error']);
        }
    }
    //request verification landing page
    public function requestVerificationPage(): Factory|View|Application
    {
        $web = GeneralSetting::find(1);

        $dataView = [
            'pageName' => 'Verify Code',
            'siteName' => $web->name,
            'web'      => $web
        ];
        return view('mobile.ads.auth.reset_password',$dataView);
    }
    //process verification code
    public function processVerificationCode(Request $request): JsonResponse
    {
        $rateLimitKey = 'password-reset-' . $request->ip();
        $web = GeneralSetting::find(1);
        // 🚨 Get Encrypted User ID & Expiration from Session
        $encryptedUserId = session('password_reset_user');
        $expirationTime = session('password_reset_expires_at');

        // 🚨 Ensure Session Data Exists
        if (!$encryptedUserId || !$expirationTime) {
            return $this->sendError('session.expired', [
                'error' => 'Session expired. Please request a new password reset.'
            ]);
        }

        // 🚨 Validate Expiration Time
        if (time() > $expirationTime) {
            return $this->sendError('token.expired', [
                'error' => 'Password reset request expired. Please request a new one.'
            ]);
        }

        // 🚨 Decrypt User ID
        try {
            $userId = decrypt($encryptedUserId);
        } catch (\Exception $e) {
            return $this->sendError('token.invalid', [
                'error' => 'Invalid reset request. Please try again.'
            ]);
        }

        // 🚨 Apply Rate Limiting
        $allowed = RateLimiter::attempt($rateLimitKey, 5, function () { }, 600);

        if (!$allowed) {
            return $this->sendError('rate.limit', [
                'error' => 'Too many password recovery attempts. Try again later.',
            ]);
        }

        DB::beginTransaction();

        try {

            $validator = Validator::make($request->all(), [
                'code' => ['required', 'numeric', 'digits:6'],
                'password' => ['required', Password::min(8)->uncompromised(1)],
                'password_confirmation' => ['required', 'same:password']
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', [
                    'error' => $validator->errors()->all()
                ]);
            }

            $input = $validator->validated();
            $user = User::find($userId);

            if (!$user) {
                return $this->sendError('user.notfound', ['error' => 'User not found.']);
            }

            $codeExists = PasswordReset::where(['user' => $user->id, 'email' => $user->email])
                ->orderBy('id', 'desc')->first();

            if (!$codeExists) {
                return $this->sendError('token.error', ['error' => 'Unidentified token']);
            }

            if (time() > $codeExists->codeExpire) {
                return $this->sendError('token.expired', ['error' => 'Token expired.']);
            }

            if (!Hash::check($input['code'], $codeExists->token)) {
                return $this->sendError('token.error', ['error' => 'Invalid token entered']);
            }

            // ✅ Reset Password
            $user->update([
                'password' => Hash::make($input['password'])
            ]);

            // ✅ Delete Reset Token & Clear Session
            PasswordReset::where('user', $user->id)->delete();
            session()->forget(['password_reset_user', 'password_reset_expires_at']);

            //Send mail
            $user->notify(new PasswordChanged($user));

            DB::commit();

            // ✅ Regenerate session to prevent session hijacking

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return $this->sendResponse([
                'redirectTo' => route('mobile.login')
            ], 'Account Password changed. Redirecting soon ...');

        }catch (\Exception $exception){
            DB::rollBack();
            Log::alert($exception->getMessage());
            return $this->sendError('password.error',['error'=>'Internal Server error']);
        }
    }

    //resend verification email
    public function resendVerificationMail(Request $request){

        $web = GeneralSetting::find(1);
        // 🚨 Get encrypted user ID from session
        $encryptedUserId = session('password_reset_user');
        $expirationTime = session('password_reset_expires_at');
        // 🚨 Ensure session data exists
        if (!$encryptedUserId || !$expirationTime) {
            return $this->sendError('session.expired', [
                'error' => 'Session expired. Please request a new password reset.'
            ]);
        }

        try {

            // 🚨 Validate Expiration Time
            if (time() > $expirationTime) {
                return $this->sendError('token.expired', [
                    'error' => 'Password reset request expired. Please request a new one.'
                ]);
            }

            // 🚨 Decrypt User ID
            try {
                $userId = decrypt($encryptedUserId);
            } catch (\Exception $e) {
                return $this->sendError('token.invalid', [
                    'error' => 'Invalid reset request. Please try again.'
                ]);
            }

            // 🚨 Fetch user from database
            $user = User::find($userId);
            if (!$user) {
                return $this->sendError('user.notfound', [
                    'error' => 'User not found. Please request a new password reset.'
                ]);
            }

            // 🚨 Rate limit resend requests (Max 3 resends per 10 minutes)
            $rateLimitKey = 'resend-password-recovery-' . $request->ip();
            $maxResends = 5;
            $lockoutTime = 600;

            $allowed = RateLimiter::attempt($rateLimitKey, $maxResends, function () { }, $lockoutTime);

            if (!$allowed) {
                return $this->sendError('rate.limit', [
                    'error' => 'Too many resend requests. Try again in 10 minutes.',
                    'attempts_left' => 0
                ]);
            }

            // ✅ Resend password recovery email
            $user->notify(new PasswordRecovery($user));

            return $this->sendResponse([
                'redirectTo' => route('mobile.verify-password-reset')
            ], 'Verification code resent to your email.');

        }catch (\Exception $exception){
            Log::alert('Error occurred while resending two-factor verification mail: '.$exception->getMessage());
            return $this->sendError('error',['error'=>'Internal Server error']);
        }

    }
}
