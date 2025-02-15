<?php

namespace App\Livewire\Mobile\Users\Kyc;

use App\Custom\GoogleUpload;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Models\UserVerification;
use App\Models\UserVerificationDocumentType;
use App\Traits\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class PersonalVerification extends Component
{
    use WithFileUploads,LivewireAlert,Helpers;

    public $verification;
    public $user;
    public $documentTypes=[];
    public $countries = [];
    public $states = [];

    #[Validate('required|string|max:100|exists:user_verification_document_types,slug')]
    public $docType;
    #[Validate('required|string|max:100')]
    public $idNumber;
    #[Validate('required|image|max:6000')]
    public $frontImage;
    #[Validate('nullable|required_if:hasBack,true|image|max:6000')]
    public $backImage;
    #[Validate('required|exists:countries,iso3')]
    public $country;
    #[Validate('required|string|max:150')]
    public $state;
    #[Validate('required|string|max:200')]
    public $address;
    #[Validate('required|image|max:2048')]
    public $addressProof;


    public $hasBack = false;
    public $docName;

    protected $listeners = [
        'kycSubmitted' => 'render',
    ];

    public function mount($user=null)
    {
        $this->user = $user??auth()->user();
        $this->verification = UserVerification::where('user', $this->user->id)->first();
        $countryCode = strtolower($this->user->countryCode);
        $this->documentTypes = UserVerificationDocumentType::where('status', 1)
            ->where(function ($query) use ($countryCode) {
                $query->where('country', $countryCode)
                    ->orWhere('country', 'all');
            })->get();
        $this->countries = Country::where('status', 1)->orderBy('name')->get();
        $this->country = $this->user->countryCode;
        $this->state = $this->user->state;
        $this->address = $this->user->address;
        $country = Country::where('iso3', $this->user->countryCode)->first();

        $this->states = State::where('country_code', $country->iso2)->orderBy('name')->get();

    }
    public function updatedDocType($value)
    {
        $doc = UserVerificationDocumentType::where('slug', $value)->first();
        if ($doc) {
            $this->hasBack = $doc->hasBack==1;
            $this->docName = $doc->name;
        } else {
            $this->hasBack = false;
        }
    }

    public function updatedCountry($value)
    {
        $country = Country::where('iso3', $value)->first();
        $this->states = State::where('country_code',$country->iso2)->orderBy('name')->get();
    }

    public function submitKyc()
    {

        $this->validate();

        DB::beginTransaction();

        try {
            $merchant = User::where('reference', $this->user->reference)->first();

            // Upload ID front image
            $imageResultFront = googleUpload($this->frontImage);
            $frontImage = $imageResultFront['link'] ?? null;
            // Upload ID back image
            $backImage=null;
            if ($this->hasBack){
                $imageResultBack = googleUpload($this->backImage);
                $backImage = $imageResultBack['link'] ?? null;
            }
            // Upload proof of address
            $addressProofResult = googleUpload($this->addressProof);
            $addressImage = $addressProofResult['link'] ?? null;
            //Check that the files actually uploaded
            if (!$frontImage || !$addressImage|| ($this->hasBack && !$backImage)) {

                session()->flash('error', 'File upload failed. Please try again.');
                return;
            }

            if ($this->verification){
                // Update existing verification
                $reference = $this->verification->reference;
                $this->verification->update([
                    'docType'=>$this->docType,
                    'frontImage'=>$frontImage,
                    'backImage'=>$backImage,
                    'idNumber'=>$this->idNumber,
                    'utilityBill'=>$addressImage,
                    'status'=>4
                ]);

                $adminMessage = "Dear Compliance Team,

The merchant, {$merchant->name}, has updated their KYC details for verification. The updated information includes the following:

- **Document Type**: {$this->docType}
- **Front Image**: Uploaded
- **Back Image**: " . ($backImage ? "Uploaded" : "Not Provided") . "
- **ID Number**: {$this->idNumber}
- **Utility Bill**: " . ($addressImage ? "Uploaded" : "Not Provided") . "
- **KYC Reference ID**: {$reference}

The status of this KYC has been updated to **Pending Review** (Status Code: 4). Please review the updated information promptly to ensure compliance and keep the verification process on track.

You may log in to the admin dashboard to access the complete details and proceed with the verification.

Best regards,
System Notification";

                $this->sendDepartmentMail('compliance', $adminMessage, 'Updated KYC Submission by Merchant');

                $merchant->isVerified=4;
                $merchant->state=$this->state;
                $merchant->save();

            }else{
                // Create new record
                $reference = $this->generateUniqueReference('user_verifications','reference',7);

                //create the verification
                $verification = UserVerification::create([
                    'user'=>$merchant->id,
                    'reference'=>$reference,
                    'docType'=>$this->docType,
                    'frontImage'=>$frontImage,
                    'backImage'=>$backImage,
                    'idNumber'=>$this->idNumber,
                    'utilityBill'=>$addressImage,
                    'status'=>4
                ]);
                if (!empty($verification)) {
                    $merchant->isVerified = 4;
                    $merchant->state = $this->state;
                    $merchant->save();

                    //send message to compliance department
                    $adminMessage = "Dear Compliance Team,
We have received a new KYC submission for a merchant account from {$merchant->name}. All the required documents have been successfully uploaded and are now awaiting your review.

Below are the details for your reference:
- **Merchant Name**: {$merchant->name}
- **KYC Reference ID**: {$reference}

Please log in to the staff dashboard to review and process this KYC submission at your earliest convenience. Ensuring timely verification will help maintain compliance and facilitate a seamless onboarding process for the merchant.

Best regards,
System Notification";
                    $this->sendDepartmentMail('compliance', $adminMessage, 'New KYC Submission for Merchant Account');


                }else{
                    session()->flash('error', 'Failed to create verification record.');
                }

            }
            // Commit database transaction
            DB::commit();
            session()->flash('success', 'KYC Verification successfully submitted.');
            $this->dispatch('kycSubmitted');
            return;

        }catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'An error occurred while submitting KYC.');
            Log::error('Error creating merchant KYC: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.mobile.users.kyc.personal-verification');
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
}
