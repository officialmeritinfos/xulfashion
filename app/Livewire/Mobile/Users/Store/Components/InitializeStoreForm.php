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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class InitializeStoreForm extends Component
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

    public function mount()
    {
        $this->user = auth()->user();
        $this->country = Country::where('iso3',$this->user->countryCode)->first();
        $this->returnPolicy = "At [Store_name], customer satisfaction is our priority. If you're not completely happy with your purchase, we offer a straightforward return process. Items must be returned within [number] days from the date of delivery and should be unused, unworn, and in their original packaging (if applicable). A valid proof of purchase, such as a receipt or order confirmation, is required for all returns. However, certain items, including personalized, perishable, and hygiene-related products, are not eligible for returns.

To initiate a return, please contact us via email/phone, and we will review your request. If approved, you will receive return instructions. The customer is responsible for return shipping costs unless the item is defective or incorrect. Once we receive the returned item, we will inspect it and process a refund, exchange, or store credit based on our policy. Refunds will be issued to the original payment method or as store credit, depending on the customer’s preference, and typically take 4 business days to process. Please note that shipping fees are non-refundable unless the item received was defective or incorrect.

For exchanges, customers must request a replacement within 2 days of purchase. Exchanges are subject to product availability. If you receive a damaged, defective, or incorrect item, please reach out to us immediately with photos and a description of the issue, and we will arrange for a replacement or refund at no extra cost. Certain items, including personalized products, digital downloads, perishable goods, and intimate/hygiene-related items, cannot be returned.

For any return-related inquiries, please contact [Store_name] at [Phone_Number], [Email]. We appreciate your business and look forward to serving you again.
        ";
        $this->refundPolicy = "At [Store_name], we are committed to ensuring a smooth and transparent refund process for our customers. If you are not satisfied with your purchase and meet our return eligibility criteria, you may request a refund. Refunds are issued only for items returned within 2 days of purchase in their original condition—unused, unworn, and in original packaging where applicable. A valid proof of purchase, such as a receipt or order confirmation, is required. Refunds are processed once we receive and inspect the returned item, and they are issued to the original payment method or as store credit, depending on customer preference. Please note that shipping fees are non-refundable, except in cases where the item received was defective, damaged, or incorrect.

For orders that qualify for a refund, processing typically takes 5 business days after the return is received and approved. Customers requesting a refund due to an incorrect or defective item must report the issue within 2 days of delivery, providing clear photos and a description of the problem. If verified, we will offer a full refund or replacement at no additional cost. Refunds are not available for certain products, including personalized items, perishable goods, digital products, and intimate or hygiene-related items.

For any refund-related inquiries or to request a refund, please contact [Store_name] at [Phone_Number], [Email]. We appreciate your trust in us and will do our best to resolve any issues promptly.
        ";
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

        return view('livewire.mobile.users.store.components.initialize-store-form',[
            'states' => State::where('country_code', $country->iso2)->orderBy('name')->get(),
        ]);
    }
    //create store
    public function processForm()
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
            'file' => ['required', 'image', 'max:7000'],  // Max size in KB
            'returnPolicy' => ['nullable', 'string'],
            'refundPolicy' => ['required', 'string'],
            'industry' => ['required','in:fashion,beauty']
        ]);

        // 2. Begin database transaction
        DB::beginTransaction();

        try {
            // 3. Generate unique reference and slug for the store
            $reference = $this->generateUniqueReference('user_stores', 'reference', 8);
            $slug = $this->generateUniqueSlug('user_stores', $this->name);

            // 4. Fetch default store theme
            $theme = StoreTheme::where('isDefault', 1)->first();

            // 5. Upload the store logo to Google Drive (or any cloud service)
            $imageResult = googleUpload($this->file);
            if (!$imageResult || empty($imageResult['link'])) {
                $this->addError('form_error', 'There was an error uploading your store image');
            }
            $logo = $imageResult['link'];  // Retrieve the uploaded image link

            // 6. Create the store record in the database
            $store = UserStore::firstOrCreate(
                [
                    'user' => $this->user->id,
                ],
                [
                'reference' => $reference,
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
                'theme' => $theme->id,
                'industry' => $this->industry,
            ]);

            if ($store) {
                // 7. Create default store settings
                UserStoreSetting::firstOrCreate(
                    ['store' => $store->id],
                    ['store' => $store->id]
                );


                // 8. Create a default product category
                UserStoreCatalogCategory::create([
                    'store' => $store->id,
                    'categoryName' => 'default',
                    'isDefault' => 1,
                    'status' => 1
                ]);

                // 9. Apply the selected theme settings to the store
                $this->updateStoreThemeSettting($store, $theme);

                // 10. Commit the database transaction
                DB::commit();


                // 12. Determine redirect URL based on the "Verify Business" checkbox
                $url = $this->verifyBusiness
                    ? route('mobile.user.store.verify')
                    : route('mobile.user.store.index');

                $storeUrl = route('merchant.store',['subdomain'=>$store->slug]);

                // 14. (Optional) Trigger email notification to the user
                Mail::to($this->user->email)->queue(new StoreCreatedNotification(
                    $store->name,
                    $storeUrl,
                    $this->user->name,
                    route('mobile.user.store.verify')
                ));
                session()->flash('success', 'Store successfully created.');
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
            Log::error('Error creating store: ' . $exception->getMessage());
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
