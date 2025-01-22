<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Kyc;

use App\Custom\GoogleUpload;
use App\Models\Country;
use App\Models\SystemStaffAction;
use App\Models\User;
use App\Models\UserVerification;
use App\Models\UserVerificationDocumentType;
use App\Traits\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class KycList extends Component
{
    use WithFileUploads,LivewireAlert,Helpers;

    public $userId;
    public $user;
    public $showForm = false;
    public $documentTypes = [];
    public $countries = [];

    //validate the inputs
    #[Validate('required|string|max:100|exists:user_verification_document_types,slug')]
    public $docType;
    #[Validate('required|string|max:100')]
    public $idNumber;
    #[Validate('required|image|max:2048')]
    public $frontImage;
    #[Validate('required_if:hasBack,true|image|max:2048')]
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

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::where('reference', $this->userId)->first();
        $this->documentTypes = UserVerificationDocumentType::all();
        $this->countries = Country::all();
        $this->country = $this->user->countryCode;
        $this->state = $this->user->state;
        $this->address = $this->user->address;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
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
    public function submitKyc()
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('create User') && $staff->cannot('create UserVerification') && $staff->cannot('update UserVerification')) {

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to onboard a user.',
                'width' => '400',
            ]);
            return;
        }
        $this->validate();
        try {

            $merchant = User::where('reference', $this->userId)->first();
            $google = new GoogleUpload();
            //check for document upload
            $imageResultFront = $google->uploadGoogle($this->frontImage);
            $frontImage = $imageResultFront['link'];
            //check if back image is needed
            if ($this->hasBack==true){
                $imageResultBack = $google->uploadGoogle($this->backImage);
                $backImage = $imageResultBack['link'];
            }else{
                $backImage = '';
            }
            //upload proof of address
            $imageResultAddress = $google->uploadGoogle($this->addressProof);
            $addressImage = $imageResultAddress['link'];

            $reference = $this->generateUniqueReference('user_verifications','reference',10);

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
                $adminMessage = "A new KYC for merchant account has been received from ".$merchant->name.". The required
                documents have been uploaded and is awaiting your review. KYC Reference ID is ".$reference;
                $this->sendDepartmentMail('compliance', $adminMessage,'New KYC for Account Submitted.');

                SystemStaffAction::create([
                    'staff' => $staff->id,
                    'action' => 'Submitted Merchant KYC',
                    'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($this->user),
                    'model_id' => $this->user->id,
                ]);

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Profile completed successfully.',
                    'width' => '400',
                ]);
                $this->dispatch('kycSubmitted');
                return;
            }
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Something went wrong',
                'width' => '400',
            ]);
            return;
        }catch (\Exception $e) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while submitting KYC.',
                'width' => '400',
            ]);
            Log::error('Error creating merchant KYC: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.staff.users.components.merchant.kyc.kyc-list', [
            'kyc' => UserVerification::where('user', $this->user->id)->first()
        ]);
    }

}
