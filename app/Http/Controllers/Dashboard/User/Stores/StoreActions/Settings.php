<?php

namespace App\Http\Controllers\Dashboard\User\Stores\StoreActions;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\State;
use App\Models\UserStore;
use App\Models\UserStoreSetting;
use App\Traits\Helpers;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Settings extends BaseController
{
    use Helpers;
    //edit store settings
    public function editStoreSettings(): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        $country = Country::where('iso3',$user->countryCode)->first();

        return view('dashboard.users.stores.basic_settings')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Edit Store Settings',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'states'        =>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
            'store'         =>$store,
            'settings'      =>UserStoreSetting::where('store',$store->id)->first()
        ]);
    }
    //process store settings edit
    public function processStoreSettingsEdit(Request $request,$id)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();

            $store = UserStore::where([
                'user'=>$user->id,'reference'=>$id
            ])->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }

            $validator = Validator::make($request->all(),[
                'notifications'=>['nullable','numeric'],
                'newsletter'=>['nullable','numeric'],
                'signups'=>['nullable','numeric'],
                'collectPhone'=>['nullable','numeric'],
                'collectPayment'=>['nullable','numeric'],
                'whatsappPayment'=>['nullable','numeric'],
                'whatsappNumber'=>['nullable','numeric'],
                'whatsappSupport'=>['nullable','numeric'],
                'whatsappSupportNumber'=>['nullable','numeric'],
                'escrowPayment'=>['nullable','numeric'],
                'defaultBuyText'=>['nullable','string','max:200'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            if (UserStoreSetting::where('store',$store->id)->update([
                'allowWhatsappCheckout'=>($request->has('whatsappPayment'))?1:2,
                'allowOnlineCheckout'=>($request->has('collectPayment'))?1:2,
                'allowEscrowPayments'=>($request->has('escrowPayment'))?1:2,
                'whatsappContact'=>$input['whatsappNumber'],
                'allowNotifications'=>($request->has('notifications'))?1:2,
                'allowNewLetters'=>($request->has('newsletter'))?1:2,
                'allowSignups'=>($request->has('signups'))?1:2,
                'collectPhone'=>($request->has('collectPhone'))?1:2,
                'whatsappSupport'=>($request->has('whatsappSupport'))?1:2,
                'whatsappSupportNumber'=>$input['whatsappSupportNumber'],
                'defaultBuyText'=>$input['defaultBuyText']
            ])){
                $this->userNotification($user,'Store settings Updated','Your store settings was successfully updated',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Settings successfully updated. Redirecting soon ...');
            }

        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' while updating store settings: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
