<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store\Kyb;

use App\Custom\GoogleUpload;
use App\Models\GeneralSetting;
use App\Models\SystemStaffAction;
use App\Models\User;
use App\Models\UserStore;
use App\Models\UserStoreVerification;
use App\Notifications\CustomNotificationNoLink;
use App\Traits\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class KybList extends Component
{
    use LivewireAlert, WithFileUploads,Helpers;

    public $staff;
    public $storeId;
    public $store;
    public $verification;
    public $user;
    public $siteName;

    public $accountPin;
    public $rejectReason;

    public $showForm = false;
    public $showApproveForm = false;
    public $showRejectForm = false;

    protected $listeners = [
        'kycSubmitted' => 'render',
    ];

    public function mount($storeId)
    {
        $this->storeId = $storeId;
        $this->store = UserStore::where('reference', $this->storeId)->first();
        $this->verification = UserStoreVerification::where('store',$this->store->id)->first();
        $this->user = User::where('id',$this->store->user)->first();
        $this->staff = Auth::guard('staff')->user();
        $this->siteName = GeneralSetting::find(1)->name;
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
                $this->showForm= false;
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
        return view('livewire.staff.users.components.merchant.store.kyb.kyb-list');
    }

    //notify compliance
    public function notifyCompliance()
    {
        $message = "There is a KYB submission pending review by the compliance unit.
        Please review this and approve or reject where necessary. The KYB ID is ".$this->verification->reference.' and it
        is from the store '.$this->store->name;

        $this->sendDepartmentMail('compliance',$message,'KYB Pending Review on '.$this->siteName);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Reminder successfully sent',
            'width' => '400',
        ]);
    }
    //toggle show edit form
    public function toggleShowForm()
    {
        $this->showForm = !$this->showForm;
        $this->showApproveForm = false;
        $this->showRejectForm = false;
    }
    //toggle show approve form
    public function toggleApproveForm()
    {
        $this->showApproveForm = !$this->showApproveForm;
        $this->showForm = false;
        $this->showRejectForm = false;
    }
    //toggle show reject form
    public function toggleRejectForm()
    {
        $this->showRejectForm = !$this->showRejectForm;
        $this->showForm = false;
        $this->showApproveForm = false;
    }
    //submit approval
    public function submitApproval()
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

            $hashed = Hash::check($this->accountPin,$staff->accountPin);
            if (!$hashed){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Access Denied. Wrong authorization pin',
                    'width' => '400',
                ]);
                return;
            }

            if ($this->verification->status==1){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Account already activated.',
                    'width' => '400',
                ]);
                return;
            }

            if ($this->verification->status!=4){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Kyc submission not received yet. Please upload the KYC documents first.',
                    'width' => '400',
                ]);
                return;
            }

            $merchant = User::where('reference', $this->user->reference)->first();

            $verification = UserStoreVerification::where('id',$this->verification->id)->update([
                'status'=>1,'approvedBy'=>$staff->id
            ]);
            if ($verification) {
                $this->store->isVerified = 1;
                $this->store->save();

                //send message to compliance department
                $adminMessage = "The KYB for merchant store for ".$this->store->name." has been approved. ";
                $this->sendDepartmentMail('compliance', $adminMessage,'Business KYB Approved.');
                //send merchant mail
                $merchantMessage = "
                    Your store has been successfully verified and the full features activated. You can now accept online
                    payment and get payout into your main balance without delay. Also, you are qualified for our paid
                    features when available.
                ";
                $merchant->notify(new CustomNotificationNoLink($merchant->name,'Store activation',$merchantMessage));

                SystemStaffAction::create([
                    'staff' => $staff->id,
                    'action' => 'Approved Business KYB',
                    'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($this->user).' / '.get_class($this->verification),
                    'model_id' => $this->verification->id,
                ]);

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'KYB successfully approved',
                    'width' => '400',
                ]);
                $this->dispatch('kycSubmitted');
                $this->showForm=false;
                $this->showApproveForm=false;
                $this->showRejectForm=false;
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
                'text' => 'An error occurred while updating KYB.',
                'width' => '400',
            ]);
            Log::error('Error updating merchant KYC: ' . $e->getMessage());
        }
    }
    //submit reject
    public function submitReject()
    {
        $web = GeneralSetting::find(1);
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
            'accountPin' =>'required|string|max:6|min:6',
            'rejectReason'    =>'required|string'
        ]);
        try {

            $hashed = Hash::check($this->accountPin,$staff->accountPin);
            if (!$hashed){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Access Denied. Wrong authorization pin',
                    'width' => '400',
                ]);
                return;
            }

            $merchant = User::where('reference', $this->user->reference)->first();

            $verification = UserStoreVerification::where('id',$this->verification->id)->update([
                'status'=>2,'approvedBy'=>$staff->id, 'rejectReason'=>$this->rejectReason
            ]);
            if ($verification) {
                $this->store->isVerified = 2;
                $this->store->save();

                //send message to compliance department
                $adminMessage = "The KYB for merchant store for ".$this->store->name." has been rejected. ";
                $this->sendDepartmentMail('compliance', $adminMessage,'Business KYC Rejection.');
                //send mail to the merchant
                $merchantMessage = "
                    We ran into some challenges while trying to verify your business document on <b>".$web->name."</b>. You can
                    find the details below:<hr/><br/>
                    <p>$this->rejectReason</p>
                ";
                $merchant->notify(new CustomNotificationNoLink($this->store->name,'Business Verification Failed',$merchantMessage));

                SystemStaffAction::create([
                    'staff' => $staff->id,
                    'action' => 'Rejected Store KYB',
                    'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($this->user).' / '.get_class($this->verification),
                    'model_id' => $this->store->id,
                ]);

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'KYB successfully rejected',
                    'width' => '400',
                ]);
                $this->dispatch('kycSubmitted');
                $this->showForm=false;
                $this->showApproveForm=false;
                $this->showRejectForm=false;
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
}
