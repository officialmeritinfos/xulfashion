<?php

namespace App\Livewire\Staff\Users;

use App\Models\Country;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\SystemStaffAction;
use App\Models\User;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddUser extends Component
{
    use LivewireAlert, Helpers;


    #[Validate('required|string|max:255')]
    public $name='';
    #[Validate('required|string|max:255|unique:users,username')]
    public $username='';
    #[Validate('required|email|unique:users,email')]
    public $email='';
    #[Validate('required|string|max:3')]
    public $country='';
    #[Validate('nullable|string|max:15')]
    public $phone='';
    #[Validate('required|string|max:3')]
    public $fiat='';
    #[Validate('required|string|confirmed|min:8')]
    public $password='';
    public $password_confirmation='';
    public $showCompleteProfile = false;

    public $merchant = '';

    public function submit(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff->can('create User')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to onboard a user.',
                'width' => '400',
            ]);
            return;
        }

        $validated = $this->validate();
        try {
            $web = GeneralSetting::find(1);


            $reference = $this->generateUniqueId('users','reference');
            //check if the selected country is valid
            $countryExists = Country::where(['iso3'=>$this->country,'status'=>1])->first();


            $dataUser = [
                'name'=>$this->name,
                'email'=>$this->email,
                'username'=>$this->username,
                'reference'=>$reference,
                'password'=>Hash::make($this->password),
                'country'=>$countryExists->name,
                'countryCode'=>$countryExists->iso3,
                'phone'=>$this->phone,
                'mainCurrency'=>$this->fiat,
                'registrationIp'=>$request->ip(),'status'=>1,
                'accountManager'=>$staff->id
            ];
            $user = User::create($dataUser);
            if (!empty($user)){
                $this->initializeUserSettings($user);//initialize settings
                SystemStaffAction::create([
                    'staff'         =>$staff->id,
                    'action'        =>'Merchant Onboarding',
                    'isSuper'       =>$staff->role=='superadmin'?1:2,
                    'model'         =>get_class($user),
                    'model_id'      =>$user->id
                ]);
                //send a welcome mail to the merchant
                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'User created successfully.',
                    'width' => '400'
                ]);

                $this->reset();
                $this->merchant = $user->reference;

                $this->dispatch('merchantCreated',$this->merchant);
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
        } catch (\Exception $e) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while onboarding the merchant.',
                'width' => '400',
            ]);
            Log::error('Error onboarding merchant: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.staff.users.add-user',[
            'countries'     =>Country::where('status',1)->get(),
            'fiats'         =>Fiat::where('status',1)->get(),
        ]);
    }

}
