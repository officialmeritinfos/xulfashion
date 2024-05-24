<?php

namespace App\Http\Controllers\Dashboard\User\Stores\StoreActions;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\StoreTheme;
use App\Models\UserStore;
use App\Models\UserStoreThemeSetting;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Themes extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.theme.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store-front Themes',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'themes'        =>StoreTheme::get()
        ]);
    }
    //customize theme
    public function customizeDesign()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        $settings = UserStoreThemeSetting::where('store',$store->id)->first();



        return view('dashboard.users.stores.components.theme.customize')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Customize Store-front ',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'setting'       =>$settings
        ]);
    }
    //process customization
    public function saveCustomization(Request $request)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user', $user->id)->first();
            if (empty($store)) {
                return $this->sendError('store.error', ['error' => 'Store not initialized.']);
            }
            $validator = Validator::make($request->all(),[
                'textColor'=>['required','string','max:200'],
                'primaryColor'=>['required','string','max:200'],
                'headerTextColor'=>['required','string','max:150'],
                'perk'=>['sometimes', 'required'],
                'perk.*'=>['sometimes','required','string','max:200'],
                'perkIcon'=>['sometimes','required'],
                'perkIcon.*'=>['sometimes','required','string'],
                'perkContent'=>['sometimes','required'],
                'perkContent.*'=>['sometimes','required','string'],
                'footerText'=>['nullable','string'],
                'workingDay'=>['nullable','string'],
                'footerScript'=>['nullable','string'],
                'customCss'=>['nullable','string'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            $theme = UserStoreThemeSetting::where('store',$store->id)->first();

            if (UserStoreThemeSetting::where('id',$theme->id)->update([
                'textColor'=>$input['textColor'],'primaryColor'=>$input['primaryColor'],
                'headerTextColor'=>$input['headerTextColor'],'footerText'=>$input['footerText'],
                'workingDay'=>$input['workingDay'],'footerScript'=>$input['footerScript'],
                'customCSS'=>$input['customCss'],'perkSection'=>$request->has('perk')?1:2,
                'perkTitle'=>$request->input('perk'),'perkContent'=>$request->input('perkContent'),
                'perkIcon'=>$request->input('perkIcon')
            ])){
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Theme customization saved. Preview now.');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' saving store theme customization: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
