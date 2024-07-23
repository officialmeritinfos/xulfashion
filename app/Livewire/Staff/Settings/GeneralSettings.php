<?php

namespace App\Livewire\Staff\Settings;

use App\Models\GeneralSetting;
use App\Models\SystemStaffAction;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class GeneralSettings extends Component
{
    use LivewireAlert;

    public $settings;
    #[Validate]
    public $name;
    #[Validate]
    public $email;
    #[Validate]
    public $supportEmail;
    #[Validate]
    public $phone;
    #[Validate]
    public $codeExpires;
    #[Validate]
    public $helpDesk;
    #[Validate]
    public $keywords;
    #[Validate]
    public $description;

    public $staff;

    public function mount()
    {
        $setting = GeneralSetting::find(1);
        $this->settings = $setting;
        $this->name = $setting->name;
        $this->email = $setting->email;
        $this->supportEmail = $setting->supportEmail;
        $this->phone = $setting->phone;
        $this->codeExpires = $setting->codeExpire;
        $this->helpDesk = $setting->ticketHelpDesk;
        $this->keywords = $setting->keywords;
        $this->description = $setting->description;

        $this->staff = Auth::guard('staff')->user();
    }

    public function rules()
    {
        return [
            'name'=>['required','string','max:255'],
            'email'=>['required','email','max:255'],
            'supportEmail'=>['required','email','max:255'],
            'phone'=>['required','string','max:100'],
            'codeExpires'=>['required','string','max:100'],
            'helpDesk'=>['required','url','max:255'],
            'keywords'=>['required','string'],
            'description'=>['required','string','max:2550   '],
        ];
    }

    public function render()
    {
        return view('livewire.staff.settings.general-settings');
    }

    public function submit()
    {
        $this->validate();

        if ($this->staff->cannot('update GeneralSetting')) {

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission perform this action.',
                'width' => '400',
            ]);
            return;
        }

        $settings = GeneralSetting::find(1);

        $settings->update([
            'name' => $this->name,'email' => $this->email,'supportEmail' => $this->supportEmail,
            'phone' => $this->phone,'codeExpire' => $this->codeExpires,'ticketHelpDesk' => $this->helpDesk,
            'keywords' => $this->keywords,'description' => $this->description
        ]);

        SystemStaffAction::create([
            'staff' => $this->staff->id,
            'action' => 'Updated Merchant Information',
            'isSuper' => $this->staff->role == 'superadmin' ? 1 : 2,
            'model' => get_class($settings),
            'model_id' => $this->settings->id,
        ]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Website setup successful.',
            'width' => '400',
        ]);
    }
}
