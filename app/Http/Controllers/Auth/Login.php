<?php

namespace App\Http\Controllers\Auth;

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

class Login extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);



        //check if session is active and redirect to dashboard
//        if (\auth()->check()){
//            $user = \auth()->user();
//            $url =  $this->userDashboard($user);
//            return redirect()->to($url);
//        }
//
//        return view('auth.login')->with([
//            'web'        =>$web,
//            'siteName'   =>$web->name,
//            'pageName'   =>'Login to your account',
//        ]);

        return redirect()->route('mobile.login');
    }
    //profess form
    public function processLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'email'=>['required','email','exists:users,email'],
                'password'=>['required',Password::min(8)->uncompromised(1)],
                'remember'=>['nullable','integer'],
                'g-recaptcha-response' => ['required', new ReCaptcha]
            ],[],[
                'g-recaptcha-response'=>'Recaptcha'
            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);

            $input = $validator->validated();
            if (Auth::attempt(
                [
                    'email' => $input['email'],
                    'password' => $input['password']
                ],$request->filled('remember')
            )) {
                $user = User::where('email',$input['email'])->first();

                //check if account is active
                if ($user->status!=1){
                    return $this->sendError('account.error',['error'=>'Account is inactive; contact support']);
                }
                //check if email is verified
                if (empty($user->email_verified_at)){
                    Auth::login($user);
                    //send email verification
                    $user->notify(new EmailVerification($user));
                    return $this->sendResponse([
                        'redirectTo'=>route('email-verification'),
                    ],'A code has been sent to your email. Verify your email to proceed.');
                }
                //user settings
                $settings = UserSetting::where('user',$user->id)->first();
                if ($settings->twoFactor==1){
                    $user->loggedIn = 2;
                    $user->save();
                    Auth::login($user);
                    $user->notify(new TwoFactorAuthentication($user));
                    $url = route('login-verification');
                    $message = "Login authorization required. Redirecting soon ...";
                }else{
                    $user->loggedIn = 1;
                    $user->save();
                    Auth::login($user);
                    if ($settings->emailNotification==1){
                        $this->notifyLogin($request, $user);
                    }
                    //since two-factor authentication is off, we redirect to the necessary page
                    $url = $this->userDashboard($user);
                    $message = "Account authenticated. Redirecting soon ...";
                }
                return $this->sendResponse([
                    'redirectTo'=>$url,
                    'user'=>$user->email
                ],$message);
            }else{
                return $this->sendError('authentication.error',['error'=>'Email and Password Combination is wrong']);
            }
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('authentication.error',['error'=>'Internal Server Error']);
        }
    }
    //start two-factor authentication
    public function twoFactorAuthentication(): Factory|View|Application
    {
        $web = GeneralSetting::find(1);

        $dataView = [
            'pageName' => 'Login Authorization',
            'siteName' => $web->name,
            'web'      => $web
        ];
        return view('auth.two_factor',$dataView);
    }
    //process two factor
    public function processTwoFactor(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            //validate request
            $validator = Validator::make($request->all(), [
                'code' => ['required', 'digits:6'],
            ])->stopOnFirstFailure();

            if ($validator->fails()){
                return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            }
            $input = $validator->validated();

            $codeExists = TwoFactor::where(['user'=>$user->id,'email'=>$user->email])->orderBy('id','desc')->first();
            if (empty($codeExists)) return $this->sendError('token.error',['error'=>'Unidentified token']);

            if (time()>$codeExists->codeExpire)return $this->sendError('token.error',['error'=>'Token timeout.']);

            $hashed = Hash::check($input['code'],$codeExists->token);
            if (!$hashed) return $this->sendError('token.error',['error'=>'Invalid token entered']);

            //update user
            $dataUser = [
                'loggedIn'=>1,
            ];

            if (User::where('id',$user->id)->update($dataUser)){

                Auth::login($user);

                $this->notifyLogin($request, $user);

                TwoFactor::where('user',$user->id)->delete();

                return $this->sendResponse([
                    'redirectTo'=>$this->userDashboard($user)
                ],'Login successfully verified.');
            }
            return $this->sendError('account.error',['error'=>'Unable to verify login']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('error',['error'=>'Internal Server error']);
        }
    }
    //logout
    public function logout(Request $request)
    {
        $user = Auth::user();

        User::where('id',$user->id)->update(['loggedIn'=>2]);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('login')->with('info','Logout successful');
    }
    //resend verification email
    public function resendVerificationMail(Request $request){
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        try {
            $user->notify(new TwoFactorAuthentication($user));
            return $this->sendResponse([
                'redirectTo'=>route('email-verification'),
            ],'Authentication Pin sent to your mail.');
        }catch (\Exception $exception){
            Log::alert('Error occurred while resending two-factor verification mail: '.$exception->getMessage());
            return $this->sendError('error',['error'=>'Internal Server error']);
        }

    }
    //logout mobile
    public function mobileLogout(Request $request)
    {
        $user = Auth::user();

        User::where('id',$user->id)->update(['loggedIn'=>2]);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('mobile.marketplace.index',['country'=>strtolower($user->countryCode)])->with('info','Logout successful');
    }
}
