<?php

namespace App\Http\Controllers\Staff\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\StaffEmailVerification;
use App\Models\SystemStaff;
use App\Models\SystemStaffAction;
use App\Notifications\EmailVerification;
use App\Notifications\StaffAccountPasswordSet;
use App\Notifications\StaffCustomNotification;
use App\Notifications\StaffTwoFactorAuthentication;
use App\Notifications\TwoFactorAuthentication;
use App\Rules\ReCaptcha;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class LoginController extends BaseController
{
    //landing page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);

        return view('staff.auth.login')->with([
            'web'        =>$web,
            'siteName'   =>$web->name,
            'pageName'   =>'Login to your account',
        ]);
    }
    //process login
    public function processLogin(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(),[
                'email'=>['required','email','exists:system_staff,email'],
                'password'=>['required',Password::min(8)->uncompromised(1)],
                'g-recaptcha-response' => ['required', new ReCaptcha]
            ],[],[
                'g-recaptcha-response'=>'Recaptcha'
            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);

            $input = $validator->validated();

            $user = SystemStaff::where([
                'email'=>$input['email']
            ])->first();
            if(empty($user)){
                return $this->sendError('staff.error',['error'=>'Account not found']);
            }
            //check password
            $hashed = Hash::check($input['password'],$user->password);
            if (!$hashed){
                return $this->sendError('authentication.error',['error'=>'Wrong email and password']);
            }
            //check status
            if ($user->status!=1){
                return $this->sendError('authentication.error',['error'=>'Account is currently locked']);
            }
            //send two-factor authentication code
            $user->notify(new StaffTwoFactorAuthentication($user));
            //store the session
            $request->session()->put([
                'two_factor'=>1,
                'staff'=>$user->id,
                'emailEmail'=>$user->email
            ]);
            return $this->sendResponse([
                'redirectTo'=>route('staff.twoFactor'),
            ],'Authentication needed. Login to your mail and use the code to login');

        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('authentication.error',['error'=>'Internal Server Error']);
        }
    }

    public function setupPassword(Request $request,$token,$email,$staff)
    {
        $web = GeneralSetting::find(1);

        return view('staff.auth.set_password')->with([
            'web'        =>$web,
            'siteName'   =>$web->name,
            'pageName'   =>'Set-up Password',
            'token'      =>$token,
            'email'      =>$email
        ]);
    }
    //process password set-up
    public function processPasswordSetUp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'exists:system_staff,email'],
                'token' => ['required','string'],
                'password'=>['required',Password::min(8)->uncompromised(1),'confirmed'],
                'password_confirmation'=>['required',Password::min(8)->uncompromised(1),'same:password'],
            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);

            $input = $validator->validated();
            $user = SystemStaff::where([
                'email' => $input['email']
            ])->first();

            if(empty($user)){
                return $this->sendError('staff.error',['error'=>'Account not found']);
            }
            //check if the token is valid
            $token = StaffEmailVerification::where([
                'email' => $input['email'],
                'token' => $input['token']
            ])->orderBy('id','desc')->first();

            if (empty($token)){
                return $this->sendError('staff.error',['error'=>'Token not found']);
            }

            //check if the token has expired
            if (time() > $token->codeExpires){
                return $this->sendError('staff.error',['error'=>'Token already expired']);
            }

            $staff = $user;

            //update record
            $data = [
                'hasUpdatedPassword'=>1,
                'password'=>bcrypt($input['password'])
            ];
            $staff->update($data);
            $token->delete();

            SystemStaffAction::create([
                'staff' => $user->id,
                'action' => 'Password Set-up',
                'isSuper' => $user->role == 'superadmin' ? 1 : 2,
                'model' => get_class($user),
                'model_id' => $user->id,
            ]);

            //notify the staff
            $user->notify(new StaffAccountPasswordSet($user));

            //send them notification
            return $this->sendResponse([
                'redirectTo'=>route('staff.login'),
            ],'Password updated. Please login to access account.');
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('authentication.error',['error'=>'Internal Server Error']);
        }
    }

    //lock staff account
    public function lockStaffAccount(Request $request,$staff)
    {
        try {
            $user = SystemStaff::where('id', $staff)->first();
            if (empty($user)){
                return to_route('staff.login')->with('error','Account not found');
            }

            if ($user->status!=1){
                return to_route('staff.login')->with('error','Account already locked.');
            }

            $user->status=3;
            $user->save();

            $message = "Your staff account was locked based on the request received at " . date('d-m-Y h:i:s', time()) . " from IP " . $request->ip() . ".<br/>
                <b>Note:</b> Your account can only be unlocked by the department with appropriate privilege.
            ";

            $user->notify(new StaffCustomNotification($user, $message, 'Staff Account Lockout',true));

            SystemStaffAction::create([
                'staff' => $user->id,
                'action' => 'Account Lock-out',
                'isSuper' => $user->role == 'superadmin' ? 1 : 2,
                'model' => get_class($user),
                'model_id' => $user->id,
            ]);
            return to_route('staff.login')->with('success','Account successfully locked.');

        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('authentication.error',['error'=>'Internal Server Error']);
        }
    }
}
