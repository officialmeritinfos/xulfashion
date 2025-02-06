<?php

namespace App\Livewire\Staff\Users\Components\Merchant;

use App\Custom\GoogleUpload;
use App\Models\Country;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\SystemStaffAction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompleteProfile extends Component
{
    use WithFileUploads, LivewireAlert;

    public $userId;
    public $user;


    public $bio;
    public $displayName ;
    #[Validate('required|string|in:male,female,others')]
    public $gender ;
    #[Validate('required|date')]
    public $dob ;
    #[Validate('required|string|max:255')]
    public $address;
    #[Validate('required|image|max:4048')] // 1MB Max
    public $photo;
    #[Validate('nullable')]
    public $submitKyc;
    #[Validate('required','numeric')]
    public $merchantType;
    public $country;
    public $username;
    public $tutorKeywords;


    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::where('reference', $this->userId)->first();

        $this->bio = $this->user->bio;
        $this->displayName = $this->user->displayName;
        $this->dob = $this->user->dob;
        $this->address = $this->user->address;
        $this->gender = $this->user->gender;
        $this->username = $this->user->username;
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
        $this->validate([
            'bio' => 'required',
            'displayName' => ['required','string','max:255',Rule::unique('users','displayName')->ignore($this->user->id)],
            'gender' => 'required',
            'country' => ['required',Rule::exists('countries','iso3')->where('status',1)],
            'dob' => 'required',
            'address' => 'required',
            'photo' => 'image|max:4048',
            'username'=>['required', 'alpha_num', Rule::unique('users','username')->ignore($this->user->id)],
            'tutorKeywords'         =>['nullable'],
            'tutorKeywords.*'       =>['nullable','string'],
        ]);

        try {

            $merchant = User::where('reference',$this->userId)->first();
            $google = new GoogleUpload();
            $imageResult = $google->uploadGoogle($this->photo);
            $imageLink = $imageResult['link'];

            // Get Country from request
            $country = Country::where('iso3',$this->country)->where('status',1)->first();
            if (!$country) {
                return $this->sendError('validation.error', ['error' => 'Country selection is required. Please reload this page.']);
            }

            //check if the user's country currency is supported
            $fiat = Fiat::where('code',$country->currency)->first();
            if (empty($fiat)){
                $currency = 'USD';
            }else{
                $currency = $fiat->code;
            }


            $merchant->update([
                'bio' => $this->bio,
                'gender' => $this->gender,
                'completedProfile' => 1,
                'dob' => $this->dob,
                'displayName' => $this->displayName,
                'address' => $this->address,
                'accountType' => 1,
                'photo' => $imageLink,
                'activelyLookingForJob'=>1,
                'merchantType' => $this->merchantType,
                'tutorKeywords'=>$this->tutorKeywords,
                'username' => $this->username,
                'country' => $country->name,
                'countryCode' => $country->iso3,
                'mainCurrency' => $currency,
            ]);

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
        return view('livewire.staff.users.components.merchant.complete-profile',[
            'countries' => Country::where('status',1)->get(),
            'merchant' => $this->user,
        ]);
    }
}
