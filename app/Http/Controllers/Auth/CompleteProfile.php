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
            'rateTypes' =>RateType::where('status',1)->get(),
            'fiats'     =>Fiat::where('status',1)->get(),
            'countries' =>Country::where('status',1)->get()
        ]);
    }
    //process form for tutor
    public function processAccountCompletionTutor(Request $request)
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
                'workRate'              =>['required','numeric'],
                'salaryType'            =>['required',Rule::exists('rate_types','id')],
                'workPreference'        =>['required','string','in:1,2,3,4'],
                'currentlyEmployed'     =>['nullable','numeric','integer'],
                'currentEmployer'       =>['required_with:currentlyEmployed','string'],
                'employerCountry'       =>['required_with:currentlyEmployed','string','exists:countries,iso3'],
                'currentEmployerAddress'=>['required_with:employerCountry','string'],
                'currentSalary'         =>['required_with:currentlyEmployed','numeric'],
                'localized'             =>['nullable','numeric'],
                'activeForJob'          =>['nullable','numeric'],
                'tutorKeywords'         =>['nullable'],
                'tutorKeywords.*'       =>['nullable','string'],
                'minWorkHour'           =>['required','numeric'],
                'maxWorkHour'           =>['required','numeric'],
                'image'                 => ['required', 'image','max:1024'],

            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            $input = $validator->validated();

            $salaryType = RateType::find($input['salaryType']);

            //upload image
            $google = new GoogleUpload();
            $imageResult = $google->uploadGoogle($request->file('image'));
            $image  = $imageResult['link'];

            //update the user's profile
            if (User::where('id',$user->id)->update([
                'bio'=>$input['bio'], 'gender'=>$input['gender'],
                'workRate'=>$input['workRate'], 'rateType'=>$salaryType->duration,'rateTypeId'=>$salaryType->id,
                'workRateCurrency'=>$user->mainCurrency, 'currentlyEmployed'=>$request->filled('currentlyEmployed')?1:2,
                'tutorKeywords'=>implode(',',$input['tutorKeywords']),
                'currentEmployer'=>$input['currentEmployer'], 'currentEmployerCountry'=>$input['employerCountry'],
                'currentEmployerAddress'=>$input['currentEmployerAddress'], 'currentSalary'=>$input['currentSalary'],
                'localized'=>$request->filled('localized')?1:2, 'activelyLookingForJob'=>$request->filled('activeForJob')?1:2,
                'typeOfJob'=>$input['workPreference'], 'completedProfile'=>1, 'dob'=>$input['dob'],
                'displayName'=>$input['displayName'], 'address'=>$input['address'], 'tutorMinHour'=>$input['minWorkHour'],
                'tutorMaxHour'=>$input['maxWorkHour'],'accountType'=>1,'photo'=>$image
            ])){
                $this->userNotification($user,'Profile setup completed','Your profile setup as a tutor has been completed.',$request->ip());
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
    public function processAccountCompletionSchool(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'bio'                   =>['required','string'],
                'companyName'           =>['nullable','string'],
                'address'               =>['required','string'],
                'payRate'              =>['required','numeric'],
                'payType'            =>['required',Rule::exists('rate_types','id')],
                'localized'             =>['nullable','numeric'],
                'activeForJob'          =>['nullable','numeric'],
                'minWorkHour'           =>['required','numeric'],
                'maxWorkHour'           =>['required','numeric'],
                'image'                 => ['required', 'image','max:1024'],

            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            $input = $validator->validated();

            $salaryType = RateType::find($input['payType']);

            //upload image
            $google = new GoogleUpload();
            $imageResult = $google->uploadGoogle($request->file('image'));
            $image  = $imageResult['link'];

            //update the user's profile
            if (User::where('id',$user->id)->update([
                'companyName'=>$input['companyName'],
                'bio'=>$input['bio'],
                'payRate'=>$input['payRate'], 'payType'=>$salaryType->duration,'payTypeId'=>$salaryType->id,
                'payCurrency'=>$user->mainCurrency,
                'localized'=>$request->filled('localized')?1:2,
                'activelyEmploying'=>$request->filled('activeForJob')?1:2,
                'completedProfile'=>1,
                'address'=>$input['address'],
                'minWorkHour'=>$input['minWorkHour'],
                'maxWorkHour'=>$input['maxWorkHour'],
                'accountType'=>3,'photo'=>$image
            ])){
                $this->userNotification($user,'Profile setup completed','Your profile setup as a recruiter has been completed.',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('school.dashboard')
                ],'Profile completely setup. Redirecting soon ...');
            }
            return $this->sendError('setup.error',['error'=>'Something went wrong. Please try again']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('school.error',['error'=>'Internal Server Error']);
        }
    }
    //process form for parent
    public function processAccountCompletionParent(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'gender'                =>['required','string','in:male,female,others'],
                'occupation'            =>['nullable','string'],
                'address'               =>['required','string'],
                'payRate'               =>['required','numeric'],
                'payType'               =>['required',Rule::exists('rate_types','id')],
                'localized'             =>['nullable','numeric'],
                'activeForJob'          =>['nullable','numeric'],
                'minWorkHour'           =>['required','numeric'],
                'maxWorkHour'           =>['required','numeric'],
                'image'                 => ['required', 'image','max:1024'],
            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            $input = $validator->validated();

            $salaryType = RateType::find($input['payType']);

            //upload image
            $google = new GoogleUpload();
            $imageResult = $google->uploadGoogle($request->file('image'));
            $image  = $imageResult['link'];

            //update the user's profile
            if (User::where('id',$user->id)->update([
                'occupation'=>$input['occupation'],
                'gender'=>$input['gender'],
                'payRate'=>$input['payRate'],
                'payType'=>$salaryType->duration,
                'payTypeId'=>$salaryType->id,
                'payCurrency'=>$user->mainCurrency,
                'localized'=>$request->filled('localized')?1:2,
                'activelyEmploying'=>$request->filled('activeForJob')?1:2,
                'completedProfile'=>1,
                'address'=>$input['address'],
                'minWorkHour'=>$input['minWorkHour'],
                'maxWorkHour'=>$input['maxWorkHour'],
                'accountType'=>2,'photo'=>$image
            ])){
                $this->userNotification($user,'Profile setup completed','Your profile setup as a parent has been completed.',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('parent.dashboard')
                ],'Profile completely setup. Redirecting soon ...');
            }
            return $this->sendError('setup.error',['error'=>'Something went wrong. Please try again']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('parent.error',['error'=>'Internal Server Error']);
        }
    }
}
