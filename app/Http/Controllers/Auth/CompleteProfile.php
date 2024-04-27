<?php

namespace App\Http\Controllers\Auth;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\RateType;
use App\Models\User;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CompleteProfile extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        if ($user->completedProfile==1){
           return redirect($this->userDashboard($user))->with('success','Welcome to your dashboard.');
        }
        $web = GeneralSetting::find(1);
        return view('auth.complete_account')->with([
            'web'       =>$web,
            'pageName'  =>'Profile Setup',
            'siteName'  =>$web->name,
            'user'      =>Auth::user(),
            'fiats'     =>Fiat::where('status',1)->get(),
            'countries' =>Country::where('status',1)->get()
        ]);
    }
    //process form for tutor
    public function processAccountCompletionSeller(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'bio'                   =>['required','string'],
                'displayName'           =>['nullable','string'],
                'gender'                =>['required','string','in:male,female,others'],
                'dob'                   =>['required','date'],
                'address'               =>['required','string'],
                'tutorKeywords'         =>['nullable'],
                'tutorKeywords.*'       =>['nullable','string'],
                'image'                 => ['required', 'image','max:1024'],

            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            $input = $validator->validated();

            //upload image
            $google = new GoogleUpload();
            $imageResult = $google->uploadGoogle($request->file('image'));
            $image  = $imageResult['link'];

            //update the user's profile
            if (User::where('id',$user->id)->update([
                'bio'=>$input['bio'], 'gender'=>$input['gender'],
                'tutorKeywords'=>implode(',',$input['tutorKeywords']),
                'activelyLookingForJob'=>$request->filled('activeForJob')?1:2,
                'completedProfile'=>1, 'dob'=>$input['dob'],
                'displayName'=>$input['displayName'],
                'address'=>$input['address'], 'accountType'=>1,'photo'=>$image
            ])){
                $this->userNotification($user,'Profile setup completed','Your profile setup as a merchant has been completed.',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('user.dashboard')
                ],'Profile completely setup. Redirecting soon ...');
            }
            return $this->sendError('setup.error',['error'=>'Something went wrong. Please try again']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('tutor.error',['error'=>'Internal Server Error']);
        }
    }
    //process form for school
    public function processAccountCompletionUser(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            //update the user's profile
            if (User::where('id',$user->id)->update([
                'completedProfile'=>1,
                'accountType'=>2
            ])){
                $this->userNotification($user,'Profile setup completed','Your profile has been setup as a buyer',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('user.dashboard')
                ],'Profile completely setup. Redirecting soon ...');
            }
            return $this->sendError('setup.error',['error'=>'Something went wrong. Please try again']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('user.error',['error'=>'Internal Server Error']);
        }
    }

}
