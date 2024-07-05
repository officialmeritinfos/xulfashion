<?php

namespace App\Livewire\Staff\Users\Components\Merchant;

use App\Custom\GoogleUpload;
use App\Models\GeneralSetting;
use App\Models\SystemStaffAction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompleteProfile extends Component
{
    use WithFileUploads, LivewireAlert;

    public $userId;
    public $user;

    #[Validate('required|string')]
    public $bio = '';
    #[Validate('required|string|max:255|unique:users,displayName')]
    public $displayName = '';
    #[Validate('required|string|in:male,female,others')]
    public $gender = '';
    #[Validate('required|date')]
    public $dob = '';
    #[Validate('required|string|max:255')]
    public $address = '';
    #[Validate('required|image|max:1048')] // 1MB Max
    public $photo;
    #[Validate('nullable')]
    public $submitKyc;


    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::where('reference', $this->userId)->first();

        $this->bio = $this->user->bio;
        $this->displayName = $this->user->displayName;
        $this->dob = $this->user->dob;
        $this->address = $this->user->address;
        $this->gender = $this->user->gender;
    }

    public function submit()
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

            $merchant = User::where('reference',$this->userId)->first();
            $google = new GoogleUpload();
            $imageResult = $google->uploadGoogle($this->photo);
            $imageLink = $imageResult['link'];

            $userData = [
                'bio' => $this->bio,
                'gender' => $this->gender,
                'completedProfile' => 1,
                'dob' => $this->dob,
                'displayName' => $this->displayName,
                'address' => $this->address,
                'accountType' => 1,
                'photo' => $imageLink,
            ];

            $merchant->update($userData);

            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Complete Merchant Profile',
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

            if (!empty($this->submitKyc)) {
                $url = route('staff.users.kyc',['id'=>$this->user->reference]);
            } else {
                $url = route('staff.users.detail',['id'=>$this->user->reference]);
            }
            $this->dispatch('merchantProfileCompleted',$url);
            return;
        } catch (\Exception $e) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while completing the merchant profile.',
                'width' => '400',
            ]);
            Log::error('Error completing merchant profile: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.staff.users.components.merchant.complete-profile');
    }
}
