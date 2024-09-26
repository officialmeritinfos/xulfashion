<?php

namespace App\Livewire\Company\Mobile;

use App\Mail\VerifyAccountDeletion;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DeleteMyInformation extends Component
{

    use LivewireAlert, Helpers;
    #[Validate]
    public $reason;
    #[Validate]
    public $email;
    public $captcha = null;
    public $showForm = true;
    public $showSuccessForm = false;

    public function rules()
    {
        return [
            'reason'=>['required','string','max:225'],
            'email'=>['required','email',Rule::exists('users','email')],
            'captcha' => ['required'],
        ];
    }
    //submit
    public function submit(Request $request)
    {
        $this->validate();

        try {

            $user = User::where('email',$this->email)->first();

            if (empty($user)){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Account not found or already scheduled for removal.',
                    'width' => '400',
                ]);
                return;
            }
            if ($user->requestedForAccountDeletion==1){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Account already scheduled for removal.',
                    'width' => '400',
                ]);
                return;
            }
            $user->reasonForDeleting=$this->reason;
            $user->save();
            //send the verification email
            Mail::to($user->email)->send(new VerifyAccountDeletion($user));
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Please verify your request from your mail',
                'width' => '400',
            ]);
            $this->showSuccessForm=true;
            $this->showForm=false;
            return;

        }catch (\Exception $exception){
            Log::info('An error occurred while requesting for account deletion: '.$exception->getMessage());
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
                'captcha' => __('We think, you are a bot, please refresh and try again!'),
            ]);
        } else {
            $this->captcha = true;
        }
    }
    public function render()
    {
        $web = GeneralSetting::find(1);
        return view('livewire.company.mobile.delete-my-information',[
            'siteName' =>$web->name,
            'web'=>$web
        ]);
    }
}
