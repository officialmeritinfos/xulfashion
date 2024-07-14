<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Ads;

use App\Custom\GoogleUpload;
use App\Models\Country;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\SystemStaffAction;
use App\Models\User;
use App\Models\UserAd;
use App\Models\UserAdPhoto;
use App\Traits\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateAd extends Component
{
    use WithFileUploads, Helpers, LivewireAlert;

    public $user;
    public $userId;
    #[Validate]
    public $priceType = 2;
    #[Validate]
    public $location;
    #[Validate]
    public $featuredImage;
    #[Validate]
    public $title;
    #[Validate]
    public $companyName;
    #[Validate]
    public $serviceType;
    #[Validate]
    public $description;
    #[Validate]
    public $price;
    #[Validate]
    public $negotiate;
    #[Validate]
    public $category=[];
    #[Validate]
    public $photos = [];
    public $country;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::where('reference', $this->userId)->first();
        $this->country = Country::where('iso3',$this->user->countryCode)->first();
    }

    //set rules
    public function rules()
    {
        return [
            'location'=>['required','alpha',Rule::exists('states','iso2')->where('country_code',$this->country->iso2)],
            'featuredImage'=>['required','image','max:2048'],
            'title'=>['required','string','max:200'],
            'companyName'=>['nullable','string','max:150'],
            'serviceType'=>['required','integer','exists:service_types,id'],
            'description'=>['required','string'],
            'priceType'=>['required','integer','in:1,2'],
            'price'=>['nullable','required_if:priceType,2', 'numeric'],
            'negotiate'=>['nullable','numeric','in:1,2,3'],
            'category.*'=>['nullable','string'],
            'photos.*'=>['nullable','image','max:2048'],
        ];
    }

    public function submit()
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('create UserAd')) {

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to create an Ad for a user.',
                'width' => '400',
            ]);
            return;
        }
        $this->validate();
        $google = new GoogleUpload();
        DB::beginTransaction();
        try {
            $reference = $this->generateUniqueReference('user_ads','reference',16);

            if ($this->featuredImage) {
                //lets upload the address proof
                $result = $google->uploadGoogle($this->featuredImage);
                $featuredPhoto  = $result['link'];
            }
            $ad = UserAd::create([
                'user'=>$this->user->id,'reference'=>$reference,
                'title'=>$this->title,'description'=>$this->description,
                'companyName'=>$this->companyName,'priceType'=>$this->priceType,
                'amount'=>($this->priceType!=2)?0:$this->price,'serviceType'=>$this->serviceType,
                'state'=>$this->location,'tags'=>$this->category,
                'openToNegotiation'=>$this->negotiate,'status'=>2,
                'featuredImage'=>$featuredPhoto,'currency'=>$this->user->mainCurrency,'country'=>$this->country->iso2
            ]);

            $merchant = User::where('reference',$this->userId)->first();

            if (!empty($ad)){
                //check if photos were uploaded
                if ($this->photos){
                    foreach ($this->photos as $index => $item) {
                        $result = $google->uploadGoogle($item);
                        $fileName = $result['link'];

                        UserAdPhoto::create([
                            'ad'=>$ad->id,'photo'=>$fileName
                        ]);
                    }
                }

                SystemStaffAction::create([
                    'staff' => $staff->id,
                    'action' => 'Added an Ad to merchant',
                    'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($merchant).'/'.get_class($ad),
                    'model_id' => $merchant->id,
                ]);
                DB::commit();

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Ad successfully added.',
                    'width' => '400',
                ]);
                $this->dispatch('adsCreated',route('staff.users.ads',['id'=>$merchant->reference]));
                return;
            }

        }catch (\Exception $exception){
             $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while creating an ad for merchant.s',
                'width' => '400',
            ]);
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while adding new ad to merchant: ' . $exception->getMessage());
             return;
        }
    }

    public function togglePriceType($value)
    {
        $this->priceType = $value;
    }

    public function render()
    {
        $country = Country::where('iso3',$this->user->countryCode)->first();
        return view('livewire.staff.users.components.merchant.ads.create-ad',[
            'states'=>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
            'services'=>ServiceType::where('status',1)->get()
        ]);
    }
}
