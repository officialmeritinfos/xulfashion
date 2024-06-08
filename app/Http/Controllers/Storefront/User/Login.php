<?php

namespace App\Http\Controllers\Storefront\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserSetting;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreSetting;
use App\Notifications\EmailVerification;
use App\Notifications\SendStoreCustomerLoginAuthentication;
use App\Notifications\TwoFactorAuthentication;
use App\Traits\Helpers;
use App\Traits\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class Login extends BaseController
{
    use Helpers,Themes;
    //landing page
    public function landingPage($subdomain)
    {
        $userStore = UserStore::where('slug',$subdomain)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>$userStore->name.' Customer Login',
        ];
        return view('storefront.account.login')->with($data);
    }
    //process login
    public function processLogin(Request $request, $subdomain)
    {
        $userStore = UserStore::where('slug',$subdomain)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();

        try {
            $validator = Validator::make($request->all(),[
                'email'=>['required','email',Rule::exists('user_store_customers','email')->where('store',$userStore->id)],
                'password'=>['nullable',Password::min(8)->uncompromised(1)],
            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);

            $input = $validator->validated();

            $customer = UserStoreCustomer::where([
                'email'=>$input['email'],'store'=>$userStore->id
            ])->first();

            if (empty($request->password)){
                $customer->notify(new SendStoreCustomerLoginAuthentication($customer));

                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'We have sent a mail to your registered email to authenticate this action.');
            }
            //since password was passed, we will check the password
            $hashed = Hash::check($input['password'],$customer->password);
            if (!$hashed){
                return $this->sendError('authentication.error',['error'=>'Wrong Email and Password combination']);
            }
            //login
            $request->session()->put([
                'loggedIn'=>1,
                'customer'=>$customer->id,
                'loggedInStore'=>$userStore->id
            ]);
            $customer->loggedIn=1;
            $customer->save();

            $request->session()->regenerate();
            return $this->sendResponse([
                'redirectTo'=>route('merchant.store.user.index',['subdomain'=>$userStore->slug])
            ],'Account successfully authenticated. Redirecting soon.');

        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('authentication.error',['error'=>'Internal Server Error']);
        }
    }
    //authenticate login
    public function authenticateLogin(Request $request, $subdomain, $customerRef)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->to(route('merchant.store.login',['subdomain'=>$subdomain]))->with('error','Invalid login action');
        }
        try {
            //store
            $store = UserStore::where('slug',$subdomain)->firstOrFail();

            $customer = UserStoreCustomer::where([
                'store'=>$store->id, 'reference'=>$customerRef
            ])->firstOrFail();
            //authenticate the login by setting sessions that we need later
            $request->session()->put([
                'loggedIn'=>1,
                'customer'=>$customer->id,
                'loggedInStore'=>$store->id
            ]);
            $customer->loggedIn=1;
            $customer->save();

            $request->session()->regenerate();
            //take to the dashboard
            return redirect()->to(route('merchant.store.user.index',['subdomain'=>$store->slug]))->with('success','Account login successful');

        }catch (\Exception $exception){
            Log::info($exception->getMessage());
            return redirect()->to(route('merchant.store.login',['subdomain'=>$subdomain]))->with('error','An error occurred.');
        }
    }
}
