<?php

namespace App\Livewire\Mobile\Users\Store\Components;

use App\Models\UserStore;
use App\Models\UserStoreVerification;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class BusinessVerification extends Component
{
    use WithFileUploads,Helpers;

    public $user;
    public $store;
    public $status;
    public $verification;


    public $currentStep = 1;

    public $legalName;
    public $regNumber;
    public $doingBusinessAs;
    public $address;
    public $regCert;
    public $addressProof;

    protected $rules = [
        'legalName' => 'required|string|min:3',
        'regNumber' => 'required|string|min:5',
        'address' => 'required|string|min:10',
        'regCert' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
        'addressProof' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
    ];

    protected $messages = [
        'legalName.required' => 'Legal Business Name is required.',
        'regNumber.required' => 'Registration Number is required.',
        'address.required' => 'Business Address is required.',
        'regCert.required' => 'Registration Certificate must be uploaded.',
        'addressProof.required' => 'Proof of Address must be uploaded.',
    ];

    public function nextStep()
    {
        $this->validateStep($this->currentStep);
        $this->currentStep++;
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateStep($step)
    {
        if ($step == 1) {
            $this->validateOnly('legalName');
        } elseif ($step == 2) {
            $this->validateOnly('regNumber');
        } elseif ($step == 3) {
            $this->validateOnly('address');
        }
    }
    public function mount(UserStore $store)
    {
        $this->user = Auth::user();
        $this->store = $store;
        $this->status = $this->store->isVerified;
        $this->verification = UserstoreVerification::where('store', $this->store->id)->first();
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
        return view('livewire.mobile.users.store.components.business-verification',[
            'store' => $this->store,
        ]);
    }

    /**
     * Handles the submission of the business verification request.
     *
     * This method uploads the required documents, updates or creates the verification record,
     * sends notifications to both the user and the compliance department, and handles errors.
     *
     * @param Request $request
     * @return void
     */
    public function submitVerification(Request $request)
    {
        // Validate the form inputs
        $this->validate();

        DB::beginTransaction();

        try {
            // Upload business certificate
            $certificateResult = googleUpload($this->regCert);
            $certificate = $certificateResult['link'] ?? null;

            // Upload business address proof
            $addressProofResult = googleUpload($this->addressProof);
            $addressProof = $addressProofResult['link'] ?? null;

            if (!$certificate || !$addressProof) {
                session()->flash('error', 'File upload failed. Please try again.');
                return;
            }

            if ($this->verification) {
                // Update existing verification
                $reference = $this->verification->reference;

                $this->verification->update([
                    'store'       => $this->store->id,
                    'reference'   => $reference,
                    'certificate' => $certificate,
                    'addressProof'=> $addressProof,
                    'status'      => 4,
                    'address'     => $this->address,
                    'regNumber'   => $this->regNumber,
                    'dba'         => $this->doingBusinessAs,
                    'legalName'   => $this->legalName
                ]);

                // Notify admin about the update
                $adminMessage = "The existing business verification for {$this->user->name} has been updated.\n".
                    "Updated documents are available for review. KYC Reference ID: {$reference}.";
                $this->sendDepartmentMail('compliance', $adminMessage, 'Updated KYB for Store');

            } else {
                // Generate a unique verification reference
                $reference = $this->generateUniqueReference('user_store_verifications', 'reference', 8);

                // Create new verification record
                $verification = UserStoreVerification::create([
                    'store'       => $this->store->id,
                    'reference'   => $reference,
                    'certificate' => $certificate,
                    'addressProof'=> $addressProof,
                    'status'      => 4,
                    'address'     => $this->address,
                    'regNumber'   => $this->regNumber,
                    'dba'         => $this->doingBusinessAs,
                    'legalName'   => $this->legalName
                ]);

                if ($verification) {
                    // Update store status
                    $this->store->update([
                        'isVerified' => 4,
                        'legalName'  => $this->legalName,
                        'address'    => $this->address
                    ]);

                    // Notify user
                    $message = "The KYC for your store {$this->store->name} has been submitted and is currently under review.";
                    $this->userNotification($this->user, 'KYC for Store Submitted', $message, $request->ip());

                    // Notify admin about the new submission
                    $adminMessage = "A new business verification request has been submitted by {$this->user->name}.\n".
                        "Documents are available for review. KYC Reference ID: {$reference}.";
                    $this->sendDepartmentMail('compliance', $adminMessage, 'New KYB for Store Submitted');
                } else {
                    session()->flash('error', 'Failed to create verification record.');
                    return;
                }
            }

            // Commit database transaction
            DB::commit();

            // Success feedback
            session()->flash('success', 'Business verification request successfully received.');
            $this->resetForm();
            $this->dispatch('verificationSent', url: route('mobile.user.store.verify'));

        } catch (\Exception $exception) {
            // Rollback database transaction on error
            DB::rollBack();

            logger()->error('Error submitting business verification: ' . $exception->getMessage() . ' on mobile.');
            session()->flash('error', 'Internal Server Error. Try again or contact support for help.');
        }
    }
    private function resetForm()
    {
        $this->reset(['legalName', 'regNumber', 'doingBusinessAs', 'address', 'regCert', 'addressProof', 'currentStep']);
        $this->currentStep = 1;
    }

}
