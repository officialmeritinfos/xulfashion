<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Custom\Flutterwave;
use App\Custom\GoogleUpload;
use App\Custom\Paystack;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\RateType;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserBank;
use App\Models\UserSetting;
use App\Models\UserVerification;
use App\Models\UserVerificationDocumentType;
use App\Notifications\CustomNotification;
use App\Notifications\SendPushNotification;
use App\Traits\Helpers;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class Settings extends BaseController
{
    use Helpers;
    //landing Page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.settings.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Settings',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user)
        ]);
    }
    //user verification
    public function verification()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.settings.verification')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Account Verification',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'userDocs'      =>UserVerificationDocumentType::where('status',1)->where(function ($query) use ($user) {
                $query->where('country',strtolower($user->countryCode))
                    ->orWhere('country','all');
            }) ->get(),
            'countries'     =>Country::get()
        ]);
    }
    //process kyc submission
    public function processKycSubmission(Request $request)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();

            $validator = Validator::make($request->all(),[
                'docType'=>['required','string','exists:user_verification_document_types,slug'],
                'idNumber'=>['required','string','max:50'],
                'frontImage'=>['required','mimes:jpg,jpeg,png,pdf','max:1000'],
                'backImage'=>['nullable','mimes:jpg,jpeg,png,pdf','max:1000'],
                'addressProof'=>['required','mimes:jpg,jpeg,png,pdf','max:1000'],
                'country'=>['required','alpha','exists:countries,iso3'],
                'state'=>['required','string','max:150'],
                'address'=>['required','string','max:200'],
            ],[],[
                'frontImage'=>'Front Side of ID',
                'backImage'=>'Back Side of ID',
                'addressProof'=>'Proof of Residence',
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();


            $reference = $this->generateUniqueReference('user_verifications','reference',7);

            $directorDocRequirement = UserVerificationDocumentType::where('slug',$input['docType'])->first();
            $google = new GoogleUpload();

            //let us upload the director's proof of address
            if ($request->hasFile('addressProof')) {
                //lets upload the address proof
                $result = $google->uploadGoogle($request->file('addressProof'));
                $addressProof  = $result['link'];
            }

            //let us upload the director's id photo
            if ($request->hasFile('frontImage')) {
                $results = $google->uploadGoogle($request->file('frontImage'));
                $frontImage  = $results['link'];
            }

            if ($directorDocRequirement->hasBack==1){
                $resultBack = $google->uploadGoogle($request->file('backImage'));
                $backImage  = $resultBack['link'];
            }else{
                $backImage = '';
            }

            //check if kyc already exists
            $kycExists = UserVerification::where('user',$user->id)->first();
            if (empty($kycExists)){
                //collate director's data
                $directorData = [
                    'user'=>$user->id,
                    'reference'=>$reference,
                    'docType'=>$input['docType'],
                    'frontImage'=>$frontImage,
                    'backImage'=>$backImage,
                    'idNumber'=>$input['idNumber'],
                    'utilityBill'=>$addressProof,
                    'status'=>4
                ];

                //we create the document
                $verification = UserVerification::create($directorData);
                if (!empty($verification)){
                    $user->isVerified=4;
                    $user->state=$input['state'];
                    $user->save();

                    //send notification
                    $message = "The KYC for your account ".$user->name." has been submitted and is currently under review.";
                    $this->userNotification($user,'KYC for Account submitted',$message,$request->ip());

                    //send message to admin
                    $adminMessage = "A new KYC for individual account has been received from ".$user->name.". The required
                documents have been uploaded and is awaiting your review. KYC Reference ID is ".$reference;
                    $this->sendDepartmentMail('compliance', $adminMessage,'New KYC for Account Submitted.');

                    return $this->sendResponse([
                        'redirectTo'=>url()->previous()
                    ],'Your account KYC has been received and will be reviewed shortly. ');
                }
                return $this->sendError('document.error',[
                    'error'=>'Something went wrong while processing your documents'
                ]);
            }else{
                //collate director's data
                $directorData = [
                    'docType'=>$input['docType'],
                    'frontImage'=>$frontImage,
                    'backImage'=>$backImage,
                    'idNumber'=>$input['idNumber'],
                    'utilityBill'=>$addressProof,
                    'status'=>4
                ];

                //we update
                $kycExists->update($directorData);

                $user->isVerified=4;
                $user->state=$input['state'];
                $user->save();

                //send notification
                $message = "The KYC for your account ".$user->name." has been submitted and is currently under review.";
                $this->userNotification($user,'KYC for Account submitted',$message,$request->ip());

                //send message to admin
                $adminMessage = "A new KYC for individual account has been received from ".$user->name.". The required
                documents have been uploaded and is awaiting your review. KYC Reference ID is ".$reference;
                $this->sendDepartmentMail('compliance',$adminMessage,'New KYC for Account Submitted.');

                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Your account KYC has been received and will be reviewed shortly. ');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' updating verification documents: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //basic settings
    public function basicSettings()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.settings.basic')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Basic Settings',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'settings'      =>UserSetting::where('user',$user->id)->first()
        ]);
    }
    //update basic setting
    public function updateBasicSettings(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'emailNotification'       =>['nullable','numeric'],
                'newsletter'              =>['nullable','numeric'],
                'withdrawalNotification'  =>['nullable','numeric'],
                'depositNotification'     =>['nullable','numeric'],
                'collectPayment'          =>['nullable','numeric'],

            ])->stopOnFirstFailure();
            if ($validator->fails()){
                return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            }

            if (UserSetting::where('user',$user->id)->update([
                'newsletters' => $request->filled('newsletter')?1:2,
                'withdrawalNotification' => $request->filled('withdrawalNotification')?1:2,
                'depositNotification' => $request->filled('depositNotification')?1:2,
                'emailNotification' => $request->filled('emailNotification')?1:2,
                'collectPayment' => $request->filled('collectPayment')?1:2,
            ])){
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Setting updated');
            }
            return $this->sendError('error',['error'=>'Something went wrong']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('basic.settings.error',['error'=>'Internal Server Error']);
        }
    }
    //payout account
    public function payoutAccount()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.settings.payout')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Payout Accounts',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'banks'         =>UserBank::where('user',$user->id)->paginate()
        ]);
    }
    //add payout account
    public function addPayoutAccount(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);
            $validator = Validator::make($request->all(), [
                'password'=>['required','string','current_password:web',Password::min(8)->uncompromised(1)],
                'otp'=>['required','numeric'],
                'bank'=>['required','numeric'],
                'accountNumber'=>['required','numeric'],
                'isPrimary'=>['nullable','numeric'],
            ],['current_password'=>'Current password is wrong'],['oldPassword'=>'Current Password'])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();
            //check the otp.
            if ($user->otpExpires<time()){
                return $this->sendError('authentication.error', ['error' => 'OTP has timed out.']);
            }

            if (!Hash::check($input['otp'],$user->otp)){
                return $this->sendError('authentication.error', ['error' => 'Invalid OTP']);
            }
            $user->otp='';
            $user->otpExpires='';
            $user->save();

            //check if account already exists
            $exists = UserBank::where([
                'bank'=>$input['bank'],
                'accountNumber'=>$input['accountNumber'],
                'user'=>$user->id
            ])->first();

            if (!empty($exists)){
                return $this->sendError('payout.account.error',['error'=>'Payout account already exist']);
            }

            $reference = $this->generateUniqueReference('user_banks','reference',20);
            //create the beneficiary
            $client = new Paystack();

            $response = $client->addRecipient([
                'bank_code'=>$input['bank'],
                'account_number'=>$input['accountNumber'],
                'name'=>$user->name,
                'type'=>'nuban','currency'=>$user->currency
            ]);

            if ($response->successful()){
                $res = $response->json();
                $data = $res['data'];

                $bankName = $data['details']['bank_name'];
                $bankCode = $data['details']['bank_code'];
                $accountName = $data['details']['account_name'];
                $accountNumber = $data['details']['account_number'];
                $benId = $data['recipient_code'];
            }else{
                $res = $response->json();
                Log::info($response->json());
                return $this->sendError('payout.account.error',['error'=>$res['message']]);
            }

            $beneficiary = UserBank::create([
                'user'=>$user->id,'bank'=>$bankCode,
                'bankName'=>$bankName,'accountNumber'=>$accountNumber,
                'reference'=>$reference,'benRef'=>$benId,
                'accountName'=>$accountName
            ]);

            if (!empty($beneficiary)){


                $message = 'A new payout account has been added to your account on '.$web->name;
                UserActivity::create([
                    'user'=>$user->id,'title'=>'New Payout account',
                    'content'=>$message
                ]);
                //send notification
                $user->notify(new SendPushNotification($user,'New Payout Account',$message));
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Payout account successfully added.');
            }
            return $this->sendError('payout.account.error',['error'=>'We are unable to add beneficiary.']);

        }catch (\Exception $exception){
            Log::info($exception->getMessage().' on '.$exception->getLine());
            return $this->sendError('location.error',['error'=>'Internal Server error']);
        }
    }
    //security settings
    public function securitySettings()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.settings.security')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Security Settings',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'setting'       =>UserSetting::where('user',$user->id)->first()
        ]);
    }
    //update security setting - password
    public function updateSecuritySettingsPassword(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'oldPassword'               =>['required','current_password:web'],
                'newPassword'               =>['required','confirmed',Password::min(8)->mixedCase()->symbols()->uncompromised(1)],

            ])->stopOnFirstFailure();
            if ($validator->fails()){
                return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            }
            $input = $validator->validated();

            if (User::where('id',$user->id)->update([
                'password' =>bcrypt($input['newPassword'])
            ])){
                $this->userNotification($user,'Password Update','Account password was recently updated',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Password updated');
            }
            return $this->sendError('error',['error'=>'Something went wrong']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('basic.settings.error',['error'=>'Internal Server Error']);
        }
    }
    //update security setting - 2fa
    public function updateSecuritySettingsTwoFactor(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'password'               =>['required','current_password:web'],
                'twoFactor'              =>['required','numeric'],

            ])->stopOnFirstFailure();
            if ($validator->fails()){
                return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            }
            $input = $validator->validated();

            if (UserSetting::where('user',$user->id)->update([
                'twoFactor' =>$input['twoFactor']
            ])){
                $this->userNotification($user,'Two-factor authentication','Account two-factor authentication was recently updated',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Two factor authentication updated');
            }
            return $this->sendError('error',['error'=>'Something went wrong']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('basic.settings.error',['error'=>'Internal Server Error']);
        }
    }



    //send otp
    public function sendOtp()
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $otp = $this->generateToken('users','reference');

            $user->otp = bcrypt($otp);
            $user->otpExpires =strtotime($web->codeExpire,time());


            $message = "There is a new request on your account requiring an OTP. The OTP to use is <b>".$otp."</b>.
            <p>This OTP will expire in <b>".$web->codeExpire."</b>. Note that neither ".$web->name." nor her staff will ever ask you for your OTP.";

            $user->notify(new CustomNotification($user,$message,'OTP Authentication'));
            $user->save();
            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'An OTP has been sent to your registered mail. Please use it to authenticate this action.');

        }catch (ThrottleRequestsException $exception){
            return $this->sendError('otp.error',['error'=>'You can only request for OTP once every minute. Please wait.']);
        }catch (\Exception $exception){
            Log::info('Error on '.$exception->getFile().' on line '.$exception->getLine().': '.$exception->getMessage());
            return $this->sendError('otp.error',['error'=>'Internal Server error; we are working on this now']);
        }
    }
    //get banks in country
    public function getCountryBanks()
    {
        try {
            $user = Auth::user();
            $countryCode = $user->countryCode;
            $country = Country::where('iso3',$countryCode)->first();
            $client = new Paystack();
            $response = $client->fetchBank(strtolower($country->name));
            if ($response->successful()){
                $res = $response->json();

                return $this->sendResponse([
                    'banks'=>$res['data']
                ],'Banks retrieved.');

            }else{
                return $this->sendError('bank.error',['error'=>'There was an error retrieving banks']);
            }
        }catch (\Exception $exception){
            Log::info($exception->getMessage());
            return $this->sendError('bank.error',['error'=>'An internal server error occurred']);
        }

    }
    //Bio settings
    public function bioSetting()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.settings.bio')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Portfolio Settings',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'setting'       =>UserSetting::where('user',$user->id)->first(),
            'fiats'         =>Fiat::where('status',1)->get(),
            'countries'     =>Country::where('status',1)->get()
        ]);
    }
    //process bio update
    public function processPortfolioUpdate(Request $request)
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
                'activeForJob'          =>['nullable','numeric'],
                'tutorKeywords'         =>['nullable'],
                'tutorKeywords.*'       =>['nullable','string'],
                'image'                 => ['required', 'image','max:1024'],

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

            //update the user's profile
            if (User::where('id',$user->id)->update([
                'bio'=>$input['bio'], 'gender'=>$input['gender'],
                'activelyLookingForJob'=>$request->filled('activeForJob')?1:2,
                 'dob'=>$input['dob'],'displayName'=>$input['displayName'], 'address'=>$input['address'],
                'photo'=>$image
            ])){
                $this->userNotification($user,'Profile updated','Your profile data has been updated.',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'profile update successful. Redirecting soon ...');
            }
            return $this->sendError('setup.error',['error'=>'Something went wrong. Please try again']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('tutor.error',['error'=>'Internal Server Error']);
        }
    }
}
