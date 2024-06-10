<?php

namespace App\Http\Controllers\Storefront\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\State;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreOrder;
use App\Models\UserStoreSetting;
use App\Notifications\SendStoreCustomerNotification;
use App\Traits\Helpers;
use App\Traits\Themes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use SebastianBergmann\Diff\Exception;

class Profiles extends BaseController
{
    use Helpers,Themes;
    //landing page
    public function landingPage(Request $request,$subdomain)
    {
        $userStore = UserStore::where('slug',$subdomain)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);
        $customer = UserStoreCustomer::where([
            'store'=>$userStore->id,'id'=>$request->session()->get('customer')
        ])->firstOrFail();

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>'Profile',
            'customer'        =>$customer,
            'orders'          =>UserStoreOrder::where('customer',$customer->id)->count(),
            'sumOfOrders'     =>UserStoreOrder::where([
                'customer'=>$customer->id,
            ])->where(function ($query){
                $query->whereNot('status',3)->orWhereNot('status',2)->get();
            })->sum('amountPaid')
        ];
        return view('storefront.account.profile.index')->with($data);
    }
    //settings
    public function settings(Request $request,$subdomain)
    {
        $userStore = UserStore::where('slug',$subdomain)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);
        $customer = UserStoreCustomer::where([
            'store'=>$userStore->id,'id'=>$request->session()->get('customer')
        ])->firstOrFail();

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>'Profile Setup',
            'customer'        =>$customer,
            'countries'       =>Country::where('status',1)->get()
        ];
        return view('storefront.account.profile.settings')->with($data);
    }
    //update info settings
    public function updateInfoSettings(Request $request,$subdomain,$customerId): JsonResponse
    {
        $userStore = UserStore::where('slug',$subdomain)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);
        $customer = UserStoreCustomer::where([
            'store'=>$userStore->id,'id'=>$customerId
        ])->first();

        if (empty($customer)){
            return $this->sendError('customer.error',['error'=>'Action denied: we cannot find your ID']);
        }
        try {
            $validator = Validator::make($request->all(),[
                'name'          =>['required','string','max:150'],
                'phone'         =>['required','string','max:150'],
                'bio'           =>['nullable','string'],
                'country'       =>['required','string','max:3'],
                'state'         =>['required','string','max:3'],
                'address'       =>['required','string']
            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);

            $input = $validator->validated();

            //check if the country is supported
            $country = Country::where('iso3',$input['country'])->where('status',1)->first();
            if (empty($country)){
                return $this->sendError('country.error',['error'=>'Unsupported country selected']);
            }
            ///check if the state exists in the country
            $state = State::where('country_code',$country->iso2)->where('iso2',$input['state'])->first();
            if (empty($state)){
                return $this->sendError('state.error',['error'=>'State not found']);
            }

            $customer->update([
               'name'=>$input['name'],'country'=>$country->iso3,
               'state'=>$input['state'],'phone'=>$input['phone'],
               'address'=>$input['address'],'bio'=>$input['bio']
            ]);

            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Information successfully updated.');
        }catch (Exception $exception){
            Log::alert($exception->getMessage().' on line '.$exception->getLine().' in file '.$exception->getFile());
            return $this->sendError('customer.settings.error',['error'=>'Internal Server Error']);
        }
    }
    //set up password
    public function setupPassword(Request $request,$subdomain,$customerId): JsonResponse
    {
        $userStore = UserStore::where('slug',$subdomain)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);
        $customer = UserStoreCustomer::where([
            'store'=>$userStore->id,'id'=>$customerId
        ])->first();

        if (empty($customer)){
            return $this->sendError('customer.error',['error'=>'Action denied: we cannot find your ID']);
        }
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(),[
                'password'                  =>['required','confirmed',Password::min(8)->uncompromised(1)],
                'password_confirmation'     =>['required','string','max:150']
            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);

            $input = $validator->validated();

            $customer->password=bcrypt($input['password']);
            $customer->save();

            $message = "A New password was just added to your account ".$userStore->name.". The details are as follow:
                <p><b>Password</b>:".$input['password']."</p>
                <p><b>IP</b>:".$request->ip()."</p>
                <p><b>Time</b>:".date('d-m-Y-H-i-s',time())."</p>
            ";
            $customer->notify(new SendStoreCustomerNotification($customer,'Password Added to Account',$message));
            DB::commit();
            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Password successfully added.');
        }catch (Exception $exception){
            DB::rollBack();
            Log::alert($exception->getMessage().' on line '.$exception->getLine().' in file '.$exception->getFile());
            return $this->sendError('customer.password.setup.error',['error'=>'Internal Server Error']);
        }
    }
    //update password
    public function changePassword(Request $request,$subdomain,$customerId): JsonResponse
    {
        $userStore = UserStore::where('slug',$subdomain)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);
        $customer = UserStoreCustomer::where([
            'store'=>$userStore->id,'id'=>$customerId
        ])->first();

        if (empty($customer)){
            return $this->sendError('customer.error',['error'=>'Action denied: we cannot find your ID']);
        }
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(),[
                'oldPassword'                  =>['required'],
                'newPassword'                  =>['required','confirmed'],
                'newPassword_confirmation'     =>['required','string','max:150']
            ])->stopOnFirstFailure();
            if ($validator->fails()) {
                return $this->sendError('validation.error',['error'=>$validator->errors()->all()]);
            }

            $input = $validator->validated();

            //check if the password is correct
            $hashed = Hash::check($input['oldPassword'],$customer->password);
            if (!$hashed){
                return $this->sendError('password.error',['error'=>'Old Password is wrong']);
            }

            $customer->password=bcrypt($input['newPassword']);
            $customer->save();

            $message = "The password for your account on ".$userStore->name." has been changed. The details are as follow:
                <p><b>IP</b>:".$request->ip()."</p>
                <p><b>Time</b>:".date('d-m-Y-H-i-s',time())."</p>
            ";
            $customer->notify(new SendStoreCustomerNotification($customer,'Account Password Updated',$message));
            DB::commit();

            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Password successfully updated.');
        }catch (Exception $exception){
            DB::rollBack();
            Log::alert($exception->getMessage().' on line '.$exception->getLine().' in file '.$exception->getFile());
            return $this->sendError('customer.password.setup.error',['error'=>'Internal Server Error']);
        }
    }
}
