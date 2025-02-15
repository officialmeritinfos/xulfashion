<?php

namespace App\Livewire\Mobile\Users\Store\Components;

use App\Mail\StoreCreatedNotification;
use App\Models\Country;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\StoreTheme;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreSetting;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditStoreForm extends Component
{
    use WithFileUploads,Helpers;
    public $user;

    public $name;
    public $serviceType;
    public $description;
    public $returnPolicy;
    public $refundPolicy;
    public $file;
    public $state;
    public $city;
    public $address;
    public $supportPhone;
    public $supportEmail;
    public $verifyBusiness = false;
    public $country;
    public $industry;
    public $categories=[];
    public $showCategory = false;
    public $store;

    public function mount(UserStore $store)
    {
        $this->user = auth()->user();
        $this->country = Country::where('iso3',$this->user->countryCode)->first();
        $this->store = $store;

        if ($this->store){
            $this->name = $this->store->name;
            $this->description = $this->store->description;
            $this->returnPolicy = $this->store->returnPolicy;
            $this->refundPolicy = $this->store->refundPolicy;
            $this->state = $this->store->state;
            $this->city = $this->store->city;
            $this->address = $this->store->address;
            $this->supportEmail = $this->store->email;
            $this->supportPhone = $this->store->phone;
            $this->industry = $this->store->industry;
            if ($this->industry){
                $this->fetchIndustryCategories();
                $this->serviceType = $this->store->service;
            }
        }
    }
    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
           <svg width="100%" height="400px" viewBox="0 0 400 400" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="skeleton-gradient">
                        <stop offset="0%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="50%" stop-color="#e0e0e0">
                            <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="100%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                    </linearGradient>
                </defs>

                <!-- Card Placeholder 1 -->
                <rect x="10" y="10" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="25" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="55" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="75" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 2 -->
                <rect x="10" y="130" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="145" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="175" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="195" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 3 -->
                <rect x="10" y="250" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="265" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="295" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="315" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />
            </svg>
        </div>
        HTML;
    }
    public function render()
    {
        $country = Country::where('iso3',$this->user->countryCode)->first();

        return view('livewire.mobile.users.store.components.edit-store-form',[
            'states' => State::where('country_code', $country->iso2)->orderBy('name')->get(),
        ]);
    }
    public function processForm(Request $request)
    {
        $this->resetErrorBag();

        // 1. Validate form input data
        $this->validate([
            'name' => ['required', 'string', 'max:200'],
            'serviceType' => ['required', 'integer', 'exists:service_types,id'],
            'description' => ['required', 'string'],
            'state' => ['required', 'alpha', Rule::exists('states', 'iso2')->where('country_code', $this->country->iso2)],
            'city' => ['required', 'string', 'max:150'],
            'address' => ['required', 'string'],
            'supportPhone' => ['required', 'string'],
            'supportEmail' => ['required', 'email'],
            'file' => ['nullable', 'image', 'max:7000'],  // Max size in KB
            'returnPolicy' => ['nullable', 'string'],
            'refundPolicy' => ['required', 'string'],
            'industry' => ['required','in:fashion,beauty']
        ]);

        // 2. Begin database transaction
        DB::beginTransaction();

        try {
            $slug = ($this->store->name!=$this->name)? $this->generateUniqueSlug('user_stores', $this->name): $this->store->slug;

            // 5. Upload the store logo to Google Drive (or any cloud service)
            //if file is uploaded
            if($this->file){
                $imageResult = googleUpload($this->file);
                if (!$imageResult || empty($imageResult['link'])) {
                    $this->addError('form_error', 'There was an error uploading your store image');
                }
                $logo = $imageResult['link'];  // Retrieve the uploaded image link
            }else{
                $logo = $this->store->logo;
            }

            // 6. Create the store record in the database
            $store = UserStore::where('id',$this->store->id)->update(
                [
                    'name' => $this->name,
                    'description' => $this->description,
                    'slug' => $slug,
                    'service' => $this->serviceType,
                    'state' => $this->state,
                    'city' => $this->city,
                    'logo' => $logo,
                    'currency' => $this->user->mainCurrency,
                    'country' => $this->country->iso2,
                    'address' => $this->address,
                    'email' => $this->supportEmail,
                    'phone' => $this->supportPhone,
                    'status' => 1,
                    'refundPolicy' => clean(str_replace(['[Store_name]','[Email]','[Phone_Number]'],[$this->name,$this->supportEmail,$this->supportPhone],$this->refundPolicy)),
                    'returnPolicy' => clean(str_replace(['[Store_name]','[Email]','[Phone_Number]'],[$this->name,$this->supportEmail,$this->supportPhone],$this->returnPolicy)),
                    'industry' => $this->industry,
                ]);

            if ($store) {

                // 10. Commit the database transaction
                DB::commit();


                // 12. Determine redirect URL based on the "Verify Business" checkbox
                $url = route('mobile.user.store.index');


                // 14. (Optional) Trigger email notification to the user
                $this->userNotification($this->user,'Store Information Updated','Your store information was successfully updated',$request->ip());

                session()->flash('success', 'Store successfully updated.');
                // 13. Trigger Livewire redirect event with a delay
                $this->dispatch('storeCreated', url: $url);
                return;
            }

        } catch (\Exception $exception) {
            // 15. Rollback the transaction if an error occurs
            DB::rollBack();

            // 16. Show error message to the user
            $this->addError('form_error', 'An error occurred: ' . $exception->getMessage());

            // 17. Log the error for debugging
            Log::error('Error updating store: ' . $exception->getMessage());
        }
    }
    //fetch categories in industry
    public function fetchIndustryCategories()
    {
        if (!empty($this->industry)) {
            $this->categories = ServiceType::where('mainCategory', $this->industry)
                ->select('id', 'name') // Fetch only id and name
                ->get()
                ->toArray();

            $this->showCategory = true;
        } else {
            $this->categories = [];
            $this->showCategory = false;
        }
    }
}
