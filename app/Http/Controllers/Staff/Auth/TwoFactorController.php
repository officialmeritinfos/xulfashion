<?php

namespace App\Http\Controllers\Staff\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\SystemStaff;
use App\Models\SystemStaffTwoFactor;
use App\Notifications\StaffCustomNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TwoFactorController extends BaseController
{
    //landing page
    public function landingPage(Request $request)
    {
        //check if the session for two-factor exists
        if (!$request->session()->has('two_factor') || !$request->session()->has('staff')){
            return to_route('staff.login')->with('error','Access denied, please login again.');
        }
        $web = GeneralSetting::find(1);

        return view('staff.auth.two_factor')->with([
            'web'        =>$web,
            'siteName'   =>$web->name,
            'pageName'   =>'Two-factor Authentication',
        ]);
    }
    //process two-factor authentication
    public function processAuthentication(Request $request)
    {
        try {
            $staffId = $request->session()->get('staff');
            $staffEmail = $request->session()->get('emailEmail');
             //validate request
             $validator = Validator::make($request->all(), [
                'code' => ['required', 'digits:6'],
            ])->stopOnFirstFailure();

            if ($validator->fails()){
                return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            }
            $input = $validator->validated();

            $codeExists = SystemStaffTwoFactor::where(['user'=>$staffId,'email'=>$staffEmail])->orderBy('id','desc')->first();

            if (empty($codeExists)) return $this->sendError('token.error',['error'=>'Unidentified token']);

            if (time()>$codeExists->codeExpire)return $this->sendError('token.error',['error'=>'Token timeout.']);

            $hashed = Hash::check($input['code'],$codeExists->token);
            if (!$hashed) return $this->sendError('token.error',['error'=>'Invalid token entered']);

            $staff = SystemStaff::where(['id'=>$staffId,'email'=>$staffEmail])->first();

            if (empty($staff)) return $this->sendError('staff.error',['error'=>'Account was not found']);

            $data=[
                'lastLogin'=>$staff->loginTime,
                'loginTime'=>time(),
            ];

            $role = $staff->role;



            //remove existing sessions
            $request->session()->flush();

            //delete all tokens to avoid double replication
            SystemStaffTwoFactor::where(['user'=>$staffId,'email'=>$staffEmail])->delete();

            //set session
            $request->session()->put([
                'cipherLogin'=>1,
                'staff'=>$staffId,
                'emailEmail'=>$staffEmail,
                'role'=>$role
            ]);

            $request->session()->regenerate();//regenerate session to prevent session fixing

            $loginMessage = "
                Your staff account was accessed at ".date('d-m-Y h:i:s', time())." from IP ".$request->ip().". If this action was not performed
                by you, your account could have been compromised. Please contact the Technical unit immediately to fix your account.
            ";
            $staff->notify(new StaffCustomNotification($staff,$loginMessage,'Account Login'));


            $staff->update($data);

            return $this->sendResponse([
                'redirectTo'=>route('staff.dashboard'),
            ],'Authentication successful. Redirecting soon...');

        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->sendError('authentication.error',['error'=>'Something went wrong']);
        }
    }
}
