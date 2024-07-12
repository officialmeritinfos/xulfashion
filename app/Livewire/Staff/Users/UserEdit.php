<?php

namespace App\Livewire\Staff\Users;

use App\Models\Country;
use App\Models\Fiat;
use App\Models\SystemStaffAction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserEdit extends Component
{
    use LivewireAlert;

    public $userId;
    public $user;
    #[Validate]
    public $name;
    #[Validate]
    public $email;
    #[Validate]
    public $username;
    #[Validate]
    public $displayName;
    #[Validate]
    public $mainCurrency;
    #[Validate]
    public $country;
    #[Validate]
    public $state;
    #[Validate]
    public $phone;
    #[Validate]
    public $gender;
    #[Validate]
    public $dob;
    #[Validate]
    public $address;
    #[Validate]
    public $bio;
    public $fiats;
    public $countryCode;
    public $countries;

    protected $listeners = [
        'profileUpdated' => 'render',
    ];
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::where('reference',$this->userId)->first();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->username = $this->user->username;
        $this->displayName = $this->user->displayName;
        $this->mainCurrency = $this->user->mainCurrency;
        $this->country = $this->user->country;
        $this->countryCode = $this->user->countryCode;
        $this->state = $this->user->state;
        $this->phone = $this->user->phone;
        $this->gender = $this->user->gender;
        $this->dob = $this->user->dob;
        $this->address = $this->user->address;
        $this->countries = Country::where('status',1)->get();
        $this->fiats = Fiat::where('status',1)->get();
        $this->bio = $this->user->bio;
    }

    public function rules()
    {
        return [
            'name'          =>['required','string','max:200'],
            'email'         =>['required','email','max:200',Rule::unique('users','email')->ignore($this->user->id)],
            'username'      =>['required','alpha_num','max:150',Rule::unique('users','username')->ignore($this->user->id)],
            'displayName'   =>['nullable','string','max:150'],
            'gender'         =>['required','string','in:male,female,others'],
            'dob'            =>['required','date'],
            'address'        =>['required','string'],
            'country'        => ['required', 'string', 'exists:countries,iso3'],
            'state'          => ['required', 'string'],
            'mainCurrency'   => ['required', 'string', 'exists:fiats,code'],
            'phone'          =>['required','numeric'],
            'bio'            =>['nullable','string'],
        ];
    }

    //submit edited information
    public function submit()
    {
        $staff = Auth::guard('staff')->user();

        if ($staff->cannot('update User')) {

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission perform this action.',
                'width' => '400',
            ]);
            return;
        }
        $this->validate();
        try {
            $merchant = User::where('reference', $this->userId)->first();
            $countryExists = Country::where(['iso3'=>$this->country,'status'=>1])->first();
            $userData = [
                'name'=>$this->name,
                'email'=>$this->email,
                'username'=>$this->username,
                'country'=>$countryExists->name,
                'countryCode'=>$countryExists->iso3,
                'phone'=>$this->phone,
                'mainCurrency'=>$this->mainCurrency,
                'bio' => $this->bio,
                'gender' => $this->gender,
                'dob' => $this->dob,
                'displayName' => $this->displayName,
                'address' => $this->address,
                'state' => $this->state,
                'email_verified_at'=>($this->email!=$merchant->email)?null:$merchant->email_verified_at
            ];
            //update
            $merchant->update($userData);

            SystemStaffAction::create([
                'staff' => $staff->id,
                'action' => 'Updated Merchant Information',
                'isSuper' => $staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($this->user),
                'model_id' => $this->user->id,
            ]);

            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Profile updated successfully.',
                'width' => '400',
            ]);
            $this->dispatch('profileUpdated');
            return;

        }catch (\Exception $e) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while updating the merchant profile.',
                'width' => '400',
            ]);
            Log::error('Error updating merchant information: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.staff.users.user-edit');
    }
}
