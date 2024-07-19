<?php

namespace App\Http\Controllers\Dashboard\User\Stores;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\StoreTheme;
use App\Models\UserAd;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreSetting;
use App\Models\UserStoreVerification;
use App\Traits\Helpers;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Stores extends BaseController
{
    use Helpers;
    public $google;
    //landing page
    public function __construct()
    {
        $this->google = new GoogleUpload();
    }

    //landing page
    public function landingPage(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.stores.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'ads'           =>UserAd::where('user',$user->id)->orderBy('id','desc')->get(),
            'store'         =>UserStore::where('user',$user->id)->first()
        ]);
    }
    //initialize store
    public function initializeStore(): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (!empty($store)){
            return back()->with('error','Store already initialized. Update store information instead.');
        }
        $country = Country::where('iso3',$user->countryCode)->first();

        return view('dashboard.users.stores.initialize')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store initialization',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'states'        =>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
            'services'      =>ServiceType::where('status',1)->get()
        ]);
    }
    //process store initialization
    public function processStoreInitialization(Request $request)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $country = Country::where('iso3',$user->countryCode)->first();


            $validator = Validator::make($request->all(),[
                'name'=>['required','string','max:200'],
                'serviceType'=>['required','integer','exists:service_types,id'],
                'description'=>['required','string'],
                'state'=>['required','alpha',Rule::exists('states','iso2')->where('country_code',$country->iso2)],
                'city'=>['required','string','max:150'],
                'address'=>['required','string'],
                'phone'=>['required','string'],
                'email'=>['required','email'],
                'file'=>['nullable','image','max:2048'],
                'returnPolicy'=>['nullable','string'],
                'refundPolicy'=>['nullable','string']
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            $reference = $this->generateUniqueReference('user_stores','reference',16);
            //let us try to upload the image
            if ($request->hasFile('file')) {
                //lets upload the address proof
                $result = $this->google->uploadGoogle($request->file('file'));
                $logo  = $result['link'];
            }else{
                $logo='';
            }

            $slug = $this->generateUniqueSlug('user_stores',$input['name']);

            $theme = StoreTheme::where('isDefault',1)->first();

            $store = UserStore::create([
                'user'=>$user->id,'reference'=>$reference,
                'name'=>$input['name'],'description'=>$input['description'],
                'slug'=>$slug,'service'=>$input['serviceType'],
                'state'=>$input['state'],'city'=>$input['city'],
                'logo'=>$logo,'currency'=>$user->mainCurrency,'country'=>$country->iso2,
                'address'=>$input['address'],'email'=>$input['email'],'phone'=>$input['phone'],
                'status'=>1,'refundPolicy'=>clean($input['refundPolicy']),'returnPolicy'=>clean($input['returnPolicy']),
                'theme'=>$theme->id
            ]);
            if (!empty($store)){

                UserStoreSetting::create([
                    'store'=>$store->id
                ]);
                UserStoreCatalogCategory::create([
                    'store'=>$store->id,'categoryName'=>'default',
                    'isDefault'=>1,'status'=>1
                ]);
                $this->updateStoreThemeSettting($store,$theme);

                $this->userNotification($user,'Store Initialized','Your store was successfully initialized',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>($request->has('verifyBusiness'))?route('user.stores.verify'):route('user.stores.index')
                ],'Store successfully initialized. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' while initializing store: ' . $exception->getMessage().' on line '.$exception->getLine());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }

    //edit store
    public function editStoreInfo(): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        $country = Country::where('iso3',$user->countryCode)->first();

        return view('dashboard.users.stores.edit_store')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Edit Store Info',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'states'        =>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
            'services'      =>ServiceType::where('status',1)->get(),
            'store'         =>$store
        ]);
    }
    //process store edit
    public function processStoreEdit(Request $request,$id)
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
                'name'=>['required','string','max:200'],
                'serviceType'=>['required','integer','exists:service_types,id'],
                'description'=>['required','string'],
                'state'=>['required','alpha',Rule::exists('states','iso2')->where('country_code',$country->iso2)],
                'city'=>['required','string','max:150'],
                'address'=>['required','string'],
                'phone'=>['required','string'],
                'email'=>['required','email'],
                'file'=>['nullable','image','max:2048'],
                'returnPolicy'=>['nullable','string'],
                'refundPolicy'=>['nullable','string']
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            //let us try to upload the image
            if ($request->hasFile('file')) {
                //lets upload the address proof
                $result = $this->google->uploadGoogle($request->file('file'));
                $logo  = $result['link'];
            }else{
                $logo=$store->logo;
            }


            if (UserStore::where('id',$store->id)->update([
                'user'=>$user->id,
                'name'=>$input['name'],'description'=>$input['description'],
                'service'=>$input['serviceType'],
                'state'=>$input['state'],'city'=>$input['city'],
                'logo'=>$logo,'currency'=>$user->mainCurrency,'country'=>$country->iso2,
                'address'=>$input['address'],'email'=>$input['email'],'phone'=>$input['phone'],
                'refundPolicy'=>clean($input['refundPolicy']),'returnPolicy'=>clean($input['returnPolicy'])
            ])){

                $this->userNotification($user,'Store Information Updated','Your store information was successfully updated',$request->ip());
                return $this->sendResponse([
                    'redirectTo'=>route('user.stores.index')
                ],'Store successfully updated. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' while edit store info: ' . $exception->getMessage().' on line: '.$exception->getLine());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }

}
