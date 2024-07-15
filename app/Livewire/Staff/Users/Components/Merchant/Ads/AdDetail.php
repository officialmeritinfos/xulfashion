<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Ads;

use App\Custom\GoogleUpload;
use App\Models\SystemStaffAction;
use App\Models\User;
use App\Models\UserAd;
use App\Models\UserAdPhoto;
use App\Notifications\CustomNotificationNoLink;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdDetail extends Component
{
    use WithPagination, LivewireAlert,WithFileUploads;

    public $user;
    public $userId;
    public $adId;
    public $ad;
    public $adImages;
    public $accountPin;
    public $featuredImage;
    public $showApproveForm=false;
    public $showRejectForm=false;
    public $showEditFeaturedImage=false;
    public $rejectReason;

    protected $listeners = [
        'renderAd' => 'render',
        'deleteConfirmed'
    ];
    public function mount($userId,$adId)
    {
        $this->userId = $userId;
        $this->user = User::where('reference', $this->userId)->first();
        $this->adId = $adId;

        $this->ad = UserAd::where([
            'user'=>$this->user->id,'id'=>$this->adId
        ])->first();
        $this->adImages = UserAdPhoto::where('ad',$this->ad->id)->get();

    }
    //toggle show approve form
    public function toggleShowApproveForm()
    {
        $this->showApproveForm = !$this->showApproveForm;
        if ($this->showRejectForm){
            $this->showRejectForm=false;
        }
    }
    //toggle show reject form
    public function toggleShowRejectForm()
    {
        $this->showRejectForm = !$this->showRejectForm;
        if ($this->showApproveForm){
            $this->showApproveForm=false;
        }
    }
    //toggle show featured image edit form
    public function toggleShowEditFeaturedImageForm()
    {
        $this->showEditFeaturedImage = !$this->showEditFeaturedImage;
    }

    public function render()
    {
        return view('livewire.staff.users.components.merchant.ads.ad-detail',[

        ]);
    }
    //delete ad
    public function deleteAdPhoto($ad,$id)
    {
        try {
            $ad = UserAd::where([
                'id' => $ad, 'user' => $this->user->id
            ])->first();

            $photo = UserAdPhoto::where([
                'id'=>$id,'ad'=>$ad
            ])->first();

            if (empty($photo)){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Photo not found',
                    'width' => '400',
                ]);
            }

            //open a dialog to confirm action
            $this->alert('warning', '', [
                'text' => 'Do you want to delete this image',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Yes',
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancel',
                'onConfirmed' => 'deleteConfirmed',
                'data' => [
                    'id' => $id
                ],
                'timer' => null
            ]);
        } catch (\Exception $exception) {
            Log::info('An error occurred while trying to delete an ad');
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while creating an ad for merchant.s',
                'width' => '400',
            ]);
            return;
        }
    }

    //delete confirmed
    public function deleteConfirmed($data)
    {
        $id = $data['id'] ?? null;

        if ($id) {
            $photo = UserAdPhoto::where([
                'id' => $id
            ])->first();

            if ($photo) {
                $photo->delete();
            }
        }

        $this->dispatch('renderAd');
    }
    //submit reject ad
    public function submitReject()
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('update UserAd')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have the clearance ti perform this action',
                'width' => '400',
            ]);
        }

        $this->validate([
            'accountPin' =>'required|string|max:6|min:6',
            'rejectReason'=>['required','string'],
        ]);

        try {
            $hashed = Hash::check($this->accountPin, $staff->accountPin);
            if (!$hashed) {
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Access Denied. Wrong authorization pin',
                    'width' => '400',
                ]);
                return;
            }
            //begin transaction
            DB::beginTransaction();

            $merchant = User::where('reference',$this->user->reference)->first();

            $ad = UserAd::where([
                'id'=>$this->ad->id,'user'=>$merchant->id
            ])->first();

            $dataUpdate = [
                'status'=>4,
                'rejectReason'=>$this->rejectReason,
                'approvedBy'=>$staff->id,
                'dateApproved'=>time()
            ];

            $message = "
                Your Ad <b>".$this->ad->title."</b> with ID <b>".$this->ad->reference."</b> has been disproved
                for the reason below:<hr/>
                <p>$this->rejectReason</p>
            ";
            $ad->update($dataUpdate);

            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Disproved Ad posting',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->ad),
                'model_id' => $this->ad->reference,
            ]);
            DB::commit();
            $merchant->notify(new CustomNotificationNoLink($merchant->name,'Ad post rejected',$message));
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Ad posting rejected.',
                'width' => '400',
            ]);
            $this->dispatch('renderAd');
            $this->showEditFeaturedImage=false;
            $this->showRejectForm=false;
            $this->showApproveForm=false;
            $this->reset(['accountPin','rejectReason']);

            return;

        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while disproving merchant ad.',
                'width' => '400',
            ]);
            Log::error('Error disproving merchant ad: ' . $exception->getMessage());
        }

    }
    //submit approve ad
    public function submitApprove()
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('update UserAd')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have the clearance ti perform this action',
                'width' => '400',
            ]);
        }

        $this->validate([
            'accountPin' =>'required|string|max:6|min:6',
        ]);

        try {
            $hashed = Hash::check($this->accountPin, $staff->accountPin);
            if (!$hashed) {
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Access Denied. Wrong authorization pin',
                    'width' => '400',
                ]);
                return;
            }
            //begin transaction
            DB::beginTransaction();

            $merchant = User::where('reference',$this->user->reference)->first();

            $ad = UserAd::where([
                'id'=>$this->ad->id,'user'=>$merchant->id
            ])->first();

            $dataUpdate = [
                'status'=>1,
                'rejectReason'=>$this->rejectReason,
                'approvedBy'=>$staff->id,
                'dateApproved'=>time()
            ];

            $message = "
                Your Ad <b>".$this->ad->title."</b> with ID <b>".$this->ad->reference."</b> has been approved
                and is running now on the platform.
            ";
            $ad->update($dataUpdate);

            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Approved Ad posting',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->ad),
                'model_id' => $this->ad->reference,
            ]);
            DB::commit();
            $merchant->notify(new CustomNotificationNoLink($merchant->name,'Ad post approved',$message));
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Ad posting approved.',
                'width' => '400',
            ]);
            $this->dispatch('renderAd');
            $this->showEditFeaturedImage=false;
            $this->showRejectForm=false;
            $this->showApproveForm=false;
            $this->reset(['accountPin','rejectReason']);

            return;

        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while approving merchant ad.',
                'width' => '400',
            ]);
            Log::error('Error approving merchant ad: ' . $exception->getMessage());
        }

    }
    //submit update featured image
    public function updateFeaturedImage()
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('update UserAd')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have the clearance ti perform this action',
                'width' => '400',
            ]);
        }

        $this->validate([
            'accountPin' =>'required|string|max:6|min:6',
            'featuredImage'=>['required','image','max:2048'],
        ]);

        try {
            $hashed = Hash::check($this->accountPin, $staff->accountPin);
            if (!$hashed) {
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Access Denied. Wrong authorization pin',
                    'width' => '400',
                ]);
                return;
            }
            $google = new GoogleUpload();
            //begin transaction
            DB::beginTransaction();

            $merchant = User::where('reference',$this->user->reference)->first();

            $ad = UserAd::where([
                'id'=>$this->ad->id,'user'=>$merchant->id
            ])->first();

            $result = $google->uploadGoogle($this->featuredImage);
            $featuredPhoto  = $result['link'];

            $dataUpdate = [
                'featuredImage'=>$featuredPhoto,
            ];

            $ad->update($dataUpdate);

            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Updated Ad featured Image',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->ad),
                'model_id' => $this->ad->reference,
            ]);
            DB::commit();

            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Image uploaded',
                'width' => '400',
            ]);
            $this->dispatch('renderAd');
            $this->showEditFeaturedImage=false;
            $this->showRejectForm=false;
            $this->showApproveForm=false;
            $this->reset(['accountPin']);
            return;

        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while updating merchant ad photo.',
                'width' => '400',
            ]);
            Log::error('Error updating merchant ad featured Image: ' . $exception->getMessage());
        }

    }
}
