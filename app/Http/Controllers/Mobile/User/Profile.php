<?php

namespace App\Http\Controllers\Mobile\User;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\User;
use App\Models\UserVerification;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
                'image'                 => ['nullable', 'image','max:5000'],

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
                'redirects'=>true
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

        return view('mobile.users.profile.settings')->with([
            'pageName'  =>'Settings',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user()
        ]);
    }
    public function helpCenter()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.help')->with([
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
    public function completeProfileSocialite()
    {
        $web = GeneralSetting::find(1);

        return view('mobile.users.profile.complete_profile_socialite')->with([
            'pageName'  =>'Complete Profile',
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>Auth::user(),
            'countries' =>Country::where('status',1)->get(),
            'referral'  =>(Cookie::has('ref'))?Cookie::get('ref'):'',
        ]);
    }

    public function processCompleteProfile(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'bio'                   =>['required','string'],
                'displayName'           =>['required','string'],
                'gender'                =>['required','string','in:male,female,others'],
                'address'               =>['required','string'],
                'tutorKeywords'         =>['nullable'],
                'tutorKeywords.*'       =>['nullable','string'],
                'image'                 => ['required', 'image','max:7000'],
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
                'completedProfile'=>1,
                'displayName'=>$input['displayName'],
                'address'=>$input['address'], 'accountType'=>1,'photo'=>$image,'merchantType' => $input['merchantType']
            ])){
                $this->userNotification($user,'Profile setup completed','Your profile setup as a merchant has been completed.',$request->ip());

                $url = session()->has('redirect')?session('redirect'):route('mobile.user.profile.landing-page');

                return $this->sendResponse([
                    'redirectTo'=>$url,
                    'redirects'=>true
                ],'Profile completely setup.');
            }
            return $this->sendError('setup.error',['error'=>'Something went wrong. Please try again']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('tutor.error',['error'=>'Internal Server Error']);
        }
    }

    public function processCompleteProfileSocialite(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'bio'                   =>['required','string'],
                'displayName'           =>['required','string'],
                'gender'                =>['required','string','in:male,female,others'],
                'address'               =>['required','string'],
                'tutorKeywords'         =>['nullable'],
                'tutorKeywords.*'       =>['nullable','string'],
                'image'                 => ['nullable', 'image','max:7000'],
                'merchantType'          =>['required','numeric'],
                'name'                  => ['required', 'string'],
                'username'              => ['required', 'alpha_num', Rule::unique('users','username')->ignore($user->id)],
                'country'               => ['required',Rule::exists('countries','iso3')->where('status',1)],
                'referral'              => ['nullable', 'string', 'exists:users,username'],
            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            $input = $validator->validated();

            if ($request->hasFile('image')) {
                //upload image
                $google = new GoogleUpload();
                $imageResult = $google->uploadGoogle($request->file('image'));
                $image  = $imageResult['link'];
            }else{
                $image = $user->photo;
            }

            // Get Country from request
            $country = Country::where('iso3',$input['country'])->where('status',1)->first();
            if (!$country) {
                return $this->sendError('validation.error', ['error' => 'Country selection is required. Please reload this page.']);
            }

            //check if the user's country currency is supported
            $fiat = Fiat::where('code',$country->currency)->first();
            if (empty($fiat)){
                $currency = 'USD';
            }else{
                $currency = $fiat->code;
            }

            $refBy = $request->filled('referral') ? User::where('username', $input['referral'])->value('id') : 0;

            //update the user's profile
            if (User::where('id',$user->id)->update([
                'bio'=>$input['bio'], 'gender'=>$input['gender'],
                'tutorKeywords'=>implode(',',$input['tutorKeywords']),
                'activelyLookingForJob'=>1,
                'completedProfile'=>1,
                'displayName'=>$input['displayName'],
                'address'=>$input['address'], 'accountType'=>1,'photo'=>$image,'merchantType' => $input['merchantType'],
                'name' => $input['name'],'registrationIp' => $request->ip(),
                'username' => $input['username'],
                'country' => $country->name,
                'countryCode' => $country->iso3,
                'mainCurrency' => $currency,
            ])){
                $this->userNotification($user,'Profile setup completed','Your profile setup as a merchant has been completed.',$request->ip());
                $url = session()->has('redirect')?session('redirect'):route('mobile.user.profile.landing-page');

                return $this->sendResponse([
                    'redirectTo'=>$url,
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

    //fetch categories in industry
    public function fetchIndustryCategory(Request $request)
    {
        $industry = $request->mainCategory;
        $categories = ServiceType::where('mainCategory',$industry)
            ->select('id', 'name')->get();

        return response()->json($categories);
    }
}
