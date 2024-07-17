<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store;

use App\Custom\GoogleUpload;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\StoreTheme;
use App\Models\SystemStaffAction;
use App\Models\User;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreSetting;
use App\Models\UserStoreVerification;
use App\Notifications\CustomNotificationNoLink;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class StoreList extends Component
{
    use  WithFileUploads,LivewireAlert,Helpers;

    public $userId;
    public $user;
    public $store;
    public $country;
    public $showInitializeStoreForm=false;
    public $showVerifyBusinessForm=false;
    #[Validate]
    public $name;
    #[Validate]
    public $serviceType;
    #[Validate]
    public $description;
    #[Validate]
    public $state;
    #[Validate]
    public $city;
    #[Validate]
    public $address;
    #[Validate]
    public $phone;
    #[Validate]
    public $email;
    #[Validate]
    public $returnPolicy;
    #[Validate]
    public $refundPolicy;
    #[Validate]
    public $logo;
    public $verifyBusiness;
    public $staff;
    public $legalName;
    public $doingBusinessAs;
    public $addressProof;
    public $regCert;
    public $regNumber;

    protected $listeners = [
        'renderAds' => 'render',
    ];

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::where('reference',$this->userId)->first();
        $this->store = UserStore::where('user',$this->user->id)->first();
        $this->showInitializeStoreForm= empty($this->store);
        $this->country=Country::where('iso3',$this->user->countryCode)->first();
        $this->staff = Auth::guard('staff')->user();
        $this->showVerifyBusinessForm= !$this->showInitializeStoreForm && $this->store->isVerified==2;
        if (!$this->showInitializeStoreForm && !empty($this->store)){
            $this->legalName = $this->store->name;
            $this->doingBusinessAs = $this->store->name;
            $this->address = $this->store->address;
        }
    }
    //validate rule
    public function rules()
    {
        return [
            'name'=>['required','string','max:200'],
            'serviceType'=>['required','integer','exists:service_types,id'],
            'description'=>['required','string'],
            'state'=>['required','alpha',Rule::exists('states','iso2')->where('country_code',$this->country->iso2)],
            'city'=>['required','string','max:150'],
            'address'=>['required','string'],
            'phone'=>['required','string'],
            'email'=>['required','email'],
            'logo'=>['nullable','image','max:2048'],
            'returnPolicy'=>['nullable','string'],
            'refundPolicy'=>['nullable','string']
        ];
    }
    //initialize store
    public function submitInitialization(Request $request)
    {
        if ($this->staff->cannot('create UserStore')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to perform this action.',
                'width' => '400',
            ]);
            return;
        }

        $this->validate();
        DB::beginTransaction();
        try {

            $reference = $this->generateUniqueReference('user_stores','reference',16);
            //let us try to upload the image
            if ($this->logo) {
                $google = new GoogleUpload();

                //lets upload the address proof
                $result = $google->uploadGoogle($this->logo);
                $logo  = $result['link'];
            }else{
                $logo='';
            }
            $merchant = User::where('reference',$this->user->reference)->first();

            $slug = $this->generateUniqueSlug('user_stores',$this->name);
            $theme = StoreTheme::where('isDefault',1)->first();

            $store = UserStore::create([
                'user'=>$merchant->id,'reference'=>$reference,
                'name'=>$this->name,'description'=>$this->description,
                'slug'=>$slug,'service'=>$this->serviceType,
                'state'=>$this->state,'city'=>$this->city,
                'logo'=>$logo,'currency'=>$merchant->mainCurrency,'country'=>$this->country->iso2,
                'address'=>$this->address,'email'=>$this->email,'phone'=>$this->phone,
                'status'=>1,'refundPolicy'=>clean($this->refundPolicy),'returnPolicy'=>clean($this->returnPolicy),
                'theme'=>$theme->id
            ]);
            if (!empty($store)) {

                UserStoreSetting::create([
                    'store' => $store->id
                ]);
                UserStoreCatalogCategory::create([
                    'store' => $store->id, 'categoryName' => 'default',
                    'isDefault' => 1, 'status' => 1
                ]);
                $this->updateStoreThemeSettting($store, $theme);

                SystemStaffAction::create([
                    'staff' => $this->staff->id,
                    'action' => 'Complete Merchant Profile',
                    'isSuper' => $this->staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($this->user).'/'.get_class($store),
                    'model_id' => $store->id,
                ]);
                DB::commit();
                $storeLink = route('merchant.store',['subdomain'=>$store->slug]);
                $message = "
                    Your store on ".config('app.name')." has been initialized successfully. login to your account to complete the business
                    verification process, and begin to sell online. Your unique store link is below:<br/>
                    <a href=".$storeLink.">$storeLink</a>
                ";
                $merchant->notify(new CustomNotificationNoLink($merchant->name,'Merchant Store Initialized',$message));

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Store successfully initialized.',
                    'width' => '400',
                ]);
                $this->showInitializeStoreForm=false;
                $this->showVerifyBusinessForm= (bool)$this->verifyBusiness;
                $this->store = $store;
                $this->dispatch('renderAds');
                return;
            }
        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while initializing the merchant store.',
                'width' => '400',
            ]);
            Log::error('Error initializing merchant store: ' . $exception->getMessage().' on line: '.$exception->getLine());
        }
    }
    //submit kyc
    public function submitKYC()
    {
        if ($this->staff->cannot('create UserStoreVerification')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to perform this action.',
                'width' => '400',
            ]);
            return;
        }

        if (empty($this->store)){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Store must be initialized first.',
                'width' => '400',
            ]);
            return;
        }

        $this->validate([
            'legalName'=>['required','string','max:200'],
            'regNumber'=>['required','string','max:50'],
            'regCert'=>['required','mimes:jpg,jpeg,png,pdf','max:2048'],
            'addressProof'=>['required','mimes:jpg,jpeg,png,pdf','max:1024'],
            'doingBusinessAs'=>['required','string','max:150'],
            'address'=>['required','string','max:200'],
        ]);

        DB::beginTransaction();

        try {
            $reference = $this->generateUniqueReference('user_store_verifications','reference',16);

            $google = new GoogleUpload();
            //let us upload the address proof
            if ($this->addressProof) {
                //lets upload the address proof
                $result = $google->uploadGoogle($this->addressProof);
                $addressProof  = $result['link'];
            }

            //let us upload the business certificate
            if ($this->regCert) {
                $results = $google->uploadGoogle($this->regCert);
                $certificate  = $results['link'];
            }

            $merchant = User::where('reference',$this->user->reference)->first();
            $businessData = [
                'store'=>$this->store->id,
                'reference'=>$reference,
                'certificate'=>$certificate,
                'addressProof'=>$addressProof,
                'status'=>4,
                'address'=>$this->address,'regNumber'=>$this->regNumber,
                'dba'=>$this->doingBusinessAs,'legalName'=>$this->legalName
            ];
            $verification = UserStoreVerification::create($businessData);
            if (!empty($verification)) {
                $this->store->isVerified = 4;
                $this->store->legalName = $this->legalName;
                $this->store->address = $this->address;
                $this->store->save();

                SystemStaffAction::create([
                    'staff' => $this->staff->id,
                    'action' => 'Submitted Store KYC',
                    'isSuper' => $this->staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($this->user).'/'.get_class($verification),
                    'model_id' => $verification->id,
                ]);

                DB::commit();

                //send notification
                $message = "The KYC for your store ".$this->store->name." has been submitted and is currently under review.";
                $merchant->notify(new CustomNotificationNoLink($merchant->name,'Store KYC Received',$message));

                $adminMessage = "A new KYC for business account has been received from ".$merchant->name.". The required
                documents have been uploaded and is awaiting your review. KYC Reference ID is ".$reference;
                $this->sendDepartmentMail('compliance', $adminMessage,'New KYB for Store Submitted');

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Store KYB successfully initialized.',
                    'width' => '400',
                ]);
                $this->showInitializeStoreForm=false;
                $this->showVerifyBusinessForm= false;
                $this->dispatch('renderAds');
                return;

            }
        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while submitting store KYB',
                'width' => '400',
            ]);
            Log::error('Error submitting store KYB: ' . $exception->getMessage().' on line: '.$exception->getLine());
        }

    }
    public function render()
    {
        $web = GeneralSetting::find(1);
        return view('livewire.staff.users.components.merchant.store.store-list',[
            'states'        =>State::where('country_code',$this->country->iso2)->orderBy('name','asc')->get(),
            'services'      =>ServiceType::where('status',1)->get(),
            'siteName'      =>$web->name
        ]);
    }
}
