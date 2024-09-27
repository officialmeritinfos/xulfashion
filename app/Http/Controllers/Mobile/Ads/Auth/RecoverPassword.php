<?php

namespace App\Http\Controllers\Mobile\Ads\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordChanged;
use App\Notifications\PasswordRecovery;
use App\Notifications\TwoFactorAuthentication;
use App\Rules\ReCaptcha;
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
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'exists:users,email'],
                'g-recaptcha-response' => ['required', new ReCaptcha]
            ],[],[
                'g-recaptcha-response'=>'Recaptcha'
            ])->stopOnFirstFailure();
            if ($validator->fails()){
                return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            }
            $input = $validator->validated();

            $user = User::where('email',$input['email'])->first();
            //since this exists, we need to send the mail
            $user->notify(new PasswordRecovery($user));

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
        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'code' => ['required', 'numeric', 'digits:6'],
                'password'=>['required',Password::min(8)->uncompromised(1)],
                'password_confirmation'=>['required','same:password']
            ])->stopOnFirstFailure();

            if ($validator->fails()){
                return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            }
            $input = $validator->validated();

            $codeExists = PasswordReset::where(['user'=>$user->id,'email'=>$user->email])->orderBy('id','desc')->first();
            if (empty($codeExists)) return $this->sendError('token.error',['error'=>'Unidentified token']);

            if (time()>$codeExists->codeExpire)return $this->sendError('token.error',['error'=>'Token timeout.']);

            $hashed = Hash::check($input['code'],$codeExists->token);
            if (!$hashed) return $this->sendError('token.error',['error'=>'Invalid token entered']);

            PasswordReset::where('user',$user->id)->delete();
            //change the password

            $dataUser = [
                'password'=>bcrypt($input['password'])
            ];
            if (User::where('id',$user->id)->update($dataUser)){
                //send notification
                $user->notify(new PasswordChanged($user));

                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return $this->sendResponse([
                    'redirectTo'=>route('mobile.login')
                ],'Account Password changed. Redirecting soon ...');
            }
            return $this->sendError('password.error',['error'=>'Something went wrong']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('password.error',['error'=>'Internal Server error']);
        }
    }

    //resend verification email
    public function resendVerificationMail(Request $request){
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        try {
            $user->notify(new PasswordRecovery($user));
            return $this->sendResponse([
                'redirectTo'=>route('email-verification'),
            ],'Verification Pin sent to your mail.');
        }catch (\Exception $exception){
            Log::alert('Error occurred while resending two-factor verification mail: '.$exception->getMessage());
            return $this->sendError('error',['error'=>'Internal Server error']);
        }

    }
}
