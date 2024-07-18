<?php

namespace App\Livewire\Company;

use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Traits\Helpers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class Home extends Component
{
    use LivewireAlert, Helpers;
    #[Validate]
    public $name;
    #[Validate]
    public $email;
    public $captcha = null;
    public $showForm = true;
    public $showSuccessForm = false;

    public function rules()
    {
        return [
            'name'=>['required','string','max:225'],
            'email'=>['required','email',Rule::unique('users','email')],
            'captcha' => ['nullable'],
        ];
    }
    //submit
    public function submit(Request $request)
    {
        $this->validate();

        try {
            //we will register the user into the system
            $ip = $request->ip();
            //check the environment
            $position = (config('app.env')=='local')?Location::get():Location::get($ip);

            $country = Country::where('iso2',$position->countryCode)->first();

            $list = User::create([
                'name'=>$this->name,'email'=>$this->email,
                'registrationIp'=>$ip,
                'country'=>$position->countryName,
                'countryCode'=>$country->iso3,
                'mainCurrency'=>$country->currency
            ]);
            if (!empty($list)){
                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'You have successfully joined the wait-list.',
                    'width' => '400',
                ]);
                $this->reset(['name','captcha','email']);
                $this->showForm=false;
                $this->showSuccessForm=true;

                return;
            }
        }catch (\Exception $exception){
            Log::info('An error occurred while joining wait-list: '.$exception->getMessage());
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred. No worries, we are working on it.',
                'width' => '400',
            ]);
        }
    }

    public function updatedCaptcha($token)
    {
        $response = Http::post(
            'https://www.google.com/recaptcha/api/siteverify?secret='.
            config('app.recaptcha_secret').
            '&response='.$token
        );

        $success = $response->json()['success'];

        if (! $success) {
            throw ValidationException::withMessages([
                'captcha' => __('Google thinks, you are a bot, please refresh and try again!'),
            ]);
        } else {
            $this->captcha = true;
        }
    }

    public function render()
    {
        $web = GeneralSetting::find(1);
        return view('livewire.company.home',[
            'siteName' =>$web->name
        ]);
    }
}
