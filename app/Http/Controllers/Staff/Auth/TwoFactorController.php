<?php

namespace App\Http\Controllers\Staff\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\SystemStaff;
use App\Models\SystemStaffTwoFactor;
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
            $staffEmail = $request->session()->get('staffEmail');
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

            $staff->update($data);

            //remove existing sessions
            $request->session()->flush();

            //set session
            $request->session()->put([
                'cipherLogin'=>1,
                'staff'=>$staffId,
                'emailEmail'=>$staffEmail,
                'role'=>$role
            ]);

            return $this->sendResponse([
                'redirectTo'=>route('staff.twoFactor'),
            ],'Authentication needed. Login to your mail and use the code to login');

        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->sendError('authentication.error',['error'=>'Something went wrong']);
        }
    }
}
