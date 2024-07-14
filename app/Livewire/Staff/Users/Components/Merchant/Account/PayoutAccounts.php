<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Account;

use App\Models\User;
use App\Models\UserBank;
use Livewire\Component;
use Livewire\WithPagination;

class PayoutAccounts extends Component
{
    use WithPagination;
    public $userId;
    public $user;

    //mount it
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::where('reference',$this->userId)->first();
    }

    public function render()
    {
        return view('livewire.staff.users.components.merchant.account.payout-accounts',[
            'accounts'=>UserBank::where('user',$this->user->id)->paginate()
        ]);
    }
}
