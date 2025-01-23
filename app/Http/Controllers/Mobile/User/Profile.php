<?php

namespace App\Http\Controllers\Mobile\User;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserVerification;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Profile extends BaseController
{
    use Helpers;
    //landing Page
    public function landingPage()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.index')->with([
            'pageName'  =>'Profile Manager',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }
    //landing Page
    public function editProfile()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.edit_profile')->with([
            'pageName'  =>'Edit Profile',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }
    //update profile
    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'name'                  =>['required','string'],
                'phone'                 =>['required','string'],
                'image'                 => ['nullable', 'image','max:1024'],

            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            $input = $validator->validated();

            $image = $user->photo;
            if ($request->hasFile('image')){
                //upload image
                $google = new GoogleUpload();
                $imageResult = $google->uploadGoogle($request->file('image'));
                $image  = $imageResult['link'];
            }

            if (User::where('id',$user->id)->update([
                'name'=>$input['name'],
                'photo'=>$image
            ])){
            $this->userNotification($user,'Profile updated','Your profile data has been updated.',$request->ip());
            return $this->sendResponse([
                'redirectTo'=>url()->previous(),
                'photo'=>$image,
                'name'=>$input['name'],
                'redirects'=>false
            ],'profile update successful.');
        }
            return $this->sendError('setup.error',['error'=>'Something went wrong. Please try again']);


        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('user.profile.error',['error'=>'Internal Server Error']);
        }
    }
    public function comingSoon()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.placeholder.coming_soon')->with([
            'pageName'  =>'Coming Soon',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }
    public function postAds()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.placeholder.post_ad')->with([
            'pageName'  =>'ADS',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }
    public function settings()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.placeholder.settings')->with([
            'pageName'  =>'Settings',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }
    public function helpCenter()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.placeholder.help')->with([
            'pageName'  =>'Help Center',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }
    public function completeProfile()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.complete_profile')->with([
            'pageName'  =>'Complete Profile',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }

    public function processCompleteProfile(Request $request)
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
                'image'                 => ['required', 'image','max:5120'],
                'merchantType'          =>['required','numeric']

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
                'activelyLookingForJob'=>1,
                'completedProfile'=>1, 'dob'=>$input['dob'],
                'displayName'=>$input['displayName'],
                'address'=>$input['address'], 'accountType'=>1,'photo'=>$image,'merchantType' => $input['merchantType']
            ])){
                $this->userNotification($user,'Profile setup completed','Your profile setup as a merchant has been completed.',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('mobile.user.profile.landing-page'),
                    'redirects'=>true
                ],'Profile completely setup.');
            }
            return $this->sendError('setup.error',['error'=>'Something went wrong. Please try again']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('tutor.error',['error'=>'Internal Server Error']);
        }
    }
    //user kyc
    public function userKyc()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.kyc')->with([
            'pageName'  =>'KYC Verification',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }
}
