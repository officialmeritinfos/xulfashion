<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store;

use App\Models\UserStore;
use App\Models\UserStoreSetting;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Settings extends Component
{
    use LivewireAlert;

    public $staff;
    public $storeId;
    public $store;
    public $settings;

    public $notifications = false;
    public $newsletter = false;
    public $signups = false;
    public $collectPhone = false;
    public $collectPayment = false;
    public $whatsappPayment = false;
    public $whatsappSupport = false;
    public $whatsappNumber;
    public $whatsappSupportNumber;
    public $escrowPayment = false;
    public $defaultBuyText;

    public function mount($storeId)
    {
        $this->storeId = $storeId;
        $this->store = UserStore::where('reference',$storeId)->first();
        $this->staff = Auth::guard('staff')->user();
        $this->settings = UserStoreSetting::where('store',$this->store->id)->first();

        $this->notifications = $this->settings->allowNotifications==1;
        $this->newsletter = $this->settings->allowNewLetters==1;
        $this->signups = $this->settings->allowSignups==1;
        $this->collectPhone = $this->settings->collectPhone==1;
        $this->collectPayment = $this->settings->allowOnlineCheckout==1;
        $this->whatsappPayment = $this->settings->allowWhatsappCheckout==1;
        $this->whatsappSupport = $this->settings->whatsappSupport==1;
        $this->whatsappNumber = $this->settings->whatsappContact;
        $this->whatsappSupportNumber = $this->settings->whatsappSupportNumber;
        $this->escrowPayment = $this->settings->allowEscrowPayments==1;
        $this->defaultBuyText = $this->settings->defaultBuyText;
    }

    public function submit()
    {
        if ($this->staff->cannot('update UserStoreSetting')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to perform this action.',
                'width' => '400',
            ]);
            return;
        }

        $this->validate([
            'notifications' => 'boolean',
            'newsletter' => 'boolean',
            'signups' => 'boolean',
            'collectPhone' => 'boolean',
            'collectPayment' => 'boolean',
            'whatsappPayment' => 'boolean',
            'whatsappSupport' => 'boolean',
            'whatsappNumber' => 'nullable|string',
            'whatsappSupportNumber' => 'nullable|string',
            'escrowPayment' => 'boolean',
            'defaultBuyText' => 'nullable|string|max:255',
        ]);

        $this->settings->update([
            'allowWhatsappCheckout'=>($this->whatsappPayment)?1:2,
            'allowOnlineCheckout'=>($this->collectPayment)?1:2,
            'allowEscrowPayments'=>($this->escrowPayment)?1:2,
            'whatsappContact'=>$this->whatsappNumber,
            'allowNotifications'=>($this->notifications)?1:2,
            'allowNewLetters'=>($this->newsletter)?1:2,
            'allowSignups'=>($this->signups)?1:2,
            'collectPhone'=>($this->collectPhone)?1:2,
            'whatsappSupport'=>($this->whatsappSupport)?1:2,
            'whatsappSupportNumber'=>$this->whatsappSupportNumber,
            'defaultBuyText'=>$this->defaultBuyText
        ]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Store settings successfully updated.',
            'width' => '400',
        ]);
    }

    public function render()
    {
        return view('livewire.staff.users.components.merchant.store.settings');
    }
}
