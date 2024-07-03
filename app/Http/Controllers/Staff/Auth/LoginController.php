<?php

namespace App\Http\Controllers\Staff\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\SystemStaff;
use App\Notifications\EmailVerification;
use App\Notifications\StaffTwoFactorAuthentication;
use App\Notifications\TwoFactorAuthentication;
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
                'password'=>['required',Password::min(8)->uncompromised(1)]
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
}
