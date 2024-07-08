<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Kyc;

use App\Custom\GoogleUpload;
use App\Models\Country;
use App\Models\SystemStaffAction;
use App\Models\User;
use App\Models\UserVerification;
use App\Models\UserVerificationDocumentType;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class KycDetail extends Component
{
    use WithFileUploads,LivewireAlert,Helpers;

    public $staff;
    public $userId;
    public $user;
    public $showForm = false;
    public $showApproveForm = false;
    public $showRejectForm = false;
    public $showDeleteForm = false;
    public $documentType;
    public $document;
    public $documentTypes = [];
    public $countries = [];
    public $accountPin;

    //validate the inputs
    #[Validate('nullable|string|max:100|exists:user_verification_document_types,slug')]
    public $docType;
    #[Validate('nullable|string|max:100')]
    public $idNumber;
    #[Validate('nullable|image|max:2048')]
    public $frontImage;
    #[Validate('nullable|required_if:hasBack,true|image|max:2048')]
    public $backImage;
    #[Validate('required|exists:countries,iso3')]
    public $country;
    #[Validate('required|string|max:150')]
    public $state;
    #[Validate('required|string|max:200')]
    public $address;
    #[Validate('nullable|image|max:2048')]
    public $addressProof;

    public $hasBack = false;
    public $docName;

    protected $listeners = [
        'kycUpdated' => 'render',
    ];

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::where('reference', $this->userId)->first();
        $this->document = UserVerification::where('user',$this->user->id)->first();
        $this->documentType = UserVerificationDocumentType::where('slug',$this->document->docType)->first();
        $this->staff = Auth::guard('staff')->user();
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
    //update kyc
    public function updateKyc(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('create UserVerification') && $staff->cannot('update UserVerification')) {

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

            if ($this->frontImage){
                //check for document upload
                $imageResultFront = $google->uploadGoogle($this->frontImage);
                $frontImage = $imageResultFront['link'];
            }else{
                $frontImage = $this->document->frontImage;
            }
            if ($this->backImage){
                $imageResultBack = $google->uploadGoogle($this->backImage);
                $backImage = $imageResultBack['link'];
            }else{
                $backImage = $this->document->backImage;
            }
            if ($this->addressProof){
                //upload proof of address
                $imageResultAddress = $google->uploadGoogle($this->addressProof);
                $addressImage = $imageResultAddress['link'];
            }else{
                $addressImage = $this->document->utilityBill;
            }

            $docType =  ($this->docType)?:$this->document->docType;
            $idNumber =  ($this->idNumber)?:$this->document->idNumber;

            $verification = UserVerification::where('id',$this->document->id)->update([
                'docType'=>$docType,
                'frontImage'=>$frontImage,
                'backImage'=>$backImage,
                'idNumber'=>$idNumber,
                'utilityBill'=>$addressImage,
                'status'=>4
            ]);
            if ($verification) {
                $merchant->isVerified = 4;
                $merchant->state = $this->state;
                $merchant->save();

                //send message to compliance department
                $adminMessage = "The KYC for merchant account for ".$merchant->name." has been updated. The required
                documents have been uploaded and is awaiting your review. KYC Reference ID is ".$this->document->reference;
                $this->sendDepartmentMail('compliance', $adminMessage,'Account KYC updated.');

                SystemStaffAction::create([
                    'staff' => $staff->id,
                    'action' => 'Updated Merchant KYC',
                    'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($this->user),
                    'model_id' => $this->user->id,
                ]);

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'KYC updated successfully.',
                    'width' => '400',
                ]);
                $this->dispatch('kycUpdated');
                $this->showForm=false;
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
                'text' => 'An error occurred while updating KYC.',
                'width' => '400',
            ]);
            Log::error('Error updating merchant KYC: ' . $e->getMessage());
        }
    }
    //approve kyc
    public function approveKyc(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('update UserVerification')) {

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to onboard a user.',
                'width' => '400',
            ]);
            return;
        }

        $this->validate([
            'accountPin' =>'required|string|max:6|min:6'
        ]);

        try {

            $merchant = User::where('reference', $this->userId)->first();

            $verification = UserVerification::where('id',$this->document->id)->update([
                'status'=>1,'approvedBy'=>$staff->id
            ]);
            if ($verification) {
                $merchant->isVerified = 1;
                $merchant->activateProfile = 1;
                $merchant->save();

                //send message to compliance department
                $adminMessage = "The KYC for merchant account for ".$merchant->name." has been approved. ";
                $this->sendDepartmentMail('compliance', $adminMessage,'Account KYC Approved.');

                SystemStaffAction::create([
                    'staff' => $staff->id,
                    'action' => 'Approved Merchant KYC',
                    'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($this->user).' / '.get_class($this->document),
                    'model_id' => $this->user->id,
                ]);

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'KYC successfully approved',
                    'width' => '400',
                ]);
                $this->dispatch('kycUpdated');
                $this->showForm=false;
                $this->showApproveForm=false;
                $this->showRejectForm=false;
                $this->showDeleteForm=false;
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
                'text' => 'An error occurred while updating KYC.',
                'width' => '400',
            ]);
            Log::error('Error updating merchant KYC: ' . $e->getMessage());
        }
    }
    //reject kyc
    public function rejectKyc(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('update UserVerification')) {

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to onboard a user.',
                'width' => '400',
            ]);
            return;
        }

        $this->validate([
            'accountPin' =>'required|string|max:6|min:6'
        ]);

        try {

            $merchant = User::where('reference', $this->userId)->first();

            $verification = UserVerification::where('id',$this->document->id)->update([
                'status'=>2,'approvedBy'=>$staff->id,
            ]);
            if ($verification) {
                $merchant->isVerified = 1;
                $merchant->activateProfile = 1;
                $merchant->save();

                //send message to compliance department
                $adminMessage = "The KYC for merchant account for ".$merchant->name." has been approved. ";
                $this->sendDepartmentMail('compliance', $adminMessage,'Account KYC Approved.');

                SystemStaffAction::create([
                    'staff' => $staff->id,
                    'action' => 'Approved Merchant KYC',
                    'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($this->user).' / '.get_class($this->document),
                    'model_id' => $this->user->id,
                ]);

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'KYC successfully approved',
                    'width' => '400',
                ]);
                $this->dispatch('kycUpdated');
                $this->showForm=false;
                $this->showApproveForm=false;
                $this->showRejectForm=false;
                $this->showDeleteForm=false;
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
                'text' => 'An error occurred while updating KYC.',
                'width' => '400',
            ]);
            Log::error('Error updating merchant KYC: ' . $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.staff.users.components.merchant.kyc.kyc-detail');
    }
}
